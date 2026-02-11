<?php
/**
 * Script para generar PreinscritosSeeder desde BaseDeDatosDos.md
 */

// Leer archivo BaseDeDatosDos.md
$file = 'c:\\Users\\AdminSena\\Documents\\SoeSoftware2\\docs\\BaseDeDatosDos.md';
$contenido = file_get_contents($file);
$lineas = explode("\n", $contenido);

// Mapeo de fichas a programa_id (necesitamos obtener estos IDs de la BD)
$fichaAProgramaId = [
    // Fichas oficiales
    '3410551' => 'Análisis y Desarrollo de Software',
    '3410528' => 'Cosmetología y Estética Integral',
    '3410525' => 'Dibujo Arquitectónico - FIC',
    '3410568' => 'Gestión Administrativa',
    '3410548' => 'Actividad Física',
    '3410569' => 'Levantamientos Topográficos y Georreferenciación',
    '3410558' => 'Gestión Contable y de Información Financiera',
    '3410564' => 'Coordinación en Sistemas Integrados de Gestión',
    '3410523' => 'Procesos de Panadería',
    '3410527' => 'Atención Integral a la Primera Infancia',
];

// Enum de tipos de documento válidos
$tiposDocumentoValidos = ['CC', 'TI', 'PPT', 'CE', 'PA'];
$estados = ['Activo', 'Inactivo', 'Pendiente'];

$preinscritos = [];
$estadisticas = [
    'total' => 0,
    'procesados' => 0,
    'con_error' => 0,
    'detalles' => []
];

// Procesar cada línea
foreach ($lineas as $idx => $linea) {
    // Saltar línea de encabezado
    if ($idx === 0 || trim($linea) === '') {
        continue;
    }
    
    // Parsear campos separados por tab
    $campos = explode("\t", $linea);
    
    if (count($campos) >= 6) {
        $estadisticas['total']++;
        
        $nombre = isset($campos[0]) ? trim($campos[0]) : '';
        $tipoDoc = isset($campos[1]) ? trim($campos[1]) : '';
        $numDoc = isset($campos[2]) ? trim($campos[2]) : '';
        $telefono = isset($campos[3]) ? trim($campos[3]) : '';
        $programa = isset($campos[4]) ? trim($campos[4]) : '';
        $ficha = isset($campos[5]) ? trim($campos[5]) : '';
        $correo = isset($campos[6]) ? trim($campos[6]) : '';
        $novedad = isset($campos[7]) ? trim($campos[7]) : '';
        
        // Validaciones
        if (empty($nombre) || empty($tipoDoc) || empty($numDoc)) {
            $estadisticas['con_error']++;
            continue;
        }
        
        // Validar tipo de documento
        if (!in_array($tipoDoc, $tiposDocumentoValidos)) {
            $tipoDoc = 'CC'; // Default
        }
        
        // Separar nombres y apellidos (simple split)
        $partes = explode(' ', $nombre, 2);
        $nombres = $partes[0] ?? '';
        $apellidos = $partes[1] ?? '';
        
        // Asignar programa_id basado en ficha (será actualizado luego)
        $programaId = null;
        $programaNombre = $programa;
        
        // Crear registro de preinscrito
        $preinscrito = [
            'nombres' => $nombres,
            'apellidos' => $apellidos,
            'tipo_documento' => $tipoDoc,
            'numero_documento' => $numDoc,
            'celular_principal' => $telefono,
            'celular_alternativo' => null,
            'correo_principal' => !empty($correo) && $correo !== 'null' ? $correo : null,
            'correo_alternativo' => null,
            'programa_id' => $programaId, // Será actualizado
            'programa_nombre' => $programaNombre,
            'ficha' => $ficha,
            'estado' => 'Activo',
            'comentarios' => !empty($novedad) && $novedad !== 'null' ? $novedad : null,
            'tipo_novedad' => null,
            'novedad_resuelta' => 0,
        ];
        
        $preinscritos[] = $preinscrito;
        $estadisticas['procesados']++;
        
        // Registrar detalle
        if (!isset($estadisticas['detalles'][$programa])) {
            $estadisticas['detalles'][$programa] = ['cantidad' => 0, 'ficha' => $ficha];
        }
        $estadisticas['detalles'][$programa]['cantidad']++;
    }
}

// Generar seeder PHP
$seederCode = <<<'PHP'
<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Programa;
use App\Models\Preinscrito;

class PreinscritorosDosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Obtener mapeo de fichas a programa_id
        $fichasMap = $this->obtenerMapeoFichas();
        
        $preinscritos = [
PHP;

// Agregar datos de preinscritos
foreach ($preinscritos as $idx => $p) {
    $programaId = "null";
    if (isset($fichasMap[$p['ficha']])) {
        $programaId = $fichasMap[$p['ficha']];
    }
    
    $seederCode .= "            [\n";
    $seederCode .= "                'nombres' => '" . addslashes($p['nombres']) . "',\n";
    $seederCode .= "                'apellidos' => '" . addslashes($p['apellidos']) . "',\n";
    $seederCode .= "                'tipo_documento' => '" . $p['tipo_documento'] . "',\n";
    $seederCode .= "                'numero_documento' => '" . $p['numero_documento'] . "',\n";
    $seederCode .= "                'celular_principal' => '" . ($p['celular_principal'] ?? '') . "',\n";
    $seederCode .= "                'correo_principal' => " . ($p['correo_principal'] ? "'" . addslashes($p['correo_principal']) . "'" : "null") . ",\n";
    $seederCode .= "                'programa_id' => " . $programaId . ",\n";
    $seederCode .= "                'estado' => '" . $p['estado'] . "',\n";
    $seederCode .= "                'comentarios' => " . ($p['comentarios'] ? "'" . addslashes($p['comentarios']) . "'" : "null") . ",\n";
    $seederCode .= "                'created_at' => now(),\n";
    $seederCode .= "                'updated_at' => now(),\n";
    $seederCode .= "            ],\n";
}

$seederCode .= <<<'PHP'
        ];
        
        // Insertar preinscritos
        foreach ($preinscritos as $preinscrito) {
            Preinscrito::create($preinscrito);
        }
        
        $this->command->info('✅ BaseDeDatosDos preinscritos sembrados correctamente');
    }
    
    /**
     * Obtener mapeo de fichas a programa_id
     */
    private function obtenerMapeoFichas(): array
    {
        $fichas = [
            '3410551' => 'Análisis y Desarrollo de Software',
            '3410528' => 'Cosmetología y Estética Integral',
            '3410525' => 'Dibujo Arquitectónico - FIC',
            '3410568' => 'Gestión Administrativa',
            '3410548' => 'Actividad Física',
            '3410569' => 'Levantamientos Topográficos y Georreferenciación',
            '3410558' => 'Gestión Contable y de Información Financiera',
            '3410564' => 'Coordinación en Sistemas Integrados de Gestión',
            '3410523' => 'Procesos de Panadería',
            '3410527' => 'Atención Integral a la Primera Infancia',
        ];
        
        $map = [];
        foreach ($fichas as $ficha => $nombre) {
            $programa = Programa::where('numero_ficha', $ficha)->first();
            if ($programa) {
                $map[$ficha] = $programa->id;
            }
        }
        
        return $map;
    }
}
PHP;

// Guardar seeder
$seederPath = 'c:\\Users\\AdminSena\\Documents\\SoeSoftware2\\database\\seeders\\PreinscritorosDosSeeder.php';
file_put_contents($seederPath, $seederCode);

echo "✅ Seeder creado: PreinscritorosDosSeeder.php\n";
echo "📊 ESTADÍSTICAS:\n";
echo "==================================\n";
echo "Total de líneas: " . $estadisticas['total'] . "\n";
echo "Procesados: " . $estadisticas['procesados'] . "\n";
echo "Con error: " . $estadisticas['con_error'] . "\n\n";

echo "📋 DETALLE POR PROGRAMA:\n";
ksort($estadisticas['detalles']);
foreach ($estadisticas['detalles'] as $programa => $info) {
    echo str_pad(substr($programa, 0, 50), 50) . " | Ficha: " . $info['ficha'] . " | Qty: " . $info['cantidad'] . "\n";
}

echo "\n✅ Proceso completado\n";
?>
