<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

    <title><?php echo $__env->yieldContent('title', config('app.name', 'Laravel')); ?></title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=work-sans:400,500,600,700&display=swap" rel="stylesheet" />

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    <!-- Animate.css (usado por SweetAlert) -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/animate.css@4.1.1/animate.min.css">

    <!-- Assets -->
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/sena-utilities.css', 'resources/js/public/public.js']); ?>

    <?php echo $__env->yieldPushContent('styles'); ?>
</head>

<body>
<div id="app">

    
    <?php if(!View::hasSection('hide_navbar')): ?>
        <?php echo $__env->make('partials.navbar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <?php endif; ?>

    
    <main class="py-4">
        <?php echo $__env->yieldContent('content'); ?>
    </main>

</div>


<?php if(!View::hasSection('hide_footer')): ?>
<footer class="bg-light py-5" style="font-family: 'Work Sans', sans-serif;">
    <div class="container">
        <div class="row">

            <div class="col-md-3">
                <h5 class="editable" data-model="home" data-model-id="0" data-key="footer_centro_title" data-type="text">
                    <?php echo getCustomContent('home', 'footer_centro_title', 'Centro'); ?>

                </h5>
                <ul class="list-unstyled">
                    <li><a href="#" class="text-decoration-none text-muted editable" data-key="footer_centro_link1"><?php echo getCustomContent('home','footer_centro_link1','Sobre nosotros'); ?></a></li>
                    <li><a href="#" class="text-decoration-none text-muted editable" data-key="footer_centro_link2"><?php echo getCustomContent('home','footer_centro_link2','Programas'); ?></a></li>
                </ul>
            </div>

            <div class="col-md-3">
                <h5 class="editable" data-key="footer_servicios_title">
                    <?php echo getCustomContent('home','footer_servicios_title','Servicios'); ?>

                </h5>
                <ul class="list-unstyled">
                    <li><a href="#" class="text-decoration-none text-muted editable"><?php echo getCustomContent('home','footer_servicios_link1','Características'); ?></a></li>
                    <li><a href="#" class="text-decoration-none text-muted editable"><?php echo getCustomContent('home','footer_servicios_link2','Información'); ?></a></li>
                </ul>
            </div>

            <div class="col-md-3">
                <h5 class="editable"><?php echo getCustomContent('home','footer_recursos_title','Recursos'); ?></h5>
                <ul class="list-unstyled">
                    <li><a href="#" class="text-decoration-none text-muted editable"><?php echo getCustomContent('home','footer_recursos_link1','Blog'); ?></a></li>
                    <li><a href="#" class="text-decoration-none text-muted editable"><?php echo getCustomContent('home','footer_recursos_link2','Centro de ayuda'); ?></a></li>
                </ul>
            </div>

            <div class="col-md-3">
                <h5 class="editable"><?php echo getCustomContent('home','footer_contacto_title','Contáctanos'); ?></h5>
                <p class="text-muted editable"><?php echo getCustomContent('home','footer_contacto_direccion','Cra. 11 No. 13-13'); ?></p>
                <p class="text-muted editable"><?php echo getCustomContent('home','footer_contacto_telefono','Línea de atención: 018000 910270'); ?></p>
                <p class="text-muted editable"><?php echo getCustomContent('home','footer_contacto_email','Email: servicioalciudadano@sena.edu.co'); ?></p>
            </div>

        </div>

        <div class="row mt-4">
            <div class="col">
                <p class="text-center text-muted border-top pt-3 editable">
                    <?php echo getCustomContent('home','footer_copyright','&copy; 2026 SENA, Centro Agroempresarial y Turístico de los Andes.'); ?>

                </p>
            </div>
        </div>
    </div>
</footer>
<?php endif; ?>


<?php if(auth()->guard()->check()): ?>
<a href="<?php echo e(route('home')); ?>"
   class="btn btn-primary btn-lg shadow-lg position-fixed bottom-0 end-0 m-4 rounded-circle d-flex align-items-center justify-content-center"
   style="width:60px;height:60px;z-index:1050"
   data-bs-toggle="tooltip"
   title="Ir a Home">
    <i class="bi bi-house-fill fs-4"></i>
</a>
<?php endif; ?>

<!-- JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('[data-bs-toggle="tooltip"]').forEach(el => new bootstrap.Tooltip(el));
});
</script>

<?php if(session('success') || session('status') === 'inscripcion-exitosa' || session('status') === 'inscripcion-retirada'): ?>
<script>
document.addEventListener('DOMContentLoaded', () => {
Swal.fire({
    icon: 'success',
    title: '¡Éxito!',
    text: "<?php echo e(session('message') ?? session('success')); ?>",
    confirmButtonColor: '#39A900',
    timer: 4000,
    timerProgressBar: true
});
});
</script>
<?php endif; ?>

<?php if(session('error')): ?>
<script>
document.addEventListener('DOMContentLoaded', () => {
Swal.fire({
    icon: 'error',
    title: 'Error',
    text: "<?php echo e(session('error')); ?>",
    confirmButtonColor: '#FDC300'
});
});
</script>
<?php endif; ?>

<?php if(session('warning')): ?>
<script>
document.addEventListener('DOMContentLoaded', () => {
Swal.fire({
    icon: 'warning',
    title: 'Atención',
    text: "<?php echo e(session('warning')); ?>",
    confirmButtonColor: '#FDC300'
});
});
</script>
<?php endif; ?>

<?php if(session('info')): ?>
<script>
document.addEventListener('DOMContentLoaded', () => {
Swal.fire({
    icon: 'info',
    title: 'Información',
    text: "<?php echo e(session('info')); ?>",
    confirmButtonColor: '#00304D'
});
});
</script>
<?php endif; ?>

<?php echo $__env->yieldPushContent('scripts'); ?>
</body>
</html>
<?php /**PATH C:\Users\Saave\Documents\project\SOES\SoeSoftware2\resources\views/layouts/bootstrap.blade.php ENDPATH**/ ?>