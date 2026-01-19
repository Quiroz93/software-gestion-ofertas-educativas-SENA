@extends('layouts.app')

@section('title', 'Competencias')

@section('content_header')
<div class="d-flex justify-content-between align-items-center">
    <h1 class="m-0">
        <i class="fas fa-trophy text-primary"></i>
        Gestión de Competencias
    </h1>

    <div>
        @can('competencias.create')
            <a href="{{ route('competencias.create') }}" class="btn btn-outline-success">
                <i class="fas fa-plus-circle"></i>
                Agregar competencia
            </a>
        @endcan
        <a href="{{ route('competencias.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left"></i>
            Volver
        </a>
    </div>
</div>
@stop

@section('content')

@if($competencias->isEmpty())
    <div class="alert alert-info">
        <i class="fas fa-info-circle"></i>
        No existen competencias registradas.
    </div>
@endif

<div class="row">
    @foreach($competencias as $competencia)
        <div class="col-md-6 col-lg-4">
            <div class="card card-outline card-primary shadow-sm h-100">

                {{-- HEADER --}}
                <div class="card-header">
                    <h3 class="card-title fw-bold text-uppercase">
                        {{ $competencia->nombre }}
                    </h3>
                </div>

                {{-- BODY --}}
                <div class="card-body">
                    <p class="mb-0">
                        <strong>Descripción:</strong><br>
                        {{ $competencia->descripcion }}
                    </p>
                </div>

                {{-- FOOTER --}}
                <div class="card-footer d-flex justify-content-between">

                    <div>
                        @can('competencias.view')
                            <a href="{{ route('competencias.show', $competencia->id) }}"
                               class="btn btn-sm btn-outline-info">
                                <i class="fas fa-eye"></i>
                                Ver
                            </a>
                        @endcan

                        @can('competencias.edit')
                            <a href="{{ route('competencias.edit', $competencia->id) }}"
                               class="btn btn-sm btn-outline-warning">
                                <i class="fas fa-edit"></i>
                                Editar
                            </a>
                        @endcan
                    </div>

                    @can('competencias.delete')
                        <form action="{{ route('competencias.destroy', $competencia->id) }}"
                              method="POST"
                              onsubmit="return confirmarEliminacion(event)">
                            @csrf
                            @method('DELETE')

                            <button type="submit" class="btn btn-sm btn-outline-danger">
                                <i class="fas fa-trash"></i>
                                Eliminar
                            </button>
                        </form>
                    @endcan

                </div>
            </div>
        </div>
    @endforeach
</div>

@endsection
