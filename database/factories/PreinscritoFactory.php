<?php

namespace Database\Factories;

use App\Models\Preinscrito;
use Illuminate\Database\Eloquent\Factories\Factory;

class PreinscritoFactory extends Factory
{
    protected $model = Preinscrito::class;

    public function definition()
    {
        $user = \App\Models\User::factory()->create();
        return [
            'nombres' => $this->faker->firstName(),
            'apellidos' => $this->faker->lastName(),
            'tipo_documento' => 'CC',
            'numero_documento' => $this->faker->unique()->numerify('########'),
            'celular_principal' => $this->faker->phoneNumber(),
            'celular_alternativo' => $this->faker->phoneNumber(),
            'correo_principal' => $this->faker->unique()->safeEmail(),
            'correo_alternativo' => $this->faker->safeEmail(),
            'programa_id' => 1,
            'estado' => 'por_inscribir',
            'comentarios' => null,
            'novedades' => null,
            'tipo_novedad' => null,
            'novedad_resuelta' => false,
            'fecha_resolucion' => null,
            'resuelto_por' => null,
            'created_by' => $user->id,
            'updated_by' => $user->id,
        ];
    }
}
