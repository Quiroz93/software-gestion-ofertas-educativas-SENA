<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Centro extends Model
{
    // Definir la tabla si no sigue la convención plural
    protected $table = 'centros';

    // Definir los campos que pueden ser asignados masivamente
    protected $fillable = [
        'nombre',
        'direccion',
        'telefono',
        'correo',
    ];
}
