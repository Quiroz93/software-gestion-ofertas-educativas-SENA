<?php $__env->startSection('title', 'Redes'); ?>

<?php $__env->startSection('content_header'); ?>
<div class="d-flex justify-content-between align-items-center">
    <h1 class="m-0">
        <i class="fas fa-network-wired text-primary"></i>
        Gestión de redes
    </h1>
    <div>
        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('programas.create')): ?>
        <a href="<?php echo e(route('redes_conocimiento.create')); ?>" class="btn btn-outline-success">
            <i class="fas fa-plus-circle"></i>
            Nueva red de conocimiento
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

<?php if($redes->isEmpty()): ?>
<div class="alert alert-info">
    <i class="fas fa-info-circle"></i>
    No existen redes registradas.
</div>
<?php endif; ?>

<div class="row">
    <?php $__currentLoopData = $redes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $red): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <div class="col-md-6 col-lg-4 mb-4 mt-2">
        <div class="card card-outline card-primary shadow-sm h-100">

            
            <div class="card-header">
                <h3 class="card-title fw-bold text-uppercase">
                    <?php echo e($red->nombre); ?>

                </h3>
            </div>

            
            <div class="card-body">
                <p class="mb-0">
                    <strong>Descripción:</strong><br>
                    <span class="badge bg-light text-sena-dark border">
                        <?php echo e($red->descripcion); ?>

                    </span>
                </p>
            </div>

            
            <div class="card-footer d-flex justify-content-between">

                <div>
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('redes_conocimiento.edit')): ?>
                    <a href="" class="btn btn-sm btn-outline-warning">
                        <i class="fas fa-edit"></i>
                        Editar
                    </a>
                    <?php endif; ?>
                </div>

                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('redes_conocimiento.delete')): ?>
                <form action=""
                    method="POST"
                    onsubmit="return confirmarEliminacion(event)">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('DELETE'); ?>

                    <button type="submit" class="btn btn-sm btn-outline-danger">
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

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\AdminSena\Documents\SoeSoftware2\resources\views/admin/redes/index.blade.php ENDPATH**/ ?>