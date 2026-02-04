<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HistoriaExito extends Model
{
    // Definir la tabla si no sigue la convención plural
    protected $table = 'historias_de_exitos';

    // Definir los campos que se pueden asignar masivamente
    protected $fillable = [
        'nombre',
        'titulo',
        'descripcion',
        'año',
        'correo',
        'programa_id',
        'imagen',
    ];

    /**
     * Accessor: Título limitado a 30 caracteres
     */
    public function getTituloCortaAttribute()
    {
        return \Illuminate\Support\Str::limit($this->titulo ?? '', 30);
    }

    /**
     * Accessor: Descripción limitada a 150 caracteres
     */
    public function getDescripcionCortaAttribute()
    {
        return \Illuminate\Support\Str::limit($this->descripcion ?? '', 150);
    }

    /**
     * Método: Obtener descripción limitada a una cantidad específica
     */
    public function getDescripcionLimitada($length = 150)
    {
        return \Illuminate\Support\Str::limit($this->descripcion ?? '', $length);
    }
}
