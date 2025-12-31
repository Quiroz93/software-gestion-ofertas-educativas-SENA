<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Sistema de Gestión de Ofertas Educativas | SENA</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    {{-- Bootstrap (puedes cambiar a Vite si ya lo tienes compilado) --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    {{-- Iconos --}}
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">

</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        
    <div class="container">

        <!-- Logo / Nombre -->
        <a href="{{ route('dashboard') }}" class="brand-link">
    <span class="brand-image">
        {!! file_get_contents(public_path('images/logosimbolo-SENA.svg')) !!}
    </span>
    {{--estilo del logo--}}
    <style>
        .brand-image svg {
            width: 40px;
            height: 40px;
            display: block;
            color: #39A900; 
            margin-right: 1.8rem/* Verde SENA */
        }
    </style>
</a>
        <a class="navbar-brand " href="#" style="color:#ffff ;font-size:1rem;font-family:worksans, sans-serif;">
            SOE | SENA
        </a>
        

        <!-- Botón responsive -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarAuth" aria-controls="navbarAuth"
                aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Contenido -->
        <div class="collapse navbar-collapse" id="navbarAuth">

            <!-- Espaciador para centrar -->
            <div class="ms-auto">
                <div class="d-flex gap-3 flex-wrap">

                    <ul class="navbar-nav flex-row gap-3" style="font-size:12px; font-family:worksans,sans-serif">
                        <li class="nav-item">
                            <a class="nav-link text-decoration-underline texto-hover" href="#">Inicio</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-decoration-underline texto-hover" href="#">Servicios</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-decoration-underline texto-hover" href="#">Contacto</a>
                        </li>
                    </ul>
                    <style>
                        .texto-hover {
                            color:#ffff ;
                            transition: color 0.3s ease;
                        }

                        .texto-hover:hover {
                            color: #39A900; /* azul */
                        }   
                    </style>

                    <a href="{{ route('login') }}" class="btn btn-primary btn-sm">
                        <i class="fas fa-sign-in-alt me-2"></i> Iniciar sesión
                    </a>

                    <a href="{{ route('register') }}" class="btn btn-outline-success btn-sm">
                        <i class="fas fa-user-plus me-2"></i> Registrarse
                    </a>

                </div>
            </div>

        </div>
    </div>
</nav>
{{-- HERO --}}
<section class="hero  align-items-center">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">

                <div class="hero-card text-center">

                    <h1 class="fw-bold mb-3">
                        Sistema de Ofertas Educativas
                    </h1>

                    <p class="text-muted fs-5 mb-4">
                        Plataforma institucional para la administración, control y publicación
                        de ofertas educativas del SENA.
                    </p>
                    <div class="container">
                        <div id="carouselExampleIndicators" class="carousel slide" style="height: 350px;">
                        <div class="carousel-indicators">
                            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
                            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
                        </div>
                        <div class="carousel-inner">
                            <div class="carousel-item active" style="height: 350px;">
                            <img src="{{ asset('images/oferta1.jpeg') }}" class="d-block w-100" alt="...">
                            </div>
                            <div class="carousel-item" style="height: 350px;">
                            <img src="{{ asset('images/oferta2.jpeg') }}" class="d-block w-100" alt="...">
                            </div>
                            <div class="carousel-item" style="height: 350px;">
                            <img src="{{ asset('images/oferta3.jpeg') }}" class="d-block w-100" alt="...">
                            </div>
                            
                        </div>
                        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </button>
                        </div>
                    </div>
                    {{-- Características --}}
                    <div class="row g-4">
                        <div class="col-md-4">
                            <i class="fas fa-building feature-icon mb-3"></i>
                            <h6 class="fw-bold">Centros</h6>
                            <p class="text-muted small">
                                Gestión de centros de formación.
                            </p>
                        </div>

                        <div class="col-md-4">
                            <i class="fas fa-book feature-icon mb-3"></i>
                            <h6 class="fw-bold">Programas</h6>
                            <p class="text-muted small">
                                Administración de programas educativos.
                            </p>
                        </div>

                        <div class="col-md-4">
                            <i class="fas fa-graduation-cap feature-icon mb-3"></i>
                            <h6 class="fw-bold">Ofertas</h6>
                            <p class="text-muted small">
                                Control de ofertas educativas vigentes.
                            </p>
                        </div>

                    </div>

                </div>

            </div>
        </div>
    </div>
</section>

{{-- FOOTER --}}
<footer class="text-center py-4">
    © {{ date('Y') }} SENA · Sistema de Gestión de Ofertas Educativas
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
{{-- Sección para incluir estilos adicionales --}}
@section('css')
    <style>
        body {
            background: linear-gradient(135deg, #0d6efd, #198754);
            min-height: 100vh;
            color: #fff;
        }

        .hero {
            padding: 6rem 1rem;
        }

        .hero-card {
            background: #ffffff;
            color: #212529;
            border-radius: 1rem;
            padding: 3rem;
            box-shadow: 0 20px 40px rgba(0,0,0,.15);
        }

        .feature-icon {
            font-size: 2.5rem;
            color: #0d6efd;
        }

        footer {
            font-size: .9rem;
            opacity: .8;
        }

        .navbar-brand {
            font-weight: bold;
            font-size: 1.5rem;
            font-family: wordmark, sans-serif;
        }
        
    </style>

@stop