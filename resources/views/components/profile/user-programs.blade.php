@props(['user'])

<div class="card shadow-sm">
    <div class="card-header bg-primary text-white">
        <h5 class="mb-0">
            <i class="bi bi-book me-2"></i>
            Mis Programas de Formación
        </h5>
    </div>
    <div class="card-body">
        @php
            $inscripciones = $user->inscripcionesOrdenadas()->with(['programa.red', 'programa.competencias', 'programa.nivelFormacion', 'programa.centro', 'instructor'])->get();
        @endphp

        @if($inscripciones->isEmpty())
            <div class="alert alert-info mb-0">
                <i class="bi bi-info-circle me-2"></i>
                No estás inscrito en ningún programa actualmente.
            </div>
        @else
            <div class="accordion" id="accordionProgramas">
                @foreach($inscripciones as $index => $inscripcion)
                    @php
                        $programa = $inscripcion->programa;
                        $estadoClass = match($inscripcion->estado) {
                            'activo' => 'success',
                            'finalizado' => 'primary',
                            'retirado' => 'danger',
                            'inactivo' => 'secondary',
                            default => 'secondary'
                        };
                        $estadoIcon = match($inscripcion->estado) {
                            'activo' => 'check-circle-fill',
                            'finalizado' => 'trophy-fill',
                            'retirado' => 'x-circle-fill',
                            'inactivo' => 'pause-circle-fill',
                            default => 'circle'
                        };
                    @endphp

                    <div class="accordion-item border mb-3">
                        <h2 class="accordion-header" id="heading{{ $index }}">
                            <button class="accordion-button {{ $index === 0 ? '' : 'collapsed' }}" type="button" 
                                    data-bs-toggle="collapse" data-bs-target="#collapse{{ $index }}" 
                                    aria-expanded="{{ $index === 0 ? 'true' : 'false' }}" 
                                    aria-controls="collapse{{ $index }}">
                                <div class="w-100 d-flex justify-content-between align-items-center pe-3">
                                    <div>
                                        <strong>{{ $programa->nombre }}</strong>
                                        <br>
                                        <small class="text-muted">
                                            <i class="bi bi-calendar-event me-1"></i>
                                            Inscrito: {{ $inscripcion->fecha_inscripcion->format('d/m/Y') }}
                                        </small>
                                    </div>
                                    <span class="badge bg-{{ $estadoClass }} ms-2">
                                        <i class="bi bi-{{ $estadoIcon }} me-1"></i>
                                        {{ ucfirst($inscripcion->estado) }}
                                    </span>
                                </div>
                            </button>
                        </h2>
                        <div id="collapse{{ $index }}" 
                             class="accordion-collapse collapse {{ $index === 0 ? 'show' : '' }}" 
                             aria-labelledby="heading{{ $index }}" 
                             data-bs-parent="#accordionProgramas">
                            <div class="accordion-body">
                                {{-- Información del Programa --}}
                                <div class="row mb-4">
                                    <div class="col-md-6">
                                        <h6 class="text-primary">
                                            <i class="bi bi-info-circle me-1"></i>
                                            Información del Programa
                                        </h6>
                                        <table class="table table-sm table-borderless">
                                            <tr>
                                                <td class="text-muted" width="40%"><strong>Nivel:</strong></td>
                                                <td>{{ $programa->nivelFormacion->nombre ?? 'N/A' }}</td>
                                            </tr>
                                            <tr>
                                                <td class="text-muted"><strong>Modalidad:</strong></td>
                                                <td>{{ $programa->modalidad ?? 'N/A' }}</td>
                                            </tr>
                                            <tr>
                                                <td class="text-muted"><strong>Jornada:</strong></td>
                                                <td>{{ $programa->jornada ?? 'N/A' }}</td>
                                            </tr>
                                            <tr>
                                                <td class="text-muted"><strong>Duración:</strong></td>
                                                <td>{{ $programa->duracion_meses }} meses</td>
                                            </tr>
                                            <tr>
                                                <td class="text-muted"><strong>Centro:</strong></td>
                                                <td>{{ $programa->centro->nombre ?? 'N/A' }}</td>
                                            </tr>
                                        </table>
                                    </div>

                                    <div class="col-md-6">
                                        <h6 class="text-primary">
                                            <i class="bi bi-person-badge me-1"></i>
                                            Estado de Inscripción
                                        </h6>
                                        <table class="table table-sm table-borderless">
                                            <tr>
                                                <td class="text-muted" width="45%"><strong>Estado:</strong></td>
                                                <td>
                                                    <span class="badge bg-{{ $estadoClass }}">
                                                        {{ ucfirst($inscripcion->estado) }}
                                                    </span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-muted"><strong>Fecha inscripción:</strong></td>
                                                <td>{{ $inscripcion->fecha_inscripcion->format('d/m/Y') }}</td>
                                            </tr>
                                            @if($inscripcion->fecha_retiro)
                                            <tr>
                                                <td class="text-muted"><strong>Fecha retiro:</strong></td>
                                                <td>{{ $inscripcion->fecha_retiro->format('d/m/Y') }}</td>
                                            </tr>
                                            @endif
                                            @if($inscripcion->observaciones)
                                            <tr>
                                                <td class="text-muted"><strong>Observaciones:</strong></td>
                                                <td>{{ $inscripcion->observaciones }}</td>
                                            </tr>
                                            @endif
                                        </table>
                                    </div>
                                </div>

                                {{-- Red de Conocimiento --}}
                                @if($programa->red)
                                <div class="mb-4">
                                    <h6 class="text-primary">
                                        <i class="bi bi-diagram-3 me-1"></i>
                                        Red de Conocimiento
                                    </h6>
                                    <div class="alert alert-light mb-0">
                                        <strong>{{ $programa->red->nombre }}</strong>
                                        <p class="mb-0 mt-2">{{ $programa->red->descripcion }}</p>
                                    </div>
                                </div>
                                @endif

                                {{-- Instructor --}}
                                @if($inscripcion->instructor)
                                <div class="mb-4">
                                    <h6 class="text-primary">
                                        <i class="bi bi-person-check me-1"></i>
                                        Instructor a Cargo
                                    </h6>
                                    <div class="card bg-light">
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between align-items-start">
                                                <div>
                                                    <h6 class="mb-1">{{ $inscripcion->instructor->nombre }} {{ $inscripcion->instructor->apellidos }}</h6>
                                                    <p class="text-muted mb-2">
                                                        <i class="bi bi-envelope me-2"></i>
                                                        <a href="mailto:{{ $inscripcion->instructor->correo }}" 
                                                           class="text-decoration-none">
                                                            {{ $inscripcion->instructor->correo }}
                                                        </a>
                                                    </p>
                                                    @if($inscripcion->instructor->perfil_profesional)
                                                    <p class="mb-0 small">
                                                        <strong>Perfil:</strong> {{ Str::limit($inscripcion->instructor->perfil_profesional, 150) }}
                                                    </p>
                                                    @endif
                                                </div>
                                                <button class="btn btn-sm btn-outline-primary" 
                                                        type="button" 
                                                        data-bs-toggle="modal" 
                                                        data-bs-target="#instructorModal{{ $inscripcion->instructor->id }}">
                                                    <i class="bi bi-info-circle"></i>
                                                    Ver más
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{-- Modal Instructor --}}
                                <div class="modal fade" id="instructorModal{{ $inscripcion->instructor->id }}" tabindex="-1">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">
                                                    <i class="bi bi-person-badge me-2"></i>
                                                    Información del Instructor
                                                </h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <div class="modal-body">
                                                <h6>{{ $inscripcion->instructor->nombre }} {{ $inscripcion->instructor->apellidos }}</h6>
                                                <hr>
                                                <p><strong>Correo:</strong> {{ $inscripcion->instructor->correo }}</p>
                                                @if($inscripcion->instructor->perfil_profesional)
                                                <p><strong>Perfil Profesional:</strong><br>{{ $inscripcion->instructor->perfil_profesional }}</p>
                                                @endif
                                                @if($inscripcion->instructor->experiencia)
                                                <p><strong>Experiencia:</strong><br>{{ $inscripcion->instructor->experiencia }}</p>
                                                @endif
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endif

                                {{-- Competencias --}}
                                @if($programa->competencias->isNotEmpty())
                                <div class="mb-4">
                                    <h6 class="text-primary">
                                        <i class="bi bi-award me-1"></i>
                                        Competencias del Programa
                                    </h6>
                                    <div class="row">
                                        @foreach($programa->competencias as $competencia)
                                        <div class="col-md-6 mb-2">
                                            <div class="card h-100 border-start border-primary border-4">
                                                <div class="card-body p-2">
                                                    <h6 class="mb-1">{{ $competencia->nombre }}</h6>
                                                    <p class="text-muted mb-0 small">{{ $competencia->descripcion }}</p>
                                                </div>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                                @endif

                                {{-- Descripción y Requisitos --}}
                                <div class="row">
                                    @if($programa->descripcion)
                                    <div class="col-md-6 mb-3">
                                        <h6 class="text-primary">
                                            <i class="bi bi-file-text me-1"></i>
                                            Descripción
                                        </h6>
                                        <p class="text-muted">{{ $programa->descripcion }}</p>
                                    </div>
                                    @endif

                                    @if($programa->requisitos)
                                    <div class="col-md-6 mb-3">
                                        <h6 class="text-primary">
                                            <i class="bi bi-list-check me-1"></i>
                                            Requisitos
                                        </h6>
                                        <p class="text-muted">{{ $programa->requisitos }}</p>
                                    </div>
                                    @endif
                                </div>

                                {{-- Información Adicional --}}
                                <div class="mt-3">
                                    <h6 class="text-primary">
                                        <i class="bi bi-clipboard-data me-1"></i>
                                        Información Adicional
                                    </h6>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <small class="text-muted d-block">Título Otorgado</small>
                                            <strong>{{ $programa->titulo_otorgado ?? 'N/A' }}</strong>
                                        </div>
                                        @if($programa->codigo_snies)
                                        <div class="col-md-4">
                                            <small class="text-muted d-block">Código SNIES</small>
                                            <strong>{{ $programa->codigo_snies }}</strong>
                                        </div>
                                        @endif
                                        @if($programa->registro_calidad)
                                        <div class="col-md-4">
                                            <small class="text-muted d-block">Registro de Calidad</small>
                                            <strong>{{ $programa->registro_calidad }}</strong>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>
