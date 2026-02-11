<?php $__env->startSection('title', 'Preinscritos'); ?>

<?php $__env->startSection('content_header'); ?>
<div class="d-flex justify-content-between align-items-center">
    <h1 class="m-0">
        <i class="fas fa-clipboard-list text-primary"></i>
        Gestión de Preinscritos
    </h1>

    <div>
        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('preinscritos.create')): ?>
            <a href="<?php echo e(route('preinscritos.create')); ?>" class="btn btn-outline-success">
                <i class="fas fa-plus-circle"></i>
                Nuevo Preinscrito
            </a>
        <?php endif; ?>
        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('preinscritos.consolidaciones.admin')): ?>
            <a href="<?php echo e(route('preinscritos.consolidaciones.index')); ?>" class="btn btn-outline-primary">
                <i class="bi bi-layers"></i>
                Consolidaciones
            </a>
        <?php endif; ?>
        <a href="<?php echo e(route('dashboard')); ?>" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left"></i>
            Volver
        </a>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <?php if(session('success')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle"></i>
            <?php echo e(session('success')); ?>

            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <?php if(session('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle"></i>
            <?php echo e(session('error')); ?>

            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <!-- Filtros -->
    <div class="card card-outline card-primary mb-4">
        <div class="card-header">
            <h3 class="card-title">
                <i class="fas fa-filter"></i>
                Filtros de Búsqueda
            </h3>
        </div>
        <div class="card-body">
            <form method="GET" action="<?php echo e(route('preinscritos.index')); ?>" class="row g-3">
                <div class="col-md-3">
                    <label for="programa_id" class="form-label">Programa</label>
                    <select class="form-select form-select-sm" id="programa_id" name="programa_id">
                        <option value="">-- Todos los programas --</option>
                        <?php $__currentLoopData = $programas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $programa): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($programa->id); ?>" <?php echo e(request('programa_id') == $programa->id ? 'selected' : ''); ?>>
                                <?php echo e($programa->nombre); ?>

                            </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>

                <div class="col-md-3">
                    <label for="estado" class="form-label">Estado</label>
                    <select class="form-select form-select-sm" id="estado" name="estado">
                        <option value="">-- Todos los estados --</option>
                        <?php $__currentLoopData = $estados; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $valor => $etiqueta): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($valor); ?>" <?php echo e(request('estado') == $valor ? 'selected' : ''); ?>>
                                <?php echo e($etiqueta); ?>

                            </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>

                <div class="col-md-3">
                    <label for="tipo_documento" class="form-label">Tipo de Documento</label>
                    <select class="form-select form-select-sm" id="tipo_documento" name="tipo_documento">
                        <option value="">-- Todos --</option>
                        <?php $__currentLoopData = $tiposDocumento; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $valor => $etiqueta): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($valor); ?>" <?php echo e(request('tipo_documento') == $valor ? 'selected' : ''); ?>>
                                <?php echo e($etiqueta); ?>

                            </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>

                <div class="col-md-3">
                    <label for="numero_documento" class="form-label">Nº de Documento</label>
                    <input type="text" class="form-control form-control-sm" id="numero_documento" name="numero_documento" 
                           value="<?php echo e(request('numero_documento')); ?>" placeholder="Buscar...">
                </div>

                <div class="col-md-3">
                    <label for="tipo_novedad" class="form-label">Tipo de Novedad</label>
                    <select class="form-select form-select-sm" id="tipo_novedad" name="tipo_novedad">
                        <option value="">-- Todos los tipos --</option>
                        <?php $__currentLoopData = $tiposNovedades; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $valor => $etiqueta): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($valor); ?>" <?php echo e(request('tipo_novedad') == $valor ? 'selected' : ''); ?>>
                                <?php echo e($etiqueta); ?>

                            </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>

                <div class="col-md-3">
                    <label for="novedad_resuelta" class="form-label">Estado de Novedad</label>
                    <select class="form-select form-select-sm" id="novedad_resuelta" name="novedad_resuelta">
                        <option value="">-- Todos --</option>
                        <option value="pendiente" <?php echo e(request('novedad_resuelta') == 'pendiente' ? 'selected' : ''); ?>>
                            Pendientes
                        </option>
                        <option value="resuelta" <?php echo e(request('novedad_resuelta') == 'resuelta' ? 'selected' : ''); ?>>
                            Resueltas
                        </option>
                    </select>
                </div>

                <div class="col-12">
                    <button type="submit" class="btn btn-outline-primary btn-sm">
                        <i class="fas fa-search"></i> Buscar
                    </button>
                    <a href="<?php echo e(route('preinscritos.index')); ?>" class="btn btn-outline-secondary btn-sm">
                        <i class="fas fa-redo"></i> Limpiar
                    </a>
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('preinscritos.view')): ?>
                        <a href="<?php echo e(route('preinscritos.reportes')); ?>" class="btn btn-outline-info btn-sm">
                            <i class="fas fa-chart-bar"></i> Reportes
                        </a>
                    <?php endif; ?>
                </div>
            </form>
        </div>
    </div>

    <!-- Tabla de Preinscritos -->
    <?php if($preinscritos->count() > 0): ?>
        <div class="card card-outline card-primary">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-list"></i>
                    Listado de Preinscritos (<?php echo e($preinscritos->total()); ?>)
                </h3>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead class="table-primary">
                            <tr>
                                <th style="width: 15%">Nombre Completo</th>
                                <th style="width: 12%">Documento</th>
                                <th style="width: 15%">Correo Principal</th>
                                <th style="width: 12%">Celular</th>
                                <th style="width: 20%">Programa</th>
                                <th style="width: 10%">Estado</th>
                                <th style="width: 12%">Novedad</th>
                                <th style="width: 16%">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $preinscritos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $presrito): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td>
                                        <strong><?php echo e($presrito->nombre_completo); ?></strong>
                                    </td>
                                    <td>
                                        <span class="badge bg-light text-dark">
                                            <?php echo e(strtoupper($presrito->tipo_documento)); ?>-<?php echo e($presrito->numero_documento); ?>

                                        </span>
                                    </td>
                                    <td>
                                        <a href="mailto:<?php echo e($presrito->correo_principal); ?>">
                                            <?php echo e($presrito->correo_principal); ?>

                                        </a>
                                    </td>
                                    <td>
                                        <a href="tel:<?php echo e($presrito->celular_principal); ?>">
                                            <?php echo e($presrito->celular_principal); ?>

                                        </a>
                                    </td>
                                    <td>
                                        <small class="d-block text-muted">
                                            <?php echo e($presrito->programa->nombre ?? 'Sin asignar'); ?><br>
                                            <em>(<?php echo e($presrito->programa->numero_ficha ?? 'N/A'); ?>)</em>
                                        </small>
                                    </td>
                                    <td>
                                        <span class="badge bg-<?php echo e($presrito->estado === 'inscrito' ? 'success' : ($presrito->estado === 'por_inscribir' ? 'warning' : 'danger')); ?>">
                                            <?php echo e($presrito->etiqueta_estado); ?>

                                        </span>
                                    </td>
                                    <td>
                                        <?php if($presrito->estado === 'con_novedad'): ?>
                                            <?php if($presrito->novedad_resuelta): ?>
                                                <span class="badge bg-success" title="<?php echo e($presrito->tipo_novedad ? $presrito->etiqueta_tipo_novedad : 'Novedad resuelta'); ?>">
                                                    <i class="fas fa-check-circle"></i> Resuelta
                                                </span>
                                            <?php else: ?>
                                                <span class="badge bg-danger" title="<?php echo e($presrito->tipo_novedad ? $presrito->etiqueta_tipo_novedad : 'Novedad pendiente'); ?>">
                                                    <i class="fas fa-exclamation-triangle"></i> Pendiente
                                                </span>
                                            <?php endif; ?>
                                        <?php else: ?>
                                            <span class="badge bg-light text-dark">N/A</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('preinscritos.view')): ?>
                                            <a href="<?php echo e(route('preinscritos.show', $presrito->id)); ?>" class="btn btn-outline-info btn-sm" title="Ver">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                        <?php endif; ?>
                                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('preinscritos.edit')): ?>
                                            <a href="<?php echo e(route('preinscritos.edit', $presrito->id)); ?>" class="btn btn-outline-warning btn-sm" title="Editar">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                        <?php endif; ?>
                                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('preinscritos.delete')): ?>
                                            <form action="<?php echo e(route('preinscritos.destroy', $presrito->id)); ?>" 
                                                  method="POST" 
                                                  style="display: inline-block;"
                                                  onsubmit="return confirmarEliminacion(event)">
                                                <?php echo csrf_field(); ?>
                                                <?php echo method_field('DELETE'); ?>
                                                <button type="submit" class="btn btn-outline-danger btn-sm" title="Eliminar">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer">
                <?php echo e($preinscritos->links()); ?>

            </div>
        </div>
    <?php else: ?>
        <div class="alert alert-info">
            <i class="fas fa-info-circle"></i>
            No hay preinscritos registrados.
        </div>
    <?php endif; ?>
</div>

<script>
    function confirmarEliminacion(event) {
        event.preventDefault();
        
        Swal.fire({
            title: '¿Estás seguro?',
            text: '¿Deseas eliminar este preinscrito? Se eliminará de forma temporal.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                event.target.submit();
            }
        });
        
        return false;
    }
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Saave\Documents\project\SOES\SoeSoftware2\resources\views/admin/preinscritos/index.blade.php ENDPATH**/ ?>