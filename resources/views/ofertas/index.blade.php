@extends('layouts.app')

@section('title', 'Ofertas')

@section('content_header')
<div class="d-flex justify-content-between align-items-center">
    <h1 class="m-0">
        <i class="fas fa-graduation-cap text-primary"></i>
        Ofertas
    </h1>

    @can('ofertas.create')
    <a href="{{-- enlace al controller --}}" class="btn btn-success">
        <i class="fas fa-plus-circle"></i>
        Crear oferta
    </a>
    @endcan
</div>
@stop

@section('content')

@if($ofertas->isEmpty())
<div class="alert alert-info">
    <i class="fas fa-info-circle"></i>
    No existen ofertas registradas.
</div>
@endif

<div class="row">
    @foreach($ofertas as $oferta)
    <div class="col-md-6 col-lg-4">
        <div class="card card-outline card-primary shadow-sm h-100">

            {{-- HEADER --}}
            <div class="card-header">
                <h3 class="card-title text-uppercase fw-bold">
                    {{ $oferta->nombre }}
                </h3>
            </div>

            {{-- BODY --}}
            <div class="card-body">

                <p class="mb-2">
                    <strong>Año:</strong>
                    <span class="badge badge-secondary">
                        {{ $oferta->anio }}
                    </span>
                </p>

                <p class="mb-2">
                    <strong>Fecha inicio:</strong><br>
                    {{ $oferta->fecha_inicio }}
                </p>

                <p class="mb-2">
                    <strong>Fecha final:</strong><br>
                    {{ $oferta->fecha_final }}
                </p>

                <p class="mb-0">
                    <strong>Estado:</strong>
                    <span class="badge badge-info">
                        {{ $oferta->estado }}
                    </span>
                </p>

            </div>

            {{-- FOOTER --}}
            <div class="card-footer d-flex justify-content-between">

                @can('ofertas.edit')
                <a href="{{-- enlace al controller editar --}}"
                   class="btn btn-sm btn-outline-warning">
                    <i class="fas fa-edit"></i>
                    Editar
                </a>
                @endcan

                @can('ofertas.delete')
                <form action="{{-- enlace al controller eliminar --}}"
                      method="POST"
                      onsubmit="return confirmarEliminacion(event)">
                    @csrf
                    @method('DELETE')

                    <button type="submit"
                            class="btn btn-sm btn-outline-danger">
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
