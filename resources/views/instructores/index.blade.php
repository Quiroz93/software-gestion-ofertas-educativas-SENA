@extends('layouts.app')

@section('title', 'Instructores')

@section('content_header')
<div class="d-flex justify-content-between align-items-center">
    <h1 class="m-0">
        <i class="fas fa-chalkboard-teacher text-primary"></i>
        Gestión de Instructores
    </h1>

    <div>
        @can('instructores.create')
            <a href="{{ route('instructores.create') }}" class="btn btn-outline-success">
                <i class="fas fa-plus-circle"></i>
                Agregar instructor
            </a>
        @endcan

        <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left"></i>
            Volver
        </a>
    </div>
</div>
@stop

@section('content')

@if($instructores->isEmpty())
    <div class="alert alert-info">
        <i class="fas fa-info-circle"></i>
        No existen instructores registrados.
    </div>
@endif

<div class="row">
    @foreach($instructores as $instructor)
        <div class="col-md-6 col-lg-4">
            <div class="card card-outline card-primary shadow-sm h-100">

                {{-- HEADER --}}
                <div class="card-header">
                    <h3 class="card-title fw-bold text-uppercase">
                        {{ $instructor->nombre }} {{ $instructor->apellido }}
                    </h3>
                </div>

                {{-- BODY --}}
                <div class="card-body">
                    <p class="mb-2">
                        <strong>Perfil:</strong>
                        <span class="badge badge-secondary">
                            {{ $instructor->perfil }}
                        </span>
                    </p>

                    <p class="mb-2">
                        <strong>Experiencia:</strong>
                        <span class="badge badge-info">
                            {{ $instructor->experiencia }}
                        </span>
                    </p>

                    <p class="mb-0">
                        <strong>Correo:</strong><br>
                        {{ $instructor->correo }}
                    </p>
                </div>

                {{-- FOOTER --}}
                <div class="card-footer d-flex justify-content-between">

                    <div>
                        @can('instructores.view')
                            <a href="{{ route('instructores.show', $instructor->id) }}"
                               class="btn btn-sm btn-outline-info">
                                <i class="fas fa-eye"></i>
                                Ver
                            </a>
                        @endcan

                        @can('instructores.edit')
                            <a href="{{ route('instructores.edit', $instructor->id) }}"
                               class="btn btn-sm btn-outline-warning">
                                <i class="fas fa-edit"></i>
                                Editar
                            </a>
                        @endcan
                    </div>

                    @can('instructores.delete')
                        <form action="{{ route('instructores.destroy', $instructor->id) }}"
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
