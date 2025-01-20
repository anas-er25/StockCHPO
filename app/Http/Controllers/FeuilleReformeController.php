<?php

namespace App\Http\Controllers;

use App\Models\FeuilleReforme;
use App\Models\Log;
use App\Models\Material;
use Barryvdh\DomPDF\Facade\Pdf;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FeuilleReformeController extends Controller
{
    public function reformelist()
    {
        $reformelist = FeuilleReforme::all();
        return view('pages.materiels.reformes.all', compact('reformelist'));
    }

    public function addreforme()
    {
        $materials = Material::WhereNotNull('service_id')->get();
        return view('pages.materiels.reformes.create', compact('materials'));
    }

    public function storereforme(Request $request)
    {
        $request->validate([
            'material_id' => 'required',
            'motif' => 'required',
            'qte' => 'required',
            'designation' => 'required'
        ]);

        $reforme = new FeuilleReforme();
        $reforme->material_id = $request->material_id;
        $reforme->motif = $request->motif;
        $reforme->date_reforme = now();
        $reforme->qte = $request->qte;
        $reforme->designation = $request->designation;
        $reforme->save();
        // Créer le log
        Log::create([
            'action' => 'create',
            'table_name' => 'feuille_reformes',
            'record_id' => $reforme->id,
            'performed_by' => Auth::user()->id,
            'performed_at' => now()
        ]);
        return redirect()->route('reforme.allreforme')->with('success', 'Reforme ajoutée avec succès');
    }

    public function reformeedit($id)
    {
        $reforme = FeuilleReforme::find($id);
        $materials = Material::all();
        return view('pages.materiels.reformes.edit', compact('reforme', 'materials'));
    }

    public function reformeupdate(Request $request, $id)
    {
        $request->validate([
            'material_id' => 'required',
            'motif' => 'required',
            'qte' => 'required',
            'designation' => 'required'
        ]);

        $reforme = FeuilleReforme::find($id);
        $reforme->material_id = $request->material_id;
        $reforme->motif = $request->motif;
        $reforme->date_reforme = now();
        $reforme->qte = $request->qte;
        $reforme->designation = $request->designation;
        $reforme->save();
        // Créer le log
        Log::create([
            'action' => 'update',
            'table_name' => 'feuille_reformes',
            'record_id' => $reforme->id,
            'performed_by' => Auth::user()->id,
            'performed_at' => now()
        ]);
        return redirect()->route('reforme.allreforme')->with('success', 'Reforme modifiée avec succès');
    }

    public function reformedelete($id)
    {
        $reforme = FeuilleReforme::find($id);
        $reforme->delete();
        // Créer le log
        Log::create([
            'action' => 'delete',
            'table_name' => 'feuille_reformes',
            'record_id' => $reforme->id,
            'performed_by' => Auth::user()->id,
            'performed_at' => now()
        ]);
        return redirect()->route('reforme.allreforme')->with('success', 'Reforme supprimée avec succès');
    }

    // Export
    public function reformePDF()
    {
        // Ensuite, vous passez la variable à la vue pour la génération du PDF
        $pdf = PDF::loadView('pages.pdfs.reformelist');
        // Créer le log
        Log::create([
            'action' => 'export',
            'table_name' => 'feuille_reformes',
            'record_id' => 0,
            'performed_by' => Auth::user()->id,
            'performed_at' => now()
        ]);

        return $pdf->download('FeuilleReforme.pdf');
    }
}