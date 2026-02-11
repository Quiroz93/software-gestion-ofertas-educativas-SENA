@extends('layouts.bootstrap')

@section('title', 'Historias de Éxito')

@push('styles')
    @vite(['resources/css/public/historias-exito.css'])
@endpush

@section('content')
<div class="container-fluid">
    <!-- Hero Section -->
    <div style="background-color: var(--sena-green);" class="text-white py-5 mb-5 rounded-bottom-lg">
        <div class="container">
            <div class="row align-items-center g-4">
                <div class="col-lg-8">
                    <h1 class="display-4 fw-bold mb-3">Historias de Éxito</h1>
                    <p class="lead mb-4">
                        <i class="bi bi-info-circle me-2"></i>
                        Inspiración y testimonios de nuestros egresados
                    </p>
                    <a href="#historias" class="btn btn-outline-sena bg-white">
                        <i class="bi bi-arrow-down me-2"></i>Leer Historias
                    </a>
                </div>
                <div class="col-lg-4 text-center">
                    <i class="bi bi-star display-3 opacity-50 text-white"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Introduction Section -->
    <div class="container mb-5 py-4">
        <div class="row g-4 mb-5">
            <div class="col-lg-8 mx-auto">
                <div class="card">
                    <div class="card-body p-5">
                        <h3 class="h4 fw-bold mb-3" style="color: var(--sena-blue-dark);">Historias que Inspiran</h3>
                        <p class="text-muted mb-3">
                            Aquí compartimos las historias de egresados que han logrado transformar sus vidas 
                            a través de la formación en nuestro centro. Estos testimonios reflejan el impacto 
                            real de nuestros programas en la carrera profesional de nuestros estudiantes.
                        </p>
                        <p class="text-muted mb-3">
                            Desde emprendedores que han creado sus propias empresas, hasta profesionales 
                            que han alcanzado posiciones importantes en sus sectores, estas historias demuestran 
                            el potencial de transformación que nuestros programas ofrecen.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Success Stories Section -->
    <div class="py-5 mb-5" id="historias" style="background-color: var(--neutral-bg);">
        <div class="container">
            <h3 class="h3 fw-bold text-center mb-5" style="color: var(--sena-blue-dark);">Nuestros Egresados</h3>
            
            @if(isset($historias) && $historias->count() > 0)
                <div class="row g-4">
                    @foreach($historias as $historia)
                    <div class="col-lg-6">
                        <div class="card overflow-hidden h-100">
                            <div class="card-body p-4">
                                <div class="d-flex align-items-start mb-3">
                                    <div class="me-3">
                                        <i class="bi bi-person-circle" style="font-size: 2.5rem; color: var(--sena-green);"></i>
                                    </div>
                                    <div>
                                        <h5 class="fw-bold mb-0" style="color: var(--sena-blue-dark);">{{ $historia->titulo ?? 'Título de historia' }}</h5>
                                        <p class="text-muted small mb-0">{{ $historia->nombre ?? '' }}</p>
                                    </div>
                                </div>
                                
                                <div class="mb-3">
                                    <div class="d-flex align-items-center mb-2">
                                        <span class="badge badge-oferta me-2">Egresado</span>
                                        @isset($historia->año)
                                            <span class="small text-muted">Año: {{ $historia->año }}</span>
                                        @endisset
                                    </div>
                                </div>
                                
                                @isset($historia->descripcion)
                                    <p class="text-muted small mb-3">
                                        {{ $historia->descripcion_corta }}
                                    </p>
                                @endisset
                                
                                <a href="{{ route('public.historiasDeExito.show', $historia->id) }}" class="btn btn-sm btn-outline-sena">
                                    <i class="bi bi-arrow-right me-1"></i>Leer historia completa
                                </a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                
                <!-- Pagination -->
                <div class="d-flex justify-content-center mt-5">
                    {{ $historias->links() }}
                </div>
            @else
                <div class="row">
                    <div class="col-lg-8 mx-auto">
                        <div class="alert text-center" role="alert" style="background-color: var(--neutral-bg); border: 1px solid var(--sena-blue-light); color: var(--sena-blue-dark);">
                            <i class="bi bi-info-circle me-2"></i>
                            Historias de éxito disponibles próximamente. ¡Tú podrías ser la próxima historia!
                        </div>
                    </div>
                </div>
            @endif

            <!-- Pagination -->
            @if(isset($historias) && $historias->hasPages())
                <div class="d-flex justify-content-center mt-4">
                    {{ $historias->links() }}
                </div>
            @endif
        </div>
    </div>

    <!-- Benefits Section -->
    <div class="container mb-5 py-4">
        <h3 class="h3 fw-bold text-center mb-5" style="color: var(--sena-blue-dark);">¿Por Qué Compartimos Historias?</h3>
        <div class="row g-4">
            <div class="col-md-4">
                <div class="text-center">
                    <div style="background-color: rgba(253,195,0,0.12);" class="rounded-circle p-4 d-inline-block mb-3">
                        <i class="bi bi-lightbulb" style="font-size: 2rem; color: var(--sena-yellow);"></i>
                    </div>
                    <h5 class="fw-bold" style="color: var(--sena-blue-dark);">Inspiración</h5>
                    <p class="text-muted small">Motivarte a alcanzar tus objetivos profesionales</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="text-center">
                    <div style="background-color: rgba(253,195,0,0.12);" class="rounded-circle p-4 d-inline-block mb-3">
                        <i class="bi bi-graph-up" style="font-size: 2rem; color: var(--sena-yellow);"></i>
                    </div>
                    <h5 class="fw-bold" style="color: var(--sena-blue-dark);">Crecimiento</h5>
                    <p class="text-muted small">Ejemplos reales de desarrollo profesional</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="text-center">
                    <div style="background-color: rgba(253,195,0,0.12);" class="rounded-circle p-4 d-inline-block mb-3">
                        <i class="bi bi-check-circle" style="font-size: 2rem; color: var(--sena-yellow);"></i>
                    </div>
                    <h5 class="fw-bold" style="color: var(--sena-blue-dark);">Confianza</h5>
                    <p class="text-muted small">Validar la calidad de nuestros programas</p>
                </div>
            </div>
        </div>
    </div>

    <!-- CTA Section -->
    <div class="container mb-5">
        <div style="background-color: var(--sena-green);" class="text-white rounded-lg p-5 text-center">
            <h3 class="h4 fw-bold mb-3">¿Quieres Ser la Próxima Historia de Éxito?</h3>
            <p class="mb-4">Únete a nuestros programas y comienza tu transformación profesional</p>
            <a href="{{ route('public.programasDeFormacion.index') }}" class="btn btn-outline-sena bg-white">
                <i class="bi bi-arrow-right me-2"></i>Ver Programas
            </a>
        </div>
    </div>
</div>
@endsection