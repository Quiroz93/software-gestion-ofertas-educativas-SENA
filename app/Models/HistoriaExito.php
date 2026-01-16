<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HistoriaExito extends Model
{
    // Definir la tabla si no sigue la convención plural
    protected $table = 'historias_de_exitos';

    // Definir los campos que se pueden asignar masivamente
    protected $fillable = [
        'nombre',
        'titulo',
        'descripcion',
        'año',
        'correo',
        'programa_id',
        'imagen',
    ];
}
