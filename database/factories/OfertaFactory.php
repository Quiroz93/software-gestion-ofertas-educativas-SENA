<?php

namespace Database\Factories;

use App\Models\Oferta;
use Illuminate\Database\Eloquent\Factories\Factory;

class OfertaFactory extends Factory
{
    protected $model = Oferta::class;

    public function definition()
    {
        return [
            'nombre' => $this->faker->words(3, true),
            'año' => $this->faker->year(),
            'fecha_inicio' => $this->faker->date(),
            'fecha_fin' => $this->faker->date(),
            'estado' => 'activa',
            'centro_id' => \App\Models\Centro::factory(),
        ];
    }
}
