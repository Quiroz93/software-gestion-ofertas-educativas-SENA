@extends('layouts.bootstrap')

@section('title', 'Centro de Formación')

@section('content')
<div class="container-fluid">
    <!-- Hero Section -->
    <div class="hero hero-programa hero-md">
        <div class="container">
            <div class="row align-items-center g-4">
                <div class="col-lg-8">
                    <h1 class="hero-title fw-bold mb-3">Centro Agroempresarial y Turístico de los Andes</h1>
                    <p class="hero-subtitle mb-4">
                        <i class="bi bi-info-circle me-2"></i>
                        Conoce nuestra institución y su compromiso con la formación de calidad
                    </p>
                    <a href="#detalles" class="btn btn-light btn-lg">
                        <i class="bi bi-arrow-down me-2"></i>Más Información
                    </a>
                </div>
                <div class="col-lg-4 text-center">
                    <i class="bi bi-building display-3 text-light opacity-50"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Centro Information Section -->
    <div class="container mb-5 py-4" id="detalles">
        <div class="row g-4">
            <!-- About Centro -->
            <div class="col-lg-6">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-body p-5">
                        <h3 class="h4 fw-bold mb-3">
                            <i class="bi bi-info-circle text-primary me-2"></i>Acerca del Centro
                        </h3>
                        <p class="text-muted mb-3">
                            El Centro Agroempresarial y Turístico de los Andes es una institución del SENA 
                            comprometida con la formación integral de talento humano en las áreas agrícola, 
                            empresarial y turística.
                        </p>
                        <p class="text-muted mb-3">
                            Contamos con instalaciones modernas, equipos tecnológicos de punta y un equipo 
                            de docentes especializados dedicados a impartir una formación de excelencia.
                        </p>
                        <ul class="list-unstyled">
                            <li class="mb-2"><i class="bi bi-check-circle text-success me-2"></i>Programas acreditados</li>
                            <li class="mb-2"><i class="bi bi-check-circle text-success me-2"></i>Docentes certificados</li>
                            <li class="mb-2"><i class="bi bi-check-circle text-success me-2"></i>Infraestructura moderna</li>
                            <li><i class="bi bi-check-circle text-success me-2"></i>Apoyo a emprendimiento</li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Contact Information -->
            <div class="col-lg-6">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-body p-5">
                        <h3 class="h4 fw-bold mb-3">
                            <i class="bi bi-telephone text-primary me-2"></i>Información de Contacto
                        </h3>
                        <div class="mb-4">
                            <p class="text-muted mb-1"><strong>Ubicación:</strong></p>
                            <p class="mb-3">Carrera 11 No. 13-13, Nariño</p>
                        </div>
                        <div class="mb-4">
                            <p class="text-muted mb-1"><strong>Teléfono:</strong></p>
                            <p class="mb-3">
                                <a href="tel:+5724234500" class="text-decoration-none">
                                    +57 2 423 45 00
                                </a>
                            </p>
                        </div>
                        <div class="mb-4">
                            <p class="text-muted mb-1"><strong>Línea de atención:</strong></p>
                            <p class="mb-3">
                                <a href="tel:+5718000910270" class="text-decoration-none">
                                    01 8000 91 02 70
                                </a>
                            </p>
                        </div>
                        <div class="mb-4">
                            <p class="text-muted mb-1"><strong>Correo Electrónico:</strong></p>
                            <p class="mb-0">
                                <a href="mailto:centro@sena.edu.co" class="text-decoration-none">
                                    centro@sena.edu.co
                                </a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Features Section -->
    <div class="bg-light py-5 mb-5">
        <div class="container">
            <h3 class="h3 fw-bold text-center mb-5">Nuestros Servicios</h3>
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="text-center">
                        <div class="bg-primary bg-opacity-10 rounded-circle p-4 d-inline-block mb-3">
                            <i class="bi bi-book-half text-primary fs-2"></i>
                        </div>
                        <h5 class="fw-bold">Formación Profesional</h5>
                        <p class="text-muted small">Programas diseñados para el desarrollo de competencias</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="text-center">
                        <div class="bg-success bg-opacity-10 rounded-circle p-4 d-inline-block mb-3">
                            <i class="bi bi-briefcase text-success fs-2"></i>
                        </div>
                        <h5 class="fw-bold">Consultoría Empresarial</h5>
                        <p class="text-muted small">Asesoramiento a empresas y emprendedores</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="text-center">
                        <div class="bg-warning bg-opacity-10 rounded-circle p-4 d-inline-block mb-3">
                            <i class="bi bi-graph-up text-warning fs-2"></i>
                        </div>
                        <h5 class="fw-bold">Innovación Tecnológica</h5>
                        <p class="text-muted small">Espacios con tecnología de punta para aprendizaje</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- CTA Section -->
    <div class="container mb-5">
        <div class="bg-primary text-white rounded p-5 text-center">
            <h3 class="h4 fw-bold mb-3">¿Interesado en nuestros programas?</h3>
            <p class="mb-4">Explora nuestra oferta educativa y encuentra el programa que se adapte a tus objetivos</p>
            <a href="{{ route('public.programasDeFormacion.index') }}" class="btn btn-light btn-lg">
                <i class="bi bi-arrow-right me-2"></i>Ver Programas
            </a>
        </div>
    </div>
</div>
@endsection