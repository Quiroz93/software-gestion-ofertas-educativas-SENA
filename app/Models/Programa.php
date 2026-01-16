<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Programa extends Model
{
    // Definir la tabla si no sigue la convención plural
    protected $table = 'programas';

    // Definir los campos que se pueden asignar masivamente
    protected $fillable = [
        'nombre',
        'descripcion',
        'requisitos',
        'duracion_meses',
        'red_id',
        'nivel_formacion_id',
    ];
}
