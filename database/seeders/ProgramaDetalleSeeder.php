<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Programa;
use App\Models\ProgramaDetalle;

class ProgramaDetalleSeeder extends Seeder
{
    public function run(): void
    {
        $programa = Programa::where('nombre', 'Análisis y Desarrollo de Software')->first();
        if (!$programa) {
            $programa = Programa::create([
                'nombre' => 'Análisis y Desarrollo de Software',
                'numero_ficha' => '3410551',
                'descripcion' => 'Formación tecnológica en desarrollo de software.',
                'requisitos' => 'Bachiller',
                'duracion_meses' => 24,
                'red_id' => 3,
                'nivel_formacion_id' => 3,
                'modalidad' => 'Presencial',
                'jornada' => 'Diurna',
                'titulo_otorgado' => 'Tecnólogo en Análisis y Desarrollo de Software',
                'codigo_snies' => '110595',
                'registro_calidad' => null,
                'fecha_registro' => now()->format('Y-m-d'),
                'fecha_actualizacion' => now()->format('Y-m-d'),
                'estado' => 'Activo',
                'centro_id' => 1,
                'cupos' => 30
            ]);
        }

        ProgramaDetalle::create([
            'programa_id' => $programa->id,
            'contextualizacion' => 'Este programa forma tecnólogos capaces de analizar, diseñar, desarrollar y mantener soluciones de software para diferentes sectores productivos.',
            'video_url' => 'https://www.youtube.com/embed/1hHMwLxN6EM',
            'video_file' => null,
            'imagenes_blob' => json_encode([
                base64_encode(file_get_contents(public_path('images/foto1.jpg'))),
                base64_encode(file_get_contents(public_path('images/foto2.jpg')))
            ]),
        ]);
    }
}
