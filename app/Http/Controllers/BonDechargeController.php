<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade\Pdf;

use App\Models\Bon_Decharge;
use App\Models\Log;
use App\Models\Material;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BonDechargeController extends Controller
{
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
        // Créer le log
        Log::create([
            'action' => 'create',
            'table_name' => 'bon__decharges',
            'record_id' => $bonDecharge->id,
            'performed_by' => Auth::user()->id,
            'performed_at' => now()
        ]);

        // Retourner à la page de bon de décharge avec un message de succès
        return redirect(route('bondecharge.allbondecharge'))->with('success', 'Bon de décharge créé avec succès.');
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
        // Créer le log
        Log::create([
            'action' => 'update',
            'table_name' => 'bon__decharges',
            'record_id' => $bonDecharge->id,
            'performed_by' => Auth::user()->id,
            'performed_at' => now()
        ]);

        // Retourner à la page de bon de décharge avec un message de succès
        return redirect(route('bondecharge.allbondecharge'))->with('success', 'Bon de décharge modifié avec succès.');
    }

    public function bondechargedestroy($id)
    {
        $bonDecharge = Bon_Decharge::find($id);
        $bonDecharge->delete();
        // Créer le log
        Log::create([
            'action' => 'delete',
            'table_name' => 'bon__decharges',
            'record_id' => $bonDecharge->id,
            'performed_by' => Auth::user()->id,
            'performed_at' => now()
        ]);
        return redirect(route('bondecharge.allbondecharge'))->with('success', 'Bon de décharge supprimé avec succès.');
    }

    public function bondechargePDF($id)
    {
        $bondecharge = Bon_Decharge::findOrFail($id);

        // Ensuite, vous passez la variable à la vue pour la génération du PDF
        $pdf = PDF::loadView('pages.pdfs.Bondecharge', compact('bondecharge'));
        // Créer le log
        Log::create([
            'action' => 'export',
            'table_name' => 'bon__decharges',
            'record_id' => $bondecharge->id,
            'performed_by' => Auth::user()->id,
            'performed_at' => now()
        ]);
        return $pdf->download('bon_decharge' . preg_replace('/[\/\\\\]/', '_', $bondecharge->materiel->num_inventaire) . '.pdf');
    }
}