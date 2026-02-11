<?php
/**
 * Script para asignar fichas a BaseDeDatosDos.md
 * Utiliza mapeo V2 con reglas especiales
 */

// Mapeo de programas a fichas con reglas
$mapeoFichas = [
    // Programas oficiales (coincidencia exacta)
    'Análisis y Desarrollo de Software' => '3410551',
    'Cosmetología y Estética Integral' => '3410528',
    'Dibujo Arquitectónico - FIC' => '3410525',
    'Gestión Administrativa' => '3410568',
    'Actividad Física' => '3410548',
    'Levantamientos Topográficos y Georreferenciación' => '3410569',
    'Gestión Contable y de Información Financiera' => '3410558',
    'Coordinación en Sistemas Integrados de Gestión' => '3410564',
    'Procesos de Panadería' => '3410523',
    'Atención Integral a la Primera Infancia' => '3410527',
    
    // Variantes conocidas
    'Topografía' => '3410569',
    'Topgrafia' => '3410569',
    'Tpogafía' => '3410569',
    'Topogrfía' => '3410569',
    'Levantamiéntos Topográficos y Georeferenciación' => '3410569',
    'levantamiento topografico' => '3410569',
    
    // Variantes de programas
    'Dibujo Arquitectonico' => '3410525',
    'dibujo arquitectónico' => '3410525',
    'dibujo arqutectonico' => '3410525',
    'dibujo arquitectonico' => '3410525',
    
    // Primera infancia
    'primera infancia' => '3410527',
    'Primera infancia' => '3410527',
    'atención integral a la pimera infancia' => '3410527',
    'Atención Integral a La Primera Infancia' => '3410527',
    'atencion integral a la primera infancia' => '3410527',
    
    // ADSO
    'adso' => '3410551',
    'ADSO' => '3410551',
    'Adso' => '3410551',
    'Analisis Y Diseño De Software' => '3410551',
    'analisis y desarrollo de software' => '3410551',
    
    // Coordinación sistemas
    'Coordinacion en sistemas integrados de gestion' => '3410564',
    'coordinacion de sistemas' => '3410564',
    'coordinacion en sistemas integrados de gestion' => '3410564',
    'cordinacion de sistemas integrados de gestion' => '3410564',
    'Coordinacion en sistemas integrados de gestion' => '3410564',
    
    // Gestión
    'GESTION EMPRESARIAL' => '3410558', // Usar GC&IF como alternativa
    'gestion administrativa' => '3410568',
    'GEstion administrativa' => '3410568',
    'gestion Administrativa' => '3410568',
    'GESTION ADMINISTRATIVA' => '3410568',
    'getion administrativa' => '3410568',
    'administracion de empresas' => '3410558', // Alternativa
    
    // Panadería
    'PANDERIA' => '3410523',
    'Panadería' => '3410523',
    'panaderia' => '3410523',
    
    // Otros programas no oficiales (fichas genéricas)
    'MANTENIMIENTO DE MOTOS Y MOTOCARROS' => '1000001',
    'MANTENIMIENTOS DE MOTOS Y MOTOCARROS' => '1000001',
    'Enfermería' => '1000002',
    'ENERMERIA' => '1000002',
    'PROCESAMIENTO DE CARNES' => '1000003',
    'produccion ganadera' => '1000004',
    'GESTION DE LA PRODUCCION AGRICOLA' => '1000005',
    'CONSTRUCCION EN EDIFICACIONES' => '1000006',
    'COCINA' => '1000007',
    'CURSO DE CUIDADOR' => '1000008',
    'CULTIVOS AGRICOLAS' => '1000012',
    'SALUD OCUPACIONAL' => '1000013',
    'INGLES' => '1000014',
    'SISTEMAS' => '1000015',
    
    // Variantes con typos
    'GESTIO A LA PRIMERA INFANCA' => '3410527', // Regla especial para corregir
    'constuccio' => '1000006', // Construcción con typo
    'costruccion/electricidad' => '1000006',
    'construccion/electricidad' => '1000006',
];

// Leer archivo BaseDeDatosDos.md
$file = 'c:\\Users\\AdminSena\\Documents\\SoeSoftware2\\docs\\BaseDeDatosDos.md';
$contenido = file_get_contents($file);
$lineas = explode("\n", $contenido);

$nuevasLineas = [];
$estadisticas = [
    'fichas_oficiales' => 0,
    'fichas_genericas' => 0,
    'sin_programa' => 0,
    'total' => 0,
    'detalles_programas' => []
];

// Procesar cada línea
foreach ($lineas as $idx => $linea) {
    // Saltar línea de encabezado
    if ($idx === 0) {
        $nuevasLineas[] = $linea;
        continue;
    }
    
    // Saltar líneas vacías
    if (trim($linea) === '') {
        $nuevasLineas[] = $linea;
        continue;
    }
    
    // Parsear campos separados por tab
    $campos = explode("\t", $linea);
    
    if (count($campos) >= 5) {
        $nombre = isset($campos[0]) ? trim($campos[0]) : '';
        $tipoDoc = isset($campos[1]) ? trim($campos[1]) : '';
        $numDoc = isset($campos[2]) ? trim($campos[2]) : '';
        $telefono = isset($campos[3]) ? trim($campos[3]) : '';
        $programa = isset($campos[4]) ? trim($campos[4]) : '';
        $correo = isset($campos[5]) ? trim($campos[5]) : '';
        $novedad = isset($campos[6]) ? trim($campos[6]) : '';
        
        $ficha = '';
        
        // Buscar ficha si hay programa
        if (!empty($programa) && $programa !== 'null') {
            // Búsqueda exacta primero
            if (array_key_exists($programa, $mapeoFichas)) {
                $ficha = $mapeoFichas[$programa];
            } else {
                // Búsqueda case-insensitive y parcial
                $programaLower = strtolower(trim($programa));
                $found = false;
                
                foreach ($mapeoFichas as $key => $valor) {
                    $keyLower = strtolower($key);
                    
                    // Coincidencia exacta insensible a mayúsculas
                    if ($keyLower === $programaLower) {
                        $ficha = $valor;
                        $found = true;
                        break;
                    }
                    
                    // Búsqueda parcial (contiene)
                    if (strpos($programaLower, $keyLower) !== false || 
                        strpos($keyLower, $programaLower) !== false) {
                        $ficha = $valor;
                        $found = true;
                        break;
                    }
                }
                
                // Si no se encontró, asignar genérica
                if (!$found) {
                    $ficha = '1000999'; // Genérica desconocida
                }
            }
        } else {
            $ficha = 'SIN_PROGRAMA';
        }
        
        // Actualizar estadísticas
        $estadisticas['total']++;
        if (strpos($ficha, '1000') === 0) {
            $estadisticas['fichas_genericas']++;
        } elseif (strpos($ficha, '3410') === 0) {
            $estadisticas['fichas_oficiales']++;
        } else {
            $estadisticas['sin_programa']++;
        }
        
        // Registrar detalle
        if (!isset($estadisticas['detalles_programas'][$programa])) {
            $estadisticas['detalles_programas'][$programa] = [
                'ficha' => $ficha,
                'cantidad' => 0
            ];
        }
        $estadisticas['detalles_programas'][$programa]['cantidad']++;
        
        // Reconstruir línea con ficha
        $nuevasLineas[] = implode("\t", [
            $nombre,
            $tipoDoc,
            $numDoc,
            $telefono,
            $programa,
            $ficha,
            $correo,
            $novedad
        ]);
    } else {
        $nuevasLineas[] = $linea;
    }
}

// Guardar archivo actualizado
$nuevoContenido = implode("\n", $nuevasLineas);
file_put_contents($file, $nuevoContenido);

// Crear backup
$timestamp = date('Y-m-d_H-i-s');
$backup = "c:\\Users\\AdminSena\\Documents\\SoeSoftware2\\docs\\BaseDeDatosDos.backup.$timestamp.md";
copy($file, $backup);

echo "✅ Archivo actualizado: BaseDeDatosDos.md\n";
echo "📦 Backup creado: BaseDeDatosDos.backup.$timestamp.md\n\n";

echo "📊 ESTADÍSTICAS DE ASIGNACIÓN:\n";
echo "==================================\n";
echo "Total de registros: " . $estadisticas['total'] . "\n";
echo "Fichas oficiales (3410XXX): " . $estadisticas['fichas_oficiales'] . " (" . 
    round(($estadisticas['fichas_oficiales'] / $estadisticas['total']) * 100, 1) . "%)\n";
echo "Fichas genéricas (1000XXX): " . $estadisticas['fichas_genericas'] . " (" . 
    round(($estadisticas['fichas_genericas'] / $estadisticas['total']) * 100, 1) . "%)\n";
echo "Sin programa: " . $estadisticas['sin_programa'] . "\n\n";

echo "📋 DETALLE POR PROGRAMA:\n";
echo "==================================\n";
ksort($estadisticas['detalles_programas']);
foreach ($estadisticas['detalles_programas'] as $programa => $info) {
    echo str_pad($programa, 60) . " | Ficha: " . $info['ficha'] . " | Cantidad: " . $info['cantidad'] . "\n";
}

echo "\n✅ Proceso completado exitosamente\n";
?>
