<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\StorePresritoRequest;
use App\Http\Requests\UpdatePresritoRequest;
use App\Exports\PreinscritosPlantillaExport;
use App\Imports\RawArrayImport;
use App\Models\Preinscrito;
use App\Models\PreinscritoRechazado;
use App\Models\TipoNovedad;
use App\Models\Programa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;

/**
 * Controlador para la gestión de Preinscritos
 * Gestiona las operaciones CRUD completas del módulo de aprendices preinscritos
 * 
 * LÓGICA DE EDICIÓN MEJORADA:
 * 1. Al cargar edit(): se guardan datos originales en JavaScript
 * 2. Al enviar formulario: se comparan datos originales vs editados
 * 3. Si cambió documento o nombre/apellidos: SweetAlert ruidosa (warning)
 * 4. Si NO cambió esos datos: SweetAlert simple (info)
 * 5. Si usuario cancela: no se guardan cambios
 * 6. Si usuario confirma: 
 *    - Si hay cambios sensibles: se valida que documento no sea duplicado
 *    - Si NO hay cambios sensibles: se actualiza directamente
 */
class PreinscritoController extends \App\Http\Controllers\Controller
{
    /**
     * Mostrar la lista de aprendices preinscritos
     */
    public function index(Request $request)
    {
        Gate::authorize('preinscritos.view');

        $query = Preinscrito::with('programa', 'createdBy', 'updatedBy');

        if ($request->filled('programa_id')) {
            $query->byPrograma($request->programa_id);
        }
        if ($request->filled('estado')) {
            $query->byEstado($request->estado);
        }
        if ($request->filled('tipo_documento')) {
            $query->byTipoDocumento($request->tipo_documento);
        }
        if ($request->filled('numero_documento')) {
            $query->byNumeroDocumento($request->numero_documento);
        }
        if ($request->filled('nombre')) {
            $query->byNombre($request->nombre);
        }
        if ($request->filled('tipo_novedad')) {
            $query->byTipoNovedad($request->tipo_novedad);
        }
        if ($request->filled('novedad_resuelta')) {
            $query->byNovedadResuelta($request->novedad_resuelta === 'pendiente' ? false : true);
        }

        $preinscritos = $query->paginate(15);
        $programas = Programa::all();
        $estados = Preinscrito::getEstados();
        $tiposDocumento = Preinscrito::getTiposDocumento();
        $tiposNovedades = Preinscrito::getTiposNovedades();

        return view('admin.preinscritos.index', compact('preinscritos', 'programas', 'estados', 'tiposDocumento', 'tiposNovedades'));
    }

    /**
     * Formulario de carga masiva desde archivo externo
     */
    public function importForm()
    {
        Gate::authorize('preinscritos.import');

        return view('admin.preinscritos.import');
    }

    /**
     * Descargar plantilla de carga masiva
     */
    public function downloadPlantilla()
    {
        Gate::authorize('preinscritos.import');

        return Excel::download(new PreinscritosPlantillaExport(), 'plantilla_preinscritos.xlsx');
    }

    /**
     * Procesar carga masiva desde archivos Excel
     */
    public function importStore(Request $request)
    {
        Gate::authorize('preinscritos.import');

        $request->validate([
            'archivos' => ['required'],
            'archivos.*' => ['file', 'mimes:xlsx,xls,csv'],
        ]);

        $totales = 0;
        $insertados = 0;
        $rechazados = 0;

        foreach ($request->file('archivos', []) as $archivo) {
            $sheets = Excel::toArray(new RawArrayImport(), $archivo);
            $rows = $sheets[0] ?? [];

            if (empty($rows)) {
                continue;
            }

            [$headerIndex, $headerMap] = $this->detectHeaderRow($rows);

            if ($headerIndex === null) {
                $rechazados += count($rows);
                continue;
            }

            for ($i = $headerIndex + 1; $i < count($rows); $i++) {
                $row = $rows[$i];
                $parsed = $this->parseRow($row, $headerMap);

                if ($parsed['vacio']) {
                    continue;
                }

                $totales++;

                if (!$parsed['valido']) {
                    $this->registrarRechazado($parsed, $i + 1, 'datos_incompletos');
                    $rechazados++;
                    continue;
                }

                if (Preinscrito::documentoExiste($parsed['numero_documento'])) {
                    $this->registrarRechazado($parsed, $i + 1, 'documento_duplicado');
                    $rechazados++;
                    continue;
                }

                $programa = $this->resolverPrograma($parsed);
                if (!$programa) {
                    // Detectar si hay inconsistencia entre nombre y ficha
                    $motivo = 'sin_programa_asignado';
                    if (!empty($parsed['codigo_ficha']) && !empty($parsed['programa_nombre'])) {
                        $motivo = 'inconsistencia_programa'; // Posible modificación manual
                    }
                    $this->registrarRechazado($parsed, $i + 1, $motivo);
                    $rechazados++;
                    continue;
                }

                Preinscrito::create([
                    'nombres' => $parsed['nombres'],
                    'apellidos' => $parsed['apellidos'],
                    'tipo_documento' => $parsed['tipo_documento'],
                    'numero_documento' => $parsed['numero_documento'],
                    'celular_principal' => $parsed['celular_principal'],
                    'correo_principal' => $parsed['correo_principal'],
                    'programa_id' => $programa->id,
                    'estado' => $parsed['estado'] ?? 'por_inscribir',
                    'created_by' => Auth::id(),
                    'updated_by' => Auth::id(),
                ]);

                $insertados++;
            }
        }

        $mensaje = "Carga masiva finalizada. Registros procesados: {$totales}. Insertados: {$insertados}. Rechazados: {$rechazados}.";

        return redirect()->route('preinscritos.index')->with('success', $mensaje);
    }

    /**
     * Mostrar el formulario para crear un nuevo preinscrito
     */
    public function create()
    {
        Gate::authorize('preinscritos.create');

        $programas = Programa::all();
        $estados = Preinscrito::getEstados();
        $tiposDocumento = Preinscrito::getTiposDocumento();
        $tiposNovedades = TipoNovedad::query()
            ->activos()
            ->orderBy('nombre')
            ->get();

        return view('admin.preinscritos.create', compact('programas', 'estados', 'tiposDocumento', 'tiposNovedades'));
    }

    /**
     * Almacenar un nuevo preinscrito en la base de datos
     * SOLO VALIDA DOCUMENTO DUPLICADO EN CREACIÓN
     */
    public function store(StorePresritoRequest $request)
    {
        try {
            DB::beginTransaction();

            // Validación de documento duplicado SOLO en creación
            if (Preinscrito::documentoExiste($request->numero_documento)) {
                DB::rollBack();
                return redirect()->back()
                    ->with('error', 'El número de documento ya está registrado.')
                    ->withInput();
            }

            $preinscrito = Preinscrito::create($request->validated());

            if ($request->has('tiene_novedad') && $request->tiene_novedad) {
                $novedad = $preinscrito->novedades()->create([
                    'tipo_novedad_id' => $request->tipo_novedad_id,
                    'estado' => $request->novedad_estado,
                    'descripcion' => $request->novedad_descripcion,
                    'created_by' => Auth::id(),
                    'updated_by' => Auth::id(),
                ]);

                if ($novedad) {
                    $novedad->historial()->create([
                        'estado_anterior' => null,
                        'estado_nuevo' => $request->novedad_estado,
                        'comentario' => 'Novedad creada al momento de registrar el preinscrito',
                        'changed_by' => Auth::id(),
                    ]);
                }
            }

            DB::commit();

            $mensaje = 'Preinscrito creado exitosamente.';
            if ($request->has('tiene_novedad') && $request->tiene_novedad) {
                $mensaje .= ' Se registró la novedad asociada.';
            }

            return redirect()->route('preinscritos.index')
                ->with('success', $mensaje);
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Error al crear el preinscrito: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Mostrar los detalles de un preinscrito
     */
    public function show(Preinscrito $preinscrito)
    {
        $presrito = $preinscrito;
        Gate::authorize('preinscritos.view', $presrito);
        $presrito->load([
            'programa', 
            'createdBy', 
            'updatedBy',
            'novedades.tipoNovedad',
            'novedades.createdBy',
            'novedades.historial.changedBy'
        ]);

        return view('admin.preinscritos.show', compact('presrito'));
    }

    /**
     * Mostrar el formulario para editar un preinscrito
     * Pasa datos originales para comparación en JavaScript
     */
    public function edit(Preinscrito $preinscrito)
    {
        $presrito = $preinscrito;
        Gate::authorize('preinscritos.edit', $presrito);

        $programas = Programa::all();
        $estados = Preinscrito::getEstados();
        $tiposDocumento = Preinscrito::getTiposDocumento();
        $tiposNovedades = TipoNovedad::query()
            ->activos()
            ->orderBy('nombre')
            ->get();

        // Datos originales para comparación en JavaScript
        $datosOriginales = [
            'numero_documento' => $presrito->numero_documento,
            'nombres' => $presrito->nombres,
            'apellidos' => $presrito->apellidos,
        ];

        return view('admin.preinscritos.edit', compact('presrito', 'programas', 'estados', 'tiposDocumento', 'tiposNovedades', 'datosOriginales'));
    }

    /**
     * Actualizar un preinscrito en la base de datos
     * 
     * FLUJO:
     * 1. Recibe flag "cambios_sensibles" desde JavaScript
     * 2. Si hay cambios sensibles (doc/nombre/apellidos) → VALIDA documento duplicado
     * 3. Si NO hay cambios sensibles → ACTUALIZA directamente sin validar
     * 4. Guarda novedades si las hay
     */
    public function update(UpdatePresritoRequest $request, Preinscrito $preinscrito)
    {
        $presrito = $preinscrito;
        try {
            DB::beginTransaction();

            // Verificar si hay cambios sensibles (documento, nombres, apellidos)
            $tieneChangiosSensibles = $request->has('cambios_sensibles') && $request->cambios_sensibles === 'true';

            // SOLO si hay cambios sensibles, validar documento duplicado
            if ($tieneChangiosSensibles) {
                $docOriginal = $request->input('documento_original');
                $docNuevo = (string)$request->numero_documento;

                // Si el documento fue modificado, validar que no exista
                if ((string)$docOriginal !== $docNuevo) {
                    if (Preinscrito::documentoExiste($docNuevo, $presrito->id)) {
                        DB::rollBack();
                        return redirect()->back()
                            ->with('error', 'El número de documento ya está registrado en la base de datos.')
                            ->withInput();
                    }
                }
            }

            // Actualizar el preinscrito
            $presrito->update($request->validated());

            // Crear novedad si se marcó la opción
            if ($request->has('tiene_novedad') && $request->tiene_novedad) {
                $novedad = $presrito->novedades()->create([
                    'tipo_novedad_id' => $request->tipo_novedad_id,
                    'estado' => $request->novedad_estado,
                    'descripcion' => $request->novedad_descripcion,
                    'created_by' => Auth::id(),
                    'updated_by' => Auth::id(),
                ]);

                // Registrar historial de la creación (estado_anterior = null porque es nueva)
                if ($novedad) {
                    $novedad->historial()->create([
                        'estado_anterior' => null, // NULL indica que es una creación nueva
                        'estado_nuevo' => $request->novedad_estado,
                        'comentario' => 'Novedad creada durante la edición del preinscrito',
                        'changed_by' => Auth::id(),
                    ]);
                }
            }

            DB::commit();

            $mensaje = 'Preinscrito actualizado exitosamente.';
            if ($request->has('tiene_novedad') && $request->tiene_novedad) {
                $mensaje .= ' Se registró la novedad asociada.';
            }

            return redirect()->route('preinscritos.index')
                ->with('success', $mensaje);
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Error al actualizar el preinscrito: ' . $e->getMessage())
                ->withInput();
        }
    }

    private function detectHeaderRow(array $rows): array
    {
        $max = min(count($rows), 15);
        for ($i = 0; $i < $max; $i++) {
            $headerMap = $this->buildHeaderMap($rows[$i] ?? []);
            if ($this->headerValido($headerMap)) {
                return [$i, $headerMap];
            }
        }

        return [null, []];
    }

    private function buildHeaderMap(array $row): array
    {
        $aliases = [
            'tipo_documento' => ['tipo_documento', 'tipo documento', 'tipo doc', 'tipo doc.'],
            'numero_documento' => ['numero_documento', 'numero documento', 'número documento', 'documento', 'nro documento', 'no documento'],
            'nombres' => ['nombres', 'nombre', 'primer nombre'],
            'apellidos' => ['apellidos', 'apellido', 'primer apellido'],
            'nombre_completo' => ['nombre completo', 'nombres y apellidos', 'nombre y apellido'],
            'correo_principal' => ['correo', 'correo principal', 'email', 'e-mail'],
            'celular_principal' => ['celular', 'teléfono', 'telefono', 'movil', 'celular principal'],
            'programa_nombre' => ['programa', 'nombre programa', 'denominacion programa', 'denominacion_programa'],
            'codigo_ficha' => ['codigo ficha', 'código ficha', 'ficha', 'numero ficha', 'número ficha', 'codigo_ficha'],
            'estado' => ['estado'],
        ];

        $map = [];
        foreach ($row as $index => $value) {
            $normalized = $this->normalizeHeader($value);
            foreach ($aliases as $key => $names) {
                foreach ($names as $name) {
                    if ($normalized === $this->normalizeHeader($name) && !array_key_exists($key, $map)) {
                        $map[$key] = $index;
                    }
                }
            }
        }

        return $map;
    }

    private function headerValido(array $headerMap): bool
    {
        $tieneIdentificacion = isset($headerMap['tipo_documento'], $headerMap['numero_documento']);
        $tieneNombre = isset($headerMap['nombres'], $headerMap['apellidos']) || isset($headerMap['nombre_completo']);
        $tienePrograma = isset($headerMap['codigo_ficha']) || isset($headerMap['programa_nombre']);

        return $tieneIdentificacion && $tieneNombre && $tienePrograma;
    }

    private function parseRow(array $row, array $headerMap): array
    {
        $get = function (string $key) use ($row, $headerMap) {
            if (!isset($headerMap[$key])) {
                return null;
            }
            return isset($row[$headerMap[$key]]) ? trim((string) $row[$headerMap[$key]]) : null;
        };

        $nombreCompleto = $get('nombre_completo');
        $nombres = $get('nombres');
        $apellidos = $get('apellidos');

        if (!$nombres && !$apellidos && $nombreCompleto) {
            $partes = preg_split('/\s+/', $nombreCompleto, -1, PREG_SPLIT_NO_EMPTY);
            if (count($partes) > 1) {
                $apellidos = array_pop($partes);
                $nombres = implode(' ', $partes);
            } else {
                $nombres = $nombreCompleto;
            }
        }

        $tipoDocumento = $this->normalizeTipoDocumento($get('tipo_documento'));
        $numeroDocumento = $get('numero_documento');

        $data = [
            'nombres' => $nombres,
            'apellidos' => $apellidos,
            'tipo_documento' => $tipoDocumento,
            'numero_documento' => $numeroDocumento,
            'correo_principal' => $get('correo_principal'),
            'celular_principal' => $get('celular_principal'),
            'programa_nombre' => $get('programa_nombre'),
            'codigo_ficha' => $get('codigo_ficha'),
            'estado' => $get('estado'),
        ];

        $vacio = collect($data)->filter()->isEmpty();
        $valido = !empty($data['tipo_documento'])
            && !empty($data['numero_documento'])
            && !empty($data['nombres'])
            && !empty($data['apellidos']);

        return $data + [
            'vacio' => $vacio,
            'valido' => $valido,
        ];
    }

    private function resolverPrograma(array $data): ?Programa
    {
        // Si viene numero_ficha Y programa_nombre, validar que coincidan (plantilla con VLOOKUP)
        if (!empty($data['codigo_ficha']) && !empty($data['programa_nombre'])) {
            $programa = Programa::where('numero_ficha', $data['codigo_ficha'])
                ->where('estado', 'activo')
                ->first();
            
            // Validar que el nombre coincida (tolerancia de espacios y mayúsculas)
            if ($programa) {
                $nombreDb = strtolower(trim($programa->nombre));
                $nombreExcel = strtolower(trim($data['programa_nombre']));
                
                // Si no coinciden exactamente, rechazar (posible modificación manual)
                if ($nombreDb !== $nombreExcel) {
                    return null; // Será rechazado por inconsistencia
                }
                
                return $programa;
            }
            
            return null;
        }
        
        // Método original: buscar solo por codigo_ficha
        if (!empty($data['codigo_ficha'])) {
            return Programa::where('numero_ficha', $data['codigo_ficha'])
                ->where('estado', 'activo')
                ->first();
        }

        // Método original: buscar solo por nombre (menos confiable)
        if (!empty($data['programa_nombre'])) {
            return Programa::where('nombre', 'like', '%' . $data['programa_nombre'] . '%')
                ->where('estado', 'activo')
                ->first();
        }

        return null;
    }

    private function registrarRechazado(array $data, int $fila, string $motivo): void
    {
        PreinscritoRechazado::create([
            'nombre_completo' => trim(($data['nombres'] ?? '') . ' ' . ($data['apellidos'] ?? '')),
            'tipo_documento' => $data['tipo_documento'] ?? null,
            'numero_documento' => $data['numero_documento'] ?? null,
            'telefono' => $data['celular_principal'] ?? null,
            'programa' => $data['programa_nombre'] ?? ($data['codigo_ficha'] ?? null),
            'correo' => $data['correo_principal'] ?? null,
            'motivo' => $motivo,
            'fila_excel' => $fila,
            'datos_json' => json_encode($data, JSON_UNESCAPED_UNICODE),
            'created_by' => Auth::id(),
        ]);
    }

    private function normalizeHeader(?string $value): string
    {
        $value = $value ?? '';
        $value = Str::of($value)->lower()->trim()->replace(['.', ':', '-', '_'], ' ')->toString();
        $value = Str::of($value)->replaceMatches('/\s+/', ' ')->toString();
        return Str::of($value)->ascii()->toString();
    }

    private function normalizeTipoDocumento(?string $value): ?string
    {
        if (!$value) {
            return null;
        }

        $value = Str::of($value)->lower()->trim()->toString();
        $map = [
            'cc' => 'cc',
            'cedula' => 'cc',
            'cédula' => 'cc',
            'ti' => 'ti',
            'tarjeta' => 'ti',
            'ce' => 'ce',
            'ppt' => 'ppt',
            'pas' => 'pas',
            'pasaporte' => 'pas',
            'pa' => 'pa',
            'pep' => 'pep',
            'nit' => 'nit',
        ];

        return $map[$value] ?? $value;
    }

    /**
     * Eliminar un preinscrito (Soft Delete)
     */
    public function destroy(Preinscrito $preinscrito)
    {
        $presrito = $preinscrito;
        Gate::authorize('preinscritos.delete', $presrito);

        try {
            DB::beginTransaction();

            $presrito->delete();

            DB::commit();

            return redirect()->route('preinscritos.index')
                ->with('success', 'Preinscrito eliminado exitosamente.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Error al eliminar el preinscrito: ' . $e->getMessage());
        }
    }

    /**
     * Mostrar reporte de preinscritos con filtros
     */
    public function reportes(Request $request)
    {
        Gate::authorize('preinscritos.view');

        $query = Preinscrito::with('programa');

        if ($request->filled('programa_id')) {
            $query->byPrograma($request->programa_id);
        }
        if ($request->filled('estado')) {
            $query->byEstado($request->estado);
        }
        if ($request->filled('tipo_documento')) {
            $query->byTipoDocumento($request->tipo_documento);
        }
        if ($request->filled('tipo_novedad')) {
            $query->byTipoNovedad($request->tipo_novedad);
        }
        if ($request->filled('novedad_resuelta')) {
            $query->byNovedadResuelta($request->novedad_resuelta === 'pendiente' ? false : true);
        }

        $preinscritos = $query->orderBy('programa_id')->get();
        $programas = Programa::all();
        $estados = Preinscrito::getEstados();
        $tiposDocumento = Preinscrito::getTiposDocumento();
        $tiposNovedades = Preinscrito::getTiposNovedades();

        $estadisticas = [
            'total' => $preinscritos->count(),
            'inscrito' => $preinscritos->where('estado', 'inscrito')->count(),
            'por_inscribir' => $preinscritos->where('estado', 'por_inscribir')->count(),
            'con_novedad' => $preinscritos->where('estado', 'con_novedad')->count(),
            'novedades_resueltas' => $preinscritos->where('novedad_resuelta', true)->count(),
            'novedades_pendientes' => $preinscritos->where('novedad_resuelta', false)->count(),
        ];

        return view('admin.preinscritos.reportes', compact('preinscritos', 'programas', 'estados', 'tiposDocumento', 'tiposNovedades', 'estadisticas'));
    }

    /**
     * Restaurar un preinscrito eliminado
     */
    public function restore($id)
    {
        Gate::authorize('preinscritos.restore');

        try {
            DB::beginTransaction();

            $presrito = Preinscrito::onlyTrashed()->findOrFail($id);
            $presrito->restore();

            DB::commit();

            return redirect()->route('preinscritos.index')
                ->with('success', 'Preinscrito restaurado exitosamente.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Error al restaurar el preinscrito: ' . $e->getMessage());
        }
    }
}
