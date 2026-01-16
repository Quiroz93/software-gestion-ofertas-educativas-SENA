<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Red extends Model
{
    // Definir la tabla si no sigue la convención plural
    protected $table = 'redes';

    // Definir los campos que se pueden asignar masivamente
    protected $fillable = [
        'nombre',
        'descripcion',
    ];
}
