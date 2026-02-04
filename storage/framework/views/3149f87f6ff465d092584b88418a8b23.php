<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?php echo $__env->yieldContent('title', config('app.name', 'SENA')); ?> - Admin</title>

    
    <link rel="icon" href="<?php echo e(asset('favicons/favicon.ico')); ?>" type="image/x-icon">

    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">

    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    
    <style>
        :root {
            --sidebar-width: 280px;
            --primary-color: #0d6efd;
            --sidebar-bg: #2c3e50;
            --sidebar-text: #ecf0f1;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f8f9fa;
        }

        .app-wrapper {
            display: flex;
            min-height: 100vh;
        }

        
        .sidebar {
            width: var(--sidebar-width);
            background: var(--sidebar-bg);
            color: var(--sidebar-text);
            padding: 0;
            position: fixed;
            left: 0;
            top: 0;
            bottom: 0;
            overflow-y: auto;
            z-index: 1000;
            box-shadow: 2px 0 8px rgba(0, 0, 0, 0.1);
        }

        .sidebar-header {
            padding: 1.5rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            background: rgba(0, 0, 0, 0.1);
        }

        .sidebar-header h5 {
            margin: 0;
            font-size: 1.1rem;
            font-weight: 600;
        }

        .sidebar-nav {
            list-style: none;
            padding: 1rem 0;
        }

        .sidebar-nav-item {
            margin: 0;
        }

        .sidebar-nav-link {
            display: flex;
            align-items: center;
            padding: 0.75rem 1.5rem;
            color: var(--sidebar-text);
            text-decoration: none;
            transition: all 0.3s ease;
            border-left: 3px solid transparent;
        }

        .sidebar-nav-link:hover {
            background: rgba(255, 255, 255, 0.1);
            border-left-color: var(--primary-color);
            color: #fff;
        }

        .sidebar-nav-link.active {
            background: rgba(13, 110, 253, 0.2);
            border-left-color: var(--primary-color);
            color: #fff;
        }

        .sidebar-nav-link i {
            width: 1.5rem;
            margin-right: 0.75rem;
            text-align: center;
        }

        
        .main-content {
            margin-left: var(--sidebar-width);
            display: flex;
            flex-direction: column;
            flex: 1;
        }

        
        .navbar {
            background: #fff;
            border-bottom: 1px solid #e9ecef;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
            padding: 1rem 2rem;
            margin-left: -var(--sidebar-width);
            margin-left: auto;
            width: 100%;
        }

        .navbar-brand {
            font-size: 1.1rem;
            font-weight: 600;
            color: #212529;
        }

        
        .content-area {
            flex: 1;
            padding: 2rem;
            overflow-y: auto;
        }

        
        .card {
            border: none;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.08);
            margin-bottom: 1.5rem;
            transition: all 0.3s ease;
        }

        .card:hover {
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.12);
        }

        .card-header {
            background: #f8f9fa;
            border-bottom: 1px solid #e9ecef;
            font-weight: 600;
        }

        
        .breadcrumb {
            background: transparent;
            padding: 0;
            margin-bottom: 1.5rem;
        }

        
        .btn {
            border-radius: 0.375rem;
            font-weight: 500;
            transition: all 0.2s ease;
        }

        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }

        .btn-primary:hover {
            background-color: #0b5ed7;
            border-color: #0b5ed7;
        }

        
        .table {
            background: #fff;
        }

        .table thead th {
            border-bottom: 2px solid #e9ecef;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.875rem;
            background: #f8f9fa;
        }

        .table tbody tr:hover {
            background: #f8f9fa;
        }

        
        .form-control,
        .form-select {
            border-color: #dee2e6;
            transition: all 0.3s ease;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.25);
        }

        
        .alert {
            border: none;
            border-radius: 0.375rem;
        }

        
        @media (max-width: 768px) {
            .sidebar {
                position: fixed;
                left: -var(--sidebar-width);
                transition: left 0.3s ease;
                z-index: 1050;
            }

            .sidebar.show {
                left: 0;
            }

            .main-content {
                margin-left: 0;
            }

            .navbar {
                margin-left: 0;
            }

            .content-area {
                padding: 1rem;
            }

            .toggle-sidebar {
                display: inline-block;
                cursor: pointer;
            }
        }

        @media (min-width: 769px) {
            .toggle-sidebar {
                display: none;
            }
        }

        
        .fade-in {
            animation: fadeIn 0.3s ease-in;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        
        .spinner {
            display: inline-block;
            vertical-align: middle;
        }

        
        .transition {
            transition: all 0.3s ease;
        }

        .hover-shadow:hover {
            box-shadow: 0 0.5rem 1.5rem rgba(0, 0, 0, 0.15) !important;
            transform: translateY(-2px);
        }
    </style>

    <?php echo $__env->yieldContent('css'); ?>
</head>
<body>
    <div class="app-wrapper">
        
        <aside class="sidebar" id="sidebar">
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
                        <small class="text-uppercase opacity-75">Contenido</small>
                    </li>

                    
                    <li class="sidebar-nav-item">
                        <a href="<?php echo e(route('programas.index')); ?>"
                           class="sidebar-nav-link <?php echo e(request()->routeIs('programas.*') ? 'active' : ''); ?>">
                            <i class="bi bi-book"></i>
                            <span>Programas</span>
                        </a>
                    </li>

                    
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

        
        <div class="main-content">
            
            <nav class="navbar navbar-expand-lg navbar-light sticky-top">
                <div class="container-fluid">
                    <button class="btn btn-outline-secondary d-lg-none toggle-sidebar" id="sidebarToggle">
                        <i class="bi bi-list"></i>
                    </button>

                    <span class="navbar-brand ms-2"><?php echo $__env->yieldContent('title', config('app.name', 'SENA')); ?></span>

                    <div class="ms-auto d-flex align-items-center gap-3">
                        
                        <?php if(auth()->guard()->check()): ?>
                        <div class="dropdown">
                            <button class="btn btn-link dropdown-toggle text-dark text-decoration-none"
                                    type="button" data-bs-toggle="dropdown">
                                <i class="bi bi-person-circle me-2"></i>
                                <?php echo e(Auth::user()->name); ?>

                            </button>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li>
                                    <a class="dropdown-item" href="<?php echo e(route('profile.edit')); ?>">
                                        <i class="bi bi-person me-2"></i>Perfil
                                    </a>
                                </li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form method="POST" action="<?php echo e(route('logout')); ?>">
                                        <?php echo csrf_field(); ?>
                                        <button type="submit" class="dropdown-item text-danger">
                                            <i class="bi bi-box-arrow-right me-2"></i>Cerrar sesión
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </nav>

            
            <div class="content-area fade-in">
                
                <?php if (! empty(trim($__env->yieldContent('breadcrumbs')))): ?>
                <nav aria-label="breadcrumb" class="mb-4">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?php echo e(route('dashboard')); ?>">Inicio</a></li>
                        <?php echo $__env->yieldContent('breadcrumbs'); ?>
                    </ol>
                </nav>
                <?php endif; ?>

                
                <?php if($errors->any()): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="bi bi-exclamation-triangle me-2"></i>
                    <strong>Errores de validación:</strong>
                    <ul class="mb-0 mt-2">
                        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li><?php echo e($error); ?></li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
                <?php endif; ?>

                <?php if(session('success')): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="bi bi-check-circle me-2"></i>
                    <?php echo e(session('success')); ?>

                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
                <?php endif; ?>

                
                <?php echo $__env->yieldContent('content'); ?>
            </div>

            
            <footer class="bg-light text-muted py-3 px-4 border-top mt-auto text-center">
                <small>&copy; <?php echo e(date('Y')); ?> <?php echo e(config('app.name', 'SENA')); ?>. Todos los derechos reservados.</small>
            </footer>
        </div>
    </div>

    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">

    
    <?php if(session('success')): ?>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                icon: 'success',
                title: '¡Éxito!',
                text: '<?php echo e(session("success")); ?>',
                confirmButtonText: 'Aceptar',
                timer: 3000
            });
        });
    </script>
    <?php endif; ?>

    
    <script>
        function confirmarEliminacion(event) {
            event.preventDefault();
            const form = event.target.closest('form');

            Swal.fire({
                title: '¿Estás seguro?',
                text: "¡No podrás revertir esto!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        }
    </script>

    
    <script>
        document.getElementById('sidebarToggle')?.addEventListener('click', function() {
            document.getElementById('sidebar').classList.toggle('show');
        });

        // Close sidebar when clicking on a link
        document.querySelectorAll('.sidebar-nav-link').forEach(link => {
            link.addEventListener('click', function() {
                document.getElementById('sidebar').classList.remove('show');
            });
        });
    </script>

    
    <script>
        $(function() {
            $('#myTable, .table').DataTable({
                responsive: true,
                autoWidth: false,
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.10.21/i18n/Spanish.json'
                }
            });
        });
    </script>

    <?php echo $__env->yieldContent('js'); ?>
</body>
</html>
<?php /**PATH C:\Users\Saave\Documents\project\SOES\SoeSoftware2\resources\views/layouts/admin.blade.php ENDPATH**/ ?>