@extends('layouts.admin')

@section('title', 'Gestión de Novedades')

@section('content_header')
<div class="d-flex justify-content-between align-items-center">
    <h1 class="m-0">
        <i class="bi bi-exclamation-triangle text-primary"></i>
        Gestión de Novedades
    </h1>
    <div>
        @can('preinscritos.novedades.admin')
        <a href="{{ route('novedades.create') }}" class="btn btn-outline-success">
            <i class="bi bi-plus-circle"></i>
            Nueva Novedad
        </a>
        <a href="{{ route('tipos-novedad.index') }}" class="btn btn-outline-info">
            <i class="bi bi-tags"></i>
            Tipos
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
            <form method="GET" action="{{ route('novedades.index') }}" class="row g-3">
                <div class="col-md-4">
                    <label class="form-label">Buscar Preinscrito</label>
                    <input type="text" name="search" class="form-control" 
                           value="{{ request('search') }}" placeholder="Nombre o documento...">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Tipo de Novedad</label>
                    <select name="tipo_novedad_id" class="form-select">
                        <option value="">-- Todos --</option>
                        @foreach ($tiposNovedad as $tipo)
                            <option value="{{ $tipo->id }}" {{ request('tipo_novedad_id') == $tipo->id ? 'selected' : '' }}>
                                {{ $tipo->nombre }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Estado</label>
                    <select name="estado" class="form-select">
                        <option value="">-- Todos --</option>
                        @foreach ($estados as $valor => $etiqueta)
                            <option value="{{ $valor }}" {{ request('estado') == $valor ? 'selected' : '' }}>
                                {{ $etiqueta }}
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
            @if($novedades->count() > 0)
                <table class="table table-striped table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Preinscrito</th>
                            <th>Documento</th>
                            <th>Tipo</th>
                            <th>Estado</th>
                            <th>Creado por</th>
                            <th>Fecha</th>
                            <th class="text-end">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($novedades as $novedad)
                            <tr>
                                <td>
                                    <strong>{{ $novedad->preinscrito->nombre_completo }}</strong><br>
                                    <small class="text-muted">{{ $novedad->preinscrito->programa->nombre ?? 'Sin asignar' }}</small>
                                </td>
                                <td>
                                    <span class="badge bg-light text-dark">
                                        {{ strtoupper($novedad->preinscrito->tipo_documento) }}-{{ $novedad->preinscrito->numero_documento }}
                                    </span>
                                </td>
                                <td>
                                    @if ($novedad->tipoNovedad)
                                        <span class="badge bg-secondary">{{ $novedad->tipoNovedad->nombre }}</span>
                                    @else
                                        <span class="badge bg-light text-dark">Sin tipo</span>
                                    @endif
                                </td>
                                <td>
                                    @php
                                        $colorEstado = match($novedad->estado) {
                                            'abierta' => 'danger',
                                            'en_gestion' => 'warning',
                                            'resuelta' => 'success',
                                            'cancelada' => 'secondary',
                                            default => 'light',
                                        };
                                    @endphp
                                    <span class="badge bg-{{ $colorEstado }}">{{ $novedad->etiqueta_estado }}</span>
                                </td>
                                <td>
                                    <small>{{ $novedad->createdBy->name ?? 'Sistema' }}</small>
                                </td>
                                <td>
                                    <small class="text-muted">{{ $novedad->created_at->format('d/m/Y H:i') }}</small>
                                </td>
                                <td class="text-end">
                                    <a href="{{ route('novedades.show', $novedad) }}" 
                                       class="btn btn-outline-info btn-sm" title="Ver">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="{{ route('novedades.edit', $novedad) }}" 
                                       class="btn btn-outline-warning btn-sm" title="Editar">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="{{ route('novedades.destroy', $novedad) }}" 
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
                    <p class="text-muted mt-3">No hay novedades registradas</p>
                </div>
            @endif
        </div>
        @if($novedades->hasPages())
            <div class="card-footer">
                {{ $novedades->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
