<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade\Pdf;

use App\Models\Bon_Decharge;
use App\Models\Log;
use App\Models\Material;
use App\Models\MaterialHistory;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class BonDechargeController extends Controller
{
    public function bondecharge()
    {
        $materiels = Material::WhereNotNull('service_id')->get();
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
            'type' => 'required'
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
        $bonDecharge->type = $request->type;

        // Sauvegarder les données
        if ($bonDecharge->save()) {
            // update on service_id on material table
            Material::where('id', $bonDecharge->material_id)->update([
                'service_id' => $bonDecharge->cessionnaire_id,
            ]);
            // Get material history id
            $last_to_service_id = MaterialHistory::where('material_id', $bonDecharge->material_id)
                ->latest()
                ->first();

            // Sauvegarder l'history de material dans la table materialHistory
            MaterialHistory::create([
                'material_id' => $bonDecharge->material_id,
                'from_service_id' => $last_to_service_id ? $last_to_service_id->to_service_id : null,
                'to_service_id' => $bonDecharge->cessionnaire_id,
                'moved_at' => now()
            ]);
            // Créer le log
            Log::create([
                'action' => 'create',
                'table_name' => 'bon_decharges',
                'record_id' => $bonDecharge->id,
                'performed_by' => Auth::user()->id,
                'performed_at' => now()
            ]);
        }


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
            'type' => 'required'
        ]);

        $bonDecharge = Bon_Decharge::find($id);

        // Assigner les valeurs à l'instance du bon de décharge
        $bonDecharge->material_id = $request->material_id;
        $bonDecharge->qte = $request->qte;
        $bonDecharge->num_serie = $request->num_serie;
        $bonDecharge->cedant_id = $request->cedant_id;
        $bonDecharge->cessionnaire = $request->cessionnaire;
        $bonDecharge->motif = $request->motif;
        $bonDecharge->type = $request->type;

        // Sauvegarder les données
        if ($bonDecharge->save()) {
            // update on service_id on material table
            Material::where('id', $bonDecharge->material_id)->update([
                'service_id' => $bonDecharge->cessionnaire_id,
            ]);
            // Trouver le dernier enregistrement pour le matériel donné
            $lastHistory = MaterialHistory::where('material_id', $bonDecharge->material_id)
                ->latest('moved_at')
                ->first();

            if ($lastHistory) {
                // Mettre à jour le dernier enregistrement
                $lastHistory->update([
                    'from_service_id' => $bonDecharge->cedant_id,
                    'to_service_id' => $bonDecharge->cessionnaire_id,
                    'moved_at' => now()
                ]);
            } else {
                // Si aucun enregistrement n'est trouvé, vous pouvez créer un nouvel enregistrement
                MaterialHistory::create([
                    'material_id' => $bonDecharge->material_id,
                    'from_service_id' => $bonDecharge->cedant_id,
                    'to_service_id' => $bonDecharge->cessionnaire_id,
                    'moved_at' => now()
                ]);
            }
            // Créer le log
            Log::create([
                'action' => 'update',
                'table_name' => 'bon_decharges',
                'record_id' => $bonDecharge->id,
                'performed_by' => Auth::user()->id,
                'performed_at' => now()
            ]);
        }


        // Retourner à la page de bon de décharge avec un message de succès
        return redirect(route('bondecharge.allbondecharge'))->with('success', 'Bon de décharge modifié avec succès.');
    }

    public function bondechargedestroy($id)
    {
        $bonDecharge = Bon_Decharge::find($id);
        // Check authorization using Gate
        if (Gate::denies('delete', $bonDecharge)) {
            abort(403, 'Action non autorisée.');
        }
        $bonDecharge->delete();
        // Créer le log
        Log::create([
            'action' => 'delete',
            'table_name' => 'bon_decharges',
            'record_id' => $bonDecharge->id,
            'performed_by' => Auth::user()->id,
            'performed_at' => now()
        ]);
        return redirect(route('bondecharge.allbondecharge'))->with('success', 'Bon de décharge supprimé avec succès.');
    }

    // Export
    public function bondechargePDF($id)
    {
        $bondecharge = Bon_Decharge::findOrFail($id);

        // Ensuite, vous passez la variable à la vue pour la génération du PDF
        $pdf = PDF::loadView('pages.pdfs.Bondecharge', compact('bondecharge'));
        // Créer le log
        Log::create([
            'action' => 'export',
            'table_name' => 'bon_decharges',
            'record_id' => $bondecharge->id,
            'performed_by' => Auth::user()->id,
            'performed_at' => now()
        ]);
        return $pdf->download('bon_decharge' . preg_replace('/[\/\\\\]/', '_', $bondecharge->materiel->num_inventaire) . '.pdf');
    }
    public function exportAllPDF()
    {
        $bondecharges = Bon_Decharge::all();

        $pdf = PDF::loadView('pages.pdfs.AllBondecharge', ['bondecharges' => $bondecharges]);

        Log::create([
            'action' => 'export',
            'table_name' => 'bon_decharges',
            'record_id' => 0,
            'performed_by' => Auth::user()->id,
            'performed_at' => now()
        ]);

        return $pdf->download('tous_bons_decharge.pdf');
    }
}