@extends('layouts.admin')

@section('title', 'Centro de Formación')

@section('content_header')
<div class="d-flex justify-content-between align-items-center">
    <h1 class="m-0">
        <i class="fas fa-school text-primary"></i>
        Detalles del Centro
    </h1>

    <a href="{{ route('centros.index') }}" class="btn btn-outline-secondary">
        <i class="fas fa-arrow-left"></i>
        Volver
    </a>
</div>
@endsection

@section('content')

<div class="container-fluid">
    <div class="row">
        <div class="col-md-8 offset-md-2">

            <div class="card card-outline card-primary shadow-sm">

                {{-- HEADER --}}
                <div class="card-header">
                    <h3 class="card-title fw-bold">
                        <i class="fas fa-building"></i>
                        {{ $centro->nombre }}
                    </h3>
                </div>

                {{-- BODY --}}
                <div class="card-body">

                    {{-- Dirección --}}
                    <div class="mb-4">
                        <h5 class="text-primary">
                            <i class="fas fa-map-marker-alt"></i>
                            Dirección
                        </h5>
                        <p class="text-muted ms-4">
                            {{ $centro->direccion ?? 'No especificada' }}
                        </p>
                    </div>

                    {{-- Teléfono --}}
                    <div class="mb-4">
                        <h5 class="text-primary">
                            <i class="fas fa-phone"></i>
                            Teléfono
                        </h5>
                        <p class="text-muted ms-4">
                            {{ $centro->telefono ?? 'No especificado' }}
                        </p>
                    </div>

                    {{-- Correo --}}
                    <div class="mb-4">
                        <h5 class="text-primary">
                            <i class="fas fa-envelope"></i>
                            Correo electrónico
                        </h5>
                        <p class="text-muted ms-4">
                            @if($centro->correo)
                                <a href="mailto:{{ $centro->correo }}">{{ $centro->correo }}</a>
                            @else
                                No especificado
                            @endif
                        </p>
                    </div>

                    {{-- Información adicional --}}
                    <div class="mb-4">
                        <h5 class="text-primary">
                            <i class="fas fa-info-circle"></i>
                            Información adicional
                        </h5>
                        <p class="text-muted ms-4">
                            <strong>Fecha de registro:</strong> {{ $centro->created_at->format('d/m/Y') }}<br>
                            <strong>Última actualización:</strong> {{ $centro->updated_at->format('d/m/Y') }}
                        </p>
                    </div>

                </div>

                {{-- FOOTER --}}
                <div class="card-footer">
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('centros.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i>
                            Volver al listado
                        </a>

                        <div>
                            @can('centros.edit')
                                <a href="{{ route('centros.edit', $centro) }}" class="btn btn-warning">
                                    <i class="fas fa-edit"></i>
                                    Editar
                                </a>
                            @endcan

                            @can('centros.delete')
                                <form action="{{ route('centros.destroy', $centro) }}" 
                                      method="POST" 
                                      class="d-inline"
                                      onsubmit="return confirm('¿Está seguro de eliminar este centro?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">
                                        <i class="fas fa-trash"></i>
                                        Eliminar
                                    </button>
                                </form>
                            @endcan
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>
</div>

@endsection
