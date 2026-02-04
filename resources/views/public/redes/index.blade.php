@extends('layouts.bootstrap')

@section('title', 'Redes de Conocimiento')

@section('content')
<div class="container-fluid">
    <!-- Hero Section -->
    <div class="hero-section hero-bg-green py-5 mb-5 rounded-bottom-lg">
        <div class="container">
            <div class="row align-items-center g-4">
                <div class="col-lg-8">
                    <h1 class="display-4 fw-bold mb-3">Redes de Conocimiento</h1>
                    <p class="lead mb-4">
                        <i class="bi bi-info-circle me-2"></i>
                        Descubre las diferentes áreas de conocimiento del SENA
                    </p>
                    <a href="#redes" class="btn btn-outline-sena bg-white">
                        <i class="bi bi-arrow-down me-2"></i>Ver Redes
                    </a>
                </div>
                <div class="col-lg-4 text-center">
                    <i class="bi bi-diagram-3 display-3 text-white opacity-50"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Redes Section -->
    <div class="container mb-5 py-4" id="redes">
        <h3 class="h3 fw-bold text-center mb-5 title-blue">Nuestras Redes de Conocimiento</h3>
        
        @forelse($redes as $red)
            <div class="row mb-4">
                <div class="col-lg-10 mx-auto">
                    <div class="card">
                        <div class="card-body p-4">
                            <div class="d-flex align-items-start">
                                <div class="me-4">
                                    <div class="circle-bg circle-bg-green p-3">
                                        <i class="bi bi-diagram-3 circle-icon-green"></i>
                                    </div>
                                </div>
                                <div class="flex-grow-1">
                                    <h5 class="fw-bold mb-2 title-blue">{{ $red->nombre }}</h5>
                                    <p class="text-muted mb-0">{{ $red->descripcion ?? 'Red de conocimiento especializado' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="row">
                <div class="col-lg-8 mx-auto">
                    <div class="info-box text-center py-5">
                        <i class="bi bi-info-circle me-2" style="font-size: 2rem;"></i>
                        <p class="mb-0">No hay redes de conocimiento disponibles en este momento</p>
                    </div>
                </div>
            </div>
        @endforelse

        <!-- Pagination -->
        @if($redes->hasPages())
            <div class="d-flex justify-content-center mt-4">
                {{ $redes->links() }}
            </div>
        @endif
    </div>

    <!-- CTA Section -->
    <div class="container mb-5">
        <div style="background-color: var(--sena-green);" class="text-white rounded-lg p-5 text-center">
            <h3 class="h4 fw-bold mb-3">¿Quieres explorar nuestros programas?</h3>
            <p class="mb-4">Encuentra programas organizados por redes de conocimiento</p>
            <a href="{{ route('public.programasDeFormacion.index') }}" class="btn btn-outline-sena bg-white">
                <i class="bi bi-arrow-right me-2"></i>Ver Programas
            </a>
        </div>
    </div>
</div>
@endsection
