@extends('layouts.bootstrap')

@section('title', 'Niveles de Formación')

@section('content')
<div class="container-fluid">
    <!-- Hero Section -->
    <div class="bg-primary text-white py-5 mb-5 rounded-bottom-lg">
        <div class="container">
            <div class="row align-items-center g-4">
                <div class="col-lg-8">
                    <h1 class="display-4 fw-bold mb-3">Niveles de Formación</h1>
                    <p class="lead mb-4">
                        <i class="bi bi-info-circle me-2"></i>
                        Encuentra el nivel de formación que se ajuste a tus objetivos
                    </p>
                    <a href="#niveles" class="btn btn-light btn-lg">
                        <i class="bi bi-arrow-down me-2"></i>Ver Niveles
                    </a>
                </div>
                <div class="col-lg-4 text-center">
                    <i class="bi bi-bar-chart-steps display-3 text-light opacity-50"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Niveles Section -->
    <div class="container mb-5" id="niveles">
        <h3 class="h3 fw-bold text-center mb-5">Nuestros Niveles de Formación</h3>
        
        @forelse($niveles as $nivel)
            <div class="card shadow-sm border-0 mb-4 transition hover-shadow">
                <div class="card-body p-4">
                    <div class="row align-items-center">
                        <div class="col-md-2 text-center mb-3 mb-md-0">
                            <div class="bg-primary bg-opacity-10 rounded-circle p-3 d-inline-block">
                                <i class="bi bi-mortarboard text-primary" style="font-size: 2rem;"></i>
                            </div>
                        </div>
                        <div class="col-md-10">
                            <h5 class="fw-bold card-title mb-2">{{ $nivel->nombre }}</h5>
                            @if($nivel->descripcion)
                                <p class="text-muted mb-0">{{ $nivel->descripcion }}</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="row">
                <div class="col-lg-8 mx-auto">
                    <div class="alert alert-info text-center py-5" role="alert">
                        <i class="bi bi-info-circle me-2" style="font-size: 2rem;"></i>
                        <p class="mb-0">No hay niveles de formación disponibles en este momento</p>
                    </div>
                </div>
            </div>
        @endforelse
    </div>

    <!-- CTA Section -->
    <div class="container mb-5">
        <div class="bg-primary text-white rounded-lg p-5 text-center">
            <h3 class="h4 fw-bold mb-3">¿Listo para comenzar tu formación?</h3>
            <p class="mb-4">Explora nuestros programas disponibles</p>
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
</style>
@endsection
