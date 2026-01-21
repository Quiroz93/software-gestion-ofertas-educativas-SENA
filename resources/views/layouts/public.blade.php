<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">

    <title>
        @yield('title', config('app.name', 'SOESoftware'))
    </title>

    <meta name="viewport" content="width=device-width, initial-scale=1">

    {{-- SEO básico --}}
    <meta name="description" content="@yield('meta_description', 'Plataforma educativa SOESoftware')">

    {{-- Favicon --}}
    <link rel="icon" href="{{ asset('favicons/favicon.ico') }}" type="image/x-icon">

    {{-- Bootstrap 5 --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    {{-- Bootstrap Icons --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    {{-- CSS público --}}
    {{-- <link href="{{ asset('css/public.css') }}" rel="stylesheet"> --}}

    @stack('styles')
</head>
<body>

    {{-- Navbar pública --}}
    <nav class="navbar navbar-expand-lg navbar-light bg-light border-bottom">
        <div class="container">
            <a class="navbar-brand fw-bold" href="{{ route('public.home') }}">
                SOESoftware
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarPublic" aria-controls="navbarPublic"
                aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarPublic">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">

                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('public.programas.index') }}">Programas</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('public.ofertas.index') }}">Ofertas</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('public.instructores.index') }}">Instructores</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('public.noticias.index') }}">Noticias</a>
                    </li>

                </ul>
            </div>
        </div>
    </nav>

    {{-- Contenido principal --}}
    <main class="py-4">
        <div class="container">
            @yield('content')
        </div>
    </main>

    {{-- Footer --}}
    <footer class="bg-dark text-light py-4 mt-auto">
        <div class="container text-center">
            <small>
                © {{ date('Y') }} SOESoftware · Todos los derechos reservados
            </small>
        </div>
    </footer>

    {{-- Bootstrap JS --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    @stack('scripts')
</body>
</html>
