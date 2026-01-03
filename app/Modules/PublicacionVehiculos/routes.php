<?php

use Illuminate\Support\Facades\Route;
use App\Modules\PublicacionVehiculos\Controllers\VehController;

Route::prefix('publi-vehiculo')->group(function () {
    Route::get('/publicacion-vehiculo', [VehController::class, 'index'])
        ->name('publicacion.vehiculo');
    
    Route::post('/publicacion-vehiculo', [VehController::class, 'store'])
        ->name('publicacion.vehiculo.store');

    Route::get('/marcas/{cod}/lineas', [VehController::class, 'lineasPorMarca'])
        ->name('marcas.lineas');
});
