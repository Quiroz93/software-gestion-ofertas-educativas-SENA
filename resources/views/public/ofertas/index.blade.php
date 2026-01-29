@extends('layouts.bootstrap')

@section('title', 'Ofertas Educativas')

@section('content')
<div class="container-fluid">
    <!-- Hero Section with Background -->
    @php
        $bannerImageUrl = getMediaUrl('oferta', 'banner_image', asset('images/oferta4.jpeg'));
        $bannerAlt = getMediaMetadata('oferta', 'banner_image', 'alt_text', 'Banner de ofertas educativas');
    @endphp
    
    <div class="hero hero-oferta hero-xl hero-with-image"
         style="background-image: url('{{ $bannerImageUrl }}');">
        <!-- Content -->
        <div class="hero-content container">
            <div class="row">
                <div class="col-lg-8">
                    <h1 class="display-4 fw-bold mb-3 editable"
                        data-model="oferta" data-model-id="0" data-key="banner_title" data-type="text">
                        {{ getCustomContent('oferta', 'banner_title', 'Ofertas Educativas') }}
                    </h1>

                    <p class="lead mb-3 editable"
                        data-model="oferta" data-model-id="0" data-key="banner_subtitle" data-type="text">
                        {{ getCustomContent('oferta', 'banner_subtitle', 'Centro Agro Empresarial y Turístico de los Andes') }}
                    </p>

                    <p class="h5 mb-4 editable"
                        data-model="oferta" data-model-id="0" data-key="banner_slogan" data-type="text">
                        {{ getCustomContent('oferta', 'banner_slogan', 'Fórmate hoy para transformar tu futuro profesional') }}
                    </p>

                    <a href="#ofertas" class="btn btn-light btn-lg">
                        <i class="bi bi-arrow-down me-2"></i>Ver Ofertas
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Motivational Section -->
    <div class="container py-5 mb-5">
        <div class="text-center mb-5">
            <h2 class="h2 fw-bold mb-3 editable"
                data-model="oferta" data-model-id="0" data-key="motivational_title" data-type="text">
                {{ getCustomContent('oferta', 'motivational_title', 'Educación que transforma') }}
            </h2>

            <p class="lead text-muted editable"
                data-model="oferta" data-model-id="0" data-key="motivational_description" data-type="text">
                {{ getCustomContent('oferta', 'motivational_description', 'Accede a programas diseñados para tu desarrollo profesional') }}
            </p>
        </div>

        <div class="row g-4">
            <div class="col-md-4">
                <div class="text-center">
                    <i class="bi bi-briefcase text-primary fs-1"></i>
                    <h5 class="fw-bold mt-3">Experiencia Laboral</h5>
                    <p class="text-muted">Conecta con el mercado real</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="text-center">
                    <i class="bi bi-award text-success fs-1"></i>
                    <h5 class="fw-bold mt-3">Certificación Oficial</h5>
                    <p class="text-muted">Respaldo institucional garantizado</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="text-center">
                    <i class="bi bi-person-check text-warning fs-1"></i>
                    <h5 class="fw-bold mt-3">Docentes Calificados</h5>
                    <p class="text-muted">Profesionales con experiencia real</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Offers Listing -->
    <div class="container mb-5" id="ofertas">
        <h3 class="h3 fw-bold mb-5">
            <i class="bi bi-list-check me-2 text-primary"></i>Nuestras Ofertas Disponibles
        </h3>

        <div class="row g-4">
            @forelse ($ofertas as $oferta)
                <div class="col-lg-6">
                    <div class="card h-100 shadow-sm border-0 transition hover-shadow rounded-lg">
                        <div class="row g-0 h-100">
                            <!-- Image -->
                            <div class="col-md-4 bg-light d-flex align-items-center justify-content-center">
                                <div class="text-center">
                                    <i class="bi bi-laptop text-primary fs-1"></i>
                                </div>
                            </div>

                            <!-- Content -->
                            <div class="col-md-8">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-start mb-2">
                                        <h6 class="card-title fw-bold text-primary">{{ $oferta->nombre }}</h6>
                                        <span class="badge bg-success">
                                            <i class="bi bi-check-circle me-1"></i>Activa
                                        </span>
                                    </div>

                                    <p class="card-text text-muted small mb-3">
                                        {{ Str::limit($oferta->descripcion, 150) }}
                                    </p>

                                    <!-- Details -->
                                    <div class="mb-3">
                                        @if($oferta->programas()->count() > 0)
                                        <small class="text-muted d-block mb-2">
                                            <i class="bi bi-journal-code me-1"></i>
                                            <strong>{{ $oferta->programas()->count() }}</strong> programa(s)
                                        </small>
                                        @endif
                                        
                                        @if($oferta->centro)
                                        <small class="text-muted d-block">
                                            <i class="bi bi-geo-alt me-1"></i>
                                            <strong>{{ $oferta->centro->nombre }}</strong>
                                        </small>
                                        @endif
                                    </div>

                                    <!-- Link -->
                                    <a href="{{ route('public.ofertas.show', $oferta) }}"
                                       class="btn btn-sm btn-primary stretched-link">
                                        <i class="bi bi-arrow-right me-1"></i>Ver Detalles
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="alert alert-info text-center py-5">
                        <i class="bi bi-info-circle me-2 fs-2"></i>
                        <p class="mb-0">No hay ofertas disponibles en este momento</p>
                    </div>
                </div>
            @endforelse
        </div>
    </div>

    <!-- CTA Section -->
    <div class="bg-primary text-white rounded-lg p-5 text-center mb-5">
        <h4 class="fw-bold mb-2">¿Listo para comenzar?</h4>
        <p class="mb-3">Contacta con nuestro equipo de asesoría académica</p>
        <a href="mailto:info@example.com" class="btn btn-light">
            <i class="bi bi-envelope me-2"></i>Solicitar Información
        </a>
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
</style>
@endsection