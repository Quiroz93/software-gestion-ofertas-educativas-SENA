<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Competencia extends Model
{
    // Definir la tabla si no sigue la convención plural
    protected $table = "competencias";

    // Definir los campos que pueden ser asignados masivamente
    protected $fillable = ["nombre","descripcion"];

    /**
     * Accessor: Descripción limitada a 80 caracteres
     */
    public function getDescripcionCortaAttribute()
    {
        return \Illuminate\Support\Str::limit($this->descripcion ?? '', 80);
    }
}
