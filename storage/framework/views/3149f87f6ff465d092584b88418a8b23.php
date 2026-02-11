<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title><?php echo $__env->yieldContent('title', config('app.name', 'SENA')); ?> - Admin</title>

    
    <link rel="icon" href="<?php echo e(asset('favicons/favicon.ico')); ?>" type="image/x-icon">

    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">

    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/sena-utilities.css', 'resources/css/admin/admin.css', 'resources/css/admin/admin-layout.css', 'resources/css/components/pagination-sena.css', 'resources/js/admin/admin.js']); ?>

    <?php echo $__env->yieldContent('css'); ?>
</head>
<body>
    <div class="app-wrapper">
        
        <div class="sidebar-overlay" id="sidebarOverlay"></div>
        
        
        <?php echo $__env->make('partials.sidebar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

        
        <div class="main-content">
            
            <nav class="navbar navbar-expand-lg navbar-light sticky-top">
                <div class="container-fluid">
                    <button class="btn btn-outline-success d-lg-none me-2" 
                            type="button"
                            data-bs-toggle="offcanvas" 
                            data-bs-target="#sidebar-mobile" 
                            aria-controls="sidebar-mobile">
                        <i class="bi bi-list" style="font-size: 1.25rem;"></i>
                    </button>

                    <span class="navbar-brand mb-0 h1"><?php echo $__env->yieldContent('title', config('app.name', 'SENA')); ?></span>

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
                
                <?php if (! empty(trim($__env->yieldContent('content_header')))): ?>
                <div class="content-header mb-4">
                    <?php echo $__env->yieldContent('content_header'); ?>
                </div>
                <?php endif; ?>

                
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

                <?php if(session('error')): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="bi bi-x-circle me-2"></i>
                    <?php echo e(session('error')); ?>

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

    <?php if(session('error')): ?>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                icon: 'error',
                title: 'Atención',
                text: '<?php echo e(session("error")); ?>',
                confirmButtonText: 'Aceptar'
            });
        });
    </script>
    <?php endif; ?>

    <?php if(session('permission_error')): ?>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                icon: 'info',
                title: 'Acceso restringido',
                text: '<?php echo e(session("permission_error")); ?>',
                confirmButtonText: 'Aceptar'
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
        // No necesitamos JavaScript personalizado, Bootstrap 5 maneja el offcanvas automáticamente
        // Pero mantenemos cierre al hacer clic en enlaces para mejor UX móvil
        document.querySelectorAll('#sidebar-mobile .nav-link').forEach(link => {
            link.addEventListener('click', function() {
                const offcanvas = bootstrap.Offcanvas.getInstance(document.getElementById('sidebar-mobile'));
                if (offcanvas && window.innerWidth < 992) {
                    offcanvas.hide();
                }
            });
        });

        // También para el sidebar desktop en tablets
        document.querySelectorAll('.sidebar-nav-link').forEach(link => {
            link.addEventListener('click', function() {
                if (window.innerWidth < 992 && document.getElementById('sidebar-desktop')) {
                    document.getElementById('sidebar-desktop').classList.remove('show');
                    document.getElementById('sidebarOverlay').classList.remove('show');
                    document.body.classList.remove('sidebar-open');
                }
            });
        });
    </script>

    
    <script>
        $(function() {
            $('#myTable, #preinscritos-table').DataTable({
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