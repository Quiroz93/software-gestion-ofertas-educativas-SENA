<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomContent extends Model
{
    protected $fillable = [
        'key',
        'value',
        'type',
    ];

    /**
     * Relación polimórfica inversa
     */
    public function contentable()
    {
        return $this->morphTo();
    }
}

