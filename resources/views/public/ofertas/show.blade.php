@extends('layouts.bootstrap')

@section('title', $oferta->nombre)

@push('styles')
    @vite(['resources/css/public/ofertas.css'])
@endpush
@section('content')
<div class="container-fluid">
    <!-- Hero Section -->
    <div class="py-5 rounded-lg mb-5 overflow-hidden text-white" style="background-color: var(--sena-green); min-height: 300px; display: flex; align-items: center;">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <h1 class="display-4 fw-bold mb-3 editable"
                        data-model="oferta"
                        data-model-id="{{ $oferta->id }}"
                        data-key="banner_title"
                        data-type="text">
                        {{ $oferta->custom('banner_title', $oferta->nombre) }}
                    </h1>

                    <p class="lead editable"
                        data-model="oferta"
                        data-model-id="{{ $oferta->id }}"
                        data-key="slogan"
                        data-type="text">
                        {{ $oferta->custom('slogan', 'Inscripciones abiertas') }}
                    </p>

                    <!-- Breadcrumbs -->
                    <nav aria-label="breadcrumb" class="mt-3">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-white" style="opacity: 0.8;">Inicio</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('public.ofertasEducativas.index') }}" class="text-white" style="opacity: 0.8;">Ofertas</a></li>
                            <li class="breadcrumb-item active text-white" aria-current="page">{{ $oferta->nombre }}</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="container mb-5">
        <div class="row g-4">
            <!-- Left Column -->
            <div class="col-lg-8">
                <!-- Description Section -->
                <div class="card mb-4">
                    <div class="card-body">
                        <h4 class="card-title fw-bold mb-3 editable" style="color: var(--sena-green);"
                            data-model="oferta"
                            data-model-id="{{ $oferta->id }}"
                            data-key="description_title"
                            data-type="text">
                            <i class="bi bi-file-text me-2"></i>
                            {{ $oferta->custom('description_title', 'Descripción de la oferta') }}
                        </h4>

                        <p class="text-muted" editable
                            data-model="oferta"
                            data-model-id="{{ $oferta->id }}"
                            data-key="descripcion"
                            data-type="text">
                            {{ $oferta->descripcion }}
                        </p>
                    </div>
                </div>

                <!-- Important Dates -->
                <div class="card mb-4">
                    <div class="card-body">
                        <h4 class="card-title fw-bold mb-3" style="color: var(--sena-green);">
                            <i class="bi bi-calendar me-2"></i>Fechas Importantes
                        </h4>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="p-3 rounded-lg mb-3" style="background-color: var(--neutral-bg);">
                                    <small class="text-muted d-block" style="margin-bottom: 0.5rem;">Fecha de Inicio</small>
                                    <h6 class="fw-bold mb-0" style="color: var(--sena-blue-dark);">
                                        {{ is_string($oferta->fecha_inicio) ? \Carbon\Carbon::parse($oferta->fecha_inicio)->format('d/m/Y') : $oferta->fecha_inicio?->format('d/m/Y') }}
                                    </h6>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="p-3 rounded-lg mb-3" style="background-color: var(--neutral-bg);">
                                    <small class="text-muted d-block" style="margin-bottom: 0.5rem;">Fecha de Fin</small>
                                    <h6 class="fw-bold mb-0" style="color: var(--sena-blue-dark);">
                                        {{ is_string($oferta->fecha_fin) ? \Carbon\Carbon::parse($oferta->fecha_fin)->format('d/m/Y') : $oferta->fecha_fin?->format('d/m/Y') }}
                                    </h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Related Programs -->
                @if($oferta->programas()->count() > 0)
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title fw-bold mb-3" style="color: var(--sena-green);">
                            <i class="bi bi-link-45deg me-2"></i>Programas Asociados
                        </h4>

                        <div class="row g-3">
                            @foreach($oferta->programas()->take(4) as $programa)
                            <div class="col-md-6">
                                <a href="{{ route('public.programasDeFormacion.show', $programa) }}"
                                   class="card text-decoration-none">
                                    <div class="card-body">
                                        <h6 class="card-title fw-bold mb-1" style="color: var(--sena-green);">{{ $programa->nombre }}</h6>
                                        <small class="text-muted">{{ $programa->duracion ?? 'Duración no especificada' }}</small>
                                    </div>
                                </a>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                @endif
            </div>

            <!-- Right Column - Sidebar -->
            <div class="col-lg-4">
                <!-- Offer Details Card -->
                <div class="card mb-4 sticky-top" style="top: 20px;">
                    <div class="card-body">
                        <h5 class="card-title fw-bold mb-3" style="color: var(--sena-green);">
                            <i class="bi bi-info-circle me-2"></i>Información Clave
                        </h5>

                        <!-- Status -->
                        <div class="d-flex mb-3 pb-3 border-bottom">
                            <i class="bi bi-check-circle me-3" style="font-size: 1.5rem; color: var(--sena-green);"></i>
                            <div>
                                <small class="text-muted d-block">Estado</small>
                                <strong style="color: var(--sena-green);">Oferta Activa</strong>
                            </div>
                        </div>

                        <!-- Center -->
                        @if($oferta->centro)
                        <div class="d-flex mb-3 pb-3 border-bottom">
                            <i class="bi bi-geo-alt me-3" style="font-size: 1.5rem; color: var(--sena-yellow);"></i>
                            <div>
                                <small class="text-muted d-block">Centro</small>
                                <strong style="color: var(--sena-blue-dark);">{{ $oferta->centro->nombre }}</strong>
                            </div>
                        </div>
                        @endif

                        <!-- Programs Count -->
                        <div class="d-flex">
                            <i class="bi bi-book me-3" style="font-size: 1.5rem; color: var(--sena-blue-light);"></i>
                            <div>
                                <small class="text-muted d-block">Programas</small>
                                <strong style="color: var(--sena-blue-dark);">{{ $oferta->programas()->count() }} disponibles</strong>
                            </div>
                        </div>

                        <!-- Enrollment Button -->
                        <button class="btn btn-primary-sena w-100 mt-4" data-bs-toggle="modal" data-bs-target="#enrollModal">
                            <i class="bi bi-check-circle me-2"></i>Solicitar Inscripción
                        </button>
                    </div>
                </div>

                <!-- Benefits Card -->
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title fw-bold mb-3" style="color: var(--sena-green);">
                            <i class="bi bi-star-fill me-2" style="color: var(--sena-yellow);"></i>Beneficios
                        </h5>
                        <ul class="list-unstyled">
                            <li class="mb-2">
                                <i class="bi bi-check-circle me-2" style="color: var(--sena-green);"></i>
                                <small>Certificación oficial SENA</small>
                            </li>
                            <li class="mb-2">
                                <i class="bi bi-check-circle me-2" style="color: var(--sena-green);"></i>
                                <small>Docentes especializados</small>
                            </li>
                            <li class="mb-2">
                                <i class="bi bi-check-circle me-2" style="color: var(--sena-green);"></i>
                                <small>Formación gratuita</small>
                            </li>
                            <li>
                                <i class="bi bi-check-circle me-2" style="color: var(--sena-green);"></i>
                                <small>Bolsa de empleo</small>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- CTA Section -->
    <div style="background-color: var(--neutral-bg);" class="rounded-lg p-5 mb-5">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <h4 class="fw-bold mb-2" style="color: var(--sena-blue-dark);">¿Tienes dudas sobre esta oferta?</h4>
                <p class="text-muted mb-0">Nuestro equipo de asesoría está disponible para ayudarte</p>
            </div>
            <div class="col-lg-4 text-lg-end mt-3 mt-lg-0">
                <a href="mailto:info@example.com" class="btn btn-primary-sena">
                    <i class="bi bi-envelope me-2"></i>Contactar Asesor
                </a>
            </div>
        </div>
    </div>

    <!-- Back Button -->
    <div class="container mb-5">
        <a href="{{ route('public.ofertasEducativas.index') }}" class="btn btn-outline-sena">
            <i class="bi bi-arrow-left me-2"></i>Volver a Ofertas
        </a>
    </div>
</div>

<!-- Enrollment Modal -->
<div class="modal fade" id="enrollModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title fw-bold" style="color: var(--sena-blue-dark);">Solicitud de Inscripción</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" action="#">
                @csrf
                <div class="modal-body">
                    <input type="hidden" name="oferta_id" value="{{ $oferta->id }}">

                    <div class="mb-3">
                        <label for="nombre" class="form-label" style="color: var(--sena-blue-dark); font-weight: 600;">Nombre Completo</label>
                        <input type="text" class="form-control" id="nombre" name="nombre" required>
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label" style="color: var(--sena-blue-dark); font-weight: 600;">Correo Electrónico</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>

                    <div class="mb-3">
                        <label for="telefono" class="form-label" style="color: var(--sena-blue-dark); font-weight: 600;">Teléfono</label>
                        <input type="tel" class="form-control" id="telefono" name="telefono">
                    </div>

                    <div class="mb-3">
                        <label for="programa" class="form-label" style="color: var(--sena-blue-dark); font-weight: 600;">Programa de Interés</label>
                        <select class="form-select" id="programa" name="programa_id">
                            <option value="">Seleccionar programa...</option>
                            @foreach($oferta->programas as $programa)
                            <option value="{{ $programa->id }}">{{ $programa->nombre }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-sena" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary-sena">Enviar Solicitud</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection