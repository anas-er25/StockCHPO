<?php

namespace App\Http\Controllers;

use App\Models\Log;
use App\Models\Material;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class DashboardController extends Controller
{
    public function index()
    {
        // Logs existants
        $logs = Log::with('user')
            ->orderBy('performed_at', 'DESC')
            ->get()
            ->map(function ($log) {
                $record = $this->getRecordInfo($log->table_name, $log->record_id);
                return [
                    'id' => $log->id,
                    'action' => $log->action,
                    'table_name' => $log->table_name,
                    'record' => $record,
                    'record_id' => $log->record_id,
                    'numero_inventaire' => $record ? $record->num_inventaire : null,
                    'user' => $log->user->name,
                    'performed_at' => $log->performed_at,
                ];
            });

        // Derniers mouvements de stock
        $recentMovements = [
            'entries' => Material::whereIn('etat', ['réceptionné', 'colis fermé'])
                ->orderBy('date_inscription', 'desc')
                ->take(4)
                ->get(),
            'outputs' => Material::whereIn('etat', ['affecté', 'en mouvement', 'réformé'])
                ->orderBy('date_affectation', 'desc')
                ->take(4)
                ->get()
        ];

        // Matériels par type pour l'année en cours
        $materielstype = Material::select('type')
            ->whereYear('date_inscription', date('Y'))
            ->groupBy('type')
            ->selectRaw('type, count(*) as count')
            ->get();

        // Matériels par Etat pour l'année en cours
        $materielsetat = Material::select('etat')
            ->whereYear('date_inscription', date('Y'))
            ->groupBy('etat')
            ->selectRaw('etat, count(*) as count')
            ->get();

        return view('dashboard', compact('logs', 'recentMovements', 'materielstype', 'materielsetat'));
    }

    public function getChartData(Request $request)
    {
        $month = $request->input('month');
        $year = $request->input('year', date('Y'));

        $materielsetat = Material::select('etat')
            ->whereMonth('date_inscription', $month)
            ->whereYear('date_inscription', $year)
            ->groupBy('etat')
            ->selectRaw('etat, count(*) as count')
            ->get();

        $labelsetat = $materielsetat->pluck('etat')->toArray();
        $seriesetat = $materielsetat->pluck('count')->map(function ($value) {
            return (int)$value;
        })->toArray();

        // Provide default data if empty
        if (empty($labelsetat)) {
            $labelsetat = ['Aucune donnée'];
            $seriesetat = [0];
        }

        return response()->json([
            'labels' => $labelsetat,
            'series' => $seriesetat,
        ]);
    }

    public function Movements()
    {
        $Movements = [
            'entries' => Material::whereIn('etat', ['réceptionné', 'colis fermé'])
                ->orderBy('date_inscription', 'desc')
                ->get(),
            'outputs' => Material::whereIn('etat', ['affecté', 'en mouvement'])
                ->orderBy('date_affectation', 'desc')
                ->get()
        ];

        return view('movements', compact('Movements'));
    }

    public function getRecordInfo($tableName, $recordId)
    {
        $modelClass = 'App\\Models\\' . ucfirst(Str::singular($tableName));
        if (class_exists($modelClass)) {
            return $modelClass::find($recordId);
        }
        return null;
    }
}