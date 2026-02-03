<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Modelo para registrar las exportaciones realizadas
 * Auditoría de descargas de reportes
 */
class Exportacion extends Model
{
    protected $table = 'exportaciones';

    protected $fillable = [
        'user_id',
        'tipo',
        'filtros_aplicados',
        'total_registros',
        'nombre_archivo',
        'ruta_archivo',
    ];

    protected $casts = [
        'filtros_aplicados' => 'array',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Relación con el usuario que realizó la exportación
     */
    public function usuario(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Obtener exportaciones de preinscritos
     */
    public static function preinscritos()
    {
        return static::where('tipo', 'preinscritos');
    }

    /**
     * Ámbito para últimas exportaciones
     */
    public function scopeRecientes($query, $dias = 30)
    {
        return $query->where('created_at', '>=', now()->subDays($dias));
    }
}
