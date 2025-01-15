<?php

namespace App\Http\Controllers;

use App\Models\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class DashboardController extends Controller
{
    public function index()
    {
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
        return view('dashboard', compact('logs'));
    }

    public function getRecordInfo($tableName, $recordId)
    {
        $modelClass = 'App\\Models\\' . ucfirst(Str::singular($tableName));
        // $modelClass = 'App\\Models\\' . ucfirst(str_singular($tableName));
        if (class_exists($modelClass)) {
            return $modelClass::find($recordId);
        }
        return null;
    }
}