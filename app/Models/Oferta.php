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
     * Definir las relaciones con otros modelos
     */
    public function customContents()
    {
        return $this->morphMany(CustomContent::class, 'contentable');
    }
    /**
     * Obtener un contenido personalizado por clave
     */
    public function custom(string $key, $default = null)
{
    return $this->customContents
        ->where('key', $key)
        ->first()
        ?->value ?? $default;
}

}
