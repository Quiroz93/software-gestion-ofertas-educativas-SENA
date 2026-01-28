@extends('layouts.bootstrap')

@section('title', 'Instructores')

@section('content')
<div class="container-fluid">
    <!-- Hero Section -->
    <div class="bg-success text-white py-5 mb-5 rounded-bottom-lg">
        <div class="container">
            <div class="row align-items-center g-4">
                <div class="col-lg-8">
                    <h1 class="display-4 fw-bold mb-3">Nuestro Equipo de Instructores</h1>
                    <p class="lead mb-4">
                        <i class="bi bi-info-circle me-2"></i>
                        Profesionales expertos comprometidos con tu formación de calidad
                    </p>
                    <a href="#instructores" class="btn btn-light btn-lg">
                        <i class="bi bi-arrow-down me-2"></i>Conocer Equipo
                    </a>
                </div>
                <div class="col-lg-4 text-center">
                    <i class="bi bi-people display-3 text-light opacity-50"></i>
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
                        <h3 class="h4 fw-bold mb-3">Equipo Docente de Excelencia</h3>
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
                            <li class="mb-2"><i class="bi bi-check-circle text-success me-2"></i>Experiencia profesional comprobada</li>
                            <li class="mb-2"><i class="bi bi-check-circle text-success me-2"></i>Certificaciones internacionales</li>
                            <li class="mb-2"><i class="bi bi-check-circle text-success me-2"></i>Metodología pedagógica actualizada</li>
                            <li><i class="bi bi-check-circle text-success me-2"></i>Compromiso con la calidad educativa</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Instructores List Section -->
    <div class="bg-light py-5 mb-5" id="instructores">
        <div class="container">
            <h3 class="h3 fw-bold text-center mb-5">Conoce a Nuestros Instructores</h3>
            
            @if(isset($instructores) && $instructores->count() > 0)
                <div class="row g-4">
                    @foreach($instructores as $instructor)
                    <div class="col-lg-4 col-md-6">
                        <div class="card shadow-sm border-0 text-center transition hover-shadow h-100">
                            <div class="card-body p-4">
                                <div class="mb-3">
                                    <div class="bg-secondary bg-opacity-10 rounded-circle p-4 d-inline-block mb-3">
                                        <i class="bi bi-person-circle text-secondary" style="font-size: 3rem;"></i>
                                    </div>
                                </div>
                                <h5 class="fw-bold card-title">{{ $instructor->nombre ?? 'Instructor' }}</h5>
                                <p class="text-muted small mb-3">{{ $instructor->especialidad ?? 'Especialidad' }}</p>
                                @if($instructor->resena ?? null)
                                    <p class="text-muted small">{{ Str::limit($instructor->resena, 100) }}</p>
                                @endif
                                @if($instructor->email ?? null)
                                    <a href="mailto:{{ $instructor->email }}" class="btn btn-sm btn-outline-success">
                                        <i class="bi bi-envelope me-1"></i>Contactar
                                    </a>
                                @endif
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
                            Equipo de instructores disponible próximamente
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <!-- CTA Section -->
    <div class="container mb-5">
        <div class="bg-success text-white rounded-lg p-5 text-center">
            <h3 class="h4 fw-bold mb-3">¿Quieres aprender de nuestros expertos?</h3>
            <p class="mb-4">Consulta nuestros programas y elige el que mejor se ajuste a tus intereses</p>
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