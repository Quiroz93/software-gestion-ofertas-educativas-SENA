<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Models\Preinscrito;
use App\Models\Programa;
use Illuminate\Support\Facades\DB;
use App\Models\Oferta;
use Carbon\Carbon;

class EstadisticasPreinscritosController extends Controller
{
    public function index(Request $request)
    {
        Gate::authorize('preinscritos.estadisticas.view');

        // KPIs principales
        $total = Preinscrito::count();
        $porEstado = Preinscrito::select('estado', DB::raw('count(*) as total'))
            ->groupBy('estado')->pluck('total', 'estado');
        $porPrograma = Preinscrito::select('programa_id', DB::raw('count(*) as total'))
            ->groupBy('programa_id')->pluck('total', 'programa_id');
        $programasFicha = Programa::whereIn('id', $porPrograma->keys())->pluck('numero_ficha', 'id');
        $programasNombre = Programa::whereIn('id', $porPrograma->keys())->pluck('nombre', 'id');

        // Novedades (corregido: contar estado 'con_novedad')
        $conNovedad = Preinscrito::where('estado', 'con_novedad')->count();
        // Novedades resueltas: contar novedades con estado 'resuelta'
        $novedadResuelta = \App\Models\NovedadPreinscrito::where('estado', 'resuelta')->count();

        // Evolución mensual (últimos 12 meses)
        $evolucion = Preinscrito::select(
                DB::raw('DATE_FORMAT(created_at, "%Y-%m") as mes'),
                DB::raw('count(*) as total')
            )
            ->where('created_at', '>=', Carbon::now()->subMonths(12))
            ->groupBy('mes')
            ->orderBy('mes')
            ->pluck('total', 'mes');

        // Top 10 programas con más preinscritos
        $topProgramas = Preinscrito::select('programa_id', DB::raw('count(*) as total'))
            ->groupBy('programa_id')
            ->orderByDesc('total')
            ->take(10)
            ->get()
            ->map(function($row) use ($programasNombre) {
                return [
                    'programa' => $programasNombre[$row->programa_id] ?? 'N/A',
                    'total' => $row->total
                ];
            });

        // Inscritos, faltantes y rechazados por programa
        // Agrupar por programa y estado

        $estadosPorPrograma = Preinscrito::select('programa_id', 'estado', DB::raw('count(*) as total'))
            ->groupBy('programa_id', 'estado')
            ->get();

        $inscritosPorPrograma = [];
        $rechazadosPorPrograma = [];
        $faltantesPorPrograma = [];
        foreach ($estadosPorPrograma as $row) {
            if ($row->estado === 'inscrito') {
                $inscritosPorPrograma[$row->programa_id] = $row->total;
            }
        }

        // Sumar rechazados desde preinscritos_rechazados
        $rechazadosPorPrograma = [];
        $rechazadosRaw = DB::table('preinscritos_rechazados')
            ->select('programa', DB::raw('count(*) as total'))
            ->groupBy('programa')
            ->get();
        // Mapear nombre de programa a id si existe en la tabla programas
        $programasNombreToId = Programa::pluck('id', 'nombre');
        foreach ($rechazadosRaw as $row) {
            $programaNombre = $row->programa;
            $programaId = $programasNombreToId[$programaNombre] ?? null;
            if ($programaId) {
                $rechazadosPorPrograma[$programaId] = $row->total;
            }
        }

        // Faltantes: cupos - inscritos
        $cuposPorPrograma = Programa::pluck('cupos', 'id');
        $faltantesPorPrograma = [];
        foreach ($cuposPorPrograma as $id => $cupos) {
            $faltantesPorPrograma[$id] = max(0, ($cupos ?? 0) - ($inscritosPorPrograma[$id] ?? 0));
        }

        $kpis['grafica_programas'] = [
            'labels' => $programasFicha->values()->toArray(),
            'nombres' => $programasNombre->values()->toArray(),
            'inscritos' => [],
            'faltantes' => [],
            'rechazados' => [],
        ];
        foreach ($programasFicha as $id => $ficha) {
            $kpis['grafica_programas']['inscritos'][] = $inscritosPorPrograma[$id] ?? 0;
            $kpis['grafica_programas']['faltantes'][] = $faltantesPorPrograma[$id] ?? 0;
            $kpis['grafica_programas']['rechazados'][] = $rechazadosPorPrograma[$id] ?? 0;
        }

        $kpis = array_merge([
            'total' => $total,
            'por_estado' => $porEstado,
            'por_programa' => $porPrograma,
            'con_novedad' => $conNovedad,
            'novedad_resuelta' => $novedadResuelta,
            'evolucion' => $evolucion,
            'top_programas' => $topProgramas,
        ], $kpis);

        return view('admin.estadisticas.index', compact('kpis', 'programasFicha'));
    }

    /**
     * Endpoint para filtros dinámicos de la gráfica.
     * Devuelve años, ofertas y programas disponibles.
     */
    public function filtros(Request $request)
    {
        $anios = Oferta::select('año')->distinct()->orderBy('año', 'desc')->pluck('año');
        $ofertas = Oferta::select('id', 'nombre')->orderBy('nombre')->get();
        $programas = Programa::select('id', 'nombre')->orderBy('nombre')->get();

        return response()->json([
            'anios' => $anios,
            'ofertas' => $ofertas,
            'programas' => $programas,
        ]);
    }

    /**
     * Endpoint para métricas agregadas de la gráfica.
     * Valida parámetros y retorna datos agregados.
     */
    public function metricas(Request $request)
    {
        $anio = $request->input('anio');
        $ofertaId = $request->input('oferta_id');
        $programaId = $request->input('programa_id');

        // Validación básica
        if ($anio && !is_numeric($anio)) {
            return response()->json(['error' => 'Año inválido'], 422);
        }
        if ($ofertaId && !is_numeric($ofertaId)) {
            return response()->json(['error' => 'Oferta inválida'], 422);
        }
        if ($programaId && !is_numeric($programaId)) {
            return response()->json(['error' => 'Programa inválido'], 422);
        }

        // Subconsulta: Total de ofertas por año
        $ofertasPorAnio = DB::table('ofertas')
            ->select('año', DB::raw('COUNT(DISTINCT id) as total_ofertas'))
            ->when($anio, fn($q) => $q->where('año', $anio))
            ->groupBy('año');

        // Subconsulta: Total de inscritos por oferta
        $inscritosPorOferta = DB::table('inscritos')
            ->select('oferta_id', DB::raw('COUNT(DISTINCT user_id) as total_inscritos'))
            ->when($anio, fn($q) => $q->where('anio', $anio))
            ->when($ofertaId, fn($q) => $q->where('oferta_id', $ofertaId))
            ->when($programaId, fn($q) => $q->where('programa_id', $programaId))
            ->groupBy('oferta_id');

        // Subconsulta: Preinscritos rechazados, con novedad, novedades solucionadas y pendientes
        $preinscritosQuery = DB::table('preinscritos')
            ->join('programas', 'preinscritos.programa_id', '=', 'programas.id')
            ->join('oferta_programas', 'programas.id', '=', 'oferta_programas.programa_id')
            ->join('ofertas', 'oferta_programas.oferta_id', '=', 'ofertas.id')
            ->select(
                'ofertas.id as oferta_id',
                'ofertas.año',
                'programas.id as programa_id',
                DB::raw("COUNT(DISTINCT CASE WHEN preinscritos.estado = 'rechazado' THEN preinscritos.id END) as rechazados"),
                DB::raw("COUNT(DISTINCT CASE WHEN preinscritos.estado = 'con_novedad' THEN preinscritos.id END) as con_novedad"),
                DB::raw("COUNT(DISTINCT CASE WHEN np.estado = 'resuelta' THEN np.id END) as novedades_solucionadas"),
                DB::raw("COUNT(DISTINCT CASE WHEN np.estado = 'abierta' OR np.estado = 'en_gestion' THEN np.id END) as novedades_pendientes")
            )
            ->leftJoin('novedades_preinscritos as np', 'preinscritos.id', '=', 'np.preinscrito_id')
            ->when($anio, fn($q) => $q->where('ofertas.año', $anio))
            ->when($ofertaId, fn($q) => $q->where('ofertas.id', $ofertaId))
            ->when($programaId, fn($q) => $q->where('programas.id', $programaId))
            ->groupBy('ofertas.id', 'ofertas.año', 'programas.id');

        return response()->json([
            'ofertas_por_anio' => $ofertasPorAnio->get(),
            'inscritos_por_oferta' => $inscritosPorOferta->get(),
            'preinscritos_metricas' => $preinscritosQuery->get(),
        ]);
    }
}
