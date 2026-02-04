<?php $__env->startSection('title', 'Programas'); ?>

<?php $__env->startSection('content_header'); ?>
<div class="d-flex justify-content-between align-items-center">
    <h1 class="m-0">
        <i class="fas fa-book text-primary"></i>
        Programas de formación
    </h1>

    <div>
        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('programas.create')): ?>
        <a href="<?php echo e(route('programas.create')); ?>" class="btn btn-outline-success">
            <i class="fas fa-plus-circle"></i>
            Crear programa
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

<?php if($programas->isEmpty()): ?>
<div class="alert alert-info">
    <i class="fas fa-info-circle"></i>
    No existen programas registrados.
</div>
<?php endif; ?>

<div class="row">
    <?php $__currentLoopData = $programas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $programa): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <div class="col-md-6 col-lg-4">
        <div class="card card-outline card-primary shadow-sm h-100">

            
            <div class="card-header">
                <h3 class="card-title text-uppercase fw-bold">
                    <?php echo e($programa->nombre); ?>

                </h3>
            </div>

                
            <div class="card-body">
                <p class="mb-2">
                    <strong>Descripción:</strong><br>
                    <small><?php echo e(Str::limit($programa->descripcion ?? 'Sin descripción', 100)); ?></small>
                </p>

                <div class="row mb-2">
                    <div class="col-6">
                        <strong>Duración:</strong><br>
                        <span class="badge bg-info">
                            <?php echo e($programa->duracion_meses ? $programa->duracion_meses . ' meses' : 'N/A'); ?>

                        </span>
                    </div>
                    <div class="col-6">
                        <strong>Cupos:</strong><br>
                        <span class="badge bg-secondary">
                            <?php echo e($programa->cupos ?? 'N/A'); ?>

                        </span>
                    </div>
                </div>

                <p class="mb-2">
                    <strong>Modalidad:</strong>
                    <span class="badge bg-primary">
                        <?php echo e($programa->modalidad ?? 'N/A'); ?>

                    </span>
                </p>

                <p class="mb-2">
                    <strong>Jornada:</strong>
                    <span class="badge bg-primary">
                        <?php echo e($programa->jornada ?? 'N/A'); ?>

                    </span>
                </p>

                <p class="mb-2">
                    <strong>Estado:</strong>
                    <span class="badge bg-success">
                        <?php echo e($programa->estado ?? 'N/A'); ?>

                    </span>
                </p>

                <p class="mb-2">
                    <strong>Red de Conocimiento:</strong><br>
                    <span class="badge bg-info">
                        <?php echo e($programa->red->nombre ?? 'N/A'); ?>

                    </span>
                </p>

                <p class="mb-2">
                    <strong>Nivel de Formación:</strong><br>
                    <span class="badge bg-warning">
                        <?php echo e($programa->nivelFormacion->nombre ?? 'N/A'); ?>

                    </span>
                </p>

                <p class="mb-0">
                    <strong>Centro:</strong><br>
                    <span class="badge bg-dark">
                        <?php echo e($programa->centro->nombre ?? 'No asignado'); ?>

                    </span>
                </p>
            </div>

            
            <div class="card-footer d-flex justify-content-between">

                <div class="d-flex gap-1">
                    <a href="<?php echo e(route('programas.show', $programa)); ?>" class="btn btn-sm btn-outline-primary">
                        <i class="fas fa-eye"></i>
                        Ver
                    </a>

                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('programas.edit')): ?>
                        <a href="<?php echo e(route('programas.edit', $programa)); ?>" class="btn btn-sm btn-outline-warning">
                            <i class="fas fa-edit"></i>
                            Editar
                        </a>
                    <?php endif; ?>

                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('programas.delete')): ?>
                        <form action="<?php echo e(route('programas.destroy', $programa)); ?>"
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
    </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Saave\Documents\project\SOES\SoeSoftware2\resources\views/programas/index.blade.php ENDPATH**/ ?>