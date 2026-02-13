<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Centro extends Model
{
    use HasFactory;
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
