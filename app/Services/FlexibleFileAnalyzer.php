<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

/**
 * Analizador flexible de archivos Excel para consolidación
 * No depende del nombre del archivo, solo de su estructura interna
 */
class FlexibleFileAnalyzer
{
    /**
     * Analiza un archivo y retorna su estructura completa
     */
    public static function analyze(array $rows, string $nombreArchivo = ''): array
    {
        Log::info('Iniciando análisis flexible de archivo', [
            'nombre' => $nombreArchivo,
            'total_filas' => count($rows),
        ]);

        // 1. Detectar índice de fila de encabezados
        $headerIndex = self::detectHeaderRow($rows);
        
        // 2. Detectar metadata (filas antes del header)
        $metadata = self::extractMetadataFlexible($rows, $headerIndex);
        
        // 3. Mapear columnas detectadas
        $columnsMap = self::mapColumns($rows, $headerIndex);
        
        // 4. Extraer datos (SOLO UNA MUESTRA para preview)
        $allData = self::extractData($rows, $headerIndex, $columnsMap);
        $totalRegistros = count($allData);
        
        // Solo guardar los primeros 10 registros como muestra (para preview y validación)
        $dataSample = array_slice($allData, 0, 10);
        
        $result = [
            'nombre_archivo' => $nombreArchivo,
            'header_index' => $headerIndex,
            'metadata' => $metadata,
            'columns_map' => $columnsMap,
            'columns_detected' => array_keys($columnsMap),
            'total_columns' => count($columnsMap),
            'data' => $dataSample,  // Solo muestra
            'total_registros' => $totalRegistros,  // Total real
        ];
        
        Log::info('Análisis completado', [
            'header_index' => $headerIndex,
            'columnas_detectadas' => count($columnsMap),
            'registros_totales' => $totalRegistros,
            'muestra_guardada' => count($dataSample),
        ]);
        
        return $result;
    }

    /**
     * Detecta la fila de encabezados buscando características típicas:
     * - Mayor cantidad de celdas no vacías
     * - Presencia de palabras clave (nombre, documento, correo, etc.)
     * - Tipo de dato: texto vs números
     */
    private static function detectHeaderRow(array $rows): int
    {
        $maxScore = 0;
        $bestIndex = 0;
        
        // Palabras clave que típicamente aparecen en headers
        $keywords = [
            'nombre', 'apellido', 'documento', 'cedula', 'cc', 'ti',
            'correo', 'email', 'telefono', 'celular', 'movil', 'fijo',
            'estado', 'ficha', 'programa', 'tipo', 'fecha', 'nis',
            'prueba', 'resultado', 'municipio', 'regional', 'sede',
        ];
        
        foreach ($rows as $index => $row) {
            if ($index > 50) break; // Solo buscar en las primeras 50 filas
            
            $score = 0;
            $nonEmptyCells = 0;
            $textCells = 0;
            
            foreach ($row as $cell) {
                if ($cell === null || trim((string)$cell) === '') continue;
                
                $nonEmptyCells++;
                $cellStr = strtolower(trim((string)$cell));
                
                // Es texto (no número puro)
                if (!is_numeric($cell)) {
                    $textCells++;
                }
                
                // Contiene palabras clave
                foreach ($keywords as $keyword) {
                    if (stripos($cellStr, $keyword) !== false) {
                        $score += 10;
                    }
                }
                
                // Longitud típica de header (5-30 caracteres)
                $len = strlen($cellStr);
                if ($len >= 5 && $len <= 30) {
                    $score += 2;
                }
            }
            
            // Bonus por tener muchas celdas de texto no vacías
            $score += $nonEmptyCells * 3;
            $score += $textCells * 2;
            
            if ($score > $maxScore) {
                $maxScore = $score;
                $bestIndex = $index;
            }
        }
        
        Log::info('Header detectado', [
            'index' => $bestIndex,
            'score' => $maxScore,
        ]);
        
        return $bestIndex;
    }

    /**
     * Extrae metadata de las filas anteriores al header
     */
    private static function extractMetadataFlexible(array $rows, int $headerIndex): array
    {
        $metadata = [];
        
        // Buscar pares clave-valor en filas antes del header
        for ($i = 0; $i < $headerIndex; $i++) {
            $row = $rows[$i] ?? [];
            
            // Típicamente metadata viene en formato: [Etiqueta, Valor]
            $label = trim((string)($row[0] ?? ''));
            $value = trim((string)($row[1] ?? ''));
            
            if ($label && $value) {
                $key = self::normalizeMetadataKey($label);
                $metadata[$key] = $value;
            }
        }
        
        return $metadata;
    }

    /**
     * Mapea columnas del archivo a nombres estándar
     */
    private static function mapColumns(array $rows, int $headerIndex): array
    {
        $headerRow = $rows[$headerIndex] ?? [];
        $columnsMap = [];
        
        // Mapeo de variaciones de nombres a columna estándar
        $standardMapping = [
            'tipo_documento' => ['tipo documento', 'tipo_doc', 'tipo doc', 'tipodoc', 'tipo', 'tipo de documento', 'tipo_de_documento'],
            'numero_documento' => ['numero documento', 'numero_documento', 'documento', 'cedula', 'cc', 'numero', 'numero de documento', 'identificacion', 'numero_doc', 'doc'],
            'nombre_completo' => ['nombre completo', 'nombre_completo', 'nombres', 'nombre', 'apellidos', 'nombres y apellidos', 'nombres apellidos', 'nombre y apellidos'],
            'nombres' => ['nombres'],
            'apellidos' => ['apellidos'],
            'correo_electronico' => ['correo electronico', 'correo_electronico', 'correo', 'email', 'e-mail', 'mail', 'correo electrónico'],
            'telefono_fijo' => ['telefono fijo', 'telefono_fijo', 'tel_fijo', 'fijo', 'tel fijo', 'telefono', 'teléfono fijo', 'telefono fijo sistema', 'tel', 'phone', 'phone number'],
            'telefono_movil' => ['telefono movil', 'telefono_movil', 'tel_movil', 'celular', 'movil', 'cel', 'telefono celular', 'teléfono móvil', 'teléfono celular', 'telefono movil sistema', 'mobile'],
            'estado' => ['estado', 'estado registro', 'estado_registro', 'estado de registro'],
            'codigo_ficha' => ['codigo ficha', 'codigo_ficha', 'ficha', 'cod ficha', 'numero ficha', 'codigo_de_ficha'],
            'nombre_programa' => ['nombre programa', 'nombre_programa', 'programa', 'nombre del programa', 'programa nombre'],
            'nis' => ['nis', 'n.i.s', 'nro nis'],
            'tipo_prueba' => ['tipo prueba', 'tipo_prueba', 'prueba tipo'],
            'resultado_prueba' => ['resultado prueba', 'resultado_prueba', 'resultado', 'prueba resultado'],
            'fecha_cargue' => ['fecha cargue', 'fecha_cargue', 'fecha de cargue', 'fecha carga', 'fecha cargue sistema', 'fecha_cargue_sistema'],
            'estado_prueba' => ['estado prueba', 'estado_prueba', 'prueba estado', 'estado de prueba'],
            'motivo_prueba' => ['motivo prueba', 'motivo_prueba', 'motivo', 'razon prueba', 'motivo de prueba'],
            'fecha_prueba' => ['fecha prueba', 'fecha_prueba', 'fecha de la prueba', 'fecha de prueba', 'fecha de la prueba sistema', 'fecha_prueba_sistema', 'fecha realización prueba'],
            'acceso_preferente' => ['acceso preferente', 'acceso_preferente', 'acceso preferencial'],
            'digito' => ['digito', 'dígito', 'digito verificador'],
            'dia_pico_placa' => ['dia pico placa', 'dia_pico_placa', 'pico y placa', 'pico placa'],
            'observaciones' => ['observaciones', 'observacion', 'notas', 'nota', 'comentarios', 'comentario', 'novedad', 'novedades'],
        ];
        
        foreach ($headerRow as $colIndex => $cellValue) {
            $cellNormalized = self::normalizeColumnName($cellValue);
            
            if (empty($cellNormalized)) continue;
            
            // Buscar coincidencia en mapeo estándar
            $standardName = null;
            foreach ($standardMapping as $standard => $variations) {
                foreach ($variations as $variation) {
                    if ($cellNormalized === self::normalizeColumnName($variation)) {
                        $standardName = $standard;
                        break 2;
                    }
                }
            }
            
            // Si no encuentra mapeo, intentar inferir por posición y contenido
            if (!$standardName) {
                $standardName = self::inferColumnType($rows, $headerIndex, $colIndex, $cellNormalized);
            }
            
            if ($standardName) {
                $columnsMap[$standardName] = $colIndex;
            }
        }
        
        return $columnsMap;
    }

    /**
     * Intenta inferir el tipo de columna analizando su contenido
     */
    private static function inferColumnType(array $rows, int $headerIndex, int $colIndex, string $headerText): ?string
    {
        // Tomar muestra de 10 registros para análisis
        $sample = [];
        for ($i = $headerIndex + 1; $i < min($headerIndex + 11, count($rows)); $i++) {
            $value = $rows[$i][$colIndex] ?? null;
            if ($value !== null && trim((string)$value) !== '') {
                $sample[] = trim((string)$value);
            }
        }
        
        if (empty($sample)) return null;
        
        // Análisis de patrones
        $emailCount = 0;
        $phoneCount = 0;
        $documentCount = 0;
        $nameCount = 0;
        $numberCount = 0;
        
        foreach ($sample as $value) {
            // Email
            if (filter_var($value, FILTER_VALIDATE_EMAIL)) {
                $emailCount++;
            }
            
            // Teléfono (7-10 dígitos)
            if (preg_match('/^\d{7,10}$/', $value)) {
                $phoneCount++;
            }
            
            // Documento (5-15 dígitos)
            if (preg_match('/^\d{5,15}$/', $value)) {
                $documentCount++;
            }
            
            // Nombre (contiene letras y espacios)
            if (preg_match('/^[a-záéíóúñ\s]+$/iu', $value)) {
                $nameCount++;
            }
            
            // Número puro
            if (is_numeric($value)) {
                $numberCount++;
            }
        }
        
        $total = count($sample);
        
        // Determinar tipo por mayoría (>70%)
        if ($emailCount / $total > 0.7) return 'correo_electronico';
        if ($phoneCount / $total > 0.7) return 'telefono_movil';
        if ($documentCount / $total > 0.7) return 'numero_documento';
        if ($nameCount / $total > 0.7) return 'nombre_completo';
        
        return null;
    }

    /**
     * Extrae datos de las filas posteriores al header
     * NOTA: Ahora público para permitir re-extracción desde archivos temporales
     */
    public static function extractData(array $rows, int $headerIndex, array $columnsMap): array
    {
        $data = [];
        
        for ($i = $headerIndex + 1; $i < count($rows); $i++) {
            $row = $rows[$i] ?? [];
            $record = [];
            
            // Mapear cada columna detectada
            foreach ($columnsMap as $standardName => $colIndex) {
                $record[$standardName] = $row[$colIndex] ?? null;
            }
            
            // Solo agregar si tiene al menos un campo no vacío
            $hasData = false;
            foreach ($record as $value) {
                if ($value !== null && trim((string)$value) !== '') {
                    $hasData = true;
                    break;
                }
            }
            
            if ($hasData) {
                $data[] = $record;
            }
        }
        
        return $data;
    }

    /**
     * Normaliza nombre de columna para comparación
     */
    private static function normalizeColumnName($value): string
    {
        $str = trim(strtolower((string)$value));
        
        // Eliminar acentos y caracteres especiales comunes
        $replacements = [
            'á' => 'a', 'é' => 'e', 'í' => 'i', 'ó' => 'o', 'ú' => 'u',
            'ñ' => 'n', 'ü' => 'u',
            'à' => 'a', 'è' => 'e', 'ì' => 'i', 'ò' => 'o', 'ù' => 'u',
        ];
        
        foreach ($replacements as $from => $to) {
            $str = str_replace($from, $to, $str);
        }
        
        // Eliminar caracteres especiales menos espacio y guión
        $str = preg_replace('/[^a-z0-9\s\-]/', '', $str);
        
        // Normalizar espacios múltiples y guiones
        $str = preg_replace('/[\s\-]+/', ' ', $str);
        
        return trim($str);
    }

    /**
     * Normaliza clave de metadata
     */
    private static function normalizeMetadataKey(string $label): string
    {
        $key = strtolower(trim($label));
        $key = str_replace(' ', '_', $key);
        $key = preg_replace('/[^a-z0-9_]/', '', $key);
        return $key;
    }

    /**
     * Obtiene todas las columnas únicas de múltiples archivos analizados
     */
    public static function getAllColumnsFromAnalysis(array $analysisResults): array
    {
        $allColumns = [];
        
        foreach ($analysisResults as $analysis) {
            $columns = $analysis['columns_detected'] ?? [];
            foreach ($columns as $col) {
                if (!in_array($col, $allColumns)) {
                    $allColumns[] = $col;
                }
            }
        }
        
        return $allColumns;
    }

    /**
     * Genera etiquetas legibles para columnas
     */
    public static function getColumnLabel(string $columnName): string
    {
        $labels = [
            'tipo_documento' => 'Tipo de Documento',
            'numero_documento' => 'Número de Documento',
            'nombre_completo' => 'Nombre Completo',
            'nombres' => 'Nombres',
            'apellidos' => 'Apellidos',
            'correo_electronico' => 'Correo Electrónico',
            'telefono_fijo' => 'Teléfono Fijo',
            'telefono_movil' => 'Teléfono Móvil',
            'estado' => 'Estado',
            'codigo_ficha' => 'Código Ficha',
            'nombre_programa' => 'Nombre Programa',
            'nis' => 'NIS',
            'tipo_prueba' => 'Tipo de Prueba',
            'resultado_prueba' => 'Resultado Prueba',
            'fecha_cargue' => 'Fecha de Cargue',
            'estado_prueba' => 'Estado Prueba',
            'motivo_prueba' => 'Motivo Prueba',
            'fecha_prueba' => 'Fecha de Prueba',
            'acceso_preferente' => 'Acceso Preferente',
            'digito' => 'Dígito',
            'dia_pico_placa' => 'Día Pico y Placa',
            'observaciones' => 'Observaciones',
        ];
        
        return $labels[$columnName] ?? ucwords(str_replace('_', ' ', $columnName));
    }
}
