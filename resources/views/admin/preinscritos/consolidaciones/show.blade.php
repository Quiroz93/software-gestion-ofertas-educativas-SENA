@extends('layouts.admin')

@section('title', 'Detalle de Consolidación')

@section('content_header')
<div class="d-flex justify-content-between align-items-center">
    <h1 class="m-0">
        <i class="bi bi-layers text-primary"></i>
        {{ $consolidacion->nombre_consolidacion }}
    </h1>
    <div class="d-flex gap-2">
        <a href="{{ route('preinscritos.consolidaciones.exportar', ['consolidacion' => $consolidacion->id] + request()->only(['codigo_ficha', 'estado'])) }}" 
           class="btn btn-success">
            <i class="bi bi-file-earmark-excel"></i>
            Exportar a Excel
        </a>
        <a href="{{ route('preinscritos.consolidaciones.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left"></i>
            Volver
        </a>
    </div>
</div>
@endsection

@section('content')
<div class="container-fluid">
    <div class="card mb-4">
        <div class="card-body">
            <div class="row">
                <div class="col-md-4">
                    <div class="text-muted">Usuario</div>
                    <div class="fw-semibold">{{ $consolidacion->createdBy?->name ?? 'N/A' }}</div>
                </div>
                <div class="col-md-4">
                    <div class="text-muted">Fecha</div>
                    <div class="fw-semibold">{{ $consolidacion->created_at->format('Y-m-d H:i') }}</div>
                </div>
                <div class="col-md-4">
                    <div class="text-muted">Resumen</div>
                    <div class="fw-semibold">
                        Archivos: {{ $consolidacion->total_archivos }} | Registros: {{ $consolidacion->total_registros }} | Descartados: {{ $consolidacion->total_descartados }}
                    </div>
                </div>
            </div>
            <div class="mt-3 text-muted">
                {{ $consolidacion->descripcion }}
            </div>
        </div>
    </div>

    @if(session('import_report'))
        <div class="card border-success mb-4">
            <div class="card-header bg-success text-white">
                Resultado de importación
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3">
                        <div class="text-muted">Total archivos</div>
                        <div class="fw-semibold">{{ session('import_report.total_archivos') }}</div>
                    </div>
                    <div class="col-md-3">
                        <div class="text-muted">Registros válidos</div>
                        <div class="fw-semibold">{{ session('import_report.total_registros') }}</div>
                    </div>
                    <div class="col-md-3">
                        <div class="text-muted">Descartados</div>
                        <div class="fw-semibold">{{ session('import_report.total_descartados') }}</div>
                    </div>
                    <div class="col-md-3">
                        <div class="text-muted">Duplicados</div>
                        <div class="fw-semibold">{{ session('import_report.duplicados') }}</div>
                    </div>
                </div>

                @if(!empty(session('import_report.errores_archivos')))
                    <hr>
                    <h6>Errores por archivo</h6>
                    <ul class="mb-0">
                        @foreach(session('import_report.errores_archivos') as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                @endif
            </div>
        </div>
    @endif

    <div class="card card-outline card-primary mb-4">
        <div class="card-header">
            <h3 class="card-title"><i class="bi bi-funnel"></i> Filtros de detalle</h3>
        </div>
        <div class="card-body">
            <form method="GET" action="{{ route('preinscritos.consolidaciones.show', $consolidacion) }}" class="row g-3">
                <div class="col-md-5">
                    <label class="form-label">Código de ficha</label>
                    <input type="text" name="codigo_ficha" class="form-control" value="{{ request('codigo_ficha') }}">
                </div>
                <div class="col-md-5">
                    <label class="form-label">Estado</label>
                    <select name="estado" class="form-select">
                        <option value="">-- Todos --</option>
                        @foreach($estados as $estado)
                            <option value="{{ $estado }}" {{ request('estado') == $estado ? 'selected' : '' }}>{{ $estado }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-search"></i>
                        Filtrar
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-body table-responsive">
            <table class="table table-striped align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Tipo Doc</th>
                        <th>Número</th>
                        <th>Nombre completo</th>
                        <th>Estado</th>
                        <th>Ficha</th>
                        <th>Programa</th>
                        <th>Observaciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($detalles as $detalle)
                        <tr>
                            <td>{{ $detalle->tipo_documento }}</td>
                            <td>{{ $detalle->numero_documento }}</td>
                            <td>{{ $detalle->nombre_completo }}</td>
                            <td>{{ $detalle->estado ?? 'N/A' }}</td>
                            <td>{{ $detalle->codigo_ficha ?? 'N/A' }}</td>
                            <td>{{ $detalle->nombre_programa ?? 'N/A' }}</td>
                            <td style="min-width: 260px;">
                                <form action="{{ route('preinscritos.consolidaciones.detalles.update', $detalle) }}" method="POST" class="d-flex gap-2">
                                    @csrf
                                    @method('PUT')
                                    <input type="text" name="observaciones" class="form-control form-control-sm" value="{{ $detalle->observaciones }}" placeholder="Observaciones">
                                    <button type="submit" class="btn btn-sm btn-outline-success" title="Guardar">
                                        <i class="bi bi-check-lg"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted">No hay registros para mostrar.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="card-footer">
            {{ $detalles->links() }}
        </div>
    </div>
</div>
@endsection
