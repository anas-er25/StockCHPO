<?php

use App\Http\Controllers\AvisMvtController;
use App\Http\Controllers\BonDechargeController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FeuilleReformeController;
use App\Http\Controllers\MaterialController;
use App\Http\Controllers\MaterialHistoryController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RepareController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\SocieteController;
use App\Http\Controllers\SocieteMaterialController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('pages.home');
// });

Route::group(["middleware" => "auth"], function () {
    /* -------------------------------------------------------------------------- */
    /*                            Dashboard routes - START                        */
    /* -------------------------------------------------------------------------- */
    Route::group(['controller' => DashboardController::class], function () {
        Route::get('/', 'index');
        Route::get('/dashboard', 'index')->name('dashboard');
        Route::get('/dashboard/Movements', 'Movements')->name('dashboard.Movements');
        Route::get('/dashboard/chart-data', 'getChartData');
    });
    /* -------------------------------------------------------------------------- */
    /*                            Service routes - START                          */
    /* -------------------------------------------------------------------------- */
    Route::group(['controller' => ServiceController::class, 'as' => 'services.'], function () {
        Route::get('/services', 'index')->name('index');
        Route::get('/addservice', 'create')->name('create');
        Route::post('/addservice', 'store')->name('store');
        Route::get('/services/{id}/edit', 'edit')->name('edit');
        Route::put('/services/{id}', 'update')->name('update');
        Route::get('/services/{id}/show', 'show')->name('show');
        Route::get('/services/sub-services/{parentId}', 'getSubServices');
        Route::get('/services/parent-services', 'getParentServices');
        Route::delete('/services/{id}', 'destroy')->name('destroy');
    });

    /* -------------------------------------------------------------------------- */
    /*                            Societe routes - START                          */
    /* -------------------------------------------------------------------------- */
    Route::group(['controller' => SocieteController::class, 'as' => 'societies.'], function () {
        Route::get('/societies', 'index')->name('index');
        Route::get('/societies/{id}/edit', 'edit')->name('edit');
        Route::put('/societies/{id}', 'update')->name('update');
        Route::delete('/societies/{id}', 'destroy')->name('destroy');

        // Import
        Route::post('/societe/import', 'importSociete')->name('importExcel');

    });

    /* -------------------------------------------------------------------------- */
    /*                            Societe Materiels routes - START                          */
    /* -------------------------------------------------------------------------- */
    Route::group(['controller' => SocieteMaterialController::class, 'as' => 'societiesmaterial.'], function () {
        Route::get('/society/{id}/show', 'show')->name('show');
        Route::post('/society/{societyId}/material/{materialId}/update-pv-cps', 'updatePVCPS')
            ->name('societiesmaterial.updatePVCPS');
    });

    /* -------------------------------------------------------------------------- */
    /*                            Materiels routes - START                        */
    /* -------------------------------------------------------------------------- */
    Route::group(['controller' => MaterialController::class, 'as' => 'materiels.'], function () {
        // Materiel CRUD
        Route::get('/materiels', 'index')->name('index');
        Route::get('/stock', 'stock')->name('stock');
        Route::get('/addmateriel', 'create')->name('create');
        Route::post('/addmateriel', 'store')->name('store');
        Route::get('/materiels/{id}/edit', 'edit')->name('edit');
        Route::put('/materiels/{id}', 'update')->name('update');
        Route::get('/materiels/{id}', 'show')->name('show');
        Route::delete('/materiels/{id}', 'destroy')->name('destroy');
        Route::get('/get-services/{hopital_id}', 'getServices');
        Route::get('/get-sous-services/{service_id}', 'getSousServices');

        // Import
        Route::post('/materiels/import', 'importExcel')->name('importExcel');

        // Export
        Route::get('/materiels/export-pdf/{id}', 'exportPDF')->name('export_pdf');
        Route::get('/export-pdflist', 'export_pdflist')->name('exportpdflist');
        Route::get('/export-excel', 'exportexcel')->name('exportexcel');
    });

    /* -------------------------------------------------------------------------- */
    /*                            Bon de decharge routes - START                  */
    /* -------------------------------------------------------------------------- */
    Route::group(['controller' => BonDechargeController::class, 'as' => 'bondecharge.'], function () {

        Route::get('/materials/{id}', 'getMaterial')->name('getMaterial');

        // Bon de decharge
        Route::get('/bondecharge', 'bondecharge')->name('bondecharge');
        Route::post('/addbondecharge', 'storebondecharge')->name('storebondecharge');
        Route::get('/allbondecharge', 'allbondecharge')->name('allbondecharge');
        Route::get('/bondecharge/{id}/edit', 'bondechargeedit')->name('bondechargeedit');
        Route::put('/bondecharge/{id}', 'bondechargeupdate')->name('bondechargeupdate');
        Route::delete('/bondecharge/{id}', 'bondechargedestroy')->name('bondechargedestroy');

        // Export PDF
        Route::get('/bondechargePDF/export-pdf/{id}', 'bondechargePDF')->name('bondechargePDF');
        Route::get('/bondechargePDF/export-all', 'exportAllPDF')->name('exportAllPDF');
    });


    /* -------------------------------------------------------------------------- */
    /*                            Avis de mouvement routes - START                */
    /* -------------------------------------------------------------------------- */
    Route::group(['controller' => AvisMvtController::class, 'as' => 'avismvt.'], function () {
        // Avis de mouvement
        Route::get(
            '/materials/{id}',
            'getMaterial'
        )->name('getMaterial');
        Route::get('/allavismvt', 'allavismvt')->name('allavismvt');
        Route::get('/avismvt', 'avismvt')->name('avismvt');
        Route::post('/addavismvt', 'storeavismvt')->name('storeavismvt');
        Route::get('/avismvt/{id}/edit', 'avismvtedit')->name('avismvtedit');
        Route::put('/avismvt/{id}', 'avismvtupdate')->name('avismvtupdate');
        Route::delete('/avismvt/{id}', 'avismvtdestroy')->name('avismvtdestroy');
        // Export PDF
        Route::get('/avismvtPDF/export-pdf/{id}', 'avismvtPDF')->name('avismvtPDF');
        Route::get('/avismvtPDF/export-all', 'exportAllPDF')->name('exportAllPDF');
    });


    /* -------------------------------------------------------------------------- */
    /*                            Reforme routes - START                */
    /* -------------------------------------------------------------------------- */
    Route::group(['controller' => FeuilleReformeController::class, 'as' => 'reforme.'], function () {
        // Reforme
        Route::get('/allreforme', 'reformelist')->name('allreforme');
        Route::get('/reforme', 'addreforme')->name('addreforme');
        Route::post('/addreforme', 'storereforme')->name('storereforme');
        Route::get('/reforme/{id}/edit', 'reformeedit')->name('reformeedit');
        Route::put('/reforme/{id}', 'reformeupdate')->name('reformeupdate');
        Route::delete('/reforme/{id}', 'reformedelete')->name('reformedestroy');
        // Export PDF
        Route::post('/reforme/export-selected-pdf', 'exportSelectedPDF')->name('exportSelectedPDF');
        Route::get('/reformePDF/export-pdf', 'reformePDF')->name('reformePDF');
    });

    /* -------------------------------------------------------------------------- */
    /*                            Reparation routes - START                */
    /* -------------------------------------------------------------------------- */
    Route::group(['controller' => RepareController::class, 'as' => 'repare.'], function () {
        // Reforme
        Route::get('/allrepare', 'reparelist')->name('allrepare');
        Route::get('/repare', 'addrepare')->name('addrepare');
        Route::post('/addrepare', 'storerepare')->name('storerepare');
        Route::get('/repare/{id}/edit', 'repareedit')->name('repareedit');
        Route::put('/repare/{id}', 'repareupdate')->name('repareupdate');
        Route::delete('/repare/{id}', 'reparedelete')->name('reparedestroy');

        // Export PDF
        Route::post('/repare/export-selected-pdf', 'exportSelectedPDF')->name('exportSelectedPDF');
        Route::get('/reparePDF/export-pdf', 'reparePDF')->name('reparePDF');
    });


    /* -------------------------------------------------------------------------- */
    /*                            MouvementHistory routes - START                */
    /* -------------------------------------------------------------------------- */
    Route::group(['controller' => MaterialHistoryController::class, 'as' => 'material.'], function () {
        // MouvementHistory
        Route::get('/materialhistory',  'historyView')->name('historyview');
        Route::get('/material', 'history')->name('history');
    });
});

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/adduser', [ProfileController::class, 'adduser'])->name('profile.adduser');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::get('/users', [ProfileController::class, 'userlist'])->name('profile.userlist');
    Route::get('/profile/{id}', [ProfileController::class, 'edituser'])->name('profile.edituser');
    Route::post('/profile', [ProfileController::class, 'store'])->name('profile.store');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profileuser/{id}', [ProfileController::class, 'updateuser'])->name('profile.updateuser');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::delete('/profile/{id}', [ProfileController::class, 'destroyuser'])->name('profile.destroyuser');
    Route::post('/profile/{id}', [ProfileController::class, 'status'])->name('profile.status');
});

Route::fallback(function () {
    return view('erreur.404');
});
require __DIR__ . '/auth.php';