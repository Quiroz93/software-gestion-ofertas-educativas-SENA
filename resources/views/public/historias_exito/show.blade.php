@extends('layouts.bootstrap')

@section('title', $historia_exito->titulo)

@section('content')
<div class="container-fluid">
    <!-- Hero Section -->
    <div style="background-color: var(--sena-green);" class="text-white py-5 mb-5 rounded-lg overflow-hidden">
        <div class="container">
            <!-- Breadcrumbs -->
            <nav aria-label="breadcrumb" class="mb-3">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-white" style="opacity: 0.8;">Inicio</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('public.historiasDeExito.index') }}" class="text-white" style="opacity: 0.8;">Historias de Éxito</a></li>
                    <li class="breadcrumb-item active text-white" aria-current="page">{{ $historia_exito->titulo_corta }}</li>
                </ol>
            </nav>

            <!-- Title -->
            <h1 class="display-4 fw-bold mb-3">{{ $historia_exito->titulo }}</h1>
            
            <div class="d-flex flex-wrap gap-3">
                <small class="text-white-50">
                    <i class="bi bi-person-check me-1"></i>
                    Historia de Éxito
                </small>
                <small class="text-white-50">
                    <i class="bi bi-calendar me-1"></i>
                    {{ $historia_exito->created_at->format('d/m/Y') }}
                </small>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="container mb-5">
        <div class="row g-4">
            <!-- Left Column - Content -->
            <div class="col-lg-8">
                <!-- Description Card -->
                <div class="card mb-4">
                    <div class="card-body">
                        <h4 class="card-title fw-bold mb-3" style="color: var(--sena-blue-dark);">
                            <i class="bi bi-file-text me-2" style="color: var(--sena-green);"></i>La Historia
                        </h4>
                        <div class="fs-5 lh-lg text-muted">
                            {!! nl2br(e($historia_exito->descripcion)) !!}
                        </div>
                    </div>
                </div>

                <!-- Key Points -->
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title fw-bold mb-3" style="color: var(--sena-blue-dark);">
                            <i class="bi bi-star-fill me-2" style="color: var(--sena-yellow);"></i>Puntos Clave
                        </h4>
                        <ul class="list-unstyled">
                            <li class="mb-3">
                                <i class="bi bi-check-circle me-2 fs-5" style="color: var(--sena-green);"></i>
                                <strong>Inspiración para otros estudiantes</strong>
                            </li>
                            <li class="mb-3">
                                <i class="bi bi-check-circle me-2 fs-5" style="color: var(--sena-green);"></i>
                                <strong>Ejemplo de dedicación y esfuerzo</strong>
                            </li>
                            <li class="mb-3">
                                <i class="bi bi-check-circle me-2 fs-5" style="color: var(--sena-green);"></i>
                                <strong>Logro profesional alcanzado</strong>
                            </li>
                            <li>
                                <i class="bi bi-check-circle me-2 fs-5" style="color: var(--sena-green);"></i>
                                <strong>Desarrollo de competencias exitosas</strong>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Right Column - Sidebar -->
            <div class="col-lg-4">
                <!-- Profile Card -->
                <div class="card mb-4 sticky-top" style="top: 20px;">
                    <div class="card-body text-center">
                        <div class="mb-3">
                            <i class="bi bi-person-circle" style="font-size: 4rem; color: var(--sena-green);"></i>
                        </div>
                        
                        <h5 class="fw-bold mb-2">{{ $historia_exito->titulo }}</h5>
                        
                        <p class="text-muted small mb-3">
                            <i class="bi bi-award me-1"></i>
                            Egresado Centro CATA
                        </p>

                        <hr>

                        <div class="text-start">
                            <small class="text-muted d-block mb-2">
                                <strong>Testimonio</strong>
                            </small>
                            <p class="small">
                                "La formación recibida en Centro CATA cambió mi vida profesional y personal."
                            </p>
                        </div>

                        <button class="btn btn-primary-sena w-100 mt-3" data-bs-toggle="modal" data-bs-target="#contactModal">
                            <i class="bi bi-envelope me-2"></i>Contactar Estudiante
                        </button>
                    </div>
                </div>

                <!-- CTA Card -->
                <div class="card text-white" style="background-color: var(--sena-green);">
                    <div class="card-body">
                        <h6 class="card-title fw-bold mb-2">
                            <i class="bi bi-rocket me-2"></i>¿Quieres Tu Historia?
                        </h6>
                        <p class="small mb-3">Forma parte de nuestros egresados exitosos</p>
                        <a href="{{ route('public.programasDeFormacion.index') }}" class="btn btn-sm btn-outline-sena bg-white w-100">
                            <i class="bi bi-arrow-right me-1"></i>Ver Programas
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Related Stories -->
    <div class="container mb-5">
        <h4 class="fw-bold mb-4" style="color: var(--sena-blue-dark);">
            <i class="bi bi-link-45deg me-2" style="color: var(--sena-blue-light);"></i>Otras Historias de Éxito
        </h4>

        <div class="row g-4">
            @for($i = 1; $i <= 3; $i++)
            <div class="col-lg-4">
                <div class="card">
                    <div class="bg-light d-flex align-items-center justify-content-center" style="height: 200px;">
                        <i class="bi bi-person-check" style="font-size: 2rem; color: var(--sena-green);"></i>
                    </div>
                    <div class="card-body">
                        <h6 class="card-title fw-bold" style="color: var(--sena-green);">Historia {{ $i }}</h6>
                        <p class="card-text small text-muted mb-3">
                            Experiencia de transformación y éxito profesional
                        </p>
                        <a href="#" class="btn btn-outline-sena btn-sm">
                            <i class="bi bi-arrow-right me-1"></i>Leer
                        </a>
                    </div>
                </div>
            </div>
            @endfor
        </div>
    </div>

    <!-- Back Button -->
    <div class="container mb-5">
        <a href="{{ route('public.historiasDeExito.index') }}" class="btn btn-outline-sena">
            <i class="bi bi-arrow-left me-2"></i>Volver a Historias
        </a>
    </div>
</div>

<!-- Contact Modal -->
<div class="modal fade" id="contactModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title fw-bold" style="color: var(--sena-blue-dark);">Contactar Egresado</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" action="#">
                @csrf
                <div class="modal-body">
                    <input type="hidden" name="historia_exito_id" value="{{ $historia_exito->id }}">

                    <div class="mb-3">
                        <label for="nombre" class="form-label">Tu Nombre</label>
                        <input type="text" class="form-control" id="nombre" name="nombre" required>
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Correo Electrónico</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>

                    <div class="mb-3">
                        <label for="mensaje" class="form-label">Mensaje</label>
                        <textarea class="form-control" id="mensaje" name="mensaje" rows="3" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-sena" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary-sena">Enviar</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection