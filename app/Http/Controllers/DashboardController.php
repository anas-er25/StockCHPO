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
        $logs = Log::with('user')->get()->map(function ($log) {
            $record = $this->getRecordInfo($log->table_name, $log->record_id);
            return [
                'id' => $log->id,
                'action' => $log->action,
                'table_name' => $log->table_name,
                'record' => $record,
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

        // Matériels par type
        $materielstype = Material::select('type')
            ->groupBy('type')
            ->selectRaw('type, count(*) as count')
            ->get();
        // Matériels par type
        $materielsetat = Material::select('etat')
            ->groupBy('etat')
            ->selectRaw('etat, count(*) as count')
            ->get();

        return view('dashboard', compact('logs', 'recentMovements', 'materielstype', 'materielsetat'));
    }

    public function Movements()
    {
        $Movements = [
            'entries' => Material::whereIn('etat', ['réceptionné', 'colis fermé'])
                ->orderBy('date_inscription', 'desc')
                ->get(),
            'outputs' => Material::whereIn('etat', ['affecté', 'en mouvement', 'réformé'])
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