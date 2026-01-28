<?php

namespace Database\Seeders;

use App\Models\Competencia;
use Illuminate\Database\Seeder;

class CompetenciaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $competencias = [
            [
                'nombre' => 'Diseño e Implementación de Soluciones',
                'descripcion' => 'Capacidad para diseñar e implementar soluciones tecnológicas.'
            ],
            [
                'nombre' => 'Desarrollo de Software',
                'descripcion' => 'Habilidad en programación y desarrollo de aplicaciones.'
            ],
            [
                'nombre' => 'Administración de Bases de Datos',
                'descripcion' => 'Gestión y administración de sistemas de base de datos.'
            ],
            [
                'nombre' => 'Gestión Empresarial',
                'descripcion' => 'Competencias en gestión y administración empresarial.'
            ],
            [
                'nombre' => 'Comunicación Efectiva',
                'descripcion' => 'Habilidades de comunicación verbal y escrita.'
            ],
            [
                'nombre' => 'Trabajo en Equipo',
                'descripcion' => 'Capacidad para trabajar colaborativamente en grupos.'
            ],
            [
                'nombre' => 'Liderazgo',
                'descripcion' => 'Competencias de liderazgo y toma de decisiones.'
            ],
            [
                'nombre' => 'Pensamiento Crítico',
                'descripcion' => 'Análisis y resolución de problemas complejos.'
            ]
        ];

        foreach ($competencias as $competencia) {
            Competencia::create($competencia);
        }
    }
}
