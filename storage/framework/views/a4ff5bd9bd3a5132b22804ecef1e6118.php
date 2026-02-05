<?php $__env->startSection('title', 'Crear Preinscrito'); ?>

<?php $__env->startSection('content_header'); ?>
<div class="d-flex justify-content-between align-items-center">
    <h1 class="m-0">
        <i class="fas fa-user-plus text-primary"></i>
        Crear Nuevo Preinscrito
    </h1>
    <a href="<?php echo e(route('preinscritos.index')); ?>" class="btn btn-outline-secondary">
        <i class="fas fa-arrow-left"></i>
        Volver
    </a>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-8 offset-lg-2">
            <div class="card card-outline card-primary">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-form"></i>
                        Formulario de Registro
                    </h3>
                </div>

                <form action="<?php echo e(route('preinscritos.store')); ?>" method="POST" id="formPresrito">
                    <?php echo csrf_field(); ?>

                    <div class="card-body">
                        <!-- Alertas de error -->
                        <?php if($errors->any()): ?>
                            <div class="alert alert-danger">
                                <strong>¡Error!</strong> Revisa los campos que contienen errores:
                                <ul class="mb-0">
                                    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <li><?php echo e($error); ?></li>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </ul>
                            </div>
                        <?php endif; ?>

                        <!-- Datos Personales -->
                        <h5 class="mb-3">
                            <i class="fas fa-user"></i>
                            Datos Personales
                        </h5>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="nombres" class="form-label">
                                    Nombres <span class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control <?php $__errorArgs = ['nombres'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                       id="nombres" name="nombres" value="<?php echo e(old('nombres')); ?>" 
                                       placeholder="Ej: Juan" required>
                                <?php $__errorArgs = ['nombres'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="invalid-feedback d-block"><?php echo e($message); ?></div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>

                            <div class="col-md-6">
                                <label for="apellidos" class="form-label">
                                    Apellidos <span class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control <?php $__errorArgs = ['apellidos'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                       id="apellidos" name="apellidos" value="<?php echo e(old('apellidos')); ?>" 
                                       placeholder="Ej: Pérez González" required>
                                <?php $__errorArgs = ['apellidos'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="invalid-feedback d-block"><?php echo e($message); ?></div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                        </div>

                        <!-- Documento de Identidad -->
                        <h5 class="mb-3">
                            <i class="fas fa-id-card"></i>
                            Documento de Identidad
                        </h5>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="tipo_documento" class="form-label">
                                    Tipo de Documento <span class="text-danger">*</span>
                                </label>
                                <select class="form-select <?php $__errorArgs = ['tipo_documento'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                        id="tipo_documento" name="tipo_documento" required>
                                    <option value="">-- Selecciona un tipo --</option>
                                    <?php $__currentLoopData = $tiposDocumento; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $valor => $etiqueta): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($valor); ?>" <?php echo e(old('tipo_documento') == $valor ? 'selected' : ''); ?>>
                                            <?php echo e($etiqueta); ?>

                                        </option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                                <?php $__errorArgs = ['tipo_documento'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="invalid-feedback d-block"><?php echo e($message); ?></div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>

                            <div class="col-md-6">
                                <label for="numero_documento" class="form-label">
                                    Número de Documento <span class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control <?php $__errorArgs = ['numero_documento'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                       id="numero_documento" name="numero_documento" value="<?php echo e(old('numero_documento')); ?>" 
                                       placeholder="Ej: 1234567890" required>
                                <?php $__errorArgs = ['numero_documento'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="invalid-feedback d-block"><?php echo e($message); ?></div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                        </div>

                        <!-- Información de Contacto -->
                        <h5 class="mb-3">
                            <i class="fas fa-phone"></i>
                            Información de Contacto
                        </h5>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="celular_principal" class="form-label">
                                    Celular Principal <span class="text-danger">*</span>
                                </label>
                                <input type="tel" class="form-control <?php $__errorArgs = ['celular_principal'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                       id="celular_principal" name="celular_principal" value="<?php echo e(old('celular_principal')); ?>" 
                                       placeholder="Ej: 3001234567" required>
                                <?php $__errorArgs = ['celular_principal'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="invalid-feedback d-block"><?php echo e($message); ?></div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>

                            <div class="col-md-6">
                                <label for="celular_alternativo" class="form-label">
                                    Celular Alternativo
                                </label>
                                <input type="tel" class="form-control <?php $__errorArgs = ['celular_alternativo'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                       id="celular_alternativo" name="celular_alternativo" value="<?php echo e(old('celular_alternativo')); ?>" 
                                       placeholder="Ej: 3187654321">
                                <?php $__errorArgs = ['celular_alternativo'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="invalid-feedback d-block"><?php echo e($message); ?></div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="correo_principal" class="form-label">
                                    Correo Principal <span class="text-danger">*</span>
                                </label>
                                <input type="email" class="form-control <?php $__errorArgs = ['correo_principal'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                       id="correo_principal" name="correo_principal" value="<?php echo e(old('correo_principal')); ?>" 
                                       placeholder="Ej: ejemplo@correo.com" required>
                                <?php $__errorArgs = ['correo_principal'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="invalid-feedback d-block"><?php echo e($message); ?></div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>

                            <div class="col-md-6">
                                <label for="correo_alternativo" class="form-label">
                                    Correo Alternativo
                                </label>
                                <input type="email" class="form-control <?php $__errorArgs = ['correo_alternativo'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                       id="correo_alternativo" name="correo_alternativo" value="<?php echo e(old('correo_alternativo')); ?>" 
                                       placeholder="Ej: alternativo@correo.com">
                                <?php $__errorArgs = ['correo_alternativo'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="invalid-feedback d-block"><?php echo e($message); ?></div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                        </div>

                        <!-- Información de Formación -->
                        <h5 class="mb-3">
                            <i class="fas fa-graduation-cap"></i>
                            Información de Formación
                        </h5>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="programa_id" class="form-label">
                                    Programa <span class="text-danger">*</span>
                                </label>
                                <select class="form-select <?php $__errorArgs = ['programa_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                        id="programa_id" name="programa_id" required>
                                    <option value="">-- Selecciona un programa --</option>
                                    <?php $__currentLoopData = $programas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $programa): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($programa->id); ?>" <?php echo e(old('programa_id') == $programa->id ? 'selected' : ''); ?>>
                                            <?php echo e($programa->nombre); ?> (<?php echo e($programa->numero_ficha); ?>)
                                        </option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                                <?php $__errorArgs = ['programa_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="invalid-feedback d-block"><?php echo e($message); ?></div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>

                            <div class="col-md-6">
                                <label for="estado" class="form-label">
                                    Estado <span class="text-danger">*</span>
                                </label>
                                <select class="form-select <?php $__errorArgs = ['estado'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                        id="estado" name="estado" required>
                                    <option value="">-- Selecciona un estado --</option>
                                    <?php $__currentLoopData = $estados; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $valor => $etiqueta): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($valor); ?>" <?php echo e(old('estado') == $valor ? 'selected' : ''); ?>>
                                            <?php echo e($etiqueta); ?>

                                        </option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                                <?php $__errorArgs = ['estado'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="invalid-feedback d-block"><?php echo e($message); ?></div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                        </div>

                        <!-- Información Adicional -->
                        <h5 class="mb-3">
                            <i class="fas fa-sticky-note"></i>
                            Información Adicional
                        </h5>

                        <div class="row mb-3">
                            <div class="col-12">
                                <label for="comentarios" class="form-label">
                                    Comentarios
                                </label>
                                <textarea class="form-control <?php $__errorArgs = ['comentarios'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                          id="comentarios" name="comentarios" rows="4" 
                                          placeholder="Agrega comentarios o notas adicionales..."><?php echo e(old('comentarios')); ?></textarea>
                                <?php $__errorArgs = ['comentarios'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="invalid-feedback d-block"><?php echo e($message); ?></div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                        </div>

                        <!-- Sección de Novedad (Opcional) -->
                        <hr class="my-4">
                        <h5 class="mb-3">
                            <i class="fas fa-exclamation-triangle text-warning"></i>
                            Registrar Novedad (Opcional)
                        </h5>
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle"></i>
                            <strong>Nota:</strong> Si el preinscrito requiere una novedad desde el inicio, completa esta sección. Esto es independiente del estado del preinscrito.
                        </div>

                        <div class="row mb-3">
                            <div class="col-12">
                                <div class="form-check form-switch mb-3">
                                    <input class="form-check-input" type="checkbox" id="tiene_novedad" name="tiene_novedad" 
                                           value="1" <?php echo e(old('tiene_novedad') ? 'checked' : ''); ?>

                                           onchange="toggleNovedadFields()">
                                    <label class="form-check-label" for="tiene_novedad">
                                        <strong>Este preinscrito tiene una novedad</strong>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div id="novedad_fields" style="display: '<?php echo e(old('tiene_novedad') ? 'block' : 'none'); ?>';"></div>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="tipo_novedad_id" class="form-label">
                                        Tipo de Novedad
                                    </label>
                                    <select class="form-select <?php $__errorArgs = ['tipo_novedad_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                            id="tipo_novedad_id" name="tipo_novedad_id">
                                        <option value="">-- Selecciona un tipo (opcional) --</option>
                                        <?php $__currentLoopData = $tiposNovedades; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $tipo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <?php
                                                $tipoId = is_object($tipo) ? $tipo->id : $key;
                                                $tipoNombre = is_object($tipo) ? $tipo->nombre : $tipo;
                                            ?>
                                            <option value="<?php echo e($tipoId); ?>" <?php echo e(old('tipo_novedad_id') == $tipoId ? 'selected' : ''); ?>>
                                                <?php echo e($tipoNombre); ?>

                                            </option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                    <?php $__errorArgs = ['tipo_novedad_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="invalid-feedback d-block"><?php echo e($message); ?></div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>

                                <div class="col-md-6">
                                    <label for="novedad_estado" class="form-label">
                                        Estado de la Novedad <span class="text-danger">*</span>
                                    </label>
                                    <select class="form-select <?php $__errorArgs = ['novedad_estado'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                            id="novedad_estado" name="novedad_estado">
                                        <option value="">-- Selecciona un estado --</option>
                                        <option value="abierta" <?php echo e(old('novedad_estado') == 'abierta' ? 'selected' : ''); ?>>Abierta</option>
                                        <option value="en_gestion" <?php echo e(old('novedad_estado') == 'en_gestion' ? 'selected' : ''); ?>>En Gestión</option>
                                        <option value="resuelta" <?php echo e(old('novedad_estado') == 'resuelta' ? 'selected' : ''); ?>>Resuelta</option>
                                        <option value="cancelada" <?php echo e(old('novedad_estado') == 'cancelada' ? 'selected' : ''); ?>>Cancelada</option>
                                    </select>
                                    <?php $__errorArgs = ['novedad_estado'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="invalid-feedback d-block"><?php echo e($message); ?></div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-12">
                                    <label for="novedad_descripcion" class="form-label">
                                        Descripción de la Novedad <span class="text-danger">*</span>
                                    </label>
                                    <textarea class="form-control <?php $__errorArgs = ['novedad_descripcion'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                              id="novedad_descripcion" name="novedad_descripcion" rows="4" 
                                              placeholder="Describe la novedad o situación especial del preinscrito..."><?php echo e(old('novedad_descripcion')); ?></textarea>
                                    <?php $__errorArgs = ['novedad_descripcion'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="invalid-feedback d-block"><?php echo e($message); ?></div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    <small class="text-muted">Este campo es requerido cuando se marca que el preinscrito tiene novedad.</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer">
                        <button type="submit" class="btn btn-outline-primary">
                            <i class="fas fa-save"></i>
                            Guardar Preinscrito
                        </button>
                        <a href="<?php echo e(route('preinscritos.index')); ?>" class="btn btn-outline-secondary">
                            <i class="fas fa-times"></i>
                            Cancelar
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    // Mostrar/ocultar campos de novedad
    function toggleNovedadFields() {
        const checkbox = document.getElementById('tiene_novedad');
        const fields = document.getElementById('novedad_fields');
        const estado = document.getElementById('novedad_estado');
        const descripcion = document.getElementById('novedad_descripcion');
        
        if (checkbox.checked) {
            fields.style.display = 'block';
            estado.required = true;
            descripcion.required = true;
        } else {
            fields.style.display = 'none';
            estado.required = false;
            descripcion.required = false;
            estado.value = '';
            descripcion.value = '';
            document.getElementById('tipo_novedad_id').value = '';
        }
    }

    // Validación de formulario
    document.getElementById('formPresrito').addEventListener('submit', function(e) {
        const numeroDocumento = document.getElementById('numero_documento').value;
        if (!numeroDocumento || numeroDocumento.length < 5) {
            e.preventDefault();
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'El número de documento debe tener al menos 5 caracteres.'
            });
            return false;
        }

        // Validar campos de novedad si está marcado
        const tieneNovedad = document.getElementById('tiene_novedad').checked;
        if (tieneNovedad) {
            const estadoNovedad = document.getElementById('novedad_estado').value;
            const descripcionNovedad = document.getElementById('novedad_descripcion').value;
            
            if (!estadoNovedad || !descripcionNovedad) {
                e.preventDefault();
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Debes completar el estado y descripción de la novedad.'
                });
                return false;
            }
        }
    });

    // Inicializar estado de campos al cargar
    document.addEventListener('DOMContentLoaded', function() {
        toggleNovedadFields();
    });
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\AdminSena\Documents\SoeSoftware2\resources\views/admin/preinscritos/create.blade.php ENDPATH**/ ?>