@extends('layouts.admin')

@section('title', 'Centros')

@section('content_header')

<div class="d-flex justify-content-between align-items-center">
    <h1 class="m-0">
        <i class="fas fa-school text-primary"></i>
        Gestión de Centros
    </h1>

    <div>
        @can('centros.create')
            <a href="{{ route('centros.create') }}" class="btn btn-outline-success">
                <i class="fas fa-plus-circle"></i>
                Agregar centro
            </a>
        @endcan
        <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left"></i>
            Volver
        </a>
    </div>
</div>
@endsection

@section('content')

<div class="container-fluid">

    @if($centros->count() > 0)
    <div class="row">
        @foreach($centros as $centro)
        <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12 mb-4 mt-2">
            <div class="card card-outline card-primary h-100">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-building"></i>
                        {{ $centro->nombre }}
                    </h3>
                </div>

                <div class="card-body">
                    <p class="mb-2">
                        <i class="fas fa-map-marker-alt text-muted"></i>
                        <strong>Dirección:</strong><br>
                        <span class="text-muted">
                            {{ $centro->direccion ?? 'N/A' }}
                        </span>
                    </p>

                    <p class="mb-2">
                        <i class="fas fa-phone text-muted"></i>
                        <strong>Teléfono:</strong><br>
                        <span class="text-muted">
                            {{ $centro->telefono ?? 'N/A' }}
                        </span>
                    </p>

                    <p class="mb-0">
                        <i class="fas fa-envelope text-muted"></i>
                        <strong>Correo:</strong><br>
                        @if($centro->correo)
                        <a href="mailto:{{ $centro->correo }}">
                            {{ $centro->correo }}
                        </a>
                        @else
                        <span class="text-muted">N/A</span>
                        @endif
                    </p>
                </div>

                @canany(['centros.edit','centros.update','centros.delete'])
                <div class="card-footer d-flex flex-wrap gap-2">
                    <div class="">
                        @canany(['centros.edit','centros.update'])
                        <a href="{{ route('centros.edit', $centro->id) }}"
                            class="btn btn-outline-warning btn-sm min-width-100px">
                            <i class="fas fa-edit"></i> Editar
                        </a>
                    </div>
                    @endcanany

                    @can('centros.delete')
                    <form action="{{ route('centros.destroy', $centro->id) }}"
                        method="POST"
                        onsubmit="return confirmarEliminacion(event)">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            class="btn btn-outline-danger btn-sm min-width-100px">
                            <i class="fas fa-trash"></i> Eliminar
                        </button>
                    </form>
                    @endcan
                </div>
                @endcanany
            </div>
        </div>
        @endforeach
    </div>

    <div class="mt-3 text-muted">
        <i class="fas fa-database"></i>
        Total de centros: <strong>{{ $centros->count() }}</strong>
    </div>

    @else
    <div class="alert alert-info">
        <i class="fas fa-info-circle"></i>
        No hay centros registrados.
        @can('centros.create')
        <a href="{{ route('centros.create') }}" class="alert-link">
            Crear uno ahora
        </a>
        @endcan
    </div>
    @endif

</div>
@endsection

@section('js')
@parent
@endsection
