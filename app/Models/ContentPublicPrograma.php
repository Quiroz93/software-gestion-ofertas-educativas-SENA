<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContentPublicPrograma extends Model
{
    protected $table = 'content_public_programas';

    protected $fillable = [
        'programa_id',
        'hero_title',
        'hero_description',
        'hero_image',
        'motivational_title',
        'motivational_text',
        'motivational_image',
        'competencias_fallback',
    ];

    public function programa()
    {
        return $this->belongsTo(Programa::class);
    }
}
