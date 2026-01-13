@extends('layouts.app')

@section('title', 'Centros')

@section('content_header')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Centros</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Centros</li>
                </ol>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                {{-- Botones de acción --}}
                <div class="mb-3">
                   
                        <a href="{{ route('centro.create') }}" class="btn btn-success">
                            <i class="fas fa-plus"></i> Agregar Centro
                        </a>
                   
                    <a href="{{ route('dashboard') }}" class="btn btn-primary">
                        <i class="fas fa-arrow-left"></i> Volver
                    </a>
                </div>

                {{-- Tarjeta con tabla --}}
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-building"></i> Lista de Centros
                        </h3>
                    </div>

                    <div class="card-body">
                        @if($centros->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-hover table-striped">
                                    <thead class="thead-light">
                                        <tr>
                                            <th style="width: 5%">ID</th>
                                            <th style="width: 20%">Nombre</th>
                                            <th style="width: 25%">Dirección</th>
                                            <th style="width: 15%">Teléfono</th>
                                            <th style="width: 20%">Correo</th>
                                            <th style="width: 15%">Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($centros as $centro)
                                            <tr>
                                                <td>
                                                    <span class="badge badge-info">{{ $centro->id }}</span>
                                                </td>
                                                <td>
                                                    <strong>{{ $centro->nombre }}</strong>
                                                </td>
                                                <td>
                                                    <small>{{ $centro->direccion }}</small>
                                                </td>
                                                <td>
                                                    {{ $centro->telefono ?? 'N/A' }}
                                                </td>
                                                <td>
                                                    <a href="mailto:{{ $centro->correo }}" class="text-muted">
                                                        {{ $centro->correo ?? 'N/A' }}
                                                    </a>
                                                </td>
                                                <td>
                                                    <div class="btn-group btn-group-sm" role="group">
                                                        <a href="{{ route('centro.edit', $centro->id) }}" 
                                                           class="btn btn-info" 
                                                           title="Editar">
                                                            <i class="fas fa-edit"></i> Editar
                                                        </a>
                                                        <form action="{{ route('centro.destroy', $centro->id) }}" 
                                                              method="POST" 
                                                              class="d-inline"
                                                              onsubmit="return confirmarEliminacion(event)">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" 
                                                                    class="btn btn-danger" 
                                                                    title="Eliminar">
                                                                <i class="fas fa-trash"></i> Eliminar
                                                            </button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="alert alert-info" role="alert">
                                <i class="fas fa-info-circle"></i> No hay centros registrados.
                               
                                    <a href="{{ route('centro.create') }}" class="alert-link">Crear uno ahora</a>
                                
                            </div>
                        @endif
                    </div>

                    @if($centros->count() > 0)
                        <div class="card-footer">
                            <small class="text-muted">
                                <i class="fas fa-database"></i> Total de centros: <strong>{{ $centros->count() }}</strong>
                            </small>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        function confirmarEliminacion(event) {
            if (!confirm('¿Está seguro de que desea eliminar este centro?')) {
                event.preventDefault();
                return false;
            }
            return true;
        }
    </script>
@endsection