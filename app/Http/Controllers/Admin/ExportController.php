<?php

namespace App\Http\Controllers\Admin;

use App\Exports\PresritosExport;
use App\Models\Exportacion;
use App\Models\Preinscrito;
use App\Services\ReportePresritoService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
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
    public function reportes()
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
        ];

        return view('admin.preinscritos.reportes', compact(
            'programas',
            'totalPreinscritos',
            'totalExportaciones',
            'ultimaExportacion',
            'estadisticas'
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

            // Descargar Excel
            return Excel::download(
                new PresritosExport($headerReporte, $datosReporte, $preinscritos->count()),
                $nombreArchivo
            );

        } catch (\Exception $e) {
            return redirect()->route('preinscritos.reportes')
                ->with('error', 'Error al generar el reporte: ' . $e->getMessage());
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
    private function generarNombreArchivo(): string
    {
        $timestamp = now()->format('Ymd_His');
        return "reporte_preinscritos_{$timestamp}.xlsx";
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
}
