<?php

namespace Database\Seeders;

use App\Models\Preinscrito;
use App\Models\Programa;
use Illuminate\Database\Seeder;

/**
 * Seeder para Preinscritos
 * Crea datos de ejemplo para el módulo de gestión de aprendices preinscritos
 */
class PresritoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Obtener un programa de ejemplo
        $programa = Programa::first();

        if (!$programa) {
            $this->command->warn('No hay programas registrados. Por favor cree un programa primero.');
            return;
        }

        // Datos de ejemplo para preinscritos
        $preinscritos = [
            [
                'nombres' => 'Juan',
                'apellidos' => 'Pérez González',
                'tipo_documento' => 'cc',
                'numero_documento' => '1234567890',
                'celular_principal' => '3001234567',
                'celular_alternativo' => '3187654321',
                'correo_principal' => 'juan.perez@example.com',
                'correo_alternativo' => 'jperez.example@gmail.com',
                'programa_id' => $programa->id,
                'estado' => 'por_inscribir',
                'comentarios' => 'Preinscrito de ejemplo',
                'created_by' => 1,
                'updated_by' => 1,
            ],
            [
                'nombres' => 'María',
                'apellidos' => 'García López',
                'tipo_documento' => 'cc',
                'numero_documento' => '0987654321',
                'celular_principal' => '3009876543',
                'celular_alternativo' => null,
                'correo_principal' => 'maria.garcia@example.com',
                'correo_alternativo' => null,
                'programa_id' => $programa->id,
                'estado' => 'inscrito',
                'comentarios' => 'Preinscrita de ejemplo - Inscrita',
                'created_by' => 1,
                'updated_by' => 1,
            ],
            [
                'nombres' => 'Carlos',
                'apellidos' => 'Rodríguez Martínez',
                'tipo_documento' => 'ti',
                'numero_documento' => '123456',
                'celular_principal' => '3015555555',
                'celular_alternativo' => null,
                'correo_principal' => 'carlos.rodriguez@example.com',
                'correo_alternativo' => 'crodriguez@example.com',
                'programa_id' => $programa->id,
                'estado' => 'con_novedad',
                'comentarios' => 'Con novedad en documentación',
                'created_by' => 1,
                'updated_by' => 1,
            ],
            [
                'nombres' => 'Ana',
                'apellidos' => 'Hernández Vargas',
                'tipo_documento' => 'cc',
                'numero_documento' => '5555555555',
                'celular_principal' => '3026666666',
                'celular_alternativo' => '3187777777',
                'correo_principal' => 'ana.hernandez@example.com',
                'correo_alternativo' => 'ahernandez@example.com',
                'programa_id' => $programa->id,
                'estado' => 'por_inscribir',
                'comentarios' => 'Pendiente de confirmación',
                'created_by' => 1,
                'updated_by' => 1,
            ],
            [
                'nombres' => 'Luis',
                'apellidos' => 'Sánchez Flores',
                'tipo_documento' => 'ce',
                'numero_documento' => 'CE12345678',
                'celular_principal' => '3038888888',
                'celular_alternativo' => null,
                'correo_principal' => 'luis.sanchez@example.com',
                'correo_alternativo' => null,
                'programa_id' => $programa->id,
                'estado' => 'inscrito',
                'comentarios' => 'Cédula de extranjería',
                'created_by' => 1,
                'updated_by' => 1,
            ],
        ];

        foreach ($preinscritos as $presrito) {
            Preinscrito::create($presrito);
        }

        $this->command->info('Preinscritos de ejemplo creados exitosamente.');
    }
}
