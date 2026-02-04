@extends('layouts.admin')

@section('title', 'Preinscritos')

@section('content_header')
<div class="d-flex justify-content-between align-items-center">
    <h1 class="m-0">
        <i class="fas fa-clipboard-list text-primary"></i>
        Gestión de Preinscritos
    </h1>

    <div>
        @can('preinscritos.create')
            <a href="{{ route('preinscritos.create') }}" class="btn btn-outline-success">
                <i class="fas fa-plus-circle"></i>
                Nuevo Preinscrito
            </a>
        @endcan
        @can('preinscritos.consolidaciones.admin')
            <a href="{{ route('preinscritos.consolidaciones.index') }}" class="btn btn-outline-primary">
                <i class="bi bi-layers"></i>
                Consolidaciones
            </a>
        @endcan
        <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left"></i>
            Volver
        </a>
    </div>
</div>
@endsection

@section('content')
<div class="container-fluid">
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle"></i>
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle"></i>
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Filtros -->
    <div class="card card-outline card-primary mb-4">
        <div class="card-header">
            <h3 class="card-title">
                <i class="fas fa-filter"></i>
                Filtros de Búsqueda
            </h3>
        </div>
        <div class="card-body">
            <form method="GET" action="{{ route('preinscritos.index') }}" class="row g-3">
                <div class="col-md-3">
                    <label for="programa_id" class="form-label">Programa</label>
                    <select class="form-select form-select-sm" id="programa_id" name="programa_id">
                        <option value="">-- Todos los programas --</option>
                        @foreach($programas as $programa)
                            <option value="{{ $programa->id }}" {{ request('programa_id') == $programa->id ? 'selected' : '' }}>
                                {{ $programa->nombre }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-3">
                    <label for="estado" class="form-label">Estado</label>
                    <select class="form-select form-select-sm" id="estado" name="estado">
                        <option value="">-- Todos los estados --</option>
                        @foreach($estados as $valor => $etiqueta)
                            <option value="{{ $valor }}" {{ request('estado') == $valor ? 'selected' : '' }}>
                                {{ $etiqueta }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-3">
                    <label for="tipo_documento" class="form-label">Tipo de Documento</label>
                    <select class="form-select form-select-sm" id="tipo_documento" name="tipo_documento">
                        <option value="">-- Todos --</option>
                        @foreach($tiposDocumento as $valor => $etiqueta)
                            <option value="{{ $valor }}" {{ request('tipo_documento') == $valor ? 'selected' : '' }}>
                                {{ $etiqueta }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-3">
                    <label for="numero_documento" class="form-label">Nº de Documento</label>
                    <input type="text" class="form-control form-control-sm" id="numero_documento" name="numero_documento" 
                           value="{{ request('numero_documento') }}" placeholder="Buscar...">
                </div>

                <div class="col-md-3">
                    <label for="tipo_novedad" class="form-label">Tipo de Novedad</label>
                    <select class="form-select form-select-sm" id="tipo_novedad" name="tipo_novedad">
                        <option value="">-- Todos los tipos --</option>
                        @foreach($tiposNovedades as $valor => $etiqueta)
                            <option value="{{ $valor }}" {{ request('tipo_novedad') == $valor ? 'selected' : '' }}>
                                {{ $etiqueta }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-3">
                    <label for="novedad_resuelta" class="form-label">Estado de Novedad</label>
                    <select class="form-select form-select-sm" id="novedad_resuelta" name="novedad_resuelta">
                        <option value="">-- Todos --</option>
                        <option value="pendiente" {{ request('novedad_resuelta') == 'pendiente' ? 'selected' : '' }}>
                            Pendientes
                        </option>
                        <option value="resuelta" {{ request('novedad_resuelta') == 'resuelta' ? 'selected' : '' }}>
                            Resueltas
                        </option>
                    </select>
                </div>

                <div class="col-12">
                    <button type="submit" class="btn btn-outline-primary btn-sm">
                        <i class="fas fa-search"></i> Buscar
                    </button>
                    <a href="{{ route('preinscritos.index') }}" class="btn btn-outline-secondary btn-sm">
                        <i class="fas fa-redo"></i> Limpiar
                    </a>
                    @can('preinscritos.view')
                        <a href="{{ route('preinscritos.reportes') }}" class="btn btn-outline-info btn-sm">
                            <i class="fas fa-chart-bar"></i> Reportes
                        </a>
                    @endcan
                </div>
            </form>
        </div>
    </div>

    <!-- Tabla de Preinscritos -->
    @if($preinscritos->count() > 0)
        <div class="card card-outline card-primary">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-list"></i>
                    Listado de Preinscritos ({{ $preinscritos->total() }})
                </h3>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead class="table-primary">
                            <tr>
                                <th style="width: 15%">Nombre Completo</th>
                                <th style="width: 12%">Documento</th>
                                <th style="width: 15%">Correo Principal</th>
                                <th style="width: 12%">Celular</th>
                                <th style="width: 20%">Programa</th>
                                <th style="width: 10%">Estado</th>
                                <th style="width: 12%">Novedad</th>
                                <th style="width: 16%">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($preinscritos as $presrito)
                                <tr>
                                    <td>
                                        <strong>{{ $presrito->nombre_completo }}</strong>
                                    </td>
                                    <td>
                                        <span class="badge bg-light text-dark">
                                            {{ strtoupper($presrito->tipo_documento) }}-{{ $presrito->numero_documento }}
                                        </span>
                                    </td>
                                    <td>
                                        <a href="mailto:{{ $presrito->correo_principal }}">
                                            {{ $presrito->correo_principal }}
                                        </a>
                                    </td>
                                    <td>
                                        <a href="tel:{{ $presrito->celular_principal }}">
                                            {{ $presrito->celular_principal }}
                                        </a>
                                    </td>
                                    <td>
                                        <small class="d-block text-muted">
                                            {{ $presrito->programa->nombre ?? 'Sin asignar' }}<br>
                                            <em>({{ $presrito->programa->numero_ficha ?? 'N/A' }})</em>
                                        </small>
                                    </td>
                                    <td>
                                        <span class="badge bg-{{ $presrito->estado === 'inscrito' ? 'success' : ($presrito->estado === 'por_inscribir' ? 'warning' : 'danger') }}">
                                            {{ $presrito->etiqueta_estado }}
                                        </span>
                                    </td>
                                    <td>
                                        @if($presrito->estado === 'con_novedad')
                                            @if($presrito->novedad_resuelta)
                                                <span class="badge bg-success" title="{{ $presrito->tipo_novedad ? $presrito->etiqueta_tipo_novedad : 'Novedad resuelta' }}">
                                                    <i class="fas fa-check-circle"></i> Resuelta
                                                </span>
                                            @else
                                                <span class="badge bg-danger" title="{{ $presrito->tipo_novedad ? $presrito->etiqueta_tipo_novedad : 'Novedad pendiente' }}">
                                                    <i class="fas fa-exclamation-triangle"></i> Pendiente
                                                </span>
                                            @endif
                                        @else
                                            <span class="badge bg-light text-dark">N/A</span>
                                        @endif
                                    </td>
                                    <td>
                                        @can('preinscritos.view')
                                            <a href="{{ route('preinscritos.show', $presrito->id) }}" class="btn btn-outline-info btn-sm" title="Ver">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                        @endcan
                                        @can('preinscritos.edit')
                                            <a href="{{ route('preinscritos.edit', $presrito->id) }}" class="btn btn-outline-warning btn-sm" title="Editar">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                        @endcan
                                        @can('preinscritos.delete')
                                            <form action="{{ route('preinscritos.destroy', $presrito->id) }}" 
                                                  method="POST" 
                                                  style="display: inline-block;"
                                                  onsubmit="return confirmarEliminacion(event)">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-outline-danger btn-sm" title="Eliminar">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        @endcan
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer">
                {{ $preinscritos->links() }}
            </div>
        </div>
    @else
        <div class="alert alert-info">
            <i class="fas fa-info-circle"></i>
            No hay preinscritos registrados.
        </div>
    @endif
</div>

<script>
    function confirmarEliminacion(event) {
        event.preventDefault();
        
        Swal.fire({
            title: '¿Estás seguro?',
            text: '¿Deseas eliminar este preinscrito? Se eliminará de forma temporal.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                event.target.submit();
            }
        });
        
        return false;
    }
</script>
@endsection
