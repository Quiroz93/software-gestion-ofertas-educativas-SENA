<?php
// app/Models/Noticia.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Noticia extends Model
{
    use HasFactory;

    // Definir la tabla si no sigue la convención plural
    protected $table = 'noticias';

    // Definir los campos que se pueden asignar masivamente
    protected $fillable = [
        'titulo',
        'descripcion',
        'imagen',
        'activa',
    ];

    /**
     * Los atributos que deben ser convertidos
     */
    protected $casts = [
        'activa' => 'boolean',
    ];

    /**
     * Accessor: Título limitado a 30 caracteres
     */
    public function getTituloCortaAttribute()
    {
        return \Illuminate\Support\Str::limit($this->titulo ?? '', 30);
    }

    /**
     * Accessor: Título limitado a 50 caracteres
     */
    public function getTituloMedioAttribute()
    {
        return \Illuminate\Support\Str::limit($this->titulo ?? '', 50);
    }

    /**
     * Accessor: Descripción limitada a 90 caracteres
     */
    public function getDescripcionCortaAttribute()
    {
        return \Illuminate\Support\Str::limit($this->descripcion ?? '', 90);
    }

    /**
     * Accessor: Descripción limitada a 100 caracteres
     */
    public function getDescripcionMediaAttribute()
    {
        return \Illuminate\Support\Str::limit($this->descripcion ?? '', 100);
    }

    /**
     * Accessor: Descripción limitada a 200 caracteres
     */
    public function getDescripcionLargaAttribute()
    {
        return \Illuminate\Support\Str::limit($this->descripcion ?? '', 200);
    }
}

