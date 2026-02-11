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
        // Campos opcionales para REGIONAL SANTANDER
        'nis',
        'correo_electronico',
        'telefono_fijo',
        'telefono_movil',
        'tipo_prueba',
        'resultado_prueba',
        'fecha_cargue',
        'estado_prueba',
        'motivo_prueba',
        'fecha_prueba',
        'acceso_preferente',
        'digito',
        'dia_pico_placa',
    ];

    public function consolidacion()
    {
        return $this->belongsTo(ConsolidacionPreinscrito::class, 'consolidacion_id');
    }
}
