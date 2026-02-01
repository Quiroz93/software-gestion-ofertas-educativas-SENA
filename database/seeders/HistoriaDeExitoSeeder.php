<?php

namespace Database\Seeders;

use App\Models\HistoriaExito;
use Illuminate\Database\Seeder;

class HistoriaDeExitoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $historias = [
            [
                'nombre' => 'Andrés Felipe López Rodríguez',
                'titulo' => 'Del SENA a Emprendedor Exitoso',
                'descripcion' => 'Andrés completó el programa de Análisis y Desarrollo de Sistemas en 2021. Hoy dirige su propia empresa de desarrollo de software con 5 empleados. Su aplicación móvil ha sido descargada más de 10,000 veces.',
                'año' => 2021,
                'correo' => 'andres.lopez@empresa.com',
                'programa_id' => 8
            ],
            [
                'nombre' => 'Valentina Sánchez García',
                'titulo' => 'Transformación Laboral en el Sector Financiero',
                'descripcion' => 'Valentina estudió Administración de Empresas en SENA y fue contratada inmediatamente por uno de los principales bancos del país. Actualmente es jefa de departamento con equipo a cargo.',
                'año' => 2020,
                'correo' => 'valentina.sanchez@banco.com',
                'programa_id' => 7
            ],
            [
                'nombre' => 'José María Rodríguez Ríos',
                'titulo' => 'Especialista Técnico en Multinacional',
                'descripcion' => 'José María se capacitó en Mantenimiento de Equipos de Cómputo y fue seleccionado por una multinacional tecnológica. Hoy es especialista técnico certificado internacionalmente.',
                'año' => 2019,
                'correo' => 'josemaria.rodriguez@tech.com',
                'programa_id' => 8
            ],
            [
                'nombre' => 'Patricia Martínez Acosta',
                'titulo' => 'Gerenta de Automatización Industrial',
                'descripcion' => 'Patricia fue egresada del programa de Automatización Industrial. Tras trabajar en diferentes empresas manufactureras, ahora es gerenta de automatización en una planta de producción de Medellín.',
                'año' => 2018,
                'correo' => 'patricia.martinez@manufactura.com',
                'programa_id' => 2
            ],
            [
                'nombre' => 'David Vargas Contreras',
                'titulo' => 'Consultor Empresarial Internacional',
                'descripcion' => 'Después de completar estudios técnicos en SENA y complementarlos con inglés técnico, David trabaja como consultor empresarial para empresas internacionales con operaciones en Colombia.',
                'año' => 2022,
                'correo' => 'david.vargas@consulting.com',
                'programa_id' => 7
            ]
        ];

        foreach ($historias as $historia) {
            HistoriaExito::create($historia);
        }
    }
}
