<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserSetting extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'setting_key',
        'setting_value',
        'setting_type',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'setting_value' => function ($value, $attributes) {
                return match ($attributes['setting_type']) {
                    'json' => json_decode($value, true),
                    'boolean' => (bool) $value,
                    'integer' => (int) $value,
                    default => $value,
                };
            },
        ];
    }

    /**
     * Get the user that owns the setting.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
