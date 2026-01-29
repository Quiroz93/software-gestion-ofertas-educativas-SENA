@extends('layouts.bootstrap')

@section('title', 'Redes de Conocimiento')

@section('content')
<div class="container-fluid">
    <!-- Hero Section -->
    <div class="bg-secondary text-white py-5 mb-5 rounded-bottom-lg">
        <div class="container">
            <div class="row align-items-center g-4">
                <div class="col-lg-8">
                    <h1 class="display-4 fw-bold mb-3">Redes de Conocimiento</h1>
                    <p class="lead mb-4">
                        <i class="bi bi-info-circle me-2"></i>
                        Descubre las diferentes áreas de conocimiento del SENA
                    </p>
                    <a href="#redes" class="btn btn-light btn-lg">
                        <i class="bi bi-arrow-down me-2"></i>Ver Redes
                    </a>
                </div>
                <div class="col-lg-4 text-center">
                    <i class="bi bi-diagram-3 display-3 text-light opacity-50"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Redes Section -->
    <div class="container mb-5 py-4" id="redes">
        <h3 class="h3 fw-bold text-center mb-5">Nuestras Redes de Conocimiento</h3>
        
        @forelse($redes as $red)
            <div class="row mb-4">
                <div class="col-lg-10 mx-auto">
                    <div class="card shadow-sm border-0 transition hover-shadow rounded-lg">
                        <div class="card-body p-4">
                            <div class="d-flex align-items-start">
                                <div class="me-4">
                                    <div class="bg-secondary bg-opacity-10 rounded-circle p-3">
                                        <i class="bi bi-diagram-3 text-secondary" style="font-size: 2rem;"></i>
                                    </div>
                                </div>
                                <div class="flex-grow-1">
                                    <h5 class="fw-bold mb-2">{{ $red->nombre }}</h5>
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
                    <div class="alert alert-info text-center py-5" role="alert">
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
        <div class="bg-secondary text-white rounded-lg p-5 text-center">
            <h3 class="h4 fw-bold mb-3">¿Quieres explorar nuestros programas?</h3>
            <p class="mb-4">Encuentra programas organizados por redes de conocimiento</p>
            <a href="{{ route('public.programasDeFormacion.index') }}" class="btn btn-light btn-lg">
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
    
    .rounded-bottom-lg {
        border-radius: 0 0 1rem 1rem;
    }
    
    .rounded-lg {
        border-radius: 1rem;
    }
</style>
@endsection
