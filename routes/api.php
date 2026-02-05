<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\PreinscritoController;

// Rutas públicas (sin middleware de auth)
Route::get('/preinscritos', [PreinscritoController::class, 'index'])->name('api.preinscritos.index');

// Rutas que requieren autenticación
Route::middleware('auth')->group(function () {
    // Agregar aquí rutas que requieran auth
});
