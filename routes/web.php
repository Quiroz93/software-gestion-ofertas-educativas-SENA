<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CentroController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserRoleController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\CompetenciaController;
use App\Http\Controllers\HistoriaExitoController;
use App\Http\Controllers\InstructorController;
use App\Http\Controllers\NivelFormacionController;
use App\Http\Controllers\OfertaController;
use App\Http\Controllers\ProgramaController;
use App\Http\Controllers\RedController;
use App\Http\Controllers\WelcomeController;

/*
|--------------------------------------------------------------------------
| Ruta de bienvenida
|--------------------------------------------------------------------------
*/
Route::get('/', [WelcomeController::class, 'index'])->name('welcome');

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


    Route::get('/home', [HomeController::class, 'index'])->name('home');

    Route::get('/dashboard', function () {
        return view('dashboard');
    })
    ->middleware('can:dashboard.view')
    ->name('dashboard');


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
| Roles (ADMIN)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'verified', 'can:roles.manage'])
    ->prefix('admin')
    ->group(function () {
        Route::resource('roles', RoleController::class);
    });

/*
|--------------------------------------------------------------------------
| Permisos (ADMIN)
|--------------------------------------------------------------------------
*/
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
Route::middleware(['auth', 'verified', 'can:users.assign.roles'])->group(function () {

    Route::get('users/{user}/roles', [UserRoleController::class, 'edit'])
        ->name('users.roles.assign');

    Route::put('users/{user}/roles', [UserRoleController::class, 'update'])
        ->name('users.roles.update');
});

/*
|--------------------------------------------------------------------------
| Permisos directos por usuario
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'verified', 'can:users.assign.roles'])->group(function () {

    Route::get('usuarios/{user}/permisos', [UserController::class, 'editPermissions'])
        ->name('users.permissions.edit');

    Route::put('usuarios/{user}/permisos', [UserController::class, 'updatePermissions'])
        ->name('users.permissions.update');
});

/*
|--------------------------------------------------------------------------
| Centros educativos
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'verified'])->group(function () {

    Route::get('centros', [CentroController::class, 'index'])
        ->middleware('can:centros.view')->name('centros.index');

    Route::get('centros/create', [CentroController::class, 'create'])
        ->middleware('can:centros.create')->name('centros.create');

    Route::post('centros', [CentroController::class, 'store'])
        ->middleware('can:centros.create')->name('centros.store');

    Route::get('centros/{centro}/edit', [CentroController::class, 'edit'])
        ->middleware('can:centros.edit')->name('centros.edit');

    Route::put('centros/{centro}', [CentroController::class, 'update'])
        ->middleware('can:centros.update')->name('centros.update');

    Route::delete('centros/{centro}', [CentroController::class, 'destroy'])
        ->middleware('can:centros.delete')->name('centros.destroy');
});

/*
|--------------------------------------------------------------------------
| Competencias
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {

    Route::get('competencias', [CompetenciaController::class, 'index'])
        ->middleware('can:competencias.view')->name('competencias.index');

    Route::get('competencias/create', [CompetenciaController::class, 'create'])
        ->middleware('can:competencias.create')->name('competencias.create');

    Route::post('competencias', [CompetenciaController::class, 'store'])
        ->middleware('can:competencias.create')->name('competencias.store');

    Route::get('competencias/{competencia}/edit', [CompetenciaController::class, 'edit'])
        ->middleware('can:competencias.edit')->name('competencias.edit');

    Route::put('competencias/{competencia}', [CompetenciaController::class, 'update'])
        ->middleware('can:competencias.update')->name('competencias.update');

    Route::delete('competencias/{competencia}', [CompetenciaController::class, 'destroy'])
        ->middleware('can:competencias.delete')->name('competencias.destroy');
});

/*
|--------------------------------------------------------------------------
| Historias de éxito
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {

    Route::resource('historias_de_exito', HistoriaExitoController::class)
        ->middleware([
            'index'   => 'can:historias_exito.view',
            'create'  => 'can:historias_exito.create',
            'store'   => 'can:historias_exito.create',
            'edit'    => 'can:historias_exito.edit',
            'update'  => 'can:historias_exito.update',
            'destroy' => 'can:historias_exito.delete',
        ]);
});

/*
|--------------------------------------------------------------------------
| Instructores
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {

    Route::resource('instructores', InstructorController::class)
        ->middleware([
            'index'   => 'can:instructores.view',
            'create'  => 'can:instructores.create',
            'store'   => 'can:instructores.create',
            'edit'    => 'can:instructores.edit',
            'update'  => 'can:instructores.update',
            'destroy' => 'can:instructores.delete',
        ]);
});

/*
|--------------------------------------------------------------------------
| Niveles de formación
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {

    Route::resource('niveles_formacion', NivelFormacionController::class)
        ->middleware([
            'index'   => 'can:niveles_formacion.view',
            'create'  => 'can:niveles_formacion.create',
            'store'   => 'can:niveles_formacion.create',
            'edit'    => 'can:niveles_formacion.edit',
            'update'  => 'can:niveles_formacion.update',
            'destroy' => 'can:niveles_formacion.delete',
        ]);
});

/*
|--------------------------------------------------------------------------
| Ofertas educativas
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {

    Route::resource('ofertas', OfertaController::class)
        ->middleware([
            'index'   => 'can:ofertas.view',
            'create'  => 'can:ofertas.create',
            'store'   => 'can:ofertas.create',
            'edit'    => 'can:ofertas.edit',
            'update'  => 'can:ofertas.update',
            'destroy' => 'can:ofertas.delete',
        ]);
});

/*
|--------------------------------------------------------------------------
| Programas de formación
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {

    Route::resource('programas', ProgramaController::class)
        ->middleware([
            'index'   => 'can:programas.view',
            'create'  => 'can:programas.create',
            'store'   => 'can:programas.create',
            'edit'    => 'can:programas.edit',
            'update'  => 'can:programas.update',
            'destroy' => 'can:programas.delete',
        ]);
});

/*
|--------------------------------------------------------------------------
| Redes de conocimiento
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {

    Route::resource('redes_conocimiento', RedController::class)
        ->middleware([
            'index'   => 'can:redes_conocimiento.view',
            'create'  => 'can:redes_conocimiento.create',
            'store'   => 'can:redes_conocimiento.create',
            'edit'    => 'can:redes_conocimiento.edit',
            'update'  => 'can:redes_conocimiento.update',
            'destroy' => 'can:redes_conocimiento.delete',
        ]);
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