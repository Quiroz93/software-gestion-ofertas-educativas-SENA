<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Municipio extends Model
{
    use HasFactory;

    protected $table = 'municipios';

    protected $fillable = [
        'nombre',
        'codigo',
        'departamento',
    ];

    /**
     * Relación: Un municipio puede tener muchos programas
     */
    public function programas()
    {
        return $this->hasMany(Programa::class);
    }
}
