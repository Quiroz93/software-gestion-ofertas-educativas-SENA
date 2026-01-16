<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OfertaPrograma extends Model
{
    // Definir la tabla si no sigue la convención plural
    protected $table = 'oferta_programas';

    // Definir los campos que se pueden asignar masivamente
    protected $fillable = [
        'oferta_id',
        'programa_id',
    ];
}
