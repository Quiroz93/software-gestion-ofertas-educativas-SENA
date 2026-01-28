@extends('layouts.bootstrap')

@section('title', $oferta->nombre)

@section('content')
<div class="container-fluid">
    <!-- Hero Section -->
    <div class="py-5 rounded-lg mb-5 overflow-hidden text-white transition"
         style="background: linear-gradient(135deg, {{ $oferta->custom('hero_bg_color', '#667eea') }} 0%, {{ $oferta->custom('hero_bg_color_2', '#764ba2') }} 100%);
                 min-height: 300px;
                 display: flex;
                 align-items: center;">
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
                        <ol class="breadcrumb breadcrumb-dark mb-0">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-white-50">Inicio</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('public.ofertas.index') }}" class="text-white-50">Ofertas</a></li>
                            <li class="breadcrumb-item active text-white">{{ $oferta->nombre }}</li>
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
                <div class="card shadow-sm border-0 mb-4 rounded-lg">
                    <div class="card-body">
                        <h4 class="card-title fw-bold mb-3 editable"
                            data-model="oferta"
                            data-model-id="{{ $oferta->id }}"
                            data-key="description_title"
                            data-type="text">
                            <i class="bi bi-file-text me-2 text-primary"></i>
                            {{ $oferta->custom('description_title', 'Descripción de la oferta') }}
                        </h4>

                        <p class="text-muted editable"
                            data-model="oferta"
                            data-model-id="{{ $oferta->id }}"
                            data-key="descripcion"
                            data-type="text">
                            {{ $oferta->descripcion }}
                        </p>
                    </div>
                </div>

                <!-- Important Dates -->
                <div class="card shadow-sm border-0 mb-4 rounded-lg">
                    <div class="card-body">
                        <h4 class="card-title fw-bold mb-3">
                            <i class="bi bi-calendar me-2 text-success"></i>Fechas Importantes
                        </h4>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="p-3 bg-light rounded-lg mb-3">
                                    <small class="text-muted d-block mb-1">Fecha de Inicio</small>
                                    <h6 class="fw-bold mb-0">
                                        {{ is_string($oferta->fecha_inicio) ? \Carbon\Carbon::parse($oferta->fecha_inicio)->format('d/m/Y') : $oferta->fecha_inicio?->format('d/m/Y') }}
                                    </h6>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="p-3 bg-light rounded-lg mb-3">
                                    <small class="text-muted d-block mb-1">Fecha de Fin</small>
                                    <h6 class="fw-bold mb-0">
                                        {{ is_string($oferta->fecha_fin) ? \Carbon\Carbon::parse($oferta->fecha_fin)->format('d/m/Y') : $oferta->fecha_fin?->format('d/m/Y') }}
                                    </h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Related Programs -->
                @if($oferta->programas()->count() > 0)
                <div class="card shadow-sm border-0 rounded-lg">
                    <div class="card-body">
                        <h4 class="card-title fw-bold mb-3">
                            <i class="bi bi-link-45deg me-2 text-info"></i>Programas Asociados
                        </h4>

                        <div class="row g-3">
                            @foreach($oferta->programas()->take(4) as $programa)
                            <div class="col-md-6">
                                <a href="{{ route('public.programas.show', $programa) }}"
                                   class="card border-0 shadow-sm text-decoration-none transition hover-shadow rounded-lg">
                                    <div class="card-body">
                                        <h6 class="card-title fw-bold text-primary mb-1">{{ $programa->nombre }}</h6>
                                        <small class="text-muted d-block">{{ $programa->duracion ?? 'Duración no especificada' }}</small>
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
                <div class="card shadow-sm border-0 mb-4 rounded-lg sticky-top" style="top: 20px;">
                    <div class="card-body">
                        <h5 class="card-title fw-bold mb-3">
                            <i class="bi bi-info-circle me-2 text-primary"></i>Información Clave
                        </h5>

                        <!-- Status -->
                        <div class="d-flex mb-3 pb-3 border-bottom">
                            <i class="bi bi-check-circle text-success me-3" style="font-size: 1.5rem;"></i>
                            <div>
                                <small class="text-muted d-block">Estado</small>
                                <strong class="text-success">Oferta Activa</strong>
                            </div>
                        </div>

                        <!-- Center -->
                        @if($oferta->centro)
                        <div class="d-flex mb-3 pb-3 border-bottom">
                            <i class="bi bi-geo-alt text-warning me-3" style="font-size: 1.5rem;"></i>
                            <div>
                                <small class="text-muted d-block">Centro</small>
                                <strong>{{ $oferta->centro->nombre }}</strong>
                            </div>
                        </div>
                        @endif

                        <!-- Programs Count -->
                        <div class="d-flex">
                            <i class="bi bi-book me-3 text-info" style="font-size: 1.5rem;"></i>
                            <div>
                                <small class="text-muted d-block">Programas</small>
                                <strong>{{ $oferta->programas()->count() }} disponibles</strong>
                            </div>
                        </div>

                        <!-- Enrollment Button -->
                        <button class="btn btn-primary w-100 mt-4" data-bs-toggle="modal" data-bs-target="#enrollModal">
                            <i class="bi bi-check-circle me-2"></i>Solicitar Inscripción
                        </button>
                    </div>
                </div>

                <!-- Benefits Card -->
                <div class="card shadow-sm border-0 rounded-lg">
                    <div class="card-body">
                        <h5 class="card-title fw-bold mb-3">
                            <i class="bi bi-star-fill text-warning me-2"></i>Beneficios
                        </h5>
                        <ul class="list-unstyled">
                            <li class="mb-2">
                                <i class="bi bi-check-circle text-success me-2"></i>
                                <small>Certificación oficial SENA</small>
                            </li>
                            <li class="mb-2">
                                <i class="bi bi-check-circle text-success me-2"></i>
                                <small>Docentes especializados</small>
                            </li>
                            <li class="mb-2">
                                <i class="bi bi-check-circle text-success me-2"></i>
                                <small>Formación gratuita</small>
                            </li>
                            <li>
                                <i class="bi bi-check-circle text-success me-2"></i>
                                <small>Bolsa de empleo</small>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- CTA Section -->
    <div class="bg-light rounded-lg p-5 mb-5">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <h4 class="fw-bold mb-2">¿Tienes dudas sobre esta oferta?</h4>
                <p class="text-muted mb-0">Nuestro equipo de asesoría está disponible para ayudarte</p>
            </div>
            <div class="col-lg-4 text-lg-end mt-3 mt-lg-0">
                <a href="mailto:info@example.com" class="btn btn-primary">
                    <i class="bi bi-envelope me-2"></i>Contactar Asesor
                </a>
            </div>
        </div>
    </div>

    <!-- Back Button -->
    <div class="container mb-5">
        <a href="{{ route('public.ofertas.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-2"></i>Volver a Ofertas
        </a>
    </div>
</div>

<!-- Enrollment Modal -->
<div class="modal fade" id="enrollModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title fw-bold">Solicitud de Inscripción</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" action="#">
                @csrf
                <div class="modal-body">
                    <input type="hidden" name="oferta_id" value="{{ $oferta->id }}">

                    <div class="mb-3">
                        <label for="nombre" class="form-label">Nombre Completo</label>
                        <input type="text" class="form-control" id="nombre" name="nombre" required>
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Correo Electrónico</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>

                    <div class="mb-3">
                        <label for="telefono" class="form-label">Teléfono</label>
                        <input type="tel" class="form-control" id="telefono" name="telefono">
                    </div>

                    <div class="mb-3">
                        <label for="programa" class="form-label">Programa de Interés</label>
                        <select class="form-select" id="programa" name="programa_id">
                            <option value="">Seleccionar programa...</option>
                            @foreach($oferta->programas as $programa)
                            <option value="{{ $programa->id }}">{{ $programa->nombre }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Enviar Solicitud</button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    .transition {
        transition: all 0.3s ease;
    }

    .hover-shadow:hover {
        box-shadow: 0 0.5rem 1.5rem rgba(0, 0, 0, 0.15) !important;
        transform: translateY(-5px);
    }

    .rounded-lg {
        border-radius: 1rem;
    }

    .breadcrumb-dark .breadcrumb-item.active {
        color: rgba(255, 255, 255, 0.8);
    }
</style>
@endsection