<?php $__env->startSection('title', 'Sistema de ofertas educativas SENA-CATA'); ?>
<?php $__env->startSection('hide_navbar', true); ?>
<?php $__env->startSection('hide_footer', true); ?>

<?php $__env->startPush('styles'); ?>
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/public/home.css']); ?>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
    <nav id="navbar">
        <div class="nav-container">
            <a href="#home" class="logo-link">
                <img class="logo-svg" src="<?php echo e(asset('images/logosimbolo-SENA.svg')); ?>" alt="Logo SENA">
                <span class="logo-text">SENA</span>
            </a>
            <ul class="nav-links">
                <li><a href="#home" class="nav-link active">Inicio</a></li>
                <li><a href="#collections" class="nav-link">Programas</a></li>
                <li><a href="#featured" class="nav-link">Ofertas</a></li>
                <li><a href="#contact" class="nav-link">Contacto</a></li>
                <li><a href="#noticias" class="nav-link">Noticias</a></li>
                <li><a href="#nosotros" class="nav-link">Nosotros</a></li>
                <li><a href="#eventos" class="nav-link">Eventos</a></li>
                <?php if(auth()->guard()->guest()): ?>
                    <li><a href="<?php echo e(route('login')); ?>" class="nav-cta">Ingresar</a></li>
                    <li><a href="<?php echo e(route('register')); ?>" class="nav-cta">Registrarse</a></li>
                <?php endif; ?>
                <?php if(auth()->guard()->check()): ?>
                    <?php echo $__env->make('partials.user-menu', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                <?php endif; ?>
            </ul>
            <div class="menu-toggle" id="menuToggle">
                <span></span>
                <span></span>
                <span></span>
            </div>
        </div>
    </nav>
    <div class="mobile-nav" id="mobileNav">
        <ul class="mobile-nav-links">
            <li><a href="#home">Inicio</a></li>
            <li><a href="#collections">Programas</a></li>
            <li><a href="#featured">Ofertas</a></li>
            <li><a href="#contact">Contacto</a></li>
            <li><a href="#noticias">Noticias</a></li>
            <li><a href="#nosotros">Nosotros</a></li>
            <li><a href="#eventos">Eventos</a></li>
            <?php if(auth()->guard()->guest()): ?>
                <li><a href="<?php echo e(route('login')); ?>">Ingresar</a></li>
                <li><a href="<?php echo e(route('register')); ?>">Registrarse</a></li>
            <?php endif; ?>
        </ul>
    </div>

    <section class="hero" id="home">
        <div class="hero-bg"></div>
        <div class="hero-container">
            <div class="hero-left">
                <div class="hero-badge">Convocatoria 2026 abierta</div>
                <h1 class="hero-title">
                    <span class="line"><span>Impulsa</span></span>
                    <span class="line"><span>Tu <span class="accent">Futuro</span></span></span>
                    <span class="line"><span>Aprende Hoy</span></span>
                </h1>
                <p class="hero-description">
                    Inscribete a la nueva oferta educativa 2026: programas tecnicos, tecnologicos y cursos cortos con enfoque practico. Aprende con instructores expertos, desarrolla proyectos reales y accede a rutas formativas que te conectan con el empleo. Explora las opciones y reserva tu cupo.
                </p>
                <div class="hero-stats">
                    <div class="stat">
                        <span class="stat-number">120+</span>
                        <span class="stat-label">Programas Activos</span>
                    </div>
                    <div class="stat">
                        <span class="stat-number">35+</span>
                        <span class="stat-label">Empresas Aliadas</span>
                    </div>
                    <div class="stat">
                        <span class="stat-number">90%</span>
                        <span class="stat-label">Insercion Laboral</span>
                    </div>
                </div>
                <div class="cta-group">
                    <a href="#collections" class="cta-button primary">Explorar Programas</a>
                    <a href="#featured" class="cta-button outline">Ver Ofertas</a>
                </div>
            </div>
            <div class="hero-right <?php echo e($slides->isEmpty() ? 'logo-only' : ''); ?>">
                <div class="hero-image-wrapper">
                    <div class="hero-carousel">
                        <?php if($slides->isNotEmpty()): ?>
                            <?php $__currentLoopData = $slides; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $slide): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="carousel-slide <?php echo e($loop->first ? 'active' : ''); ?>">
                                    <img src="<?php echo e(asset('storage/' . $slide->image_path)); ?>" alt="<?php echo e($slide->title); ?>">
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php else: ?>
                            <div class="carousel-slide active is-logo">
                                <img class="carousel-logo" src="<?php echo e(asset('images/logosimbolo-SENA.svg')); ?>" alt="Logo SENA">
                            </div>
                        <?php endif; ?>
                        <div class="carousel-overlay"></div>
                        <div class="carousel-indicators">
                            <?php if($slides->isNotEmpty()): ?>
                                <?php $__currentLoopData = $slides; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $slide): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <span class="indicator <?php echo e($loop->first ? 'active' : ''); ?>" data-slide="<?php echo e($loop->index); ?>"></span>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php else: ?>
                                <span class="indicator active" data-slide="0"></span>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="floating-tags">
                        <div class="tag">Cupos Limitados</div>
                        <div class="tag">Practica Real</div>
                        <div class="tag">Certificacion Oficial</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="scroll-indicator">
            <span></span>
        </div>
    </section>

    <section class="collections" id="collections">
        <div class="section-header">
            <h2 class="section-title">Programas Destacados</h2>
            <p class="section-subtitle">Explora rutas formativas con alta empleabilidad y cupos limitados</p>
            <p class="section-subtitle">Recomendado: programas tecnicos, tecnologicos y cursos cortos con enfoque practico</p>
        </div>
        
        <div class="category-tabs">
            <button class="tab-btn active" data-category="all">Todos</button>
            <button class="tab-btn" data-category="operario">Operario</button>
            <button class="tab-btn" data-category="tecnico">Tecnico</button>
            <button class="tab-btn" data-category="tecnologo">Tecnologo</button>
        </div>

        <div class="grid" id="collectionsGrid">
            <?php $__empty_1 = true; $__currentLoopData = $featuredProgramas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $programa): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <?php
                    $nivel = $programa->nivelFormacion->nombre ?? 'Programa';
                    $categoria = \Illuminate\Support\Str::slug($nivel);
                ?>
                <div class="collection-card" data-category="<?php echo e($categoria); ?>">
                    <div class="collection-thumbnail">
                        <img src="<?php echo e(asset('images/hero-image.png')); ?>" alt="<?php echo e($programa->nombre); ?>">
                    </div>
                    <div class="card-content">
                        <span class="card-badge"><?php echo e($nivel); ?></span>
                        <h3 class="card-title"><?php echo e($programa->nombre); ?></h3>
                        <p class="card-subtitle">
                            <?php if($programa->numero_ficha): ?>
                                Ficha <?php echo e($programa->numero_ficha); ?> •
                            <?php endif; ?>
                            <?php if($programa->duracion_meses): ?>
                                <?php echo e($programa->duracion_meses); ?> meses •
                            <?php endif; ?>
                            <?php if($programa->cupos): ?>
                                Cupos <?php echo e($programa->cupos); ?> •
                            <?php endif; ?>
                            <?php echo e($programa->modalidad ?? 'Presencial'); ?>

                        </p>
                        <p class="card-price">Formación 100% gratuita</p>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <div class="collection-card" data-category="all">
                    <div class="collection-thumbnail">
                        <img src="<?php echo e(asset('images/logosimbolo-SENA.svg')); ?>" alt="SENA">
                    </div>
                    <div class="card-content">
                        <span class="card-badge">SENA</span>
                        <h3 class="card-title">Programas en actualizacion</h3>
                        <p class="card-subtitle">Muy pronto publicaremos nuevas ofertas educativas.</p>
                        <p class="card-price">Formación 100% gratuita</p>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </section>

    <section class="featured" id="featured">
        <div class="featured-container">
            <div class="featured-hero">
                <div class="featured-content">
                    <span class="label">Oferta educativa</span>
                    <h2>Formacion con sentido productivo</h2>
                    <p>En el SENA unimos formacion tecnica, tecnologia y cursos cortos con enfoque practico. Construye competencias reales, participa en proyectos aplicados y accede a rutas formativas alineadas a las necesidades del territorio.</p>

                    <div class="feature-highlights">
                        <div class="highlight-item">
                            <div class="highlight-icon">✔</div>
                            <div class="highlight-title">Formacion gratuita</div>
                            <div class="highlight-desc">Programas sin costo para el aprendiz, con calidad institucional.</div>
                        </div>
                        <div class="highlight-item">
                            <div class="highlight-icon">🏢</div>
                            <div class="highlight-title">Vinculo con empresas</div>
                            <div class="highlight-desc">Aprendizaje conectado a sectores productivos y empleabilidad.</div>
                        </div>
                        <div class="highlight-item">
                            <div class="highlight-icon">🎓</div>
                            <div class="highlight-title">Certificacion oficial</div>
                            <div class="highlight-desc">Reconocimiento SENA para fortalecer tu perfil profesional.</div>
                        </div>
                    </div>

                    <a href="#collections" class="feature-cta">Conocer programas</a>
                </div>

                <div class="featured-image-section">
                    <div class="featured-image-grid">
                        <div class="featured-img">
                            <img src="<?php echo e(asset('images/oferta1.jpeg')); ?>" alt="Oferta educativa SENA">
                        </div>
                        <div class="featured-img">
                            <img src="<?php echo e(asset('images/oferta2.jpeg')); ?>" alt="Formacion practica">
                        </div>
                        <div class="featured-img">
                            <img src="<?php echo e(asset('images/oferta3.jpeg')); ?>" alt="Aprendizaje aplicado">
                        </div>
                    </div>
                </div>
            </div>

            <div class="testimonials">
                <div class="testimonials-header">
                    <h3>Historias de formacion</h3>
                    <p class="section-subtitle">Experiencias reales de aprendices y egresados</p>
                </div>

                <div class="testimonials-grid">
                    <div class="testimonial-card">
                        <div class="testimonial-rating">★★★★★</div>
                        <div class="testimonial-quote">
                            "El programa me dio bases solidas y confianza para iniciar mi vida laboral. La formacion practica fue clave."
                        </div>
                        <div class="testimonial-author">
                            <div class="author-avatar">L</div>
                            <div class="author-info">
                                <h4>Laura Gomez</h4>
                                <p>Aprendiz SENA</p>
                            </div>
                        </div>
                    </div>

                    <div class="testimonial-card">
                        <div class="testimonial-rating">★★★★★</div>
                        <div class="testimonial-quote">
                            "La articulacion con empresas nos permitio aplicar lo aprendido en entornos reales."
                        </div>
                        <div class="testimonial-author">
                            <div class="author-avatar">M</div>
                            <div class="author-info">
                                <h4>Mateo Rodriguez</h4>
                                <p>Egresado</p>
                            </div>
                        </div>
                    </div>

                    <div class="testimonial-card">
                        <div class="testimonial-rating">★★★★★</div>
                        <div class="testimonial-quote">
                            "La formacion fue integral, con instructores comprometidos y contenidos actualizados."
                        </div>
                        <div class="testimonial-author">
                            <div class="author-avatar">A</div>
                            <div class="author-info">
                                <h4>Ana Perez</h4>
                                <p>Aprendiz SENA</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="collections" id="noticias">
        <div class="section-header">
            <h2 class="section-title">Noticias del Centro</h2>
            <p class="section-subtitle">Actualidad institucional del Centro Agroempresarial y Turistico de los Andes</p>
        </div>

        <div class="grid">
            <?php $__empty_1 = true; $__currentLoopData = $noticias->take(3); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $noticia): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <?php
                    $fallbackImages = ['images/oferta1.jpeg', 'images/oferta2.jpeg', 'images/oferta3.jpeg'];
                    $fallbackImage = asset($fallbackImages[$loop->index % count($fallbackImages)]);
                    $noticiaImage = $noticia->imagen ? asset('storage/' . $noticia->imagen) : $fallbackImage;
                ?>
                <div class="collection-card">
                    <div class="collection-thumbnail">
                        <img src="<?php echo e($noticiaImage); ?>" alt="<?php echo e($noticia->titulo); ?>">
                    </div>
                    <div class="card-content">
                        <span class="card-badge">Noticia</span>
                        <h3 class="card-title"><?php echo e($noticia->titulo_medio); ?></h3>
                        <p class="card-subtitle">
                            <?php echo e($noticia->created_at?->format('d/m/Y') ?? 'Fecha por confirmar'); ?>

                        </p>
                        <a class="card-price" href="<?php echo e(route('public.ultimaNoticias.show', ['ultimaNoticia' => $noticia->id])); ?>">Leer noticia</a>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <div class="collection-card">
                    <div class="collection-thumbnail">
                        <img src="<?php echo e(asset('images/oferta1.jpeg')); ?>" alt="Noticias SENA">
                    </div>
                    <div class="card-content">
                        <span class="card-badge">Noticias</span>
                        <h3 class="card-title">Sin novedades publicadas</h3>
                        <p class="card-subtitle">Muy pronto compartiremos noticias del centro</p>
                        <a class="card-price" href="<?php echo e(route('public.ultimaNoticias.index')); ?>">Ver todas las noticias</a>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </section>

    <section class="collections" id="nosotros">
        <div class="section-header">
            <h2 class="section-title">Nosotros</h2>
            <p class="section-subtitle">Formacion gratuita y pertinente para el territorio</p>
        </div>

        <div class="grid">
            <div class="collection-card">
                <div class="collection-thumbnail">
                    <img src="<?php echo e(asset('images/hero-image.png')); ?>" alt="Mision institucional">
                </div>
                <div class="card-content">
                    <span class="card-badge">Mision</span>
                    <h3 class="card-title">Talento humano con sentido productivo</h3>
                    <p class="card-subtitle">Formacion tecnica, tecnologica y cursos cortos</p>
                    <a class="card-price" href="<?php echo e(route('public.centrosFormacion.index')); ?>">Conoce el centro</a>
                </div>
            </div>

            <div class="collection-card">
                <div class="collection-thumbnail">
                    <img src="<?php echo e(asset('images/oferta2.jpeg')); ?>" alt="Vision institucional">
                </div>
                <div class="card-content">
                    <span class="card-badge">Vision</span>
                    <h3 class="card-title">Innovacion aplicada y pertinente</h3>
                    <p class="card-subtitle">Enfoque agroempresarial y turistico</p>
                    <a class="card-price" href="<?php echo e(route('public.redesDeConocimiento.index')); ?>">Ver redes</a>
                </div>
            </div>

            <div class="collection-card">
                <div class="collection-thumbnail">
                    <img src="<?php echo e(asset('images/oferta1.jpeg')); ?>" alt="Bienestar y acompanamiento">
                </div>
                <div class="card-content">
                    <span class="card-badge">Bienestar</span>
                    <h3 class="card-title">Acompanamiento integral</h3>
                    <p class="card-subtitle">Orientacion, bienestar y servicios al aprendiz</p>
                    <a class="card-price" href="<?php echo e(route('public.instructoresDeFormacion.index')); ?>">Conoce el equipo</a>
                </div>
            </div>
        </div>
    </section>

    <section class="collections" id="eventos">
        <div class="section-header">
            <h2 class="section-title">Eventos y Jornadas</h2>
            <p class="section-subtitle">Encuentros para impulsar tu formacion</p>
        </div>

        <div class="grid">
            <?php $__empty_1 = true; $__currentLoopData = $eventos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $evento): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <?php
                    $fallbackImages = ['images/oferta3.jpeg', 'images/oferta1.jpeg', 'images/oferta2.jpeg'];
                    $fallbackImage = asset($fallbackImages[$loop->index % count($fallbackImages)]);
                    $imagenContent = $evento->customContents->firstWhere('key', 'imagen');
                    $imagenAlt = $evento->customContents->firstWhere('key', 'imagen_alt')?->value;
                    $imagenTitle = $evento->customContents->firstWhere('key', 'imagen_title')?->value;
                    $imagenUrl = $imagenContent?->value;

                    if ($imagenUrl && str_starts_with($imagenUrl, 'media/')) {
                        $imagenUrl = asset('storage/' . $imagenUrl);
                    }

                    $imagenUrl = $imagenUrl ?: $fallbackImage;
                    $fechaInicio = $evento->fecha_inicio?->format('d/m/Y');
                    $fechaFin = $evento->fecha_fin?->format('d/m/Y');
                    $rangoFechas = $fechaInicio ? $fechaInicio . ($fechaFin ? ' - ' . $fechaFin : '') : 'Fecha por confirmar';
                ?>
                <div class="collection-card">
                    <div class="collection-thumbnail">
                        <img src="<?php echo e($imagenUrl); ?>" alt="<?php echo e($imagenAlt ?? $evento->nombre); ?>" title="<?php echo e($imagenTitle ?? $evento->nombre); ?>">
                    </div>
                    <div class="card-content">
                        <span class="card-badge">Agenda</span>
                        <h3 class="card-title"><?php echo e($evento->nombre); ?></h3>
                        <p class="card-subtitle"><?php echo e($rangoFechas); ?></p>
                        <a class="card-price" href="<?php echo e(route('public.ofertasEducativas.show', $evento)); ?>">Ver detalles</a>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <div class="collection-card">
                    <div class="collection-thumbnail">
                        <img src="<?php echo e(asset('images/oferta2.jpeg')); ?>" alt="Eventos SENA">
                    </div>
                    <div class="card-content">
                        <span class="card-badge">Eventos</span>
                        <h3 class="card-title">Agenda por publicar</h3>
                        <p class="card-subtitle">Te avisaremos proximamente</p>
                        <a class="card-price" href="<?php echo e(route('public.ofertasEducativas.index')); ?>">Ver ofertas</a>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </section>

    <section class="contact" id="contact">
        <div class="contact-container">
            <div class="contact-header">
                <h2 class="section-title">Contacto SENA</h2>
                <p class="section-subtitle">Estamos para orientarte en tu proceso de formacion</p>
            </div>

            <div class="contact-content">
                <div class="contact-form-wrapper">
                    <form id="contactForm">
                        <div class="form-row">
                            <div class="form-group">
                                <label for="firstName">Nombres</label>
                                <input type="text" id="firstName" name="firstName" placeholder="Juan" required>
                            </div>
                            <div class="form-group">
                                <label for="lastName">Apellidos</label>
                                <input type="text" id="lastName" name="lastName" placeholder="Perez" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="email">Correo</label>
                            <input type="email" id="email" name="email" placeholder="juan@correo.com" required>
                        </div>
                        <div class="form-group">
                            <label for="subject">Asunto</label>
                            <input type="text" id="subject" name="subject" placeholder="Informacion de programas" required>
                        </div>
                        <div class="form-group">
                            <label for="message">Mensaje</label>
                            <textarea id="message" name="message" placeholder="Cuéntanos en que podemos ayudarte" required></textarea>
                        </div>
                        <button type="submit" class="form-submit">Enviar mensaje</button>
                    </form>
                </div>

                <div class="contact-info">
                    <div class="info-item">
                        <div class="info-icon">S</div>
                        <div class="info-content">
                            <h3>Centro de formacion</h3>
                            <p>Cra. 11 No. 13-13<br>
                            Centro Agroempresarial y Turistico de los Andes</p>
                        </div>
                    </div>

                    <div class="info-item">
                        <div class="info-icon">T</div>
                        <div class="info-content">
                            <h3>Lineas de atencion</h3>
                            <p>Linea nacional: <a href="tel:018000910270">018000 910270</a><br>
                            Horario: Lun-Vie, 8AM-5PM</p>
                        </div>
                    </div>

                    <div class="info-item">
                        <div class="info-icon">@</div>
                        <div class="info-content">
                            <h3>Correo institucional</h3>
                            <p>Atencion: <a href="mailto:servicioalciudadano@sena.edu.co">servicioalciudadano@sena.edu.co</a><br>
                            Soporte: <a href="mailto:soporte@sena.edu.co">soporte@sena.edu.co</a></p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="map-section">
                <div class="map-container">
                    <iframe src="https://www.google.com/maps?q=Carrera%2011%20No.%2013%20-%2013%2C%20Barrio%20Ricaurte&output=embed" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                </div>
            </div>
        </div>
    </section>

    <footer>
        <div class="footer-content">
            <div class="footer-brand">
                <h3>SENA</h3>
                <p>Sistema de ofertas educativas con formacion gratuita, pertinente y de calidad para el desarrollo del talento humano.</p>
                <div class="social-links">
                    <a class="social-link" href="https://www.sena.edu.co" aria-label="Sitio SENA">
                        <i class="bi bi-globe"></i>
                    </a>
                    <a class="social-link" href="https://www.instagram.com/senacomunica" aria-label="Instagram SENA">
                        <i class="bi bi-instagram"></i>
                    </a>
                    <a class="social-link" href="https://www.facebook.com/SENA" aria-label="Facebook SENA">
                        <i class="bi bi-facebook"></i>
                    </a>
                    <a class="social-link" href="https://www.youtube.com/user/SENATV" aria-label="YouTube SENA">
                        <i class="bi bi-youtube"></i>
                    </a>
                </div>
            </div>

            <div class="footer-column">
                <h4>Oferta Educativa</h4>
                <ul>
                    <li><a href="#collections">Programas</a></li>
                    <li><a href="#featured">Ofertas</a></li>
                    <li><a href="#contact">Contacto</a></li>
                </ul>
            </div>

            <div class="footer-column">
                <h4>Atencion al Ciudadano</h4>
                <ul>
                    <li><a href="https://www.sena.edu.co/es-co/Paginas/default.aspx">Portal SENA</a></li>
                    <li><a href="https://www.sena.edu.co/es-co/atencion-al-ciudadano">Canales de atencion</a></li>
                    <li><a href="https://www.sena.edu.co/es-co/transparencia">Transparencia</a></li>
                </ul>
            </div>

            <div class="footer-column">
                <h4>Contacto</h4>
                <ul>
                    <li>Cra. 11 No. 13-13, Barrio Ricaurte</li>
                    <li>Linea nacional: 018000 910270</li>
                    <li><a href="mailto:servicioalciudadano@sena.edu.co">servicioalciudadano@sena.edu.co</a></li>
                </ul>
            </div>
        </div>

        <div class="footer-bottom">
            <span>Copyright © 2026 SENA</span>
            <span>Centro Agroempresarial y Turistico de los Andes</span>
        </div>
    </footer>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.bootstrap', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Saave\Documents\project\SOES\SoeSoftware2\resources\views/public/home.blade.php ENDPATH**/ ?>