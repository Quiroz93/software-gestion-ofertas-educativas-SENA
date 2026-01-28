<?php

namespace Database\Seeders;

use App\Models\Instructor;
use Illuminate\Database\Seeder;

class InstructorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $instructores = [
            [
                'nombre' => 'Juan',
                'apellidos' => 'García Rodríguez',
                'perfil_profesional' => 'Ingeniero de Sistemas con especialización en desarrollo web y bases de datos.',
                'experiencia' => 'Más de 10 años en desarrollo de software y educación técnica en SENA.',
                'correo' => 'juan.garcia@sena.edu.co'
            ],
            [
                'nombre' => 'María',
                'apellidos' => 'López Martínez',
                'perfil_profesional' => 'Administradora de Empresas especializada en gestión empresarial y finanzas.',
                'experiencia' => 'Experiencia en sector privado y educación con 8 años en SENA.',
                'correo' => 'maria.lopez@sena.edu.co'
            ],
            [
                'nombre' => 'Carlos',
                'apellidos' => 'Pérez Hernández',
                'perfil_profesional' => 'Técnico Electrónico especializado en automatización y control industrial.',
                'experiencia' => 'Más de 12 años en industria manufacturera y educación técnica.',
                'correo' => 'carlos.perez@sena.edu.co'
            ],
            [
                'nombre' => 'Sandra',
                'apellidos' => 'Ramírez Gutiérrez',
                'perfil_profesional' => 'Ingeniera Informática con especialización en seguridad de información.',
                'experiencia' => '7 años como desarrolladora y 3 años como instructora en SENA.',
                'correo' => 'sandra.ramirez@sena.edu.co'
            ],
            [
                'nombre' => 'Roberto',
                'apellidos' => 'Mendoza Silva',
                'perfil_profesional' => 'Profesional en Mantenimiento con certificaciones internacionales.',
                'experiencia' => '15 años en mantenimiento industrial y formación técnica.',
                'correo' => 'roberto.mendoza@sena.edu.co'
            ],
            [
                'nombre' => 'Catalina',
                'apellidos' => 'Gómez Vargas',
                'perfil_profesional' => 'Tecnóloga en Sistemas especializada en programación mobile.',
                'experiencia' => '6 años en desarrollo de aplicaciones móviles.',
                'correo' => 'catalina.gomez@sena.edu.co'
            ]
        ];

        foreach ($instructores as $instructor) {
            Instructor::create($instructor);
        }
    }
}
