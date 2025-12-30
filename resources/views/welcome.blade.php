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

{{-- HERO --}}
<section class="hero d-flex align-items-center">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">

                <div class="hero-card text-center">

                    <h1 class="fw-bold mb-3">
                        Sistema de Gestión de Ofertas Educativas
                    </h1>

                    <p class="text-muted fs-5 mb-4">
                        Plataforma institucional para la administración, control y publicación
                        de ofertas educativas del SENA.
                    </p>

                    {{-- Acciones --}}
                    <div class="d-flex justify-content-center gap-3 flex-wrap mb-5">
                        <a href="{{ route('login') }}" class="btn btn-primary btn-lg">
                            <i class="fas fa-sign-in-alt me-2"></i> Iniciar sesión
                        </a>

                        <a href="{{ route('register') }}" class="btn btn-outline-success btn-lg">
                            <i class="fas fa-user-plus me-2"></i> Registrarse
                        </a>
                    </div>

                    {{-- Características --}}
                    <div class="row g-4">

                        <div class="col-md-3">
                            <i class="fas fa-building feature-icon mb-3"></i>
                            <h6 class="fw-bold">Centros</h6>
                            <p class="text-muted small">
                                Gestión de centros de formación.
                            </p>
                        </div>

                        <div class="col-md-3">
                            <i class="fas fa-book feature-icon mb-3"></i>
                            <h6 class="fw-bold">Programas</h6>
                            <p class="text-muted small">
                                Administración de programas educativos.
                            </p>
                        </div>

                        <div class="col-md-3">
                            <i class="fas fa-graduation-cap feature-icon mb-3"></i>
                            <h6 class="fw-bold">Ofertas</h6>
                            <p class="text-muted small">
                                Control de ofertas educativas vigentes.
                            </p>
                        </div>

                        <div class="col-md-3">
                            <i class="fas fa-users feature-icon mb-3"></i>
                            <h6 class="fw-bold">Usuarios</h6>
                            <p class="text-muted small">
                                Roles y permisos del sistema.
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
    </style>

@stop