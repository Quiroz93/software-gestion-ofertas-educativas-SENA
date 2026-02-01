@extends('layouts.bootstrap')

@section('title', 'Ofertas Educativas')

@section('content')
<div class="container-fluid">
    <!-- Hero Section with Background -->
    @php
        $bannerImageUrl = getMediaUrl('oferta', 'banner_image', asset('images/oferta4.jpeg'));
        $bannerAlt = getMediaMetadata('oferta', 'banner_image', 'alt_text', 'Banner de ofertas educativas');
    @endphp
    
    <div class="position-relative py-5 mb-5 rounded-lg overflow-hidden text-white"
         style="background-image: url('{{ $bannerImageUrl }}'); 
                 background-size: cover; 
                 background-position: center;
                 min-height: 500px;
                 display: flex;
                 align-items: center;">
        <!-- Overlay -->
        <div style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; 
                background: rgba(57, 169, 0, 0.7); z-index: 1;"></div>
        
        <!-- Content -->
        <div class="container position-relative" style="z-index: 2;">
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

                    <a href="#ofertas" class="btn btn-outline-sena bg-white">
                        <i class="bi bi-arrow-down me-2"></i>Ver Ofertas
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Motivational Section -->
    <div class="container py-5 mb-5">
        <div class="text-center mb-5">
            <h2 class="h2 fw-bold mb-3 editable" style="color: var(--sena-blue-dark);"
                data-model="oferta" data-model-id="0" data-key="motivational_title" data-type="text">
                {{ getCustomContent('oferta', 'motivational_title', 'Educación que transforma') }}
            </h2>

            <p class="lead editable text-muted"
                data-model="oferta" data-model-id="0" data-key="motivational_description" data-type="text">
                {{ getCustomContent('oferta', 'motivational_description', 'Accede a programas diseñados para tu desarrollo profesional') }}
            </p>
        </div>

        <div class="row g-4">
            <div class="col-md-4">
                <div class="text-center">
                    <i class="bi bi-briefcase" style="font-size: 2.5rem; color: var(--sena-green);"></i>
                    <h5 class="fw-bold mt-3" style="color: var(--sena-blue-dark);">Experiencia Laboral</h5>
                    <p class="text-muted">Conecta con el mercado real</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="text-center">
                    <i class="bi bi-award" style="font-size: 2.5rem; color: var(--sena-green);"></i>
                    <h5 class="fw-bold mt-3" style="color: var(--sena-blue-dark);">Certificación Oficial</h5>
                    <p class="text-muted">Respaldo institucional garantizado</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="text-center">
                    <i class="bi bi-person-check" style="font-size: 2.5rem; color: var(--sena-green);"></i>
                    <h5 class="fw-bold mt-3" style="color: var(--sena-blue-dark);">Docentes Calificados</h5>
                    <p class="text-muted">Profesionales con experiencia real</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Offers Listing -->
    <div class="container mb-5" id="ofertas">
        <h3 class="h3 fw-bold mb-5" style="color: var(--sena-blue-dark);">
            <i class="bi bi-list-check me-2" style="color: var(--sena-green);"></i>Nuestras Ofertas Disponibles
        </h3>

        <div class="row g-4">
            @forelse ($ofertas as $oferta)
                <div class="col-lg-6">
                    <div class="card h-100">
                        <div class="row g-0 h-100">
                            <!-- Image -->
                            <div class="col-md-4 d-flex align-items-center justify-content-center" style="background-color: var(--neutral-bg);">
                                <div class="text-center">
                                    <i class="bi bi-laptop" style="font-size: 2.5rem; color: var(--sena-green);"></i>
                                </div>
                            </div>

                            <!-- Content -->
                            <div class="col-md-8">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-start mb-2">
                                        <h6 class="card-title fw-bold" style="color: var(--sena-green);">{{ $oferta->nombre }}</h6>
                                        <span class="badge badge-programa">
                                            <i class="bi bi-check-circle me-1"></i>Activa
                                        </span>
                                    </div>

                                    <p class="card-text small mb-3 text-muted">
                                        {{ $oferta->descripcion_media ?? '' }}
                                    </p>

                                    <!-- Details -->
                                    <div class="mb-3">
                                        @if($oferta->programas()->count() > 0)
                                        <small class="text-muted d-block" style="margin-bottom: 0.5rem;">
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
                                                <a href="{{ route('public.ofertasEducativas.show', $oferta) }}"
                                                    class="btn btn-primary-sena btn-sm stretched-link">
                                        <i class="bi bi-arrow-right me-1"></i>Ver Detalles
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="alert text-center py-5" style="background-color: var(--neutral-bg); border: 1px solid var(--sena-blue-light); color: var(--sena-blue-dark);">
                        <i class="bi bi-info-circle me-2" style="font-size: 2rem;"></i>
                        <p class="mb-0">No hay ofertas disponibles en este momento</p>
                    </div>
                </div>
            @endforelse
        </div>
    </div>

    <!-- CTA Section -->
    <div style="background-color: var(--sena-green);" class="text-white rounded-lg p-5 text-center mb-5">
        <h4 class="fw-bold mb-2">¿Listo para comenzar?</h4>
        <p class="mb-3">Contacta con nuestro equipo de asesoría académica</p>
        <a href="mailto:info@example.com" class="btn btn-outline-sena bg-white">
            <i class="bi bi-envelope me-2"></i>Solicitar Información
        </a>
    </div>
</div>
@endsection