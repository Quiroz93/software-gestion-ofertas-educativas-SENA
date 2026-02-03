@extends('layouts.admin')

@section('title', 'Tipos de Novedad')

@section('content_header')
<div class="d-flex justify-content-between align-items-center">
    <h1 class="m-0">
        <i class="bi bi-tags text-primary"></i>
        Gestión de Tipos de Novedad
    </h1>
    <div>
        @can('novedad.tipos.admin')
        <a href="{{ route('tipos-novedad.create') }}" class="btn btn-outline-success">
            <i class="bi bi-plus-circle"></i>
            Crear Tipo
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
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle me-2"></i>
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card card-outline card-primary mb-4">
        <div class="card-header">
            <h3 class="card-title">
                <i class="bi bi-funnel"></i>
                Filtros
            </h3>
        </div>
        <div class="card-body">
            <form method="GET" action="{{ route('tipos-novedad.index') }}" class="row g-3">
                <div class="col-md-8">
                    <label class="form-label">Buscar</label>
                    <input type="text" name="search" class="form-control" 
                           value="{{ request('search') }}" placeholder="Nombre o descripción...">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Estado</label>
                    <select name="activo" class="form-select">
                        <option value="">-- Todos --</option>
                        <option value="1" {{ request('activo') === '1' ? 'selected' : '' }}>Activos</option>
                        <option value="0" {{ request('activo') === '0' ? 'selected' : '' }}>Inactivos</option>
                    </select>
                </div>
                <div class="col-md-1 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-search"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-body table-responsive">
            @if($tiposNovedad->count() > 0)
                <table class="table table-striped table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Nombre</th>
                            <th>Descripción</th>
                            <th>Novedades</th>
                            <th>Estado</th>
                            <th class="text-end">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($tiposNovedad as $tipo)
                            <tr>
                                <td>
                                    <strong>{{ $tipo->nombre }}</strong>
                                </td>
                                <td>
                                    <small class="text-muted">{{ $tipo->descripcion ?? 'Sin descripción' }}</small>
                                </td>
                                <td>
                                    <span class="badge bg-info">{{ $tipo->novedades_count ?? 0 }}</span>
                                </td>
                                <td>
                                    @if ($tipo->activo)
                                        <span class="badge bg-success">Activo</span>
                                    @else
                                        <span class="badge bg-secondary">Inactivo</span>
                                    @endif
                                </td>
                                <td class="text-end">
                                    <a href="{{ route('tipos-novedad.edit', $tipo) }}" 
                                       class="btn btn-outline-warning btn-sm" title="Editar">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="{{ route('tipos-novedad.destroy', $tipo) }}" 
                                          method="POST" style="display: inline;" 
                                          onsubmit="return confirmarEliminacion(event)">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger btn-sm" title="Eliminar">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <div class="text-center py-5">
                    <i class="bi bi-inbox" style="font-size: 3rem; color: #ccc;"></i>
                    <p class="text-muted mt-3">No hay tipos de novedad registrados</p>
                </div>
            @endif
        </div>
        @if($tiposNovedad->hasPages())
            <div class="card-footer">
                {{ $tiposNovedad->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
