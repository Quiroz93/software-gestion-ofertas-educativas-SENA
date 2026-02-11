<?php

namespace Database\Seeders;

use App\Models\Red;
use Illuminate\Database\Seeder;

class RedSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $redes = [
            [
                'nombre' => 'Red de Comercio y Servicios',
                'descripcion' => 'Formación en gestión empresarial, comercio internacional y servicios.'
            ],
            [
                'nombre' => 'Red de Manufactura e Ingeniería',
                'descripcion' => 'Programas en manufactura, electrónica, automatización industrial.'
            ],
            [
                'nombre' => 'Red de Tecnología e Innovación',
                'descripcion' => 'Formación en tecnologías de la información, software y desarrollo.'
            ],
            [
                'nombre' => 'Red de Talento Humano y Gestión',
                'descripcion' => 'Competencias en gestión, liderazgo y desarrollo de personas.'
            ],
            [
                'nombre' => 'Red de Salud y Bienestar',
                'descripcion' => 'Formación en servicios de salud, estética, cosmetología y bienestar personal.'
            ],
            [
                'nombre' => 'Red de Deportes y Recreación',
                'descripcion' => 'Programas de actividad física, entrenamiento deportivo y recreación.'
            ]
        ];

        foreach ($redes as $red) {
            Red::create($red);
        }
    }
}
