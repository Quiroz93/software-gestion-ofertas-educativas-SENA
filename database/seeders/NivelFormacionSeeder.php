<?php

namespace Database\Seeders;

use App\Models\NivelFormacion;
use Illuminate\Database\Seeder;

class NivelFormacionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $niveles = [
            [
                'nombre' => 'Técnico',
                'descripcion' => 'Programa técnico profesional de dos años de duración.'
            ],
            [
                'nombre' => 'Tecnólogo',
                'descripcion' => 'Programa tecnológico profesional de tres años de duración.'
            ],
            [
                'nombre' => 'Complementaria',
                'descripcion' => 'Formación complementaria para aprendices y trabajadores.'
            ],
            [
                'nombre' => 'Especialización Técnica',
                'descripcion' => 'Especialización técnica en áreas específicas.'
            ],
            [
                'nombre' => 'Curso Corto',
                'descripcion' => 'Cursos especializados de corta duración.'
            ]
        ];

        foreach ($niveles as $nivel) {
            NivelFormacion::create($nivel);
        }
    }
}
