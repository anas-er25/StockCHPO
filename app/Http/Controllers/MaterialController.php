<?php

namespace App\Http\Controllers;

use App\Models\Hopital;
use PhpOffice\PhpSpreadsheet\IOFactory;
use App\Models\Log;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Material;
use App\Models\MaterialHistory;
use App\Models\Service;
use App\Models\Societe;
use App\Models\SocieteMaterial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class MaterialController extends Controller
{

    public function index()
    {
        $materiels = Material::chunk(100, function ($materials) use (&$allMaterials) {
            foreach ($materials as $material) {
                $allMaterials[] = $material;
            }
        });
        $materiels = collect($allMaterials ?? []);
        return view('pages.materiels.index', ['materiels' => $materiels]);
    }

    public function create()
    {
        $hopitals = Hopital::all(); // Récupérer tous les hôpitaux
        $services = collect(); // Initialiser une collection vide pour les services
        $year = date('y');
        $latestMaterial = Material::where('num_inventaire', 'LIKE', "%/$year")
            ->orderByRaw('CAST(SUBSTRING_INDEX(num_inventaire, "/", 1) AS SIGNED) DESC')
            ->first();
        $startNumber = 1;
        if ($latestMaterial) {
            $parts = explode('/', $latestMaterial->num_inventaire);
            $startNumber = (int)$parts[0];
            $startNumber++;
        }
        $latestMaterial = $startNumber . "/$year";

        return view('pages.materiels.create', [
            'hopitals' => $hopitals,
            'services' => $services,
            'societes' => Societe::all(),
            'latestMaterial' => $latestMaterial,
        ]);
    }
    public function getServices($hopital_id)
    {
        $services = Service::where('hopital_id', $hopital_id)->get();
        return response()->json($services);
    }
    public function getSousServices($service_id)
    {
        $sousServices = Service::where('parent_id', $service_id)->get();
        return response()->json($sousServices);
    }

    public function store(Request $request)
    {
        // Validate the request...
        $request->validate([
            'num_inventaire' => 'required|unique:materials,num_inventaire',
            'designation' => 'required',
            'qte' => 'required|integer|min:1',
            'type' => 'required',
            'origin' => 'required',
            'marque' => 'required',
            'modele' => 'required',
            'num_serie' => 'required',
            'observation' => 'required',
            'etat' => 'required',
            'service_id' => 'nullable|exists:services,id',
            'sous_service_id' => 'nullable|exists:services,id',
            'date_inscription' => 'required|date',
            'societe_id' => 'required_without:nouvelle_societe|nullable|exists:societes,id',
            'nouvelle_societe' => 'required_without:societe_id|nullable|string|max:255',
            'numero_marche' => 'nullable|string|max:255',
            'numero_bl' => 'nullable|string|max:255',
            'pv' => 'nullable',
            'cps' => 'nullable',
            'observation_reserve' => 'nullable'

        ]);

        // Get latest inventory number
        $year = date('y');
        $latestMaterial = Material::where('num_inventaire', 'LIKE', "%/$year")
            ->orderByRaw('CAST(SUBSTRING_INDEX(num_inventaire, "/", 1) AS SIGNED) DESC')
            ->first();

        $startNumber = 1;
        if ($latestMaterial) {
            $parts = explode('/', $latestMaterial->num_inventaire);
            $startNumber = intval($parts[0]) + 1;
        }

        // Handle society
        if ($request->societe_id) {
            $societe = Societe::find($request->societe_id);
        } else {
            $societe = new Societe();
            $societe->nom_societe = $request->nouvelle_societe;
            $societe->save();
        }

        // Create materials based on quantity
        for ($i = 0; $i < $request->qte; $i++) {
            $material = new Material();
            $material->num_inventaire = ($startNumber + $i) . "/$year";
            $material->designation = $request->designation;
            $material->qte = 1;
            $material->type = $request->type;
            $material->origin = $request->origin;
            $material->marque = $request->marque;
            $material->modele = $request->modele;
            $material->num_serie = $request->num_serie;
            $material->date_inscription = $request->has('date_inscription') ? $request->date_inscription : now();
            $material->date_affectation = now();
            if ($request->service_id && $request->sous_service_id) {
                $material->service_id = $request->sous_service_id; // Assign service_id
            } else {
                $material->service_id = $request->service_id; // Assign sous_service_id if provided
            }
            $material->observation = $request->observation;
            $material->etat = $request->etat;
            $material->societe_id = $societe->id;

            if ($material->save()) {
                $toServiceId = null;

                if ($request->service_id && $request->sous_service_id) {
                    $toServiceId = $request->sous_service_id; // Si les deux sont fournis, utilisez sous_service_id
                } else {
                    $toServiceId = $request->service_id; // Sinon, utilisez service_id
                }
                // Ajouter l'enregistrement dans la table d'association societe_materials
                SocieteMaterial::create([
                    'societe_id' => $societe->id,
                    'material_id' => $material->id,
                    'numero_marche' => $request->numero_marche,
                    'numero_bl' => $request->numero_bl,
                    'PV' => $request->pv,
                    'CPS' => $request->cps,
                    'observation' => $request->observation_reserve
                ]);
                MaterialHistory::create([
                    'material_id' => $material->id,
                    'from_service_id' => null,
                    'to_service_id' => $toServiceId,
                    'moved_at' => now()
                ]);

                Log::create([
                    'action' => 'create',
                    'table_name' => 'materials',
                    'record_id' => $material->id,
                    'performed_by' => Auth::user()->id,
                    'performed_at' => now()
                ]);
            }
        }

        return redirect(route('materiels.index'))->with('success', 'Matériels créés avec succès.');
    }


    public function edit($id)
    {
        $material = Material::find($id);
        $hopitals = Hopital::all(); // Récupérer tous les hôpitaux
        $services = collect(); // Initialiser une collection vide pour les services
        $societes = Societe::all();
        return view('pages.materiels.edit', [
            'material' => $material,
            'hopitals' => $hopitals,
            'services' => $services,
            'societes' => $societes
        ]);
    }

    public function update(Request $request, $id)
    {
        // Validate the request...
        $request->validate([
            'designation' => 'required',
            'qte' => 'required',
            'type' => 'required',
            'origin' => 'required',
            'marque' => 'required',
            'modele' => 'required',
            'num_serie' => 'required',
            'observation' => 'required',
            'etat' => 'required',
        ]);

        $material = Material::find($id);

        $material->designation = $request->designation;
        $material->qte = 1;
        $material->type = $request->type;
        $material->origin = $request->origin;
        $material->marque = $request->marque;
        $material->modele = $request->modele;
        $material->num_serie = $request->num_serie;

        // Si 'date_inscription' est fourni, l'utiliser; sinon, utiliser la date actuelle
        $material->date_inscription = $request->has('date_inscription') ? $request->date_inscription : now();

        $material->date_affectation = now();
        if ($request->service_id && $request->sous_service_id) {
            $material->service_id = $request->sous_service_id; // Assign service_id
        } else {
            $material->service_id = $request->service_id; // Assign sous_service_id if provided
        }
        $material->observation = $request->observation;
        $material->etat = $request->etat;

        // Handle society creation or selection
        $societe = $request->societe_id
            ? Societe::findOrFail($request->societe_id)
            : Societe::create(['nom_societe' => $request->nouvelle_societe]);

        // Update society fields
        $societeMaterials = SocieteMaterial::updateOrCreate(
            [
                'societe_id' => $societe->id,
                'material_id' => $material->id,
            ],
            [
                'numero_marche' => $request->numero_marche,
                'numero_bl' => $request->numero_bl,
            ]
        );

        // Associate the material with the society
        $material->societe_id = $societe->id;

        if ($material->save()) {

            $toServiceId = null;

            if ($request->service_id && $request->sous_service_id) {
                $toServiceId = $request->sous_service_id; // Si les deux sont fournis, utilisez sous_service_id
            } else {
                $toServiceId = $request->service_id; // Sinon, utilisez service_id
            }
            // Modifier l'history de material dans la table materialHistory
            MaterialHistory::where('material_id', $material->id)->update([
                'from_service_id' => null,
                'to_service_id' => $toServiceId,
                'moved_at' => now()
            ]);

            // Créer le log
            Log::create([
                'action' => 'update',
                'table_name' => 'materials',
                'record_id' => $material->id,
                'performed_by' => Auth::user()->id,
                'performed_at' => now()
            ]);
        }

        return redirect(route('materiels.index'))->with('success', 'Matériele modifié avec succès.');
    }

    public function show($id)
    {
        $material = Material::find($id);
        return view('pages.materiels.show', ['material' => $material]);
    }


    public function destroy($id)
    {
        $material = Material::find($id);
        // Check authorization using Gate
        if (Gate::denies('delete', $material)) {
            abort(403, 'Action non autorisée.');
        }
        $material->delete();
        // Créer le log
        Log::create([
            'action' => 'delete',
            'table_name' => 'materials',
            'record_id' => $material->id,
            'performed_by' => Auth::user()->id,
            'performed_at' => now()
        ]);
        return redirect(route('materiels.index'))->with('success', 'Matériele supprimé avec succès.');
    }
    public function stock()
    {
        // Get the selected state and search term from the query parameters
        $selectedEtat = request('etat');
        $searchTerm = request('search');

        // Base query
        $query = Material::query();

        // Apply state filter if selected
        if ($selectedEtat) {
            $query->where('etat', $selectedEtat);
        } else {
            // Default behavior: show only materials without service
            $query->whereNull('service_id');
        }

        // Apply search filter if a search term is provided
        if ($searchTerm) {
            $query->where(function ($q) use ($searchTerm) {
                $q->where('num_inventaire', 'like', '%' . $searchTerm . '%')
                    ->orWhere('designation', 'like', '%' . $searchTerm . '%')
                    ->orWhere('marque', 'like', '%' . $searchTerm . '%')
                    ->orWhere('num_serie', 'like', '%' . $searchTerm . '%')
                    ->orWhere('modele', 'like', '%' . $searchTerm . '%')
                    ->orWhere('type', 'like', '%' . $searchTerm . '%')
                    ->orWhere('origin', 'like', '%' . $searchTerm . '%')
                    ->orWhere('etat', 'like', '%' . $searchTerm . '%')
                    ->orWhereHas('societeMaterials', function ($q) use ($searchTerm) {
                        $q->where('numero_marche', 'like', '%' . $searchTerm . '%');
                        $q->where('numero_bl', 'like', '%' . $searchTerm . '%');
                    });
            });
        }

        $materiels = $query->get();
        $sorties = Material::whereIn('etat', ['affecté', 'en mouvement'])->count();
        $entries = Material::where('etat', 'réceptionné')
            ->orWhere('etat', 'colis fermé')
            ->orWhereNull('service_id')
            ->count();
        $materialstotal = Material::all()->count();

        return view('pages.materiels.stock', [
            'materialstotal' => $materialstotal,
            'materiels' => $materiels,
            'sorties' => $sorties,
            'entries' => $entries,
            'selectedEtat' => $selectedEtat,
            'searchTerm' => $searchTerm
        ]);
    }

    // Export
    public function exportPDF($id)
    {

        // Fetch the specific material by ID
        $material = Material::findOrFail($id);

        // Create PDF content
        $pdf = Pdf::loadView('pages.pdfs.Bullteincession', compact('material'));

        // Optionally, you can pass data such as the current date to the view
        $pdf->setPaper('A4', 'portrait');

        // Sanitize the filename to remove invalid characters
        $filename = 'bulletin_de_cession_' . preg_replace('/[\/\\\\]/', '_', $material->num_inventaire) . '.pdf';
        // Créer le log
        Log::create([
            'action' => 'export',
            'table_name' => 'materials',
            'record_id' => $material->id,
            'performed_by' => Auth::user()->id,
            'performed_at' => now()
        ]);
        // Return the generated PDF as a download
        return $pdf->download($filename);
    }

    public function exportexcel()
    {
        try {
            $materials = Material::with('service')
                ->get()
                ->map(function ($material) {
                    return [
                        'N° d\'inventaire' => $material->num_inventaire,
                        'Date d\'inscription' => $material->date_inscription,
                        'Désignation de l\'objet' => $material->designation,
                        'Qté' => $material->qte,
                        'Marque' => $material->marque,
                        'Modèle' => $material->modele,
                        'Service' => $material->service_id ? $material->service->nom : 'Non affecté',
                        'Date d\'affectation' => $material->date_affectation,
                        'N° de série' => $material->num_serie,
                        'Observation' => $material->observation,
                        'N° de BL' => $material->societeMaterials->isNotEmpty() ? $material->societeMaterials->first()->numero_bl : null,
                        'Nom de société' => $material->societe ? $material->societe->nom_societe : null,
                        'N° de marché' => $material->societeMaterials->isNotEmpty() ? $material->societeMaterials->first()->numero_marche : null,
                        'Type' => $material->type,
                        'Origine' => $material->origin,
                        'Etat' => $material->etat,
                    ];
                });

            // Create log export excel
            Log::create([
                'action' => 'export',
                'table_name' => 'materials',
                'record_id' => 0,
                'performed_by' => Auth::user()->id,
                'performed_at' => now()
            ]);

            return response()->json($materials);
        } catch (\Exception $e) {
            Log::error('Export error: ' . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function importExcel(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls',
        ]);

        $file = $request->file('file');
        $spreadsheet = IOFactory::load($file);
        $sheet = $spreadsheet->getActiveSheet();
        $data = $sheet->toArray();

        $skipped = 0;
        $imported = 0;

        foreach ($data as $key => $row) {
            if ($key < 8) continue;

            if (empty($row) || empty($row[0])) continue;

            if (Material::where('num_inventaire', $row[0])->exists()) {
                $skipped++;
                continue;
            }

            $societe = null;
            if (!empty($row[11])) {
                $numero_bl = isset($row[10]) ? trim($row[10]) : '';
                $nom_societe = trim($row[11]);
                $numero_marche = isset($row[12]) ? trim($row[12]) : '';

                $societe = Societe::where(function ($query) use ($numero_bl, $nom_societe, $numero_marche) {
                    if (!empty($numero_marche)) {
                        $query->orWhere('nom_societe', $nom_societe); // Only search by nom_societe
                    }
                })->first();

                if (!$societe) {
                    $societe = Societe::create([
                        'nom_societe' => $nom_societe ?: 'Non spécifié',
                        // Remove numero_bl and numero_marche from here since they belong in societe_materials
                    ]);
                }
            }

            $cleanInventaire = $row[0];
            $formats = ['Y-m-d', 'm-d-Y', 'd-m-Y', 'm/d/Y'];
            $date = null;

            foreach ($formats as $format) {
                try {
                    $date = \Carbon\Carbon::createFromFormat($format, $row[7]);
                    break; // Stop once we find a valid date format
                } catch (\Exception $e) {
                    // Continue to try next format
                }
            }
            if (strpos($cleanInventaire, '-') !== false) {
                $inventaireNums = explode('-', $cleanInventaire);
                foreach ($inventaireNums as $num) {
                    if (Material::where('num_inventaire', trim($num))->exists()) {
                        $skipped++;
                        continue;
                    }


                    $newMaterial = new Material();
                    $newMaterial->num_inventaire = trim($num);
                    // For date_inscription (row[1])
                    $dateInscription = null;
                    if (!empty($row[1])) {
                        foreach ($formats as $format) {
                            try {
                                $dateInscription = \Carbon\Carbon::createFromFormat($format, $row[1]);
                                break; // Stop once a valid date format is found
                            } catch (\Exception $e) {
                                // Continue to try the next format
                            }
                        }
                    }
                    $newMaterial->date_inscription = $dateInscription ? $dateInscription->format('Y-m-d') : now();
                    $newMaterial->designation = $row[2];
                    $newMaterial->qte = 1;
                    $newMaterial->marque = $row[4];
                    $newMaterial->modele = $row[5];
                    $newMaterial->service_id = !empty($row[6]) ? (Service::where('nom', $row[6])->first()?->id ?? null) : null;
                    // For date_affectation (row[7])
                    $dateAffection = null;
                    if (!empty($row[7])) {
                        foreach ($formats as $format) {
                            try {
                                $dateAffection = \Carbon\Carbon::createFromFormat($format, $row[7]);
                                break; // Stop once a valid date format is found
                            } catch (\Exception $e) {
                                // Continue to try the next format
                            }
                        }
                    }
                    $newMaterial->date_affectation = $dateAffection ? $dateAffection->format('Y-m-d') : now();

                    $newMaterial->num_serie = $row[8];
                    $newMaterial->observation = $row[9];
                    // $newMaterial->numero_bl = $row[10];
                    $newMaterial->societe_id = $societe ? $societe->id : null;
                    // $newMaterial->numero_marche = $row[12];
                    $newMaterial->type = $row[13];
                    $newMaterial->origin = $row[14];
                    $newMaterial->etat = !empty($row[15]) ? $row[15] : null;

                    if ($newMaterial->save()) {
                        // Create the societe_materials record after material is saved
                        if ($societe) {
                            SocieteMaterial::create([
                                'societe_id' => $societe->id,
                                'material_id' => $newMaterial->id,
                                'numero_marche' => $numero_marche ?? null,
                                'numero_bl' => $numero_bl ?? null,
                            ]);
                        }
                        $imported++;
                        MaterialHistory::create([
                            'material_id' => $newMaterial->id,
                            'from_service_id' => null,
                            'to_service_id' => $newMaterial->service_id,
                            'moved_at' => now()
                        ]);
                    }
                }
                continue;
            }

            $material = new Material();
            $material->num_inventaire = $cleanInventaire;
            // For date_inscription (row[1])
            $dateInscription = null;
            if (!empty($row[1])) {
                foreach ($formats as $format) {
                    try {
                        $dateInscription = \Carbon\Carbon::createFromFormat($format, $row[1]);
                        break; // Stop once a valid date format is found
                    } catch (\Exception $e) {
                        // Continue to try the next format
                    }
                }
            }
            $material->date_inscription = $dateInscription ? $dateInscription->format('Y-m-d') : now();
            $material->designation = $row[2];
            $material->qte = 1;
            $material->marque = $row[4];
            $material->modele = $row[5];
            $material->service_id = !empty($row[6]) ? (Service::where('nom', $row[6])->first()?->id ?? null) : null;
            // For date_affectation (row[7])
            $dateAffection = null;
            if (!empty($row[7])) {
                foreach ($formats as $format) {
                    try {
                        $dateAffection = \Carbon\Carbon::createFromFormat($format, $row[7]);
                        break; // Stop once a valid date format is found
                    } catch (\Exception $e) {
                        // Continue to try the next format
                    }
                }
            }
            $material->date_affectation = $dateAffection ? $dateAffection->format('Y-m-d') : now();

            $material->num_serie = $row[8];
            $material->observation = $row[9];
            // $material->numero_bl = $row[10];
            $material->societe_id = $societe ? $societe->id : null;
            // $material->numero_marche = $row[12];
            $material->type = $row[13];
            $material->origin = $row[14];
            $material->etat = !empty($row[15]) ? $row[15] : null;

            if ($material->save()) {
                // Create the societe_materials record after material is saved
                if ($societe) {
                    SocieteMaterial::create([
                        'societe_id' => $societe->id,
                        'material_id' => $material->id,
                        'numero_marche' => $numero_marche ?? null,
                        'numero_bl' => $numero_bl ?? null,
                    ]);
                }
                $imported++;
                MaterialHistory::create([
                    'material_id' => $material->id,
                    'from_service_id' => null,
                    'to_service_id' => $material->service_id,
                    'moved_at' => now()
                ]);
            }
        }

        Log::create([
            'action' => 'import',
            'table_name' => 'materials',
            'record_id' => 0,
            'performed_by' => Auth::user()->id,
            'performed_at' => now()
        ]);

        return redirect(route('materiels.index'))
            ->with('success', "Import terminé. $imported produits importés, $skipped produits existants ignorés.");
    }
}