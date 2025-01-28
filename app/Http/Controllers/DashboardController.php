<?php

namespace App\Http\Controllers;

use App\Models\Log;
use App\Models\Material;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        // Get filter parameters
        $timeFilter = $request->get('time_filter', 'all');
        $startDate = $request->get('start_date');
        $endDate = $request->get('end_date');

        $query = Log::with('user')->orderBy('performed_at', 'DESC');

        // Apply filters
        if ($timeFilter === 'custom' && $startDate && $endDate) {
            $query->whereBetween('performed_at', [
                $startDate . ' 00:00:00',
                $endDate . ' 23:59:59'
            ]);
        } else {
            switch ($timeFilter) {
                    // ...existing time filter cases...
                case 'day':
                    $query->whereDate('performed_at', date('Y-m-d'));
                    break;
                case 'week':
                    $query->whereBetween('performed_at', [
                        date('Y-m-d', strtotime('monday this week')) . ' 00:00:00',
                        date('Y-m-d', strtotime('sunday this week')) . ' 23:59:59'
                    ]);
                    break;
                case 'month':
                    $query->whereMonth('performed_at', date('m'));
                    break;

            }
        }
        // Get filtered logs
        $logs = $query->get()->map(function ($log) {
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
            'entries' => Material::whereIn('etat', ['provisoire', 'définitive', 'colis fermé'])
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

        return view('dashboard', compact('logs', 'recentMovements', 'materielstype', 'materielsetat', 'timeFilter','startDate', 'endDate'));
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
            'entries' => Material::whereIn('etat', ['provisoire', 'définitive', 'colis fermé'])
                ->orderBy('date_inscription', 'desc')
                ->get(),
            'outputs' => Material::whereIn('etat', ['affecté','en mouvement', 'réformé'])
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