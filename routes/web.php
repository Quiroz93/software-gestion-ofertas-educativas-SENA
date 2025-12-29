<?php

use App\Http\Controllers\CentroController;
use App\Http\Controllers\CompetenciaController;
use Illuminate\Support\Facades\Route;

//Rutas para la gestion de centros

// funcion de vista principal
Route::get('/', function () {return view('welcome');});

// ruta para ver todos los centros
Route::get('centros', [CentroController::class, 'index'])
    ->name('centro.index');

// ruta para ver el formulario de creacion de centros
Route::get('create', [CentroController::class,'create'])
    ->name('centro.create');

// ruta para guardar un nuevo centro
Route::post('centros', [CentroController::class, 'store'])
    ->name('centro.store');

// ruta para ver un centro en particular
Route::get('centros/{centro}', [CentroController::class, 'show'])
    ->name('centro.show');

// ruta para ver el formulario de edicion de un centro
Route::get('centros/{centro}/edit', [CentroController::class, 'edit'])
    ->name('centro.edit');

// ruta para actualizar un centro
Route::put('centros/{centro}', [CentroController::class, 'update'])
    ->name('centro.update');

// ruta para eliminar un centro
Route::delete('centros/{centro}', [CentroController::class, 'destroy'])
    ->name('centro.destroy');

//__________________________________________________________________________________________

    //rutas para la gestion de competencias

    // ruta para ver todas las competencias
Route::get('competencias', [CompetenciaController::class, 'index'])
    ->name('competencia.index');

    // ruta para ver el formulario de creacion de competencias
Route::get('competencias/create', [CompetenciaController::class,'create'])
    ->name('competencia.create');

    // ruta para guardar una nueva competencia
Route::post('competencias', [CompetenciaController::class, 'store'])
    ->name('competencia.store');

    // ruta para ver una competencia en particular
Route::get('competencias/{competencia}', [CompetenciaController::class, 'show'])
    ->name('competencia.show');

    // ruta para ver el formulario de edicion de una competencia
Route::get('competencias/{competencia}/edit', [CompetenciaController::class, 'edit'])
    ->name('competencia.edit');

    // ruta para actualizar una competencia
Route::put('competencias/{competencia}', [CompetenciaController::class, 'update'])
    ->name('competencia.update');

    // ruta para eliminar una competencia
Route::delete('competencias/{competencia}', [CompetenciaController::class, 'destroy'])
    ->name('competencia.destroy');

//__________________________________________________________________________________________

//Rutas para la gestion de programas

// ruta para ver todos los programas
//Route::get('programas', [ProgramaController::class, 'index'])->name('programas.index');