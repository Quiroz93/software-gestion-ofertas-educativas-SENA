<?php

namespace Database\Factories;

use App\Models\Instructor;
use Illuminate\Database\Eloquent\Factories\Factory;

class InstructorFactory extends Factory
{
    protected $model = Instructor::class;

    public function definition()
    {
        return [
            'nombre' => $this->faker->name(),
            'apellidos' => $this->faker->lastName(),
            'correo' => $this->faker->unique()->safeEmail(),
            'especialidad' => $this->faker->word(),
            'estado' => 'activo',
        ];
    }
}
