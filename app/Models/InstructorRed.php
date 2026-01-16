<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InstructorRed extends Model
{
    // Definir la tabla si no sigue la convención plural
    protected $table = 'instructor_redes';

    // Definir los campos que se pueden asignar masivamente
    protected $fillable = [
        'instructor_id',
        'redes_id',
    ];
}
