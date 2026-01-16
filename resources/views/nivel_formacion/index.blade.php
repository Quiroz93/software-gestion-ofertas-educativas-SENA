@extends('layouts.app')

@section('title', 'Nivel de Formación')

@section('content_header')
<div class="d-flex justify-content-between align-items-center">
    <h1 class="m-0">
        <i class="fa-solid fa-ranking-star text-primary"></i>
        Niveles de Formación
    </h1>

    @can('niveles.create')
        <a href="{{-- enlace al controller --}}" class="btn btn-success">
            <i class="fas fa-plus-circle"></i>
            Crear nivel
        </a>
    @endcan
</div>
@stop

@section('content')

@if($niveles_formacion->isEmpty())
    <div class="alert alert-info">
        <i class="fas fa-info-circle"></i>
        No existen niveles de formación registrados.
    </div>
@endif

<div class="row">
    @foreach($niveles_formacion as $nivel)
        <div class="col-md-6 col-lg-4">
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
                <div class="card-footer d-flex justify-content-between">

                    @can('niveles.edit')
                        <a href="{{-- enlace al controller --}}"
                           class="btn btn-sm btn-outline-warning">
                            <i class="fas fa-edit"></i>
                            Editar
                        </a>
                    @endcan

                    @can('niveles.delete')
                        <form action="{{-- enlace al controller --}}"
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
