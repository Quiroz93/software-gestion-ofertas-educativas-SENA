<?php $__env->startSection('title', 'Ofertas'); ?>

<?php $__env->startSection('content_header'); ?>
<div class="d-flex justify-content-between align-items-center">
    <h1 class="m-0">
        <i class="fas fa-graduation-cap text-primary"></i>
        Ofertas
    </h1>

    <div>
        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('ofertas.create')): ?>
    <a href="<?php echo e(route('ofertas.create')); ?>" class="btn btn-outline-success">
        <i class="fas fa-plus-circle"></i>
        Crear oferta
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

<?php if($ofertas->isEmpty()): ?>
<div class="alert alert-info">
    <i class="fas fa-info-circle"></i>
    No existen ofertas registradas.
</div>
<?php endif; ?>

<div class="row">
    <?php $__currentLoopData = $ofertas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $oferta): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <div class="col-md-6 col-lg-4">
        <div class="card card-outline card-primary shadow-sm h-100">

            
            <div class="card-header">
                <h3 class="card-title text-uppercase fw-bold">
                    <?php echo e($oferta->nombre); ?>

                </h3>
            </div>

            
            <div class="card-body">

                <p class="mb-2">
                    <strong>Año:</strong>
                    <span class="badge badge-secondary">
                        <?php echo e($oferta->año); ?>

                    </span>
                </p>

                <p class="mb-2">
                    <strong>Fecha inicio:</strong><br>
                    <?php echo e($oferta->fecha_inicio); ?>

                </p>

                <p class="mb-2">
                    <strong>Fecha final:</strong><br>
                    <?php echo e($oferta->fecha_final); ?>

                </p>

                <p class="mb-0">
                    <strong>Estado:</strong>
                    <span class="badge badge-info">
                        <?php echo e($oferta->estado); ?>

                    </span>
                </p>

            </div>

            
            <div class="card-footer d-flex justify-content-between">

                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('ofertas.edit')): ?>
                <a href="<?php echo e(route('ofertas.edit', $oferta)); ?>"
                   class="btn btn-sm btn-outline-warning">
                    <i class="fas fa-edit"></i>
                    Editar
                </a>
                <?php endif; ?>

                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('ofertas.delete')): ?>
                <form action="<?php echo e(route('ofertas.destroy', $oferta)); ?>"
                      method="POST"
                      onsubmit="return confirmarEliminacion(event)">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('DELETE'); ?>

                    <button type="submit"
                            class="btn btn-sm btn-outline-danger">
                        <i class="fas fa-trash"></i>
                        Eliminar
                    </button>
                </form>
                <?php endif; ?>

            </div>

        </div>
    </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Saave\Documents\project\SOES\SoeSoftware2\resources\views/ofertas/index.blade.php ENDPATH**/ ?>