<?php

use App\Http\Controllers\Public\PublicCentroController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Public\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\CentroController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\UserRoleController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\CompetenciaController;
use App\Http\Controllers\Admin\HistoriaExitoController;
use App\Http\Controllers\Admin\InstructorController;
use App\Http\Controllers\Admin\NivelFormacionController;
use App\Http\Controllers\Admin\OfertaController;
use App\Http\Controllers\Admin\ProgramaController;
use App\Http\Controllers\Public\PublicCompetenciaController;
use App\Http\Controllers\Public\PublicHistoriaExitoController;
use App\Http\Controllers\Public\PublicInstructorController;
use App\Http\Controllers\Public\PublicNivelFormacionController;
use App\Http\Controllers\Public\PublicNoticiaController;
use App\Http\Controllers\Public\PublicOfertaController;
use App\Http\Controllers\Public\PublicRedController;
use App\Http\Controllers\Public\PublicProgramaController;
use App\Http\Controllers\Admin\RedController;
use App\Http\Controllers\Admin\HomeCarouselController;
use App\Http\Controllers\Admin\MunicipioController;
use App\Http\Controllers\Admin\PreinscritoController;
use App\Http\Controllers\Admin\ConsolidacionPreinscritoController;
use App\Http\Controllers\Admin\ReportesController;
use App\Http\Controllers\Public\WelcomeController;
use App\Http\Controllers\Public\CustomContentController;
use App\Http\Controllers\Public\MediaContentController;
use App\Http\Controllers\Admin\TipoNovedadController;
use App\Http\Controllers\Admin\NovedadPreinscritoController;
use App\Http\Controllers\Admin\ExportController;




/*|--------------------------------------------------------------------------
| Rutas para gestión de contenidos personalizados (PUBLIC CONTENT)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'can:public_content.edit'])
    ->post('/public-content', [CustomContentController::class, 'store'])
    ->name('public.content.store');

/*|--------------------------------------------------------------------------
| Rutas para gestión de archivos multimedia (MEDIA CONTENT)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'can:public_content.edit'])->group(function () {
    Route::get('/public/media/list', [MediaContentController::class, 'list'])
        ->name('public.media.list');
    
    Route::post('/public/media/upload', [MediaContentController::class, 'upload'])
        ->name('public.media.upload');
    
    Route::post('/public/media/store', [MediaContentController::class, 'store'])
        ->name('public.media.store');
    
    Route::delete('/public/media/delete', [MediaContentController::class, 'delete'])
        ->name('public.media.delete');
});

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

/*
|--------------------------------------------------------------------------
| Dashboard - ADMIN ONLY
|--------------------------------------------------------------------------
*/
Route::get('/dashboard', function () {
    return view('admin.dashboard');
})
    ->middleware(['auth', 'verified', 'role:admin|SuperAdmin'])
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
        ->name('users.roles.edit');

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

    Route::get('competencias/show', [CompetenciaController::class, 'show'])
        ->middleware('can:competencias.view')->name('competencias.show');

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

    Route::get('instructores/{instructor}/show', [InstructorController::class, 'show'])
        ->middleware('can:instructores.view')->name('instructores.show');

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

    // Mostrar detalles de un programa (administrativo)
    Route::get('programas/{programa}', [ProgramaController::class, 'show'])
        ->middleware('can:programas.view')->name('programas.show');

    Route::get('programas/{programa}/edit', [ProgramaController::class, 'edit']) 
        ->middleware('can:programas.edit')->name('programas.edit');

    Route::put('programas/{programa}', [ProgramaController::class, 'update'])
        ->middleware('can:programas.update')->name('programas.update');

    Route::delete('programas/{programa}', [ProgramaController::class, 'destroy'])
        ->middleware('can:programas.delete')->name('programas.destroy');
    
});

/*
|--------------------------------------------------------------------------
| Aprendices Preinscritos
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {
    Route::get('admin/preinscritos', [PreinscritoController::class, 'index'])
        ->middleware('can:preinscritos.view')->name('preinscritos.index');

    Route::get('admin/preinscritos/create', [PreinscritoController::class, 'create'])
        ->middleware('can:preinscritos.create')->name('preinscritos.create');

    Route::get('admin/preinscritos/reportes', [ReportesController::class, 'index'])
        ->middleware('can:preinscritos.export')->name('preinscritos.reportes');

    Route::get('admin/preinscritos/historial-exportaciones', [ReportesController::class, 'historial'])
        ->middleware('can:preinscritos.export')->name('preinscritos.historial-exportaciones');

    Route::post('admin/preinscritos', [PreinscritoController::class, 'store'])
        ->middleware('can:preinscritos.create')->name('preinscritos.store');

    Route::post('admin/preinscritos/exportar', [PreinscritoController::class, 'exportar'])->name('preinscritos.exportar');

    Route::post('admin/preinscritos/reportar', [ReportesController::class, 'reportar'])
        ->middleware('can:preinscritos.export')->name('preinscritos.reportar');

    Route::post('admin/preinscritos/generar-excel', [ReportesController::class, 'exportarExcel'])
        ->middleware('can:preinscritos.export')->name('preinscritos.generar-excel');

    Route::get('admin/preinscritos/reportes/imprimir', [ReportesController::class, 'imprimir'])
        ->middleware('can:preinscritos.export')->name('reportes.imprimir');

    Route::get('admin/preinscritos/exportaciones/{exportacion}/descargar', [ReportesController::class, 'descargar'])
        ->middleware('can:preinscritos.export')->name('preinscritos.exportaciones.descargar');

    Route::get('admin/preinscritos/{preinscrito}', [PreinscritoController::class, 'show'])
        ->middleware('can:preinscritos.view')->name('preinscritos.show');

    Route::get('admin/preinscritos/{preinscrito}/edit', [PreinscritoController::class, 'edit'])
        ->middleware('can:preinscritos.edit')->name('preinscritos.edit');

    Route::put('admin/preinscritos/{preinscrito}', [PreinscritoController::class, 'update'])
        ->middleware('can:preinscritos.edit')->name('preinscritos.update');

    Route::delete('admin/preinscritos/{preinscrito}', [PreinscritoController::class, 'destroy'])
        ->middleware('can:preinscritos.delete')->name('preinscritos.destroy');

    Route::post('admin/preinscritos/{preinscrito}/restore', [PreinscritoController::class, 'restore'])
        ->middleware('can:preinscritos.restore')->name('preinscritos.restore');

    // Consolidaciones de preinscritos
    Route::get('admin/preinscritos/consolidaciones', [ConsolidacionPreinscritoController::class, 'index'])
        ->name('preinscritos.consolidaciones.index');

    Route::get('admin/preinscritos/consolidaciones/importar', [ConsolidacionPreinscritoController::class, 'importForm'])
        ->name('preinscritos.consolidaciones.import');

    Route::post('admin/preinscritos/consolidaciones/importar', [ConsolidacionPreinscritoController::class, 'import'])
        ->name('preinscritos.consolidaciones.store');

    Route::get('admin/preinscritos/consolidaciones/{consolidacion}', [ConsolidacionPreinscritoController::class, 'show'])
        ->name('preinscritos.consolidaciones.show');

    Route::put('admin/preinscritos/consolidaciones/detalles/{detalle}', [ConsolidacionPreinscritoController::class, 'updateDetalle'])
        ->name('preinscritos.consolidaciones.detalles.update');

    Route::delete('admin/preinscritos/consolidaciones/{consolidacion}', [ConsolidacionPreinscritoController::class, 'destroy'])
        ->name('preinscritos.consolidaciones.destroy');
});

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
| Municipios
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {
    Route::get('municipios/index', [MunicipioController::class, 'index'])
        ->middleware('can:municipios.view')->name('municipios.index');

    Route::get('municipios/create', [MunicipioController::class, 'create'])
        ->middleware('can:municipios.create')->name('municipios.create');

    Route::post('municipios/store', [MunicipioController::class, 'store'])
        ->middleware('can:municipios.create')->name('municipios.store');

    Route::get('municipios/{municipio}', [MunicipioController::class, 'show'])
        ->middleware('can:municipios.view')->name('municipios.show');

    Route::get('municipios/{municipio}/edit', [MunicipioController::class, 'edit'])
        ->middleware('can:municipios.edit')->name('municipios.edit');

    Route::put('municipios/{municipio}', [MunicipioController::class, 'update'])
        ->middleware('can:municipios.update')->name('municipios.update');

    Route::delete('municipios/{municipio}', [MunicipioController::class, 'destroy'])
        ->middleware('can:municipios.delete')->name('municipios.destroy');
});

/*
|--------------------------------------------------------------------------
| Noticias (Administración)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {

    Route::get('noticias/index', [App\Http\Controllers\Admin\NoticiaController::class, 'index'])
        ->middleware('can:noticias.view')->name('noticias.index');

    Route::get('noticias/create', [App\Http\Controllers\Admin\NoticiaController::class, 'create'])
        ->middleware('can:noticias.create')->name('noticias.create');

    Route::post('noticias/store', [App\Http\Controllers\Admin\NoticiaController::class, 'store'])
        ->middleware('can:noticias.create')->name('noticias.store');

    Route::get('noticias/{noticia}', [App\Http\Controllers\Admin\NoticiaController::class, 'show'])
        ->middleware('can:noticias.view')->name('noticias.show');

    Route::get('noticias/{noticia}/edit', [App\Http\Controllers\Admin\NoticiaController::class, 'edit'])
        ->middleware('can:noticias.update')->name('noticias.edit');

    Route::put('noticias/{noticia}', [App\Http\Controllers\Admin\NoticiaController::class, 'update'])
        ->middleware('can:noticias.update')->name('noticias.update');

    Route::delete('noticias/{noticia}', [App\Http\Controllers\Admin\NoticiaController::class, 'destroy'])
        ->middleware('can:noticias.delete')->name('noticias.destroy');

    Route::post('noticias/{noticia}/toggle-active', [App\Http\Controllers\Admin\NoticiaController::class, 'toggleActive'])
        ->middleware('can:noticias.update')->name('noticias.toggle-active');
});

/*
|--------------------------------------------------------------------------
| Carousel del Home (Administración)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->prefix('admin')->name('admin.home-carousel.')->group(function () {
    
    Route::get('carousel', [HomeCarouselController::class, 'index'])
        ->name('index');
    
    Route::get('carousel/create', [HomeCarouselController::class, 'create'])
        ->name('create');
    
    Route::post('carousel', [HomeCarouselController::class, 'store'])
        ->name('store');
    
    Route::get('carousel/{homeCarousel}/edit', [HomeCarouselController::class, 'edit'])
        ->name('edit');
    
    Route::put('carousel/{homeCarousel}', [HomeCarouselController::class, 'update'])
        ->name('update');
    
    Route::delete('carousel/{homeCarousel}', [HomeCarouselController::class, 'destroy'])
        ->name('destroy');
    
    Route::patch('carousel/{homeCarousel}/toggle-active', [HomeCarouselController::class, 'toggleActive'])
        ->name('toggle-active');
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
    
    // Rutas de foto de perfil
    Route::put('/profile/photo', [ProfileController::class, 'photoUpdate'])
        ->name('profile.photo.update');
    Route::delete('/profile/photo', [ProfileController::class, 'photoDestroy'])
        ->name('profile.photo.destroy');
});

/*
|--------------------------------------------------------------------------
| Inscripciones a programas de formación
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {
    
    // Mostrar formulario de inscripción
    Route::get('programas/{programa}/inscribirse', [App\Http\Controllers\InscripcionController::class, 'create'])
        ->name('inscripcion.create');
    
    // Guardar inscripción
    Route::post('programas/{programa}/inscribir', [App\Http\Controllers\InscripcionController::class, 'store'])
        ->name('inscripcion.store');
    
    // Retirar inscripción
    Route::delete('inscripciones/{inscripcion}', [App\Http\Controllers\InscripcionController::class, 'destroy'])
        ->name('inscripcion.destroy');
    
    // Listar mis inscripciones
    Route::get('mis-inscripciones', [App\Http\Controllers\InscripcionController::class, 'misinscripciones'])
        ->name('inscripcion.index');
});


/*
|--------------------------------------------------------------------------
| Rutas públicas
|--------------------------------------------------------------------------
| Acceso libre – frontend institucional
| Middleware web mantiene sesión para usuarios autenticados opcionales
*/
Route::prefix('/')
    ->name('public.')
    ->middleware('web')
    ->group(function () {

        Route::get('/', function () {
            return view('public.welcome');
        })->name('home');

        // Centros
        Route::resource('centrosFormacion', PublicCentroController::class)
            ->only(['index', 'show']);

        // Competencias
        Route::resource('competenciasDeFormacion', PublicCompetenciaController::class)
            ->only(['index']);

        // Niveles de formación
        Route::resource('nivelFormaciones', PublicNivelFormacionController::class)
            ->only(['index']);

        // Noticias
        Route::resource('ultimaNoticias', PublicNoticiaController::class)
            ->only(['index', 'show']);

        // Redes
        Route::resource('redesDeConocimiento', PublicRedController::class)
            ->only(['index']);

        // Instructores
        Route::resource('instructoresDeFormacion', PublicInstructorController::class)
            ->only(['index', 'show']);

        // Programas
        Route::resource('programasDeFormacion', PublicProgramaController::class)
            ->only(['index', 'show']);

        // Ofertas educativas
        Route::resource('ofertasEducativas', PublicOfertaController::class)
            ->only(['index', 'show']);

        // Historias de éxito
        Route::resource('historiasDeExito', PublicHistoriaExitoController::class)
            ->only(['index', 'show']);
    });


/*|--------------------------------------------------------------------------
| Tipos de Novedad (Admin)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'verified', 'can:novedad.tipos.admin'])
    ->prefix('admin')
    ->group(function () {
        Route::resource('tipos-novedad', TipoNovedadController::class)
            ->names('tipos-novedad');
    });


/*|--------------------------------------------------------------------------
| Novedades de Preinscritos (Admin)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'verified', 'can:preinscritos.novedades.admin'])
    ->prefix('admin')
    ->group(function () {
        Route::resource('novedades', NovedadPreinscritoController::class)
            ->names('novedades');
        
        // Custom route for changing novedad estado
        Route::post('novedades/{novedad}/cambiar-estado', [NovedadPreinscritoController::class, 'cambiarEstado'])
            ->name('novedades.cambiar-estado');
        
        // Custom route for getting novedades by preinscrito
        Route::get('preinscritos/{preinscrito}/novedades', [NovedadPreinscritoController::class, 'porPreinscrito'])
            ->name('novedades.por-preinscrito');
    });
