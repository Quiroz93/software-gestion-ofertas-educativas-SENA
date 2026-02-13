<?php

namespace Database\Factories;

use App\Models\Red;
use Illuminate\Database\Eloquent\Factories\Factory;

class RedFactory extends Factory
{
    protected $model = Red::class;

    public function definition()
    {
        return [
            'nombre' => $this->faker->word(),
            'descripcion' => $this->faker->sentence(),
            'estado' => 'activo',
        ];
    }
}
