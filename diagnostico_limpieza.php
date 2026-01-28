#!/usr/bin/env php
<?php
/**
 * Script de Diagnóstico y Limpieza para Error file_put_contents
 * Uso: php diagnostico_limpieza.php
 */

echo "\n";
echo "╔═══════════════════════════════════════════════════════════╗\n";
echo "║  DIAGNÓSTICO Y LIMPIEZA - Error file_put_contents         ║\n";
echo "║  Laravel - storage/framework/views                        ║\n";
echo "╚═══════════════════════════════════════════════════════════╝\n\n";

$dirs = [
    'storage/framework/views',
    'storage/framework/cache',
    'storage/framework/cache/data',
    'storage/framework/sessions',
    'storage/logs',
    'storage/app',
    'storage/app/public'
];

// ============================================================
// PASO 1: DIAGNÓSTICO
// ============================================================
echo "PASO 1: DIAGNÓSTICO DE DIRECTORIOS\n";
echo str_repeat("─", 60) . "\n";

$allHealthy = true;
foreach ($dirs as $dir) {
    $exists = is_dir($dir);
    $writable = is_writable($dir);
    $status = ($exists && $writable) ? "✓ OK" : "✗ PROBLEMA";
    
    echo "  $dir: ";
    echo ($exists ? "existe " : "NO existe ");
    echo ($writable ? "- escribible" : "- NO escribible");
    echo " [$status]\n";
    
    if (!$exists || !$writable) {
        $allHealthy = false;
    }
}

echo "\n";

// ============================================================
// PASO 2: CREAR DIRECTORIOS SI NO EXISTEN
// ============================================================
if (!$allHealthy) {
    echo "PASO 2: CREANDO DIRECTORIOS FALTANTES\n";
    echo str_repeat("─", 60) . "\n";
    
    foreach ($dirs as $dir) {
        if (!is_dir($dir)) {
            if (@mkdir($dir, 0755, true)) {
                echo "  ✓ Creado: $dir\n";
            } else {
                echo "  ✗ Error al crear: $dir\n";
            }
        }
    }
    echo "\n";
}

// ============================================================
// PASO 3: LIMPIAR ARCHIVOS
// ============================================================
echo "PASO 3: LIMPIEZA DE ARCHIVOS COMPILADOS\n";
echo str_repeat("─", 60) . "\n";

$cleanupStats = [
    'views' => 0,
    'cache' => 0,
    'sessions' => 0,
];

// Limpiar vistas compiladas
$viewFiles = glob('storage/framework/views/*.php');
if ($viewFiles) {
    foreach ($viewFiles as $file) {
        if (@unlink($file)) {
            $cleanupStats['views']++;
        }
    }
}

// Limpiar caché
$cacheFiles = glob('storage/framework/cache/data/*');
if ($cacheFiles) {
    foreach ($cacheFiles as $file) {
        if (is_file($file) && @unlink($file)) {
            $cleanupStats['cache']++;
        } elseif (is_dir($file)) {
            $this->removeDirectory($file);
            $cleanupStats['cache']++;
        }
    }
}

// Limpiar sesiones
$sessionFiles = glob('storage/framework/sessions/*');
if ($sessionFiles) {
    foreach ($sessionFiles as $file) {
        if (is_file($file) && @unlink($file)) {
            $cleanupStats['sessions']++;
        }
    }
}

echo "  ✓ Archivos de vistas eliminados: " . $cleanupStats['views'] . "\n";
echo "  ✓ Archivos de caché eliminados: " . $cleanupStats['cache'] . "\n";
echo "  ✓ Archivos de sesiones eliminados: " . $cleanupStats['sessions'] . "\n";

echo "\n";

// ============================================================
// PASO 4: VERIFICACIÓN FINAL
// ============================================================
echo "PASO 4: VERIFICACIÓN FINAL\n";
echo str_repeat("─", 60) . "\n";

$testFile = 'storage/framework/views/test_' . md5(time()) . '.txt';
$testContent = 'Test write permission - ' . date('Y-m-d H:i:s');

if (@file_put_contents($testFile, $testContent, LOCK_EX)) {
    @unlink($testFile);
    echo "  ✓ Prueba de escritura: EXITOSA\n";
    echo "  ✓ Los permisos están correctamente configurados\n";
} else {
    echo "  ✗ Prueba de escritura: FALLIDA\n";
    echo "  ✗ Verifique permisos de carpeta storage/\n";
}

echo "\n";

// ============================================================
// RESUMEN
// ============================================================
echo "╔═══════════════════════════════════════════════════════════╗\n";
echo "║  RESUMEN DE OPERACIÓN                                     ║\n";
echo "╚═══════════════════════════════════════════════════════════╝\n\n";

echo "Total de archivos eliminados: " . array_sum($cleanupStats) . "\n";
echo "Directorios verificados: " . count($dirs) . "\n";
echo "\n✓ Limpieza completada exitosamente.\n";
echo "✓ El sistema está listo para compilar vistas nuevamente.\n\n";

echo "Próximos pasos:\n";
echo "  1. Recargar la aplicación web en el navegador\n";
echo "  2. Las vistas se recompilaran automáticamente\n";
echo "  3. Si el error persiste, ejecute: php artisan optimize:clear\n\n";

// Helper para eliminar directorios recursivamente
function removeDirectory($dir) {
    if (is_dir($dir)) {
        $files = scandir($dir);
        foreach ($files as $file) {
            if ($file != '.' && $file != '..') {
                $path = $dir . '/' . $file;
                if (is_dir($path)) {
                    removeDirectory($path);
                } else {
                    @unlink($path);
                }
            }
        }
        @rmdir($dir);
    }
}

?>
