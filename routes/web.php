<?php

use App\Http\Controllers\CentroController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

//Panel de Control
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

//Home
Route::get('/home', function () {
    return view('home');
})->middleware(['auth', 'verified'])->name('home');

//Rutas de perfil
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

//Rutas de autenticación
require __DIR__ . '/auth.php';

//Rutas de centros educativos
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('centros/index', [CentroController::class, 'index'])->name('centro.index');
    Route::get('centros/create', [CentroController::class, 'create'])->name('centro.create');
    Route::post('centros/store', [CentroController::class, 'store'])->name('centro.store');
    Route::get('centros/{id}/edit', [CentroController::class, 'edit'])->name('centro.edit');
    Route::put('centros/{id}/update', [CentroController::class, 'update'])->name('centro.update');
    Route::delete('centros/{id}/delete', [CentroController::class, 'destroy'])->name('centro.destroy');
});
