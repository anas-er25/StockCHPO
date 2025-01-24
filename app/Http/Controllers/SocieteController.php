<?php

namespace App\Http\Controllers;

use App\Models\Log;
use App\Models\Societe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SocieteController extends Controller
{
    public function index()
    {
        $societies = Societe::all();
        return view('pages.societe.index', ['societies' => $societies]);
    }

    public function edit($id)
    {
        $societe = Societe::find($id);
        return view('pages.societe.edit', ['societe' => $societe]);
    }

    public function update(Request $request, $id)
    {
        // validate the form
        $request->validate([
            'nom_societe' => 'required',
            'telephone' => 'required',
        ]);

        // update the data
        $societe = Societe::find($id);
        $societe->nom_societe = $request->nom_societe;
        $societe->siege_social = $request->siege_social;
        $societe->telephone = $request->telephone;

        if ($societe->save()) {
            // create log
            Log::create([
                'action' => 'update',
                'table_name' => 'societies',
                'record_id' => $societe->id,
                'performed_by' => Auth::user()->id,
                'performed_at' => now()
            ]);
        }

        return redirect()->route('societies.index')->with('success', 'Société modifié avec succès.');
    }

    public function destroy($id)
    {
        $societe = Societe::find($id);
        if ($societe->delete()) {
            // create log
            Log::create([
                'action' => 'delete',
                'table_name' => 'societies',
                'record_id' => $societe->id,
                'performed_by' => Auth::user()->id,
                'performed_at' => now()
            ]);
        }

        return redirect()->route('societies.index')->with('success', 'Société supprimé avec succès.');
    }
}