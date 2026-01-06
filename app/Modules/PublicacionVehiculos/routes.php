<?php

use Illuminate\Support\Facades\Route;
use App\Modules\PublicacionVehiculos\Controllers\VehController;
use App\Modules\PublicacionVehiculos\Controllers\VehiculoDocumentosController;

Route::prefix('publi-vehiculo')->group(function () {
    Route::get('/publicacion-vehiculo', [VehController::class, 'index'])
        ->name('publicacion.vehiculo');
    
    Route::post('/publicacion-vehiculo', [VehController::class, 'store'])
        ->name('publicacion.vehiculo.store');

    Route::get('/marcas/{cod}/lineas', [VehController::class, 'lineasPorMarca'])
        ->name('marcas.lineas');
    Route::get('/docVeh', [VehController::class, 'vehiculo'])
        ->name('vehiculo-ver');
    Route::post('/vehiculos/documentos', [VehiculoDocumentosController::class, 'store'])
    ->name('vehiculo.documentos.store');
});
