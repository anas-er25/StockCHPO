<?php

namespace App\Http\Controllers;

use App\Models\Bon_Decharge;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use App\Models\Material;
use App\Models\Service;
use Illuminate\Http\Request;

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
            'date_affectation' => 'required',
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

        $material->save();

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
            'date_affectation' => 'required',
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

        $material->save();

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

        return redirect(route('materiels.index'))->with('success', 'Matériele supprimé avec succès.');
    }


    public function exportPDF($id)
    {
        // Fetch the specific material by ID
        // Fetch the specific material by ID
        $material = Material::findOrFail($id);

        // Create PDF content
        $pdf = Pdf::loadView('pages.pdfs.Bullteincession', compact('material'));

        // Optionally, you can pass data such as the current date to the view
        $pdf->setPaper('A4', 'portrait');

        // Sanitize the filename to remove invalid characters
        $filename = 'bulletin_de_cession_' . preg_replace('/[\/\\\\]/', '_', $material->num_inventaire) . '.pdf';

        // Return the generated PDF as a download
        return $pdf->download($filename);
    }

    // ===================================================================================================================================
    public function bondecharge()
    {
        $materiels = Material::all();
        $services = Service::all();

        return view('pages.materiels.bondecharge.bondecharge', ['materials' => $materiels, 'services' => $services]);
    }
    public function getMaterial($id)
    {
        $material = Material::with('service')->findOrFail($id);

        return response()->json($material);
    }


    public function storebondecharge(Request $request)
    {
        // dd($request->all());
        // Valider la requête
        $request->validate([
            'material_id' => 'required|exists:materials,id',
            'qte' => 'required',
            'num_serie' => 'required',
            'cedant_id' => 'required|exists:services,id',
            'cessionnaire' => 'required',
            'motif' => 'required',
        ]);

        // Créer une nouvelle instance de BonDecharge
        $bonDecharge = new Bon_Decharge();

        // Assigner les valeurs à l'instance du bon de décharge
        $bonDecharge->material_id = $request->material_id;
        $bonDecharge->qte = $request->qte;
        $bonDecharge->num_serie = $request->num_serie;
        $bonDecharge->cedant_id = $request->cedant_id;
        $bonDecharge->cessionnaire = $request->cessionnaire;
        $bonDecharge->motif = $request->motif;

        // Sauvegarder les données
        $bonDecharge->save();

        // Retourner à la page de bon de décharge avec un message de succès
        return redirect(route('materiels.allbondecharge'))->with('success', 'Bon de décharge créé avec succès.');
    }

    public function allbondecharge()
    {
        $bonDecharges = Bon_Decharge::all();
        return view('pages.materiels.bondecharge.allbondecharge', ['bonDecharges' => $bonDecharges]);
    }

    public function bondechargeedit($id)
    {
        $bondecharge = Bon_Decharge::find($id);
        $services = Service::all();
        $material = Material::all();
        return view('pages.materiels.bondecharge.bondechargeedit', ['bondecharge' => $bondecharge, 'services' => $services, 'material' => $material]);
    }

    public function bondechargeupdate(Request $request, $id)
    {
        // Valider la requête
        $request->validate([
            'material_id' => 'required|exists:materials,id',
            'qte' => 'required',
            'num_serie' => 'required',
            'cedant_id' => 'required|exists:services,id',
            'cessionnaire' => 'required',
            'motif' => 'required',
        ]);

        $bonDecharge = Bon_Decharge::find($id);

        // Assigner les valeurs à l'instance du bon de décharge
        $bonDecharge->material_id = $request->material_id;
        $bonDecharge->qte = $request->qte;
        $bonDecharge->num_serie = $request->num_serie;
        $bonDecharge->cedant_id = $request->cedant_id;
        $bonDecharge->cessionnaire = $request->cessionnaire;
        $bonDecharge->motif = $request->motif;

        // Sauvegarder les données
        $bonDecharge->save();

        // Retourner à la page de bon de décharge avec un message de succès
        return redirect(route('materiels.allbondecharge'))->with('success', 'Bon de décharge modifié avec succès.');
    }

    public function bondechargedestroy($id)
    {
        $bonDecharge = Bon_Decharge::find($id);
        $bonDecharge->delete();

        return redirect(route('materiels.allbondecharge'))->with('success', 'Bon de décharge supprimé avec succès.');
    }

    public function bondechargePDF($id)
    {
        $bondecharge = Bon_Decharge::findOrFail($id);

        // Ensuite, vous passez la variable à la vue pour la génération du PDF
        $pdf = PDF::loadView('pages.pdfs.Bondecharge', compact('bondecharge'));

        return $pdf->download('bon_decharge' . preg_replace('/[\/\\\\]/', '_', $bondecharge->materiel->num_inventaire) . '.pdf');
    }
}