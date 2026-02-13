<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Instructor extends Model
{
    use HasFactory;
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
