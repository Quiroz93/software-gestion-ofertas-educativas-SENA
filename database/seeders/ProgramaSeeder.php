<?php

namespace Database\Seeders;

use App\Models\Programa;
use Illuminate\Database\Seeder;

class ProgramaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $programas = [
            [
                'nombre' => 'Análisis y Desarrollo de Sistemas de Información',
                'descripcion' => 'Formación de tecnólogos capaces de analizar, diseñar e implementar soluciones informáticas.',
                'requisitos' => 'Diploma de Bachiller, prueba de aptitud',
                'duracion_meses' => 36,
                'red_id' => 3,
                'nivel_formacion_id' => 2,
                'modalidad' => 'Presencial',
                'jornada' => 'Diurna',
                'titulo_otorgado' => 'Tecnólogo en Análisis y Desarrollo de Sistemas de Información',
                'codigo_snies' => '105999',
                'registro_calidad' => 'Resolución 05555 de 2015',
                'fecha_registro' => '2015-12-15',
                'fecha_actualizacion' => now()->format('Y-m-d'),
                'estado' => 'Activo',
                'centro_id' => 1,
                'cupos' => 40
            ],
            [
                'nombre' => 'Administración de Empresas',
                'descripcion' => 'Programa técnico profesional en administración empresarial y gestión organizacional.',
                'requisitos' => 'Diploma de Bachiller',
                'duracion_meses' => 24,
                'red_id' => 1,
                'nivel_formacion_id' => 1,
                'modalidad' => 'Presencial',
                'jornada' => 'Diurna',
                'titulo_otorgado' => 'Técnico Profesional en Administración de Empresas',
                'codigo_snies' => '105100',
                'registro_calidad' => 'Resolución 08765 de 2020',
                'fecha_registro' => '2020-06-10',
                'fecha_actualizacion' => now()->format('Y-m-d'),
                'estado' => 'Activo',
                'centro_id' => 1,
                'cupos' => 50
            ],
            [
                'nombre' => 'Mantenimiento de Equipos de Cómputo',
                'descripcion' => 'Formación técnica en mantenimiento preventivo y correctivo de equipos computacionales.',
                'requisitos' => 'Diploma de Bachiller, conocimientos básicos de electrónica',
                'duracion_meses' => 24,
                'red_id' => 3,
                'nivel_formacion_id' => 1,
                'modalidad' => 'Presencial',
                'jornada' => 'Diurna',
                'titulo_otorgado' => 'Técnico Profesional en Mantenimiento de Equipos de Cómputo',
                'codigo_snies' => '105800',
                'registro_calidad' => 'Resolución 12345 de 2019',
                'fecha_registro' => '2019-03-20',
                'fecha_actualizacion' => now()->format('Y-m-d'),
                'estado' => 'Activo',
                'centro_id' => 3,
                'cupos' => 35
            ],
            [
                'nombre' => 'Automatización Industrial',
                'descripcion' => 'Programa tecnológico para formar especialistas en sistemas de automatización y control.',
                'requisitos' => 'Diploma de Bachiller, conocimientos en electrónica',
                'duracion_meses' => 36,
                'red_id' => 2,
                'nivel_formacion_id' => 2,
                'modalidad' => 'Presencial',
                'jornada' => 'Diurna',
                'titulo_otorgado' => 'Tecnólogo en Automatización Industrial',
                'codigo_snies' => '106001',
                'registro_calidad' => 'Resolución 06789 de 2021',
                'fecha_registro' => '2021-09-01',
                'fecha_actualizacion' => now()->format('Y-m-d'),
                'estado' => 'Activo',
                'centro_id' => 2,
                'cupos' => 30
            ],
            [
                'nombre' => 'Inglés Técnico',
                'descripcion' => 'Formación complementaria en idioma inglés con énfasis técnico.',
                'requisitos' => 'Aprendiz o trabajador SENA',
                'duracion_meses' => 6,
                'red_id' => 4,
                'nivel_formacion_id' => 3,
                'modalidad' => 'Presencial',
                'jornada' => 'Nocturna',
                'titulo_otorgado' => 'Certificado en Inglés Técnico',
                'codigo_snies' => '',
                'registro_calidad' => '',
                'fecha_registro' => now()->format('Y-m-d'),
                'fecha_actualizacion' => now()->format('Y-m-d'),
                'estado' => 'Activo',
                'centro_id' => 1,
                'cupos' => 60
            ]
        ];

        foreach ($programas as $programa) {
            Programa::create($programa);
        }
    }
}
