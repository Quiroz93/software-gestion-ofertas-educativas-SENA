@extends('layouts.admin')

@section('title', 'Municipios')

@section('content_header')
<div class="d-flex justify-content-between align-items-center">
    <h1 class="m-0">
        <i class="bi bi-geo-alt-fill text-sena"></i>
        Municipios
    </h1>

    @can('municipios.create')
    <a href="{{ route('municipios.create') }}" class="btn btn-primary-sena">
        <i class="bi bi-plus-circle"></i>
        Nuevo Municipio
    </a>
    @endcan
</div>
@stop

@section('content')

{{-- Alertas de sesión --}}
@if(session('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    <i class="bi bi-check-circle-fill me-2"></i>
    {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

@if(session('error'))
<div class="alert alert-danger alert-dismissible fade show" role="alert">
    <i class="bi bi-exclamation-triangle-fill me-2"></i>
    {{ session('error') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

<div class="card shadow-sm">
    <div class="card-header bg-white">
        <h5 class="mb-0">
            <i class="bi bi-list-ul me-2"></i>
            Lista de Municipios
        </h5>
    </div>

    <div class="card-body">
        @if($municipios->count() > 0)
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th style="width: 10%">Código</th>
                        <th style="width: 30%">Nombre</th>
                        <th style="width: 30%">Departamento</th>
                        <th style="width: 15%" class="text-center">Programas</th>
                        <th style="width: 15%" class="text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($municipios as $municipio)
                    <tr>
                        <td>
                            <span class="badge bg-secondary">{{ $municipio->codigo }}</span>
                        </td>
                        <td>
                            <strong>{{ $municipio->nombre }}</strong>
                        </td>
                        <td>
                            {{ $municipio->departamento ?? 'N/A' }}
                        </td>
                        <td class="text-center">
                            <span class="badge bg-info">{{ $municipio->programas->count() }}</span>
                        </td>
                        <td class="text-center">
                            <div class="btn-group btn-group-sm" role="group">
                                @can('municipios.edit', $municipio)
                                <a href="{{ route('municipios.edit', $municipio) }}" 
                                   class="btn btn-outline-primary"
                                   title="Editar">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                @endcan

                                @can('municipios.delete', $municipio)
                                <form action="{{ route('municipios.destroy', $municipio) }}" 
                                      method="POST" 
                                      class="d-inline"
                                      onsubmit="return confirm('¿Está seguro de eliminar este municipio?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="btn btn-outline-danger"
                                            title="Eliminar"
                                            @if($municipio->programas->count() > 0) disabled @endif>
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                                @endcan
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <div class="text-center py-5">
            <i class="bi bi-inbox display-1 text-muted"></i>
            <p class="text-muted mt-3">No hay municipios registrados</p>
            @can('municipios.create')
            <a href="{{ route('municipios.create') }}" class="btn btn-primary-sena">
                <i class="bi bi-plus-circle"></i>
                Crear el primer municipio
            </a>
            @endcan
        </div>
        @endif
    </div>
</div>

@endsection

@section('css')
<style>
    .text-sena {
        color: #39A900;
    }
    
    .btn-primary-sena {
        background-color: #39A900;
        border-color: #39A900;
        color: #fff;
    }
    
    .btn-primary-sena:hover {
        background-color: #007832;
        border-color: #007832;
        color: #fff;
    }
    
    .table-hover tbody tr:hover {
        background-color: #f8f9fa;
    }
</style>
@endsection
