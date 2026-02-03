<?php $__env->startSection('title', 'Panel de control'); ?>

<?php $__env->startSection('content_header'); ?> <h1 class="m-0">Panel de Administración</h1>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

<?php if (\Illuminate\Support\Facades\Blade::check('hasanyrole', 'admin | SuperAdmin')): ?>

<div class="alert alert-info alert-dismissible mb-3">
    <strong>
        <?php echo e(__('Bienvenido, :name', ['name' => auth()->user()->name])); ?>

    </strong>
    <div class="small">
        <?php echo e(__('Acceso administrativo')); ?>

    </div>
</div>
<?php endif; ?>

<div class="container-fluid">
    <div class="row">

    
    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('centros.view')): ?>
    <div class="col-md-4 mt-4">
        <div class="card text-center shadow-sm">
            <div class="card-header">
                <i class="fas fa-school fa-3x"></i>
            </div>
            <div class="card-body">
                <h5 class="card-title">Centros Educativos</h5>
                <a href="<?php echo e(route('centros.index')); ?>" class="btn btn-outline-primary btn-sm mt-3">
                    Ver centros educativos
                </a>
            </div>
        </div>
    </div>
    <?php endif; ?>

    
    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('users.view')): ?>
    <div class="col-md-4 mt-4">
        <div class="card text-center shadow-sm">
            <div class="card-header">
                <i class="fas fa-users fa-3x"></i>
            </div>
            <div class="card-body">
                <h5 class="card-title">Usuarios</h5>
                <a href="<?php echo e(route('users.index')); ?>" class="btn btn-outline-secondary btn-sm mt-3">
                    Ver usuarios
                </a>
            </div>
        </div>
    </div>
    <?php endif; ?>

    
    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('roles.view')): ?>
    <div class="col-md-4 mt-4">
        <div class="card text-center shadow-sm">
            <div class="card-header">
                <i class="fas fa-user-tag fa-3x"></i>
            </div>
            <div class="card-body">
                <h5 class="card-title">Roles</h5>
                <a href="<?php echo e(route('roles.index')); ?>" class="btn btn-outline-info btn-sm mt-3">
                    Ver roles
                </a>
            </div>
        </div>
    </div>
    <?php endif; ?>

    
    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('permissions.view')): ?>
    <div class="col-md-4 mt-4">
        <div class="card text-center shadow-sm">
            <div class="card-header">
                <i class="fas fa-key fa-3x"></i>
            </div>
            <div class="card-body">
                <h5 class="card-title">Permisos</h5>
                <a href="<?php echo e(route('permissions.index')); ?>" class="btn btn-outline-success btn-sm mt-3">
                    Ver permisos
                </a>
            </div>
        </div>
    </div>
    <?php endif; ?>

    
    <div class="col-md-4 mt-4">
        <div class="card text-center shadow-sm">
            <div class="card-header">
                <i class="fas fa-cogs fa-3x"></i>
            </div>
            <div class="card-body">
                <h5 class="card-title">Configuración</h5>
                <a href="#" class="btn btn-outline-warning btn-sm mt-3">
                    Ajustes
                </a>
            </div>
        </div>
    </div>

    
    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('competencias.view')): ?>
    <div class="col-md-4 mt-4">
        <div class="card text-center shadow-sm">
            <div class="card-header">
                <i class="fas fa-trophy fa-3x"></i>
            </div>
            <div class="card-body">
                <h5 class="card-title">Competencias</h5>
                <a href="<?php echo e(route('competencias.index')); ?>" class="btn btn-outline-light btn-sm mt-3">
                    Ver competencias
                </a>
            </div>
        </div>
    </div>
    <?php endif; ?>

    
    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('historias_exito.view')): ?>
    <div class="col-md-4 mt-4">
        <div class="card text-center shadow-sm">
            <div class="card-header">
                <i class="fas fa-book-open fa-3x"></i>
            </div>
            <div class="card-body">
                <h5 class="card-title">Historias de Éxito</h5>
                <a href="<?php echo e(route('historias_de_exito.index')); ?>" class="btn btn-outline-secondary btn-sm mt-3">
                    Ver historias de éxito
                </a>
            </div>
        </div>
    </div>
    <?php endif; ?>

    
    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('instructores.view')): ?>
    <div class="col-md-4 mt-4">
        <div class="card text-center shadow-sm">
            <div class="card-header">
                <i class="fas fa-chalkboard-teacher fa-3x"></i>
            </div>
            <div class="card-body">
                <h5 class="card-title">Instructores</h5>
                <a href="<?php echo e(route('instructores.index')); ?>" class="btn btn-outline-primary btn-sm mt-3">
                    Ver instructores
                </a>
            </div>
        </div>
    </div>
    <?php endif; ?>

    
    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('niveles_formacion.view')): ?>
    <div class="col-md-4 mt-4">
        <div class="card text-center shadow-sm">
            <div class="card-header">
                <i class="bi bi-stack fa-3x"></i>
            </div>
            <div class="card-body">
                <h5 class="card-title">Niveles de Formación</h5>
                <a href="<?php echo e(route('niveles_formacion.index')); ?>" class="btn btn-outline-success btn-sm mt-3">
                    Ver niveles de formación
                </a>
            </div>
        </div>
    </div>
    <?php endif; ?>

    
    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('ofertas.view')): ?>
    <div class="col-md-4 mt-4">
        <div class="card text-center shadow-sm">
            <div class="card-header">
                <i class="fas fa-graduation-cap fa-3x"></i>
            </div>
            <div class="card-body">
                <h5 class="card-title">Ofertas</h5>
                <a href="<?php echo e(route('ofertas.index')); ?>" class="btn btn-outline-info btn-sm mt-3">
                    Ver ofertas
                </a>
            </div>
        </div>
    </div>
    <?php endif; ?>

    
    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('programas.view')): ?>
    <div class="col-md-4 mt-4">
        <div class="card text-center shadow-sm">
            <div class="card-header">
                <i class="fas fa-book fa-3x"></i>
            </div>
            <div class="card-body">
                <h5 class="card-title">Programas de formación</h5>
                <a href="<?php echo e(route('programas.index')); ?>" class="btn btn-outline-warning btn-sm mt-3">
                    Ver programas de formación
                </a>
            </div>
        </div>
    </div>
    <?php endif; ?>

    
    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('redes_conocimiento.view')): ?>
    <div class="col-md-4 mt-4">
        <div class="card text-center shadow-sm">
            <div class="card-header">
                <i class="fas fa-network-wired fa-3x"></i>
            </div>
            <div class="card-body">
                <h5 class="card-title">Redes</h5>
                <a href="<?php echo e(route('redes_conocimiento.index')); ?>" class="btn btn-outline-light btn-sm mt-3">
                    Ver redes
                </a>
            </div>
        </div>
    </div>
    <?php endif; ?>

    
    <div class="col-md-4 mt-4">
        <div class="card text-center shadow-sm">
            <div class="card-header">
                <i class="bi bi-images fa-3x text-sena"></i>
            </div>
            <div class="card-body">
                <h5 class="card-title">Carousel del Home</h5>
                <p class="text-muted small">Administra los slides del carousel institucional</p>
                <a href="<?php echo e(route('admin.home-carousel.index')); ?>" class="btn btn-sena btn-sm mt-3">
                    Gestionar carousel
                </a>
            </div>
        </div>
    </div>

</div>

</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\AdminSena\Documents\SoeSoftware2\resources\views/admin/dashboard.blade.php ENDPATH**/ ?>