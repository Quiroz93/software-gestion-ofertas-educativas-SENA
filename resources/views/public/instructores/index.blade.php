@extends('layouts.bootstrap')

@section('title', 'Instructores')

@push('styles')
    @vite(['resources/css/public/instructores.css'])
@endpush

@section('content')
<div class="container-fluid">
    <!-- Hero Section -->
    <div style="background-color: var(--sena-green);" class="text-white py-5 mb-5 rounded-bottom-lg">
        <div class="container">
            <div class="row align-items-center g-4">
                <div class="col-lg-8">
                    <h1 class="display-4 fw-bold mb-3">Nuestro Equipo de Instructores</h1>
                    <p class="lead mb-4">
                        <i class="bi bi-info-circle me-2"></i>
                        Profesionales expertos comprometidos con tu formación de calidad
                    </p>
                    <a href="#instructores" class="btn btn-outline-sena bg-white">
                        <i class="bi bi-arrow-down me-2"></i>Conocer Equipo
                    </a>
                </div>
                <div class="col-lg-4 text-center">
                    <i class="bi bi-people display-3 text-white opacity-50"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- About Section -->
    <div class="container mb-5 py-4">
        <div class="row g-4 mb-5">
            <div class="col-lg-8 mx-auto">
                <div class="card shadow-sm border-0">
                    <div class="card-body p-5">
                        <h3 class="h4 fw-bold mb-3" style="color: var(--sena-blue-dark);">Equipo Docente de Excelencia</h3>
                        <p class="text-muted mb-3">
                            Nuestro equipo de instructores está compuesto por profesionales con amplia 
                            experiencia en sus áreas de especialización, certificados por organismos nacionales 
                            e internacionales.
                        </p>
                        <p class="text-muted mb-3">
                            Cada uno de nuestros instructores trae consigo experiencia real del sector, 
                            garantizando una formación práctica y contextualizada a las necesidades del mercado laboral.
                        </p>
                        <ul class="list-unstyled">
                            <li class="mb-2"><i class="bi bi-check-circle me-2" style="color: var(--sena-green);"></i>Experiencia profesional comprobada</li>
                            <li class="mb-2"><i class="bi bi-check-circle me-2" style="color: var(--sena-green);"></i>Certificaciones internacionales</li>
                            <li class="mb-2"><i class="bi bi-check-circle me-2" style="color: var(--sena-green);"></i>Metodología pedagógica actualizada</li>
                            <li><i class="bi bi-check-circle me-2" style="color: var(--sena-green);"></i>Compromiso con la calidad educativa</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Instructores List Section -->
    <div style="background-color: var(--neutral-bg);" class="py-5 mb-5" id="instructores">
        <div class="container">
            <h3 class="h3 fw-bold text-center mb-5" style="color: var(--sena-blue-dark);">Conoce a Nuestros Instructores</h3>
            
            @if(isset($instructores) && $instructores->count() > 0)
                <div class="row g-4">
                    @foreach($instructores as $instructor)
                    <div class="col-lg-4 col-md-6">
                        <div class="card text-center h-100">
                            <div class="card-body p-4">
                                <div class="mb-3">
                                    <div style="background-color: rgba(57,169,0,0.08);" class="rounded-circle p-4 d-inline-block mb-3">
                                        <i class="bi bi-person-circle" style="font-size: 3rem; color: var(--sena-green);"></i>
                                    </div>
                                </div>
                                <h5 class="fw-bold card-title" style="color: var(--sena-blue-dark);">{{ $instructor->nombre }} {{ $instructor->apellidos ?? '' }}</h5>
                                <p class="text-muted" style="font-size: 0.9rem; margin-bottom: 0.75rem;">{{ $instructor->perfil_profesional ?? 'Instructor' }}</p>
                                @isset($instructor->experiencia)
                                    <p class="text-muted" style="font-size: 0.85rem;">{{ $instructor->experiencia_corta }}</p>
                                @endisset
                                @isset($instructor->correo)
                                    <a href="mailto:{{ $instructor->correo }}" class="btn btn-primary-sena btn-sm">
                                        <i class="bi bi-envelope me-1"></i>Contactar
                                    </a>
                                @endisset
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                
                <!-- Pagination -->
                <div class="d-flex justify-content-center mt-5">
                    {{ $instructores->links() }}
                </div>
            @else
                <div class="row">
                    <div class="col-lg-8 mx-auto">
                        <div class="alert text-center" role="alert" style="background-color: var(--neutral-bg); border: 1px solid var(--sena-blue-light); color: var(--sena-blue-dark);">
                            <i class="bi bi-info-circle me-2"></i>
                            Equipo de instructores disponible próximamente
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <!-- CTA Section -->
    <div class="container mb-5">
        <div style="background-color: var(--sena-green);" class="text-white rounded-lg p-5 text-center">
            <h3 class="h4 fw-bold mb-3">¿Quieres aprender de nuestros expertos?</h3>
            <p class="mb-4">Consulta nuestros programas y elige el que mejor se ajuste a tus intereses</p>
            <a href="{{ route('public.programasDeFormacion.index') }}" class="btn btn-outline-sena bg-white">
                <i class="bi bi-arrow-right me-2"></i>Ver Programas
            </a>
        </div>
    </div>
</div>
@endsection