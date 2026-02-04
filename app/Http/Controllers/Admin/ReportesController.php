<?php

namespace App\Http\Controllers\Admin;

use App\Exports\PresritosExport;
use App\Http\Controllers\Controller;
use App\Models\Exportacion;
use App\Models\Preinscrito;
use App\Services\ReportePresritoService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;

/**
 * Controlador para gestionar reportes de preinscritos
 * Maneja visualización, exportación a Excel e impresión en PDF
 */
class ReportesController extends Controller
{
    use AuthorizesRequests;

    protected $reporteService;

    public function __construct(ReportePresritoService $reporteService)
    {
        $this->reporteService = $reporteService;
    }

    /**
     * Mostrar vista principal de reportes con filtros y estadísticas
     */
    public function index(Request $request)
    {
        Gate::authorize('preinscritos.export');

        $programas = \App\Models\Programa::all();
        $totalPreinscritos = Preinscrito::count();
        $totalExportaciones = Exportacion::preinscritos()
            ->where('user_id', Auth::user()->id)
            ->count();
        $ultimaExportacion = Exportacion::preinscritos()
            ->where('user_id', Auth::user()->id)
            ->latest()
            ->first();

        // Estadísticas generales
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
        $query = Preinscrito::with('programa');

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

        // Obtener preinscritos con paginación
        $preinscritos = $query->orderBy('created_at', 'desc')->get();

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
     * Generar reporte y guardarlo en BD (sin archivo físico)
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
                ->with('success', 'Reporte registrado correctamente en base de datos.');

        } catch (\Exception $e) {
            return redirect()->route('preinscritos.reportes')
                ->with('error', 'Error al registrar el reporte: ' . $e->getMessage());
        }
    }

    /**
     * Exportar preinscritos a Excel
     */
    public function exportarExcel(Request $request)
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
                ->with('success', 'Reporte Excel generado correctamente.')
                ->with('download_url', route('preinscritos.exportaciones.descargar', $exportacion))
                ->with('download_name', $nombreArchivo);

        } catch (\Exception $e) {
            return redirect()->route('preinscritos.reportes')
                ->with('error', 'Error al generar el reporte: ' . $e->getMessage());
        }
    }

    /**
     * Imprimir reporte en PDF
     */
    public function imprimir(Request $request)
    {
        Gate::authorize('preinscritos.export');

        try {
            // Validar y preparar filtros
            $filtros = $this->validarFiltros($request);

            // Obtener preinscritos según filtros
            $query = Preinscrito::with('programa');

            if ($request->filled('programa_id')) {
                $query->where('programa_id', $request->programa_id);
            }

            if ($request->filled('estado')) {
                $query->where('estado', $request->estado);
            }

            if ($request->filled('tipo_documento')) {
                $query->where('tipo_documento', $request->tipo_documento);
            }

            $preinscritos = $query->orderBy('created_at', 'desc')->get();

            // Si no hay registros, retornar error
            if ($preinscritos->isEmpty()) {
                return redirect()->route('preinscritos.reportes')
                    ->with('error', 'No hay registros que cumplan con los filtros especificados.');
            }

            // Estadísticas
            $estadisticas = [
                'total' => $preinscritos->count(),
                'inscrito' => $preinscritos->where('estado', 'inscrito')->count(),
                'por_inscribir' => $preinscritos->where('estado', 'por_inscribir')->count(),
                'con_novedad' => $preinscritos->filter(fn($p) => $p->novedades()->count() > 0)->count(),
            ];

            // Generar PDF
            $pdf = Pdf::loadView('admin.preinscritos.reportes-pdf', [
                'preinscritos' => $preinscritos,
                'estadisticas' => $estadisticas,
                'fecha' => now()->format('d/m/Y H:i:s')
            ]);

            $pdf->setPaper('a4', 'landscape');

            return $pdf->stream('reporte_preinscritos_' . now()->format('Ymd_His') . '.pdf');

        } catch (\Exception $e) {
            return redirect()->route('preinscritos.reportes')
                ->with('error', 'Error al generar el PDF: ' . $e->getMessage());
        }
    }

    /**
     * Listar historial de exportaciones del usuario
     */
    public function historial()
    {
        Gate::authorize('preinscritos.export');

        $exportaciones = Exportacion::preinscritos()
            ->where('user_id', Auth::user()->id)
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

        // Verificar que el usuario sea propietario
        if ($exportacion->user_id !== Auth::user()->id) {
            abort(403, 'No tienes permiso para descargar este archivo.');
        }

        // Verificar que el archivo existe
        if (!Storage::disk('local')->exists($exportacion->ruta_archivo)) {
            return redirect()->route('preinscritos.reportes')
                ->with('error', 'El archivo solicitado no existe o ha sido eliminado.');
        }

        return response()->download(
            storage_path('app/' . $exportacion->ruta_archivo),
            $exportacion->nombre_archivo
        );
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
            'user_id' => Auth::user()->id,
            'tipo' => 'preinscritos',
            'filtros_aplicados' => $filtrosSerialized,
            'total_registros' => $totalRegistros,
            'nombre_archivo' => $nombreArchivo,
            'ruta_archivo' => "exports/{$nombreArchivo}",
        ]);
    }
}
