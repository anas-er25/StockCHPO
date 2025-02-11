<?php

namespace App\Http\Controllers;

use App\Models\Repare;
use App\Models\Log;
use App\Models\Material;
use App\Models\MaterialHistory;
use App\Models\Service;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Gate;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RepareController extends Controller
{
    public function reparelist()
    {
        $reparelist = Repare::all();
        return view('pages.materiels.repares.all', compact('reparelist'));
    }

    public function addrepare()
    {
        $services= Service::all();
        $materials = Material::WhereNotNull('service_id')->get();
        return view('pages.materiels.repares.create', compact('materials', 'services'));
    }

    public function storerepare(Request $request)
    {
        $request->validate([
            'material_id' => 'required',
            'motif' => 'required',
            'qte' => 'required',
            'designation' => 'required',
            'cedant_id' => 'required'
        ]);

        $repare = new Repare();
        $repare->material_id = $request->material_id;
        $repare->motif = $request->motif;
        $repare->date_reparation = now();
        $repare->qte = $request->qte;
        $repare->service_id = $request->cedant_id;
        $repare->designation = $request->designation;
        if ($repare->save()) {
            // Changer le service_id du matériel
            Material::where('id', $request->material_id)->update([
                'service_id' => null,
                'etat' => 'réparé'
            ]);
            // Trouver le dernier enregistrement pour le matériel donné
            $lastHistory = MaterialHistory::where('material_id', $repare->material_id)
                ->latest('moved_at')
                ->first();

            MaterialHistory::create([
                'material_id' => $repare->material_id,
                'from_service_id' => $lastHistory->to_service_id,
                'to_service_id' => $repare->cessionnaire_id,
                'moved_at' => now()
            ]);

            // Créer le log
            Log::create([
                'action' => 'create',
                'table_name' => 'repares',
                'record_id' => $repare->id,
                'performed_by' => Auth::user()->id,
                'performed_at' => now()
            ]);
        }
        return redirect()->route('repare.allrepare')->with('success', 'Matériel ajoutée avec succès');
    }

    public function repareedit($id)
    {
        $repare = Repare::find($id);
        $materials = Material::all();
        $services = Service::all();
        return view('pages.materiels.repares.edit', compact('repare', 'materials', 'services'));
    }

    public function repareupdate(Request $request, $id)
    {
        $request->validate([
            'material_id' => 'required',
            'motif' => 'required',
            'qte' => 'required',
            'designation' => 'required',
            'cedant_id' => 'required'
        ]);

        $repare = Repare::find($id);
        $repare->material_id = $request->material_id;
        $repare->motif = $request->motif;
        $repare->date_reparation = now();
        $repare->qte = $request->qte;
        $repare->service_id = $request->cedant_id;
        $repare->designation = $request->designation;
        if ($repare->save()) {
            // Créer le log
            Log::create([
                'action' => 'update',
                'table_name' => 'feuille_repares',
                'record_id' => $repare->id,
                'performed_by' => Auth::user()->id,
                'performed_at' => now()
            ]);
        }
        return redirect()->route('repare.allrepare')->with('success', 'Matériel modifiée avec succès');
    }

    public function reparedelete($id)
    {

        $repare = Repare::find($id);

        // Check authorization using Gate
        if (Gate::denies('delete', $repare)) {
            abort(403, 'Action non autorisée.');
        }
        if ($repare->delete()) {
            // Créer le log
            Log::create([
                'action' => 'delete',
                'table_name' => 'feuille_repares',
                'record_id' => $repare->id,
                'performed_by' => Auth::user()->id,
                'performed_at' => now()
            ]);
        }
        return redirect()->route('repare.allrepare')->with('success', 'Matériel supprimée avec succès');
    }

    // Export
    public function exportSelectedPDF(Request $request)
    {
        $selectedIds = json_decode($request->input('selected_ids'));
        $materiels = Repare::whereIn('id', $selectedIds)->get();

        $pdf = PDF::loadView('pages.pdfs.export-pdfrep', compact('materiels'));
        return $pdf->download('materiels_repares.pdf');
    }

    public function reparePDF()
    {
        // Ensuite, vous passez la variable à la vue pour la génération du PDF
        $pdf = PDF::loadView('pages.pdfs.reparationlist');
        // Créer le log
        Log::create([
            'action' => 'export',
            'table_name' => 'repares',
            'record_id' => 0,
            'performed_by' => Auth::user()->id,
            'performed_at' => now()
        ]);

        return $pdf->download('Réparation.pdf');
    }
}