<?php

$filePath = __DIR__ . '/docs/BaseDeDatosDos.md';
$contenido = file_get_contents($filePath);
$lineas = explode("\n", $contenido);

$cambios_contador = 0;
$resultado = [];

foreach ($lineas as $linea) {
    // Procesar solo si tiene datos (múltiples tabuladores)
    if (substr_count($linea, "\t") >= 5) {
        $campos = explode("\t", $linea);
        
        if (isset($campos[4]) && isset($campos[5])) {
            $programa = $campos[4];
            $ficha = trim($campos[5]);
            
            // Convertir a mayúsculas manteniendo acentos
            $prog_upper = mb_strtoupper($programa);
            
            // Si la ficha es 1000999...
            if ($ficha === '1000999') {
                // Cambiar a 3410558 si contiene "GESTION" y "CONTABLE"
                // O si contiene "CONTABILIZACION"
                if ((strpos($prog_upper, 'GESTI') !== false && strpos($prog_upper, 'CONTABLE') !== false) ||
                    (strpos($prog_upper, 'CONTABILIZACI') !== false)) {
                    
                    $campos[5] = '3410558';
                    $cambios_contador++;
                }
                // NO cambiar si es PELUQUERIA, MANTENIMIENTO, MOTOS
            }
        }
        
        $resultado[] = implode("\t", $campos);
    } else {
        $resultado[] = $linea;
    }
}

file_put_contents($filePath, implode("\n", $resultado));

echo "✅ Unificación finalizada:\n";
echo "   Total registros actualizados: $cambios_contador\n";
echo "   Gestión Contable: 1000999 → 3410558\n";
echo "   PELUQUERIA, MANTENIMIENTO, MOTOS: 1000999 (preservado)\n";
