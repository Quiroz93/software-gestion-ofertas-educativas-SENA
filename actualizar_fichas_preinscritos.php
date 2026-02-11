<?php

// Cargar el mapeo generado
$mapeo = json_decode(file_get_contents('mapeo_programas_fichas.json'), true);

// Leer archivo de preinscritos
$filePath = 'docs/base_datos_preinscritos.md';
$content = file_get_contents($filePath);
$lines = explode("\n", $content);

// Array para las líneas actualizadas
$lineasActualizadas = [];
$estadisticas = [
    'actualizados' => 0,
    'sin_cambio' => 0,
    'errores' => 0
];

echo "╔══════════════════════════════════════════════════════════════════════════╗\n";
echo "║  ACTUALIZACIÓN DE FICHAS EN BASE DE DATOS                                ║\n";
echo "╚══════════════════════════════════════════════════════════════════════════╝\n\n";

foreach ($lines as $i => $line) {
    // Mantener la cabecera sin cambios
    if ($i === 0) {
        $lineasActualizadas[] = $line;
        continue;
    }
    
    // Si la línea está vacía, mantenerla
    if (trim($line) === '') {
        $lineasActualizadas[] = $line;
        continue;
    }
    
    $columns = explode("\t", $line);
    
    // Si no tiene suficientes columnas, mantener sin cambios
    if (count($columns) < 6) {
        $lineasActualizadas[] = $line;
        $estadisticas['sin_cambio']++;
        continue;
    }
    
    // Extraer datos
    $nombre = trim($columns[0]);
    $programa = trim($columns[4]);
    $fichaActual = trim($columns[5]);
    
    // Buscar la ficha correcta en el mapeo
    if (isset($mapeo[$programa])) {
        $nuevaFicha = $mapeo[$programa]['ficha'];
        
        // Actualizar la columna de ficha
        $columns[5] = $nuevaFicha;
        
        // Reconstruir la línea
        $lineaActualizada = implode("\t", $columns);
        $lineasActualizadas[] = $lineaActualizada;
        
        // Mostrar cambio solo si es diferente
        if ($fichaActual !== $nuevaFicha) {
            echo sprintf("%-50s: %-10s -> %-10s\n", 
                substr($nombre, 0, 47), 
                ($fichaActual ?: 'Sin ficha'), 
                $nuevaFicha
            );
            $estadisticas['actualizados']++;
        } else {
            $estadisticas['sin_cambio']++;
        }
    } else {
        // Si no se encuentra en el mapeo, mantener sin cambios
        $lineasActualizadas[] = $line;
        $estadisticas['errores']++;
        echo "⚠️  Programa no encontrado en mapeo: $programa (preinscrito: $nombre)\n";
    }
}

// Guardar el archivo actualizado
$nuevoContenido = implode("\n", $lineasActualizadas);
file_put_contents($filePath, $nuevoContenido);

echo "\n╔══════════════════════════════════════════════════════════════════════════╗\n";
echo "║  ESTADÍSTICAS DE ACTUALIZACIÓN                                           ║\n";
echo "╠══════════════════════════════════════════════════════════════════════════╣\n";
echo sprintf("║  Registros actualizados: %-48s║\n", $estadisticas['actualizados']);
echo sprintf("║  Registros sin cambio: %-50s║\n", $estadisticas['sin_cambio']);
echo sprintf("║  Registros con errores: %-49s║\n", $estadisticas['errores']);
echo sprintf("║  Total de líneas procesadas: %-43s║\n", count($lines));
echo "╚══════════════════════════════════════════════════════════════════════════╝\n\n";

echo "✅ Archivo 'docs/base_datos_preinscritos.md' actualizado exitosamente\n\n";

// Generar backup
$backupFile = 'docs/base_datos_preinscritos.backup.' . date('Y-m-d_H-i-s') . '.md';
file_put_contents($backupFile, $content);
echo "✅ Backup generado: $backupFile\n";
