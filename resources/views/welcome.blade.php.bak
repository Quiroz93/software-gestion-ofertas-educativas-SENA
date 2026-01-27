<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Sistema de Gestión de Ofertas Educativas | SENA</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    {{-- Favicon --}}
    <link rel="icon" href="{{ asset('favicons/favicon.ico') }}" type="image/x-icon">

    {{-- Bootstrap 5 --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    {{-- Bootstrap Icons --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
</head>

<body>

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">

            <!-- Logo -->
            <a href="{{ route('dashboard') }}" class="d-flex align-items-center me-2">
                <span class="brand-image">
                    {!! file_get_contents(public_path('images/logosimbolo-SENA.svg')) !!}
                </span>
            </a>

            <style>
                .brand-image svg {
                    width: 40px;
                    height: 40px;
                    color: #39A900;
                    margin-right: 1rem;
                }
            </style>

            <a class="navbar-brand text-white" href="#" style="font-size:1rem;">
                SOE | SENA
            </a>

            <!-- Responsive -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarAuth">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarAuth">
                <div class="ms-auto d-flex flex-wrap gap-3 align-items-center">

                    <ul class="navbar-nav flex-row gap-3 small">
                        <li class="nav-item">
                            <a class="nav-link text-white text-decoration-underline hover-sena" href="#">Inicio</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white text-decoration-underline hover-sena" href="#">Servicios</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white text-decoration-underline hover-sena" href="#">Contacto</a>
                        </li>
                    </ul>

                    <a href="{{ route('login') }}" class="btn btn-outline-primary btn-sm">
                        <i class="bi bi-box-arrow-in-right me-1"></i> Iniciar sesión
                    </a>

                    <a href="{{ route('register') }}" class="btn btn-outline-success btn-sm">
                        <i class="bi bi-person-plus me-1"></i> Registrarse
                    </a>
                </div>
            </div>
        </div>
    </nav>

    {{-- HERO --}}
    <section class="hero">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10">

                    <div class="hero-card text-center">

                        <h1 class="fw-bold mb-3 mt-5">
                            Sistema de Ofertas Educativas SENA - CATA
                        </h1>

                        <p class="text-muted fs-5 mb-4">
                            Plataforma institucional para la administración, control y publicación
                            de ofertas educativas del SENA - Santander.
                        </p>

                        {{-- Carousel --}}
                        <div id="carouselExampleIndicators" class="carousel slide mb-5">
                            <div class="carousel-indicators">
                                <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active"></button>
                                <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1"></button>
                                <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2"></button>
                            </div>

                            <div class="carousel-inner rounded">
                                <div class="carousel-item active">
                                    <img src="{{ asset('') }}" class="d-block w-100" alt="Imagen 1">
                                </div>
                                <div class="carousel-item">
                                    <img src="{{ asset('') }}" class="d-block w-100" alt="Imagen 2">
                                </div>
                                <div class="carousel-item">
                                    <img src="{{ asset('') }}" class="d-block w-100" alt="Imagen 3">
                                </div>
                            </div>

                            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
                                <span class="carousel-control-prev-icon"></span>
                            </button>
                            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
                                <span class="carousel-control-next-icon"></span>
                            </button>
                        </div>

                        {{-- Noticias --}}
                        <section class="py-5">
                            <div class="container">
                                <h2 class="text-center fw-bold mb-4">Últimas Noticias</h2>
                                <div class="row">
                                    @if(isset($noticias) && $noticias->count() > 0)
                                        @foreach($noticias as $noticia)
                                            <div class="col-md-3 mb-4">
                                                <div class="card h-100">
                                                    @if($noticia->imagen)
                                                        <img src="{{ asset('storage/' . $noticia->imagen) }}" class="card-img-top" alt="{{ $noticia->titulo }}">
                                                    @endif
                                                    <div class="card-body">
                                                        <h5 class="card-title">{{ $noticia->titulo }}</h5>
                                                        <p class="card-text">{{ Str::limit($noticia->contenido, 100) }}</p>
                                                    </div>
                                                    <div class="card-footer">
                                                        <a href="#" class="btn btn-primary btn-sm">Leer más</a>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    @else
                                        <div class="col">
                                            <p class="text-center text-muted">No hay noticias disponibles en este momento.</p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </section>

                        {{-- Ofertas --}}
                        <section class="py-5 bg-light">
                            <div class="container">
                                <h2 class="text-center fw-bold mb-4">Ofertas Educativas Recientes</h2>
                                <div class="row">
                                    @if(isset($ofertas) && $ofertas->count() > 0)
                                        @foreach($ofertas as $oferta)
                                            <div class="col-md-3 mb-4">
                                                <div class="card h-100">
                                                    <div class="card-body">
                                                        <h5 class="card-title">{{ $oferta->nombre }}</h5>
                                                        <p class="card-text">{{ Str::limit($oferta->descripcion, 100) }}</p>
                                                    </div>
                                                    <div class="card-footer">
                                                        <a href="#" class="btn btn-success btn-sm">Ver oferta</a>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    @else
                                        <div class="col">
                                            <p class="text-center text-muted">No hay ofertas disponibles en este momento.</p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </section>

                        {{-- Características --}}
                        <div class="row g-4">

                            <div class="col-md-3">
                                <i class="bi bi-building feature-icon"></i>
                                <h6 class="fw-bold">Centros</h6>
                                <p class="text-muted small">Gestión de centros de formación.</p>
                            </div>

                            <div class="col-md-3">
                                <i class="bi bi-journal-bookmark feature-icon"></i>
                                <h6 class="fw-bold">Programas</h6>
                                <p class="text-muted small">Administración de programas educativos.</p>
                            </div>

                            <div class="col-md-3">
                                <i class="bi bi-mortarboard feature-icon"></i>
                                <h6 class="fw-bold">Ofertas</h6>
                                <p class="text-muted small">Control de ofertas educativas vigentes.</p>
                            </div>

                            <div class="col-md-3">
                                <i class="bi bi-newspaper feature-icon"></i>
                                <h6 class="fw-bold">Noticias</h6>
                                <p class="text-muted small">Últimas noticias y novedades.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    {{-- FOOTER --}}
    <footer class="bg-light py-5">
        <div class="container">
            <div class="row">
                <div class="col-md-3">
                    <h5>Centro</h5>
                    <ul class="list-unstyled">
                        <li><a href="#" class="text-decoration-none text-muted">Sobre nosotros</a></li>
                        <li><a href="#" class="text-decoration-none text-muted">Programas</a></li>
                        <!-- more links -->
                    </ul>
                </div>
                <div class="col-md-3">
                    <h5>Servicios</h5>
                    <ul class="list-unstyled">
                        <li><a href="#" class="text-decoration-none text-muted">Características</a></li>
                        <li><a href="#" class="text-decoration-none text-muted">información</a></li>
                        <!-- more links -->
                    </ul>
                </div>
                <div class="col-md-3">
                    <h5>Recursos</h5>
                    <ul class="list-unstyled">
                        <li><a href="#" class="text-decoration-none text-muted">Blog</a></li>
                        <li><a href="#" class="text-decoration-none text-muted">Centro de ayuda</a></li>
                        <!-- more links -->
                    </ul>
                </div>
                <div class="col-md-3">
                    <h5>Contactanos</h5>
                    <p class="text-muted">Cra. 11 No. 13-13</p>
                    <p class="text-muted">Linea de atención: 018000 910270</p>
                    <p class="text-muted">Email: servicioalciudadano@sena.udu.co</p>
                </div>
            </div>
            <div class="row mt-4">
                <div class="col">
                    <p class="text-center text-muted border-top pt-3">&copy; 2026 SENA, Centro Agroempresarial y Turístico de los Andes.</p>
                </div>
            </div>
        </div>
    </footer>
</body>

</html>