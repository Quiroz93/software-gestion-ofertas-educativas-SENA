<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>
        @yield('title', config('app.name', 'SoeSoftware'))
    </title>

    <link rel="icon" href="{{ asset('favicons/favicon.ico') }}" type="image/x-icon">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=work-sans:400,500,600,700&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/sena-utilities.css', 'resources/css/common/app.css', 'resources/js/common/app.js'])
</head>

<body style="font-family: 'Work Sans', sans-serif; background-color: #F6F6F6; color: #00304D;">

    <div class="container-fluid min-vh-100">
        <div class="row min-vh-100">

            <!-- COLUMNA IZQUIERDA (IMÁGENES) -->
            <div class="col-md-6 d-none d-md-flex align-items-center justify-content-center text-white p-5" style="background-color: #39A900;">
                <div class="text-center">
                    <div class="mb-3">
                        <img src="{{ asset('images/logo.png') }}" alt="Logo" style="width: 64px; height: 64px;">
                    </div>
                    <h1 class="h3 fw-bold mb-3">SoeSoftware</h1>
                    <p class="mb-4">Sistema de gestión institucional</p>

                    <div class="w-100" style="max-width: 320px; height: 220px; background: rgba(255,255,255,0.2); border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                        <span style="opacity: 0.85;">Espacio para imágenes representativas</span>
                    </div>
                </div>
            </div>

            <!-- COLUMNA DERECHA (FORMULARIO) -->
            <div class="col-md-6 d-flex align-items-center justify-content-center" style="background-color: #F6F6F6;">
                <div class="w-100" style="max-width: 420px; padding: 2rem 1.5rem;">
                    {{ $slot }}
                </div>
            </div>

        </div>
    </div>

</body>

</html>
