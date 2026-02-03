<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NovedadHistorial extends Model
{
    use HasFactory;

    protected $table = 'novedades_historial';

    public $timestamps = true;

    protected $fillable = [
        'novedad_id',
        'estado_anterior',
        'estado_nuevo',
        'comentario',
        'changed_by',
    ];

    /**
     * Relación: Novedad
     */
    public function novedad()
    {
        return $this->belongsTo(NovedadPreinscrito::class, 'novedad_id');
    }

    /**
     * Relación: Usuario que hizo el cambio
     */
    public function changedBy()
    {
        return $this->belongsTo(User::class, 'changed_by');
    }

    /**
     * Scope: Por novedad
     */
    public function scopeByNovedad($query, $novedadId)
    {
        return $query->where('novedad_id', $novedadId)->orderBy('created_at', 'desc');
    }
}
