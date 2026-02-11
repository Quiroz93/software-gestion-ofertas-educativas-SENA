@extends('layouts.admin')

@section('title', 'Consolidaciones de Preinscritos')

@section('content_header')
<div class="d-flex justify-content-between align-items-center">
    <h1 class="m-0">
        <i class="bi bi-layers text-primary"></i>
        Consolidaciones de Preinscritos
    </h1>
    <div>
        @can('preinscritos.import')
        <a href="{{ route('preinscritos.consolidaciones.import') }}" class="btn btn-outline-success">
            <i class="bi bi-upload"></i>
            Importar Excel
        </a>
        @endcan
        <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left"></i>
            Volver
        </a>
    </div>
</div>
@endsection

@section('content')
<div class="container-fluid">
    <div class="card card-outline card-primary mb-4">
        <div class="card-header">
            <h3 class="card-title">
                <i class="bi bi-funnel"></i>
                Filtros de búsqueda
            </h3>
        </div>
        <div class="card-body">
            <form method="GET" action="{{ route('preinscritos.consolidaciones.index') }}" class="row g-3">
                <div class="col-md-3">
                    <label class="form-label">Fecha desde</label>
                    <input type="date" name="fecha_desde" class="form-control" value="{{ request('fecha_desde') }}">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Fecha hasta</label>
                    <input type="date" name="fecha_hasta" class="form-control" value="{{ request('fecha_hasta') }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Usuario</label>
                    <select name="usuario_id" class="form-select">
                        <option value="">-- Todos --</option>
                        @foreach($usuarios as $usuario)
                            <option value="{{ $usuario->id }}" {{ request('usuario_id') == $usuario->id ? 'selected' : '' }}>
                                {{ $usuario->name }}
                            </option>
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
                        <th>Consolidación</th>
                        <th>Tipo</th>
                        <th>Archivos</th>
                        <th>Registros</th>
                        <th>Descartados</th>
                        <th>Usuario</th>
                        <th>Fecha</th>
                        <th class="text-end">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($consolidaciones as $consolidacion)
                        <tr>
                            <td>
                                <div class="fw-semibold">{{ $consolidacion->nombre_consolidacion }}</div>
                                <div class="text-muted small">{{ Str::limit($consolidacion->descripcion, 60) }}</div>
                            </td>
                            <td>
                                @if($consolidacion->tipo_consolidacion === 'preinscritos')
                                    <span class="badge bg-primary">Preinscritos</span>
                                @elseif($consolidacion->tipo_consolidacion === 'regional_completo')
                                    <span class="badge bg-success">REGIONAL Completo</span>
                                @elseif($consolidacion->tipo_consolidacion === 'regional_esencial')
                                    <span class="badge bg-info">REGIONAL Esencial</span>
                                @else
                                    <span class="badge bg-secondary">{{ $consolidacion->tipo_consolidacion }}</span>
                                @endif
                            </td>
                            <td>{{ $consolidacion->total_archivos }}</td>
                            <td>{{ $consolidacion->total_registros }}</td>
                            <td>{{ $consolidacion->total_descartados }}</td>
                            <td>{{ $consolidacion->createdBy?->name ?? 'N/A' }}</td>
                            <td>{{ $consolidacion->created_at->format('Y-m-d H:i') }}</td>
                            <td class="text-end">
                                <a href="{{ route('preinscritos.consolidaciones.show', $consolidacion) }}" class="btn btn-sm btn-outline-primary">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <form action="{{ route('preinscritos.consolidaciones.destroy', $consolidacion) }}" method="POST" class="d-inline" onsubmit="confirmarEliminacion(event)">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted">No hay consolidaciones registradas.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="card-footer">
            {{ $consolidaciones->links() }}
        </div>
    </div>
</div>
@endsection
