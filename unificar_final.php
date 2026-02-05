<?php

/**
 * Script para unificar Gestión Contable y Contabilización
 * Procesa TODOS los registros con 1000999 de Gestión Contable
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
    
    // Procesar solo líneas de datos (contienen tabuladores)
    if (strpos($linea, "\t") !== false && substr_count($linea, "\t") >= 5) {
        $campos = explode("\t", $linea);
        
        if (isset($campos[5])) {
            $ficha = trim($campos[5]);
            
            // Si tiene ficha 1000999, verificar el programa
            if ($ficha === '1000999') {
                $programa = isset($campos[4]) ? strtoupper($campos[4]) : '';
                
                // Limpiar acentos y caracteres especiales
                $prog_clean = str_replace(
                    ['Á','á','É','é','Í','í','Ó','ó','Ú','ú','Ñ','ñ'],
                    ['A','a','E','e','I','i','O','o','U','u','N','n'],
                    $programa
                );
                
                // 1. Cambiar a 3410558 si es Gestión Contable o Contabilización
                if ((strpos($prog_clean, 'GESTION') !== false && strpos($prog_clean, 'CONTABLE') !== false) ||
                    strpos($prog_clean, 'CONTABILIZACION') !== false) {
                    
                    $campos[5] = '3410558';
                    $cambios++;
                }
                // 2. Cambiar a 3410548 si es error tipográfico de Actividad Física
                else if (strpos($prog_clean, 'ACTTIVIDAD') !== false || 
                         strpos($prog_clean, 'ACTIVIDA FISICA') !== false) {
                    
                    $campos[5] = '3410548';
                    $cambios++;
                }
                // 3. Cambiar a 3410528 si es error de Cosmetología
                else if (strpos($prog_clean, 'COSMETOLOG') !== false && 
                         strpos($prog_clean, 'ESTETICA') !== false &&
                         strpos($prog_clean, 'INTEGRAL') !== false) {
                    
                    $campos[5] = '3410528';
                    $cambios++;
                }
                // PRESERVAR para PELUQUERIA, MANTENIMIENTO, MOTOS, ETC
                // (sin cambios)
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
echo "   ✓ Ficha 1000999 → 3410558: Gestión Contable/Contabilización\n";
echo "   ✓ Ficha 1000999 → 3410548: Actividad Física (errores tipográficos)\n";
echo "   ✓ Ficha 1000999 → 3410528: Cosmetología (errores tipográficos)\n";
echo "   ✓ Ficha 1000999 preservada: PELUQUERIA, MANTENIMIENTO, MOTOS\n";
