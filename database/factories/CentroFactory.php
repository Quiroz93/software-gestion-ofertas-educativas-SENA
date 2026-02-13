<?php

namespace Database\Factories;

use App\Models\Centro;
use Illuminate\Database\Eloquent\Factories\Factory;

class CentroFactory extends Factory
{
    protected $model = Centro::class;

    public function definition()
    {
        return [
            'nombre' => $this->faker->company(),
            'codigo' => $this->faker->unique()->numerify('CEN####'),
            'direccion' => $this->faker->address(),
            'telefono' => $this->faker->phoneNumber(),
            'email' => $this->faker->unique()->safeEmail(),
            'estado' => 'activo',
        ];
    }
}
