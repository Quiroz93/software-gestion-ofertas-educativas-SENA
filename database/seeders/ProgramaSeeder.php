<?php

namespace Database\Seeders;

use App\Models\Programa;
use Illuminate\Database\Seeder;

class ProgramaSeeder extends Seeder
{
    public function run(): void
    {
        $programas = [

            /* ================= OPERARIO ================= */
            [
                'nombre' => 'Procesos de Panadería',
                'numero_ficha' => '3410523',
                'descripcion' => 'Formación operaria en procesos básicos de panadería.',
                'requisitos' => 'Saber leer y escribir',
                'duracion_meses' => 6,
                'red_id' => 2,
                'nivel_formacion_id' => 1,
                'modalidad' => 'Presencial',
                'jornada' => 'Diurna',
                'titulo_otorgado' => 'Operario en Procesos de Panadería',
                'codigo_snies' => null,
                'registro_calidad' => null,
                'fecha_registro' => now()->format('Y-m-d'),
                'fecha_actualizacion' => now()->format('Y-m-d'),
                'estado' => 'Activo',
                'centro_id' => 1,
                'cupos' => 30
            ],

            /* ================= TÉCNICO ================= */
            [
                'nombre' => 'Dibujo Arquitectónico - FIC',
                'numero_ficha' => '3410525',
                'descripcion' => 'Formación técnica en representación gráfica arquitectónica.',
                'requisitos' => 'Básica secundaria',
                'duracion_meses' => 12,
                'red_id' => 2,
                'nivel_formacion_id' => 2,
                'modalidad' => 'Presencial',
                'jornada' => 'Diurna',
                'titulo_otorgado' => 'Técnico en Dibujo Arquitectónico',
                'codigo_snies' => null,
                'registro_calidad' => 'FIC',
                'fecha_registro' => now()->format('Y-m-d'),
                'fecha_actualizacion' => now()->format('Y-m-d'),
                'estado' => 'Activo',
                'centro_id' => 1,
                'cupos' => 30
            ],
            [
                'nombre' => 'Atención Integral a la Primera Infancia',
                'descripcion' => 'Formación técnica para la atención integral de la primera infancia.',
                'numero_ficha' => '3410527',
                'requisitos' => 'Bachiller',
                'duracion_meses' => 18,
                'red_id' => 4,
                'nivel_formacion_id' => 2,
                'modalidad' => 'Presencial',
                'jornada' => 'Diurna',
                'titulo_otorgado' => 'Técnico en Atención Integral a la Primera Infancia',
                'codigo_snies' => null,
                'registro_calidad' => null,
                'fecha_registro' => now()->format('Y-m-d'),
                'fecha_actualizacion' => now()->format('Y-m-d'),
                'estado' => 'Activo',
                'centro_id' => 1,
                'cupos' => 30
            ],
            [
                'nombre' => 'Cosmetología y Estética Integral',
                'numero_ficha' => '3410528',
                'descripcion' => 'Formación técnica en servicios estéticos integrales.',
                'requisitos' => 'Bachiller',
                'duracion_meses' => 18,
                'red_id' => 5,
                'nivel_formacion_id' => 2,
                'modalidad' => 'Presencial',
                'jornada' => 'Diurna',
                'titulo_otorgado' => 'Técnico en Cosmetología y Estética Integral',
                'codigo_snies' => null,
                'registro_calidad' => null,
                'fecha_registro' => now()->format('Y-m-d'),
                'fecha_actualizacion' => now()->format('Y-m-d'),
                'estado' => 'Activo',
                'centro_id' => 1,
                'cupos' => 30
            ],
            [
                'nombre' => 'Ejecución de Programas Deportivos',
                'descripcion' => 'Formación técnica en ejecución y apoyo de programas deportivos.',
                'numero_ficha' => '3410546',
                'requisitos' => 'Bachiller',
                'duracion_meses' => 18,
                'red_id' => 6,
                'nivel_formacion_id' => 2,
                'modalidad' => 'Presencial',
                'jornada' => 'Diurna',
                'titulo_otorgado' => 'Técnico en Ejecución de Programas Deportivos',
                'codigo_snies' => null,
                'registro_calidad' => null,
                'fecha_registro' => now()->format('Y-m-d'),
                'fecha_actualizacion' => now()->format('Y-m-d'),
                'estado' => 'Activo',
                'centro_id' => 1,
                'cupos' => 30
            ],

            /* ================= TECNÓLOGO ================= */
            [
                'nombre' => 'Actividad Física',
                'descripcion' => 'Formación tecnológica en actividad física y entrenamiento.',
                'numero_ficha' => '3410548',
                'requisitos' => 'Bachiller',
                'duracion_meses' => 24,
                'red_id' => 6,
                'nivel_formacion_id' => 3,
                'modalidad' => 'Presencial',
                'jornada' => 'Diurna',
                'titulo_otorgado' => 'Tecnólogo en Actividad Física',
                'codigo_snies' => '109612',
                'registro_calidad' => null,
                'fecha_registro' => now()->format('Y-m-d'),
                'fecha_actualizacion' => now()->format('Y-m-d'),
                'estado' => 'Activo',
                'centro_id' => 1,
                'cupos' => 30
            ],
            [
                'nombre' => 'Gestión Administrativa',
                'descripcion' => 'Formación tecnológica en procesos administrativos.',
                'numero_ficha' => '3410568',
                'requisitos' => 'Bachiller',
                'duracion_meses' => 24,
                'red_id' => 1,
                'nivel_formacion_id' => 3,
                'modalidad' => 'Presencial',
                'jornada' => 'Diurna',
                'titulo_otorgado' => 'Tecnólogo en Gestión Administrativa',
                'codigo_snies' => '109141',
                'registro_calidad' => null,
                'fecha_registro' => now()->format('Y-m-d'),
                'fecha_actualizacion' => now()->format('Y-m-d'),
                'estado' => 'Activo',
                'centro_id' => 1,
                'cupos' => 30
            ],
            [
                'nombre' => 'Análisis y Desarrollo de Software',
                'descripcion' => 'Formación tecnológica en desarrollo de software.',
                'numero_ficha' => '3410551',
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
            ],
            [
                'nombre' => 'Levantamientos Topográficos y Georreferenciación',
                'descripcion' => 'Formación tecnológica en levantamientos topográficos, georreferenciación y manejo de sistemas de información geográfica.',
                'numero_ficha' => '3410569',
                'requisitos' => 'Bachiller',
                'duracion_meses' => 24,
                'red_id' => 3,
                'nivel_formacion_id' => 3,
                'modalidad' => 'Presencial',
                'jornada' => 'Diurna',
                'titulo_otorgado' => 'Tecnólogo en Levantamientos Topográficos y Georreferenciación',
                'codigo_snies' => '110596',
                'registro_calidad' => null,
                'fecha_registro' => now()->format('Y-m-d'),
                'fecha_actualizacion' => now()->format('Y-m-d'),
                'estado' => 'Activo',
                'centro_id' => 1,
                'cupos' => 30
            ],
            [
                'nombre' => 'Gestión Contable y de Información Financiera',
                'descripcion' => 'Formación tecnológica en gestión contable y de información financiera.',
                'numero_ficha' => '3410558',
                'requisitos' => 'Bachiller',
                'duracion_meses' => 24,
                'red_id' => 3,
                'nivel_formacion_id' => 3,
                'modalidad' => 'Presencial',
                'jornada' => 'Diurna',
                'titulo_otorgado' => 'Tecnólogo en Gestión Contable y de Información Financiera',
                'codigo_snies' => null,
                'registro_calidad' => null,
                'fecha_registro' => now()->format('Y-m-d'),
                'fecha_actualizacion' => now()->format('Y-m-d'),
                'estado' => 'Activo',
                'centro_id' => 1,
                'cupos' => 30
            ],
            [
                'nombre' => 'Coordinación en Sistemas Integrados de Gestión',
                'descripcion' => 'Formación tecnológica en coordinación de sistemas integrados de gestión.',
                'numero_ficha' => '3410564',
                'requisitos' => 'Bachiller',
                'duracion_meses' => 24,
                'red_id' => 1,
                'nivel_formacion_id' => 3,
                'modalidad' => 'Presencial',
                'jornada' => 'Diurna',
                'titulo_otorgado' => 'Tecnólogo en Coordinación en Sistemas Integrados de Gestión',
                'codigo_snies' => null,
                'registro_calidad' => null,
                'fecha_registro' => now()->format('Y-m-d'),
                'fecha_actualizacion' => now()->format('Y-m-d'),
                'estado' => 'Activo',
                'centro_id' => 1,
                'cupos' => 30
            ],

        ];

        foreach ($programas as $programa) {
            Programa::create($programa);
        }
    }
}
