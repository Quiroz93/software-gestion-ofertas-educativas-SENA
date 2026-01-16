<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProgramaCompetencia extends Model
{
    // Definir la tabla si no sigue la convención plural
    protected $table = 'programa_competencias';

    // Definir los campos que se pueden asignar masivamente
    protected $fillable = [
        'programa_id',
        'competencia_id',
    ];
}
