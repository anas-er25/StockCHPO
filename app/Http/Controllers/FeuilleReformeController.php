<?php

namespace App\Http\Controllers;

use App\Models\Log;
use Barryvdh\DomPDF\Facade\Pdf;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FeuilleReformeController extends Controller
{
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