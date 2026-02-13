<?php

namespace Database\Factories;

use App\Models\Inscrito;
use Illuminate\Database\Eloquent\Factories\Factory;

class InscritoFactory extends Factory
{
    protected $model = Inscrito::class;

    public function definition()
    {
        return [
            'user_id' => 1,
            'oferta_id' => 1,
            'programa_id' => 1,
            'anio' => $this->faker->year(),
            'estado' => 'activo',
            'comentarios' => $this->faker->sentence(),
            'created_by' => 1,
            'updated_by' => 1,
        ];
    }
}
