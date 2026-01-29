@extends('layouts.bootstrap')

@section('title', 'Historias de Éxito')

@section('content')
<div class="container-fluid">
    <!-- Hero Section -->
    <div class="bg-warning text-dark py-5 mb-5 rounded-bottom-lg">
        <div class="container">
            <div class="row align-items-center g-4">
                <div class="col-lg-8">
                    <h1 class="display-4 fw-bold mb-3">Historias de Éxito</h1>
                    <p class="lead mb-4">
                        <i class="bi bi-info-circle me-2"></i>
                        Inspiración y testimonios de nuestros egresados
                    </p>
                    <a href="#historias" class="btn btn-dark btn-lg">
                        <i class="bi bi-arrow-down me-2"></i>Leer Historias
                    </a>
                </div>
                <div class="col-lg-4 text-center">
                    <i class="bi bi-star display-3 opacity-50"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Introduction Section -->
    <div class="container mb-5 py-4">
        <div class="row g-4 mb-5">
            <div class="col-lg-8 mx-auto">
                <div class="card shadow-sm border-0">
                    <div class="card-body p-5">
                        <h3 class="h4 fw-bold mb-3">Historias que Inspiran</h3>
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
    <div class="bg-light py-5 mb-5" id="historias">
        <div class="container">
            <h3 class="h3 fw-bold text-center mb-5">Nuestros Egresados</h3>
            
            @if(isset($historias) && $historias->count() > 0)
                <div class="row g-4">
                    @foreach($historias as $historia)
                    <div class="col-lg-6">
                        <div class="card shadow-sm border-0 transition hover-shadow overflow-hidden h-100">
                            <div class="card-body p-4">
                                <div class="d-flex align-items-start mb-3">
                                    <div class="me-3">
                                        <i class="bi bi-person-circle text-warning" style="font-size: 2.5rem;"></i>
                                    </div>
                                    <div>
                                        <h5 class="fw-bold mb-0">{{ $historia->titulo ?? 'Título de historia' }}</h5>
                                        <p class="text-muted small mb-0">{{ $historia->subtitulo ?? 'Subtítulo' }}</p>
                                    </div>
                                </div>
                                
                                <div class="mb-3">
                                    <div class="d-flex align-items-center mb-2">
                                        <span class="badge bg-warning text-dark me-2">Egresado</span>
                                        @isset($historia->programa)
                                            <span class="small text-muted">Programa: {{ $historia->programa }}</span>
                                        @endisset
                                    </div>
                                </div>
                                
                                @isset($historia->descripcion)
                                    <p class="text-muted small mb-3">
                                        {{ Str::limit($historia->descripcion, 150) }}
                                    </p>
                                @endisset
                                
                                <a href="{{ route('public.historiasDeExito.show', $historia->id) }}" class="btn btn-sm btn-outline-warning">
                                    <i class="bi bi-arrow-right me-1"></i>Leer historia completa
                                </a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            @else
                <div class="row">
                    <div class="col-lg-8 mx-auto">
                        <div class="alert alert-info text-center" role="alert">
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
        <h3 class="h3 fw-bold text-center mb-5">¿Por Qué Compartimos Historias?</h3>
        <div class="row g-4">
            <div class="col-md-4">
                <div class="text-center">
                    <div class="bg-warning bg-opacity-10 rounded-circle p-4 d-inline-block mb-3">
                        <i class="bi bi-lightbulb text-warning" style="font-size: 2rem;"></i>
                    </div>
                    <h5 class="fw-bold">Inspiración</h5>
                    <p class="text-muted small">Motivarte a alcanzar tus objetivos profesionales</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="text-center">
                    <div class="bg-warning bg-opacity-10 rounded-circle p-4 d-inline-block mb-3">
                        <i class="bi bi-graph-up text-warning" style="font-size: 2rem;"></i>
                    </div>
                    <h5 class="fw-bold">Crecimiento</h5>
                    <p class="text-muted small">Ejemplos reales de desarrollo profesional</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="text-center">
                    <div class="bg-warning bg-opacity-10 rounded-circle p-4 d-inline-block mb-3">
                        <i class="bi bi-check-circle text-warning" style="font-size: 2rem;"></i>
                    </div>
                    <h5 class="fw-bold">Confianza</h5>
                    <p class="text-muted small">Validar la calidad de nuestros programas</p>
                </div>
            </div>
        </div>
    </div>

    <!-- CTA Section -->
    <div class="container mb-5">
        <div class="bg-warning text-dark rounded-lg p-5 text-center">
            <h3 class="h4 fw-bold mb-3">¿Quieres Ser la Próxima Historia de Éxito?</h3>
            <p class="mb-4">Únete a nuestros programas y comienza tu transformación profesional</p>
            <a href="{{ route('public.programasDeFormacion.index') }}" class="btn btn-dark btn-lg">
                <i class="bi bi-arrow-right me-2"></i>Ver Programas
            </a>
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
</style>
@endsection