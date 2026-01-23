<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Programa extends Model
{
    // Definir la tabla si no sigue la convención plural
    protected $table = 'programas';

    // Definir los campos que se pueden asignar masivamente
    protected $fillable = [
        'nombre',
        'descripcion',
        'requisitos',
        'duracion_meses',
        'red_id',
        'nivel_formacion_id',
        'modalidad',
        'jornada',
        'titulo_otorgado',
        'codigo_snies',
        'registro_calidad',
        'fecha_registro',
        'fecha_actualizacion',
        'estado',
        'observaciones',
        'centro_id',
        'cupos',
    ];
    // Definir las relaciones con otros modelos
    public function red()
    {
        return $this->belongsTo(Red::class);
    }

    public function nivelFormacion()
    {
        return $this->belongsTo(NivelFormacion::class);
    }
}
