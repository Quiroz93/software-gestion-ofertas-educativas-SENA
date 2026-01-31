@extends('layouts.bootstrap')

@section('title', 'Niveles de Formación')

@section('content')
<div class="container-fluid">
    <!-- Hero Section -->
    <div style="background-color: var(--sena-green);" class="text-white py-5 mb-5 rounded-bottom-lg">
        <div class="container">
            <div class="row align-items-center g-4">
                <div class="col-lg-8">
                    <h1 class="display-4 fw-bold mb-3">Niveles de Formación</h1>
                    <p class="lead mb-4">
                        <i class="bi bi-info-circle me-2"></i>
                        Conoce los diferentes niveles de formación disponibles en el SENA
                    </p>
                    <a href="#niveles" class="btn btn-outline-sena bg-white">
                        <i class="bi bi-arrow-down me-2"></i>Ver Niveles
                    </a>
                </div>
                <div class="col-lg-4 text-center">
                    <i class="bi bi-mortarboard display-3 text-white opacity-50"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Niveles Section -->
    <div class="container mb-5 py-4" id="niveles">
        <h3 class="h3 fw-bold text-center mb-5" style="color: var(--sena-blue-dark);">Nuestros Niveles de Formación</h3>
        
        @forelse($niveles as $nivel)
            <div class="row mb-4">
                <div class="col-lg-10 mx-auto">
                    <div class="card">
                        <div class="card-body p-4">
                            <div class="d-flex align-items-start">
                                <div class="me-4">
                                    <div style="background-color: rgba(57,169,0,0.08);" class="rounded-circle p-3">
                                        <i class="bi bi-mortarboard" style="font-size: 2rem; color: var(--sena-green);"></i>
                                    </div>
                                </div>
                                <div class="flex-grow-1">
                                    <h5 class="fw-bold mb-2" style="color: var(--sena-blue-dark);">{{ $nivel->nombre }}</h5>
                                    <p class="text-muted mb-0">{{ $nivel->descripcion ?? 'Nivel de formación profesional' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="row">
                <div class="col-lg-8 mx-auto">
                    <div class="alert text-center py-5" role="alert" style="background-color: var(--neutral-bg); border: 1px solid var(--sena-blue-light); color: var(--sena-blue-dark);">
                        <i class="bi bi-info-circle me-2" style="font-size: 2rem;"></i>
                        <p class="mb-0">No hay niveles de formación disponibles en este momento</p>
                    </div>
                </div>
            </div>
        @endforelse

        <!-- Pagination -->
        @if($niveles->hasPages())
            <div class="d-flex justify-content-center mt-4">
                {{ $niveles->links() }}
            </div>
        @endif
    </div>

    <!-- CTA Section -->
    <div class="container mb-5">
        <div style="background-color: var(--sena-green);" class="text-white rounded-lg p-5 text-center">
            <h3 class="h4 fw-bold mb-3">¿Quieres conocer nuestros programas?</h3>
            <p class="mb-4">Explora todos los programas disponibles según tu nivel de interés</p>
            <a href="{{ route('public.programasDeFormacion.index') }}" class="btn btn-outline-sena bg-white">
                <i class="bi bi-arrow-right me-2"></i>Ver Programas
            </a>
        </div>
    </div>
</div>
@endsection
