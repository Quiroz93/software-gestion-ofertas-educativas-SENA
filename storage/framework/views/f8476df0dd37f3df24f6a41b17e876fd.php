<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

    <title><?php echo $__env->yieldContent('title', config('app.name', 'Laravel')); ?></title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    <!-- Custom CSS -->
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css']); ?>

    <?php echo $__env->yieldPushContent('styles'); ?>
</head>

<body>
    <div id="app">
        <!-- Navbar -->
        <?php echo $__env->make('partials.navbar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

        <!-- Main Content -->
        <main class="py-4">
            <?php echo $__env->yieldContent('content'); ?>
        </main>

    </div>

    
    <footer class="bg-light py-5" style="font-family: 'worksans sans-serif';">
        <div class="container">
            <div class="row">
                <div class="col-md-3">
                    <h5 class="editable" data-model="home" data-model-id="0" data-key="footer_centro_title" data-type="text">
                        <?php echo getCustomContent('home', 'footer_centro_title', 'Centro'); ?>

                    </h5>
                    <ul class="list-unstyled">
                        <li><a href="#" class="text-decoration-none text-muted editable" data-model="home" data-model-id="0" data-key="footer_centro_link1" data-type="text"><?php echo getCustomContent('home', 'footer_centro_link1', 'Sobre nosotros'); ?></a></li>
                        <li><a href="#" class="text-decoration-none text-muted editable" data-model="home" data-model-id="0" data-key="footer_centro_link2" data-type="text"><?php echo getCustomContent('home', 'footer_centro_link2', 'Programas'); ?></a></li>
                        <!-- more links -->
                    </ul>
                </div>
                <div class="col-md-3">
                    <h5 class="editable" data-model="home" data-model-id="0" data-key="footer_servicios_title" data-type="text">
                        <?php echo getCustomContent('home', 'footer_servicios_title', 'Servicios'); ?>

                    </h5>
                    <ul class="list-unstyled">
                        <li><a href="#" class="text-decoration-none text-muted editable" data-model="home" data-model-id="0" data-key="footer_servicios_link1" data-type="text"><?php echo getCustomContent('home', 'footer_servicios_link1', 'Características'); ?></a></li>
                        <li><a href="#" class="text-decoration-none text-muted editable" data-model="home" data-model-id="0" data-key="footer_servicios_link2" data-type="text"><?php echo getCustomContent('home', 'footer_servicios_link2', 'información'); ?></a></li>
                        <!-- more links -->
                    </ul>
                </div>
                <div class="col-md-3">
                    <h5 class="editable" data-model="home" data-model-id="0" data-key="footer_recursos_title" data-type="text">
                        <?php echo getCustomContent('home', 'footer_recursos_title', 'Recursos'); ?>

                    </h5>
                    <ul class="list-unstyled">
                        <li><a href="#" class="text-decoration-none text-muted editable" data-model="home" data-model-id="0" data-key="footer_recursos_link1" data-type="text"><?php echo getCustomContent('home', 'footer_recursos_link1', 'Blog'); ?></a></li>
                        <li><a href="#" class="text-decoration-none text-muted editable" data-model="home" data-model-id="0" data-key="footer_recursos_link2" data-type="text"><?php echo getCustomContent('home', 'footer_recursos_link2', 'Centro de ayuda'); ?></a></li>
                        <!-- more links -->
                    </ul>
                </div>
                <div class="col-md-3">
                    <h5 class="editable" data-model="home" data-model-id="0" data-key="footer_contacto_title" data-type="text">
                        <?php echo getCustomContent('home', 'footer_contacto_title', 'Contactanos'); ?>

                    </h5>
                    <p class="text-muted editable" data-model="home" data-model-id="0" data-key="footer_contacto_direccion" data-type="text">
                        <?php echo getCustomContent('home', 'footer_contacto_direccion', 'Cra. 11 No. 13-13'); ?>

                    </p>
                    <p class="text-muted editable" data-model="home" data-model-id="0" data-key="footer_contacto_telefono" data-type="text">
                        <?php echo getCustomContent('home', 'footer_contacto_telefono', 'Linea de atención: 018000 910270'); ?>

                    </p>
                    <p class="text-muted editable" data-model="home" data-model-id="0" data-key="footer_contacto_email" data-type="text">
                        <?php echo getCustomContent('home', 'footer_contacto_email', 'Email: servicioalciudadano@sena.udu.co'); ?>

                    </p>
                </div>
            </div>
            <div class="row mt-4">
                <div class="col">
                    <p class="text-center text-muted border-top pt-3 editable" data-model="home" data-model-id="0" data-key="footer_copyright" data-type="text">
                        <?php echo getCustomContent('home', 'footer_copyright', '&copy; 2026 SENA, Centro Agroempresarial y Turístico de los Andes.'); ?>

                    </p>
                </div>
            </div>
        </div>
    </footer>

    <!-- Bootstrap 5 Bundle JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Custom JS -->
    <?php echo app('Illuminate\Foundation\Vite')(['resources/js/app.js']); ?>

    <?php echo $__env->yieldPushContent('scripts'); ?>
</body>

</html><?php /**PATH C:\Users\Saave\Documents\project\SOES\SoeSoftware2\resources\views/layouts/bootstrap.blade.php ENDPATH**/ ?>