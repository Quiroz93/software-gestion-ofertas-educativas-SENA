<?php

namespace Database\Factories;

use App\Models\NivelFormacion;
use App\Models\Programa;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProgramaFactory extends Factory
{
    protected $model = Programa::class;

    public function definition()
    {
        return [
            'nombre' => $this->faker->words(2, true),
            'numero_ficha' => $this->faker->unique()->numerify('####'),
            'descripcion' => $this->faker->sentence(),
            'requisitos' => $this->faker->sentence(),
            'duracion_meses' => $this->faker->numberBetween(6, 24),
            'red_id' => \App\Models\Red::factory(),
            'nivel_formacion_id' => NivelFormacion::factory(),
            'modalidad' => 'presencial',
            'jornada' => 'mañana',
            'titulo_otorgado' => 'Técnico',
            'codigo_snies' => $this->faker->unique()->numerify('SNIES####'),
            'registro_calidad' => $this->faker->word(),
            'fecha_registro' => $this->faker->date(),
            'fecha_actualizacion' => $this->faker->date(),
            'estado' => 'activo',
            'observaciones' => null,
            'centro_id' => \App\Models\Centro::factory(),
            'cupos' => 30,
            'municipio_id' => \App\Models\Municipio::factory(),
            'is_featured' => false,
            'instructor_id' => \App\Models\Instructor::factory(),
        ];
    }
}
