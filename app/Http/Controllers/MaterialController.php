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

        $materiels = Material::whereNull('service_id')->get();
        $sorties = Material::whereIn('etat', ['affecté', 'en mouvement', 'réformé'])->count();
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
            // Ignorer l'entête (première ligne)
            if ($key == 0) continue;

            // Vérifier si le produit existe déjà
            if (Material::where('num_inventaire', $row[0])->exists()) {
                $skipped++;
                continue;
            }

            // Valider et insérer chaque ligne dans la base de données
            $material = new Material();
            $material->num_inventaire = $row[0];
            $material->date_inscription = $row[1];
            $material->designation = $row[2];
            $material->qte = $row[3];
            $material->marque = $row[4];
            $material->modele = $row[5];

            // Vérifier si row[6] est un nom de service
            if (!is_null($row[6])) {
                $service = Service::where('nom', $row[6])->first();
                if ($service) {
                    $material->service_id = $service->id;
                } else {
                    $material->service_id = null;
                }
            } else {
                $material->service_id = null;
            }

            $material->date_affectation = $row[7];
            $material->num_serie = $row[8];
            $material->observation = $row[9];
            $material->numero_bl = $row[10];
            $material->nom_societe = $row[11];
            $material->numero_marche = $row[12];
            $material->type = $row[13];
            $material->origin = $row[14];
            $material->etat = $row[15];

            $material->save();
            $imported++;
            // Pour chaque nouveau matériel importé, créer son historique
            MaterialHistory::create([
                'material_id' => $material->id,
                'from_service_id' => null,
                'to_service_id' => $material->service_id,
                'moved_at' => now()
            ]);
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