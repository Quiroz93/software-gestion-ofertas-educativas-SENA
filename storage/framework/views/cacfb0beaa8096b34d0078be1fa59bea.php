<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title><?php echo $__env->yieldContent('title', config('app.name') . ' | Autenticación'); ?></title>

    <link rel="icon" href="<?php echo e(asset('favicons/favicon.ico')); ?>" type="image/x-icon">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=work-sans:400,500,600,700&display=swap" rel="stylesheet" />

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Common CSS/JS -->
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/sena-utilities.css', 'resources/css/common/app.css', 'resources/js/common/app.js']); ?>

    <?php echo $__env->yieldPushContent('styles'); ?>
</head>

<body>

    <div class="container-fluid auth-container">
        <div class="row h-100 justify-content-center align-items-center">
            <div class="col-12 col-md-8 col-lg-5">
                <!-- Logo + Title -->
                <div class="text-center mb-4 mt-5">
                    <div class="brand-image mb-3">
                        <img src="<?php echo e(asset('images/logosimbolo-SENA.svg')); ?>" alt="SENA Logo">
                    </div>
                    <h4 class="fw-bold mb-1 mt-3"><?php echo e(config('app.name')); ?></h4>
                    <span class="text-muted mb-5">SENA</span>
                </div>

                <!-- Auth Card -->
                <div class="card auth-card">
                    <div class="card-body p-4 p-md-5">
                        <?php echo $__env->yieldContent('content'); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Custom styles -->
    <style>
        body {
            font-family: 'Work Sans', sans-serif;
            background-color: #F6F6F6;
            min-height: 100vh;
        }

        .auth-container {
            min-height: 100vh;
        }

        .auth-card {
            border-radius: 1rem;
            box-shadow: 0 10px 25px rgba(0, 48, 77, 0.1);
            border: 1px solid rgba(0, 0, 0, 0.06);
        }

        /* Logo SENA */
        .brand-image {
            display: block;
            margin: 0 auto;
        }
        
        .brand-image img {
            width: 8rem;
            height: 8rem;
            display: block;
            margin: 0 auto;
            filter: brightness(0) saturate(100%) invert(56%) sepia(96%) saturate(445%) hue-rotate(56deg) brightness(97%) contrast(95%);
        }

        /* Divider */
        .auth-divider {
            height: 1px;
            background-color: rgba(0, 0, 0, 0.08);
            margin: 1.5rem 0;
        }

        /* Bootstrap error helpers */
        .invalid-feedback {
            display: block;
        }
    </style>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <?php echo $__env->yieldPushContent('scripts'); ?>
</body>

</html>
<?php /**PATH C:\Users\Saave\Documents\project\SOES\SoeSoftware2\resources\views/layouts/auth.blade.php ENDPATH**/ ?>