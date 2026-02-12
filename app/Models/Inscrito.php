<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Modelo de Inscrito
 * Gestiona los aprendices inscritos en los programas de formación
 */
class Inscrito extends Model
{
    use SoftDeletes;

    /**
     * Tabla asociada al modelo
     */
    protected $table = 'inscritos';

    /**
     * Atributos que pueden ser asignados en masa
     */
    protected $fillable = [
        'user_id',
        'oferta_id',
        'programa_id',
        'anio',
        'estado',
        'comentarios',
        'created_by',
        'updated_by',
    ];

    /**
     * Tipos de atributos
     */
    protected $casts = [
        'anio' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    /**
     * Relación: Un inscrito pertenece a un usuario
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relación: Un inscrito pertenece a una oferta
     */
    public function oferta(): BelongsTo
    {
        return $this->belongsTo(Oferta::class);
    }

    /**
     * Relación: Un inscrito pertenece a un programa
     */
    public function programa(): BelongsTo
    {
        return $this->belongsTo(Programa::class);
    }

    /**
     * Relación: Usuario que creó el registro
     */
    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Relación: Usuario que actualizó el registro
     */
    public function updatedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}
