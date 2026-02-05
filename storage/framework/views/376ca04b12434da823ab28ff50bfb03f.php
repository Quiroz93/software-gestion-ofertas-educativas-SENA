<?php $__env->startSection('title', 'Consolidaciones de Preinscritos'); ?>

<?php $__env->startSection('content_header'); ?>
<div class="d-flex justify-content-between align-items-center">
    <h1 class="m-0">
        <i class="bi bi-layers text-primary"></i>
        Consolidaciones de Preinscritos
    </h1>
    <div>
        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('preinscritos.import')): ?>
        <a href="<?php echo e(route('preinscritos.consolidaciones.import')); ?>" class="btn btn-outline-success">
            <i class="bi bi-upload"></i>
            Importar Excel
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
    <div class="card card-outline card-primary mb-4">
        <div class="card-header">
            <h3 class="card-title">
                <i class="bi bi-funnel"></i>
                Filtros de búsqueda
            </h3>
        </div>
        <div class="card-body">
            <form method="GET" action="<?php echo e(route('preinscritos.consolidaciones.index')); ?>" class="row g-3">
                <div class="col-md-3">
                    <label class="form-label">Fecha desde</label>
                    <input type="date" name="fecha_desde" class="form-control" value="<?php echo e(request('fecha_desde')); ?>">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Fecha hasta</label>
                    <input type="date" name="fecha_hasta" class="form-control" value="<?php echo e(request('fecha_hasta')); ?>">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Usuario</label>
                    <select name="usuario_id" class="form-select">
                        <option value="">-- Todos --</option>
                        <?php $__currentLoopData = $usuarios; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $usuario): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($usuario->id); ?>" <?php echo e(request('usuario_id') == $usuario->id ? 'selected' : ''); ?>>
                                <?php echo e($usuario->name); ?>

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
            <table class="table table-striped align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Consolidación</th>
                        <th>Archivos</th>
                        <th>Registros</th>
                        <th>Descartados</th>
                        <th>Usuario</th>
                        <th>Fecha</th>
                        <th class="text-end">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $consolidaciones; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $consolidacion): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td>
                                <div class="fw-semibold"><?php echo e($consolidacion->nombre_consolidacion); ?></div>
                                <div class="text-muted small"><?php echo e($consolidacion->descripcion); ?></div>
                            </td>
                            <td><?php echo e($consolidacion->total_archivos); ?></td>
                            <td><?php echo e($consolidacion->total_registros); ?></td>
                            <td><?php echo e($consolidacion->total_descartados); ?></td>
                            <td><?php echo e($consolidacion->createdBy?->name ?? 'N/A'); ?></td>
                            <td><?php echo e($consolidacion->created_at->format('Y-m-d H:i')); ?></td>
                            <td class="text-end">
                                <a href="<?php echo e(route('preinscritos.consolidaciones.show', $consolidacion)); ?>" class="btn btn-sm btn-outline-primary">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <form action="<?php echo e(route('preinscritos.consolidaciones.destroy', $consolidacion)); ?>" method="POST" class="d-inline" onsubmit="confirmarEliminacion(event)">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('DELETE'); ?>
                                    <button type="submit" class="btn btn-sm btn-outline-danger">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="7" class="text-center text-muted">No hay consolidaciones registradas.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        <div class="card-footer">
            <?php echo e($consolidaciones->links()); ?>

        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\AdminSena\Documents\SoeSoftware2\resources\views/admin/preinscritos/consolidaciones/index.blade.php ENDPATH**/ ?>