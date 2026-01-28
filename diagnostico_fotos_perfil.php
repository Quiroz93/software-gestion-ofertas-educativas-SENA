#!/usr/bin/env php
<?php
/**
 * Script de Diagnóstico: Fotos de Perfil y Almacenamiento
 * Detecta y reporta problemas con el enlace simbólico public/storage
 */

echo "\n";
echo "╔═══════════════════════════════════════════════════════════╗\n";
echo "║  DIAGNÓSTICO: Sistema de Fotos de Perfil                  ║\n";
echo "║  Enlace Simbólico y Almacenamiento de Archivos            ║\n";
echo "╚═══════════════════════════════════════════════════════════╝\n\n";

$issues = [];
$warnings = [];

// ============================================================
// PASO 1: Verificar estructura de directorios
// ============================================================
echo "PASO 1: VERIFICACIÓN DE DIRECTORIOS\n";
echo str_repeat("─", 60) . "\n";

$dirs = [
    'storage/app/public' => 'Directorio principal de almacenamiento',
    'storage/app/public/profile-photos' => 'Carpeta de fotos de perfil',
    'storage/app/public/media' => 'Carpeta de multimedia',
    'public/storage' => 'Enlace simbólico a storage',
];

foreach ($dirs as $path => $description) {
    $exists = is_dir($path);
    $readable = is_readable($path);
    $writable = is_writable($path);
    
    $status = ($exists && $readable && $writable) ? "✓ OK" : "✗ ERROR";
    echo sprintf("  %-40s %s\n", $path, $status);
    
    if (!$exists) {
        $issues[] = "$path no existe";
    } else {
        if (!$readable) $issues[] = "$path no es legible";
        if (!$writable) $issues[] = "$path no es escribible";
    }
}

echo "\n";

// ============================================================
// PASO 2: Verificar enlace simbólico
// ============================================================
echo "PASO 2: VERIFICACIÓN DEL ENLACE SIMBÓLICO\n";
echo str_repeat("─", 60) . "\n";

if (is_link('public/storage')) {
    $target = readlink('public/storage');
    echo "  ✓ public/storage es un enlace simbólico\n";
    echo "    Destino: " . realpath($target) . "\n";
} else {
    echo "  ✗ public/storage NO es un enlace simbólico\n";
    if (is_dir('public/storage')) {
        echo "    Es un directorio normal (no enlace)\n";
        $warnings[] = "public/storage debería ser un enlace simbólico, no un directorio";
    }
}

echo "\n";

// ============================================================
// PASO 3: Verificar archivos de fotos
// ============================================================
echo "PASO 3: VERIFICACIÓN DE ARCHIVOS DE FOTOS\n";
echo str_repeat("─", 60) . "\n";

$photoPath = 'storage/app/public/profile-photos';
$files = glob($photoPath . '/*');
$imageCount = 0;

if ($files) {
    foreach ($files as $file) {
        if (is_file($file) && preg_match('/\.(jpg|jpeg|png|gif|webp)$/i', $file)) {
            $imageCount++;
            $fileName = basename($file);
            $size = filesize($file);
            $sizeMB = round($size / 1024 / 1024, 2);
            echo "  ✓ Imagen encontrada: $fileName ($sizeMB MB)\n";
        }
    }
}

echo "  Total de imágenes: $imageCount\n";

echo "\n";

// ============================================================
// PASO 4: Prueba de acceso URL
// ============================================================
echo "PASO 4: VERIFICACIÓN DE ACCESO URL\n";
echo str_repeat("─", 60) . "\n";

$appUrl = 'http://localhost:8000';

if ($imageCount > 0) {
    // Obtener la primera imagen como ejemplo
    $photoFiles = glob($photoPath . '/*.{jpg,jpeg,png,gif,webp}', GLOB_BRACE);
    if ($photoFiles) {
        $firstPhoto = basename($photoFiles[0]);
        $url = $appUrl . '/storage/profile-photos/' . $firstPhoto;
        $relativePath = 'public/storage/profile-photos/' . $firstPhoto;
        
        echo "  URL esperada:\n";
        echo "    $url\n\n";
        echo "  Archivo en: $relativePath\n";
        echo "  Existe: " . (file_exists($relativePath) ? "✓ SÍ" : "✗ NO") . "\n";
        
        if (!file_exists($relativePath)) {
            $issues[] = "Archivo de foto no accesible en ruta pública";
        }
    }
}

echo "\n";

// ============================================================
// PASO 5: Verificar configuración de Laravel
// ============================================================
echo "PASO 5: VERIFICACIÓN DE CONFIGURACIÓN\n";
echo str_repeat("─", 60) . "\n";

echo "  Configuración esperada:\n";
echo "    Driver: local\n";
echo "    Root: storage/app/public\n";
echo "    URL: http://localhost:8000/storage\n";

echo "\n";

// ============================================================
// RESULTADO FINAL
// ============================================================
echo "╔═══════════════════════════════════════════════════════════╗\n";
echo "║  RESULTADO DEL DIAGNÓSTICO                                ║\n";
echo "╚═══════════════════════════════════════════════════════════╝\n\n";

if (empty($issues)) {
    echo "✓ SISTEMA FUNCIONANDO CORRECTAMENTE\n";
    echo "  Todas las fotos de perfil deberían cargar sin problemas.\n\n";
} else {
    echo "✗ SE HAN DETECTADO LOS SIGUIENTES PROBLEMAS:\n\n";
    foreach ($issues as $i => $issue) {
        echo "  " . ($i + 1) . ". $issue\n";
    }
    echo "\n";
    echo "SOLUCIÓN RECOMENDADA:\n";
    echo "  Ejecutar: php artisan storage:link\n\n";
}

if (!empty($warnings)) {
    echo "⚠ ADVERTENCIAS:\n\n";
    foreach ($warnings as $i => $warning) {
        echo "  " . ($i + 1) . ". $warning\n";
    }
    echo "\n";
}

// ============================================================
// INFORMACIÓN ÚTIL
// ============================================================
echo "INFORMACIÓN PARA DIAGNOSTICAR PROBLEMAS:\n";
echo str_repeat("─", 60) . "\n";
echo "• Para verificar una foto específica, ingresar en base de datos:\n";
echo "  SELECT id, name, profile_photo_path FROM users\n";
echo "  WHERE profile_photo_path IS NOT NULL LIMIT 5;\n\n";
echo "• Para recrear el enlace simbólico:\n";
echo "  php artisan storage:link\n\n";
echo "• Para verificar permisos en Windows:\n";
echo "  icacls \"storage/app/public\" /T /C\n\n";

echo "═══════════════════════════════════════════════════════════\n\n";

?>
