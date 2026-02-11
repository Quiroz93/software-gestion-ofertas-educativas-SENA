<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ConsolidacionPreinscrito extends Model
{
    use SoftDeletes;

    protected $table = 'consolidaciones_preinscritos';

    protected $fillable = [
        'nombre_consolidacion',
        'descripcion',
            'observaciones',
        'tipo_consolidacion',
        'total_archivos',
        'total_registros',
        'total_descartados',
        'created_by',
    ];

        protected $casts = [
            'observaciones' => 'array',
        ];

    public function detalles()
    {
        return $this->hasMany(ConsolidacionPreinscritoDetalle::class, 'consolidacion_id');
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
