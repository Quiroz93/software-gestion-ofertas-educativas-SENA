<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HomeCarousel extends Model
{
    protected $fillable = [
        'title',
        'description',
        'image_path',
        'button_text',
        'button_url',
        'is_active',
        'position',
    ];
}
