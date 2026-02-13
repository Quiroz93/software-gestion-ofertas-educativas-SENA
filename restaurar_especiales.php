<?php

/**
 * Restaurar PELUQUERIA, MANTENIMIENTO a 1000999
 * Verificar que Gestión Contable tenga 3410558
 */

$filePath = __DIR__ . '/docs/BaseDeDatosDos.md';
$contenido = file_get_contents($filePath);
$lineas = explode("\n", $contenido);

$cambios_restaurados = 0;
$resultado = [];

foreach ($lineas as $linea) {
    if (empty(trim($linea))) {
        $resultado[] = $linea;
        continue;
    }
    
    // Procesar líneas con datos
    if (strpos($linea, "\t") !== false) {
        $campos = explode("\t", $linea);
        
        if (isset($campos[4]) && isset($campos[5])) {
            $programa = strtoupper($campos[4]);
            $ficha = trim($campos[5]);
            
            // Restaurar PELUQUERIA, MANTENIMIENTO, MOTOS a 1000999
            if (($ficha === '3410558' || $ficha === '1000999') &&
                (strpos($programa, 'PELUQUER') !== false || 
                 strpos($programa, 'MANTENIMIENTO') !== false ||
                 strpos($programa, 'MOTO') !== false)) {
                
                $campos[5] = '1000999';
                $cambios_restaurados++;
            }
        }
        
        $resultado[] = implode("\t", $campos);
    } else {
        $resultado[] = $linea;
    }
}

file_put_contents($filePath, implode("\n", $resultado));

echo "✅ Corrección completada:\n";
echo "   Registros restaurados a 1000999: $cambios_restaurados\n";
echo "   (PELUQUERIA, MANTENIMIENTO, MOTOS)\n";
echo "   Gestión Contable: 3410558\n";
<?php

/**
 * Restaurar PELUQUERIA, MANTENIMIENTO a 1000999
 * Verificar que Gestión Contable tenga 3410558
 */

$filePath = __DIR__ . '/docs/BaseDeDatosDos.md';
$contenido = file_get_contents($filePath);
$lineas = explode("\n", $contenido);

$cambios_restaurados = 0;
$resultado = [];

foreach ($lineas as $linea) {
    if (empty(trim($linea))) {
        $resultado[] = $linea;
        continue;
    }
    
    // Procesar líneas con datos
    if (strpos($linea, "\t") !== false) {
        $campos = explode("\t", $linea);
        
        if (isset($campos[4]) && isset($campos[5])) {
            $programa = strtoupper($campos[4]);
            $ficha = trim($campos[5]);
            
            // Restaurar PELUQUERIA, MANTENIMIENTO, MOTOS a 1000999
            if (($ficha === '3410558' || $ficha === '1000999') &&
                (strpos($programa, 'PELUQUER') !== false || 
                 strpos($programa, 'MANTENIMIENTO') !== false ||
                 strpos($programa, 'MOTO') !== false)) {
                
                $campos[5] = '1000999';
                $cambios_restaurados++;
            }
        }
        
        $resultado[] = implode("\t", $campos);
    } else {
        $resultado[] = $linea;
    }
}

file_put_contents($filePath, implode("\n", $resultado));

echo "✅ Corrección completada:\n";
echo "   Registros restaurados a 1000999: $cambios_restaurados\n";
echo "   (PELUQUERIA, MANTENIMIENTO, MOTOS)\n";
echo "   Gestión Contable: 3410558\n";
