<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Instructor extends Model
{
    // Definir la tabla si no sigue la convención plural
    protected $table = 'instructores';

    // Definir los campos que se pueden asignar masivamente
    protected $fillable = [
        'nombre',
        'apellidos',
        'perfil_profesional',
        'experiencia',
        'correo',
    ];
}
