<?php

use App\Modules\GestionUsuario\breeze\Controllers\ProfileController;
use App\Modules\PublicacionVehiculos\Controllers\vehPublicacion;
use Illuminate\Support\Facades\Route;



Route::get('/dashboard', [vehPublicacion::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});