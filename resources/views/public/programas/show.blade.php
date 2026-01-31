@extends('layouts.bootstrap')

@section('title', $programa->nombre)

@section('content')
<div class="container-fluid">
    <!-- Hero Section with Breadcrumbs -->
    <div style="background-color: var(--sena-green);" class="text-white py-4 mb-5 rounded-lg overflow-hidden">
        <div class="container">
            <!-- Breadcrumbs -->
            <nav aria-label="breadcrumb" class="mb-3">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-white" style="opacity: 0.8;">Inicio</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('public.programasDeFormacion.index') }}" class="text-white" style="opacity: 0.8;">Programas</a></li>
                    <li class="breadcrumb-item active text-white" aria-current="page">{{ $programa->nombre }}</li>
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
                <div class="card mb-4">
                    <div class="card-body">
                        <h4 class="card-title fw-bold mb-3" style="color: var(--sena-green);">
                            <i class="bi bi-file-text me-2"></i>Descripción
                        </h4>
                        <p class="text-muted mb-0">{{ $programa->descripcion }}</p>
                    </div>
                </div>

                <!-- Requirements Section -->
                <div class="card mb-4">
                    <div class="card-body">
                        <h4 class="card-title fw-bold mb-3" style="color: var(--sena-green);">
                            <i class="bi bi-check-circle me-2" style="color: var(--sena-green);"></i>Requisitos
                        </h4>
                        <p class="text-muted">{{ $programa->requisitos ?? 'No especificados' }}</p>
                    </div>
                </div>

                <!-- Competencies Section -->
                @if($programa->competencias->count() > 0)
                <div class="card mb-4">
                    <div class="card-body">
                        <h4 class="card-title fw-bold mb-3" style="color: var(--sena-green);">
                            <i class="bi bi-star me-2" style="color: var(--sena-yellow);"></i>Competencias
                        </h4>
                        <div class="row g-3">
                            @foreach($programa->competencias as $competencia)
                            <div class="col-md-6">
                                <div class="p-3 rounded-lg" style="background-color: var(--neutral-bg);">
                                    <h6 class="fw-bold mb-2" style="color: var(--sena-blue-dark);">{{ $competencia->nombre }}</h6>
                                    <small class="text-muted">{{ $competencia->descripcion_corta ?? '' }}</small>
                                </div>
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
                <div class="card mb-4 sticky-top" style="top: 20px;">
                    <div class="card-body">
                        <h5 class="card-title fw-bold mb-3" style="color: var(--sena-green);">
                            <i class="bi bi-info-circle me-2"></i>Información
                        </h5>

                        <!-- Duration -->
                        @if($programa->duracion)
                        <div class="d-flex mb-3 pb-3 border-bottom">
                            <i class="bi bi-hourglass-split" style="font-size: 1.5rem; color: var(--sena-green); margin-right: 1rem;"></i>
                            <div>
                                <small class="text-muted d-block">Duración</small>
                                <strong style="color: var(--sena-blue-dark);">{{ $programa->duracion }}</strong>
                            </div>
                        </div>
                        @endif

                        <!-- Level -->
                        @if($programa->nivel)
                        <div class="d-flex mb-3 pb-3 border-bottom">
                            <i class="bi bi-mortarboard" style="font-size: 1.5rem; color: var(--sena-green); margin-right: 1rem;"></i>
                            <div>
                                <small class="text-muted d-block">Nivel</small>
                                <strong style="color: var(--sena-blue-dark);">{{ $programa->nivel->nombre ?? 'N/A' }}</strong>
                            </div>
                        </div>
                        @endif

                        <!-- Center -->
                        @if($programa->centro)
                        <div class="d-flex mb-3">
                            <i class="bi bi-geo-alt" style="font-size: 1.5rem; color: var(--sena-yellow); margin-right: 1rem;"></i>
                            <div>
                                <small class="text-muted d-block">Centro</small>
                                <strong style="color: var(--sena-blue-dark);">{{ $programa->centro->nombre }}</strong>
                            </div>
                        </div>
                        @endif

                        <!-- Enrollment Button -->
                        <button class="btn btn-primary-sena w-100 mt-4" data-bs-toggle="modal" data-bs-target="#enrollModal">
                            <i class="bi bi-check-circle me-2"></i>Solicitar Inscripción
                        </button>
                    </div>
                </div>

                <!-- Benefits Card -->
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title fw-bold mb-3" style="color: var(--sena-green);">
                            <i class="bi bi-star-fill me-2" style="color: var(--sena-yellow);"></i>Beneficios
                        </h5>
                        <ul class="list-unstyled">
                            <li class="mb-2">
                                <i class="bi bi-check-circle me-2" style="color: var(--sena-green);"></i>
                                <small>Formación de calidad</small>
                            </li>
                            <li class="mb-2">
                                <i class="bi bi-check-circle me-2" style="color: var(--sena-green);"></i>
                                <small>Certificación oficial</small>
                            </li>
                            <li class="mb-2">
                                <i class="bi bi-check-circle me-2" style="color: var(--sena-green);"></i>
                                <small>Docentes especializados</small>
                            </li>
                            <li>
                                <i class="bi bi-check-circle me-2" style="color: var(--sena-green);"></i>
                                <small>Bolsa de empleo</small>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- CTA Section -->
    <div style="background-color: var(--neutral-bg);" class="rounded-lg p-5 mb-5">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <h4 class="fw-bold mb-2" style="color: var(--sena-blue-dark);">¿Te interesa este programa?</h4>
                <p class="text-muted mb-0">Contacta con nuestro equipo de asesoría académica</p>
            </div>
            <div class="col-lg-4 text-lg-end mt-3 mt-lg-0">
                <a href="mailto:info@example.com" class="btn btn-primary-sena">
                    <i class="bi bi-envelope me-2"></i>Solicitar Información
                </a>
            </div>
        </div>
    </div>

    <!-- Back Button -->
    <div class="container mb-5">
        <a href="{{ route('public.programasDeFormacion.index') }}" class="btn btn-outline-sena">
            <i class="bi bi-arrow-left me-2"></i>Volver a Programas
        </a>
    </div>
</div>

<!-- Enrollment Modal -->
<div class="modal fade" id="enrollModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title fw-bold" style="color: var(--sena-blue-dark);">Solicitud de Inscripción</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" action="{{ route('inscripcion.store', $programa) }}" id="enrollForm">
                @csrf
                <div class="modal-body">
                    <input type="hidden" name="programa_id" value="{{ $programa->id }}">

                    <div class="mb-3">
                        <label for="observaciones" class="form-label" style="color: var(--sena-blue-dark); font-weight: 600;">Observaciones (Opcional)</label>
                        <textarea class="form-control" id="observaciones" name="observaciones" rows="3" maxlength="500"></textarea>
                        <small class="text-muted">Máximo 500 caracteres</small>
                    </div>

                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" id="acepta_terminos" name="acepta_terminos" value="1" required>
                        <label class="form-check-label" for="acepta_terminos" style="color: var(--sena-blue-dark);">
                            Acepto los términos y condiciones de inscripción
                        </label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-sena" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary-sena">Enviar Inscripción</button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const enrollForm = document.getElementById('enrollForm');
        
        if (enrollForm) {
            enrollForm.addEventListener('submit', function(e) {
                e.preventDefault();
                
                const termsCheckbox = document.getElementById('acepta_terminos');
                if (!termsCheckbox.checked) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Términos y Condiciones',
                        text: 'Debes aceptar los términos y condiciones para inscribirte',
                        confirmButtonColor: '#39a900'
                    });
                    return;
                }
                
                Swal.fire({
                    title: '¿Confirmar Inscripción?',
                    html: `
                        <p class="mb-3">Estás a punto de inscribirte en:</p>
                        <strong style="color: #39a900;">{{ $programa->nombre }}</strong>
                        <br><br>
                        <p class="text-muted" style="font-size: 0.9rem; margin-bottom: 0;">
                            <i class="bi bi-info-circle me-1"></i>
                            Recibirás una confirmación y podrás ver el programa en tu perfil
                        </p>
                    `,
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#39a900',
                    cancelButtonColor: '#00304D',
                    confirmButtonText: '<i class="bi bi-check-circle me-1"></i> Sí, inscribirme',
                    cancelButtonText: '<i class="bi bi-x-circle me-1"></i> Cancelar',
                    reverseButtons: true,
                    customClass: {
                        confirmButton: 'btn btn-lg',
                        cancelButton: 'btn btn-lg'
                    },
                    buttonsStyling: false
                }).then((result) => {
                    if (result.isConfirmed) {
                        Swal.fire({
                            title: 'Procesando inscripción...',
                            html: 'Por favor espera un momento',
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            didOpen: () => {
                                Swal.showLoading();
                            }
                        });
                        
                        enrollForm.submit();
                    }
                });
            });
        }
    });
</script>
@endpush

@endsection