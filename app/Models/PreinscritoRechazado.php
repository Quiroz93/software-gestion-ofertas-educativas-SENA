<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PreinscritoRechazado extends Model
{
    protected $table = 'preinscritos_rechazados';

    protected $fillable = [
        'nombre_completo',
        'tipo_documento',
        'numero_documento',
        'telefono',
        'programa',
        'correo',
        'motivo',
        'fila_excel',
        'datos_json',
        'created_by',
    ];
}
