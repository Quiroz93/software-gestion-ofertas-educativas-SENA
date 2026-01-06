<?php

use App\Http\Controllers\CentroController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
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
Route::middleware(['auth', 'verified', 'can:centros.view'])->group(function () {
    Route::get('centros', [CentroController::class, 'index'])->name('centro.index');
});

Route::middleware(['auth', 'verified', 'can:centros.create'])->group(function () {
    Route::get('centros/create', [CentroController::class, 'create'])->name('centro.create');
    Route::post('centros', [CentroController::class, 'store'])->name('centro.store');
});

Route::middleware(['auth', 'verified', 'can:centros.update'])->group(function () {
    Route::get('centros/{id}/edit', [CentroController::class, 'edit'])->name('centro.edit');
    Route::put('centros/{id}/update', [CentroController::class, 'update'])->name('centro.update');
});

Route::middleware(['auth', 'verified', 'can:centros.delete'])->group(function () {
    Route::delete('centros/{id}/delete', [CentroController::class, 'destroy'])->name('centro.destroy');
});

//Rutas de gestión de usuarios
Route::middleware(['auth', 'verified', 'can:manage_users'])->group(function () {
    Route::get('usuarios', [UserController::class, 'index'])->name('users.index');
    Route::get('usuarios/{user}/permisos', [UserController::class, 'editPermissions'])->name('users.permisos');
    Route::put('usuarios/{user}/permisos', [UserController::class, 'updatePermissions'])->name('users.updatepermisos');
});

//Ruta de panel de administrador
Route::middleware(['auth', 'verified', 'can:access_admin_dashboard'])->group(function () {
    Route::get('/admin/dashboard', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');
});