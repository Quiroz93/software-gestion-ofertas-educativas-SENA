<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="container-fluid">
        <!-- Brand -->
        <?php if(auth()->guard()->check()): ?>
            <a class="navbar-brand" href="<?php echo e(route('dashboard')); ?>">
                <i class="bi bi-mortarboard-fill me-2"></i>
                <?php echo e(config('app.name', 'Laravel')); ?>

            </a>
        <?php else: ?>
            <a class="navbar-brand" href="<?php echo e(route('home')); ?>">
                <i class="bi bi-mortarboard-fill me-2"></i>
                <?php echo e(config('app.name', 'Laravel')); ?>

            </a>
        <?php endif; ?>

        <!-- Mobile Toggle -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" 
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Navigation Links -->
        <div class="collapse navbar-collapse" id="navbarNav">
            <!-- Left Side -->
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <?php if(auth()->guard()->check()): ?>
                        <a class="nav-link <?php echo e(request()->is('dashboard') ? 'active' : ''); ?>" href="<?php echo e(route('dashboard')); ?>">
                            <i class="bi bi-house-door me-1"></i>Inicio
                        </a>
                    <?php else: ?>
                        <a class="nav-link <?php echo e(request()->is('dashboard') ? 'active' : ''); ?>" href="<?php echo e(route('home')); ?>">
                            <i class="bi bi-house-door me-1"></i>Inicio
                        </a>|
                    <?php endif; ?>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo e(request()->is('programasDeFormacion*') ? 'active' : ''); ?>" href="<?php echo e(route('public.programasDeFormacion.index')); ?>">
                        <i class="bi bi-journal-code me-1"></i>Programas
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo e(request()->is('ofertasEducativas*') ? 'active' : ''); ?>" href="<?php echo e(route('public.ofertasEducativas.index')); ?>">
                        <i class="bi bi-megaphone me-1"></i>Ofertas
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo e(request()->is('ultimaNoticias*') ? 'active' : ''); ?>" href="<?php echo e(route('public.ultimaNoticias.index')); ?>">
                        <i class="bi bi-newspaper me-1"></i>Noticias
                    </a>
                </li>
            </ul>

            <!-- Right Side -->
            <ul class="navbar-nav ms-auto">
                <?php if(auth()->guard()->guest()): ?>
                    <?php if(Route::has('login')): ?>
                        <li class="nav-item">
                            <a class="btn btn-sm btn-outline-primary" href="<?php echo e(route('login')); ?>">
                                <i class="bi bi-box-arrow-in-right me-1"></i>Iniciar Sesión
                            </a>
                        </li>
                    <?php endif; ?>

                    <?php if(Route::has('register')): ?>
                        <li class="nav-item">
                            <a class="btn btn-sm btn-outline-primary" href="<?php echo e(route('register')); ?>">
                                <i class="bi bi-person-plus me-1"></i>Registrarse
                            </a>
                        </li>
                    <?php endif; ?>
                <?php else: ?>
                    <?php echo $__env->make('partials.user-menu', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>
<?php /**PATH C:\Users\Saave\Documents\project\SOES\SoeSoftware2\resources\views/partials/navbar.blade.php ENDPATH**/ ?>