<?php

namespace App\Http\Controllers\Admin;

use App\Exports\PresritosExport;
use App\Models\Exportacion;
use App\Models\Preinscrito;
use App\Services\ReportePresritoService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

/**
 * Controlador para gestionar exportaciones y reportes
 * Maneja la generación y descarga de Excel de preinscritos
 */
class ExportController
{
    use AuthorizesRequests;

    protected $reporteService;

    public function __construct(ReportePresritoService $reporteService)
    {
        $this->reporteService = $reporteService;
    }

    /**
     * Mostrar vista de opciones de reportes
     */
    public function reportes(Request $request)
    {
        Gate::authorize('preinscritos.export');

        $programas = \App\Models\Programa::all();
        $totalPreinscritos = Preinscrito::count();
        $totalExportaciones = Exportacion::preinscritos()->where('user_id', auth()->id())->count();
        $ultimaExportacion = Exportacion::preinscritos()
            ->where('user_id', auth()->id())
            ->latest()
            ->first();

        // Estadísticas para estadísticas del dashboard
        $estadisticas = [
            'total' => $totalPreinscritos,
            'inscrito' => Preinscrito::where('estado', 'inscrito')->count(),
            'por_inscribir' => Preinscrito::where('estado', 'por_inscribir')->count(),
            'retirado' => Preinscrito::where('estado', 'retirado')->count(),
            'cancelado' => Preinscrito::where('estado', 'cancelado')->count(),
            'con_novedad' => Preinscrito::whereHas('novedades')->count(),
        ];

        // Opciones para los filtros
        $estados = Preinscrito::getEstados();
        $tiposDocumento = Preinscrito::getTiposDocumento();

        // Construir query con filtros
        $query = Preinscrito::query();

        // Aplicar filtros
        if ($request->filled('programa_id')) {
            $query->where('programa_id', $request->programa_id);
        }

        if ($request->filled('estado')) {
            $query->where('estado', $request->estado);
        }

        if ($request->filled('tipo_documento')) {
            $query->where('tipo_documento', $request->tipo_documento);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nombres', 'like', "%$search%")
                  ->orWhere('apellidos', 'like', "%$search%")
                  ->orWhere('numero_documento', 'like', "%$search%")
                  ->orWhere('correo_principal', 'like', "%$search%");
            });
        }

        // Obtener preinscritos paginados
        $preinscritos = $query->orderBy('created_at', 'desc')->paginate(15);

        return view('admin.preinscritos.reportes', compact(
            'programas',
            'totalPreinscritos',
            'totalExportaciones',
            'ultimaExportacion',
            'estadisticas',
            'estados',
            'tiposDocumento',
            'preinscritos'
        ));
    }

    /**
     * Exportar preinscritos a Excel
     */
    public function exportar(Request $request)
    {
        Gate::authorize('preinscritos.export');

        try {
            // Validar y preparar filtros
            $filtros = $this->validarFiltros($request);

            // Obtener preinscritos según filtros
            $preinscritos = $this->reporteService->obtenerPrescritos($filtros);

            // Si no hay registros, retornar error
            if ($preinscritos->isEmpty()) {
                return redirect()->route('preinscritos.reportes')
                    ->with('error', 'No hay registros que cumplan con los filtros especificados.');
            }

            // Construir reporte
            $headerReporte = $this->reporteService->obtenerHeaderReporte($preinscritos);
            $datosReporte = $this->reporteService->prepararDatosReporte($preinscritos);

            // Generar nombre del archivo
            $nombreArchivo = $this->generarNombreArchivo();

            // Registrar exportación en BD
            $exportacion = $this->registrarExportacion(
                $filtros,
                $preinscritos->count(),
                $nombreArchivo
            );

            // Guardar Excel en storage
            Excel::store(
                new PresritosExport($headerReporte, $datosReporte, $preinscritos->count()),
                "exports/{$nombreArchivo}",
                'local'
            );

            return redirect()->route('preinscritos.reportes')
                ->with('success', 'Reporte generado correctamente.')
                ->with('download_url', route('preinscritos.exportaciones.descargar', $exportacion))
                ->with('download_name', $nombreArchivo);

        } catch (\Exception $e) {
            return redirect()->route('preinscritos.reportes')
                ->with('error', 'Error al generar el reporte: ' . $e->getMessage());
        }
    }

    /**
     * Registrar reporte solo en base de datos
     */
    public function reportar(Request $request)
    {
        Gate::authorize('preinscritos.export');

        try {
            $filtros = $this->validarFiltros($request);
            $preinscritos = $this->reporteService->obtenerPrescritos($filtros);

            if ($preinscritos->isEmpty()) {
                return redirect()->route('preinscritos.reportes')
                    ->with('error', 'No hay registros que cumplan con los filtros especificados.');
            }

            $nombreArchivo = $this->generarNombreArchivo('solo_bd');

            $this->registrarExportacion(
                $filtros,
                $preinscritos->count(),
                $nombreArchivo
            );

            return redirect()->route('preinscritos.reportes')
                ->with('success', 'Reporte guardado en base de datos.');

        } catch (\Exception $e) {
            return redirect()->route('preinscritos.reportes')
                ->with('error', 'Error al registrar el reporte: ' . $e->getMessage());
        }
    }

    /**
     * Validar filtros recibidos desde el formulario
     */
    private function validarFiltros(Request $request): array
    {
        return [
            'programa_id' => $request->input('programa_id'),
            'estado' => $request->input('estado'),
            'tipo_documento' => $request->input('tipo_documento'),
            'search' => $request->input('search'),
        ];
    }

    /**
     * Generar nombre del archivo con timestamp
     */
    private function generarNombreArchivo(?string $sufijo = null): string
    {
        $timestamp = now()->format('Ymd_His');
        $base = "reporte_preinscritos_{$timestamp}";
        if ($sufijo) {
            $base .= "_{$sufijo}";
        }
        return "{$base}.xlsx";
    }

    /**
     * Registrar la exportación en la base de datos
     */
    private function registrarExportacion(array $filtros, int $totalRegistros, string $nombreArchivo): Exportacion
    {
        $filtrosSerialized = $this->reporteService->serializarFiltros($filtros);

        return Exportacion::create([
            'user_id' => auth()->id(),
            'tipo' => 'preinscritos',
            'filtros_aplicados' => $filtrosSerialized,
            'total_registros' => $totalRegistros,
            'nombre_archivo' => $nombreArchivo,
            'ruta_archivo' => "exports/{$nombreArchivo}",
        ]);
    }

    /**
     * Listar historial de exportaciones del usuario
     */
    public function historial()
    {
        Gate::authorize('preinscritos.export');

        $exportaciones = Exportacion::preinscritos()
            ->where('user_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('admin.preinscritos.historial-exportaciones', compact('exportaciones'));
    }

    /**
     * Descargar archivo de exportación
     */
    public function descargar(Exportacion $exportacion)
    {
        Gate::authorize('preinscritos.export');

        if ($exportacion->user_id !== auth()->id()) {
            abort(403);
        }

        if (!Storage::disk('local')->exists($exportacion->ruta_archivo)) {
            return redirect()->route('preinscritos.reportes')
                ->with('error', 'El archivo solicitado no existe.');
        }

        return Storage::disk('local')->download(
            $exportacion->ruta_archivo,
            $exportacion->nombre_archivo
        );
    }
}
