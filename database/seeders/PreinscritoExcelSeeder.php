<?php

namespace Database\Seeders;

use App\Models\Preinscrito;
use App\Models\Programa;
use App\Models\PreinscritoRechazado;
use App\Models\Red;
use App\Models\NivelFormacion;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class PreinscritoExcelSeeder extends Seeder
{
    public function run(): void
    {
        // Limpiar tablas relacionadas antes de reimportar
        Schema::disableForeignKeyConstraints();
        DB::table('novedades_preinscritos')->truncate();
        DB::table('consolidacion_preinscritos_detalles')->truncate();
        DB::table('consolidaciones_preinscritos')->truncate();
        DB::table('preinscritos_rechazados')->truncate();
        DB::table('preinscritos')->truncate();
        Schema::enableForeignKeyConstraints();

        // Leer datos del archivo base_datos_preinscritos.md (tab-delimitado)
        $filePath = base_path('base_datos_preinscritos.md');
        $raw = file_get_contents($filePath);
        $lines = preg_split("/\R/u", (string) $raw);
        
        $normalizePrograma = function (?string $nombre): string {
            $value = Str::ascii((string) $nombre);
            $value = strtoupper(trim($value));
            $value = preg_replace('/\s+/', ' ', $value);
            return $value;
        };

        // Obtener programas existentes
        $programas = Programa::all();
        $programasIndex = [];
        foreach ($programas as $programa) {
            $programasIndex[$normalizePrograma($programa->nombre)] = $programa;
        }
        $programasById = $programas->keyBy('id');

        $defaultProgram = $programas->first();
        $defaultRedId = $defaultProgram?->red_id ?? Red::query()->value('id');
        $defaultNivelId = $defaultProgram?->nivel_formacion_id ?? NivelFormacion::query()->value('id');

        $count = 0;
        $skipped = 0;
        $rechazados = 0;
        $tipoDocumentoInvalidos = 0;
        $tipoDocumentoPermitidos = ['cc', 'ti', 'ce', 'ppt', 'pa', 'pep', 'nit'];
        $documentosProcesados = [];

        $registrarRechazado = function (array $row, int $index, string $motivo) use (&$rechazados) {
            $nombreCompleto = $row[0] ?? null;
            $tipoDoc = $row[1] ?? null;
            $numeroDoc = $row[2] ?? null;
            $telefono = $row[3] ?? null;
            $programa = $row[4] ?? null;
            $correo = $row[6] ?? null;
            if (($correo === '' || $correo === null) && isset($row[7]) && str_contains((string) $row[7], '@')) {
                $correo = $row[7];
            }

            PreinscritoRechazado::create([
                'nombre_completo' => $nombreCompleto,
                'tipo_documento' => $tipoDoc ? strtolower(trim((string) $tipoDoc)) : null,
                'numero_documento' => $numeroDoc ? (string) $numeroDoc : null,
                'telefono' => $telefono ? (string) $telefono : null,
                'programa' => $programa ? (string) $programa : null,
                'correo' => $correo ? (string) $correo : null,
                'motivo' => $motivo,
                'fila_excel' => $index + 1,
                'datos_json' => json_encode($row, JSON_UNESCAPED_UNICODE),
                'created_by' => 1,
            ]);
            $rechazados++;
        };

        foreach ($lines as $index => $line) {
            // Saltar header y filas vacías
            if ($index === 0 || trim((string) $line) === '') {
                continue;
            }

            $row = array_map('trim', explode("\t", (string) $line));

            if (empty(array_filter($row, fn($v) => $v !== '' && $v !== null))) {
                continue;
            }

            $nombreCompleto = $row[0] ?? null;
            $tipoDoc = $row[1] ?? null;
            $numeroDoc = $row[2] ?? null;
            $telefono = $row[3] ?? null;
            $programaNombre = $row[4] ?? null;
            $numeroFicha = $row[5] ?? null;
            $correo = $row[6] ?? null;
            $comentario = $row[7] ?? null;

            if (($correo === '' || $correo === null) && isset($row[7]) && str_contains((string) $row[7], '@')) {
                $correo = $row[7];
                $comentario = $row[8] ?? null;
            }

            // Validar que tenga al menos nombre y documento
            if (empty($nombreCompleto) || empty($numeroDoc)) {
                $skipped++;
                continue;
            }

            $numeroDocumentoKey = preg_replace('/\D+/', '', (string) $numeroDoc);
            if ($numeroDocumentoKey === '') {
                $skipped++;
                continue;
            }

            // Detectar duplicados dentro del Excel
            if (isset($documentosProcesados[$numeroDocumentoKey])) {
                $registrarRechazado($row, $index, 'documento_duplicado_excel');
                $skipped++;
                continue;
            }
            $documentosProcesados[$numeroDocumentoKey] = true;

            // Separar nombres y apellidos
            $partes = explode(' ', trim($nombreCompleto), 3);
            $nombres = $partes[0] ?? '';
            $apellidos = isset($partes[1]) ? implode(' ', array_slice($partes, 1)) : '';

            // Normalizar tipo de documento
            $tipoDocumento = strtolower(trim((string) $tipoDoc));
            if (!in_array($tipoDocumento, $tipoDocumentoPermitidos, true)) {
                $tipoDocumento = 'cc';
                $tipoDocumentoInvalidos++;
            }

            // Si no hay teléfono, usar valor por defecto
            $celularPrincipal = $telefono ?: '3000000000';
            $celularAlternativo = null;
            if (is_string($celularPrincipal) && str_contains($celularPrincipal, '/')) {
                $partesCel = array_values(array_filter(array_map('trim', explode('/', $celularPrincipal))));
                $celularPrincipal = $partesCel[0] ?? '3000000000';
                $celularAlternativo = $partesCel[1] ?? null;
            }
            $celularPrincipal = preg_replace('/\D+/', '', (string) $celularPrincipal) ?: '3000000000';
            if ($celularAlternativo) {
                $celularAlternativo = preg_replace('/\D+/', '', (string) $celularAlternativo) ?: null;
            }

            // Si no hay correo, generar uno único basado en documento
            $correoPrincipal = $correo ?: 'preinscrito.' . $numeroDoc . '@sinregistro.com';

            // Buscar programa
            $programaId = null;
            $programaNombreLimpio = trim((string) $programaNombre);
            $numeroFichaValue = preg_replace('/\D+/', '', (string) $numeroFicha);
            if ($numeroFichaValue !== '' && isset($programasById[(int) $numeroFichaValue])) {
                $programaId = (int) $numeroFichaValue;
            }

            if (!$programaId && $programaNombreLimpio !== '') {
                $programaKey = $normalizePrograma($programaNombreLimpio);
                $programa = $programasIndex[$programaKey] ?? null;
                if ($programa) {
                    $programaId = $programa->id;
                }
            }

            if (!$programaId && $defaultProgram) {
                $programaId = $defaultProgram->id;
                // Se deja por defecto el primer programa configurado
            }

            try {
                if (Preinscrito::where('numero_documento', $numeroDocumentoKey)->exists()) {
                    $registrarRechazado($row, $index, 'documento_duplicado_db');
                    $skipped++;
                    continue;
                }
                Preinscrito::create([
                    'nombres' => $nombres,
                    'apellidos' => $apellidos,
                    'tipo_documento' => $tipoDocumento,
                    'numero_documento' => $numeroDocumentoKey,
                    'celular_principal' => (string)$celularPrincipal,
                    'celular_alternativo' => $celularAlternativo,
                    'correo_principal' => $correoPrincipal,
                    'correo_alternativo' => null,
                    'programa_id' => $programaId,
                    'estado' => 'por_inscribir',
                    'comentarios' => $comentario ?: 'Importado desde base_datos_preinscritos.md',
                    'created_by' => 1,
                    'updated_by' => 1,
                ]);
                $count++;
            } catch (\Exception $e) {
                // Solo mostrar el primer error de cada tipo para no llenar la consola
                if ($skipped < 5) {
                    $this->command->warn("Error en fila {$index}: " . Str::limit($e->getMessage(), 100));
                }
                $skipped++;
            }
        }

        $this->command->info("✓ {$count} preinscritos importados exitosamente desde base_datos_preinscritos.md.");
        if ($skipped > 0) {
            $this->command->warn("⚠ {$skipped} registros omitidos (duplicados o datos faltantes).");
        }
        if ($tipoDocumentoInvalidos > 0) {
            $this->command->warn("⚠ {$tipoDocumentoInvalidos} registros con tipo_documento inválido fueron normalizados a 'cc'.");
        }
        if ($rechazados > 0) {
            $this->command->warn("⚠ {$rechazados} registros enviados a preinscritos_rechazados por duplicados de documento.");
        }
    }
}
