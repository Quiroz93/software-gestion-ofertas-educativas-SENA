<?php

use App\Http\Controllers\CentroController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});



//Home

Route::get('/home', [HomeController::class,'index'])->name('home');




//Panel de Control
Route::get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');



//Rutas de gestión de permisos por medio de Resource Controller
Route::middleware(['auth', 'verified',])->prefix('admin')->group(function () {
    Route::resource('permissions', PermissionController::class);
});



Route::middleware('auth')->prefix('admin')->group(function () {
    Route::get('/roles', [RoleController::class, 'index'])->name('roles.index');
    Route::get('/roles/create', [RoleController::class, 'create'])->name('roles.create');
    Route::post('/roles', [RoleController::class, 'store'])->name('roles.store');
    Route::get('/roles/edit/{role}', [RoleController::class, 'edit'])->name('roles.edit');
    Route::patch('/roles/{role}', [RoleController::class, 'update'])->name('roles.update');
    Route::delete('/roles/{role}', [RoleController::class, 'destroy'])->name('roles.destroy');
});



//Rutas de perfil
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});




//Rutas de autenticación
require __DIR__ . '/auth.php';




//Rutas de centros educativos
Route::middleware(['auth', 'verified', 'can:view_centros'])->group(function () {
    Route::get('centros', [CentroController::class, 'index'])->name('centro.index');
});

Route::middleware(['auth', 'verified', 'can:create_centros'])->group(function () {
    Route::get('centros/create', [CentroController::class, 'create'])->name('centro.create');
    Route::post('centros', [CentroController::class, 'store'])->name('centro.store');
});

Route::middleware(['auth', 'verified', 'can:edit_centros'])->group(function () {
    Route::get('centros/edit/{id}', [CentroController::class, 'edit'])->name('centro.edit');
});
Route::middleware(['auth', 'verified', 'can:update_centros'])->group(function () {
    Route::put('centros/update/{id}', [CentroController::class, 'update'])->name('centro.update');
});

Route::middleware(['auth', 'verified', 'can:delete_centros'])->group(function () {
    Route::delete('centros/{id}/delete', [CentroController::class, 'destroy'])->name('centro.destroy');
});




//Rutas de gestión de usuarios
Route::middleware(['auth', 'verified', 'can:usuarios.ver'])->group(function () {
    Route::get('usuarios/{user}/roles', [UserController::class, 'editRoles'])->name('users.roles');
});

Route::middleware(['auth', 'verified', 'can:usuarios.crear'])->group(function () {
    Route::get('usuarios/create', [UserController::class, 'create'])->name('users.create');
});

Route::middleware(['auth', 'verified', 'can:usuarios.crear'])->group(function () {
    Route::post('usuarios', [UserController::class, 'store'])->name('users.store');
});

Route::middleware(['auth', 'verified', 'can:usuarios.editar'])->group(function () {
    Route::get('usuarios/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
});

Route::middleware(['auth', 'verified', 'can:usuarios.actualizar'])->group(function () {
    Route::put('usuarios/{user}', [UserController::class, 'update'])->name('users.update');
});

Route::middleware(['auth', 'verified', 'can:usuarios.eliminar'])->group(function () {
    Route::delete('usuarios/{user}', [UserController::class, 'destroy'])->name('users.destroy');
});

Route::middleware(['auth', 'verified', 'can:manage_users'])->group(function () {
    Route::get('usuarios/{user}/roles', [UserController::class, 'editRoles'])->name('users.roles');
});




//Rutas de gestión de permisos
Route::put(
    '/usuarios/{user}/permisos',
    [UserController::class, 'updatePermisos']
)->name('usuarios.updatepermisos');



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
