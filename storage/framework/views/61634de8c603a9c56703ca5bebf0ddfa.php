<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['user']));

foreach ($attributes->all() as $__key => $__value) {
    if (in_array($__key, $__propNames)) {
        $$__key = $$__key ?? $__value;
    } else {
        $__newAttributes[$__key] = $__value;
    }
}

$attributes = new \Illuminate\View\ComponentAttributeBag($__newAttributes);

unset($__propNames);
unset($__newAttributes);

foreach (array_filter((['user']), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<div class="card shadow-sm">
    <div class="card-header bg-primary text-white">
        <h5 class="mb-0">
            <i class="bi bi-book me-2"></i>
            Mis Programas de Formación
        </h5>
    </div>
    <div class="card-body">
        <?php
            $inscripciones = $user->inscripcionesOrdenadas()->with(['programa.red', 'programa.competencias', 'programa.nivelFormacion', 'programa.centro', 'instructor'])->get();
        ?>

        <?php if($inscripciones->isEmpty()): ?>
            <div class="alert alert-info mb-0">
                <i class="bi bi-info-circle me-2"></i>
                No estás inscrito en ningún programa actualmente.
            </div>
        <?php else: ?>
            <div class="accordion" id="accordionProgramas">
                <?php $__currentLoopData = $inscripciones; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $inscripcion): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php
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
                    ?>

                    <div class="accordion-item border mb-3">
                        <h2 class="accordion-header" id="heading<?php echo e($index); ?>">
                            <button class="accordion-button <?php echo e($index === 0 ? '' : 'collapsed'); ?>" type="button" 
                                    data-bs-toggle="collapse" data-bs-target="#collapse<?php echo e($index); ?>" 
                                    aria-expanded="<?php echo e($index === 0 ? 'true' : 'false'); ?>" 
                                    aria-controls="collapse<?php echo e($index); ?>">
                                <div class="w-100 d-flex justify-content-between align-items-center pe-3">
                                    <div>
                                        <strong><?php echo e($programa->nombre); ?></strong>
                                        <br>
                                        <small class="text-muted">
                                            <i class="bi bi-calendar-event me-1"></i>
                                            Inscrito: <?php echo e($inscripcion->fecha_inscripcion->format('d/m/Y')); ?>

                                        </small>
                                    </div>
                                    <span class="badge bg-<?php echo e($estadoClass); ?> ms-2">
                                        <i class="bi bi-<?php echo e($estadoIcon); ?> me-1"></i>
                                        <?php echo e(ucfirst($inscripcion->estado)); ?>

                                    </span>
                                </div>
                            </button>
                        </h2>
                        <div id="collapse<?php echo e($index); ?>" 
                             class="accordion-collapse collapse <?php echo e($index === 0 ? 'show' : ''); ?>" 
                             aria-labelledby="heading<?php echo e($index); ?>" 
                             data-bs-parent="#accordionProgramas">
                            <div class="accordion-body">
                                
                                <div class="row mb-4">
                                    <div class="col-md-6">
                                        <h6 class="text-primary">
                                            <i class="bi bi-info-circle me-1"></i>
                                            Información del Programa
                                        </h6>
                                        <table class="table table-sm table-borderless">
                                            <tr>
                                                <td class="text-muted" width="40%"><strong>Nivel:</strong></td>
                                                <td><?php echo e($programa->nivelFormacion->nombre ?? 'N/A'); ?></td>
                                            </tr>
                                            <tr>
                                                <td class="text-muted"><strong>Modalidad:</strong></td>
                                                <td><?php echo e($programa->modalidad ?? 'N/A'); ?></td>
                                            </tr>
                                            <tr>
                                                <td class="text-muted"><strong>Jornada:</strong></td>
                                                <td><?php echo e($programa->jornada ?? 'N/A'); ?></td>
                                            </tr>
                                            <tr>
                                                <td class="text-muted"><strong>Duración:</strong></td>
                                                <td><?php echo e($programa->duracion_meses); ?> meses</td>
                                            </tr>
                                            <tr>
                                                <td class="text-muted"><strong>Centro:</strong></td>
                                                <td><?php echo e($programa->centro->nombre ?? 'N/A'); ?></td>
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
                                                    <span class="badge bg-<?php echo e($estadoClass); ?>">
                                                        <?php echo e(ucfirst($inscripcion->estado)); ?>

                                                    </span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-muted"><strong>Fecha inscripción:</strong></td>
                                                <td><?php echo e($inscripcion->fecha_inscripcion->format('d/m/Y')); ?></td>
                                            </tr>
                                            <?php if($inscripcion->fecha_retiro): ?>
                                            <tr>
                                                <td class="text-muted"><strong>Fecha retiro:</strong></td>
                                                <td><?php echo e($inscripcion->fecha_retiro->format('d/m/Y')); ?></td>
                                            </tr>
                                            <?php endif; ?>
                                            <?php if($inscripcion->observaciones): ?>
                                            <tr>
                                                <td class="text-muted"><strong>Observaciones:</strong></td>
                                                <td><?php echo e($inscripcion->observaciones); ?></td>
                                            </tr>
                                            <?php endif; ?>
                                        </table>
                                    </div>
                                </div>

                                
                                <?php if($programa->red): ?>
                                <div class="mb-4">
                                    <h6 class="text-primary">
                                        <i class="bi bi-diagram-3 me-1"></i>
                                        Red de Conocimiento
                                    </h6>
                                    <div class="alert alert-light mb-0">
                                        <strong><?php echo e($programa->red->nombre); ?></strong>
                                        <p class="mb-0 mt-2"><?php echo e($programa->red->descripcion); ?></p>
                                    </div>
                                </div>
                                <?php endif; ?>

                                
                                <?php if($inscripcion->instructor): ?>
                                <div class="mb-4">
                                    <h6 class="text-primary">
                                        <i class="bi bi-person-check me-1"></i>
                                        Instructor a Cargo
                                    </h6>
                                    <div class="card bg-light">
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between align-items-start">
                                                <div>
                                                    <h6 class="mb-1"><?php echo e($inscripcion->instructor->nombre); ?> <?php echo e($inscripcion->instructor->apellidos); ?></h6>
                                                    <p class="text-muted mb-2">
                                                        <i class="bi bi-envelope me-2"></i>
                                                        <a href="mailto:<?php echo e($inscripcion->instructor->correo); ?>" 
                                                           class="text-decoration-none">
                                                            <?php echo e($inscripcion->instructor->correo); ?>

                                                        </a>
                                                    </p>
                                                    <?php if($inscripcion->instructor->perfil_profesional): ?>
                                                    <p class="mb-0 small">
                                                        <strong>Perfil:</strong> <?php echo e($inscripcion->instructor->perfil_profesional_corta); ?>

                                                    </p>
                                                    <?php endif; ?>
                                                </div>
                                                <button class="btn btn-sm btn-outline-primary" 
                                                        type="button" 
                                                        data-bs-toggle="modal" 
                                                        data-bs-target="#instructorModal<?php echo e($inscripcion->instructor->id); ?>">
                                                    <i class="bi bi-info-circle"></i>
                                                    Ver más
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                
                                <div class="modal fade" id="instructorModal<?php echo e($inscripcion->instructor->id); ?>" tabindex="-1">
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
                                                <h6><?php echo e($inscripcion->instructor->nombre); ?> <?php echo e($inscripcion->instructor->apellidos); ?></h6>
                                                <hr>
                                                <p><strong>Correo:</strong> <?php echo e($inscripcion->instructor->correo); ?></p>
                                                <?php if($inscripcion->instructor->perfil_profesional): ?>
                                                <p><strong>Perfil Profesional:</strong><br><?php echo e($inscripcion->instructor->perfil_profesional); ?></p>
                                                <?php endif; ?>
                                                <?php if($inscripcion->instructor->experiencia): ?>
                                                <p><strong>Experiencia:</strong><br><?php echo e($inscripcion->instructor->experiencia); ?></p>
                                                <?php endif; ?>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php endif; ?>

                                
                                <?php if($programa->competencias->isNotEmpty()): ?>
                                <div class="mb-4">
                                    <h6 class="text-primary">
                                        <i class="bi bi-award me-1"></i>
                                        Competencias del Programa
                                    </h6>
                                    <div class="row">
                                        <?php $__currentLoopData = $programa->competencias; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $competencia): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <div class="col-md-6 mb-2">
                                            <div class="card h-100 border-start border-primary border-4">
                                                <div class="card-body p-2">
                                                    <h6 class="mb-1"><?php echo e($competencia->nombre); ?></h6>
                                                    <p class="text-muted mb-0 small"><?php echo e($competencia->descripcion); ?></p>
                                                </div>
                                            </div>
                                        </div>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </div>
                                </div>
                                <?php endif; ?>

                                
                                <div class="row">
                                    <?php if($programa->descripcion): ?>
                                    <div class="col-md-6 mb-3">
                                        <h6 class="text-primary">
                                            <i class="bi bi-file-text me-1"></i>
                                            Descripción
                                        </h6>
                                        <p class="text-muted"><?php echo e($programa->descripcion); ?></p>
                                    </div>
                                    <?php endif; ?>

                                    <?php if($programa->requisitos): ?>
                                    <div class="col-md-6 mb-3">
                                        <h6 class="text-primary">
                                            <i class="bi bi-list-check me-1"></i>
                                            Requisitos
                                        </h6>
                                        <p class="text-muted"><?php echo e($programa->requisitos); ?></p>
                                    </div>
                                    <?php endif; ?>
                                </div>

                                
                                <div class="mt-3">
                                    <h6 class="text-primary">
                                        <i class="bi bi-clipboard-data me-1"></i>
                                        Información Adicional
                                    </h6>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <small class="text-muted d-block">Título Otorgado</small>
                                            <strong><?php echo e($programa->titulo_otorgado ?? 'N/A'); ?></strong>
                                        </div>
                                        <?php if($programa->codigo_snies): ?>
                                        <div class="col-md-4">
                                            <small class="text-muted d-block">Código SNIES</small>
                                            <strong><?php echo e($programa->codigo_snies); ?></strong>
                                        </div>
                                        <?php endif; ?>
                                        <?php if($programa->registro_calidad): ?>
                                        <div class="col-md-4">
                                            <small class="text-muted d-block">Registro de Calidad</small>
                                            <strong><?php echo e($programa->registro_calidad); ?></strong>
                                        </div>
                                        <?php endif; ?>
                                    </div>
                                </div>

                                
                                <?php if($inscripcion->estaActiva()): ?>
                                <div class="mt-4 pt-3 border-top">
                                    <form method="POST" 
                                          action="<?php echo e(route('inscripcion.destroy', $inscripcion)); ?>"
                                          class="d-inline withdrawForm">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('DELETE'); ?>
                                        <button type="button" 
                                                class="btn btn-outline-danger btn-sm withdrawBtn"
                                                data-programa="<?php echo e($programa->nombre); ?>">
                                            <i class="bi bi-x-circle me-1"></i>
                                            Retirarme del Programa
                                        </button>
                                    </form>
                                </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php $__env->startPush('scripts'); ?>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const withdrawBtns = document.querySelectorAll('.withdrawBtn');
        
        withdrawBtns.forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                const form = this.closest('form');
                const programaNombre = this.getAttribute('data-programa');
                
                Swal.fire({
                    title: '¿Retirarme del programa?',
                    html: `
                        <p class="mb-3">Estás a punto de retirarte de:</p>
                        <strong class="text-danger">${programaNombre}</strong>
                        <br><br>
                        <p class="text-muted small mb-0">
                            <i class="bi bi-info-circle me-1"></i>
                            Podrás inscribirte nuevamente cuando lo desees
                        </p>
                    `,
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: '<i class="bi bi-check-circle me-1"></i> Sí, retirarme',
                    cancelButtonText: '<i class="bi bi-x-circle me-1"></i> Cancelar',
                    reverseButtons: true,
                    customClass: {
                        confirmButton: 'btn btn-danger btn-sm',
                        cancelButton: 'btn btn-secondary btn-sm'
                    },
                    buttonsStyling: false
                }).then((result) => {
                    if (result.isConfirmed) {
                        Swal.fire({
                            title: 'Procesando retiro...',
                            html: 'Por favor espera un momento',
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            didOpen: () => {
                                Swal.showLoading();
                            }
                        });
                        form.submit();
                    }
                });
            });
        });
    });
</script>
<?php $__env->stopPush(); ?>
<?php /**PATH C:\Users\Saave\Documents\project\SOES\SoeSoftware2\resources\views/components/profile/user-programs.blade.php ENDPATH**/ ?>