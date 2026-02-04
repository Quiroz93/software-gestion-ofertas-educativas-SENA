<?php $__env->startSection('title', 'Dashboard'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <!-- Welcome Section -->
    <div class="row mb-5 pb-4 border-bottom">
        <div class="col-lg-8">
            <h1 class="display-5 fw-bold mb-2">
                <i class="bi bi-hand-thumbs-up text-success me-2"></i>
                ¡Bienvenido, <?php echo e(auth()->user()->name); ?>!
            </h1>
            <p class="lead text-muted">
                Accede a todos nuestros programas, ofertas y recursos de formación
            </p>
        </div>
        <div class="col-lg-4 d-flex align-items-end justify-content-lg-end">
            <a href="<?php echo e(route('profile.edit')); ?>" class="btn btn-outline-primary">
                <i class="bi bi-person-circle me-2"></i>Mi Perfil
            </a>
        </div>
    </div>

    <!-- Hero Section -->
    <?php
        $heroBgPath = getCustomContent('home', 'hero_background', null);
        $heroBgUrl = $heroBgPath ? asset('storage/' . $heroBgPath) : asset('images/background_1.png');
    ?>
    <div class="row mb-5">
        <div class="col-12">
            <div class="rounded-lg p-5 text-white position-relative overflow-hidden"
                 style="background-image: url('<?php echo e($heroBgUrl); ?>'); 
                         background-size: cover; 
                         background-position: center;
                         min-height: 400px;
                         display: flex;
                         align-items: center;">
                <!-- Overlay -->
                <div style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; 
                            background: rgba(0,0,0,0.4); z-index: 1;"></div>
                
                <!-- Content -->
                <div class="position-relative" style="z-index: 2;">
                    <h2 class="display-4 fw-bold mb-3 editable"
                        data-model="home" data-model-id="0" data-key="hero_title" data-type="text">
                        <?php echo getCustomContent('home', 'hero_title', 'Bienvenido a nuestra plataforma de formación'); ?>

                    </h2>
                    <p class="lead mb-4 editable"
                       data-model="home" data-model-id="0" data-key="hero_description" data-type="text">
                        <?php echo getCustomContent('home', 'hero_description', 'Descubre nuestros programas y oportunidades de desarrollo profesional'); ?>

                    </p>
                    <a href="#programas" class="btn btn-success btn-lg">
                        <i class="bi bi-arrow-down me-2"></i>Explorar Programas
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Carousel Section -->
    <div class="row mb-5">
        <div class="col-12">
            <h3 class="h4 fw-bold mb-4">
                <i class="bi bi-images me-2 text-primary"></i>Galería Destacada
            </h3>
            <div id="carouselHome" class="carousel slide shadow-lg rounded-lg overflow-hidden" 
                 data-bs-ride="carousel" data-bs-interval="5000">
                <div class="carousel-indicators">
                    <?php for($i = 0; $i < 3; $i++): ?>
                    <button type="button" data-bs-target="#carouselHome" data-bs-slide-to="<?php echo e($i); ?>"
                            class="<?php echo e($i === 0 ? 'active' : ''); ?>" 
                            aria-label="Slide <?php echo e($i + 1); ?>"></button>
                    <?php endfor; ?>
                </div>
                
                <div class="carousel-inner">
                    <?php
                        $carousel = [
                            ['image' => getCustomContent('home', 'carousel_slide1_image', null)],
                            ['image' => getCustomContent('home', 'carousel_slide2_image', null)],
                            ['image' => getCustomContent('home', 'carousel_slide3_image', null)],
                        ];
                    ?>
                    
                    <?php $__currentLoopData = $carousel; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $slide): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="carousel-item <?php echo e($key === 0 ? 'active' : ''); ?>">
                        <?php if($slide['image']): ?>
                            <img src="<?php echo e(asset('storage/' . $slide['image'])); ?>" 
                                 class="d-block w-100 editable" 
                                 data-model="home" 
                                 data-model-id="0" 
                                 data-key="carousel_slide<?php echo e($key + 1); ?>_image" 
                                 data-type="image"
                                 alt="Slide <?php echo e($key + 1); ?>"
                                 style="object-fit: cover; height: 500px;">
                        <?php else: ?>
                            <div style="height: 500px; background: #e9ecef; display: flex; align-items: center; justify-content: center;">
                                <span class="text-muted">Sin imagen</span>
                            </div>
                        <?php endif; ?>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>

                <button class="carousel-control-prev" type="button" data-bs-target="#carouselHome" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#carouselHome" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                </button>
            </div>
        </div>
    </div>

    <!-- Featured Posts Section -->
    <div class="row mb-5 pb-4 border-bottom">
        <div class="col-12">
            <h3 class="h4 fw-bold mb-4">
                <i class="bi bi-star me-2 text-warning"></i>Destacados
            </h3>
        </div>
        
        <div class="col-md-6 mb-4">
            <div class="card h-100 shadow-sm border-0 overflow-hidden transition">
                <img src="<?php echo e(asset('storage/' . getCustomContent('home', 'post1_image', ''))); ?>" 
                     alt="Post 1" 
                     class="card-img-top" 
                     style="height: 250px; object-fit: cover;">
                <div class="card-body">
                    <span class="badge bg-primary mb-2 editable"
                          data-model="home" data-model-id="0" data-key="post1_category" data-type="text">
                        <?php echo e(getCustomContent('home', 'post1_category', 'Noticia')); ?>

                    </span>
                    <h5 class="card-title fw-bold editable"
                        data-model="home" data-model-id="0" data-key="post1_title" data-type="text">
                        <?php echo getCustomContent('home', 'post1_title', 'Título del post'); ?>

                    </h5>
                    <p class="card-text text-muted small editable"
                       data-model="home" data-model-id="0" data-key="post1_date" data-type="text">
                        <?php echo getCustomContent('home', 'post1_date', 'Enero 28, 2026'); ?>

                    </p>
                    <p class="card-text editable"
                       data-model="home" data-model-id="0" data-key="post1_desc" data-type="text">
                        <?php echo getCustomContent('home', 'post1_desc', 'Descripción del primer post destacado...'); ?>

                    </p>
                    <a href="#" class="btn btn-sm btn-outline-primary">
                        Leer más <i class="bi bi-arrow-right ms-1"></i>
                    </a>
                </div>
            </div>
        </div>

        <div class="col-md-6 mb-4">
            <div class="card h-100 shadow-sm border-0 overflow-hidden transition">
                <img src="<?php echo e(asset('storage/' . getCustomContent('home', 'post2_image', ''))); ?>" 
                     alt="Post 2" 
                     class="card-img-top" 
                     style="height: 250px; object-fit: cover;">
                <div class="card-body">
                    <span class="badge bg-success mb-2 editable"
                          data-model="home" data-model-id="0" data-key="post2_category" data-type="text">
                        <?php echo e(getCustomContent('home', 'post2_category', 'Ofertas')); ?>

                    </span>
                    <h5 class="card-title fw-bold editable"
                        data-model="home" data-model-id="0" data-key="post2_title" data-type="text">
                        <?php echo getCustomContent('home', 'post2_title', 'Título del post 2'); ?>

                    </h5>
                    <p class="card-text text-muted small editable"
                       data-model="home" data-model-id="0" data-key="post2_date" data-type="text">
                        <?php echo getCustomContent('home', 'post2_date', 'Enero 28, 2026'); ?>

                    </p>
                    <p class="card-text editable"
                       data-model="home" data-model-id="0" data-key="post2_desc" data-type="text">
                        <?php echo getCustomContent('home', 'post2_desc', 'Descripción del segundo post destacado...'); ?>

                    </p>
                    <a href="#" class="btn btn-sm btn-outline-success">
                        Leer más <i class="bi bi-arrow-right ms-1"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Info Cards Section -->
    <div class="row mb-5" id="programas">
        <div class="col-12">
            <h3 class="h4 fw-bold mb-4">
                <i class="bi bi-grid-3x3-gap me-2 text-info"></i>Acceso Rápido
            </h3>
        </div>

        <!-- Centros Card -->
        <div class="col-md-3 mb-4">
            <div class="card h-100 shadow-sm border-0 text-center transition hover-shadow">
                <div class="card-body py-5">
                    <i class="bi bi-building display-4 text-primary mb-3 d-block"></i>
                    <h6 class="fw-bold card-title editable"
                        data-model="home" data-model-id="0" data-key="centros_title" data-type="text">
                        <?php echo e(getCustomContent('home', 'centros_title', 'Centros')); ?>

                    </h6>
                    <p class="text-muted small card-text editable"
                       data-model="home" data-model-id="0" data-key="centros_description" data-type="text">
                        <?php echo e(getCustomContent('home', 'centros_description', 'Conoce nuestras sedes')); ?>

                    </p>
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('centros.view')): ?>
                        <a href="<?php echo e(route('centros.index')); ?>" class="btn btn-sm btn-primary">Ver más</a>
                    <?php else: ?>
                        <a href="<?php echo e(route('public.centrosFormacion.index')); ?>" class="btn btn-sm btn-primary">Ver más</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Programas Card -->
        <div class="col-md-3 mb-4">
            <div class="card h-100 shadow-sm border-0 text-center transition hover-shadow">
                <div class="card-body py-5">
                    <i class="bi bi-journal-code display-4 text-success mb-3 d-block"></i>
                    <h6 class="fw-bold card-title editable"
                        data-model="home" data-model-id="0" data-key="programas_title" data-type="text">
                        <?php echo e(getCustomContent('home', 'programas_title', 'Programas')); ?>

                    </h6>
                    <p class="text-muted small card-text editable"
                       data-model="home" data-model-id="0" data-key="programas_description" data-type="text">
                        <?php echo e(getCustomContent('home', 'programas_description', 'Formación profesional')); ?>

                    </p>
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('programas.view')): ?>
                        <a href="<?php echo e(route('programas.index')); ?>" class="btn btn-sm btn-success">Ver más</a>
                    <?php else: ?>
                        <a href="<?php echo e(route('public.programasDeFormacion.index')); ?>" class="btn btn-sm btn-success">Ver más</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Ofertas Card -->
        <div class="col-md-3 mb-4">
            <div class="card h-100 shadow-sm border-0 text-center transition hover-shadow">
                <div class="card-body py-5">
                    <i class="bi bi-megaphone display-4 text-warning mb-3 d-block"></i>
                    <h6 class="fw-bold card-title editable"
                        data-model="home" data-model-id="0" data-key="ofertas_title" data-type="text">
                        <?php echo e(getCustomContent('home', 'ofertas_title', 'Ofertas')); ?>

                    </h6>
                    <p class="text-muted small card-text editable"
                       data-model="home" data-model-id="0" data-key="ofertas_description" data-type="text">
                        <?php echo e(getCustomContent('home', 'ofertas_description', 'Oportunidades laborales')); ?>

                    </p>
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('ofertas.view')): ?>
                        <a href="<?php echo e(route('ofertas.index')); ?>" class="btn btn-sm btn-warning">Ver más</a>
                    <?php else: ?>
                        <a href="<?php echo e(route('public.ofertasEducativas.index')); ?>" class="btn btn-sm btn-warning">Ver más</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Noticias Card -->
        <div class="col-md-3 mb-4">
            <div class="card h-100 shadow-sm border-0 text-center transition hover-shadow">
                <div class="card-body py-5">
                    <i class="bi bi-newspaper display-4 text-danger mb-3 d-block"></i>
                    <h6 class="fw-bold card-title editable"
                        data-model="home" data-model-id="0" data-key="noticias_title" data-type="text">
                        <?php echo e(getCustomContent('home', 'noticias_title', 'Noticias')); ?>

                    </h6>
                    <p class="text-muted small card-text editable"
                       data-model="home" data-model-id="0" data-key="noticias_description" data-type="text">
                        <?php echo e(getCustomContent('home', 'noticias_description', 'Últimas novedades')); ?>

                    </p>
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('noticias.view')): ?>
                        <a href="<?php echo e(route('noticias.index')); ?>" class="btn btn-sm btn-danger">Ver más</a>
                    <?php else: ?>
                        <a href="<?php echo e(route('public.ultimaNoticias.index')); ?>" class="btn btn-sm btn-danger">Ver más</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- CTA Section -->
    <div class="row">
        <div class="col-12">
            <div class="bg-primary text-white rounded-lg p-5 text-center">
                <h3 class="h4 fw-bold mb-2">¿Necesitas ayuda?</h3>
                <p class="mb-3">Nuestro equipo está listo para asistirte en tu proceso de formación</p>
                <a href="mailto:info@example.com" class="btn btn-light">
                    <i class="bi bi-envelope me-2"></i>Contáctanos
                </a>
            </div>
        </div>
    </div>
</div>

<style>
    .transition {
        transition: all 0.3s ease;
    }
    
    .hover-shadow:hover {
        box-shadow: 0 0.5rem 1.5rem rgba(0, 0, 0, 0.15) !important;
        transform: translateY(-5px);
    }
    
    .carousel-indicators [data-bs-target] {
        width: 12px;
        height: 12px;
        border-radius: 50%;
        background-color: rgba(255, 255, 255, 0.5);
        border: 2px solid #fff;
        opacity: 0.7;
        transition: all 0.3s ease;
    }
    
    .carousel-indicators [data-bs-target].active {
        background-color: #fff;
        opacity: 1;
        transform: scale(1.2);
    }
    
    .carousel-indicators [data-bs-target]:hover {
        background-color: rgba(255, 255, 255, 0.8);
        transform: scale(1.1);
    }
</style>
    </div>
    <div class="carousel-inner" style="max-height: 500px; overflow: hidden;">
      <div class="carousel-item active">
        <?php
          $slide1ImagePath = getCustomContent('home', 'carousel_slide1_image', null);
          $slide1ImageUrl = $slide1ImagePath ? asset('storage/' . $slide1ImagePath) : asset('images/carousel-placeholder.jpg');
        ?>
        <img src="<?php echo e($slide1ImageUrl); ?>" class="d-block w-100 editable" alt="Slide 1" style="object-fit: cover; height: 500px;"
             data-model="home" data-model-id="0" data-key="carousel_slide1_image" data-type="image">
        <div class="carousel-caption d-none d-md-block">
          <h5 class="editable" data-model="home" data-model-id="0" data-key="carousel_slide1_title" data-type="text">
            <?php echo getCustomContent('home', 'carousel_slide1_title', 'First slide label'); ?>

          </h5>
          <p class="editable" data-model="home" data-model-id="0" data-key="carousel_slide1_desc" data-type="text">
            <?php echo getCustomContent('home', 'carousel_slide1_desc', 'Some representative placeholder content for the first slide.'); ?>

          </p>
        </div>
      </div>
      <div class="carousel-item">
        <?php
          $slide2ImagePath = getCustomContent('home', 'carousel_slide2_image', null);
          $slide2ImageUrl = $slide2ImagePath ? asset('storage/' . $slide2ImagePath) : asset('images/carousel-placeholder.jpg');
        ?>
        <img src="<?php echo e($slide2ImageUrl); ?>" class="d-block w-100 editable" alt="Slide 2" style="object-fit: cover; height: 500px;"
             data-model="home" data-model-id="0" data-key="carousel_slide2_image" data-type="image">
        <div class="carousel-caption d-none d-md-block">
          <h5 class="editable" data-model="home" data-model-id="0" data-key="carousel_slide2_title" data-type="text">
            <?php echo getCustomContent('home', 'carousel_slide2_title', 'Second slide label'); ?>

          </h5>
          <p class="editable" data-model="home" data-model-id="0" data-key="carousel_slide2_desc" data-type="text">
            <?php echo getCustomContent('home', 'carousel_slide2_desc', 'Some representative placeholder content for the second slide.'); ?>

          </p>
        </div>
      </div>
      <div class="carousel-item">
        <?php
          $slide3ImagePath = getCustomContent('home', 'carousel_slide3_image', null);
          $slide3ImageUrl = $slide3ImagePath ? asset('storage/' . $slide3ImagePath) : asset('images/carousel-placeholder.jpg');
        ?>
        <img src="<?php echo e($slide3ImageUrl); ?>" class="d-block w-100 editable" alt="Slide 3" style="object-fit: cover; height: 500px;"
             data-model="home" data-model-id="0" data-key="carousel_slide3_image" data-type="image">
        <div class="carousel-caption d-none d-md-block">
          <h5 class="editable" data-model="home" data-model-id="0" data-key="carousel_slide3_title" data-type="text">
            <?php echo getCustomContent('home', 'carousel_slide3_title', 'Third slide label'); ?>

          </h5>
          <p class="editable" data-model="home" data-model-id="0" data-key="carousel_slide3_desc" data-type="text">
            <?php echo getCustomContent('home', 'carousel_slide3_desc', 'Some representative placeholder content for the third slide.'); ?>

          </p>
        </div>
      </div>
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="prev">
      <span class="carousel-control-prev-icon" aria-hidden="true"></span>
      <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="next">
      <span class="carousel-control-next-icon" aria-hidden="true"></span>
      <span class="visually-hidden">Next</span>
    </button>
  </div>
  </div>
</div>



<div class="container" style="margin-top: 4rem; padding-top: 2rem; font-family: 'worksans sans-serif';">
  <div class="row mb-2">
    <div class="col-md-6">
      <div
        class="row g-0 border rounded overflow-hidden flex-md-row mb-4 shadow-sm h-md-250 position-relative">
        <div class="col p-4 d-flex flex-column position-static">
          <strong class="d-inline-block mb-2 text-primary-emphasis editable"
            data-model="home" data-model-id="0" data-key="post1_category" data-type="text">
            <?php echo getCustomContent('home', 'post1_category', 'World'); ?>

          </strong>
          <h3 class="mb-0 editable" data-model="home" data-model-id="0" data-key="post1_title" data-type="text">
            <?php echo getCustomContent('home', 'post1_title', 'Featured post'); ?>

          </h3>
          <div class="mb-1 text-body-secondary editable" data-model="home" data-model-id="0" data-key="post1_date" data-type="text">
            <?php echo getCustomContent('home', 'post1_date', 'Nov 12'); ?>

          </div>
          <p class="card-text mb-auto editable" data-model="home" data-model-id="0" data-key="post1_desc" data-type="text">
            <?php echo getCustomContent('home', 'post1_desc', 'This is a wider card with supporting text below as a natural lead-in to additional content.'); ?>

          </p>
          <a
            href="#"
            class="icon-link gap-1 icon-link-hover stretched-link text-success text-decoration-underline editable"
            data-model="home"
            data-model-id="0"
            data-key="featured_post1_link"
            data-type="text">
            <?php echo e(getCustomContent('home', 'featured_post1_link', 'Continue reading')); ?>

            <svg class="bi" aria-hidden="true">
              <use xlink:href="#chevron-right"></use>
            </svg>
          </a>
        </div>
        <div class="col-auto d-none d-lg-block editable" data-model="home" data-model-id="0" data-key="post1_image" data-type="image">
          <svg
            aria-label="Placeholder: Thumbnail"
            class="bd-placeholder-img"
            height="250"
            preserveAspectRatio="xMidYMid slice"
            role="img"
            width="200"
            xmlns="http://www.w3.org/2000/svg">
            <title>Placeholder</title>
            <rect width="100%" height="100%" fill="#55595c"></rect>
            <text x="50%" y="50%" fill="#eceeef" dy=".3em">Thumbnail</text>
          </svg>
        </div>
      </div>
    </div>
    <div class="col-md-6">
      <div
        class="row g-0 border rounded overflow-hidden flex-md-row mb-4 shadow-sm h-md-250 position-relative">
        <div class="col p-4 d-flex flex-column position-static">
          <strong class="d-inline-block mb-2 text-success-emphasis editable"
            data-model="home" data-model-id="0" data-key="post2_category" data-type="text">
            <?php echo getCustomContent('home', 'post2_category', 'Design'); ?>

          </strong>
          <h3 class="mb-0 editable" data-model="home" data-model-id="0" data-key="post2_title" data-type="text">
            <?php echo getCustomContent('home', 'post2_title', 'Post title'); ?>

          </h3>
          <div class="mb-1 text-body-secondary editable" data-model="home" data-model-id="0" data-key="post2_date" data-type="text">
            <?php echo getCustomContent('home', 'post2_date', 'Nov 11'); ?>

          </div>
          <p class="mb-auto editable" data-model="home" data-model-id="0" data-key="post2_desc" data-type="text">
            <?php echo getCustomContent('home', 'post2_desc', 'This is a wider card with supporting text below as a natural lead-in to additional content.'); ?>

          </p>
          <a
            href="#"
            class="icon-link gap-1 icon-link-hover stretched-link text-success text-decoration-underline editable"
            data-model="home"
            data-model-id="0"
            data-key="featured_post2_link"
            data-type="text">
            <?php echo e(getCustomContent('home', 'featured_post2_link', 'Continue reading')); ?>

            <svg class="bi" aria-hidden="true">
              <use xlink:href="#chevron-right"></use>
            </svg>
          </a>
        </div>
        <div class="col-auto d-none d-lg-block">
          <svg
            aria-label="Placeholder: Thumbnail"
            class="bd-placeholder-img"
            height="250"
            preserveAspectRatio="xMidYMid slice"
            role="img"
            width="200"
            xmlns="http://www.w3.org/2000/svg">
            <title>Placeholder</title>
            <rect width="100%" height="100%" fill="#55595c"></rect>
            <text x="50%" y="50%" fill="#eceeef" dy=".3em">Thumbnail</text>
          </svg>
        </div>
      </div>
    </div>
  </div>
</div>


<div class="container" style="font-family: 'worksans sans-serif';">
  <section>
    <div class="d-flex align-items-center mb-3 mt-4">
      <i class="fas fa-layer-group text-success fa-2x me-2 mt-4 mb-4"></i>
      <h4 class="fw-bold mb-0 editable"
          data-model="home"
          data-model-id="0"
          data-key="modules_section_title"
          data-type="text">
        <?php echo e(getCustomContent('home', 'modules_section_title', 'Información y Módulos')); ?>

      </h4>
    </div>
    <hr>

    <div class="row g-4">

      
      <div class="col-md-3">
        <div class="card h-100 shadow-sm border-0 text-center">
          <div class="card-body">
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('centros.view')): ?>
            <a href="<?php echo e(route('centros.index')); ?>"><i class="bi bi-building fa-2x text-primary mb-2"></i></a>
            <?php else: ?>
            <a href="<?php echo e(route('public.centrosFormacion.index')); ?>"><i class="bi bi-building fa-2x text-primary mb-2"></i></a>
            <?php endif; ?>
            <h6 class="fw-bold editable"
                data-model="home"
                data-model-id="0"
                data-key="centros_title"
                data-type="text">
              <?php echo e(getCustomContent('home', 'centros_title', 'Centros')); ?>

            </h6>
            <p class="text-muted small editable"
               data-model="home"
               data-model-id="0"
               data-key="centros_description"
               data-type="text">
              <?php echo e(getCustomContent('home', 'centros_description', 'Centros de formación.')); ?>

            </p>
          </div>
        </div>
      </div>

      
      <div class="col-md-3">
        <div class="card h-100 shadow-sm border-0 text-center">
          <div class="card-body">
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('programas.view')): ?>
            <a href="<?php echo e(route('programas.index')); ?>"><i class="bi bi-journal-bookmark fa-2x text-success mb-2"></i></a>
            <?php else: ?>
            <a href="<?php echo e(route('public.programasDeFormacion.index')); ?>"><i class="bi bi-journal-bookmark fa-2x text-success mb-2"></i></a>
            <?php endif; ?>
            <h6 class="fw-bold editable"
                data-model="home"
                data-model-id="0"
                data-key="programas_title"
                data-type="text">
              <?php echo e(getCustomContent('home', 'programas_title', 'Programas')); ?>

            </h6>
            <p class="text-muted small editable"
               data-model="home"
               data-model-id="0"
               data-key="programas_description"
               data-type="text">
              <?php echo e(getCustomContent('home', 'programas_description', 'Programas educativos.')); ?>

            </p>
          </div>
        </div>
      </div>

      
      <div class="col-md-3">
        <div class="card h-100 shadow-sm border-0 text-center">
          <div class="card-body">
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('ofertas.view')): ?>
            <a href="<?php echo e(route('ofertas.index')); ?>"><i class="bi bi-mortarboard fa-2x text-warning mb-2"></i></a>
            <?php else: ?>
            <a href="<?php echo e(route('public.ofertasEducativas.index')); ?>"><i class="bi bi-mortarboard fa-2x text-warning mb-2"></i></a>
            <?php endif; ?>

            <h6 class="fw-bold editable"
                data-model="home"
                data-model-id="0"
                data-key="ofertas_title"
                data-type="text">
              <?php echo e(getCustomContent('home', 'ofertas_title', 'Ofertas')); ?>

            </h6>
            <p class="text-muted small editable"
               data-model="home"
               data-model-id="0"
               data-key="ofertas_description"
               data-type="text">
              <?php echo e(getCustomContent('home', 'ofertas_description', 'Ofertas educativas vigentes.')); ?>

            </p>
          </div>
        </div>
      </div>

      
      <?php $__currentLoopData = $noticias; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $noticia): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
      <div class="col-md-3">
        <div class="card h-100 shadow-sm border-0">
          <div class="card-body">
            <h6 class="fw-bold">
              <i class="bi bi-newspaper me-1 text-info"></i>
              <?php echo e($noticia->titulo); ?>

            </h6>
            <p class="text-muted small">
              <?php echo e(Str::limit($noticia->descripcion, 90)); ?>

            </p>
          </div>
        </div>
      </div>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

      
      <div class="col-md-3">
        <div class="card h-100 shadow-sm border-0 text-center">
          <div class="card-body">
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('instructores.view')): ?>
            <a href="<?php echo e(route('instructores.index')); ?>"><i class="fas fa-chalkboard-teacher fa-2x text-success mb-2"></i></a>
            <?php else: ?>
            <a href="<?php echo e(route('public.instructoresDeFormacion.index')); ?>"><i class="fas fa-chalkboard-teacher fa-2x text-success mb-2"></i></a>
            <?php endif; ?>
            <h6 class="fw-bold editable"
                data-model="home"
                data-model-id="0"
                data-key="instructores_title"
                data-type="text">
              <?php echo e(getCustomContent('home', 'instructores_title', 'Instructores')); ?>

            </h6>
            <p class="text-muted small editable"
               data-model="home"
               data-model-id="0"
               data-key="instructores_description"
               data-type="text">
              <?php echo e(getCustomContent('home', 'instructores_description', 'Perfil de nuestros instructores')); ?>

            </p>
          </div>
        </div>
      </div>

      
      <div class="col-md-3">
        <div class="card h-100 shadow-sm border-0 text-center">
          <div class="card-body">
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('historias_de_exito.view')): ?>
            <a href="<?php echo e(route('historias_de_exito.index')); ?>"><i class="fas fa-book-open fa-2x text-warning mb-2"></i></a>
            <?php else: ?>
            <a href="<?php echo e(route('public.historiasDeExito.index')); ?>"><i class="fas fa-book-open fa-2x text-warning mb-2"></i></a>
            <?php endif; ?>
            <h6 class="fw-bold editable"
                data-model="home"
                data-model-id="0"
                data-key="historias_title"
                data-type="text">
              <?php echo e(getCustomContent('home', 'historias_title', 'Historias')); ?>

            </h6>
            <p class="text-muted small editable"
               data-model="home"
               data-model-id="0"
               data-key="historias_description"
               data-type="text">
              <?php echo e(getCustomContent('home', 'historias_description', 'Conoce las experiencias que se viven en el Centro Agroempresarial y Turístico de los Andes')); ?>

            </p>
          </div>
        </div>
      </div>

      
      <div class="col-md-3">
        <div class="card h-100 shadow-sm border-0 text-center">
          <div class="card-body">
            <a href=""><i class="bi bi-award  fa-2x text-primary mb-2"></i></a>
            <h6 class="fw-bold editable"
                data-model="home"
                data-model-id="0"
                data-key="reconocimientos_title"
                data-type="text">
              <?php echo e(getCustomContent('home', 'reconocimientos_title', 'Reconocimientos')); ?>

            </h6>
            <p class="text-muted small editable"
               data-model="home"
               data-model-id="0"
               data-key="reconocimientos_description"
               data-type="text">
              <?php echo getCustomContent('home', 'reconocimientos_description', 'Conoce a nuestros aprendices mas destacados e inspirate a ser parte de nustra <span class="fw-bold mb-0">FAMILIA CATA</span>'); ?>

            </p>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>

<div style="font-family: 'worksans sans-serif';">
  <main class="container py-4">
    <div class="row mb-2">
      <div class="col">
        <h1 class="display-4 editable" data-model="home" data-model-id="0" data-key="blog_title" data-type="text">
          <?php echo getCustomContent('home', 'blog_title', 'Blog Home Page'); ?>

        </h1>
        <p class="lead text-body-secondary editable" data-model="home" data-model-id="0" data-key="blog_description" data-type="text">
          <?php echo getCustomContent('home', 'blog_description', 'An example blog homepage built with Bootstrap 5'); ?>

        </p>
      </div>
    </div>

    <div class="row g-5">
        <div class="col-md-8">
          <h3 class="pb-4 mb-4 fst-italic border-bottom editable" data-model="home" data-model-id="0" data-key="article1_subtitle" data-type="text">
            <?php echo getCustomContent('home', 'article1_title', 'From the Firehose' ); ?></h3>
          <article class="blog-post">
            <h2 class="display-5 link-body-emphasis mb-1 editable" data-model="home" data-model-id="0" data-key="article1_title" data-type="text">
              <?php echo getCustomContent('home', 'article1_title', 'Sample blog post'); ?>

            </h2>
            <p class="blog-post-meta editable" data-model="home" data-model-id="0" data-key="article1_meta" data-type="text">
              <?php echo getCustomContent('home', 'article1_meta', 'January 1, 2021 by <a href="#">Mark</a>'); ?>

            </p>
            <p class=" editable" data-model="home" data-model-id="0" data-key="article1_parrafo1" data-type="text">
              <?php echo e(getCustomContent('home', 'article1_parrafo1','This blog post shows a few different types of content that’s
              supported and styled with Bootstrap. Basic typography, lists,
              tables, images, code, and more are all supported as expected.')); ?>

            </p>
            <hr />
            <p class="editable" data-model="home" data-model-id="0" data-key="article1_parrafo2" data-type="text">
              <?php echo e(getCustomContent('home', 'article1_parrafo2', 'This is some additional paragraph placeholder content. It has been
              written to fill the available space and show how a longer snippet
              of text affects the surrounding content. We´ll repeat it often to
              keep the demonstration flowing, so be on the lookout for this
              exact same string of text.')); ?>

            </p>
            <h2 class="editable"
              data-model="home"
              data-model-id="0"
              data-key="article1_blockquotes"
              data-type="text"><?php echo e(getCustomContent('home', 'article1_blockquotes', 'Blockquotes')); ?></h2>
            <p class="editable"
              data-model="home"
              data-model-id="0"
              data-key="article1_blockquotes_p"
              data-type="text">
              <?php echo e(getCustomContent('home', 'article1_blockquotes_p', 'This is an example blockquote in action:')); ?>

            </p>
            <blockquote class="blockquote">
              <p class="editable"
                data-model="home"
                data-model-id="0"
                data-key="article1_blockquotes_p1"
                data-type="text"><?php echo e(getCustomContent('home', 'article1_blockquotes_p1', 'Quoted text goes here.')); ?></p>
            </blockquote>
            <p class="editable"
              data-model="home"
              data-model-id="0"
              data-key="article1_blockquotes_p2"
              data-type="text">
              <?php echo e(getCustomContent('home', 'article1_blockquotes_p2', 'This is some additional paragraph placeholder content. It has been
              written to fill the available space and show how a longer snippet
              of text affects the surrounding content. We´ll repeat it often to
              keep the demonstration flowing, so be on the lookout for this
              exact same string of text.')); ?>

            </p>
            <h3 class="editable"
              data-model="home"
              data-model-id="0"
              data-key="article1_subtitle2"
              data-type="text">
              <?php echo e(getCustomContent('home', 'article1_subtitle2', 'Example lists')); ?>

            </h3>
            <p
              class="editable"
              data-model="home"
              data-model-id="0"
              data-key="article1_parrafo3"
              data-type="text">
              <?php echo e(getCustomContent('home', 'article1_parrafo3', 'This is some additional paragraph placeholder content. It´s a
            slightly shorter version of the other highly repetitive body text
            used throughout. This is an example unordered list:')); ?>

            </p>
            <ul>
              <li
                class="editable"
                data-model="home"
                data-model-id="0"
                data-key="article1_item1"
                data-type="text">
                <?php echo e(getCustomContent('home', 'article1_item1', 'First list item')); ?>

              </li>
              <li class="editable"
                data-model="home"
                data-model-id="0"
                data-key="article1_item2"
                data-type="text">
                <?php echo e(getCustomContent('home', 'article1_item2', 'Second list item with a longer description')); ?>

              </li>
              <li class="editable"
                data-model="home"
                data-model-id="0"
                data-key="article1_item3"
                data-type="text"><?php echo e(getCustomContent('home', 'article1_item3', 'Third list item to close it out')); ?></li>
            </ul>
            <p
              class="editable"
              data-model="home"
              data-model-id="0"
              data-key="article1_listP"
              data-type="text"><?php echo e(getCustomContent('home', 'article1_listp', 'And this is an ordered list:')); ?></p>
            <ol>
              <li
              class="editable"
              data-model="home"
              data-model-id="0"
              data-key="article1_oitem1"
              data-type="text"><?php echo e(getCustomContent('home', 'article1_oitem1', 'First list item')); ?></li>
              <li
              class="editable"
              data-model="home"
              data-model-id="0"
              data-key="article1_oitem2"
              data-type="text"><?php echo e(getCustomContent('home', 'article1_oitem2', 'Second list item with a longer description')); ?></li>
              <li>Third list item to close it out</li>
            </ol>
            <p>And this is a definition list:</p>
            <dl>
              <dt>HyperText Markup Language (HTML)</dt>
              <dd>
                The language used to describe and define the content of a Web
                page
              </dd>
              <dt>Cascading Style Sheets (CSS)</dt>
              <dd>Used to describe the appearance of Web content</dd>
              <dt>JavaScript (JS)</dt>
              <dd>
                The programming language used to build advanced Web sites and
                applications
              </dd>
            </dl>
            <h2>Inline HTML elements</h2>
            <p>
              HTML defines a long list of available inline tags, a complete list
              of which can be found on the
              <a
                href="https://developer.mozilla.org/en-US/docs/Web/HTML/Element">Mozilla Developer Network</a>.
            </p>
            <ul>
              <li>
                <strong>To bold text</strong>, use
                <code class="language-plaintext highlighter-rouge">&lt;strong&gt;</code>.
              </li>
              <li>
                <em>To italicize text</em>, use
                <code class="language-plaintext highlighter-rouge">&lt;em&gt;</code>.
              </li>
              <li>
                Abbreviations, like
                <abbr title="HyperText Markup Language">HTML</abbr> should use
                <code class="language-plaintext highlighter-rouge">&lt;abbr&gt;</code>, with an optional
                <code class="language-plaintext highlighter-rouge">title</code>
                attribute for the full phrase.
              </li>
              <li>
                Citations, like <cite>— Mark Otto</cite>, should use
                <code class="language-plaintext highlighter-rouge">&lt;cite&gt;</code>.
              </li>
              <li>
                <del>Deleted</del> text should use
                <code class="language-plaintext highlighter-rouge">&lt;del&gt;</code>
                and <ins>inserted</ins> text should use
                <code class="language-plaintext highlighter-rouge">&lt;ins&gt;</code>.
              </li>
              <li>
                Superscript <sup>text</sup> uses
                <code class="language-plaintext highlighter-rouge">&lt;sup&gt;</code>
                and subscript <sub>text</sub> uses
                <code class="language-plaintext highlighter-rouge">&lt;sub&gt;</code>.
              </li>
            </ul>
            <p>
              Most of these elements are styled by browsers with few
              modifications on our part.
            </p>
            <h2>Heading</h2>
            <p>
              This is some additional paragraph placeholder content. It has been
              written to fill the available space and show how a longer snippet
              of text affects the surrounding content. We'll repeat it often to
              keep the demonstration flowing, so be on the lookout for this
              exact same string of text.
            </p>
            <h3>Sub-heading</h3>
            <p>
              This is some additional paragraph placeholder content. It has been
              written to fill the available space and show how a longer snippet
              of text affects the surrounding content. We'll repeat it often to
              keep the demonstration flowing, so be on the lookout for this
              exact same string of text.
            </p>
            <pre><code>Example code block</code></pre>
            <p>
              This is some additional paragraph placeholder content. It's a
              slightly shorter version of the other highly repetitive body text
              used throughout.
            </p>
          </article>
          <article class="blog-post">
            <h2 class="display-5 link-body-emphasis mb-1 editable" data-model="home" data-model-id="0" data-key="article2_title" data-type="text">
              <?php echo getCustomContent('home', 'article2_title', 'Another blog post'); ?>

            </h2>
            <p class="blog-post-meta editable" data-model="home" data-model-id="0" data-key="article2_meta" data-type="text">
              <?php echo getCustomContent('home', 'article2_meta', 'December 23, 2020 by <a href="#">Jacob</a>'); ?>

            </p>
            <p class="editable" data-model="home" data-model-id="0" data-key="article2_content" data-type="text">
              <?php echo getCustomContent('home', 'article2_content', 'This is some additional paragraph placeholder content. It has been
              written to fill the available space and show how a longer snippet of text affects the surrounding content. We\'ll repeat it often to
              keep the demonstration flowing, so be on the lookout for this
              exact same string of text.'); ?>

            </p>
            <blockquote class="editable" data-model="home" data-model-id="0" data-key="article2_quote" data-type="text">
              <p>
                Longer quote goes here, maybe with some
                <strong>emphasized text</strong> in the middle of it.
              </p>
            </blockquote>
            <p class="editable" data-model="home" data-model-id="0" data-key="article2_additional_content" data-type="text">
              <?php echo getCustomContent('home', 'article2_additional_content', 'This is some additional paragraph placeholder content. It has been
              written to fill the available space and show how a longer snippet of text affects the surrounding content. We\'ll repeat it often to
              keep the demonstration flowing, so be on the lookout for this
              exact same string of text.'); ?>

            </p>
            <p class="editable" data-model="home" data-model-id="0" data-key="article2_additional_content2" data-type="text">
              <?php echo getCustomContent('home', 'article2_additional_content2', 'This is some additional paragraph placeholder content. It has been
              written to fill the available space and show how a longer snippet of text affects the surrounding content. We\'ll repeat it often to
              keep the demonstration flowing, so be on the lookout for this
              exact same string of text.'); ?>

            </p>
            <h3>Example table</h3>
            <p>And don't forget about tables in these posts:</p>
            <table class="table">
              <thead>
                <tr>
                  <th>Name</th>
                  <th>Upvotes</th>
                  <th>Downvotes</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>Alice</td>
                  <td>10</td>
                  <td>11</td>
                </tr>
                <tr>
                  <td>Bob</td>
                  <td>4</td>
                  <td>3</td>
                </tr>
                <tr>
                  <td>Charlie</td>
                  <td>7</td>
                  <td>9</td>
                </tr>
              </tbody>
              <tfoot>
                <tr>
                  <td>Totals</td>
                  <td>21</td>
                  <td>23</td>
                </tr>
              </tfoot>
            </table>
            <p>
              This is some additional paragraph placeholder content. It's a
              slightly shorter version of the other highly repetitive body text
              used throughout.
            </p>
          </article>
          <article class="blog-post">
            <h2 class="display-5 link-body-emphasis mb-1 editable" data-model="home" data-model-id="0" data-key="article3_title" data-type="text">
              <?php echo getCustomContent('home', 'article3_title', 'New feature'); ?>

            </h2>
            <p class="blog-post-meta editable" data-model="home" data-model-id="0" data-key="article3_meta" data-type="text">
              <?php echo getCustomContent('home', 'article3_meta', 'December 14, 2020 by <a href="#">Chris</a>'); ?>

            </p>
            <p>
              This is some additional paragraph placeholder content. It has been
              written to fill the available space and show how a longer snippet
              of text affects the surrounding content. We'll repeat it often to
              keep the demonstration flowing, so be on the lookout for this
              exact same string of text.
            </p>
            <ul>
              <li>First list item</li>
              <li>Second list item with a longer description</li>
              <li>Third list item to close it out</li>
            </ul>
            <p>
              This is some additional paragraph placeholder content. It's a
              slightly shorter version of the other highly repetitive body text
              used throughout.
            </p>
          </article>
          <nav class="blog-pagination" aria-label="Pagination">
            <a class="btn btn-outline-primary rounded-pill" href="#">Older</a>
            <a
              class="btn btn-outline-secondary rounded-pill disabled"
              aria-disabled="true">Newer</a>
          </nav>
        </div>
        <div class="col-md-4">
          <div class="position-sticky" style="top: 2rem">
            <div class="p-4 mb-3 bg-body-tertiary rounded text-success">
              <h4 class="fst-italic editable" data-model="home" data-model-id="0" data-key="sidebar_about_title" data-type="text">
                <?php echo getCustomContent('home', 'sidebar_about_title', 'About'); ?>

              </h4>
              <p class="mb-0 editable" data-model="home" data-model-id="0" data-key="sidebar_about_text" data-type="text">
                <?php echo getCustomContent('home', 'sidebar_about_text', 'Customize this section to tell your visitors a little bit about your publication, writers, content, or something else entirely. Totally up to you.'); ?>

              </p>
            </div>
            <div>
              <h4 class="fst-italic editable" data-model="home" data-model-id="0" data-key="sidebar_recent_title" data-type="text">
                <?php echo getCustomContent('home', 'sidebar_recent_title', 'Recent posts'); ?>

              </h4>
              <ul class="list-unstyled">
                <li>
                  <a
                    class="d-flex flex-column flex-lg-row gap-3 align-items-start align-items-lg-center py-3 link-body-emphasis text-decoration-none border-top"
                    href="#">
                    <svg
                      aria-hidden="true"
                      class="bd-placeholder-img"
                      height="96"
                      preserveAspectRatio="xMidYMid slice"
                      width="100%"
                      xmlns="http://www.w3.org/2000/svg">
                      <rect width="100%" height="100%" fill="#777"></rect>
                    </svg>
                    <div class="col-lg-8">
                      <h6 class="mb-0">Example blog post title</h6>
                      <small class="text-body-secondary">January 15, 2024</small>
                    </div>
                  </a>
                </li>
                <li>
                  <a
                    class="d-flex flex-column flex-lg-row gap-3 align-items-start align-items-lg-center py-3 link-body-emphasis text-decoration-none border-top"
                    href="#">
                    <svg
                      aria-hidden="true"
                      class="bd-placeholder-img"
                      height="96"
                      preserveAspectRatio="xMidYMid slice"
                      width="100%"
                      xmlns="http://www.w3.org/2000/svg">
                      <rect width="100%" height="100%" fill="#777"></rect>
                    </svg>
                    <div class="col-lg-8">
                      <h6 class="mb-0">This is another blog post title</h6>
                      <small class="text-body-secondary">January 14, 2024</small>
                    </div>
                  </a>
                </li>
                <li>
                  <a
                    class="d-flex flex-column flex-lg-row gap-3 align-items-start align-items-lg-center py-3 link-body-emphasis text-decoration-none border-top"
                    href="#">
                    <svg
                      aria-hidden="true"
                      class="bd-placeholder-img"
                      height="96"
                      preserveAspectRatio="xMidYMid slice"
                      width="100%"
                      xmlns="http://www.w3.org/2000/svg">
                      <rect width="100%" height="100%" fill="#777"></rect>
                    </svg>
                    <div class="col-lg-8">
                      <h6 class="mb-0">
                        Longer blog post title: This one has multiple lines!
                      </h6>
                      <small class="text-body-secondary">January 13, 2024</small>
                    </div>
                  </a>
                </li>
              </ul>
            </div>
            <div class="p-4">
              <h4 class="fst-italic editable" data-model="home" data-model-id="0" data-key="sidebar_archives_title" data-type="text">
                <?php echo getCustomContent('home', 'sidebar_archives_title', 'Archives'); ?>

              </h4>
              <ol class="list-unstyled mb-0">
                <li><a href="#">March 2021</a></li>
                <li><a href="#">February 2021</a></li>
                <li><a href="#">January 2021</a></li>
                <li><a href="#">December 2020</a></li>
                <li><a href="#">November 2020</a></li>
                <li><a href="#">October 2020</a></li>
                <li><a href="#">September 2020</a></li>
                <li><a href="#">August 2020</a></li>
                <li><a href="#">July 2020</a></li>
                <li><a href="#">June 2020</a></li>
                <li><a href="#">May 2020</a></li>
                <li><a href="#">April 2020</a></li>
              </ol>
            </div>
            <div class="p-4">
              <h4 class="fst-italic editable" data-model="home" data-model-id="0" data-key="sidebar_elsewhere_title" data-type="text">
                <?php echo getCustomContent('home', 'sidebar_elsewhere_title', 'Elsewhere'); ?>

              </h4>
              <ol class="list-unstyled">
                <li><a href="#">GitHub</a></li>
                <li><a href="#">Social</a></li>
                <li><a href="#">Facebook</a></li>
              </ol>
            </div>
          </div>
        </div>
      </div>
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

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.bootstrap', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Saave\Documents\project\SOES\SoeSoftware2\resources\views/home.blade.php ENDPATH**/ ?>