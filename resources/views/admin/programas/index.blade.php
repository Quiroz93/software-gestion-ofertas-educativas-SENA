@extends('layouts.admin')

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
                    <small>{{ Str::limit($programa->descripcion ?? 'Sin descripción', 100) }}</small>
                </p>

                <div class="row mb-2">
                    <div class="col-6">
                        <strong>Duración:</strong><br>
                        <span class="badge bg-info">
                            {{ $programa->duracion_meses ? $programa->duracion_meses . ' meses' : 'N/A' }}
                        </span>
                    </div>
                    <div class="col-6">
                        <strong>Cupos:</strong><br>
                        <span class="badge bg-secondary">
                            {{ $programa->cupos ?? 'N/A' }}
                        </span>
                    </div>
                </div>

                <p class="mb-2">
                    <strong>Modalidad:</strong>
                    <span class="badge bg-primary">
                        {{ $programa->modalidad ?? 'N/A' }}
                    </span>
                </p>

                <p class="mb-2">
                    <strong>Jornada:</strong>
                    <span class="badge bg-primary">
                        {{ $programa->jornada ?? 'N/A' }}
                    </span>
                </p>

                <p class="mb-2">
                    <strong>Estado:</strong>
                    <span class="badge bg-success">
                        {{ $programa->estado ?? 'N/A' }}
                    </span>
                </p>

                <p class="mb-2">
                    <strong>Red de Conocimiento:</strong><br>
                    <span class="badge bg-info">
                        {{ $programa->red->nombre ?? 'N/A' }}
                    </span>
                </p>

                <p class="mb-2">
                    <strong>Nivel de Formación:</strong><br>
                    <span class="badge bg-warning">
                        {{ $programa->nivelFormacion->nombre ?? 'N/A' }}
                    </span>
                </p>

                <p class="mb-0">
                    <strong>Centro:</strong><br>
                    <span class="badge bg-dark">
                        {{ $programa->centro->nombre ?? 'No asignado' }}
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
