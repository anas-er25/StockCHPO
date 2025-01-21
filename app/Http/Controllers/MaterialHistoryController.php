<?php

namespace App\Http\Controllers;

use App\Models\Material;
use App\Models\MaterialHistory;
use Illuminate\Http\Request;

class MaterialHistoryController extends Controller
{
    public function historyView(){
        return view('material_history');
    }

    public function history(Request $request)
    {
        // Récupérer le numéro d'inventaire depuis la requête AJAX
        $inventoryNumber = $request->input('inventory_number');

        // Initialiser les variables
        $history = collect();
        $material = null;

        // Si un numéro d'inventaire est fourni, rechercher l'historique
        if ($inventoryNumber) {
            // Extraire le numéro d'inventaire sans l'année
            $inventoryNumberWithoutYear = preg_replace('/\/\d+$/', '', $inventoryNumber);

            // Trouver le matériel correspondant au numéro d'inventaire
            $material = Material::where('num_inventaire', 'LIKE', $inventoryNumberWithoutYear . '%')->first();

            if ($material) {
            // Récupérer l'historique des mouvements pour ce matériel
            $history = MaterialHistory::with(['fromService', 'toService'])
                ->where('material_id', $material->id)
                ->orderBy('moved_at', 'asc')
                ->get();
            }
        }

        // Retourner les résultats au format JSON
        return response()->json([
            'inventoryNumber' => $inventoryNumber,
            'material' => $material,
            'history' => $history,
        ]);
    }
}
