@extends('layouts.app')

@section('title', 'Historias de éxito')

@section('content_header')
<div class="d-flex justify-content-between align-items-center">
    <h1 class="m-0">
        <i class="fas fa-star text-primary"></i>
        Gestión de Historias de Éxito
    </h1>

    <div>
        @can('historias.create')
            <a href="{{ route('historias.create') }}" class="btn btn-success">
                <i class="fas fa-plus-circle"></i>
                Agregar historia
            </a>
        @endcan

        <a href="{{ route('historias.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i>
            Volver
        </a>
    </div>
</div>
@stop

@section('content')

@if($historias->isEmpty())
    <div class="alert alert-info">
        <i class="fas fa-info-circle"></i>
        No existen historias de éxito registradas.
    </div>
@endif

<div class="row">
    @foreach($historias as $historia)
        <div class="col-md-6 col-lg-4">
            <div class="card card-outline card-primary shadow-sm h-100">

                {{-- HEADER --}}
                <div class="card-header">
                    <h3 class="card-title fw-bold text-uppercase">
                        {{ $historia->titulo }}
                    </h3>
                </div>

                {{-- BODY --}}
                <div class="card-body">
                    <p class="mb-2">
                        <strong>Autor:</strong>
                        <span class="badge badge-secondary">
                            {{ $historia->nombre }}
                        </span>
                    </p>

                    <p class="mb-2">
                        <strong>Descripción:</strong><br>
                        {{ Str::limit($historia->descripcion, 120) }}
                    </p>

                    <p class="mb-0">
                        <strong>Fecha:</strong>
                        <span class="badge badge-info">
                            {{ $historia->fecha }}
                        </span>
                    </p>
                </div>

                {{-- FOOTER --}}
                <div class="card-footer d-flex justify-content-between">

                    <div>
                        @can('historias.view')
                            <a href="{{ route('historias.show', $historia->id) }}"
                               class="btn btn-sm btn-outline-info">
                                <i class="fas fa-eye"></i>
                                Ver
                            </a>
                        @endcan

                        @can('historias.edit')
                            <a href="{{ route('historias.edit', $historia->id) }}"
                               class="btn btn-sm btn-outline-warning">
                                <i class="fas fa-edit"></i>
                                Editar
                            </a>
                        @endcan
                    </div>

                    @can('historias.delete')
                        <form action="{{ route('historias.destroy', $historia->id) }}"
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
