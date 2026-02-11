<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\CustomContent;

class Oferta extends Model
{
    /**
     * Definir la tabla si no sigue la convención plural
     */
    protected $table = 'ofertas';

    /**
     * Definir los campos que se pueden asignar masivamente
     */
    protected $fillable = [
        'nombre',
        'año',
        'fecha_inicio',
        'fecha_fin',
        'estado',
        'centro_id',
    ];

    /**
     * Castear atributos a tipos específicos
     */
    protected $casts = [
        'fecha_inicio' => 'datetime',
        'fecha_fin' => 'datetime',
    ];

    /**
     * Definir las relaciones con otros modelos
     */
    public function centro()
    {
        return $this->belongsTo(Centro::class);
    }

    /**
     * Relación muchos a muchos con programas
     */
    public function programas()
    {
        return $this->belongsToMany(Programa::class, 'oferta_programas', 'oferta_id', 'programa_id')
            ->withTimestamps();
    }

    public function customContents()
    {
        return $this->morphMany(CustomContent::class, 'contentable');
    }
    /**
     * Obtener un contenido personalizado por clave
     */
    public function custom(string $key, $default = null)
    {
        // Utiliza el constructor de consultas de la relación directamente
        // para evitar cargar toda la colección.
        $content = $this->customContents()->where('key', $key)->first();
        return $content?->value ?? $default;
    }

    /**
     * Accessor: Descripción limitada a 100 caracteres
     */
    public function getDescripcionCortaAttribute()
    {
        $description = $this->custom('descripcion', '');
        return \Illuminate\Support\Str::limit($description, 100);
    }

    /**
     * Accessor: Descripción limitada a 150 caracteres
     */
    public function getDescripcionMediaAttribute()
    {
        $description = $this->custom('descripcion', '');
        return \Illuminate\Support\Str::limit($description, 150);
    }

}
