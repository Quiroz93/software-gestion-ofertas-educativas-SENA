
<aside class="sidebar d-none d-lg-block" id="sidebar-desktop">
    <div class="sidebar-header">
        <h5>
            <i class="bi bi-speedometer2 me-2"></i>
            <?php echo e(config('app.name', 'SENA')); ?>

        </h5>
    </div>

    <nav>
        <ul class="sidebar-nav">
            
            <li class="sidebar-nav-item">
                <a href="<?php echo e(route('dashboard')); ?>"
                   class="sidebar-nav-link <?php echo e(request()->routeIs('dashboard') ? 'active' : ''); ?>">
                    <i class="bi bi-house"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            
            <li class="sidebar-nav-item px-3 py-2 mt-3">
                <small class="text-uppercase opacity-75">Contenido público</small>
            </li>

            
            <li class="sidebar-nav-item">
                <a href="<?php echo e(route('home')); ?>"
                   class="sidebar-nav-link <?php echo e(request()->routeIs('home') ? 'active' : ''); ?>">
                    <i class="bi bi-house-door"></i>
                    <span>Home</span>
                </a>
            </li>

            <li class="sidebar-nav-item px-3 py-2 mt-3">
                <small class="text-uppercase opacity-75">Contenido</small>
            </li>

            
            <li class="sidebar-nav-item">
                <a href="<?php echo e(route('programas.index')); ?>"
                   class="sidebar-nav-link <?php echo e(request()->routeIs('programas.*') ? 'active' : ''); ?>">
                    <i class="bi bi-book"></i>
                    <span>Programas</span>
                </a>
            </li>

            
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('preinscritos.admin')): ?>
            <li class="sidebar-nav-item">
                <a href="<?php echo e(route('preinscritos.index')); ?>"
                   class="sidebar-nav-link <?php echo e(request()->routeIs('preinscritos.*') ? 'active' : ''); ?>">
                    <i class="bi bi-person-check"></i>
                    <span>Preinscritos</span>
                </a>
            </li>
            <?php endif; ?>

            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('preinscritos.consolidaciones.admin')): ?>
            <li class="sidebar-nav-item">
                <a href="<?php echo e(route('preinscritos.consolidaciones.index')); ?>"
                   class="sidebar-nav-link <?php echo e(request()->routeIs('preinscritos.consolidaciones.*') ? 'active' : ''); ?>">
                    <i class="bi bi-layers"></i>
                    <span>Consolidaciones</span>
                </a>
            </li>
            <?php endif; ?>

            
            <li class="sidebar-nav-item">
                <a href="<?php echo e(route('ofertas.index')); ?>"
                   class="sidebar-nav-link <?php echo e(request()->routeIs('ofertas.*') ? 'active' : ''); ?>">
                    <i class="bi bi-briefcase"></i>
                    <span>Ofertas</span>
                </a>
            </li>

            
            <li class="sidebar-nav-item">
                <a href="<?php echo e(route('noticias.index')); ?>"
                   class="sidebar-nav-link <?php echo e(request()->routeIs('noticias.*') ? 'active' : ''); ?>">
                    <i class="bi bi-newspaper"></i>
                    <span>Noticias</span>
                </a>
            </li>

            
            <li class="sidebar-nav-item">
                <a href="<?php echo e(route('historias_de_exito.index')); ?>"
                   class="sidebar-nav-link <?php echo e(request()->routeIs('historia_de_exito.*') ? 'active' : ''); ?>">
                    <i class="bi bi-star"></i>
                    <span>Historias Éxito</span>
                </a>
            </li>

            <li class="sidebar-nav-item px-3 py-2 mt-3">
                <small class="text-uppercase opacity-75">Configuración</small>
            </li>

            
            <li class="sidebar-nav-item">
                <a href="<?php echo e(route('centros.index')); ?>"
                   class="sidebar-nav-link <?php echo e(request()->routeIs('centros.*') ? 'active' : ''); ?>">
                    <i class="bi bi-geo-alt"></i>
                    <span>Centros</span>
                </a>
            </li>

            
            <li class="sidebar-nav-item">
                <a href="<?php echo e(route('competencias.index')); ?>"
                   class="sidebar-nav-link <?php echo e(request()->routeIs('competencias.*') ? 'active' : ''); ?>">
                    <i class="bi bi-award"></i>
                    <span>Competencias</span>
                </a>
            </li>

            
            <li class="sidebar-nav-item">
                <a href="<?php echo e(route('niveles_formacion.index')); ?>"
                   class="sidebar-nav-link <?php echo e(request()->routeIs('niveles_formacion.*') ? 'active' : ''); ?>">
                    <i class="bi bi-mortarboard"></i>
                    <span>Niveles</span>
                </a>
            </li>

            
            <li class="sidebar-nav-item">
                <a href="<?php echo e(route('redes_conocimiento.index')); ?>"
                   class="sidebar-nav-link <?php echo e(request()->routeIs('redes_conocimiento.*') ? 'active' : ''); ?>">
                    <i class="bi bi-diagram-3"></i>
                    <span>Redes</span>
                </a>
            </li>

            
            <li class="sidebar-nav-item">
                <a href="<?php echo e(route('municipios.index')); ?>"
                   class="sidebar-nav-link <?php echo e(request()->routeIs('municipios.*') ? 'active' : ''); ?>">
                    <i class="bi bi-map"></i>
                    <span>Municipios</span>
                </a>
            </li>

            
            <li class="sidebar-nav-item">
                <a href="<?php echo e(route('instructores.index')); ?>"
                   class="sidebar-nav-link <?php echo e(request()->routeIs('instructores.*') ? 'active' : ''); ?>">
                    <i class="bi bi-people"></i>
                    <span>Instructores</span>
                </a>
            </li>

            <li class="sidebar-nav-item px-3 py-2 mt-3">
                <small class="text-uppercase opacity-75">Administración</small>
            </li>

            
            <li class="sidebar-nav-item">
                <a href="<?php echo e(route('users.index')); ?>"
                   class="sidebar-nav-link <?php echo e(request()->routeIs('users.*') ? 'active' : ''); ?>">
                    <i class="bi bi-shield-lock"></i>
                    <span>Usuarios</span>
                </a>
            </li>
        </ul>
    </nav>
</aside>


<div class="offcanvas offcanvas-start d-lg-none" tabindex="-1" id="sidebar-mobile" aria-labelledby="sidebarMobileLabel">
    <div class="offcanvas-header offcanvas-header-sena">
        <h5 class="offcanvas-title" id="sidebarMobileLabel">
            <i class="bi bi-speedometer2 me-2"></i><?php echo e(config('app.name', 'SENA')); ?>

        </h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>

    <div class="offcanvas-body p-0">
        <nav class="nav flex-column">
            <a class="nav-link <?php echo e(request()->routeIs('dashboard') ? 'active' : ''); ?>" href="<?php echo e(route('dashboard')); ?>">
                <i class="bi bi-house me-2"></i>Dashboard
            </a>
            
            <div class="px-3 py-2 mt-2">
                <small class="text-muted text-uppercase">Contenido público</small>
            </div>

            <a class="nav-link <?php echo e(request()->routeIs('home') ? 'active' : ''); ?>" href="<?php echo e(route('home')); ?>">
                <i class="bi bi-house-door me-2"></i>Home
            </a>

            <div class="px-3 py-2 mt-2">
                <small class="text-muted text-uppercase">Contenido</small>
            </div>

            <a class="nav-link <?php echo e(request()->routeIs('programas.*') ? 'active' : ''); ?>" href="<?php echo e(route('programas.index')); ?>">
                <i class="bi bi-book me-2"></i>Programas
            </a>
            
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('preinscritos.admin')): ?>
            <a class="nav-link <?php echo e(request()->routeIs('preinscritos.*') ? 'active' : ''); ?>" href="<?php echo e(route('preinscritos.index')); ?>">
                <i class="bi bi-person-check me-2"></i>Preinscritos
            </a>
            <?php endif; ?>

            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('preinscritos.consolidaciones.admin')): ?>
            <a class="nav-link <?php echo e(request()->routeIs('preinscritos.consolidaciones.*') ? 'active' : ''); ?>" href="<?php echo e(route('preinscritos.consolidaciones.index')); ?>">
                <i class="bi bi-layers me-2"></i>Consolidaciones
            </a>
            <?php endif; ?>
            
            <a class="nav-link <?php echo e(request()->routeIs('ofertas.*') ? 'active' : ''); ?>" href="<?php echo e(route('ofertas.index')); ?>">
                <i class="bi bi-briefcase me-2"></i>Ofertas
            </a>
            
            <a class="nav-link <?php echo e(request()->routeIs('noticias.*') ? 'active' : ''); ?>" href="<?php echo e(route('noticias.index')); ?>">
                <i class="bi bi-newspaper me-2"></i>Noticias
            </a>
            
            <a class="nav-link <?php echo e(request()->routeIs('historia_de_exito.*') ? 'active' : ''); ?>" href="<?php echo e(route('historias_de_exito.index')); ?>">
                <i class="bi bi-star me-2"></i>Historias Éxito
            </a>

            <div class="px-3 py-2 mt-2">
                <small class="text-muted text-uppercase">Configuración</small>
            </div>

            <a class="nav-link <?php echo e(request()->routeIs('centros.*') ? 'active' : ''); ?>" href="<?php echo e(route('centros.index')); ?>">
                <i class="bi bi-geo-alt me-2"></i>Centros
            </a>
            
            <a class="nav-link <?php echo e(request()->routeIs('competencias.*') ? 'active' : ''); ?>" href="<?php echo e(route('competencias.index')); ?>">
                <i class="bi bi-award me-2"></i>Competencias
            </a>
            
            <a class="nav-link <?php echo e(request()->routeIs('niveles_formacion.*') ? 'active' : ''); ?>" href="<?php echo e(route('niveles_formacion.index')); ?>">
                <i class="bi bi-mortarboard me-2"></i>Niveles
            </a>
            
            <a class="nav-link <?php echo e(request()->routeIs('redes_conocimiento.*') ? 'active' : ''); ?>" href="<?php echo e(route('redes_conocimiento.index')); ?>">
                <i class="bi bi-diagram-3 me-2"></i>Redes
            </a>
            
            <a class="nav-link <?php echo e(request()->routeIs('municipios.*') ? 'active' : ''); ?>" href="<?php echo e(route('municipios.index')); ?>">
                <i class="bi bi-map me-2"></i>Municipios
            </a>
            
            <a class="nav-link <?php echo e(request()->routeIs('instructores.*') ? 'active' : ''); ?>" href="<?php echo e(route('instructores.index')); ?>">
                <i class="bi bi-people me-2"></i>Instructores
            </a>

            <div class="px-3 py-2 mt-2">
                <small class="text-muted text-uppercase">Administración</small>
            </div>

            <a class="nav-link <?php echo e(request()->routeIs('users.*') ? 'active' : ''); ?>" href="<?php echo e(route('users.index')); ?>">
                <i class="bi bi-shield-lock me-2"></i>Usuarios
            </a>
        </nav>
    </div>
</div>


<div class="sidebar-overlay d-lg-none" id="sidebarOverlay"></div>

<style>
    /* Estilos para offcanvas móvil */
    .nav-link {
        color: #495057;
        padding: 0.75rem 1rem;
        transition: all 0.3s ease;
        border-left: 3px solid transparent;
    }
    
    .nav-link:hover {
        background-color: #f8f9fa;
        color: var(--sena-green);
        border-left-color: var(--sena-green);
    }
    
    .nav-link.active {
        background-color: rgba(57, 169, 0, 0.1);
        color: var(--sena-green);
        border-left-color: var(--sena-green);
        font-weight: 500;
    }
    
    .nav-link i {
        width: 20px;
        text-align: center;
    }
</style>


<button class="btn btn-primary d-lg-none position-fixed bottom-0 end-0 m-3 icon-btn-round" 
        type="button" 
        data-bs-toggle="offcanvas" 
        data-bs-target="#sidebar-mobile" 
        aria-controls="sidebar-mobile">
    <i class="bi bi-list fs-4"></i>
</button>
<?php /**PATH C:\Users\AdminSena\Documents\SoeSoftware2\resources\views/partials/sidebar.blade.php ENDPATH**/ ?>