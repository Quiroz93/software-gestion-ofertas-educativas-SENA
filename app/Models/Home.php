<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\CustomContent;

class Home extends Model
{
    protected $table = 'homes'; // Aunque no usaremos tabla, por convención

    // No fillable ya que no guardaremos en DB directa

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