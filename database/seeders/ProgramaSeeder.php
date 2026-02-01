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
                'red_id' => 1,
                'nivel_formacion_id' => 3,
                'modalidad' => 'Presencial',
                'jornada' => 'Diurna',
                'titulo_otorgado' => 'Operario en Procesos de Panadería',
                'codigo_snies' => null,
                'registro_calidad' => null,
                'fecha_registro' => now(),
                'fecha_actualizacion' => now(),
                'estado' => 'Activo',
                'observaciones' => null,
                'centro_id' => 1,
                'cupos' => 30,
                'municipio_id' => 1, // Málaga
            ],

            /* ================= TÉCNICO ================= */
            [
                'nombre' => 'Dibujo Arquitectónico - FIC',
                'numero_ficha' => '3410525',
                'descripcion' => 'Formación técnica en representación gráfica arquitectónica.',
                'requisitos' => 'Educación básica secundaria',
                'duracion_meses' => 12,
                'red_id' => 2,
                'nivel_formacion_id' => 1,
                'modalidad' => 'Presencial',
                'jornada' => 'Diurna',
                'titulo_otorgado' => 'Técnico en Dibujo Arquitectónico',
                'codigo_snies' => null,
                'registro_calidad' => 'FIC',
                'fecha_registro' => now(),
                'fecha_actualizacion' => now(),
                'estado' => 'Activo',
                'observaciones' => 'Formación de Interés Comunitario',
                'centro_id' => 1,
                'cupos' => 30,
                'municipio_id' => 2, // Concepción
            ],
            [
                'nombre' => 'Atención Integral a la Primera Infancia',
                'numero_ficha' => '3410527',
                'descripcion' => 'Formación técnica para la atención integral de la primera infancia.',
                'requisitos' => 'Bachiller',
                'duracion_meses' => 18,
                'red_id' => 4,
                'nivel_formacion_id' => 1,
                'modalidad' => 'Presencial',
                'jornada' => 'Diurna',
                'titulo_otorgado' => 'Técnico en Atención Integral a la Primera Infancia',
                'codigo_snies' => null,
                'registro_calidad' => null,
                'fecha_registro' => now(),
                'fecha_actualizacion' => now(),
                'estado' => 'Activo',
                'observaciones' => null,
                'centro_id' => 1,
                'cupos' => 30,
                'municipio_id' => 1, // Málaga
            ],
            [
                'nombre' => 'Cosmetología y Estética Integral',
                'numero_ficha' => '3410528',
                'descripcion' => 'Formación técnica en servicios estéticos integrales.',
                'requisitos' => 'Bachiller',
                'duracion_meses' => 18,
                'red_id' => 5,
                'nivel_formacion_id' => 1,
                'modalidad' => 'Presencial',
                'jornada' => 'Diurna',
                'titulo_otorgado' => 'Técnico en Cosmetología y Estética Integral',
                'codigo_snies' => null,
                'registro_calidad' => null,
                'fecha_registro' => now(),
                'fecha_actualizacion' => now(),
                'estado' => 'Activo',
                'observaciones' => null,
                'centro_id' => 1,
                'cupos' => 30,
                'municipio_id' => 1, // Málaga
            ],
            [
                'nombre' => 'Ejecución de Programas Deportivos',
                'numero_ficha' => '3410546',
                'descripcion' => 'Formación técnica en ejecución y apoyo de programas deportivos.',
                'requisitos' => 'Bachiller',
                'duracion_meses' => 18,
                'red_id' => 4,
                'nivel_formacion_id' => 1,
                'modalidad' => 'Presencial',
                'jornada' => 'Diurna',
                'titulo_otorgado' => 'Técnico en Ejecución de Programas Deportivos',
                'codigo_snies' => null,
                'registro_calidad' => null,
                'fecha_registro' => now(),
                'fecha_actualizacion' => now(),
                'estado' => 'Activo',
                'observaciones' => null,
                'centro_id' => 1,
                'cupos' => 30,
                'municipio_id' => 3, // Cepitanejo
            ],

            /* ================= TECNÓLOGO ================= */
            [
                'nombre' => 'Actividad Física',
                'numero_ficha' => '3410548',
                'descripcion' => 'Formación tecnológica en actividad física y entrenamiento.',
                'requisitos' => 'Bachiller',
                'duracion_meses' => 24,
                'red_id' => 4,
                'nivel_formacion_id' => 2,
                'modalidad' => 'Presencial',
                'jornada' => 'Diurna',
                'titulo_otorgado' => 'Tecnólogo en Actividad Física',
                'codigo_snies' => '109612',
                'registro_calidad' => null,
                'fecha_registro' => now(),
                'fecha_actualizacion' => now(),
                'estado' => 'Activo',
                'observaciones' => null,
                'centro_id' => 1,
                'cupos' => 30,
                'municipio_id' => 1, // Málaga
            ],
            [
                'nombre' => 'Gestión Administrativa',
                'numero_ficha' => '3410568',
                'descripcion' => 'Formación tecnológica en procesos administrativos.',
                'requisitos' => 'Bachiller',
                'duracion_meses' => 24,
                'red_id' => 1,
                'nivel_formacion_id' => 2,
                'modalidad' => 'Presencial',
                'jornada' => 'Diurna',
                'titulo_otorgado' => 'Tecnólogo en Gestión Administrativa',
                'codigo_snies' => '109141',
                'registro_calidad' => null,
                'fecha_registro' => now(),
                'fecha_actualizacion' => now(),
                'estado' => 'Activo',
                'observaciones' => null,
                'centro_id' => 1,
                'cupos' => 30,
                'municipio_id' => 1, // Málaga
            ],
            [
                'nombre' => 'Análisis y Desarrollo de Software',
                'numero_ficha' => '3410551',
                'descripcion' => 'Formación tecnológica en desarrollo de software.',
                'requisitos' => 'Bachiller',
                'duracion_meses' => 24,
                'red_id' => 3,
                'nivel_formacion_id' => 2,
                'modalidad' => 'Presencial',
                'jornada' => 'Diurna',
                'titulo_otorgado' => 'Tecnólogo en Análisis y Desarrollo de Software',
                'codigo_snies' => '110595',
                'registro_calidad' => null,
                'fecha_registro' => now(),
                'fecha_actualizacion' => now(),
                'estado' => 'Activo',
                'observaciones' => null,
                'centro_id' => 1,
                'cupos' => 30,
                'municipio_id' => 1, // Málaga
            ],
        ];

        foreach ($programas as $programa) {
            Programa::create($programa);
        }
    }
}
