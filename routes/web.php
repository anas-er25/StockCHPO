<?php

use App\Http\Controllers\DashboardController;
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
    Route::group(['controller' => DashboardController::class], function () {
    });
    /* -------------------------------------------------------------------------- */
    /*                            Service routes - START                        */
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
        Route::get('/materiels', 'index')->name('index');
        Route::get('/addmateriel', 'create')->name('create');
        Route::post('/addmateriel', 'store')->name('store');
        Route::get('/materiels/{id}/edit', 'edit')->name('edit');
        Route::put('/materiels/{id}', 'update')->name('update');
        Route::delete('/materiels/{id}', 'destroy')->name('destroy');
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
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';