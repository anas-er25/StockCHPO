<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Avis_Mvt;
use App\Models\Material;
use App\Models\Service;
use Illuminate\Http\Request;

class AvisMvtController extends Controller
{
    public function allavismvt()
    {
        $avis = Avis_Mvt::all();

        return view('pages.materiels.avismvt.all', ['avis' => $avis]);
    }

    public function avismvt(){
        $materiels = Material::all();
        $services = Service::all();

        return view('pages.materiels.avismvt.avismvt', ['materials' => $materiels, 'services' => $services]);

    }

    public function getMaterial($id)
    {
        $material = Material::with('service')->findOrFail($id);

        return response()->json($material);
    }


    public function storeavismvt(Request $request)
    {
        // dd($request->all());
        // Valider la requête
        $request->validate([
            'material_id' => 'required|exists:materials,id',
            'qte' => 'required',
            'cedant_id' => 'required|exists:services,id',
            'cessionnaire_id' => 'required|exists:services,id',
            'motif' => 'required',
        ]);

        // Créer une nouvelle instance de avis_mvt
        $avismvt = new Avis_Mvt();

        // Assigner les valeurs à l'instance du Avis de mouvement
        $avismvt->material_id = $request->material_id;
        $avismvt->qte = $request->qte;
        $avismvt->cedant_id = $request->cedant_id;
        $avismvt->cessionnaire_id = $request->cessionnaire_id;
        $avismvt->motif = $request->motif;

        // Sauvegarder les données
        $avismvt->save();

        // Retourner à la page de Avis de mouvement avec un message de succès
        return redirect(route('avismvt.allavismvt'))->with('success', 'Avis de mouvement créé avec succès.');
    }


    public function avismvtedit($id)
    {
        $avismvt = Avis_Mvt::find($id);
        $services = Service::all();
        $material = Material::all();
        return view('pages.materiels.avismvt.avismvtedit', ['avismvt' => $avismvt, 'services' => $services, 'material' => $material]);
    }

    public function avismvtupdate(Request $request, $id)
    {
        // dd($request->all());
        // Valider la requête
        $request->validate([
            'material_id' => 'required|exists:materials,id',
            'qte' => 'required',
            'cedant_id' => 'required|exists:services,id',
            'cessionnaire_id' => 'required',
            'motif' => 'required',
        ]);

        $avismvt = Avis_Mvt::find($id);

        // Assigner les valeurs à l'instance du Avis de mouvement
        $avismvt->material_id = $request->material_id;
        $avismvt->qte = $request->qte;
        $avismvt->cedant_id = $request->cedant_id;
        $avismvt->cessionnaire_id = $request->cessionnaire_id;
        $avismvt->motif = $request->motif;

        // Sauvegarder les données
        $avismvt->save();

        // Retourner à la page de Avis de mouvement avec un message de succès
        return redirect(route('avismvt.allavismvt'))->with('success', 'Avis de mouvement modifié avec succès.');
    }

    public function avismvtdestroy($id)
    {
        $avismvt = Avis_Mvt::find($id);
        $avismvt->delete();

        return redirect(route('avismvt.allavismvt'))->with('success', 'Avis de mouvement supprimé avec succès.');
    }

    public function avismvtPDF($id)
    {
        $avismvt = Avis_Mvt::findOrFail($id);

        // Ensuite, vous passez la variable à la vue pour la génération du PDF
        $pdf = PDF::loadView('pages.pdfs.avismvt', compact('avismvt'));

        return $pdf->download('Avis_Mouvement' . preg_replace('/[\/\\\\]/', '_', $avismvt->materiel->num_inventaire) . '.pdf');
    }
}