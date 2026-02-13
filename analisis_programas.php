<?php

// Programas definidos en ProgramaSeeder.php con sus fichas
$programasSeeder = [
    'Procesos de Panadería' => '3410523',
    'Dibujo Arquitectónico - FIC' => '3410525',
    'Atención Integral a la Primera Infancia' => '3410527',
    'Cosmetología y Estética Integral' => '3410528',
    'Ejecución de Programas Deportivos' => '3410546',
    'Actividad Física' => '3410548',
    'Gestión Administrativa' => '3410568',
    'Análisis y Desarrollo de Software' => '3410551',
    'Levantamientos Topográficos y Georreferenciación' => '3410569',
    'Gestión Contable y de Información Financiera' => '3410558',
    'Coordinación en Sistemas Integrados de Gestión' => '3410564',
];

// Leer archivo de preinscritos
$filePath = 'docs/base_datos_preinscritos.md';
$content = file_get_contents($filePath);
$lines = explode("\n", $content);

// Extraer programas únicos
$programasEncontrados = [];
foreach ($lines as $i => $line) {
    if ($i === 0) continue; // Skip header
    $columns = explode("\t", $line);
    if (count($columns) < 6) continue;
    
    $programa = trim($columns[4]);
    if (!empty($programa) && $programa !== 'programa') {
        $programasEncontrados[$programa] = ($programasEncontrados[$programa] ?? 0) + 1;
    }
}

echo "╔══════════════════════════════════════════════════════════════════════════╗\n";
echo "║  ANÁLISIS COMPARATIVO DE PROGRAMAS                                       ║\n";
echo "╠══════════════════════════════════════════════════════════════════════════╣\n";
echo "║  Total programas en BaseDeDatosPreinscritos.md: " . str_pad(count($programasEncontrados), 25) . "║\n";
echo "║  Total programas en ProgramaSeeder.php: " . str_pad(count($programasSeeder), 33) . "║\n";
echo "╚══════════════════════════════════════════════════════════════════════════╝\n\n";

// Función de normalización
function normalizar($str) {
    $str = mb_strtolower($str, 'UTF-8');
    $str = preg_replace('/[áàäâ]/u', 'a', $str);
    $str = preg_replace('/[éèëê]/u', 'e', $str);
    $str = preg_replace('/[íìïî]/u', 'i', $str);
    $str = preg_replace('/[óòöô]/u', 'o', $str);
    $str = preg_replace('/[úùüû]/u', 'u', $str);
    $str = preg_replace('/[ñ]/u', 'n', $str);
    $str = preg_replace('/\s+/', ' ', $str);
    return trim($str);
}

// Análisis de coincidencias
$coincidentes = [];
$noCoincidentes = [];
$fichasAsignadas = 1000001;

foreach ($programasEncontrados as $progBD => $count) {
    $normalBD = normalizar($progBD);
    $encontrado = false;
    
    foreach ($programasSeeder as $progSeeder => $ficha) {
        $normalSeeder = normalizar($progSeeder);
        
        // Coincidencia exacta o parcial
        if ($normalBD === $normalSeeder || 
            strpos($normalBD, $normalSeeder) !== false ||
            strpos($normalSeeder, $normalBD) !== false) {
            $coincidentes[$progBD] = [
                'ficha' => $ficha,
                'nombre_seeder' => $progSeeder,
                'preinscritos' => $count
            ];
            $encontrado = true;
            break;
        }
    }
    
    // Casos especiales
    if (!$encontrado) {
        if (stripos($progBD, 'topograf') !== false) {
            $coincidentes[$progBD] = [
                'ficha' => '3410569',
                'nombre_seeder' => 'Levantamientos Topográficos y Georreferenciación',
                'preinscritos' => $count
            ];
            $encontrado = true;
        } elseif (stripos($progBD, 'coordinacion') !== false && stripos($progBD, 'sistema') !== false) {
            $coincidentes[$progBD] = [
                'ficha' => '3410564',
                'nombre_seeder' => 'Coordinación en Sistemas Integrados de Gestión',
                'preinscritos' => $count
            ];
            $encontrado = true;
        } elseif (stripos($progBD, 'primera infancia') !== false) {
            $coincidentes[$progBD] = [
                'ficha' => '3410527',
                'nombre_seeder' => 'Atención Integral a la Primera Infancia',
                'preinscritos' => $count
            ];
            $encontrado = true;
        }
    }
    
    if (!$encontrado) {
        $noCoincidentes[$progBD] = [
            'ficha' => str_pad($fichasAsignadas++, 7, '0', STR_PAD_LEFT),
            'preinscritos' => $count
        ];
    }
}

// Mostrar resultados
echo "✅ PROGRAMAS CON FICHA OFICIAL ASIGNADA (" . count($coincidentes) . "):\n";
echo str_repeat("=", 100) . "\n";
foreach ($coincidentes as $progBD => $info) {
    echo sprintf("%-55s -> Ficha: %-10s (%d preinscritos)\n", 
        $progBD, $info['ficha'], $info['preinscritos']);
    echo sprintf("   Coincide con: %s\n\n", $info['nombre_seeder']);
}

echo "\n⚠️  PROGRAMAS SIN COINCIDENCIA - REQUIEREN FICHA GENÉRICA (" . count($noCoincidentes) . "):\n";
echo str_repeat("=", 100) . "\n";
foreach ($noCoincidentes as $progBD => $info) {
    echo sprintf("%-55s -> Ficha genérica: %-10s (%d preinscritos)\n", 
        $progBD, $info['ficha'], $info['preinscritos']);
}

// Generar mapeo completo en formato JSON
$mapeoCompleto = array_merge($coincidentes, $noCoincidentes);
file_put_contents('mapeo_programas_fichas.json', json_encode($mapeoCompleto, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

echo "\n✅ Archivo 'mapeo_programas_fichas.json' generado exitosamente\n\n";

// Estadísticas
echo "╔══════════════════════════════════════════════════════════════════════════╗\n";
echo "║  ESTADÍSTICAS FINALES                                                    ║\n";
echo "╠══════════════════════════════════════════════════════════════════════════╣\n";
echo sprintf("║  Programas con ficha oficial: %-43s║\n", count($coincidentes));
echo sprintf("║  Programas con ficha genérica: %-42s║\n", count($noCoincidentes));
echo sprintf("║  Total de programas únicos: %-45s║\n", count($mapeoCompleto));
echo sprintf("║  Total de preinscritos: %-49s║\n", array_sum(array_column($mapeoCompleto, 'preinscritos')));
echo "╚══════════════════════════════════════════════════════════════════════════╝\n";

