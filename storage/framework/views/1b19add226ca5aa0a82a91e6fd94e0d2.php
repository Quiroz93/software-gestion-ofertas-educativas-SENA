<?php $__env->startSection('title', 'Competencias'); ?>

<?php $__env->startSection('content_header'); ?>
<div class="d-flex justify-content-between align-items-center">
    <h1 class="m-0">
        <i class="fas fa-trophy text-primary"></i>
        Gestión de Competencias
    </h1>

    <div>
        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('competencias.create')): ?>
            <a href="<?php echo e(route('competencias.create')); ?>" class="btn btn-outline-success">
                <i class="fas fa-plus-circle"></i>
                Agregar competencia
            </a>
        <?php endif; ?>
        <a href="<?php echo e(route('competencias.index')); ?>" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left"></i>
            Volver
        </a>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

<?php if($competencias->isEmpty()): ?>
    <div class="alert alert-info">
        <i class="fas fa-info-circle"></i>
        No existen competencias registradas.
    </div>
<?php endif; ?>

<div class="row">
    <?php $__currentLoopData = $competencias; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $competencia): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="col-md-6 col-lg-4">
            <div class="card card-outline card-primary shadow-sm h-100">

                
                <div class="card-header">
                    <h3 class="card-title fw-bold text-uppercase">
                        <?php echo e($competencia->nombre); ?>

                    </h3>
                </div>

                
                <div class="card-body">
                    <p class="mb-0">
                        <strong>Descripción:</strong><br>
                        <?php echo e($competencia->descripcion); ?>

                    </p>
                </div>

                
                <div class="card-footer d-flex justify-content-between">

                    <div>
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('competencias.view')): ?>
                            <a href="<?php echo e(route('competencias.show', $competencia->id)); ?>"
                               class="btn btn-sm btn-outline-info">
                                <i class="fas fa-eye"></i>
                                Ver
                            </a>
                        <?php endif; ?>

                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('competencias.edit')): ?>
                            <a href="<?php echo e(route('competencias.edit', $competencia->id)); ?>"
                               class="btn btn-sm btn-outline-warning">
                                <i class="fas fa-edit"></i>
                                Editar
                            </a>
                        <?php endif; ?>
                    </div>

                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('competencias.delete')): ?>
                        <form action="<?php echo e(route('competencias.destroy', $competencia->id)); ?>"
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

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Saave\Documents\project\SOES\SoeSoftware2\resources\views/competencias/index.blade.php ENDPATH**/ ?>