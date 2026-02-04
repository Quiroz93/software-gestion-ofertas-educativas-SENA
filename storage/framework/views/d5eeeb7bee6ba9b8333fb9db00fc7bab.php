<?php $__env->startSection('title', 'Centros'); ?>

<?php $__env->startSection('content_header'); ?>

<div class="d-flex justify-content-between align-items-center">
    <h1 class="m-0">
        <i class="fas fa-school text-primary"></i>
        Gestión de Centros
    </h1>

    <div>
        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('centros.create')): ?>
            <a href="<?php echo e(route('centros.create')); ?>" class="btn btn-outline-success">
                <i class="fas fa-plus-circle"></i>
                Agregar centro
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

    <?php if($centros->count() > 0): ?>
    <div class="row">
        <?php $__currentLoopData = $centros; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $centro): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12">
            <div class="card card-outline card-primary h-100">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-building"></i>
                        <?php echo e($centro->nombre); ?>

                    </h3>
                </div>

                <div class="card-body">
                    <p class="mb-2">
                        <i class="fas fa-map-marker-alt text-muted"></i>
                        <strong>Dirección:</strong><br>
                        <span class="text-muted">
                            <?php echo e($centro->direccion ?? 'N/A'); ?>

                        </span>
                    </p>

                    <p class="mb-2">
                        <i class="fas fa-phone text-muted"></i>
                        <strong>Teléfono:</strong><br>
                        <span class="text-muted">
                            <?php echo e($centro->telefono ?? 'N/A'); ?>

                        </span>
                    </p>

                    <p class="mb-0">
                        <i class="fas fa-envelope text-muted"></i>
                        <strong>Correo:</strong><br>
                        <?php if($centro->correo): ?>
                        <a href="mailto:<?php echo e($centro->correo); ?>">
                            <?php echo e($centro->correo); ?>

                        </a>
                        <?php else: ?>
                        <span class="text-muted">N/A</span>
                        <?php endif; ?>
                    </p>
                </div>

                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['centros.edit','centros.update','centros.delete'])): ?>
                <div class="card-footer d-flex flex-wrap gap-2">
                    <div class="">
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['centros.edit','centros.update'])): ?>
                        <a href="<?php echo e(route('centros.edit', $centro->id)); ?>"
                            class="btn btn-outline-warning btn-sm min-width-100px">
                            <i class="fas fa-edit"></i> Editar
                        </a>
                    </div>
                    <?php endif; ?>

                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('centros.delete')): ?>
                    <form action="<?php echo e(route('centros.destroy', $centro->id)); ?>"
                        method="POST"
                        onsubmit="return confirmarEliminacion(event)">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('DELETE'); ?>
                        <button type="submit"
                            class="btn btn-outline-danger btn-sm min-width-100px">
                            <i class="fas fa-trash"></i> Eliminar
                        </button>
                    </form>
                    <?php endif; ?>
                </div>
                <?php endif; ?>
            </div>
        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>

    <div class="mt-3 text-muted">
        <i class="fas fa-database"></i>
        Total de centros: <strong><?php echo e($centros->count()); ?></strong>
    </div>

    <?php else: ?>
    <div class="alert alert-info">
        <i class="fas fa-info-circle"></i>
        No hay centros registrados.
        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('centros.create')): ?>
        <a href="<?php echo e(route('centros.create')); ?>" class="alert-link">
            Crear uno ahora
        </a>
        <?php endif; ?>
    </div>
    <?php endif; ?>

</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>
<?php echo \Illuminate\View\Factory::parentPlaceholder('js'); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Saave\Documents\project\SOES\SoeSoftware2\resources\views/centros/index.blade.php ENDPATH**/ ?>