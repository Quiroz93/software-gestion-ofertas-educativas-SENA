<?php

namespace App\Console\Commands;

use App\Models\Programa;
use App\Models\Preinscrito;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class ValidateDataIntegrity extends Command
{
    protected $signature = 'data:validate-integrity';
    protected $description = 'Valida la integridad de datos de programas y preinscritos';

    public function handle()
    {
        $this->info("=== VALIDACIÓN DE INTEGRIDAD DE DATOS ===\n");

        $errores = 0;
        $advertencias = 0;

        // 1. Validar programas sin número de ficha
        $this->line("1. Validando números de ficha...");
        $programasSinFicha = Programa::whereNull('numero_ficha')
            ->orWhere('numero_ficha', '')
            ->count();

        if ($programasSinFicha > 0) {
            $this->error("   ✗ {$programasSinFicha} programas sin número de ficha");
            $errores++;
        } else {
            $this->info("   ✓ Todos los programas tienen número de ficha");
        }

        // 2. Validar duplicados de programas
        $this->line("\n2. Validando duplicados de programas...");
        $duplicados = Programa::selectRaw('nombre, COUNT(*) as total')
            ->groupBy('nombre')
            ->having('total', '>', 1)
            ->count();

        if ($duplicados > 0) {
            $this->error("   ✗ {$duplicados} programas con nombres duplicados");
            $errores++;
            Programa::selectRaw('nombre, COUNT(*) as total, GROUP_CONCAT(id) as ids')
                ->groupBy('nombre')
                ->having('total', '>', 1)
                ->get()
                ->each(function ($programa) {
                    $this->line("     - {$programa->nombre} ({$programa->total} duplicados)");
                });
        } else {
            $this->info("   ✓ No hay duplicados de programas");
        }

        // 3. Validar duplicados de fichas
        $this->line("\n3. Validando números de ficha únicos...");
        $fichasDuplicadas = Programa::selectRaw('numero_ficha, COUNT(*) as total')
            ->groupBy('numero_ficha')
            ->having('total', '>', 1)
            ->count();

        if ($fichasDuplicadas > 0) {
            $this->warn("   ⚠ {$fichasDuplicadas} fichas asignadas a múltiples programas");
            $advertencias++;
            Programa::selectRaw('numero_ficha, COUNT(*) as total, GROUP_CONCAT(nombre) as programas')
                ->groupBy('numero_ficha')
                ->having('total', '>', 1)
                ->get()
                ->each(function ($ficha) {
                    $this->line("     - Ficha {$ficha->numero_ficha}: {$ficha->programas}");
                });
        } else {
            $this->info("   ✓ Todos los números de ficha son únicos");
        }

        // 4. Validar preinscritos sin programa
        $this->line("\n4. Validando preinscritos con programa asignado...");
        $preinscritos = Preinscrito::count();
        $preinscritosSinPrograma = Preinscrito::whereNull('programa_id')
            ->orWhere('programa_id', 0)
            ->count();

        if ($preinscritosSinPrograma > 0) {
            $this->error("   ✗ {$preinscritosSinPrograma} de {$preinscritos} preinscritos sin programa");
            $errores++;
        } else {
            $this->info("   ✓ Todos los {$preinscritos} preinscritos tienen programa asignado");
        }

        // 5. Validar programas sin preinscritos
        $this->line("\n5. Validando programas sin preinscritos...");
        $programasSinPreinscritos = Programa::leftJoin('preinscritos', 'programas.id', '=', 'preinscritos.programa_id')
            ->selectRaw('programas.id, programas.nombre, COUNT(preinscritos.id) as total')
            ->groupBy('programas.id', 'programas.nombre')
            ->having('total', '=', 0)
            ->count();

        if ($programasSinPreinscritos > 0) {
            $this->warn("   ⚠ {$programasSinPreinscritos} programas sin preinscritos asignados");
            $advertencias++;
        } else {
            $this->info("   ✓ Todos los programas tienen al menos un preinscrito");
        }

        // 6. Validar documentos de preinscritos únicos
        $this->line("\n6. Validando números de documento únicos...");
        $documentosDuplicados = Preinscrito::selectRaw('numero_documento, COUNT(*) as total')
            ->groupBy('numero_documento')
            ->having('total', '>', 1)
            ->count();

        if ($documentosDuplicados > 0) {
            $this->error("   ✗ {$documentosDuplicados} números de documento duplicados en preinscritos");
            $errores++;
        } else {
            $this->info("   ✓ Todos los números de documento son únicos");
        }

        // 7. Validar correos principal
        $this->line("\n7. Validando correos electrónicos...");
        $preinscritosySinCorreo = Preinscrito::whereNull('correo_principal')
            ->orWhere('correo_principal', '')
            ->count();

        if ($preinscritosySinCorreo > 0) {
            $this->warn("   ⚠ {$preinscritosySinCorreo} preinscritos sin correo principal");
            $advertencias++;
        } else {
            $this->info("   ✓ Todos los preinscritos tienen correo principal");
        }

        // 8. Validar teléfonos principal
        $this->line("\n8. Validando teléfonos...");
        $preinscritosSinTelefono = Preinscrito::whereNull('celular_principal')
            ->orWhere('celular_principal', '')
            ->count();

        if ($preinscritosSinTelefono > 0) {
            $this->error("   ✗ {$preinscritosSinTelefono} preinscritos sin teléfono principal");
            $errores++;
        } else {
            $this->info("   ✓ Todos los preinscritos tienen teléfono principal");
        }

        // 9. Validar relaciones programa-preinscrito
        $this->line("\n9. Validando relaciones programa-preinscrito...");
        $relacionesInvalidas = Preinscrito::leftJoin('programas', 'preinscritos.programa_id', '=', 'programas.id')
            ->whereNull('programas.id')
            ->count();

        if ($relacionesInvalidas > 0) {
            $this->error("   ✗ {$relacionesInvalidas} preinscritos con referencia de programa inválida");
            $errores++;
        } else {
            $this->info("   ✓ Todas las relaciones programa-preinscrito son válidas");
        }

        // 10. Reporte de programas consolidados
        $this->line("\n10. Reporte de programas consolidados...");
        $programas = Programa::selectRaw('nombre, numero_ficha, COUNT(preinscritos.id) as total_preinscritos')
            ->leftJoin('preinscritos', 'programas.id', '=', 'preinscritos.programa_id')
            ->groupBy('programas.id', 'nombre', 'numero_ficha')
            ->orderBy('total_preinscritos', 'DESC')
            ->get();

        $this->table(
            ['Programa', 'Ficha', 'Preinscritos'],
            $programas->map(fn ($p) => [
                $p->nombre,
                $p->numero_ficha,
                $p->total_preinscritos
            ])->toArray()
        );

        // Resumen final
        $this->newLine();
        $this->info("=== RESUMEN FINAL ===");
        $this->info("Total de programas: " . Programa::count());
        $this->info("Total de preinscritos: " . Preinscrito::count());
        $this->info("Total en rechazados: " . (class_exists('App\Models\PreinscritoRechazado') ? 
            \App\Models\PreinscritoRechazado::count() : '0'));

        $this->newLine();
        if ($errores === 0 && $advertencias === 0) {
            $this->info("✓ ¡VALIDACIÓN EXITOSA! Todos los datos están íntegros y correctamente relacionados.");
        } elseif ($errores === 0) {
            $this->warn("⚠ Validación completada con {$advertencias} advertencia(s) que no impactan integridad.");
        } else {
            $this->error("✗ Se encontraron {$errores} error(es) crítico(s). Revisar detalles arriba.");
        }
    }
}
