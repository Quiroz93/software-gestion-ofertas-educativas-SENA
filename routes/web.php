<?php

use App\Http\Controllers\CentroController;
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
