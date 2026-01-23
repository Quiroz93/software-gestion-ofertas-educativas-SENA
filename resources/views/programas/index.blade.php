@extends('layouts.app')

@section('title', 'Programas')

@section('content_header')
<div class="d-flex justify-content-between align-items-center">
    <h1 class="m-0">
        <i class="fas fa-book text-primary"></i>
        Programas de formación
    </h1>

    <div>
        @can('programas.create')
    <a href="{{route('programas.create')}}" class="btn btn-outline-success">
        <i class="fas fa-plus-circle"></i>
        Crear programa
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

@if($programas->isEmpty())
<div class="alert alert-info">
    <i class="fas fa-info-circle"></i>
    No existen programas registrados.
</div>
@endif

<div class="row">
    @foreach($programas as $programa)
    <div class="col-md-6 col-lg-4">
        <div class="card card-outline card-primary shadow-sm h-100">

            {{-- HEADER --}}
            <div class="card-header">
                <h3 class="card-title text-uppercase fw-bold">
                    {{ $programa->nombre }}
                </h3>
            </div>

                {{-- BODY --}}
            <div class="card-body">
                <p class="mb-2">
                    <strong>Descripción:</strong><br>
                    {{ $programa->descripcion }}
                </p>

                <p class="mb-2">
                    <strong>Requisitos:</strong><br>
                    {{ $programa->requisitos }}
                </p>

                <p class="mb-0">
                    <strong>Duración:</strong>
                    <span class="badge bg-info">
                        {{ $programa->duracion_meses ? $programa->duracion_meses . ' meses' : 'N/A' }}
                    </span>
                </p>
            </div>

            {{-- FOOTER --}}
            <div class="card-footer d-flex justify-content-between">

                <div class="d-flex gap-1">
                    <a href="{{ route('programas.show', $programa) }}" class="btn btn-sm btn-outline-primary">
                        <i class="fas fa-eye"></i>
                        Ver
                    </a>

                    @can('programas.edit')
                        <a href="{{ route('programas.edit', $programa) }}" class="btn btn-sm btn-outline-warning">
                            <i class="fas fa-edit"></i>
                            Editar
                        </a>
                    @endcan

                    @can('programas.delete')
                        <form action="{{ route('programas.destroy', $programa) }}"
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
    </div>
    @endforeach
</div>

@endsection
