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
                'nombre' => 'Red de Sostenibilidad Ambiental',
                'descripcion' => 'Programas enfocados en sostenibilidad, medio ambiente y energías limpias.'
            ],
            [
                'nombre' => 'Red de Deportes y Recreación',
                'descripcion' => 'Programas en actividades físicas, deportes y recreación.'
            ]
        ];

        foreach ($redes as $red) {
            Red::create($red);
        }
    }
}
