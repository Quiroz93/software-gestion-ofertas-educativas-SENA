<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Models\Preinscrito;
use App\Models\Programa;
use Illuminate\Support\Facades\DB;
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
        $rechazadosRaw = \DB::table('preinscritos_rechazados')
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
}
