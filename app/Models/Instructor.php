<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Instructor extends Model
{
    // Definir la tabla si no sigue la convención plural
    protected $table = 'instructores';

    // Definir los campos que se pueden asignar masivamente
    protected $fillable = [
        'nombre',
        'apellidos',
        'perfil_profesional',
        'experiencia',
        'correo',
    ];

    /**
     * Accessor: Experiencia limitada a 100 caracteres
     */
    public function getExperienciaCortaAttribute()
    {
        return \Illuminate\Support\Str::limit($this->experiencia ?? '', 100);
    }
}
