@extends('layouts.bootstrap')

@section('title', 'Inscribirse - ' . $programa->nombre)

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <!-- Back Button -->
            <div class="mb-4">
                <a href="{{ route('public.programasDeFormacion.show', $programa) }}" class="btn btn-outline-secondary btn-sm">
                    <i class="bi bi-arrow-left me-2"></i>Volver al programa
                </a>
            </div>

            <!-- Page Header -->
            <div class="mb-4">
                <h1 class="h2 mb-2">
                    <i class="bi bi-pencil-square me-2"></i>Inscribirse al Programa
                </h1>
                <p class="text-muted">Completa el formulario para inscribirte a este programa de formación</p>
            </div>

            <!-- Error Messages -->
            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="bi bi-exclamation-triangle me-2"></i>
                    <strong>Error en el formulario:</strong>
                    <ul class="mb-0 mt-2">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <!-- Program Info Card -->
            <div class="card mb-4 border-info">
                <div class="card-header bg-info bg-opacity-10 border-info">
                    <h5 class="mb-0">
                        <i class="bi bi-book me-2"></i>{{ $programa->nombre }}
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <p class="mb-2"><strong>Duración:</strong></p>
                            <p class="text-muted">
                                @if($programa->duracion_horas)
                                    {{ $programa->duracion_horas }} horas
                                @else
                                    No especificada
                                @endif
                            </p>
                        </div>
                        <div class="col-md-6">
                            <p class="mb-2"><strong>Nivel:</strong></p>
                            <p class="text-muted">
                                @if($programa->nivel)
                                    <span class="badge bg-secondary">{{ $programa->nivel->nombre }}</span>
                                @else
                                    No especificado
                                @endif
                            </p>
                        </div>
                    </div>

                    @if($programa->descripcion)
                        <div class="mb-3">
                            <p class="mb-2"><strong>Descripción:</strong></p>
                            <p class="text-muted">{{ Str::limit($programa->descripcion, 200) }}</p>
                        </div>
                    @endif

                    @if($programa->competencias->count() > 0)
                        <div>
                            <p class="mb-2"><strong>Competencias:</strong></p>
                            <div class="d-flex flex-wrap gap-2">
                                @foreach($programa->competencias as $competencia)
                                    <span class="badge bg-light text-dark">{{ $competencia->nombre }}</span>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Inscription Form -->
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="bi bi-clipboard-check me-2"></i>Datos de Inscripción
                    </h5>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('inscripcion.store', $programa) }}">
                        @csrf

                        <!-- User Info (readonly) -->
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="nombre_usuario" class="form-label">Tu Nombre</label>
                                    <input type="text" 
                                           class="form-control" 
                                           id="nombre_usuario" 
                                           value="{{ $user->name }}" 
                                           readonly>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="email_usuario" class="form-label">Tu Correo</label>
                                    <input type="email" 
                                           class="form-control" 
                                           id="email_usuario" 
                                           value="{{ $user->email }}" 
                                           readonly>
                                </div>
                            </div>
                        </div>

                        <!-- Program Info (readonly) -->
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="programa_nombre" class="form-label">Programa</label>
                                    <input type="text" 
                                           class="form-control" 
                                           id="programa_nombre" 
                                           value="{{ $programa->nombre }}" 
                                           readonly>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="fecha_inscripcion" class="form-label">Fecha de Inscripción</label>
                                    <input type="date" 
                                           class="form-control" 
                                           id="fecha_inscripcion" 
                                           value="{{ now()->toDateString() }}" 
                                           readonly>
                                </div>
                            </div>
                        </div>

                        <!-- Observaciones -->
                        <div class="mb-4">
                            <label for="observaciones" class="form-label">Observaciones <span class="text-muted">(Opcional)</span></label>
                            <textarea class="form-control @error('observaciones') is-invalid @enderror" 
                                      id="observaciones" 
                                      name="observaciones" 
                                      rows="4" 
                                      placeholder="Comparte cualquier información relevante sobre tu experiencia o expectativas del programa..."
                                      maxlength="500">{{ old('observaciones') }}</textarea>
                            <small class="text-muted d-block mt-1">Máximo 500 caracteres</small>
                            @error('observaciones')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Terms and Conditions -->
                        <div class="mb-4">
                            <div class="form-check">
                                <input class="form-check-input @error('acepta_terminos') is-invalid @enderror" 
                                       type="checkbox" 
                                       id="acepta_terminos" 
                                       name="acepta_terminos" 
                                       value="1" 
                                       {{ old('acepta_terminos') ? 'checked' : '' }}>
                                <label class="form-check-label" for="acepta_terminos">
                                    Acepto los <a href="#" data-bs-toggle="modal" data-bs-target="#terminosModal">términos y condiciones</a> de la plataforma
                                </label>
                                @error('acepta_terminos')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-check-circle me-2"></i>Confirmar Inscripción
                            </button>
                            <a href="{{ route('public.programasDeFormacion.show', $programa) }}" class="btn btn-outline-secondary">
                                <i class="bi bi-x-circle me-2"></i>Cancelar
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Info Alert -->
            <div class="alert alert-info mt-4">
                <i class="bi bi-info-circle me-2"></i>
                <strong>Información importante:</strong> Una vez inscrito, podrás ver todos los detalles del programa en tu perfil. 
                Si cambias de opinión, podrás retirarte en cualquier momento desde tu sección de programas.
            </div>
        </div>
    </div>
</div>

<!-- Terms and Conditions Modal -->
<div class="modal fade" id="terminosModal" tabindex="-1" aria-labelledby="terminosModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="terminosModalLabel">Términos y Condiciones</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <h6>1. Aceptación de Términos</h6>
                <p>Al inscribirte en un programa de formación, aceptas cumplir con todos los términos y condiciones establecidos por la institución.</p>

                <h6>2. Responsabilidades del Aprendiz</h6>
                <p>Como aprendiz, te comprometes a:</p>
                <ul>
                    <li>Asistir regularmente a las sesiones del programa</li>
                    <li>Participar activamente en las actividades propuestas</li>
                    <li>Respetar el código de conducta institucional</li>
                    <li>Mantener la confidencialidad de materiales educativos</li>
                </ul>

                <h6>3. Derecho de Retiro</h6>
                <p>Puedes retirarte de un programa en cualquier momento. Sin embargo, es recomendable comunicar tu decisión al instructor.</p>

                <h6>4. Evaluación y Certificación</h6>
                <p>La certificación se otorgará únicamente a quienes cumplan con los requisitos establecidos y aprueben las evaluaciones correspondientes.</p>

                <h6>5. Datos Personales</h6>
                <p>Tus datos serán utilizados únicamente para fines educativos y administrativos conforme a nuestra política de privacidad.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>
@endsection
