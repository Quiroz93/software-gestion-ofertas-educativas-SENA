<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ImportPreinscritosConsolidacionRequest;
use App\Http\Requests\UpdateConsolidacionDetalleRequest;
use App\Imports\RawArrayImport;
use App\Models\ConsolidacionPreinscrito;
use App\Models\ConsolidacionPreinscritoDetalle;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
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

            [$headerIndex, $headerMap] = $this->detectHeader($rows);
            if ($headerIndex === null) {
                $erroresArchivos[] = "No se encontró encabezado válido en {$originalName}.";
                continue;
            }

            $validCount = 0;

            for ($i = $headerIndex + 1; $i < count($rows); $i++) {
                $row = $rows[$i];
                $mapped = $this->mapRow($row, $headerMap);

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

        return view('admin.preinscritos.consolidaciones.show', compact('consolidacion', 'detalles', 'estados'));
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

    private function detectHeader(array $rows): array
    {
        $requiredFields = ['tipo_documento', 'numero_documento', 'nombre_completo', 'estado', 'codigo_ficha'];

        foreach ($rows as $index => $row) {
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
            'tipo_documento' => ['tipo_documento', 'tipo_de_documento', 'tipo doc', 'tipodocumento', 'documento_tipo', 'tdoc'],
            'numero_documento' => ['numero_documento', 'n_documento', 'documento', 'num_documento', 'no_documento', 'documento_numero', 'numero de documento'],
            'nombre_completo' => ['nombre_completo', 'nombre', 'nombres', 'nombre y apellido', 'aprendiz', 'apellidos_nombres'],
            'estado' => ['estado', 'estado_aprendiz', 'estado_preinscripcion', 'estado preinscripcion'],
            'codigo_ficha' => ['codigo_ficha', 'ficha', 'codigo', 'codigo de ficha', 'ficha_codigo'],
            'nombre_programa' => ['nombre_programa', 'programa', 'programa_formacion', 'nombre de programa'],
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

    private function mapRow(array $row, array $headerMap): array
    {
        return [
            'tipo_documento' => $this->getCellValue($row, $headerMap['tipo_documento'] ?? null),
            'numero_documento' => $this->getCellValue($row, $headerMap['numero_documento'] ?? null),
            'nombre_completo' => $this->getCellValue($row, $headerMap['nombre_completo'] ?? null),
            'estado' => $this->getCellValue($row, $headerMap['estado'] ?? null),
            'codigo_ficha' => $this->getCellValue($row, $headerMap['codigo_ficha'] ?? null),
            'nombre_programa' => $this->getCellValue($row, $headerMap['nombre_programa'] ?? null),
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
