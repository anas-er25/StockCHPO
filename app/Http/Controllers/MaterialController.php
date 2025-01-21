<?php

namespace App\Http\Controllers;

use PhpOffice\PhpSpreadsheet\IOFactory;
use App\Models\Log;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Material;
use App\Models\MaterialHistory;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MaterialController extends Controller
{

    public function index()
    {
        $materiels = Material::all();
        return view('pages.materiels.index', ['materiels' => $materiels]);
    }

    public function create()
    {
        $services = Service::all();
        return view('pages.materiels.create', ['services' => $services]);
    }

    public function store(Request $request)
    {
        // Validate the request...
        $request->validate([
            'num_inventaire' => 'required|unique:materials,num_inventaire',
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

        $material = new Material();

        $material->num_inventaire = $request->num_inventaire;
        $material->designation = $request->designation;
        $material->qte = $request->qte;
        $material->type = $request->type;
        $material->origin = $request->origin;
        $material->marque = $request->marque;
        $material->modele = $request->modele;
        $material->num_serie = $request->num_serie;

        // Si 'date_inscription' est fourni, l'utiliser; sinon, utiliser la date actuelle
        $material->date_inscription = $request->has('date_inscription') ? $request->date_inscription : now();

        $material->date_affectation = now();
        $material->service_id = $request->service_id;
        $material->observation = $request->observation;
        $material->etat = $request->etat;
        $material->numero_marche = $request->numero_marche; // Peut être NULL
        $material->numero_bl = $request->numero_bl; // Peut être NULL
        $material->nom_societe = $request->nom_societe; // Peut être NULL

        if ($material->save()) {
            // Sauvegarder l'history de material dans la table materialHistory
            MaterialHistory::create([
                'material_id' => $material->id,
                'from_service_id' => null,
                'to_service_id' => $material->service_id,
                'moved_at' => now()
            ]);

            // Créer le log
            Log::create([
                'action' => 'create',
                'table_name' => 'materials',
                'record_id' => $material->id,
                'performed_by' => Auth::user()->id,
                'performed_at' => now()
            ]);
        }
        return redirect(route('materiels.index'))->with('success', 'Matériele créé avec succès.');
    }


    public function edit($id)
    {
        $material = Material::find($id);
        $services = Service::all();
        return view('pages.materiels.edit', ['material' => $material, 'services' => $services]);
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
        $material->qte = $request->qte;
        $material->type = $request->type;
        $material->origin = $request->origin;
        $material->marque = $request->marque;
        $material->modele = $request->modele;
        $material->num_serie = $request->num_serie;

        // Si 'date_inscription' est fourni, l'utiliser; sinon, utiliser la date actuelle
        $material->date_inscription = $request->has('date_inscription') ? $request->date_inscription : now();

        $material->date_affectation = now();
        $material->service_id = $request->service_id;
        $material->observation = $request->observation;
        $material->etat = $request->etat;

        // Les champs 'numero_marche', 'numero_bl', et 'nom_societe' peuvent être NULL
        $material->numero_marche = $request->numero_marche;
        $material->numero_bl = $request->numero_bl;
        $material->nom_societe = $request->nom_societe;

        if ($material->save()) {

            // Modifier l'history de material dans la table materialHistory
            MaterialHistory::where('material_id', $material->id)->update([
                'from_service_id' => null,
                'to_service_id' => $material->service_id,
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

        $materiels = Material::whereNull('service_id')->where('etat', '!=', 'réformé')->get();
        $sorties = Material::whereIn('etat', ['affecté', 'en mouvement'])->count();
        $entries = Material::where('etat', 'réceptionné')
            ->orWhere('etat', 'colis fermé')
            ->orWhereNull('service_id')
            ->count();
        $materialstotal = Material::all()->count();
        return view('pages.materiels.stock', ['materialstotal' => $materialstotal, 'materiels' => $materiels, 'sorties' => $sorties, 'entries' => $entries]);
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
                        'Numéro d\'inventaire' => $material->num_inventaire,
                        'Date d\'inscription' => $material->date_inscription,
                        'Désignation de l\'objet' => $material->designation,
                        'Qté' => $material->qte,
                        'Marque' => $material->marque,
                        'Modèle' => $material->modele,
                        'Service' => $material->service_id ? $material->service->nom : 'Non affecté',
                        'Date d\'affectation' => $material->date_affectation,
                        'Série' => $material->num_serie,
                        'Observation' => $material->observation,
                        'Numéro BL' => $material->numero_bl,
                        'Nom société' => $material->nom_societe,
                        'Numéro de marché' => $material->numero_marche,
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
        // Validation du fichier
        $request->validate([
            'file' => 'required|mimes:xlsx,xls',
        ]);

        // Récupérer le fichier téléchargé
        $file = $request->file('file');

        // Charger le fichier Excel
        $spreadsheet = IOFactory::load($file);

        // Récupérer la première feuille du fichier
        $sheet = $spreadsheet->getActiveSheet();
        $data = $sheet->toArray();

        $skipped = 0;
        $imported = 0;

        // Parcourir les lignes de données et les insérer dans la base
        foreach ($data as $key => $row) {
            // Skip header rows (first 8 rows)
            if ($key < 8) continue;

            // Skip if row is empty or first column (N° d'inventaire) is empty
            if (empty($row) || empty($row[0])) continue;

            // Check if material already exists
            if (Material::where('num_inventaire', $row[0])->exists()) {
                $skipped++;
                continue;
            }

            // try {
            $material = new Material();
            // Nettoyer le numéro d'inventaire en enlevant les caractères spéciaux
            $cleanInventaire = preg_replace('[^0-9-]', '', $row[0]);
            $material->num_inventaire = $cleanInventaire;

            // Si le numéro d'inventaire contient un tiret, on le divise en deux
            if (strpos($cleanInventaire, '-') !== false) {
                $inventaireNums = explode('-', $cleanInventaire);
                foreach ($inventaireNums as $num) {
                    // Skip if the inventory number already exists
                    if (Material::where('num_inventaire', trim($num))->exists()) {
                        $skipped++;
                        continue;
                    }
                    $newMaterial = new Material();
                    $newMaterial->num_inventaire = trim($num);
                    // Copier toutes les autres propriétés du matériel original
                    $newMaterial->date_inscription = $material->date_inscription;
                    $newMaterial->designation = $material->designation;
                    $newMaterial->qte = $material->qte;
                    $newMaterial->marque = $material->marque;
                    $newMaterial->modele = $material->modele;
                    $newMaterial->service_id = $material->service_id;
                    $newMaterial->date_affectation = $material->date_affectation;
                    $newMaterial->num_serie = $material->num_serie;
                    $newMaterial->observation = $material->observation;
                    $newMaterial->numero_bl = $material->numero_bl;
                    $newMaterial->nom_societe = $material->nom_societe;
                    $newMaterial->numero_marche = $material->numero_marche;
                    $newMaterial->type = $material->type;
                    $newMaterial->origin = $material->origin;
                    $newMaterial->etat = $material->etat;

                    if ($newMaterial->save()) {
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
            try {
                $material->date_inscription = !empty($row[1]) ?
                    \Carbon\Carbon::createFromFormat('d/m/Y', $row[1])->format('Y-m-d') : (!empty($row[1]) ? \Carbon\Carbon::createFromFormat('m/d/Y', $row[1])->format('Y-m-d') : now());
            } catch (\Exception $e) {
                try {
                    $material->date_inscription = \Carbon\Carbon::createFromFormat('m/d/Y', $row[1])->format('Y-m-d');
                } catch (\Exception $e) {
                    $material->date_inscription = now();
                }
            }
            $material->designation = $row[2];
            $material->qte = $row[3];
            $material->marque = $row[4];
            $material->modele = $row[5];

            // Handle service assignment
            if (!empty($row[6])) {
                $service = Service::where('nom', $row[6])->first();
                $material->service_id = $service ? $service->id : null;
            }

            // $material->date_affectation = !empty($row[7]) ? \Carbon\Carbon::createFromFormat('d/m/Y', $row[7])->format('Y-m-d') : now();
            try {
                $material->date_affectation = !empty($row[1]) ?
                    \Carbon\Carbon::createFromFormat('d/m/Y', $row[7])->format('Y-m-d') : (!empty($row[7]) ? \Carbon\Carbon::createFromFormat('m/d/Y', $row[7])->format('Y-m-d') : now());
            } catch (\Exception $e) {
                try {
                    $material->date_affectation = \Carbon\Carbon::createFromFormat('m/d/Y', $row[7])->format('Y-m-d');
                } catch (\Exception $e) {
                    $material->date_affectation = now();
                }
            }
            $material->num_serie = $row[8];
            $material->observation = $row[9];
            $material->numero_bl = $row[10];
            $material->nom_societe = $row[11];
            $material->numero_marche = $row[12];
            $material->type = $row[13];
            $material->origin = $row[14];
            $material->etat = !empty($row[15]) ? $row[15] : null;

            if ($material->save()) {
                $imported++;
                // Create material history
                MaterialHistory::create([
                    'material_id' => $material->id,
                    'from_service_id' => null,
                    'to_service_id' => $material->service_id,
                    'moved_at' => now()
                ]);
            }
            // }
        }

        // Créer le log pour l'import
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
