<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProgramaDetalle extends Model
{
    protected $table = 'programa_detalles';
    protected $fillable = [
        'programa_id',
        'contextualizacion',
        'video_url',
        'video_file',
        'imagenes', // Puede ser JSON
        'imagenes_blob',
    ];

    protected $casts = [
        'imagenes' => 'array',
        'imagenes_blob' => 'array',
    ];

    public function programa()
    {
        return $this->belongsTo(Programa::class);
    }
}
