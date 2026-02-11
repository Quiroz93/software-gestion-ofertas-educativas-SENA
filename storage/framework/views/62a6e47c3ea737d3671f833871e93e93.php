<li class="nav-item dropdown user-menu">
    <a class="nav-link dropdown-toggle d-flex align-items-center user-menu-toggle"
        href="#"
        id="userDropdown"
        role="button"
        aria-expanded="false">
        <img src="<?php echo e(Auth::user()->profile_photo_url); ?>"
            class="rounded-circle me-2"
            style="width: 32px; height: 32px; object-fit: cover;"
            alt="<?php echo e(Auth::user()->name); ?>">
        <span class="d-none d-md-inline"><?php echo e(Auth::user()->name); ?></span>
    </a>
    <ul class="dropdown-menu dropdown-menu-end shadow" aria-labelledby="userDropdown">
        <!-- User Info -->
        <li class="px-3 py-2 border-bottom">
            <div class="d-flex align-items-center">
                <img src="<?php echo e(Auth::user()->profile_photo_url); ?>"
                    class="rounded-circle me-2"
                    style="width: 40px; height: 40px; object-fit: cover;"
                    alt="<?php echo e(Auth::user()->name); ?>">
                <div>
                    <strong class="d-block"><?php echo e(Auth::user()->name); ?></strong>
                    <small class="text-muted"><?php echo e(Auth::user()->email); ?></small>
                </div>
            </div>
        </li>

        <!-- Menu Items -->
        <li>
            <a class="dropdown-item" href="<?php echo e(route('home')); ?>">
                <i class="bi bi-house me-2"></i>Home
            </a>
        </li>
        
        <?php if(Auth::user()->hasRole('admin') || Auth::user()->hasRole('SuperAdmin')): ?>
        <li>
            <a class="dropdown-item" href="<?php echo e(route('dashboard')); ?>">
                <i class="bi bi-speedometer2 me-2"></i>Dashboard
            </a>
        </li>
        <?php endif; ?>
        
        <li>
            <a class="dropdown-item" href="<?php echo e(route('profile.edit')); ?>">
                <i class="bi bi-person-circle me-2"></i>Mi Perfil
            </a>
        </li>
        <li>
            <a class="dropdown-item" href="#">
                <i class="bi bi-gear me-2"></i>Configuración
            </a>
        </li>

        <?php if(Auth::user()->hasRole('admin') || Auth::user()->hasRole('SuperAdmin')): ?>
        <li>
            <hr class="dropdown-divider">
        </li>

        <!-- Admin Panel -->
        <li>
            <a class="dropdown-item" href="<?php echo e(route('dashboard')); ?>">
                <i class="bi bi-shield-lock me-2"></i>Panel de Administración
            </a>
        </li>
        <?php endif; ?>

        <li>
            <hr class="dropdown-divider">
        </li>

        <!-- Logout -->
        <li>
            <form method="POST" action="<?php echo e(route('logout')); ?>">
                <?php echo csrf_field(); ?>
                <button type="submit" class="dropdown-item text-danger">
                    <i class="bi bi-box-arrow-right me-2"></i>Cerrar Sesión
                </button>
            </form>
        </li>
    </ul>
</li><?php /**PATH C:\Users\Saave\Documents\project\SOES\SoeSoftware2\resources\views/partials/user-menu.blade.php ENDPATH**/ ?>