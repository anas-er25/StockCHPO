<?php

use App\Http\Controllers\AvisMvtController;
use App\Http\Controllers\BonDechargeController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FeuilleReformeController;
use App\Http\Controllers\MaterialController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ServiceController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('pages.home');
});

Route::group(["middleware" => "auth"], function () {
    /* -------------------------------------------------------------------------- */
    /*                            Dashboard routes - START                        */
    /* -------------------------------------------------------------------------- */
    Route::group(['controller' => DashboardController::class], function () {});
    /* -------------------------------------------------------------------------- */
    /*                            Service routes - START                          */
    /* -------------------------------------------------------------------------- */
    Route::group(['controller' => ServiceController::class, 'as' => 'services.'], function () {
        Route::get('/services', 'index')->name('index');
        Route::get('/addservice', 'create')->name('create');
        Route::post('/addservice', 'store')->name('store');
        Route::get('/services/{id}/edit', 'edit')->name('edit');
        Route::put('/services/{id}', 'update')->name('update');
        Route::delete('/services/{id}', 'destroy')->name('destroy');
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


        // Export PDF
        Route::get('/materiels/export-pdf/{id}', 'exportPDF')->name('export_pdf');
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
        Route::get('/reformePDF/export-pdf', 'reformePDF')->name('reformePDF');
    });


    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile', [ProfileController::class, 'store'])->name('profile.store');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';