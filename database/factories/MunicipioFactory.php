<?php

namespace Database\Factories;

use App\Models\Municipio;
use Illuminate\Database\Eloquent\Factories\Factory;

class MunicipioFactory extends Factory
{
    protected $model = Municipio::class;

    public function definition()
    {
        return [
            'nombre' => $this->faker->city(),
            'codigo' => $this->faker->unique()->numerify('MUN####'),
            'estado' => 'activo',
        ];
    }
}
