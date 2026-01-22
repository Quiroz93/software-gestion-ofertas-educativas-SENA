<?php

use App\Http\Controllers\Public\PublicCentroController;
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
use App\Http\Controllers\Public\PublicCompetenciaController;
use App\Http\Controllers\Public\PublicHistoriaExitoController;
use App\Http\Controllers\Public\PublicInstructorController;
use App\Http\Controllers\Public\PublicNivelFormacionController;
use App\Http\Controllers\Public\PublicNoticiaController;
use App\Http\Controllers\Public\PublicOfertaController;
use App\Http\Controllers\Public\PublicRedController;
use App\Http\Controllers\PublicProgramaController;
use App\Http\Controllers\RedController;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\Public\CustomContentController;




/*|--------------------------------------------------------------------------
| Rutas para gestión de contenidos personalizados (PUBLIC CONTENT)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])
    ->post('/public-content', [CustomContentController::class, 'store'])
    ->name('public.content.store');


/*
|--------------------------------------------------------------------------
| Rutas para usuarios invitados
|--------------------------------------------------------------------------
*/

Route::middleware('guest')->group(function () {
    Route::get('/login', [WelcomeController::class, 'login'])->name('login');
    Route::get('/register', [WelcomeController::class, 'register'])->name('register');
});

/*
|--------------------------------------------------------------------------
| Ruta de bienvenida
|--------------------------------------------------------------------------
*/
Route::get('/SOE-SENA', [WelcomeController::class, 'index'])->name('welcome');

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

    Route::get('centros/index', [CentroController::class, 'index'])
        ->middleware('can:centros.view')->name('centros.index');

    Route::get('centros/create', [CentroController::class, 'create'])
        ->middleware('can:centros.create')->name('centros.create');

    Route::post('centros/store', [CentroController::class, 'store'])
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

    Route::get('competencias/index', [CompetenciaController::class, 'index'])
        ->middleware('can:competencias.view')->name('competencias.index');

    Route::get('competencias/create', [CompetenciaController::class, 'create'])
        ->middleware('can:competencias.create')->name('competencias.create');

    Route::post('competencias/store', [CompetenciaController::class, 'store'])
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

    Route::get('historias_de_exito/index', [HistoriaExitoController::class, 'index'])
        ->middleware('can:historias_de_exito.view')->name('historias_de_exito.index');

    Route::get('historias_de_exito/create', [HistoriaExitoController::class, 'create'])
        ->middleware('can:historias_de_exito.create')->name('historias_de_exito.create');

    Route::post('historias_de_exito/store', [HistoriaExitoController::class, 'store'])
        ->middleware('can:historias_de_exito.create')->name('historias_de_exito.store');

    Route::get('historias_de_exito/{historia}/edit', [HistoriaExitoController::class, 'edit'])
        ->middleware('can:historias_de_exito.edit')->name('historias_de_exito.edit');

    Route::put('historias_de_exito/{historia}', [HistoriaExitoController::class, 'update'])
        ->middleware('can:historias_de_exito.update')->name('historias_de_exito.update');

    Route::delete('historias_de_exito/{historia}', [HistoriaExitoController::class, 'destroy'])
        ->middleware('can:historias_de_exito.delete')->name('historias_de_exito.destroy');
});


/*
|--------------------------------------------------------------------------
| Instructores
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {

    Route::get('instructores/index', [InstructorController::class, 'index'])
        ->middleware('can:instructores.view')->name('instructores.index');

    Route::get('instructores/create', [InstructorController::class, 'create'])
        ->middleware('can:instructores.create')->name('instructores.create');

    Route::post('instructores/store', [InstructorController::class, 'store'])
        ->middleware('can:instructores.create')->name('instructores.store');

    Route::get('instructores/{instructor}/edit', [InstructorController::class, 'edit'])
        ->middleware('can:instructores.edit')->name('instructores.edit');

    Route::put('instructores/{instructor}', [InstructorController::class, 'update'])
        ->middleware('can:instructores.update')->name('instructores.update');

    Route::delete('instructores/{instructor}', [InstructorController::class, 'destroy'])
        ->middleware('can:instructores.delete')->name('instructores.destroy');
});



/*
|--------------------------------------------------------------------------
| Niveles de formación
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {
    Route::get('niveles_formacion/index', [NivelFormacionController::class, 'index'])
        ->middleware('can:niveles_formacion.view')->name('niveles_formacion.index');

    Route::get('niveles_formacion/create', [NivelFormacionController::class, 'create'])
        ->middleware('can:niveles_formacion.create')->name('niveles_formacion.create');

    Route::post('niveles_formacion/store', [NivelFormacionController::class, 'store'])
        ->middleware('can:niveles_formacion.create')->name('niveles_formacion.store');

    Route::get('niveles_formacion/{nivel}/edit', [NivelFormacionController::class, 'edit'])
        ->middleware('can:niveles_formacion.edit')->name('niveles_formacion.edit');

    Route::put('niveles_formacion/{nivel}', [NivelFormacionController::class, 'update'])
        ->middleware('can:niveles_formacion.update')->name('niveles_formacion.update');

    Route::delete('niveles_formacion/{nivel}', [NivelFormacionController::class, 'destroy'])
        ->middleware('can:niveles_formacion.delete')->name('niveles_formacion.destroy');
});

/*
|--------------------------------------------------------------------------
| Ofertas educativas
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {

    Route::get('ofertas/index', [OfertaController::class, 'index'])
        ->middleware('can:ofertas.view')->name('ofertas.index');

    Route::get('ofertas/create', [OfertaController::class, 'create'])
        ->middleware('can:ofertas.create')->name('ofertas.create');

    Route::post('ofertas/store', [OfertaController::class, 'store'])
        ->middleware('can:ofertas.create')->name('ofertas.store');

    Route::get('ofertas/{oferta}/edit', [OfertaController::class, 'edit'])
        ->middleware('can:ofertas.edit')->name('ofertas.edit');

    Route::put('ofertas/{oferta}', [OfertaController::class, 'update'])
        ->middleware('can:ofertas.update')->name('ofertas.update');

    Route::delete('ofertas/{oferta}', [OfertaController::class, 'destroy'])
        ->middleware('can:ofertas.delete')->name('ofertas.destroy');
});


/*
|--------------------------------------------------------------------------
| Programas de formación
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {
    Route::get('programas/index', [ProgramaController::class, 'index'])
        ->middleware('can:programas.view')->name('programas.index');

    Route::get('programas/create', [ProgramaController::class, 'create'])
        ->middleware('can:programas.create')->name('programas.create');

    Route::post('programas/store', [ProgramaController::class, 'store'])
        ->middleware('can:programas.create')->name('programas.store');

    Route::get('programas/{programa}/edit', [ProgramaController::class, 'edit'])
        ->middleware('can:programas.edit')->name('programas.edit');

    Route::put('programas/{programa}', [ProgramaController::class, 'update'])
        ->middleware('can:programas.update')->name('programas.update');

    Route::delete('programas/{programa}', [ProgramaController::class, 'destroy'])
        ->middleware('can:programas.delete')->name('programas.destroy');
    
});

/*|--------------------------------------------------------------------------
| Programas de formación - vista pública
|--------------------------------------------------------------------------
*/
Route::get('/oferta-educativa', [PublicProgramaController::class, 'index'])
    ->name('public.programas.index');

Route::get('/oferta-educativa/{programa}', [PublicProgramaController::class, 'show'])
    ->name('public.programas.show');


/*
|--------------------------------------------------------------------------
| Redes de conocimiento
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {

    Route::get('redes_conocimiento/index', [RedController::class, 'index'])
        ->middleware('can:redes_conocimiento.view')->name('redes_conocimiento.index');

    Route::get('redes_conocimiento/create', [RedController::class, 'create'])
        ->middleware('can:redes_conocimiento.create')->name('redes_conocimiento.create');

    Route::post('redes_conocimiento/store', [RedController::class, 'store'])
        ->middleware('can:redes_conocimiento.create')->name('redes_conocimiento.store');

    Route::get('redes_conocimiento/{red}/edit', [RedController::class, 'edit'])
        ->middleware('can:redes_conocimiento.edit')->name('redes_conocimiento.edit');

    Route::put('redes_conocimiento/{red}', [RedController::class, 'update'])
        ->middleware('can:redes_conocimiento.update')->name('redes_conocimiento.update');

    Route::delete('redes_conocimiento/{red}', [RedController::class, 'destroy'])
        ->middleware('can:redes_conocimiento.delete')->name('redes_conocimiento.destroy');
});

/*
|--------------------------------------------------------------------------
| Noticias (Administración)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {

    Route::get('noticias/index', [App\Http\Controllers\NoticiaController::class, 'index'])
        ->middleware('can:noticias.view')->name('noticias.index');

    Route::get('noticias/create', [App\Http\Controllers\NoticiaController::class, 'create'])
        ->middleware('can:noticias.create')->name('noticias.create');

    Route::post('noticias/store', [App\Http\Controllers\NoticiaController::class, 'store'])
        ->middleware('can:noticias.create')->name('noticias.store');

    Route::get('noticias/{noticia}', [App\Http\Controllers\NoticiaController::class, 'show'])
        ->middleware('can:noticias.view')->name('noticias.show');

    Route::get('noticias/{noticia}/edit', [App\Http\Controllers\NoticiaController::class, 'edit'])
        ->middleware('can:noticias.update')->name('noticias.edit');

    Route::put('noticias/{noticia}', [App\Http\Controllers\NoticiaController::class, 'update'])
        ->middleware('can:noticias.update')->name('noticias.update');

    Route::delete('noticias/{noticia}', [App\Http\Controllers\NoticiaController::class, 'destroy'])
        ->middleware('can:noticias.delete')->name('noticias.destroy');
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
| Rutas públicas
|--------------------------------------------------------------------------
| Acceso libre – frontend institucional
*/
Route::prefix('/')
    ->name('public.')
    ->group(function () {

        Route::get('/', function () {
            return view('welcome');
        })->name('home');

        // Centros
        Route::resource('centros', PublicCentroController::class)
            ->only(['index', 'show']);

        // Competencias
        Route::resource('competencias', PublicCompetenciaController::class)
            ->only(['index']);

        // Niveles de formación
        Route::resource('nivel-formaciones', PublicNivelFormacionController::class)
            ->only(['index']);

        // Noticias
        Route::resource('noticias', PublicNoticiaController::class)
            ->only(['index', 'show']);

        // Redes
        Route::resource('redes', PublicRedController::class)
            ->only(['index']);

        // Instructores
        Route::resource('instructores', PublicInstructorController::class)
            ->only(['index', 'show']);

        // Programas
        Route::resource('programas', PublicProgramaController::class)
            ->only(['index', 'show']);

        // Ofertas educativas
        Route::resource('ofertas', PublicOfertaController::class)
            ->only(['index', 'show']);

        // Historias de éxito
        Route::resource('historias-exito', PublicHistoriaExitoController::class)
            ->only(['index', 'show']);
    });

