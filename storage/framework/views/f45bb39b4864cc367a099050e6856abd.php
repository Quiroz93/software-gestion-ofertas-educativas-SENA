<?php $__env->startSection('title', 'Inicio'); ?>

<?php $__env->startSection('content'); ?>
<div class="container home">

    
    <?php
    $heroBgPath = getCustomContent('home', 'hero_background', null);
    $heroBgUrl = $heroBgPath ? asset('storage/' . $heroBgPath) : asset('images/background_1.png');
    ?>

    <section class="hero" aria-label="Sección principal">
        <div class="hero-card" style="background-image:url('<?php echo e($heroBgUrl); ?>')">
            <div class="hero-overlay"></div>

            <div class="hero-content">
                <h1 class="editable"
                    data-model="home" data-model-id="0" data-key="hero_title" data-type="text">
                    <?php echo getCustomContent('home', 'hero_title', 'Bienvenido a la plataforma SENA'); ?>

                </h1>

                <p class="lead editable"
                    data-model="home" data-model-id="0" data-key="hero_description" data-type="text">
                    <?php echo getCustomContent('home', 'hero_description', 'Explora programas de formación y oportunidades de crecimiento profesional'); ?>

                </p>

                <a href="#programas" class="btn btn-primary-sena">
                    <i class="bi bi-arrow-down"></i>
                    Explorar programas
                </a>
            </div>
        </div>
    </section>


    
    <?php if($slides->count()): ?>
    <section class="mt-5" aria-label="Información destacada SENA">

        <div id="senaCarousel"
            class="carousel slide carousel-sena"
            data-bs-ride="carousel">

            
            <div class="carousel-indicators">
                <?php $__currentLoopData = $slides; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $slide): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <button type="button"
                    data-bs-target="#senaCarousel"
                    data-bs-slide-to="<?php echo e($index); ?>"
                    class="<?php echo e($index === 0 ? 'active' : ''); ?>">
                </button>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>

            
            <div class="carousel-inner">

                <?php $__currentLoopData = $slides; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $slide): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php
                $bgImage = $slide->image_path
                ? asset('storage/'.$slide->image_path)
                : asset('images/background_1.png');
                ?>

                <div class="carousel-item <?php echo e($index === 0 ? 'active' : ''); ?>">
                    <div class="carousel-slide"
                        style="background-image:url('<?php echo e($bgImage); ?>')">

                        <div class="carousel-overlay"></div>

                        <div class="carousel-content">

                            <h3 class="editable"
                                data-model="home_carousel"
                                data-model-id="<?php echo e($slide->id); ?>"
                                data-key="title"
                                data-type="text">
                                <?php echo $slide->title; ?>

                            </h3>

                            <?php if($slide->description): ?>
                            <p class="editable"
                                data-model="home_carousel"
                                data-model-id="<?php echo e($slide->id); ?>"
                                data-key="description"
                                data-type="text">
                                <?php echo $slide->description; ?>

                            </p>
                            <?php endif; ?>

                            <?php if($slide->button_text && $slide->button_url): ?>
                            <a href="<?php echo e($slide->button_url); ?>"
                                class="btn btn-primary-sena btn-sm">
                                <?php echo e($slide->button_text); ?>

                            </a>
                            <?php endif; ?>

                        </div>
                    </div>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

            </div>

            
            <button class="carousel-control-prev"
                type="button"
                data-bs-target="#senaCarousel"
                data-bs-slide="prev">
                <span class="carousel-control-prev-icon"></span>
                <span class="visually-hidden">Anterior</span>
            </button>

            <button class="carousel-control-next"
                type="button"
                data-bs-target="#senaCarousel"
                data-bs-slide="next">
                <span class="carousel-control-next-icon"></span>
                <span class="visually-hidden">Siguiente</span>
            </button>

        </div>

    </section>
    <?php endif; ?>



    
    <section id="programas" class="mt-5" aria-label="Programas de formación">
        <header class="mb-4">
            <h2 class="h3 fw-semibold">
                <i class="bi bi-mortarboard icon-outline"></i>
                Programas de formación
            </h2>
            <p class="text-muted">Conoce nuestra oferta educativa disponible</p>
        </header>

        <div class="features">
            <?php $__currentLoopData = $programas ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $programa): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <article class="card">
                <h3 class="card-title"><?php echo e($programa->nombre); ?></h3>
                <p class="text-muted"><?php echo e(Str::limit($programa->descripcion, 120)); ?></p>
                <a href="<?php echo e(route('public.programasDeFormacion.show', $programa)); ?>" class="btn btn-outline-sena btn-sm">Ver más</a>
            </article>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php if(empty($programas) || count($programas) === 0): ?>
            <div class="card">
                <p class="text-muted mb-0">No hay programas disponibles actualmente.</p>
            </div>
            <?php endif; ?>

        </div>
    </section>

    
    <section class="mt-5" aria-label="Galería institucional">
        <header class="mb-4">
            <h2 class="h3 fw-semibold">
                <i class="bi bi-images icon-outline"></i>
                Galería institucional
            </h2>
        </header>

        <div class="features">
            <?php $__currentLoopData = $galeria ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $imagen): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <figure class="card">
                <img src="<?php echo e(asset('storage/'.$imagen->ruta)); ?>" alt="<?php echo e($imagen->titulo ?? 'Imagen institucional SENA'); ?>" class="img-fluid rounded">
                <?php if(!empty($imagen->titulo)): ?>
                <figcaption class="small text-muted mt-2"><?php echo e($imagen->titulo); ?></figcaption>
                <?php endif; ?>
            </figure>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php if(empty($galeria) || count($galeria) === 0): ?>
            <div class="card">
                <p class="text-muted mb-0">Galería no disponible.</p>
            </div>
            <?php endif; ?>
        </div>
    </section>

    
    <section class="mt-5" aria-label="Noticias y novedades">
        <header class="mb-4">
            <h2 class="h3 fw-semibold">
                <i class="bi bi-newspaper icon-outline"></i>
                Noticias
            </h2>
        </header>

        <div class="features">
            <?php $__currentLoopData = $noticias ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $noticia): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <article class="card">
                <span class="badge mb-2"><?php echo e($noticia->categoria ?? 'General'); ?></span>
                <h3 class="card-title"><?php echo e($noticia->titulo); ?></h3>
                <p class="text-muted"><?php echo e(Str::limit($noticia->descripcion, 100)); ?></p>
                <a href="<?php echo e(route('public.ultimaNoticias.show', $noticia)); ?>" class="btn btn-outline-sena btn-sm">Leer noticia</a>
            </article>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php if(empty($noticias) || count($noticias) === 0): ?>
            <div class="card">
                <p class="text-muted mb-0">No hay noticias publicadas.</p>
            </div>
            <?php endif; ?>
        </div>
    </section>

</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.bootstrap', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Saave\Documents\project\SOES\SoeSoftware2\resources\views/public/home.blade.php ENDPATH**/ ?>