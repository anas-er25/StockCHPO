<?php

namespace App\Http\Controllers;

use App\Models\Material;
use App\Models\Societe;
use App\Models\SocieteMaterial;
use Illuminate\Http\Request;

class SocieteMaterialController extends Controller
{
    public function index()
    {
        $societes = Societe::with('materials')->get();
        return view('pages.societe.index', compact('societes'));
    }

    public function show($id)
    {
        $societe = Societe::with(['materials', 'societeMaterials'])->findOrFail($id);
        return view('pages.societe.show', compact('societe'));
    }

    public function updatePVCPS(Request $request, $societyId)
    {
        $validated = $request->validate([
            'pv' => 'required|boolean',
            'cps' => 'required|boolean',
            'inventory_numbers' => 'required|array',
            'observation' => 'nullable|string'
        ]);

        // Mettre à jour tous les matériels associés aux numéros d'inventaire
        foreach ($request->inventory_numbers as $inventoryNumber) {
            // Trouver le matériel par son numéro d'inventaire
            $material = Material::where('num_inventaire', $inventoryNumber)->first();

            if ($material) {
                SocieteMaterial::where('societe_id', $societyId)
                    ->where('material_id', $material->id)
                    ->update([
                        'PV' => $validated['pv'],
                        'CPS' => $validated['cps'],
                        'observation' => $request->input('observation', null),
                    ]);
            }
        }

        return response()->json([
            'success' => true,
            'message' => 'Mise à jour réussie'
        ]);
    }
}