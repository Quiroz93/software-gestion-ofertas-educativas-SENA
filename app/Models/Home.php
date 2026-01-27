<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\CustomContent;

/**
 * Modelo placeholder para contenido global de la página Home
 * No tiene tabla asociada, solo sirve para el sistema de contenido editable
 */
class Home extends Model
{
    /**
     * Indicar que este modelo no usa tabla
     * El contenido se almacena en custom_contents (polymorphic)
     */
    public $table = null;
    
    /**
     * No usar timestamps
     */
    public $timestamps = false;
    
    /**
     * 🔗 Relación polimórfica con CustomContent
     * OBLIGATORIO para contenido editable
     */
    public function customContents()
    {
        return $this->morphMany(CustomContent::class, 'contentable');
    }

    /**
     * 🔧 Helper para obtener contenido personalizado
     * OBLIGATORIO para facilitar acceso a contenido
     *
     * @param string $key - Clave del contenido
     * @param mixed $default - Valor por defecto
     * @return mixed
     */
    public function custom(string $key, $default = null)
    {
        $content = $this->customContents()->where('key', $key)->first();
        return $content?->value ?? $default;
    }
}
