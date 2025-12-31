<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>
        @yield('title', config('app.name', 'SoeSoftware'))
    </title>


    <div class="logosimbolo">
        <a href="/">
            <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
        </a>
    </div>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased text-gray-900">

    <div class="min-h-screen grid grid-cols-1 md:grid-cols-2">

        <!-- 🟢 COLUMNA IZQUIERDA (IMÁGENES) -->
        <div class="hidden md:flex items-center justify-center bg-green-700 text-white p-12">
            <div class="text-center">
                <h1 class="text-3xl font-bold mb-4">SoeSoftware</h1>
                <p class="text-lg mb-6">
                    Sistema de gestión institucional
                </p>

                <!-- Espacio para imagen -->
                <div class="w-full h-64 bg-white/20 rounded-lg flex items-center justify-center">
                    <span class="text-sm opacity-80">
                        Espacio para imágenes representativas
                    </span>
                </div>
            </div>
        </div>

        <!-- 🟢 COLUMNA DERECHA (FORMULARIO) -->
        <div class="flex items-center justify-center bg-gray-100">
            <div class="w-full max-w-md px-6 py-8">
                {{ $slot }}
            </div>
        </div>

    </div>

</body>

</html>