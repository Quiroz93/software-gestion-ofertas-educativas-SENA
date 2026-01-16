<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Oferta extends Model
{
    // Definir la tabla si no sigue la convención plural
    protected $table = 'ofertas';

    // Definir los campos que se pueden asignar masivamente
    protected $fillable = [
        'nombre',
        'año',
        'fecha_inicio',
        'fecha_fin',
        'estado',
        'centro_id',
    ];
}
