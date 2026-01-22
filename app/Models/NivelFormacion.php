<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NivelFormacion extends Model
{
    // Definir la tabla si no sigue la convención plural
    protected $table = 'niveles_formacion';

    // Definir los campos que se pueden asignar masivamente
    protected $fillable = [
        'nombre',
        'descripcion',
    ];
}
