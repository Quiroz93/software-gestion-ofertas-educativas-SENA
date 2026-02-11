<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ImportPreinscritosConsolidacionRequest;
use App\Http\Requests\UpdateConsolidacionDetalleRequest;
use App\Imports\RawArrayImport;
use App\Models\ConsolidacionPreinscrito;
use App\Models\ConsolidacionPreinscritoDetalle;
use App\Models\User;
use App\Services\RegionalSantanderProcessor;
use App\Services\FlexibleFileAnalyzer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;

class ConsolidacionPreinscritoController extends Controller
{
    public function index(Request $request)
    {
        if (Gate::denies('preinscritos.consolidaciones.admin')) {
            return redirect()->route('dashboard')
                ->with('permission_error', 'No tienes permisos para administrar consolidaciones.');
        }

        $query = ConsolidacionPreinscrito::with('createdBy')->orderByDesc('created_at');

        if ($request->filled('fecha_desde')) {
            $query->whereDate('created_at', '>=', $request->fecha_desde);
        }

        if ($request->filled('fecha_hasta')) {
            $query->whereDate('created_at', '<=', $request->fecha_hasta);
        }

        if ($request->filled('usuario_id')) {
            $query->where('created_by', $request->usuario_id);
        }

        $consolidaciones = $query->paginate(15)->withQueryString();
        $usuarios = User::orderBy('name')->get();

        return view('admin.preinscritos.consolidaciones.index', compact('consolidaciones', 'usuarios'));
    }

    public function importForm()
    {
        if (Gate::denies('preinscritos.import')) {
            return redirect()->route('dashboard')
                ->with('permission_error', 'No tienes permisos para importar preinscritos.');
        }

        return view('admin.preinscritos.consolidaciones.import');
    }

    public function import(ImportPreinscritosConsolidacionRequest $request)
    {
        if (Gate::denies('preinscritos.import')) {
            return redirect()->route('dashboard')
                ->with('permission_error', 'No tienes permisos para importar preinscritos.');
        }

        $files = $request->file('archivos', []);
        
        if (empty($files)) {
            return back()->with('error', 'No se seleccionaron archivos.');
        }
        
        // Guardar archivos temporalmente y obtener información
        $archivosInfo = $this->storeTemporaryFiles($files);
        
        Log::info('Archivos guardados temporalmente', ['cantidad' => count($archivosInfo)]);
        
        // NUEVO: Analizar archivos con analizador flexible (sin depender del nombre)
        $analysisResults = $this->analyzeFilesFlexible($archivosInfo);
        
        Log::info('Análisis flexible completado', [
            'total_archivos' => count($analysisResults),
            'total_columnas_unicas' => count(FlexibleFileAnalyzer::getAllColumnsFromAnalysis($analysisResults)),
        ]);
        
        // Guardar información en sesión para siguiente paso
        session([
            'archivos_por_consolidar' => $archivosInfo,
            'analisis_archivos' => $analysisResults,
        ]);
        
        // Redirigir a preview de columnas donde usuario selecciona qué consolidar
        return redirect()->route('preinscritos.consolidaciones.previewColumns')
            ->with('info', 'Archivos analizados. Seleccione las columnas que desea incluir en la consolidación.');
    }
    
    /**
     * Analiza archivos con analizador flexible (basado en estructura, no en nombre)
     */
    private function analyzeFilesFlexible(array $archivosInfo): array
    {
        $analysisResults = [];
        
        foreach ($archivosInfo as $info) {
            try {
                // Leer archivo temporal
                $contenido = Storage::disk('local')->get($info['ruta_temporal']);
                $tmpFile = tempnam(sys_get_temp_dir(), 'analisis');
                file_put_contents($tmpFile, $contenido);
                
                // Leer con Excel
                $sheets = Excel::toArray(new RawArrayImport(), $tmpFile);
                unlink($tmpFile);
                
                $rows = $sheets[0] ?? [];
                
                if (empty($rows)) {
                    Log::warning('Archivo vacío', ['nombre' => $info['nombre_original']]);
                    continue;
                }
                
                // Analizar con analizador flexible
                $analysis = FlexibleFileAnalyzer::analyze($rows, $info['nombre_original']);
                $analysis['ruta_temporal'] = $info['ruta_temporal'];
                $analysis['indice'] = $info['indice'];
                
                $analysisResults[] = $analysis;
                
            } catch (\Throwable $e) {
                Log::error('Error al analizar archivo', [
                    'nombre' => $info['nombre_original'],
                    'error' => $e->getMessage(),
                ]);
            }
        }
        
        return $analysisResults;
    }
    
    /**
     * Guarda archivos cargados temporalmente y retorna información de ellos
     */
    private function storeTemporaryFiles($files): array
    {
        $archivosInfo = [];
        $tempDir = 'temp/consolidaciones_' . now()->timestamp;
        
        if (!is_array($files)) {
            $files = [$files];
        }
        
        foreach ($files as $idx => $file) {
            $originalName = $file->getClientOriginalName();
            $filename = "{$idx}_" . Str::random(8) . '.' . $file->getClientOriginalExtension();
            $tempPath = "{$tempDir}/{$filename}";
            
            try {
                // Guardar archivo usando el helper Storage
                Storage::disk('local')->putFileAs(
                    dirname($tempPath),
                    $file,
                    basename($tempPath)
                );
                
                $archivosInfo[] = [
                    'nombre_original' => $originalName,
                    'ruta_temporal' => $tempPath,
                    'indice' => $idx,
                ];
            } catch (\Throwable $e) {
                Log::error("Error al guardar archivo temporal: {$e->getMessage()}");
            }
        }
        
        return $archivosInfo;
    }
    
    /**
     * Detecta tipos de archivo desde rutas temporales
     */
    private function detectFileTypesFromPaths(array $archivosInfo): array
    {
        $archivosConTipo = [];
        $regional = [];
        $preinscritos = [];
        
        foreach ($archivosInfo as $info) {
            try {
                $contentStr = Storage::disk('local')->get($info['ruta_temporal']);
                
                Log::info('Leyendo archivo para detección', [
                    'nombre' => $info['nombre_original'],
                    'ruta' => $info['ruta_temporal'],
                    'tamaño' => strlen($contentStr),
                ]);
                
                // Para storage disk, usar contenido directo
                $tmpFile = tempnam(sys_get_temp_dir(), 'consolidacion');
                file_put_contents($tmpFile, $contentStr);
                
                $sheets = Excel::toArray(new RawArrayImport(), $tmpFile);
                unlink($tmpFile);
                
                $rows = $sheets[0] ?? [];
                
                Log::info('Archivo leído para detección', [
                    'nombre' => $info['nombre_original'],
                    'filas' => count($rows),
                    'columnas' => count($rows[0] ?? []),
                ]);
                
                $esRegional = !empty($rows) && RegionalSantanderProcessor::detect($rows);
                
                Log::info('Resultado detección', [
                    'nombre' => $info['nombre_original'],
                    'es_regional' => $esRegional,
                ]);
                
                $info['es_regional'] = $esRegional;
                $archivosConTipo[] = $info;
                
                if ($esRegional) {
                    $regional[] = $info;
                } else {
                    $preinscritos[] = $info;
                }
            } catch (\Throwable $e) {
                // Si hay error leyendo, asumir es preinscrito
                Log::error('Error al detectar tipo de archivo', [
                    'nombre' => $info['nombre_original'],
                    'error' => $e->getMessage(),
                    'trace' => $e->getTraceAsString(),
                ]);
                
                $info['es_regional'] = false;
                $archivosConTipo[] = $info;
                $preinscritos[] = $info;
            }
        }
        
        return [
            'archivos' => $archivosConTipo,
            'regional' => $regional,
            'preinscritos' => $preinscritos,
        ];
    }
    
    /**
     * Procesa consolidación desde archivos guardados temporalmente
     */
    private function procesarConsolidacionDesdeArchivos($request, array $archivosInfo, string $tipo)
    {
        $registros = [];
        $totalArchivos = 0;
        $duplicados = 0;
        $invalidos = 0;
        $erroresArchivos = [];
        $totalesPorArchivo = [];
        
        foreach ($archivosInfo as $info) {
            $originalName = $info['nombre_original'];
            $rutaTemporal = $info['ruta_temporal'];
            
            try {
                // Leer contenido y crear archivo temporal para Excel
                $contenido = Storage::disk('local')->get($rutaTemporal);
                $tmpFile = tempnam(sys_get_temp_dir(), 'consolidacion');
                file_put_contents($tmpFile, $contenido);
                
                // Excel detectará automáticamente si es .xls o .xlsx
                $sheets = Excel::toArray(new RawArrayImport(), $tmpFile);
                unlink($tmpFile);
                
                $rows = $sheets[0] ?? [];
                
                if (empty($rows)) {
                    $erroresArchivos[] = "El archivo {$originalName} está vacío.";
                    continue;
                }
                
                // Extraer metadatos del archivo
                $metadata = $this->extractMetadata($rows);
                
                [$headerIndex, $headerMap] = $this->detectHeader($rows);
                if ($headerIndex === null) {
                    $erroresArchivos[] = "No se encontró encabezado válido en {$originalName}.";
                    continue;
                }
                
                $validCount = 0;
                $totalArchivos++;
                
                for ($i = $headerIndex + 1; $i < count($rows); $i++) {
                    $row = $rows[$i];
                    $mapped = $this->mapRow($row, $headerMap, $metadata);
                    
                    if ($this->rowIsEmpty($mapped)) {
                        continue;
                    }
                    
                    if (!$this->rowHasRequired($mapped)) {
                        $invalidos++;
                        continue;
                    }
                    
                    $key = $this->makeKey($mapped);
                    if (isset($registros[$key])) {
                        $duplicados++;
                        continue;
                    }
                    
                    $registros[$key] = $mapped;
                    $validCount++;
                }
                
                $totalesPorArchivo[$originalName] = $validCount;
                
            } catch (\Throwable $e) {
                $erroresArchivos[] = "Error al procesar {$originalName}: {$e->getMessage()}";
            } finally {
                // Limpiar archivo temporal después de procesarlo
                try {
                    Storage::disk('local')->delete($rutaTemporal);
                } catch (\Throwable $e) {
                    // Log silencioso de error de limpieza
                }
            }
        }
        
        $totalRegistros = count($registros);
        $totalDescartados = $duplicados + $invalidos;
        
        if ($totalRegistros === 0) {
            return back()
                ->with('error', 'No se encontraron registros válidos para consolidar.')
                ->with('import_errors', $erroresArchivos)
                ->withInput();
        }
        
        $nombre = 'Consolidacion_preinscritos_' . now()->format('Ymd_His');
        $descripcion = $this->buildDescripcion($totalArchivos, $totalesPorArchivo, $totalRegistros);
        
        DB::beginTransaction();
        try {
            $consolidacion = ConsolidacionPreinscrito::create([
                'nombre_consolidacion' => $nombre,
                'descripcion' => $descripcion,
                'tipo_consolidacion' => 'preinscritos',
                'total_archivos' => $totalArchivos,
                'total_registros' => $totalRegistros,
                'total_descartados' => $totalDescartados,
                'created_by' => $request->user()?->id,
            ]);
            
            $now = now();
            $buffer = [];
            
            foreach ($registros as $record) {
                $buffer[] = [
                    'consolidacion_id' => $consolidacion->id,
                    'tipo_documento' => $record['tipo_documento'],
                    'numero_documento' => $record['numero_documento'],
                    'nombre_completo' => $record['nombre_completo'],
                    'estado' => $record['estado'],
                    'codigo_ficha' => $record['codigo_ficha'],
                    'nombre_programa' => $record['nombre_programa'],
                    'observaciones' => null,
                    'created_at' => $now,
                    'updated_at' => $now,
                ];
                
                if (count($buffer) >= 500) {
                    ConsolidacionPreinscritoDetalle::insert($buffer);
                    $buffer = [];
                }
            }
            
            if (!empty($buffer)) {
                ConsolidacionPreinscritoDetalle::insert($buffer);
            }
            
            DB::commit();
        } catch (\Throwable $e) {
            DB::rollBack();
            return back()->with('error', 'Error al consolidar los archivos: ' . $e->getMessage());
        }
        
        $reporte = [
            'total_archivos' => $totalArchivos,
            'total_registros' => $totalRegistros,
            'total_descartados' => $totalDescartados,
            'duplicados' => $duplicados,
            'invalidos' => $invalidos,
            'errores_archivos' => $erroresArchivos,
        ];
        
        return redirect()
            ->route('preinscritos.consolidaciones.show', $consolidacion)
            ->with('success', 'Consolidación creada exitosamente.')
            ->with('import_report', $reporte);
    }
    
    /**
     * Detea tipos de archivos y agrupa por tipo
     */
    private function detectFileTypes(array $files): array
    {
        $tipos = [
            'preinscritos' => [],
            'regional' => [],
        ];
        
        foreach ($files as $file) {
            try {
                $sheets = Excel::toArray(new RawArrayImport(), $file);
                $rows = $sheets[0] ?? [];
                
                // Intentar crear instancia del procesador para ver si detecta REGIONAL SANTANDER
                $processor = new RegionalSantanderProcessor();
                if ($processor->detect($rows)) {
                    $tipos['regional'][] = $file;
                } else {
                    $tipos['preinscritos'][] = $file;
                }
            } catch (\Throwable $e) {
                // Si hay error, asumir que es preinscritos
                $tipos['preinscritos'][] = $file;
            }
        }
        
        return $tipos;
    }
    
    /**
     * Muestra preview de columnas detectadas para que usuario seleccione cuáles consolidar
     */
    public function previewColumns()
    {
        // Aumentar timeout para archivos grandes
        set_time_limit(120);
        
        if (Gate::denies('preinscritos.import')) {
            return redirect()->route('dashboard')
                ->with('permission_error', 'No tienes permisos para importar preinscritos.');
        }

        $analisis = session('analisis_archivos', []);
        
        if (empty($analisis)) {
            return redirect()->route('preinscritos.consolidaciones.import')
                ->with('error', 'No hay archivos cargados. Por favor suba archivos primero.');
        }
        
        // Obtener todas las columnas únicas detectadas
        $todasLasColumnas = FlexibleFileAnalyzer::getAllColumnsFromAnalysis($analisis);
        
        // Crear array con información de columnas para la vista
        $columnasConInfo = [];
        foreach ($todasLasColumnas as $col) {
            $columnasConInfo[] = [
                'nombre' => $col,
                'etiqueta' => FlexibleFileAnalyzer::getColumnLabel($col),
                'recomendada' => in_array($col, ['tipo_documento', 'numero_documento', 'nombre_completo', 'codigo_ficha', 'nombre_programa']),
            ];
        }
        
        return view('admin.preinscritos.consolidaciones.preview_columns', [
            'archivos' => $analisis,
            'columnas' => $columnasConInfo,
            'totalArchivos' => count($analisis),
        ]);
    }
    
    /**
     * Procesa consolidación con columnas seleccionadas
     */
    /**
     * Procesa consolidación con columnas seleccionadas
     * 
     * DETECCIÓN DE DUPLICADOS:
     * El sistema evita consolidar registros duplicados usando una clave única compuesta por:
     * - tipo_documento + numero_documento + codigo_ficha
     * 
     * Ejemplo:
     * - Archivo 1: CC | 12345678 | 1234 → Se incluye
     * - Archivo 2: CC | 12345678 | 1234 → Se ignora (DUPLICADO)
     * 
     * Los duplicados se cuentan en 'total_descartados' y se informan al usuario.
     */
    public function processColumns(Request $request)
    {
        if (Gate::denies('preinscritos.import')) {
            return redirect()->route('dashboard')
                ->with('permission_error', 'No tienes permisos para importar preinscritos.');
        }

        $columnasSeleccionadas = $request->input('columnas', []);
        
        if (empty($columnasSeleccionadas)) {
            return back()->with('error', 'Debe seleccionar al menos una columna para consolidar.');
        }
        
        $analisis = session('analisis_archivos', []);
        
        if (empty($analisis)) {
            return redirect()->route('preinscritos.consolidaciones.importForm')
                ->with('error', 'Sesión expirada. Por favor suba los archivos nuevamente.');
        }
        
        Log::info('Procesando consolidación flexible', [
            'total_archivos' => count($analisis),
            'columnas_seleccionadas' => count($columnasSeleccionadas),
            'columnas' => $columnasSeleccionadas,
        ]);
        
        try {
            // Extraer todos los registros de todos los archivos
            $todosLosRegistros = [];
            $duplicadosCount = 0;
            $registrosUnicos = []; // Array asociativo para detectar duplicados
            
            foreach ($analisis as $archivo) {
                // IMPORTANTE: Si 'data' es solo muestra, necesitamos leer archivo completo
                $data = [];
                
                if (isset($archivo['ruta_temporal'])) {
                    // Re-leer archivo completo desde ruta temporal
                    try {
                        $contenido = Storage::disk('local')->get($archivo['ruta_temporal']);
                        $tmpFile = tempnam(sys_get_temp_dir(), 'proceso');
                        file_put_contents($tmpFile, $contenido);
                        
                        $sheets = Excel::toArray(new RawArrayImport(), $tmpFile);
                        unlink($tmpFile);
                        
                        $rows = $sheets[0] ?? [];
                        $headerIndex = $archivo['header_index'] ?? 0;
                        $columnsMap = $archivo['columns_map'] ?? [];
                        
                        // Re-extraer todos los datos
                        $data = FlexibleFileAnalyzer::extractData($rows, $headerIndex, $columnsMap);
                        
                    } catch (\Throwable $e) {
                        Log::error('Error al re-leer archivo temporal', [
                            'archivo' => $archivo['nombre_archivo'],
                            'error' => $e->getMessage(),
                        ]);
                        continue;
                    }
                } else {
                    // Fallback: usar datos en sesión (legacy)
                    $data = $archivo['data'] ?? [];
                }
                
                foreach ($data as $registro) {
                    // Filtrar solo las columnas seleccionadas
                    $registroFiltrado = [];
                    foreach ($columnasSeleccionadas as $col) {
                        $registroFiltrado[$col] = $registro[$col] ?? null;
                    }
                    
                    // Agregar metadata del archivo si está entre las columnas
                    if (in_array('codigo_ficha', $columnasSeleccionadas) && empty($registroFiltrado['codigo_ficha'])) {
                        $registroFiltrado['codigo_ficha'] = $archivo['metadata']['codigo_ficha'] ?? null;
                    }
                    if (in_array('nombre_programa', $columnasSeleccionadas) && empty($registroFiltrado['nombre_programa'])) {
                        $registroFiltrado['nombre_programa'] = $archivo['metadata']['nombre_programa'] ?? null;
                    }
                    
                    // DETECTAR DUPLICADOS: usar tipo_documento + numero_documento + codigo_ficha como clave única
                    $tipoDoc = Str::lower(trim($registroFiltrado['tipo_documento'] ?? ''));
                    $numeroDoc = trim($registroFiltrado['numero_documento'] ?? '');
                    $codigoFicha = trim($registroFiltrado['codigo_ficha'] ?? '');
                    
                    // Validar que al menos tenga número de documento
                    if (empty($numeroDoc)) {
                        continue;
                    }
                    
                    // Crear clave única
                    $key = "{$tipoDoc}|{$numeroDoc}|{$codigoFicha}";
                    
                    // Si ya existe, es duplicado - NO agregar
                    if (isset($registrosUnicos[$key])) {
                        $duplicadosCount++;
                        Log::debug('Duplicado detectado', [
                            'tipo_documento' => $tipoDoc,
                            'numero_documento' => $numeroDoc,
                            'codigo_ficha' => $codigoFicha,
                        ]);
                        continue;
                    }
                    
                    // Marcar como procesado para futuras verificaciones
                    $registrosUnicos[$key] = true;
                    $todosLosRegistros[] = $registroFiltrado;
                }
            }
            
            if (empty($todosLosRegistros)) {
                return back()->with('error', 'No se encontraron registros válidos en los archivos.');
            }
            
            Log::info('Detección de duplicados completada', [
                'total_procesados' => count($todosLosRegistros) + $duplicadosCount,
                'registros_unicos' => count($todosLosRegistros),
                'duplicados_eliminados' => $duplicadosCount,
            ]);
            
            // Crear consolidación
            $nombre = 'Consolidación_inscritos_' . now()->format('Ymd_His');
            $descripcion = "Consolidación flexible de " . count($analisis) . " archivos con " . count($columnasSeleccionadas) . " columnas seleccionadas. Duplicados eliminados: {$duplicadosCount}.";
            
            DB::beginTransaction();
            try {
                $consolidacion = ConsolidacionPreinscrito::create([
                    'nombre_consolidacion' => $nombre,
                    'descripcion' => $descripcion,
                    'tipo_consolidacion' => 'flexible',
                    'total_archivos' => count($analisis),
                    'total_registros' => count($todosLosRegistros),
                    'total_descartados' => $duplicadosCount,
                    'created_by' => $request->user()?->id,
                ]);
                
                // Guardar columnas seleccionadas en metadata (JSON)
                $consolidacion->update([
                    'observaciones' => json_encode([
                        'columnas_seleccionadas' => $columnasSeleccionadas,
                        'archivos_originales' => array_map(fn($a) => $a['nombre_archivo'], $analisis),
                        'estadisticas' => [
                            'registros_unicos' => count($todosLosRegistros),
                            'duplicados_eliminados' => $duplicadosCount,
                            'total_procesados' => count($todosLosRegistros) + $duplicadosCount,
                        ],
                    ]),
                ]);
                
                // Insertar registros
                $now = now();
                $buffer = [];
                
                // Campos de fecha que esperan formato datetime de MySQL
                $camposFecha = ['fecha_prueba', 'fecha_cargue'];
                
                // IMPORTANTE: Definir campos consistentes para el INSERT
                // Siempre incluir campos básicos + campos seleccionados
                $camposBásicos = ['tipo_documento', 'numero_documento', 'nombre_completo', 'estado', 'codigo_ficha', 'nombre_programa'];
                
                // Combinar: campos básicos + campos seleccionados (evitando duplicados)
                $camposAInsertar = array_unique(array_merge($camposBásicos, $columnasSeleccionadas));
                
                // Agregar metadata y timestamps
                $camposAInsertar = array_merge($camposAInsertar, ['consolidacion_id', 'created_at', 'updated_at']);
                
                Log::debug('Campos a insertar en consolidación flexible', [
                    'total_campos' => count($camposAInsertar),
                    'campos' => $camposAInsertar,
                ]);
                
                // Función para normalizar fechas a formato MySQL
                $normalizarFecha = function($fecha) {
                    if (empty($fecha) || $fecha === null) {
                        return null;
                    }
                    
                    $fecha = trim((string)$fecha);
                    if (empty($fecha)) {
                        return null;
                    }
                    
                    try {
                        // Lista exhaustiva de formatos que Excel puede exportar
                        $formatosPosibles = [
                            // Formatos con AM/PM
                            'm/d/Y H:i:s A',  // 06/02/2026 09:53:39 PM
                            'm/d/Y h:i:s A',  // 06/02/2026 9:53:39 PM
                            'd/m/Y H:i:s A',  // 02/06/2026 09:53:39 PM
                            'd/m/Y h:i:s A',  // 02/06/2026 9:53:39 PM
                            
                            // Formatos 24h
                            'm/d/Y H:i:s',    // 06/02/2026 09:53:39
                            'd/m/Y H:i:s',    // 02/06/2026 09:53:39
                            'Y-m-d H:i:s',    // 2026-02-06 09:53:39
                            
                            // Solo fechas
                            'm/d/Y',          // 06/02/2026
                            'd/m/Y',          // 02/06/2026
                            'Y-m-d',          // 2026-02-06
                            'd/m/Y H:i',      // 02/06/2026 09:53
                            'm/d/Y H:i',      // 06/02/2026 09:53
                            
                            // Formatos alternativos
                            'm-d-Y H:i:s',
                            'd-m-Y H:i:s',
                            'Y-m-d h:i:s A',
                        ];
                        
                        // Intentar cada formato
                        foreach ($formatosPosibles as $formato) {
                            try {
                                $carbon = \Carbon\Carbon::createFromFormat(
                                    $formato,
                                    $fecha,
                                    'America/Bogota'
                                );
                                return $carbon->format('Y-m-d H:i:s');
                            } catch (\Exception $e) {
                                // Continuar con siguiente formato
                                continue;
                            }
                        }
                        
                        // Si ningún formato funcionó, intentar strtotime
                        $timestamp = strtotime($fecha);
                        if ($timestamp !== false) {
                            return date('Y-m-d H:i:s', $timestamp);
                        }
                        
                        // Si tampoco funciona strtotime, devolver null y Log
                        Log::warning("No se pudo parsear fecha con ningún formato", [
                            'fecha' => $fecha,
                            'formatos_probados' => count($formatosPosibles),
                        ]);
                        return null;
                        
                    } catch (\Throwable $e) {
                        Log::warning("Error crítico al parsear fecha", [
                            'fecha' => $fecha,
                            'error' => $e->getMessage(),
                        ]);
                        return null;
                    }
                };
                
                foreach ($todosLosRegistros as $registro) {
                    // IMPORTANTE: Construir array con EXACTAMENTE los mismos campos para cada fila
                    $detalleData = [
                        'consolidacion_id' => $consolidacion->id,
                        'created_at' => $now,
                        'updated_at' => $now,
                    ];
                    
                    // Agregar todos los campos, rellenando con NULL si no existen
                    foreach ($camposBásicos as $campo) {
                        $detalleData[$campo] = $registro[$campo] ?? ($campo === 'estado' ? 'completada' : null);
                    }
                    
                    // Agregar campos seleccionados (que no sean básicos)
                    foreach ($columnasSeleccionadas as $campo) {
                        if (!in_array($campo, $camposBásicos)) {
                            $valor = $registro[$campo] ?? null;
                            
                            // Si es un campo de fecha, normalizarlo
                            if (in_array($campo, $camposFecha) && $valor !== null) {
                                $valor = $normalizarFecha($valor);
                            }
                            
                            $detalleData[$campo] = $valor;
                        }
                    }
                    
                    $buffer[] = $detalleData;
                    
                    if (count($buffer) >= 500) {
                        try {
                            ConsolidacionPreinscritoDetalle::insert($buffer);
                        } catch (\Throwable $e) {
                            // Log detallado del primer registro en el buffer para debugging
                            if (!empty($buffer)) {
                                Log::error('Error en batch insert de consolidación', [
                                    'error' => $e->getMessage(),
                                    'primer_registro' => $buffer[0] ?? [],
                                    'total_registros_en_buffer' => count($buffer),
                                ]);
                            }
                            throw $e;
                        }
                        $buffer = [];
                    }
                }
                
                if (!empty($buffer)) {
                    try {
                        ConsolidacionPreinscritoDetalle::insert($buffer);
                    } catch (\Throwable $e) {
                        Log::error('Error en batch insert final de consolidación', [
                            'error' => $e->getMessage(),
                            'primer_registro' => $buffer[0] ?? [],
                            'total_registros_en_buffer' => count($buffer),
                        ]);
                        throw $e;
                    }
                }
                
                DB::commit();
                
                // Limpiar sesión
                session()->forget(['archivos_por_consolidar', 'analisis_archivos']);
                
                Log::info('Consolidación flexible creada exitosamente', [
                    'id' => $consolidacion->id,
                    'registros_unicos' => count($todosLosRegistros),
                    'duplicados_eliminados' => $duplicadosCount,
                ]);
                
                // Mensaje de éxito con información de duplicados
                $mensaje = "Consolidación creada exitosamente con {$consolidacion->total_registros} registros únicos.";
                if ($duplicadosCount > 0) {
                    $mensaje .= " Se eliminaron {$duplicadosCount} registros duplicados.";
                }
                
                return redirect()->route('preinscritos.consolidaciones.show', $consolidacion)
                    ->with('success', $mensaje);
                
            } catch (\Throwable $e) {
                DB::rollBack();
                throw $e;
            }
            
        } catch (\Throwable $e) {
            Log::error('Error al procesar consolidación flexible', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            
            return back()->with('error', 'Error al procesar consolidación: ' . $e->getMessage());
        }
    }
    
    /**
     * Muestra formulario para seleccionar opciones de consolidación de REGIONAL SANTANDER
     */
    public function selectOptions()
    {
        if (Gate::denies('preinscritos.import')) {
            return redirect()->route('dashboard')
                ->with('permission_error', 'No tienes permisos para importar preinscritos.');
        }
        
        $archivosInfo = session('archivos_por_consolidar', []);
        
        if (empty($archivosInfo)) {
            return redirect()->route('preinscritos.consolidaciones.import')
                ->with('error', 'Sesión expirada. Por favor intente nuevamente.');
        }
        
        // Reorganizar para que sea accesible desde la vista
        $archivosOrganizados = [
            'regional' => [],
            'preinscritos' => [],
        ];
        
        foreach ($archivosInfo as $info) {
            if (isset($info['es_regional']) && $info['es_regional']) {
                $archivosOrganizados['regional'][] = $info;
            } else {
                $archivosOrganizados['preinscritos'][] = $info;
            }
        }
        
        return view('admin.preinscritos.consolidaciones.select_options', [
            'archivosInfo' => $archivosOrganizados,
        ]);
    }
    
    /**
     * Procesa consolidación según opciones seleccionadas
     */
    public function processWithOptions(Request $request)
    {
        if (Gate::denies('preinscritos.import')) {
            return redirect()->route('dashboard')
                ->with('permission_error', 'No tienes permisos para importar preinscritos.');
        }
        
        $archivosInfo = session('archivos_por_consolidar', []);
        $opcionRegional = $request->input('opcion_regional', 'completo'); // 'completo' o 'esencial'
        
        Log::info('ProcessWithOptions - Opción recibida', [
            'opcion_regional' => $opcionRegional,
            'request_all' => $request->all(),
        ]);
        
        if (empty($archivosInfo)) {
            return redirect()->route('preinscritos.consolidaciones.import')
                ->with('error', 'Sesión expirada. Por favor intente nuevamente.');
        }
        
        // Separar archivos por tipo basándose en la bandera guardada
        $regionalesInfo = [];
        $preinscritosInfo = [];
        
        foreach ($archivosInfo as $info) {
            if (isset($info['es_regional']) && $info['es_regional']) {
                $regionalesInfo[] = $info;
            } else {
                $preinscritosInfo[] = $info;
            }
        }
        
        try {
            $consolidacionCreada = false;
            $consolidacionesInfo = [];
            
            // Procesar archivos preinscritos si existen
            if (!empty($preinscritosInfo)) {
                $this->procesarConsolidacionDesdeArchivos($request, $preinscritosInfo, 'preinscritos');
                $consolidacionCreada = true;
            }
            
            // Procesar archivos REGIONAL SANTANDER si existen
            if (!empty($regionalesInfo)) {
                $consolidacionRegional = $this->procesarRegionalDesdeArchivos($request, $regionalesInfo, $opcionRegional);
                $consolidacionCreada = true;
                
                // Mensaje con información de duplicados
                if ($consolidacionRegional->total_descartados > 0) {
                    $consolidacionesInfo['duplicados'] = $consolidacionRegional->total_descartados;
                }
            }
            
            // Limpiar sesión y archivos temporales
            session()->forget('archivos_por_consolidar');
            $this->limpiarArchivosTemporales($archivosInfo);
            
            if ($consolidacionCreada) {
                $mensaje = 'Consolidación completada exitosamente.';
                if (isset($consolidacionesInfo['duplicados']) && $consolidacionesInfo['duplicados'] > 0) {
                    $mensaje .= " Se eliminaron {$consolidacionesInfo['duplicados']} registros duplicados.";
                }
                
                return redirect()->route('preinscritos.consolidaciones.index')
                    ->with('success', $mensaje);
            }
        } catch (\Throwable $e) {
            // Limpiar archivos temporales en caso de error
            $this->limpiarArchivosTemporales($archivosInfo);
            
            return back()
                ->with('error', 'Error al procesar archivos: ' . $e->getMessage());
        }
        
        return back()->with('error', 'No hay datos para procesar.');
    }
    
    /**
     * Limpia archivos temporales del almacenamiento
     */
    private function limpiarArchivosTemporales(array $archivosInfo)
    {
        foreach ($archivosInfo as $info) {
            if (isset($info['ruta_temporal'])) {
                try {
                    Storage::disk('local')->delete($info['ruta_temporal']);
                } catch (\Throwable $e) {
                    // Silenciar errores de limpieza
                }
            }
        }
    }
    
    /**
     * Procesa archivos de preinscritos (código original)
     */
    private function procesarConsolidacion($request, array $files, string $tipo)
    {
        $totalArchivos = count($files);
        $erroresArchivos = [];
        $duplicados = 0;
        $invalidos = 0;
        $registros = [];
        $totalesPorArchivo = [];

        foreach ($files as $file) {
            $originalName = $file->getClientOriginalName();

            try {
                $sheets = Excel::toArray(new RawArrayImport(), $file);
            } catch (\Throwable $e) {
                $erroresArchivos[] = "No se pudo leer el archivo {$originalName}: {$e->getMessage()}";
                continue;
            }

            $rows = $sheets[0] ?? [];
            if (empty($rows)) {
                $erroresArchivos[] = "El archivo {$originalName} está vacío.";
                continue;
            }

            // Extraer metadatos del archivo (código de ficha, programa, etc.)
            $metadata = $this->extractMetadata($rows);

            [$headerIndex, $headerMap] = $this->detectHeader($rows);
            if ($headerIndex === null) {
                $erroresArchivos[] = "No se encontró encabezado válido en {$originalName}.";
                continue;
            }

            $validCount = 0;

            for ($i = $headerIndex + 1; $i < count($rows); $i++) {
                $row = $rows[$i];
                $mapped = $this->mapRow($row, $headerMap, $metadata);

                if ($this->rowIsEmpty($mapped)) {
                    continue;
                }

                if (!$this->rowHasRequired($mapped)) {
                    $invalidos++;
                    continue;
                }

                $key = $this->makeKey($mapped);
                if (isset($registros[$key])) {
                    $duplicados++;
                    continue;
                }

                $registros[$key] = $mapped;
                $validCount++;
            }

            $totalesPorArchivo[$originalName] = $validCount;
        }

        $totalRegistros = count($registros);
        $totalDescartados = $duplicados + $invalidos;

        if ($totalRegistros === 0) {
            throw new \Exception('No se encontraron registros válidos para consolidar.');
        }

        $nombre = 'Consolidacion_preinscritos_' . now()->format('Ymd_His');
        $descripcion = $this->buildDescripcion($totalArchivos, $totalesPorArchivo, $totalRegistros);

        DB::beginTransaction();
        try {
            $consolidacion = ConsolidacionPreinscrito::create([
                'nombre_consolidacion' => $nombre,
                'descripcion' => $descripcion,
                'tipo_consolidacion' => 'preinscritos',
                'total_archivos' => $totalArchivos,
                'total_registros' => $totalRegistros,
                'total_descartados' => $totalDescartados,
                'created_by' => $request->user()?->id,
            ]);

            $now = now();
            $buffer = [];

            foreach ($registros as $record) {
                $buffer[] = [
                    'consolidacion_id' => $consolidacion->id,
                    'tipo_documento' => $record['tipo_documento'],
                    'numero_documento' => $record['numero_documento'],
                    'nombre_completo' => $record['nombre_completo'],
                    'estado' => $record['estado'],
                    'codigo_ficha' => $record['codigo_ficha'],
                    'nombre_programa' => $record['nombre_programa'],
                    'observaciones' => null,
                    'created_at' => $now,
                    'updated_at' => $now,
                ];

                if (count($buffer) >= 500) {
                    ConsolidacionPreinscritoDetalle::insert($buffer);
                    $buffer = [];
                }
            }

            if (!empty($buffer)) {
                ConsolidacionPreinscritoDetalle::insert($buffer);
            }

            DB::commit();
        } catch (\Throwable $e) {
            DB::rollBack();
            throw $e;
        }
    }
    
    /**
     * Procesa archivos REGIONAL SANTANDER
     */
    private function procesarRegional($request, array $files, string $opcion)
    {
        $totalArchivos = count($files);
        $erroresArchivos = [];
        $registros = [];
        $totalesPorArchivo = [];

        $processor = new RegionalSantanderProcessor();

        foreach ($files as $file) {
            $originalName = $file->getClientOriginalName();

            try {
                $sheets = Excel::toArray(new RawArrayImport(), $file);
                $rows = $sheets[0] ?? [];

                if (empty($rows)) {
                    $erroresArchivos[] = "El archivo {$originalName} está vacío.";
                    continue;
                }

                // Procesar según opción seleccionada
                $resultado = ($opcion === 'completo')
                    ? $processor->extractCompleto($rows)
                    : $processor->extractEsencial($rows);

                $metadata = $resultado['metadata'];
                $datos = $resultado['datos'];
                $validCount = 0;

                foreach ($datos as $row) {
                    if (empty($row['numero_documento'])) {
                        continue;
                    }

                    // Evitar duplicados
                    $key = Str::lower(trim($row['tipo_documento'] ?? ''))
                        . '|' . trim($row['numero_documento'])
                        . '|' . trim($row['codigo_ficha'] ?? '');

                    if (isset($registros[$key])) {
                        continue;
                    }

                    // Enriquecer datos con metadata si es necesario
                    if (empty($row['codigo_ficha'])) {
                        $row['codigo_ficha'] = $metadata['codigo_ficha'] ?? null;
                    }
                    if (empty($row['nombre_programa'])) {
                        $row['nombre_programa'] = $metadata['nombre_programa'] ?? null;
                    }

                    $registros[$key] = $row;
                    $validCount++;
                }

                $totalesPorArchivo[$originalName] = $validCount;
            } catch (\Throwable $e) {
                $erroresArchivos[] = "Error procesando {$originalName}: {$e->getMessage()}";
                continue;
            }
        }

        $totalRegistros = count($registros);

        if ($totalRegistros === 0) {
            throw new \Exception('No se encontraron registros válidos en archivos REGIONAL SANTANDER.');
        }

        $nombre = 'Consolidacion_regional_' . now()->format('Ymd_His');
        $tipoConsolidacion = ($opcion === 'completo') ? 'regional_completo' : 'regional_esencial';
        $descripcion = "Consolidación REGIONAL SANTANDER ({$opcion}) de {$totalArchivos} archivos. Total: {$totalRegistros} registros.";

        DB::beginTransaction();
        try {
            $consolidacion = ConsolidacionPreinscrito::create([
                'nombre_consolidacion' => $nombre,
                'descripcion' => $descripcion,
                'tipo_consolidacion' => $tipoConsolidacion,
                'total_archivos' => $totalArchivos,
                'total_registros' => $totalRegistros,
                'total_descartados' => 0,
                'created_by' => $request->user()?->id,
            ]);

            $now = now();
            $buffer = [];

            foreach ($registros as $record) {
                $detalleData = [
                    'consolidacion_id' => $consolidacion->id,
                    'tipo_documento' => $record['tipo_documento'] ?? null,
                    'numero_documento' => $record['numero_documento'] ?? null,
                    'nombre_completo' => $record['nombre_completo'] ?? null,
                    'estado' => $record['estado'] ?? 'completada',
                    'codigo_ficha' => $record['codigo_ficha'] ?? null,
                    'nombre_programa' => $record['nombre_programa'] ?? null,
                    'observaciones' => null,
                    'created_at' => $now,
                    'updated_at' => $now,
                ];

                // Si es consolidación completa, agregar campos adicionales
                if ($opcion === 'completo') {
                    $detalleData['nis'] = $record['nis'] ?? null;
                    $detalleData['correo_electronico'] = $record['correo_electronico'] ?? null;
                    $detalleData['telefono_fijo'] = $record['telefono_fijo'] ?? null;
                    $detalleData['telefono_movil'] = $record['telefono_movil'] ?? null;
                    $detalleData['tipo_prueba'] = $record['tipo_prueba'] ?? null;
                    $detalleData['resultado_prueba'] = $record['resultado_prueba'] ?? null;
                    $detalleData['fecha_cargue'] = $record['fecha_cargue'] ?? null;
                    $detalleData['estado_prueba'] = $record['estado_prueba'] ?? null;
                    $detalleData['motivo_prueba'] = $record['motivo_prueba'] ?? null;
                    $detalleData['fecha_prueba'] = $record['fecha_prueba'] ?? null;
                    $detalleData['acceso_preferente'] = $record['acceso_preferente'] ?? null;
                    $detalleData['digito'] = $record['digito'] ?? null;
                    $detalleData['dia_pico_placa'] = $record['dia_pico_placa'] ?? null;
                }

                $buffer[] = $detalleData;

                if (count($buffer) >= 500) {
                    ConsolidacionPreinscritoDetalle::insert($buffer);
                    $buffer = [];
                }
            }

            if (!empty($buffer)) {
                ConsolidacionPreinscritoDetalle::insert($buffer);
            }

            DB::commit();
        } catch (\Throwable $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function show(Request $request, ConsolidacionPreinscrito $consolidacion)
    {
        if (Gate::denies('preinscritos.consolidaciones.admin')) {
            return redirect()->route('dashboard')
                ->with('permission_error', 'No tienes permisos para administrar consolidaciones.');
        }

        $consolidacion->load('createdBy');

        $detallesQuery = $consolidacion->detalles()->orderBy('id');

        if ($request->filled('codigo_ficha')) {
            $detallesQuery->where('codigo_ficha', 'like', '%' . $request->codigo_ficha . '%');
        }

        if ($request->filled('estado')) {
            $detallesQuery->where('estado', $request->estado);
        }

        $detalles = $detallesQuery->paginate(25)->withQueryString();

        $estados = $consolidacion->detalles()
            ->select('estado')
            ->whereNotNull('estado')
            ->distinct()
            ->pluck('estado');

            // Extraer columnas seleccionadas si es consolidación flexible
            $columnasSeleccionadas = [];
            if ($consolidacion->tipo_consolidacion === 'flexible' && $consolidacion->observaciones) {
                $columnasSeleccionadas = $consolidacion->observaciones['columnas_seleccionadas'] ?? [];
            }

            return view('admin.preinscritos.consolidaciones.show', compact('consolidacion', 'detalles', 'estados', 'columnasSeleccionadas'));
    }

    public function updateDetalle(UpdateConsolidacionDetalleRequest $request, ConsolidacionPreinscritoDetalle $detalle)
    {
        if (Gate::denies('preinscritos.consolidaciones.admin')) {
            return redirect()->route('dashboard')
                ->with('permission_error', 'No tienes permisos para administrar consolidaciones.');
        }

        $detalle->update([
            'observaciones' => $request->observaciones,
        ]);

        return back()->with('success', 'Observaciones actualizadas correctamente.');
    }

    public function destroy(ConsolidacionPreinscrito $consolidacion)
    {
        if (Gate::denies('preinscritos.consolidaciones.admin')) {
            return redirect()->route('dashboard')
                ->with('permission_error', 'No tienes permisos para administrar consolidaciones.');
        }

        $consolidacion->delete();

        return redirect()->route('preinscritos.consolidaciones.index')
            ->with('success', 'Consolidación eliminada correctamente.');
    }

    public function exportar(Request $request, ConsolidacionPreinscrito $consolidacion)
    {
        if (Gate::denies('preinscritos.consolidaciones.admin')) {
            return redirect()->route('dashboard')
                ->with('permission_error', 'No tienes permisos para administrar consolidaciones.');
        }

        $filtros = [
            'codigo_ficha' => $request->input('codigo_ficha'),
            'estado' => $request->input('estado'),
        ];

        $filename = $consolidacion->nombre_consolidacion . '.xlsx';

        return Excel::download(
            new \App\Exports\ConsolidacionDetallesExport($consolidacion, $filtros),
            $filename
        );
    }

    /**
     * Extraer metadatos del archivo (código de ficha, programa, etc.)
     * que aparecen en las primeras filas antes del encabezado de datos
     */
    private function extractMetadata(array $rows): array
    {
        $metadata = [];
        
        // Buscar en las primeras 25 filas
        for ($i = 0; $i < min(25, count($rows)); $i++) {
            $row = $rows[$i];
            
            if (!is_array($row) || count($row) < 3) {
                continue;
            }
            
            $label = isset($row[2]) ? strtoupper(trim((string)$row[2])) : '';
            $value = isset($row[3]) ? trim((string)$row[3]) : '';
            
            if (empty($label) || empty($value)) {
                continue;
            }
            
            // Buscar código de ficha
            if (in_array($label, ['CODIGO FICHA', 'CODIGO_FICHA', 'FICHA'])) {
                $metadata['codigo_ficha'] = $value;
            }
            
            // Buscar nombre del programa
            if (in_array($label, ['DENOMINACION PROGRAMA', 'DENOMINACION_PROGRAMA', 'NOMBRE PROGRAMA', 'PROGRAMA'])) {
                $metadata['nombre_programa'] = $value;
            }
        }
        
        return $metadata;
    }
    
    /**
     * Procesa archivos REGIONAL SANTANDER desde rutas temporales
     */
    private function procesarRegionalDesdeArchivos($request, array $archivosInfo, string $opcion)
    {
        Log::info('Procesando archivos REGIONAL', [
            'opcion' => $opcion,
            'total_archivos' => count($archivosInfo),
        ]);
        
        $totalArchivos = count($archivosInfo);
        $erroresArchivos = [];
        $registros = [];
        $totalesPorArchivo = [];
        $duplicadosCount = 0; // Contador de duplicados
        
        foreach ($archivosInfo as $info) {
            $originalName = $info['nombre_original'];
            $rutaTemporal = $info['ruta_temporal'];
            
            try {
                // Leer archivo desde storage
                $contenido = Storage::disk('local')->get($rutaTemporal);
                $tmpFile = tempnam(sys_get_temp_dir(), 'regional');
                file_put_contents($tmpFile, $contenido);
                
                $sheets = Excel::toArray(new RawArrayImport(), $tmpFile);
                unlink($tmpFile);
                
                $rows = $sheets[0] ?? [];
                
                if (empty($rows)) {
                    $erroresArchivos[] = "El archivo {$originalName} está vacío.";
                    continue;
                }
                
                // Procesar según opción seleccionada
                $resultado = ($opcion === 'completo')
                    ? RegionalSantanderProcessor::extractCompleto($rows)
                    : RegionalSantanderProcessor::extractEsencial($rows);
                
                $metadata = $resultado['metadata'];
                $datos = $resultado['datos'];
                $validCount = 0;
                
                foreach ($datos as $row) {
                    if (empty($row['numero_documento'])) {
                        continue;
                    }
                    
                    // Evitar duplicados
                    $key = Str::lower(trim($row['tipo_documento'] ?? ''))
                        . '|' . trim($row['numero_documento'])
                        . '|' . trim($row['codigo_ficha'] ?? '');
                    
                    if (isset($registros[$key])) {
                        $duplicadosCount++;
                        continue;
                    }
                    
                    // Enriquecer datos con metadata si es necesario
                    if (empty($row['codigo_ficha'])) {
                        $row['codigo_ficha'] = $metadata['codigo_ficha'] ?? null;
                    }
                    if (empty($row['nombre_programa'])) {
                        $row['nombre_programa'] = $metadata['nombre_programa'] ?? null;
                    }
                    
                    $registros[$key] = $row;
                    $validCount++;
                }
                
                $totalesPorArchivo[$originalName] = $validCount;
            } catch (\Throwable $e) {
                $erroresArchivos[] = "Error procesando {$originalName}: {$e->getMessage()}";
            }
        }
        
        $totalRegistros = count($registros);
        
        if ($totalRegistros === 0) {
            throw new \Exception('No se encontraron registros válidos en archivos REGIONAL SANTANDER.');
        }
        
        $nombre = 'Consolidacion_regional_' . now()->format('Ymd_His');
        $tipoConsolidacion = ($opcion === 'completo') ? 'regional_completo' : 'regional_esencial';
        $descripcion = "Consolidación REGIONAL SANTANDER ({$opcion}) de {$totalArchivos} archivos. Total: {$totalRegistros} registros únicos.";
        if ($duplicadosCount > 0) {
            $descripcion .= " Duplicados eliminados: {$duplicadosCount}.";
        }
        
        Log::info('Creando consolidación REGIONAL', [
            'opcion' => $opcion,
            'tipo_consolidacion' => $tipoConsolidacion,
            'total_registros' => $totalRegistros,
            'duplicados_eliminados' => $duplicadosCount,
        ]);
        
        DB::beginTransaction();
        try {
            $consolidacion = ConsolidacionPreinscrito::create([
                'nombre_consolidacion' => $nombre,
                'descripcion' => $descripcion,
                'tipo_consolidacion' => $tipoConsolidacion,
                'total_archivos' => $totalArchivos,
                'total_registros' => $totalRegistros,
                'total_descartados' => $duplicadosCount,
                'created_by' => $request->user()?->id,
            ]);
            
            $now = now();
            $buffer = [];
            $contador = 0;
            
            foreach ($registros as $record) {
                $detalleData = [
                    'consolidacion_id' => $consolidacion->id,
                    'tipo_documento' => $record['tipo_documento'] ?? null,
                    'numero_documento' => $record['numero_documento'] ?? null,
                    'nombre_completo' => $record['nombre_completo'] ?? null,
                    'estado' => $record['estado'] ?? 'completada',
                    'codigo_ficha' => $record['codigo_ficha'] ?? null,
                    'nombre_programa' => $record['nombre_programa'] ?? null,
                    'created_at' => $now,
                    'updated_at' => $now,
                ];
                
                // Si es consolidación completa, agregar todos los campos adicionales
                if ($opcion === 'completo') {
                    $detalleData['nis'] = $record['nis'] ?? null;
                    $detalleData['correo_electronico'] = $record['correo_electronico'] ?? null;
                    $detalleData['telefono_fijo'] = $record['telefono_fijo'] ?? null;
                    $detalleData['telefono_movil'] = $record['telefono_movil'] ?? null;
                    $detalleData['tipo_prueba'] = $record['tipo_prueba'] ?? null;
                    $detalleData['resultado_prueba'] = $record['resultado_prueba'] ?? null;
                    $detalleData['fecha_cargue'] = $record['fecha_cargue'] ?? null;
                    $detalleData['estado_prueba'] = $record['estado_prueba'] ?? null;
                    $detalleData['motivo_prueba'] = $record['motivo_prueba'] ?? null;
                    $detalleData['fecha_prueba'] = $record['fecha_prueba'] ?? null;
                    $detalleData['acceso_preferente'] = $record['acceso_preferente'] ?? null;
                    $detalleData['digito'] = $record['digito'] ?? null;
                    $detalleData['dia_pico_placa'] = $record['dia_pico_placa'] ?? null;
                    $detalleData['observaciones'] = null;
                    
                    // Log de ejemplo solo para primeros 3 registros
                    if ($contador < 3) {
                        Log::info('Detalle COMPLETO - Registro #' . ($contador + 1), [
                            'documento' => $detalleData['numero_documento'],
                            'nis' => $detalleData['nis'],
                            'correo' => $detalleData['correo_electronico'],
                            'fecha_prueba' => $detalleData['fecha_prueba'],
                        ]);
                    }
                } else {
                    // Modo esencial: solo agregar teléfonos (sin observaciones)
                    $detalleData['telefono_fijo'] = $record['telefono_fijo'] ?? null;
                    $detalleData['telefono_movil'] = $record['telefono_movil'] ?? null;
                    
                    // Log de ejemplo solo para primeros 3 registros modo esencial
                    if ($contador < 3) {
                        Log::info('Detalle ESENCIAL - Registro #' . ($contador + 1), [
                            'documento' => $detalleData['numero_documento'],
                            'telefono_fijo' => $detalleData['telefono_fijo'],
                            'telefono_movil' => $detalleData['telefono_movil'],
                        ]);
                    }
                }
                
                $contador++;
                $buffer[] = $detalleData;
                
                if (count($buffer) >= 500) {
                    ConsolidacionPreinscritoDetalle::insert($buffer);
                    $buffer = [];
                }
            }
            
            if (!empty($buffer)) {
                ConsolidacionPreinscritoDetalle::insert($buffer);
            }
            
            DB::commit();
            
            return $consolidacion;
        } catch (\Throwable $e) {
            DB::rollBack();
            throw $e;
        }
    }

    private function detectHeader(array $rows): array
    {
        $requiredFields = ['tipo_documento', 'numero_documento', 'nombre_completo', 'estado', 'codigo_ficha'];

        // Buscar en las primeras 30 filas para archivos con metadatos
        $maxRows = min(30, count($rows));
        
        for ($index = 0; $index < $maxRows; $index++) {
            $row = $rows[$index];
            
            if (!is_array($row)) {
                continue;
            }

            $map = $this->buildHeaderMap($row);
            $matches = count(array_intersect($requiredFields, array_keys($map)));

            if ($matches >= 3) {
                return [$index, $map];
            }
        }

        return [null, []];
    }

    private function buildHeaderMap(array $row): array
    {
        $aliases = [
            'tipo_documento' => ['tipo_documento', 'tipo_de_documento', 'tipo doc', 'tipodocumento', 'documento_tipo', 'tdoc', 'tipo_doc'],
            'numero_documento' => ['numero_documento', 'n_documento', 'documento', 'num_documento', 'no_documento', 'documento_numero', 'numero de documento'],
            'nombre_completo' => ['nombre_completo', 'nombre', 'nombres', 'nombre y apellido', 'aprendiz', 'apellidos_nombres', 'nombres_apellidos'],
            'apellidos' => ['apellidos', 'apellido'],
            'estado' => ['estado', 'estado_aprendiz', 'estado_preinscripcion', 'estado preinscripcion'],
            'codigo_ficha' => ['codigo_ficha', 'ficha', 'codigo', 'codigo de ficha', 'ficha_codigo', 'numero_ficha', 'no_ficha'],
            'nombre_programa' => ['nombre_programa', 'programa', 'programa_formacion', 'nombre de programa', 'denominacion_programa'],
            'correo' => ['correo', 'correo_e', 'correo_electronico', 'email', 'e_mail'],
            'telefono_movil' => ['tel_movil', 'telefono_movil', 'celular', 'movil', 'telefono'],
            'telefono_fijo' => ['tel_fijo', 'telefono_fijo', 'fijo'],
        ];

        $normalizedAliases = [];
        foreach ($aliases as $field => $labels) {
            foreach ($labels as $label) {
                $normalizedAliases[$this->normalizeHeader($label)] = $field;
            }
        }

        $map = [];
        foreach ($row as $index => $value) {
            $normalized = $this->normalizeHeader($value);
            if ($normalized && isset($normalizedAliases[$normalized])) {
                $map[$normalizedAliases[$normalized]] = $index;
            }
        }

        return $map;
    }

    private function mapRow(array $row, array $headerMap, array $metadata = []): array
    {
        // Combinar nombres y apellidos si vienen separados
        $nombreCompleto = $this->getCellValue($row, $headerMap['nombre_completo'] ?? null);
        
        // Si nombre_completo está vacío pero tenemos nombres y apellidos separados
        if (empty($nombreCompleto) && isset($headerMap['apellidos'])) {
            $nombres = $this->getCellValue($row, $headerMap['nombre_completo'] ?? null);
            $apellidos = $this->getCellValue($row, $headerMap['apellidos']);
            
            if (!empty($nombres) || !empty($apellidos)) {
                $nombreCompleto = trim(($nombres ?? '') . ' ' . ($apellidos ?? ''));
            }
        }
        
        // Obtener codigo_ficha del encabezado o de los metadatos
        $codigoFicha = $this->getCellValue($row, $headerMap['codigo_ficha'] ?? null);
        if (empty($codigoFicha) && !empty($metadata['codigo_ficha'])) {
            $codigoFicha = $metadata['codigo_ficha'];
        }
        
        // Obtener nombre_programa del encabezado o de los metadatos
        $nombrePrograma = $this->getCellValue($row, $headerMap['nombre_programa'] ?? null);
        if (empty($nombrePrograma) && !empty($metadata['nombre_programa'])) {
            $nombrePrograma = $metadata['nombre_programa'];
        }
        
        return [
            'tipo_documento' => $this->getCellValue($row, $headerMap['tipo_documento'] ?? null),
            'numero_documento' => $this->getCellValue($row, $headerMap['numero_documento'] ?? null),
            'nombre_completo' => $nombreCompleto ?: null,
            'estado' => $this->getCellValue($row, $headerMap['estado'] ?? null) ?? 'por_inscribir',
            'codigo_ficha' => $codigoFicha,
            'nombre_programa' => $nombrePrograma,
        ];
    }

    private function rowIsEmpty(array $row): bool
    {
        foreach ($row as $value) {
            if ($value !== null && $value !== '') {
                return false;
            }
        }

        return true;
    }

    private function rowHasRequired(array $row): bool
    {
        return !empty($row['tipo_documento'])
            && !empty($row['numero_documento'])
            && !empty($row['nombre_completo'])
            && !empty($row['codigo_ficha']);
    }

    private function makeKey(array $row): string
    {
        return Str::lower(trim($row['tipo_documento'])) . '|' . trim($row['numero_documento']) . '|' . trim($row['codigo_ficha']);
    }

    private function getCellValue(array $row, $index): ?string
    {
        if ($index === null || !array_key_exists($index, $row)) {
            return null;
        }

        $value = $row[$index];

        if ($value === null) {
            return null;
        }

        if (is_numeric($value)) {
            $value = (string) ($value == (int) $value ? (int) $value : $value);
        }

        return trim((string) $value);
    }

    private function normalizeHeader($value): string
    {
        $value = trim((string) $value);

        if ($value === '') {
            return '';
        }

        $value = Str::lower($value);
        $value = str_replace(
            ['á', 'é', 'í', 'ó', 'ú', 'ñ'],
            ['a', 'e', 'i', 'o', 'u', 'n'],
            $value
        );
        $value = preg_replace('/[^a-z0-9]+/i', '_', $value);
        $value = trim($value, '_');

        return $value;
    }

    private function buildDescripcion(int $totalArchivos, array $totalesPorArchivo, int $totalRegistros): string
    {
        $detalleArchivos = [];
        foreach ($totalesPorArchivo as $archivo => $total) {
            $detalleArchivos[] = "{$archivo}={$total}";
        }

        $detalle = empty($detalleArchivos) ? 'Sin registros válidos por archivo' : implode(', ', $detalleArchivos);

        return "Se consolidaron: {$totalArchivos} archivos. Total por archivo: {$detalle}. Total preinscritos: {$totalRegistros}.";
    }
}
