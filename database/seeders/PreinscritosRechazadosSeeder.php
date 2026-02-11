<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PreinscritoRechazado;
use App\Models\Preinscrito;
use Illuminate\Support\Facades\DB;

class PreinscritosRechazadosSeeder extends Seeder
{
    public function run(): void
    {
        $file = base_path('archivos de sustentacion/BaseDeDatosDos.md');
        if (!file_exists($file)) {
            $this->command->error('Archivo BaseDeDatosDos.md no encontrado');
            return;
        }
        
        $contenido = file_get_contents($file);
        $lineas = explode("\n", $contenido);
        
        $contador = 0;
        $duplicados_en_archivo = [];
        
        foreach ($lineas as $idx => $linea) {
            if ($idx === 0 || trim($linea) === '') {
                continue;
            }
            
            $campos = explode("\t", $linea);
            
            if (count($campos) < 5) {
                continue;
            }
            
            $nombre = trim($campos[0] ?? '');
            $tipoDoc = strtolower(trim($campos[1] ?? ''));
            $numDoc = trim($campos[2] ?? '');
            $telefono = trim($campos[3] ?? '');
            $programa = trim($campos[4] ?? '');
            $ficha = trim($campos[5] ?? '');
            $correo = trim($campos[6] ?? '') ?: null;
            $novedad = trim($campos[7] ?? '') ?: null;
            
            // Normalizar valores 'null'
            if ($numDoc === 'null') $numDoc = '';
            if ($telefono === 'null') $telefono = null;
            if ($programa === 'null') $programa = '';
            if ($ficha === 'null' || $ficha === 'SIN_PROGRAMA') $ficha = '';
            if ($correo === 'null') $correo = null;
            
            $motivo = null;
            $debeRechazar = false;
            
            // Verificar condiciones de rechazo SOLO para registros NO insertados
            if (empty($nombre) || empty($numDoc)) {
                // Datos incompletos = no se pudo insertar
                $motivo = 'datos_incompletos';
                $debeRechazar = true;
            } elseif (isset($duplicados_en_archivo[$numDoc])) {
                // Duplicado dentro del mismo archivo = solo el primero se insertó
                $motivo = 'documento_duplicado';
                $debeRechazar = true;
            } elseif (empty($ficha) || $ficha === 'SIN_PROGRAMA') {
                // Sin programa asignado = no se pudo insertar
                $motivo = 'sin_programa_asignado';
                $debeRechazar = true;
            }
            
            // Registrar documento para detectar duplicados en el archivo (ANTES de decidir si rechazar)
            if (!empty($numDoc)) {
                if (isset($duplicados_en_archivo[$numDoc])) {
                    // Ya existe en el archivo, marcar como duplicado
                    $debeRechazar = true;
                    $motivo = 'documento_duplicado';
                }
                $duplicados_en_archivo[$numDoc] = true;
            }
            
            if ($debeRechazar) {
                try {
                    PreinscritoRechazado::create([
                        'nombre_completo' => $nombre,
                        'tipo_documento' => $tipoDoc ?: 'cc',
                        'numero_documento' => $numDoc ?: 'SIN_DOCUMENTO_' . ($idx + 1),
                        'telefono' => $telefono,
                        'programa' => $programa ?: 'Sin programa',
                        'correo' => $correo,
                        'motivo' => $motivo,
                        'fila_excel' => $idx + 1,
                        'datos_json' => json_encode(array_values($campos)),
                        'created_by' => null,
                    ]);
                    $contador++;
                } catch (\Exception $e) {
                    $this->command->warn("Error línea " . ($idx + 1) . ": " . $e->getMessage());
                }
            }
        }
        
        $this->command->info("✅ $contador registros rechazados insertados en preinscritos_rechazados");
    }
}
