@extends('layouts.admin')

@section('title', 'Programa de Formación')

@section('content_header')
<div class="d-flex justify-content-between align-items-center">
    <h1 class="m-0">
        <i class="fas fa-graduation-cap text-primary"></i>
        Detalles del Programa
    </h1>

    <a href="{{ route('programas.index') }}" class="btn btn-outline-secondary">
        <i class="fas fa-arrow-left"></i>
        Volver
    </a>
</div>
@endsection

@section('content')

<div class="container-fluid">
    <div class="row">
        <div class="col-md-10 offset-md-1">

            <div class="card card-outline card-primary shadow-sm">

                {{-- HEADER --}}
                <div class="card-header">
                    <h3 class="card-title fw-bold">
                        <i class="fas fa-book"></i>
                        {{ $programa->nombre }}
                    </h3>
                </div>

                {{-- BODY --}}
                <div class="card-body">

                    {{-- Descripción --}}
                    <div class="mb-4">
                        <h5 class="text-primary">
                            <i class="fas fa-align-left"></i>
                            Descripción
                        </h5>
                        <p class="text-muted ms-4">
                            {{ $programa->descripcion ?? 'No hay descripción disponible' }}
                        </p>
                    </div>

                    {{-- Requisitos --}}
                    <div class="mb-4">
                        <h5 class="text-primary">
                            <i class="fas fa-list-check"></i>
                            Requisitos
                        </h5>
                        <p class="text-muted ms-4">
                            {{ $programa->requisitos ?? 'No hay requisitos especificados' }}
                        </p>
                    </div>

                    {{-- Duración --}}
                    <div class="mb-4">
                        <h5 class="text-primary">
                            <i class="fas fa-clock"></i>
                            Duración
                        </h5>
                        <p class="text-muted ms-4">
                            @if($programa->duracion_meses)
                                {{ $programa->duracion_meses }} {{ $programa->duracion_meses == 1 ? 'mes' : 'meses' }}
                            @else
                                No especificada
                            @endif
                        </p>
                    </div>

                    <div class="row">
                        {{-- Red de Conocimiento --}}
                        <div class="col-md-6 mb-4">
                            <h5 class="text-primary">
                                <i class="fas fa-network-wired"></i>
                                Red de Conocimiento
                            </h5>
                            <p class="text-muted ms-4">
                                @if($programa->red)
                                    <span class="badge bg-info">{{ $programa->red->nombre }}</span>
                                @else
                                    No asignada
                                @endif
                            </p>
                        </div>

                        {{-- Nivel de Formación --}}
                        <div class="col-md-6 mb-4">
                            <h5 class="text-primary">
                                <i class="fas fa-layer-group"></i>
                                Nivel de Formación
                            </h5>
                            <p class="text-muted ms-4">
                                @if($programa->nivelFormacion)
                                    <span class="badge bg-success">{{ $programa->nivelFormacion->nombre }}</span>
                                @else
                                    No asignado
                                @endif
                            </p>
                        </div>
                    </div>

                    <div class="row">
                        {{-- Centro de Formación --}}
                        <div class="col-md-12 mb-4">
                            <h5 class="text-primary">
                                <i class="fas fa-building"></i>
                                Centro de Formación
                            </h5>
                            <p class="text-muted ms-4">
                                @if($programa->centro)
                                    <span class="badge bg-primary">{{ $programa->centro->nombre }}</span>
                                @else
                                    No asignado
                                @endif
                            </p>
                        </div>
                    </div>

                    {{-- Información adicional --}}
                    <div class="mb-4">
                        <h5 class="text-primary">
                            <i class="fas fa-info-circle"></i>
                            Información adicional
                        </h5>
                        <p class="text-muted ms-4">
                            <strong>Modalidad:</strong> {{ $programa->modalidad ?? 'N/A' }}<br>
                            <strong>Jornada:</strong> {{ $programa->jornada ?? 'N/A' }}<br>
                            <strong>Número de ficha:</strong> {{ $programa->numero_ficha ?? 'N/A' }}<br>
                            <strong>Título otorgado:</strong> {{ $programa->titulo_otorgado ?? 'N/A' }}<br>
                            <strong>Código SNIES:</strong> {{ $programa->codigo_snies ?? 'N/A' }}<br>
                            <strong>Registro de Calidad:</strong> {{ $programa->registro_calidad ?? 'N/A' }}<br>
                            <strong>Fecha de registro:</strong> {{ $programa->fecha_registro ? $programa->fecha_registro->format('d/m/Y') : 'N/A' }}<br>
                            <strong>Fecha de actualización:</strong> {{ $programa->fecha_actualizacion ? $programa->fecha_actualizacion->format('d/m/Y') : 'N/A' }}<br>
                            <strong>Estado:</strong> {{ $programa->estado ?? 'N/A' }}<br>
                            <strong>Cupos:</strong> {{ $programa->cupos ?? 'N/A' }}<br>
                            <strong>Observaciones:</strong> {{ $programa->observaciones ?? 'N/A' }}<br>
                            <strong>Fecha de creación:</strong> {{ $programa->created_at->format('d/m/Y') }}<br>
                            <strong>Última actualización:</strong> {{ $programa->updated_at->format('d/m/Y') }}
                        </p>
                    </div>

                    {{-- Código QR de Inscripción --}}
                    @php
                        $enlaceInscripcion = $programa->customContents()
                            ->where('key', 'enlace_inscripcion')
                            ->value('value');
                    @endphp

                    @if($enlaceInscripcion)
                        <div class="mb-4 mt-4 border-top pt-4">
                            <h5 class="text-primary mb-3">
                                <i class="fas fa-qrcode"></i>
                                Código QR de Inscripción
                            </h5>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="text-center p-3 bg-light rounded">
                                        <img src="{{ route('programas.qr.generar', $programa) }}" 
                                             alt="QR Code" 
                                             class="img-fluid"
                                             style="max-width: 300px;">
                                    </div>
                                </div>
                                <div class="col-md-6 d-flex align-items-center">
                                    <div>
                                        <p class="text-muted mb-3">
                                            <i class="fas fa-info-circle"></i>
                                            Escanea este código QR para acceder directamente al formulario de inscripción del programa.
                                        </p>
                                        <div class="d-grid gap-2">
                                            <a href="{{ route('programas.qr.descargar', $programa) }}" 
                                               class="btn btn-success"
                                               download>
                                                <i class="fas fa-download"></i>
                                                Descargar QR en SVG
                                            </a>
                                            <a href="{{ $enlaceInscripcion }}" 
                                               class="btn btn-info" 
                                               target="_blank">
                                                <i class="fas fa-external-link-alt"></i>
                                                Abrir enlace de inscripción
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                </div>

                {{-- FOOTER --}}
                <div class="card-footer">
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('programas.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i>
                            Volver al listado
                        </a>

                        <div>
                            @can('programas.edit')
                                <a href="{{ route('programas.edit', $programa) }}" class="btn btn-warning">
                                    <i class="fas fa-edit"></i>
                                    Editar
                                </a>
                            @endcan

                            @can('programas.delete')
                                <form action="{{ route('programas.destroy', $programa) }}" 
                                      method="POST" 
                                      class="d-inline"
                                      onsubmit="return confirm('¿Está seguro de eliminar este programa?')">
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
