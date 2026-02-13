<?php

namespace App\Models;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class NovedadPreinscrito extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'novedades_preinscritos';

    protected $fillable = [
        'preinscrito_id',
        'tipo_novedad_id',
        'estado',
        'descripcion',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    const ESTADOS = [
        'abierta' => 'Abierta',
        'en_gestion' => 'En Gestión',
        'resuelta' => 'Resuelta',
        'cancelada' => 'Cancelada',
    ];

    /**
     * Relación: Preinscrito
     */
    public function preinscrito()
    {
        return $this->belongsTo(Preinscrito::class);
    }

    /**
     * Relación: Tipo de novedad
     */
    public function tipoNovedad()
    {
        return $this->belongsTo(TipoNovedad::class);
    }

    /**
     * Relación: Usuario que creó
     */
    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Relación: Usuario que actualizó
     */
    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    /**
     * Relación: Historial de cambios
     */
    public function historial()
    {
        return $this->hasMany(NovedadHistorial::class, 'novedad_id');
    }

    /**
     * Scope: Por estado
     */
    public function scopeByEstado($query, $estado)
    {
        if (!$estado) {
            return $query;
        }

        return $query->where('estado', $estado);
    }

    /**
     * Scope: Por tipo de novedad
     */
    public function scopeByTipoNovedad($query, $tipoId)
    {
        if (!$tipoId) {
            return $query;
        }

        return $query->where('tipo_novedad_id', $tipoId);
    }

    /**
     * Scope: Por preinscrito
     */
    public function scopeByPreinscrito($query, $presritoId)
    {
        return $query->where('preinscrito_id', $presritoId);
    }

    /**
     * Scope: Abiertas (abierta o en_gestion)
     */
    public function scopeAbiertas($query)
    {
        return $query->whereIn('estado', ['abierta', 'en_gestion']);
    }

    /**
     * Obtener etiqueta del estado
     */
    public function getEtiquetaEstadoAttribute()
    {
        return self::ESTADOS[$this->estado] ?? $this->estado;
    }

    /**
     * Cambiar estado y registrar historial
     */
    public function cambiarEstado($nuevoEstado, $comentario = null, $userId = null)
    {
        $estadoAnterior = $this->estado;

        // Actualizar estado
        $this->estado = $nuevoEstado;
        $this->updated_by = $userId ?? Auth::id();
        $this->save();

        // Registrar en historial
        NovedadHistorial::create([
            'novedad_id' => $this->id,
            'estado_anterior' => $estadoAnterior,
            'estado_nuevo' => $nuevoEstado,
            'comentario' => $comentario,
            'changed_by' => $userId ?? Auth::id(),
        ]);

        return $this;
    }
}
