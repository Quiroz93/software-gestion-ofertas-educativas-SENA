@extends('layouts.admin')

@section('title', 'Historial de Exportaciones')

@section('content_header')
<div class="d-flex justify-content-between align-items-center">
    <h1 class="m-0">
        <i class="fas fa-history text-primary"></i>
        Historial de Exportaciones
    </h1>
    <a href="{{ route('preinscritos.reportes') }}" class="btn btn-outline-secondary">
        <i class="fas fa-arrow-left"></i>
        Volver
    </a>
</div>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card card-outline card-primary">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-table"></i>
                        Mis Exportaciones
                    </h3>
                </div>

                <div class="card-body">
                    @if($exportaciones->isEmpty())
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle"></i>
                            No has realizado exportaciones aún.
                        </div>
                    @else
                        <div class="table-responsive">
                            <table class="table table-hover table-sm">
                                <thead class="table-light">
                                    <tr>
                                        <th><i class="fas fa-calendar"></i> Fecha</th>
                                        <th><i class="fas fa-file-excel"></i> Archivo</th>
                                        <th><i class="fas fa-list"></i> Registros</th>
                                        <th><i class="fas fa-filter"></i> Filtros Aplicados</th>
                                        <th><i class="fas fa-tools"></i> Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($exportaciones as $exportacion)
                                        <tr>
                                            <td>
                                                <small class="text-muted">
                                                    {{ $exportacion->created_at->format('d/m/Y') }}<br>
                                                    <strong>{{ $exportacion->created_at->format('H:i:s') }}</strong>
                                                </small>
                                            </td>
                                            <td>
                                                <code class="text-break">{{ $exportacion->nombre_archivo }}</code>
                                            </td>
                                            <td>
                                                <span class="badge bg-primary">{{ $exportacion->total_registros }}</span>
                                            </td>
                                            <td>
                                                <small>
                                                    @if($exportacion->filtros_aplicados && isset($exportacion->filtros_aplicados['sin_filtros']))
                                                        <span class="badge bg-secondary">Sin filtros</span>
                                                    @else
                                                        @if($exportacion->filtros_aplicados)
                                                            @foreach($exportacion->filtros_aplicados as $clave => $valor)
                                                                <span class="badge bg-info">
                                                                    <strong>{{ ucfirst($clave) }}:</strong> {{ $valor }}
                                                                </span>
                                                            @endforeach
                                                        @else
                                                            <span class="text-muted">--</span>
                                                        @endif
                                                    @endif
                                                </small>
                                            </td>
                                            <td>
                                                <button class="btn btn-xs btn-outline-info" 
                                                        onclick="mostrarDetalles({{ $exportacion->id }})"
                                                        title="Ver detalles">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Paginación -->
                        <div class="mt-3">
                            {{ $exportaciones->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function mostrarDetalles(id) {
        Swal.fire({
            title: 'Detalles de Exportación',
            text: 'ID: ' + id,
            icon: 'info',
            confirmButtonText: 'Cerrar'
        });
    }
</script>
@endsection
