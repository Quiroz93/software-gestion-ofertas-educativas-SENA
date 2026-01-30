<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Programa;
use App\Models\Instructor;
use App\Models\Inscripcion;
use Illuminate\Database\Seeder;

class InscripcionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Obtener el primer usuario (o crear uno de prueba)
        $usuario = User::first();
        
        if (!$usuario) {
            echo "No hay usuarios en la base de datos. Cree al menos un usuario primero.\n";
            return;
        }

        // Obtener programas e instructores
        $programas = Programa::limit(3)->get();
        $instructor = Instructor::first();

        if ($programas->isEmpty()) {
            echo "No hay programas en la base de datos. Cree al menos un programa primero.\n";
            return;
        }

        // Crear inscripciones de ejemplo
        foreach ($programas as $index => $programa) {
            $estado = match($index) {
                0 => 'activo',
                1 => 'finalizado',
                2 => 'retirado',
                default => 'activo'
            };

            $fechaInscripcion = now()->subMonths($index * 3);
            $fechaRetiro = $estado === 'retirado' ? now()->subMonth() : null;

            Inscripcion::create([
                'user_id' => $usuario->id,
                'programa_id' => $programa->id,
                'instructor_id' => $instructor?->id,
                'fecha_inscripcion' => $fechaInscripcion,
                'fecha_retiro' => $fechaRetiro,
                'estado' => $estado,
                'observaciones' => $estado === 'retirado' 
                    ? 'Retirado por motivos personales' 
                    : ($estado === 'finalizado' ? 'Programa finalizado exitosamente' : null),
            ]);
        }

        echo "Inscripciones de ejemplo creadas exitosamente.\n";
    }
}
