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
        'numero_ficha',
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
        'municipio_id',
        'is_featured',
        'instructor_id',
    ];
    // Definir las relaciones con otros modelos
    public function contentPublicPrograma()
    {
        return $this->hasOne(ContentPublicPrograma::class);
    }
    public function red()
    {
        return $this->belongsTo(Red::class);
    }

    public function nivelFormacion()
    {
        return $this->belongsTo(NivelFormacion::class);
    }

    public function centro()
    {
        return $this->belongsTo(Centro::class);
    }

    public function municipio()
    {
        return $this->belongsTo(Municipio::class);
    }

    protected $casts = [
        'fecha_registro' => 'date',
        'fecha_actualizacion' => 'date',
        'is_featured' => 'boolean',
    ];

    /**
     * Relación con competencias
     */
    public function competencias()
    {
        return $this->belongsToMany(Competencia::class, 'programa_competencias');
    }

    /**
     * Relación muchos a muchos con ofertas educativas
     */
    public function ofertas()
    {
        return $this->belongsToMany(Oferta::class, 'oferta_programas', 'programa_id', 'oferta_id')
            ->withTimestamps();
    }

    /**
     * Relación con inscripciones
     */
    public function inscripciones()
    {
        return $this->hasMany(Inscripcion::class);
    }

    /**
     * Relación con preinscritos
     */
    public function preinscritos()
    {
        return $this->hasMany(Preinscrito::class);
    }

    /**
     * Relación con historias de éxito / proyectos destacados
     */
    public function historiasExito()
    {
        return $this->hasMany(HistoriaExito::class, 'programa_id');
    }

        /**
         * Relación uno a uno con ProgramaDetalle
         */
        public function detalle()
        {
            return $this->hasOne(ProgramaDetalle::class);
        }

    /**
     * Relación polimórfica con contenido personalizado (custom_contents)
     */
    public function customContents()
    {
        return $this->morphMany(\App\Models\CustomContent::class, 'contentable');
    }

    /**
     * Relación con usuarios (aprendices) a través de inscripciones
     */
    public function aprendices()
    {
        return $this->belongsToMany(User::class, 'inscripciones')
            ->withPivot('instructor_id', 'fecha_inscripcion', 'fecha_retiro', 'estado', 'observaciones')
            ->withTimestamps();
    }

    /**
     * Accessor: Obtiene la descripción limitada a 100 caracteres
     * Útil para vistas admin sin necesidad de usar Str::limit() en Blade
     */
    public function getDescripcionCortaAttribute()
    {
        return \Illuminate\Support\Str::limit($this->descripcion ?? 'Sin descripción', 100);
    }

    /**
     * Accessor: Obtiene la descripción limitada a 200 caracteres
     */
    public function getDescripcionLargaAttribute()
    {
        return \Illuminate\Support\Str::limit($this->descripcion ?? 'Sin descripción', 200);
    }

    /**
     * Relación con instructor
     */
    public function instructor()
    {
        return $this->belongsTo(Instructor::class);
    }
}
