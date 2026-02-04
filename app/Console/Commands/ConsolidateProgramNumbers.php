<?php

namespace App\Console\Commands;

use App\Models\Programa;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class ConsolidateProgramNumbers extends Command
{
    protected $signature = 'programs:consolidate-numbers';
    protected $description = 'Consolida números de ficha basándose en la comparación de nombres de programas';

    public function handle()
    {
        // Programas con números de ficha definidos del ProgramaSeeder
        $programasDefinidos = [
            'PROCESOS DE PANADERIA' => '3410523',
            'DIBUJO ARQUITECTONICO - FIC' => '3410525',
            'ATENCION INTEGRAL A LA PRIMERA INFANCIA' => '3410527',
            'COSMETOLOGIA Y ESTETICA INTEGRAL' => '3410528',
            'GESTION CONTABLE Y DE INFORMACION FINANCIERA' => '3410558',
            'EJECUCION DE PROGRAMAS DEPORTIVOS' => '3410546',
            'ACTIVIDAD FISICA' => '3410548',
            'GESTION ADMINISTRATIVA' => '3410568',
            'ANALISIS Y DESARROLLO DE SOFTWARE' => '3410551',
        ];

        $normalizePrograma = function (?string $nombre): string {
            $value = Str::ascii((string) $nombre);
            $value = strtoupper(trim($value));
            $value = preg_replace('/\s+/', ' ', $value);
            return $value;
        };

        $programasActualizados = 0;
        $programasGenerico = 0;
        $proximoNumeroGenerico = 1000001;

        // Obtener todos los programas sin número de ficha
        $programas = Programa::whereNull('numero_ficha')
            ->orWhere('numero_ficha', '')
            ->orderBy('nombre')
            ->get();

        $this->info("Procesando " . $programas->count() . " programas sin número de ficha...\n");

        foreach ($programas as $programa) {
            $nombreNormalizado = $normalizePrograma($programa->nombre);
            $numeroAsignado = null;

            // Buscar coincidencia exacta en programas definidos
            if (isset($programasDefinidos[$nombreNormalizado])) {
                $numeroAsignado = $programasDefinidos[$nombreNormalizado];
                $this->line("✓ {$programa->nombre} → {$numeroAsignado}");
            } else {
                // Buscar coincidencia parcial (Si contiene palabra clave)
                $palabrasClave = [
                    'PANADERIA' => '3410523',
                    'DIBUJO' => '3410525',
                    'PRIMERA INFANCIA' => '3410527',
                    'COSMETOLOGIA' => '3410528',
                    'COSMETOLOGÍA' => '3410528',
                    'CONTABLE' => '3410558',
                    'DEPORTIVO' => '3410546',
                    'ACTIVIDAD FISICA' => '3410548',
                    'ACTIVIDAD FÍSICA' => '3410548',
                    'ADMINISTRATIVA' => '3410568',
                    'SOFTWARE' => '3410551',
                    'ANALISIS' => '3410551',
                    'DESARROLLO' => '3410551',
                ];

                foreach ($palabrasClave as $palabra => $numero) {
                    if (str_contains($nombreNormalizado, $palabra)) {
                        $numeroAsignado = $numero;
                        $this->line("⚠ {$programa->nombre} → {$numeroAsignado} (parcial)");
                        break;
                    }
                }
            }

            // Si no encontró coincidencia, asignar número genérico
            if (!$numeroAsignado) {
                $numeroAsignado = (string)$proximoNumeroGenerico;
                $proximoNumeroGenerico++;
                $programasGenerico++;
                $this->line("○ {$programa->nombre} → {$numeroAsignado} (genérico)");
            }

            // Actualizar el programa
            $programa->update(['numero_ficha' => $numeroAsignado]);
            $programasActualizados++;
        }

        $this->newLine();
        $this->info("✓ {$programasActualizados} programas actualizados");
        $this->warn("⚠ {$programasGenerico} programas con número genérico (1000001+)");
    }
}
