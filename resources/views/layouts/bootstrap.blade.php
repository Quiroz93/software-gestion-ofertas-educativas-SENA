<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', config('app.name', 'Laravel'))</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    <!-- Custom CSS -->
    @vite(['resources/css/app.css'])
    
    @stack('styles')
</head>
<body>
    <div id="app">
        <!-- Navbar -->
        @include('partials.navbar')

        <!-- Main Content -->
        <main class="py-4">
            @yield('content')
        </main>

        <!-- Footer -->
        <footer class="bg-light mt-5 py-4 border-top">
            <div class="container">
                <div class="row">
                    <div class="col-md-6">
                        <p class="text-muted mb-0">&copy; {{ date('Y') }} {{ config('app.name') }}. Todos los derechos reservados.</p>
                    </div>
                    <div class="col-md-6 text-md-end">
                        <a href="#" class="text-muted text-decoration-none me-3">Términos</a>
                        <a href="#" class="text-muted text-decoration-none me-3">Privacidad</a>
                        <a href="#" class="text-muted text-decoration-none">Contacto</a>
                    </div>
                </div>
            </div>
        </footer>
    </div>

    <!-- Bootstrap 5 Bundle JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Custom JS -->
    @vite(['resources/js/app.js'])
    
    @stack('scripts')
</body>
</html>
