<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomContent extends Model
{
    protected $fillable = [
        'contentable_type',
        'contentable_id',
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

