<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Programa;
use App\Models\Instructor;
use App\Models\Inscripcion;
use Illuminate\Database\Seeder;
use Illuminate\Database\Query\Builder;

class InscripcionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * 
     * Crea inscripciones realistas para testing:
     * - 1 inscripción ACTIVA por usuario aprendiz
     * - 1 inscripción FINALIZADA por usuario aprendiz
     * - 1 inscripción RETIRADA por usuario aprendiz
     */
    public function run(): void
    {
        // Obtener todos los usuarios con rol 'aprendiz'
        $usuariosAprendices = User::role('aprendiz')->get();
        
        if ($usuariosAprendices->isEmpty()) {
            $this->command->warn('No hay usuarios con rol "aprendiz". Cree usuarios primero.');
            return;
        }

        // Obtener programas e instructores disponibles
        $programas = Programa::limit(10)->get();
        $instructores = Instructor::limit(5)->get();

        if ($programas->isEmpty()) {
            $this->command->warn('No hay programas en la base de datos.');
            return;
        }

        $this->command->info('Creando inscripciones de prueba...');

        $contador = 0;
        
        // Crear inscripciones para cada usuario aprendiz
        foreach ($usuariosAprendices as $user) {
            
            // 1. Inscripción ACTIVA
            if ($programas->isNotEmpty()) {
                $programa = $programas->random();
                $instructor = $instructores->isNotEmpty() ? $instructores->random() : null;

                // Verificar que no exista duplicada
                if (!$this->inscripcionExiste($user->id, $programa->id, 'activo')) {
                    Inscripcion::create([
                        'user_id' => $user->id,
                        'programa_id' => $programa->id,
                        'instructor_id' => $instructor?->id,
                        'fecha_inscripcion' => now()->subMonths(2)->toDateString(),
                        'estado' => 'activo',
                        'observaciones' => 'Interesado en desarrollar competencias en esta área.',
                    ]);
                    $contador++;
                }
            }

            // 2. Inscripción FINALIZADA
            if ($programas->count() > 1) {
                $programa = $programas->where('id', '!=', $programas->random()->id)->random();
                $instructor = $instructores->isNotEmpty() ? $instructores->random() : null;

                if (!$this->inscripcionExiste($user->id, $programa->id, 'finalizado')) {
                    Inscripcion::create([
                        'user_id' => $user->id,
                        'programa_id' => $programa->id,
                        'instructor_id' => $instructor?->id,
                        'fecha_inscripcion' => now()->subMonths(6)->toDateString(),
                        'estado' => 'finalizado',
                        'observaciones' => 'Programa completado satisfactoriamente.',
                    ]);
                    $contador++;
                }
            }

            // 3. Inscripción RETIRADA
            if ($programas->count() > 2) {
                $programa = $programas->random();
                $instructor = $instructores->isNotEmpty() ? $instructores->random() : null;

                if (!$this->inscripcionExiste($user->id, $programa->id, 'retirado')) {
                    Inscripcion::create([
                        'user_id' => $user->id,
                        'programa_id' => $programa->id,
                        'instructor_id' => $instructor?->id,
                        'fecha_inscripcion' => now()->subMonths(4)->toDateString(),
                        'fecha_retiro' => now()->subMonth()->toDateString(),
                        'estado' => 'retirado',
                        'observaciones' => 'Retirado por cambio de disponibilidad laboral.',
                    ]);
                    $contador++;
                }
            }
        }

        $this->command->info("✅ Se crearon {$contador} inscripciones de prueba exitosamente.");
    }

    /**
     * Verificar si una inscripción ya existe
     */
    private function inscripcionExiste(int $userId, int $programaId, string $estado): bool
    {
        return Inscripcion::where('user_id', $userId)
            ->where('programa_id', $programaId)
            ->where('estado', $estado)
            ->exists();
    }
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
