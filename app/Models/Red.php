<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Red extends Model
{
    use HasFactory;
    // Definir la tabla si no sigue la convención plural
    protected $table = 'redes';

    // Definir los campos que se pueden asignar masivamente
    protected $fillable = [
        'nombre',
        'descripcion',
    ];
}
