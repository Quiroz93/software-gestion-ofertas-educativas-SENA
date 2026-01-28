@extends('layouts.bootstrap')

@section('title', $programa->nombre)

@section('content')
<div class="container-fluid">
    <!-- Hero Section with Breadcrumbs -->
    <div class="bg-primary text-white py-4 mb-5 rounded-lg overflow-hidden">
        <div class="container">
            <!-- Breadcrumbs -->
            <nav aria-label="breadcrumb" class="mb-3">
                <ol class="breadcrumb breadcrumb-dark mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-white-50">Inicio</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('public.programasDeFormacion.index') }}" class="text-white-50">Programas</a></li>
                    <li class="breadcrumb-item active text-white">{{ $programa->nombre }}</li>
                </ol>
            </nav>

            <!-- Title and Meta -->
            <div class="row align-items-center mt-3">
                <div class="col-lg-8">
                    <h1 class="display-5 fw-bold mb-3">{{ $programa->nombre }}</h1>
                    <p class="lead mb-0">
                        <i class="bi bi-tag me-2"></i>
                        Programa de Formación
                    </p>
                </div>
                <div class="col-lg-4 text-lg-end d-none d-lg-block">
                    <i class="bi bi-book-half text-white" style="font-size: 4rem; opacity: 0.3;"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="container mb-5">
        <div class="row g-4">
            <!-- Left Column - Main Content -->
            <div class="col-lg-8">
                <!-- Description Section -->
                <div class="card shadow-sm border-0 mb-4 rounded-lg">
                    <div class="card-body">
                        <h4 class="card-title fw-bold mb-3">
                            <i class="bi bi-file-text me-2 text-primary"></i>Descripción
                        </h4>
                        <p class="text-muted mb-0">{{ $programa->descripcion }}</p>
                    </div>
                </div>

                <!-- Requirements Section -->
                <div class="card shadow-sm border-0 mb-4 rounded-lg">
                    <div class="card-body">
                        <h4 class="card-title fw-bold mb-3">
                            <i class="bi bi-check-circle me-2 text-success"></i>Requisitos
                        </h4>
                        <p class="text-muted">{{ $programa->requisitos ?? 'No especificados' }}</p>
                    </div>
                </div>

                <!-- Competencies Section -->
                @if($programa->competencias->count() > 0)
                <div class="card shadow-sm border-0 mb-4 rounded-lg">
                    <div class="card-body">
                        <h4 class="card-title fw-bold mb-3">
                            <i class="bi bi-star me-2 text-warning"></i>Competencias
                        </h4>
                        <div class="row g-3">
                            @foreach($programa->competencias as $competencia)
                            <div class="col-md-6">
                                <div class="p-3 bg-light rounded-lg">
                                    <h6 class="fw-bold mb-2">{{ $competencia->nombre }}</h6>
                                    <small class="text-muted">{{ Str::limit($competencia->descripcion, 80) }}</small>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                @endif

                <!-- Related Programs -->
                @if($programa->programas()->count() > 0)
                <div class="card shadow-sm border-0 rounded-lg">
                    <div class="card-body">
                        <h4 class="card-title fw-bold mb-3">
                            <i class="bi bi-link-45deg me-2 text-info"></i>Programas Relacionados
                        </h4>
                        <div class="row g-3">
                            @foreach($programa->programas()->take(3) as $related)
                            <div class="col-md-6">
                                <a href="{{ route('public.programas.show', $related) }}"
                                   class="card border-0 shadow-sm text-decoration-none transition hover-shadow rounded-lg">
                                    <div class="card-body">
                                        <h6 class="card-title fw-bold text-primary mb-1">{{ $related->nombre }}</h6>
                                        <small class="text-muted d-block">Ver programa</small>
                                    </div>
                                </a>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                @endif
            </div>

            <!-- Right Column - Sidebar -->
            <div class="col-lg-4">
                <!-- Quick Info Card -->
                <div class="card shadow-sm border-0 mb-4 rounded-lg sticky-top" style="top: 20px;">
                    <div class="card-body">
                        <h5 class="card-title fw-bold mb-3">
                            <i class="bi bi-info-circle me-2 text-primary"></i>Información
                        </h5>

                        <!-- Duration -->
                        @if($programa->duracion)
                        <div class="d-flex mb-3 pb-3 border-bottom">
                            <i class="bi bi-hourglass-split text-primary me-3" style="font-size: 1.5rem;"></i>
                            <div>
                                <small class="text-muted d-block">Duración</small>
                                <strong>{{ $programa->duracion }}</strong>
                            </div>
                        </div>
                        @endif

                        <!-- Level -->
                        @if($programa->nivel)
                        <div class="d-flex mb-3 pb-3 border-bottom">
                            <i class="bi bi-mortarboard text-success me-3" style="font-size: 1.5rem;"></i>
                            <div>
                                <small class="text-muted d-block">Nivel</small>
                                <strong>{{ $programa->nivel->nombre ?? 'N/A' }}</strong>
                            </div>
                        </div>
                        @endif

                        <!-- Center -->
                        @if($programa->centro)
                        <div class="d-flex mb-3">
                            <i class="bi bi-geo-alt text-warning me-3" style="font-size: 1.5rem;"></i>
                            <div>
                                <small class="text-muted d-block">Centro</small>
                                <strong>{{ $programa->centro->nombre }}</strong>
                            </div>
                        </div>
                        @endif

                        <!-- Enrollment Button -->
                        <button class="btn btn-primary w-100 mt-4" data-bs-toggle="modal" data-bs-target="#enrollModal">
                            <i class="bi bi-check-circle me-2"></i>Solicitar Inscripción
                        </button>
                    </div>
                </div>

                <!-- Benefits Card -->
                <div class="card shadow-sm border-0 rounded-lg">
                    <div class="card-body">
                        <h5 class="card-title fw-bold mb-3">
                            <i class="bi bi-star-fill text-warning me-2"></i>Beneficios
                        </h5>
                        <ul class="list-unstyled">
                            <li class="mb-2">
                                <i class="bi bi-check-circle text-success me-2"></i>
                                <small>Formación de calidad</small>
                            </li>
                            <li class="mb-2">
                                <i class="bi bi-check-circle text-success me-2"></i>
                                <small>Certificación oficial</small>
                            </li>
                            <li class="mb-2">
                                <i class="bi bi-check-circle text-success me-2"></i>
                                <small>Docentes especializados</small>
                            </li>
                            <li>
                                <i class="bi bi-check-circle text-success me-2"></i>
                                <small>Bolsa de empleo</small>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- CTA Section -->
    <div class="bg-light rounded-lg p-5 mb-5">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <h4 class="fw-bold mb-2">¿Te interesa este programa?</h4>
                <p class="text-muted mb-0">Contacta con nuestro equipo de asesoría académica</p>
            </div>
            <div class="col-lg-4 text-lg-end mt-3 mt-lg-0">
                <a href="mailto:info@example.com" class="btn btn-primary">
                    <i class="bi bi-envelope me-2"></i>Solicitar Información
                </a>
            </div>
        </div>
    </div>

    <!-- Back Button -->
    <div class="container mb-5">
        <a href="{{ route('public.programasDeFormacion.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-2"></i>Volver a Programas
        </a>
    </div>
</div>

<!-- Enrollment Modal -->
<div class="modal fade" id="enrollModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title fw-bold">Solicitud de Inscripción</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" action="#">
                @csrf
                <div class="modal-body">
                    <input type="hidden" name="programa_id" value="{{ $programa->id }}">

                    <div class="mb-3">
                        <label for="nombre" class="form-label">Nombre Completo</label>
                        <input type="text" class="form-control" id="nombre" name="nombre" required>
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Correo Electrónico</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>

                    <div class="mb-3">
                        <label for="telefono" class="form-label">Teléfono</label>
                        <input type="tel" class="form-control" id="telefono" name="telefono">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Enviar Solicitud</button>
                </div>
            </form>
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

    .rounded-lg {
        border-radius: 1rem;
    }

    .breadcrumb-dark .breadcrumb-item.active {
        color: rgba(255, 255, 255, 0.8);
    }
</style>
@endsection