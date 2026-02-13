<?php

namespace Database\Factories;

use App\Models\NivelFormacion;
use Illuminate\Database\Eloquent\Factories\Factory;

class NivelFormacionFactory extends Factory
{
    protected $model = NivelFormacion::class;

    public function definition()
    {
        return [
            'nombre' => $this->faker->word(),
            'descripcion' => $this->faker->sentence(),
            'estado' => 'activo',
        ];
    }
}
