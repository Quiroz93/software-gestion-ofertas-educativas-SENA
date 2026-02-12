@extends('layouts.admin')

@section('title', 'Estadísticas de Preinscritos')

@section('content_header')
<h1 class="m-0">Estadísticas de Preinscritos</h1>
@stop

@section('content')
<div class="container-fluid">
    @include('admin.estadisticas._kpis', ['kpis' => $kpis])

    <div class="row mb-4">
        <div class="col-md-6">
            <div class="card shadow-sm mb-3">
                <div class="card-header bg-sena text-white">Preinscritos por Programa (Top 10)</div>
                <div class="card-body">
                    <ul class="list-group mb-3">
                        @foreach($kpis['top_programas'] as $row)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            {{ $row['programa'] }}
                            <span class="badge bg-primary rounded-pill">{{ $row['total'] }}</span>
                        </li>
                        @endforeach
                    </ul>
                    <canvas id="graficoProgramas" height="220"></canvas>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card shadow-sm mb-3">
                <div class="card-header bg-sena text-white">Evolución Mensual (12 meses)</div>
                <div class="card-body">
                    @if(count($kpis['evolucion']) > 1)
                        <canvas id="graficoEvolucion" height="220"></canvas>
                    @elseif(count($kpis['evolucion']) === 1)
                        <canvas id="graficoEvolucion" height="220"></canvas>
                        <div class="alert alert-warning mt-3">
                            No hay datos históricos suficientes para mostrar una evolución mensual. Se muestra solo el mes actual.
                        </div>
                    @else
                        <div class="alert alert-info">
                            No existen datos de evolución mensual. Mostrando datos de prueba.
                        </div>
                        <canvas id="graficoEvolucion" height="220"></canvas>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-md-6">
            <div class="card shadow-sm mb-3">
                <div class="card-header bg-sena text-white">Preinscritos por Estado</div>
                <div class="card-body">
                    <canvas id="graficoEstados" height="220"></canvas>
                    <table class="table table-bordered table-sm mt-3">
                        <thead>
                            <tr>
                                <th>Estado</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($kpis['por_estado'] as $estado => $total)
                                <tr>
                                    <td>{{ $estado }}</td>
                                    <td>{{ $total }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card shadow-sm mb-3">
                <div class="card-header bg-sena text-white">Preinscritos por Programa (Todos)</div>
                <div class="card-body">
                    <table class="table table-bordered table-sm">
                        <thead>
                            <tr>
                                <th>Programa</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($kpis['por_programa'] as $programa_id => $total)
                            <tr>
                                <td>{{ $programas[$programa_id] ?? 'N/A' }}</td>
                                <td>{{ $total }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="row mb-4">
        <div class="row mb-4">
            <div class="col-12">
                <div class="card shadow-sm mb-3">
                    <div class="card-header bg-sena text-white">Comparativo de Inscritos, Faltantes y Rechazados por Programa</div>
                    <div class="card-body">
                        <canvas id="graficoComparativoProgramas" height="320"></canvas>
                        <table class="table table-bordered table-sm mt-3">
                            <thead>
                                <tr>
                                    <th>Programa</th>
                                    <th>Inscritos</th>
                                    <th>Faltantes</th>
                                    <th>Rechazados</th>
                                </tr>
                            </thead>
                            <tbody>
                                @for($i = 0; $i < count($kpis['grafica_programas']['nombres']); $i++)
                                    <tr>
                                        <td>{{ $kpis['grafica_programas']['nombres'][$i] }}</td>
                                        <td>{{ $kpis['grafica_programas']['inscritos'][$i] }}</td>
                                        <td>{{ $kpis['grafica_programas']['faltantes'][$i] }}</td>
                                        <td>{{ $kpis['grafica_programas']['rechazados'][$i] }}</td>
                                    </tr>
                                @endfor
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        window.estadisticas = @json($kpis);
        // Datos de prueba para evolución mensual si no hay datos
        if (!window.estadisticas.evolucion || Object.keys(window.estadisticas.evolucion).length === 0) {
            window.estadisticas.evolucion = {
                '2025-03': 10,
                '2025-04': 15,
                '2025-05': 20,
                '2025-06': 18,
                '2025-07': 22,
                '2025-08': 25,
                '2025-09': 30,
                '2025-10': 28,
                '2025-11': 35,
                '2025-12': 40,
                '2026-01': 50,
                '2026-02': 265
            };
        }
        // Datos de prueba para gráfico de estados si no hay datos
        if (!window.estadisticas.por_estado || Object.keys(window.estadisticas.por_estado).length === 0) {
            window.estadisticas.por_estado = {
                'inscrito': 120,
                'con_novedad': 15,
                'rechazado': 8,
                'pendiente': 5
            };
        }
    </script>
    @vite(['resources/js/admin/estadisticas.js'])
    @stop