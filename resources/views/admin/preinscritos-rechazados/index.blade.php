@extends('layouts.admin')

@section('title', 'Registros Rechazados')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="h3 mb-0">
                        <i class="bi bi-x-circle text-danger me-2"></i>
                        Registros Rechazados
                    </h1>
                    <p class="text-muted mb-0">
                        Preinscritos con problemas durante la importación
                    </p>
                </div>
                <div>
                    <a href="{{ route('admin.preinscritos-rechazados.create') }}" class="btn btn-success">
                        <i class="bi bi-plus-circle"></i>
                        Nuevo Rechazado
                    </a>
                </div>
            </div>
        </div>
    </div>

    {{-- Filtros --}}
    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('admin.preinscritos-rechazados.index') }}" class="row g-3">
                <div class="col-md-5">
                    <label for="search" class="form-label">Buscar</label>
                    <input type="text" 
                           class="form-control" 
                           id="search" 
                           name="search" 
                           placeholder="Nombre, documento, correo..."
                           value="{{ request('search') }}">
                </div>
                
                <div class="col-md-4">
                    <label for="motivo" class="form-label">Motivo de Rechazo</label>
                    <select class="form-select" id="motivo" name="motivo">
                        <option value="">Todos</option>
                        @foreach($motivos as $m)
                            <option value="{{ $m }}" {{ request('motivo') == $m ? 'selected' : '' }}>
                                {{ ucwords(str_replace('_', ' ', $m)) }}
                            </option>
                        @endforeach
                    </select>
                </div>
                
                <div class="col-md-3 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary me-2">
                        <i class="bi bi-search"></i> Filtrar
                    </button>
                    <a href="{{ route('admin.preinscritos-rechazados.index') }}" class="btn btn-secondary">
                        <i class="bi bi-x-lg"></i> Limpiar
                    </a>
                </div>
            </form>
        </div>
    </div>

    {{-- Estadísticas rápidas --}}
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card border-danger">
                <div class="card-body">
                    <h6 class="text-muted mb-2">Total Rechazados</h6>
                    <h3 class="mb-0">{{ $rechazados->total() }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-warning">
                <div class="card-body">
                    <h6 class="text-muted mb-2">Duplicados</h6>
                    <h3 class="mb-0">
                        {{ App\Models\PreinscritoRechazado::where('motivo', 'documento_duplicado')->count() }}
                    </h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-info">
                <div class="card-body">
                    <h6 class="text-muted mb-2">Sin Programa</h6>
                    <h3 class="mb-0">
                        {{ App\Models\PreinscritoRechazado::where('motivo', 'sin_programa_asignado')->count() }}
                    </h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-secondary">
                <div class="card-body">
                    <h6 class="text-muted mb-2">Datos Incompletos</h6>
                    <h3 class="mb-0">
                        {{ App\Models\PreinscritoRechazado::where('motivo', 'datos_incompletos')->count() }}
                    </h3>
                </div>
            </div>
        </div>
    </div>

    {{-- Tabla de registros --}}
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Nombre Completo</th>
                            <th>Documento</th>
                            <th>Programa</th>
                            <th>Contacto</th>
                            <th>Motivo</th>
                            <th>Fila</th>
                            <th class="text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($rechazados as $rechazado)
                            <tr>
                                <td>
                                    <strong>{{ $rechazado->nombre_completo }}</strong>
                                </td>
                                <td>
                                    <span class="badge bg-secondary">{{ strtoupper($rechazado->tipo_documento) }}</span>
                                    {{ $rechazado->numero_documento }}
                                </td>
                                <td>
                                    <small class="text-muted">{{ Str::limit($rechazado->programa, 30) }}</small>
                                </td>
                                <td>
                                    @if($rechazado->correo)
                                        <div><i class="bi bi-envelope"></i> {{ $rechazado->correo }}</div>
                                    @endif
                                    @if($rechazado->telefono)
                                        <div><i class="bi bi-phone"></i> {{ $rechazado->telefono }}</div>
                                    @endif
                                </td>
                                <td>
                                    @if($rechazado->motivo == 'documento_duplicado')
                                        <span class="badge bg-warning text-dark">
                                            <i class="bi bi-files"></i> Duplicado
                                        </span>
                                    @elseif($rechazado->motivo == 'sin_programa_asignado')
                                        <span class="badge bg-info">
                                            <i class="bi bi-question-circle"></i> Sin programa
                                        </span>
                                    @elseif($rechazado->motivo == 'datos_incompletos')
                                        <span class="badge bg-secondary">
                                            <i class="bi bi-exclamation-triangle"></i> Incompleto
                                        </span>
                                    @else
                                        <span class="badge bg-danger">
                                            {{ ucwords(str_replace('_', ' ', $rechazado->motivo)) }}
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    <span class="badge bg-light text-dark">{{ $rechazado->fila_excel }}</span>
                                </td>
                                <td class="text-center">
                                    <a href="{{ route('admin.preinscritos-rechazados.show', $rechazado->id) }}" 
                                       class="btn btn-sm btn-outline-primary"
                                       title="Ver detalles">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.preinscritos-rechazados.edit', $rechazado->id) }}"
                                       class="btn btn-sm btn-outline-success"
                                       title="Editar">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="{{ route('admin.preinscritos-rechazados.destroy', $rechazado->id) }}" 
                                          method="POST" 
                                          class="d-inline"
                                          onsubmit="return confirm('¿Está seguro de eliminar este registro?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="btn btn-sm btn-outline-danger"
                                                title="Eliminar">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-5">
                                    <i class="bi bi-inbox display-4 text-muted"></i>
                                    <p class="text-muted mt-3">No se encontraron registros rechazados</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Paginación --}}
            <div class="mt-3">
                {{ $rechazados->withQueryString()->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
