<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ConsolidacionPreinscritoDetalle extends Model
{
    protected $table = 'consolidacion_preinscritos_detalles';

    protected $fillable = [
        'consolidacion_id',
        'tipo_documento',
        'numero_documento',
        'nombre_completo',
        'estado',
        'codigo_ficha',
        'nombre_programa',
        'observaciones',
    ];

    public function consolidacion()
    {
        return $this->belongsTo(ConsolidacionPreinscrito::class, 'consolidacion_id');
    }
}
