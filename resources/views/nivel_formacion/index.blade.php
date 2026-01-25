@extends('layouts.app')

@section('title', 'Nivel de Formación')

@section('content_header')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h1 class="m-0">
        <i class="fas fa-school text-primary"></i>
        Gestión de Niveles de Formación
    </h1>

    <div class="d-flex gap-2">
        @can('niveles_formacion.create')
            <a href="{{ route('niveles_formacion.create') }}" class="btn btn-outline-success">
                <i class="fas fa-plus-circle"></i>
                Agregar Nivel de Formación
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

@if($nivel_formaciones->isEmpty())
    <div class="alert alert-info">
        <i class="fas fa-info-circle"></i>
        No existen niveles de formación registrados.
    </div>
@else
    <div class="row row-cols-1 row-cols-md-2 g-4">
        @foreach($niveles_formacion as $nivel)
            <div class="col">
                <div class="card h-100 shadow-sm">

                    {{-- HEADER --}}
                    <div class="card-header bg-light">
                        <h5 class="card-title mb-0 text-uppercase fw-bold">
                            {{ $nivel->nombre }}
                        </h5>
                    </div>

                    {{-- BODY --}}
                    <div class="card-body">
                        <p class="mb-0">
                            <strong>Descripción:</strong><br>
                            <span class="text-muted">
                                {{ $nivel->descripcion ?? 'Sin descripción' }}
                            </span>
                        </p>
                    </div>

                    {{-- FOOTER --}}
                    @canany(['niveles_formacion.edit','niveles_formacion.update','niveles_formacion.delete'])
                    <div class="card-footer d-flex justify-content-between align-items-center">

                        <div class="d-flex gap-2">
                            @canany(['niveles_formacion.edit','niveles_formacion.update'])
                                <a href="{{ route('niveles_formacion.edit', $nivel->id) }}"
                                   class="btn btn-outline-warning btn-sm">
                                    <i class="fas fa-edit"></i>
                                    Editar
                                </a>
                            @endcanany
                        </div>

                        @can('niveles_formacion.delete')
                            <form action="{{ route('niveles_formacion.destroy', $nivel->id) }}"
                                  method="POST"
                                  onsubmit="return confirmarEliminacion(event)">
                                @csrf
                                @method('DELETE')

                                <button type="submit" class="btn btn-outline-danger btn-sm">
                                    <i class="fas fa-trash"></i>
                                    Eliminar
                                </button>
                            </form>
                        @endcan

                    </div>
                    @endcanany

                </div>
            </div>
        @endforeach
    </div>
@endif

@endsection
