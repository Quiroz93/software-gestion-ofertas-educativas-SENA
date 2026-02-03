

<?php $__env->startSection('title', 'Tipos de Novedad'); ?>

<?php $__env->startSection('content_header'); ?>
<div class="d-flex justify-content-between align-items-center">
    <h1 class="m-0">
        <i class="bi bi-tags text-primary"></i>
        Gestión de Tipos de Novedad
    </h1>
    <div>
        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('novedad.tipos.admin')): ?>
        <a href="<?php echo e(route('tipos-novedad.create')); ?>" class="btn btn-outline-success">
            <i class="bi bi-plus-circle"></i>
            Crear Tipo
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
            <form method="GET" action="<?php echo e(route('tipos-novedad.index')); ?>" class="row g-3">
                <div class="col-md-8">
                    <label class="form-label">Buscar</label>
                    <input type="text" name="search" class="form-control" 
                           value="<?php echo e(request('search')); ?>" placeholder="Nombre o descripción...">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Estado</label>
                    <select name="activo" class="form-select">
                        <option value="">-- Todos --</option>
                        <option value="1" <?php echo e(request('activo') === '1' ? 'selected' : ''); ?>>Activos</option>
                        <option value="0" <?php echo e(request('activo') === '0' ? 'selected' : ''); ?>>Inactivos</option>
                    </select>
                </div>
                <div class="col-md-1 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-search"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-body table-responsive">
            <?php if($tiposNovedad->count() > 0): ?>
                <table class="table table-striped table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Nombre</th>
                            <th>Descripción</th>
                            <th>Novedades</th>
                            <th>Estado</th>
                            <th class="text-end">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $tiposNovedad; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tipo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td>
                                    <strong><?php echo e($tipo->nombre); ?></strong>
                                </td>
                                <td>
                                    <small class="text-muted"><?php echo e($tipo->descripcion ?? 'Sin descripción'); ?></small>
                                </td>
                                <td>
                                    <span class="badge bg-info"><?php echo e($tipo->novedades_count ?? 0); ?></span>
                                </td>
                                <td>
                                    <?php if($tipo->activo): ?>
                                        <span class="badge bg-success">Activo</span>
                                    <?php else: ?>
                                        <span class="badge bg-secondary">Inactivo</span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-end">
                                    <a href="<?php echo e(route('tipos-novedad.edit', $tipo)); ?>" 
                                       class="btn btn-outline-warning btn-sm" title="Editar">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="<?php echo e(route('tipos-novedad.destroy', $tipo)); ?>" 
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
                    <p class="text-muted mt-3">No hay tipos de novedad registrados</p>
                </div>
            <?php endif; ?>
        </div>
        <?php if($tiposNovedad->hasPages()): ?>
            <div class="card-footer">
                <?php echo e($tiposNovedad->links()); ?>

            </div>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\AdminSena\Documents\SoeSoftware2\resources\views/admin/novedades/tipos/index.blade.php ENDPATH**/ ?>