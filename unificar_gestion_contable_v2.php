<?php

/**
 * Script para unificar Gestión Contable y Contabilización
 */

$filePath = __DIR__ . '/docs/BaseDeDatosDos.md';
$contenido = file_get_contents($filePath);
$lineas = explode("\n", $contenido);

$cambios = 0;
$resultado = [];

foreach ($lineas as $linea) {
    if (empty(trim($linea))) {
        $resultado[] = $linea;
        continue;
    }
    
    // Procesar solo líneas de datos (tienen al menos 6 tabuladores)
    if (substr_count($linea, "\t") >= 5) {
        $campos = explode("\t", $linea);
        
        if (isset($campos[4]) && isset($campos[5])) {
            $programa = strtoupper($campos[4]);
            $ficha = trim($campos[5]);
            
            // Cambiar 1000999 a 3410558 para GESTIÓN/GESTION CONTABLE y CONTABILIZACIÓN/CONTABILIZACION
            if ($ficha === '1000999') {
                // Remover caracteres especiales para comparación
                $prog_clean = str_replace(['ó', 'é', 'í'], ['o', 'e', 'i'], $programa);
                
                // Si es Gestión Contable o Contabilización (NO PELUQUERIA, NO MANTENIMIENTO)
                if ((strpos($prog_clean, 'GESTION') !== false && strpos($prog_clean, 'CONTABLE') !== false) ||
                    strpos($prog_clean, 'CONTABILIZACION') !== false) {
                    
                    // Pero NO cambiar si es PELUQUERIA, MANTENIMIENTO, MOTO
                    if (strpos($prog_clean, 'PELUQUER') === false && 
                        strpos($prog_clean, 'MANTENIMIENTO') === false &&
                        strpos($prog_clean, 'MOTO') === false) {
                        
                        $campos[5] = '3410558';
                        $cambios++;
                    }
                }
                // También cambiar errores tipográficos de Actividad Física
                else if (strpos($prog_clean, 'ACTTIVIDAD') !== false || strpos($prog_clean, 'ACTIVIDA FISICA') !== false) {
                    $campos[5] = '3410548';
                    $cambios++;
                }
            }
        }
        
        $resultado[] = implode("\t", $campos);
    } else {
        $resultado[] = $linea;
    }
}

// Escribir resultado
file_put_contents($filePath, implode("\n", $resultado));

echo "✅ Unificación completada:\n";
echo "   Total registros actualizados: $cambios\n";
echo "   Ficha 1000999 → 3410558 para Gestión Contable/Contabilización\n";
echo "   Ficha 1000999 → 3410548 para Actividad Física (errores tipográficos)\n";
echo "   Ficha 1000999 preservada para: PELUQUERIA, MANTENIMIENTO, MOTOS\n";
