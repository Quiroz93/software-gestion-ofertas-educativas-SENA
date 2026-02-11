@extends('layouts.bootstrap')

@section('title', 'Ofertas Educativas')

@push('styles')
    @vite(['resources/css/public/ofertas.css'])
@endpush

@section('content')
<div class="container-fluid">
    @php
        $bannerImageUrl = getMediaUrl('oferta', 'banner_image', asset('images/oferta4.jpeg'));
        $bannerAlt = getMediaMetadata('oferta', 'banner_image', 'alt_text', 'Banner de ofertas educativas');
        $totalOfertas = $ofertas->count();
    @endphp

    <!-- Hero institucional -->
    <section class="position-relative mb-5 rounded-4 overflow-hidden" aria-label="Presentacion de ofertas">
        <div class="row g-0 align-items-stretch">
            <div class="col-lg-7 text-white position-relative"
                 style="background-image: url('{{ $bannerImageUrl }}');
                        background-size: cover;
                        background-position: center;
                        min-height: 460px;">
                <img src="{{ $bannerImageUrl }}" alt="{{ $bannerAlt }}" class="visually-hidden">
                <div class="position-absolute top-0 start-0 w-100 h-100"
                     style="background: linear-gradient(90deg, rgba(0,48,77,0.92) 0%, rgba(0,48,77,0.65) 55%, rgba(0,48,77,0.15) 100%);"></div>
                <div class="position-relative h-100 d-flex align-items-center px-4 px-lg-5" style="z-index: 2;">
                    <div>
                        <span class="badge rounded-pill" style="background: rgba(255,255,255,0.2);">Oferta educativa SENA</span>
                        <h1 class="display-5 fw-bold mt-3 mb-3 editable"
                            data-model="oferta" data-model-id="0" data-key="banner_title" data-type="text">
                            {{ getCustomContent('oferta', 'banner_title', 'Ofertas Educativas') }}
                        </h1>
                        <p class="lead mb-2 editable"
                            data-model="oferta" data-model-id="0" data-key="banner_subtitle" data-type="text">
                            {{ getCustomContent('oferta', 'banner_subtitle', 'Centro Agro Empresarial y Turistico de los Andes') }}
                        </p>
                        <p class="h6 text-white-50 mb-4 editable"
                            data-model="oferta" data-model-id="0" data-key="banner_slogan" data-type="text">
                            {{ getCustomContent('oferta', 'banner_slogan', 'Formate hoy para transformar tu futuro profesional') }}
                        </p>
                        <div class="d-flex flex-wrap gap-2">
                            <a href="#ofertas" class="btn btn-outline-sena bg-white">
                                <i class="bi bi-arrow-down me-2"></i>Explorar ofertas
                            </a>
                            <a href="{{ route('public.programasDeFormacion.index') }}" class="btn btn-outline-light">
                                <i class="bi bi-grid me-2"></i>Ver programas
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-5 bg-white">
                <div class="h-100 d-flex flex-column justify-content-center p-4 p-lg-5">
                    <h2 class="h4 fw-bold mb-3" style="color: var(--sena-blue-dark);">
                        Ruta clara para tu formacion
                    </h2>
                    <p class="text-muted mb-4">
                        Las ofertas educativas consolidan programas por area, centro y enfoque productivo.
                        Selecciona la oferta que mejor se ajuste a tu objetivo de aprendizaje.
                    </p>
                    <div class="row g-3">
                        <div class="col-6">
                            <div class="p-3 rounded-3" style="background: var(--neutral-bg);">
                                <div class="fw-bold" style="color: var(--sena-green);">{{ $totalOfertas }}</div>
                                <small class="text-muted">Ofertas activas</small>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="p-3 rounded-3" style="background: var(--neutral-bg);">
                                <div class="fw-bold" style="color: var(--sena-blue-dark);">Formacion certificada</div>
                                <small class="text-muted">Reconocimiento nacional</small>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="p-3 rounded-3 border" style="border-color: var(--sena-blue-light);">
                                <div class="d-flex align-items-center">
                                    <i class="bi bi-shield-check me-2" style="color: var(--sena-green);"></i>
                                    <small class="text-muted">Información pública actualizada por el Centro</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Principios de formacion -->
    <section class="container mb-5">
        <div class="row g-4 align-items-stretch">
            <div class="col-lg-4">
                <div class="p-4 rounded-4 h-100" style="background: var(--neutral-bg);">
                    <h3 class="h5 fw-bold" style="color: var(--sena-blue-dark);">Educacion con impacto regional</h3>
                    <p class="text-muted mb-0">
                        Programas alineados con la vocacion productiva del territorio y las necesidades del sector.
                    </p>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="p-4 rounded-4 h-100" style="background: var(--neutral-bg);">
                    <h3 class="h5 fw-bold" style="color: var(--sena-blue-dark);">Acompaniamiento permanente</h3>
                    <p class="text-muted mb-0">
                        Orientacion academica, seguimiento y rutas de empleo para fortalecer tu perfil.
                    </p>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="p-4 rounded-4 h-100" style="background: var(--neutral-bg);">
                    <h3 class="h5 fw-bold" style="color: var(--sena-blue-dark);">Formacion pertinente</h3>
                    <p class="text-muted mb-0">
                        Diseños curriculares que responden a competencias reales del mercado laboral.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Listado de ofertas -->
    <section class="container mb-5" id="ofertas" aria-label="Listado de ofertas">
        <div class="d-flex flex-wrap justify-content-between align-items-center mb-4">
            <div>
                <h3 class="h4 fw-bold mb-1" style="color: var(--sena-blue-dark);">
                    Ofertas disponibles
                </h3>
                <p class="text-muted mb-0">Selecciona una oferta para conocer sus programas y requisitos.</p>
            </div>
            <span class="badge rounded-pill" style="background: var(--sena-green);">
                {{ $totalOfertas }} en publicacion
            </span>
        </div>

        <div class="row g-4">
            @forelse ($ofertas as $oferta)
                <div class="col-lg-6">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body p-4">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <h4 class="h6 fw-bold mb-2" style="color: var(--sena-green);">{{ $oferta->nombre }}</h4>
                                    <p class="text-muted small mb-3">{{ $oferta->descripcion_media ?? 'Oferta educativa orientada al desarrollo de competencias.' }}</p>
                                </div>
                                <span class="badge" style="background: var(--neutral-bg); color: var(--sena-blue-dark);">
                                    <i class="bi bi-check-circle me-1" style="color: var(--sena-green);"></i>Activa
                                </span>
                            </div>

                            <div class="d-flex flex-wrap gap-3 mb-3">
                                @if($oferta->programas()->count() > 0)
                                <div class="d-flex align-items-center">
                                    <i class="bi bi-journal-code me-2" style="color: var(--sena-green);"></i>
                                    <small class="text-muted"><strong>{{ $oferta->programas()->count() }}</strong> programa(s)</small>
                                </div>
                                @endif
                                @if($oferta->centro)
                                <div class="d-flex align-items-center">
                                    <i class="bi bi-geo-alt me-2" style="color: var(--sena-blue-light);"></i>
                                    <small class="text-muted">{{ $oferta->centro->nombre }}</small>
                                </div>
                                @endif
                            </div>

                            <div class="d-flex justify-content-between align-items-center">
                                <small class="text-muted">
                                    <i class="bi bi-info-circle me-1"></i>Informacion publica
                                </small>
                                <a href="{{ route('public.ofertasEducativas.show', $oferta) }}"
                                   class="btn btn-primary-sena btn-sm">
                                    Ver detalle <i class="bi bi-arrow-right ms-1"></i>
                                </a>
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
    </section>

    <!-- Seccion de orientacion -->
    <section class="container mb-5">
        <div class="row g-4 align-items-center">
            <div class="col-lg-8">
                <div class="p-4 rounded-4" style="background: var(--sena-green); color: #fff;">
                    <h4 class="fw-bold mb-2">Necesitas orientacion?</h4>
                    <p class="mb-0">Nuestro equipo de atencion academica te ayudara a elegir la oferta adecuada.</p>
                </div>
            </div>
            <div class="col-lg-4 text-lg-end">
                <a href="mailto:info@example.com" class="btn btn-outline-sena bg-white w-100 w-lg-auto">
                    <i class="bi bi-envelope me-2"></i>Solicitar informacion
                </a>
            </div>
        </div>
    </section>
</div>
@endsection