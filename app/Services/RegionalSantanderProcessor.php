<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;

class RegionalSantanderProcessor
{
    /**
     * Detecta si un archivo es del tipo REGIONAL SANTANDER basándose en su estructura
     */
    public static function detect(array $rows): bool
    {
        // REGIONAL SANTANDER tiene estructura fija con headers en fila 24
        // Buscar el patrón característico
        
        Log::info('RegionalSantanderProcessor::detect iniciado', [
            'total_filas' => count($rows),
            'primera_fila' => $rows[0] ?? [],
        ]);
        
        if (count($rows) < 25) {
            Log::info('Archivo rechazado: menos de 25 filas');
            return false;
        }
        
        // Verificar fila con "NOMBRE REPORTE"
        // Archivo REGIONAL SANTANDER tiene 2 filas vacías al inicio
        // "NOMBRE REPORTE" está en índice 2 (tercera fila)
        $row2 = $rows[2] ?? [];
        if (!is_array($row2) || count($row2) < 2) {
            Log::info('Archivo rechazado: fila índice 2 no válida', ['row2' => $row2]);
            return false;
        }
        
        $nombreReporte = strtoupper(trim((string)($row2[0] ?? '')));
        Log::info('Verificando nombre reporte', [
            'encontrado' => $nombreReporte,
            'esperado' => 'NOMBRE REPORTE',
        ]);
        
        if ($nombreReporte !== 'NOMBRE REPORTE') {
            Log::info('Archivo rechazado: no coincide nombre reporte');
            return false;
        }
        
        // Verificar que exista fila con headers característicos
        // Headers están en índice 24
        $row24 = $rows[24] ?? [];
        if (!is_array($row24) || count($row24) < 10) {
            Log::info('Archivo rechazado: fila índice 24 no válida', [
                'columnas' => count($row24),
                'row24' => array_slice($row24, 0, 5),
            ]);
            return false;
        }
        
        // Buscar headers característicos de REGIONAL SANTANDER
        $headers24 = self::normalizeRow($row24);
        $caracteristicos = ['nis', 'tipo_doc', 'documento', 'nombres', 'apellidos'];
        
        Log::info('Headers normalizados fila 24', [
            'headers' => array_slice($headers24, 0, 10),
            'caracteristicos' => $caracteristicos,
        ]);
        
        $matches = 0;
        foreach ($caracteristicos as $header) {
            if (in_array($header, $headers24)) {
                $matches++;
            }
        }
        
        Log::info('Resultado detección', [
            'matches' => $matches,
            'requeridos' => 3,
            'es_regional' => $matches >= 3,
        ]);
        
        return $matches >= 3;
    }
    
    /**
     * Procesa un archivo REGIONAL SANTANDER y extrae todos los datos
     */
    public static function extractCompleto(array $rows): array
    {
        $metadata = self::extractMetadata($rows);
        $datosRegionales = self::extractDatosRegionales($rows);
        
        return [
            'metadata' => $metadata,
            'datos' => $datosRegionales,
            'tipo' => 'regional_completo',
        ];
    }
    
    /**
     * Procesa un archivo REGIONAL SANTANDER pero extrae solo datos esenciales
     */
    public static function extractEsencial(array $rows): array
    {
        $metadata = self::extractMetadata($rows);
        $datosRegionales = self::extractDatosRegionales($rows);
        
        // Convertir a formato esencial (campos básicos + teléfonos)
        $datosEsenciales = [];
        foreach ($datosRegionales as $dato) {
            $datosEsenciales[] = [
                'tipo_documento' => $dato['tipo_documento'] ?? null,
                'numero_documento' => $dato['numero_documento'] ?? null,
                'nombre_completo' => $dato['nombre_completo'] ?? null,
                'estado' => $dato['estado'] ?? null,
                'codigo_ficha' => $metadata['codigo_ficha'] ?? null,
                'nombre_programa' => $metadata['nombre_programa'] ?? null,
                'telefono_fijo' => $dato['telefono_fijo'] ?? null,
                'telefono_movil' => $dato['telefono_movil'] ?? null,
            ];
        }
        
        return [
            'metadata' => $metadata,
            'datos' => $datosEsenciales,
            'tipo' => 'regional_esencial',
        ];
    }
    
    /**
     * Extrae metadatos del archivo REGIONAL SANTANDER
     */
    private static function extractMetadata(array $rows): array
    {
        $metadata = [
            'nombre_reporte' => null,
            'fecha_reporte' => null,
            'fase' => null,
            'codigo_regional' => null,
            'nombre_regional' => null,
            'codigo_municipio' => null,
            'nombre_municipio' => null,
            'codigo_sede' => null,
            'nombre_sede' => null,
            'codigo_programa' => null,
            'nombre_programa' => null,
            'codigo_ficha' => null,
            'estado_ficha' => null,
            'jornada' => null,
            'nivel_formacion' => null,
            'cupo_ficha' => null,
            'total_inscritos' => null,
        ];
        
        // Mapeo de labels a campos
        $labelMap = [
            'nombre reporte' => 'nombre_reporte',
            'fecha' => 'fecha_reporte',
            'fase' => 'fase',
            'codigo regional' => 'codigo_regional',
            'nombre regional' => 'nombre_regional',
            'codigo municipio' => 'codigo_municipio',
            'nombre municipio' => 'nombre_municipio',
            'codigo sede' => 'codigo_sede',
            'nombre sede' => 'nombre_sede',
            'codigo programa' => 'codigo_programa',
            'denominacion programa' => 'nombre_programa',
            'codigo ficha' => 'codigo_ficha',
            'estado ficha' => 'estado_ficha',
            'jornada' => 'jornada',
            'nivel formacion' => 'nivel_formacion',
            'cupo ficha' => 'cupo_ficha',
            'total inscritos' => 'total_inscritos',
        ];
        
        // Buscar en las primeras 25 filas
        for ($i = 0; $i < min(25, count($rows)); $i++) {
            $row = $rows[$i];
            if (!is_array($row) || count($row) < 2) {
                continue;
            }
            
            $label = strtolower(trim((string)($row[0] ?? '')));
            $value = trim((string)($row[1] ?? ''));
            
            if (empty($label) || empty($value)) {
                continue;
            }
            
            foreach ($labelMap as $buscar => $campo) {
                if (strpos($label, $buscar) !== false) {
                    $metadata[$campo] = $value;
                    break;
                }
            }
        }
        
        return $metadata;
    }
    
    /**
     * Extrae todos los datos de aspirantes del archivo REGIONAL SANTANDER
     */
    private static function extractDatosRegionales(array $rows): array
    {
        // Los headers están en índice 24
        $headerIndex = 24;
        if (!isset($rows[$headerIndex]) || !is_array($rows[$headerIndex])) {
            Log::error('No se encontró fila de headers en índice 24');
            return [];
        }
        
        // Mapear headers a índices
        $headerMap = self::buildHeaderMap($rows[$headerIndex]);
        
        Log::info('Header map construido', ['headerMap' => $headerMap]);
        
        $datos = [];
        
        // Las filas de datos comienzan en fila 25 de Excel (índice 24 en array)
        for ($i = $headerIndex + 1; $i < count($rows); $i++) {
            $row = $rows[$i];
            
            if (!is_array($row) || empty($row[0])) {
                continue;
            }
            
            // Mapear la fila actual
            $mapped = self::mapRow($row, $headerMap);
            
            // Verificar que tenga datos mínimos
            if (!empty($mapped['numero_documento'])) {
                $datos[] = $mapped;
            }
        }
        
        Log::info('Datos regionales extraídos', ['total' => count($datos)]);
        
        return $datos;
    }
    
    /**
     * Construye mapa de índices de columnas basado en headers
     */
    private static function buildHeaderMap(array $headerRow): array
    {
        $aliases = [
            'nis' => ['nis'],
            'tipo_documento' => ['tipo_doc', 'tipo_documento'],
            'numero_documento' => ['documento', 'numero_documento'],
            'nombres' => ['nombres', 'nombre'],
            'apellidos' => ['apellidos'],
            'correo_electronico' => ['correo_e', 'correo_electronico', 'email'],
            'telefono_fijo' => ['tel_fijo', 'telefono_fijo'],
            'telefono_movil' => ['tel_movil', 'telefono_movil'],
            'tipo_prueba' => ['tipo_prueba'],
            'resultado_prueba' => ['resultado_prueba'],
            'fecha_cargue' => ['fecha_cargue'],
            'estado_prueba' => ['estado_prueba'],
            'motivo_prueba' => ['motivo_prueba'],
            'fecha_prueba' => ['fecha_prueba'],
            'acceso_preferente' => ['acceso preferente'],
            'digito' => ['digito'],
            'dia_pico_placa' => ['dia_pico_placa'],
        ];
        
        $map = [];
        foreach ($headerRow as $colIndex => $headerValue) {
            $normalized = self::normalizeString(trim((string)$headerValue));
            
            foreach ($aliases as $field => $possibleValues) {
                foreach ($possibleValues as $value) {
                    if ($normalized === self::normalizeString($value)) {
                        $map[$field] = $colIndex;
                        break 2;
                    }
                }
            }
        }
        
        return $map;
    }
    
    /**
     * Mapea una fila de datos usando headerMap
     */
    private static function mapRow(array $row, array $headerMap): array
    {
        $getCellValue = function($index) use ($row) {
            if ($index === null || !array_key_exists($index, $row)) {
                return null;
            }
            
            $value = $row[$index];
            if ($value === null || $value === '') {
                return null;
            }
            
            return trim((string)$value);
        };
        
        // Combinar nombres y apellidos
        $nombres = $getCellValue($headerMap['nombres'] ?? null);
        $apellidos = $getCellValue($headerMap['apellidos'] ?? null);
        $nombreCompleto = trim(($nombres ?? '') . ' ' . ($apellidos ?? ''));
        
        return [
            'nis' => $getCellValue($headerMap['nis'] ?? null),
            'tipo_documento' => self::normalizeTipoDocumento($getCellValue($headerMap['tipo_documento'] ?? null)),
            'numero_documento' => $getCellValue($headerMap['numero_documento'] ?? null),
            'nombre_completo' => $nombreCompleto ?: null,
            'correo_electronico' => $getCellValue($headerMap['correo_electronico'] ?? null),
            'telefono_fijo' => $getCellValue($headerMap['telefono_fijo'] ?? null),
            'telefono_movil' => $getCellValue($headerMap['telefono_movil'] ?? null),
            'tipo_prueba' => $getCellValue($headerMap['tipo_prueba'] ?? null),
            'resultado_prueba' => $getCellValue($headerMap['resultado_prueba'] ?? null),
            'fecha_cargue' => self::convertirFecha($getCellValue($headerMap['fecha_cargue'] ?? null)),
            'estado_prueba' => $getCellValue($headerMap['estado_prueba'] ?? null),
            'motivo_prueba' => $getCellValue($headerMap['motivo_prueba'] ?? null),
            'fecha_prueba' => self::convertirFecha($getCellValue($headerMap['fecha_prueba'] ?? null)),
            'acceso_preferente' => $getCellValue($headerMap['acceso_preferente'] ?? null),
            'digito' => $getCellValue($headerMap['digito'] ?? null),
            'dia_pico_placa' => $getCellValue($headerMap['dia_pico_placa'] ?? null),
            'estado' => 'completada', // Estado por defecto para datos de REGIONAL SANTANDER
        ];
    }
    
    /**
     * Normaliza cadenas para comparación de headers
     */
    private static function normalizeString(string $value): string
    {
        $value = strtolower($value);
        $value = str_replace(
            ['á', 'é', 'í', 'ó', 'ú', 'ñ', ' ', '_'],
            ['a', 'e', 'i', 'o', 'u', 'n', '', ''],
            $value
        );
        return trim($value, '_');
    }
    
    /**
     * Normaliza fila para búsqueda rápida
     */
    private static function normalizeRow(array $row): array
    {
        return array_map(function($value) {
            return self::normalizeString((string)$value);
        }, $row);
    }
    
    /**
     * Normaliza tipo de documento
     */
    private static function normalizeTipoDocumento(?string $value): ?string
    {
        if (empty($value)) {
            return null;
        }
        
        $mapping = [
            'cc' => 'CC',
            'ti' => 'TI',
            'ce' => 'CE',
            'pa' => 'PA',
            'rc' => 'RC',
            'pp' => 'PP',
            'nit' => 'NIT',
        ];
        
        $lower = strtolower(trim($value));
        return $mapping[$lower] ?? strtoupper($value);
    }
    
    /**
     * Convierte fecha de formato "DD/MM/YYYY HH:MM:SS AM/PM" a formato MySQL "YYYY-MM-DD HH:MM:SS"
     */
    private static function convertirFecha(?string $fechaStr): ?string
    {
        if (empty($fechaStr)) {
            return null;
        }
        
        try {
            // Formatos posibles:
            // "06/02/2026 07:36:04 PM"
            // "06/02/2026 09:06:09 AM"
            // "06/02/2026 02:19:49 PM"
            
            // Intentar parsear con Carbon
            $fecha = \Carbon\Carbon::createFromFormat('d/m/Y h:i:s A', $fechaStr);
            
            return $fecha->format('Y-m-d H:i:s');
        } catch (\Exception $e) {
            Log::warning('No se pudo convertir fecha', [
                'fecha' => $fechaStr,
                'error' => $e->getMessage(),
            ]);
            
            return null;
        }
    }
}
