<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
     * Relación polymorphic con CustomContent
     */
    public function customContents()
    {
        return $this->morphMany(CustomContent::class, 'contentable');
    }
}
