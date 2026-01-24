@extends('layouts.app')

@section('title', 'Nivel de Formación')

@section('content_header')
<div class="d-flex justify-content-between align-items-center">
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
@endif

<div class="row">
@foreach($nivel_formaciones as $nivel)

    <div class="col-md-6 col-lg-4 mb-4">
        <div class="card card-outline card-primary shadow-sm h-100">

            {{-- HEADER --}}
            <div class="card-header">
                <h3 class="card-title text-uppercase fw-bold">
                    {{ $nivel->nombre }}
                </h3>
            </div>

            {{-- BODY --}}
            <div class="card-body">
                <p class="mb-0">
                    <strong>Descripción:</strong><br>
                    <span class="text-muted">
                        {{ $nivel->descripcion }}
                    </span>
                </p>
            </div>

            {{-- FOOTER --}}
            @canany(['niveles_formacion.edit','niveles_formacion.update','niveles_formacion.delete'])
            <div class="card-footer d-flex flex-wrap gap-2 justify-content-between">

                @can('niveles_formacion.edit')
                <a href="{{ route('niveles_formacion.edit', $nivel->id) }}"
                   class="btn btn-sm btn-outline-warning min-width-100px">
                    <i class="fas fa-edit"></i>
                    Editar
                </a>
                @endcan

                @can('niveles_formacion.delete')
                <form action="{{ route('niveles_formacion.destroy', $nivel->id) }}"
                      method="POST"
                      onsubmit="return confirmarEliminacion(event)">
                    @csrf
                    @method('DELETE')

                    <button type="submit"
                            class="btn btn-sm btn-outline-danger min-width-100px">
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

@endsection
