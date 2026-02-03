

<?php $__env->startSection('title', 'Gestión de Novedades'); ?>

<?php $__env->startSection('content_header'); ?>
<div class="d-flex justify-content-between align-items-center">
    <h1 class="m-0">
        <i class="bi bi-exclamation-triangle text-primary"></i>
        Gestión de Novedades
    </h1>
    <div>
        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('preinscritos.novedades.admin')): ?>
        <a href="<?php echo e(route('novedades.create')); ?>" class="btn btn-outline-success">
            <i class="bi bi-plus-circle"></i>
            Nueva Novedad
        </a>
        <a href="<?php echo e(route('tipos-novedad.index')); ?>" class="btn btn-outline-info">
            <i class="bi bi-tags"></i>
            Tipos
        </a>
        <?php endif; ?>
        <a href="<?php echo e(route('dashboard')); ?>" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left"></i>
            Volver
        </a>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <?php if(session('success')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle me-2"></i>
            <?php echo e(session('success')); ?>

            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <div class="card card-outline card-primary mb-4">
        <div class="card-header">
            <h3 class="card-title">
                <i class="bi bi-funnel"></i>
                Filtros
            </h3>
        </div>
        <div class="card-body">
            <form method="GET" action="<?php echo e(route('novedades.index')); ?>" class="row g-3">
                <div class="col-md-4">
                    <label class="form-label">Buscar Preinscrito</label>
                    <input type="text" name="search" class="form-control" 
                           value="<?php echo e(request('search')); ?>" placeholder="Nombre o documento...">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Tipo de Novedad</label>
                    <select name="tipo_novedad_id" class="form-select">
                        <option value="">-- Todos --</option>
                        <?php $__currentLoopData = $tiposNovedad; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tipo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($tipo->id); ?>" <?php echo e(request('tipo_novedad_id') == $tipo->id ? 'selected' : ''); ?>>
                                <?php echo e($tipo->nombre); ?>

                            </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Estado</label>
                    <select name="estado" class="form-select">
                        <option value="">-- Todos --</option>
                        <?php $__currentLoopData = $estados; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $valor => $etiqueta): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($valor); ?>" <?php echo e(request('estado') == $valor ? 'selected' : ''); ?>>
                                <?php echo e($etiqueta); ?>

                            </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                <div class="col-md-2 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-search"></i>
                        Filtrar
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-body table-responsive">
            <?php if($novedades->count() > 0): ?>
                <table class="table table-striped table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Preinscrito</th>
                            <th>Documento</th>
                            <th>Tipo</th>
                            <th>Estado</th>
                            <th>Creado por</th>
                            <th>Fecha</th>
                            <th class="text-end">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $novedades; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $novedad): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td>
                                    <strong><?php echo e($novedad->preinscrito->nombre_completo); ?></strong><br>
                                    <small class="text-muted"><?php echo e($novedad->preinscrito->programa->nombre ?? 'Sin asignar'); ?></small>
                                </td>
                                <td>
                                    <span class="badge bg-light text-dark">
                                        <?php echo e(strtoupper($novedad->preinscrito->tipo_documento)); ?>-<?php echo e($novedad->preinscrito->numero_documento); ?>

                                    </span>
                                </td>
                                <td>
                                    <?php if($novedad->tipoNovedad): ?>
                                        <span class="badge bg-secondary"><?php echo e($novedad->tipoNovedad->nombre); ?></span>
                                    <?php else: ?>
                                        <span class="badge bg-light text-dark">Sin tipo</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php
                                        $colorEstado = match($novedad->estado) {
                                            'abierta' => 'danger',
                                            'en_gestion' => 'warning',
                                            'resuelta' => 'success',
                                            'cancelada' => 'secondary',
                                            default => 'light',
                                        };
                                    ?>
                                    <span class="badge bg-<?php echo e($colorEstado); ?>"><?php echo e($novedad->etiqueta_estado); ?></span>
                                </td>
                                <td>
                                    <small><?php echo e($novedad->createdBy->name ?? 'Sistema'); ?></small>
                                </td>
                                <td>
                                    <small class="text-muted"><?php echo e($novedad->created_at->format('d/m/Y H:i')); ?></small>
                                </td>
                                <td class="text-end">
                                    <a href="<?php echo e(route('novedades.show', $novedad)); ?>" 
                                       class="btn btn-outline-info btn-sm" title="Ver">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="<?php echo e(route('novedades.edit', $novedad)); ?>" 
                                       class="btn btn-outline-warning btn-sm" title="Editar">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="<?php echo e(route('novedades.destroy', $novedad)); ?>" 
                                          method="POST" style="display: inline;" 
                                          onsubmit="return confirmarEliminacion(event)">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('DELETE'); ?>
                                        <button type="submit" class="btn btn-outline-danger btn-sm" title="Eliminar">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            <?php else: ?>
                <div class="text-center py-5">
                    <i class="bi bi-inbox" style="font-size: 3rem; color: #ccc;"></i>
                    <p class="text-muted mt-3">No hay novedades registradas</p>
                </div>
            <?php endif; ?>
        </div>
        <?php if($novedades->hasPages()): ?>
            <div class="card-footer">
                <?php echo e($novedades->links()); ?>

            </div>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\AdminSena\Documents\SoeSoftware2\resources\views/admin/novedades/index.blade.php ENDPATH**/ ?>