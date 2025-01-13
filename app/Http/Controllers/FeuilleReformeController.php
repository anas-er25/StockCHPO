<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade\Pdf;

use Illuminate\Http\Request;

class FeuilleReformeController extends Controller
{
    public function reformePDF()
    {
        // Ensuite, vous passez la variable à la vue pour la génération du PDF
        $pdf = PDF::loadView('pages.pdfs.reformelist');

        return $pdf->download('FeuilleReforme.pdf');
    }
}