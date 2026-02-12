<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PreinscritosHistorico extends Model
{
    protected $table = 'preinscritos_historico';
    protected $fillable = [
        'nombres',
        'apellidos',
        'tipo_documento',
        'numero_documento',
        'celular_principal',
        'celular_alternativo',
        'correo_principal',
        'correo_alternativo',
        'programa_id',
        'estado',
        'comentarios',
        'created_by',
        'updated_by',
        'oferta_id',
    ];
}
