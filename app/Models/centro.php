<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class centro extends Model
{
    protected $fillable = [
        'nombre',
        'direccion',
        'telefono',
        'correo',
    ];
}
