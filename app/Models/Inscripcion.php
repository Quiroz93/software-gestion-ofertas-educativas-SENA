<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Inscripcion extends Model
{
    protected $table = 'inscripciones';

    protected $fillable = [
        'user_id',
        'programa_id',
        'instructor_id',
        'fecha_inscripcion',
        'fecha_retiro',
        'estado',
        'observaciones',
    ];

    protected $casts = [
        'fecha_inscripcion' => 'date',
        'fecha_retiro' => 'date',
    ];

    /**
     * Relación con User (aprendiz)
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relación con Programa
     */
    public function programa(): BelongsTo
    {
        return $this->belongsTo(Programa::class);
    }

    /**
     * Relación con Instructor
     */
    public function instructor(): BelongsTo
    {
        return $this->belongsTo(Instructor::class);
    }

    /**
     * Scope para inscripciones activas
     */
    public function scopeActivas($query)
    {
        return $query->where('estado', 'activo');
    }

    /**
     * Scope para inscripciones finalizadas
     */
    public function scopeFinalizadas($query)
    {
        return $query->where('estado', 'finalizado');
    }

    /**
     * Verificar si la inscripción está activa
     */
    public function estaActiva(): bool
    {
        return $this->estado === 'activo';
    }

    /**
     * Verificar si la inscripción fue retirada
     */
    public function fueRetirada(): bool
    {
        return $this->estado === 'retirado';
    }

    /**
     * Verificar si la inscripción está finalizada
     */
    public function estaFinalizada(): bool
    {
        return $this->estado === 'finalizado';
    }
}
