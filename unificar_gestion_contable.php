<?php

/**
 * Script para unificar Gestión Contable y Contabilización
 * Cambia todas las fichas 1000999 de Gestión Contable/Contabilización a 3410558
 * Mantiene PELUQUERIA (1000999) intacta
 */

$filePath = __DIR__ . '/docs/BaseDeDatosDos.md';

// Leer archivo
$contenido = file_get_contents($filePath);
$lineas = explode("\n", $contenido);

$cambios = 0;
$resultado = [];

foreach ($lineas as $idx => $linea) {
    // Saltar línea de encabezado y líneas vacías
    if (empty(trim($linea)) || strpos($linea, 'nombre') !== false) {
        $resultado[] = $linea;
        continue;
    }
    
    // Procesar solo líneas con datos (tienen tabulaciones)
    if (substr_count($linea, "\t") >= 5) {
        // Dividir por tabulador
        $campos = explode("\t", $linea);
        
        // El programa está en índice 4, la ficha en índice 5
        $programa = isset($campos[4]) ? strtoupper(trim($campos[4])) : '';
        $ficha = isset($campos[5]) ? trim($campos[5]) : '';
        
        // Debug - mostrar primeras 10 líneas con 1000999
        if ($ficha === '1000999' && $cambios < 3) {
            echo "Línea $idx: '$programa' | Ficha: '$ficha' | Tabuladores: " . substr_count($linea, "\t") . "\n";
        }
        
        // Cambiar 1000999 a 3410558 SOLO para Gestión Contable y Contabilización
        if ($ficha === '1000999') {
            // Verificar que NO sea PELUQUERIA ni MANTENIMIENTO
            $es_peluqueria = strpos($programa, 'PELUQUER') !== false;
            $es_mantenimiento = strpos($programa, 'MANTENIMIENTO') !== false || strpos($programa, 'MOTO') !== false;
            $es_gestion_contable = (strpos($programa, 'GESTION') !== false && strpos($programa, 'CONTABLE') !== false);
            $es_contabilizacion = strpos($programa, 'CONTABILIZACION') !== false;
            
            if (!$es_peluqueria && !$es_mantenimiento && ($es_gestion_contable || $es_contabilizacion)) {
                $campos[5] = '3410558';
                $cambios++;
                if ($cambios <= 3) {
                    echo "  ✓ Cambiado a 3410558\n";
                }
            }
        }
        
        $resultado[] = implode("\t", $campos);
    } else {
        $resultado[] = $linea;
    }
}

// Escribir archivo actualizado
file_put_contents($filePath, implode("\n", $resultado));

echo "✅ Unificación completada:\n";
echo "   Total cambios realizados: $cambios\n";
echo "   Ficha 1000999 (PELUQUERIA, MANTENIMIENTO) preservada: ✓\n";
echo "   Ficha 3410558 (Gestión Contable) asignada: ✓\n";
