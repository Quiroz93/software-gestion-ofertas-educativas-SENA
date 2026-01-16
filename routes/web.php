<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CentroController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserRoleController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\PermissionController;

/*
|--------------------------------------------------------------------------
| Ruta de bienvenida
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return view('welcome');
});

/*
|--------------------------------------------------------------------------
| Autenticación
|--------------------------------------------------------------------------
*/
require __DIR__ . '/auth.php';

/*
|--------------------------------------------------------------------------
| Home & Dashboard
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');

    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

/*
|--------------------------------------------------------------------------
| Panel de administrador
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'verified', 'can:admin.dashboard'])->group(function () {
    Route::get('/admin/dashboard', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');
});

/*
|--------------------------------------------------------------------------
| Gestión de usuarios (ADMIN)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'verified', 'can:users.manage'])
    ->prefix('admin')
    ->group(function () {

        Route::resource('users', UserController::class);
    });

/*
|--------------------------------------------------------------------------
| Roles y permisos (ADMIN)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'verified', 'can:roles.manage'])
    ->prefix('admin')
    ->group(function () {

        Route::resource('roles', RoleController::class);
    });

Route::middleware(['auth', 'verified', 'can:permissions.manage'])
    ->prefix('admin')
    ->group(function () {

        Route::resource('permissions', PermissionController::class);
    });

/*
|--------------------------------------------------------------------------
| Asignación de roles a usuarios
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'verified', 'can:users.roles.edit'])->group(function () {

    Route::get('users/{user}/roles', [UserRoleController::class, 'edit'])
        ->name('users.roles.assign');

    Route::put('users/{user}/roles', [UserRoleController::class, 'update'])
        ->name('users.roles.update.assigned');
});


/*
|--------------------------------------------------------------------------
| Gestión de usuarios (ESPAÑOL - vistas operativas)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'verified', 'can:users.view'])->group(function () {
    Route::get('usuarios', [UserController::class, 'index'])->name('users.index');
    Route::get('usuarios/{user}', [UserController::class, 'show'])->name('users.show');
});

Route::middleware(['auth', 'verified', 'can:users.create'])->group(function () {
    Route::get('usuarios/create', [UserController::class, 'create'])->name('users.create');
    Route::post('usuarios', [UserController::class, 'store'])->name('users.store');
});

Route::middleware(['auth', 'verified', 'can:users.edit'])->group(function () {
    Route::get('usuarios/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::put('usuarios/{user}', [UserController::class, 'update'])->name('users.update');
});

Route::middleware(['auth', 'verified', 'can:users.delete'])->group(function () {
    Route::delete('usuarios/{user}', [UserController::class, 'destroy'])->name('users.destroy');
});

/*
|--------------------------------------------------------------------------
| Permisos directos por usuario
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'verified', 'can:users.roles.edit'])->group(function () {

    Route::get('usuarios/{user}/permisos', [UserController::class, 'editPermissions'])
        ->name('users.permisos');

    Route::put('usuarios/{user}/permisos', [UserController::class, 'updatePermissions'])
        ->name('users.updatepermisos');
});

/*
|--------------------------------------------------------------------------
| Centros educativos
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'verified', 'can:centros.view'])->group(function () {
    Route::get('centros', [CentroController::class, 'index'])->name('centro.index');
});

Route::middleware(['auth', 'verified', 'can:centros.create'])->group(function () {
    Route::get('centros/create', [CentroController::class, 'create'])->name('centro.create');
    Route::post('centros', [CentroController::class, 'store'])->name('centro.store');
});

Route::middleware(['auth', 'verified', 'can:centros.edit'])->group(function () {
    Route::get('centros/edit/{id}', [CentroController::class, 'edit'])->name('centro.edit');
});

Route::middleware(['auth', 'verified', 'can:centros.update'])->group(function () {
    Route::put('centros/update/{id}', [CentroController::class, 'update'])->name('centro.update');
});

Route::middleware(['auth', 'verified', 'can:centros.delete'])->group(function () {
    Route::delete('centros/{centro}/delete', [CentroController::class, 'destroy'])->name('centro.destroy');
});

/*
|--------------------------------------------------------------------------
| Perfil de usuario
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
/*
|--------------------------------------------------------------------------
| Gestión de roles y permisos por usuario
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'can:users.edit'])->group(function () {

    Route::get('users/{user}/roles-permissions',
        [UserController::class, 'editRolesPermissions']
    )->name('users.roles.edit');

    Route::put('users/{user}/roles-permissions',
        [UserController::class, 'updateRolesPermissions']
    )->name('users.roles.update');

});

/*
|--------------------------------------------------------------------------
| Competencias
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'can:competencias.view'])->group(function () {
    Route::get('competencias', [CompetenciaController::class, 'index'])
        ->name('competencias.index');
});

/*
|--------------------------------------------------------------------------
| Historias de éxito
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'can:historias.view'])->group(function () {
    Route::get('historias', [HistoriaController::class, 'index'])
        ->name('historias.index');
});

/*
|--------------------------------------------------------------------------
| Instructores
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'can:instructores.view'])->group(function () {
    Route::get('instructores', [InstructorController::class, 'index'])
        ->name('instructores.index');
});

/*
|--------------------------------------------------------------------------
| Niveles de formación
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'can:niveles_formacion.view'])->group(function () {
    Route::get('niveles-formacion', [NivelFormacionController::class, 'index'])
        ->name('niveles_formacion.index');
});

/*
|--------------------------------------------------------------------------
| Ofertas educativas
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'can:ofertas.view'])->group(function () {
    Route::get('ofertas', [OfertaController::class, 'index'])
        ->name('ofertas.index');
});

/*
|--------------------------------------------------------------------------
| Programas de formación
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'can:programas.view'])->group(function () {
    Route::get('programas', [ProgramaController::class, 'index'])
        ->name('programas.index');
});

/*
|--------------------------------------------------------------------------
| Redes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'can:redes.view'])->group(function () {
    Route::get('redes', [RedController::class, 'index'])
        ->name('redes.index');
});

