<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('title', config('app.name') . ' | Autenticación')</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:300,400,500,600,700" rel="stylesheet" />

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles -->
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f8fafc;
            min-height: 100vh;
        }
        .auth-container {
            min-height: 100vh;
        }
        .auth-left {
            background: linear-gradient(135deg, #198754, #20c997);
            color: #fff;
        }
        .auth-card {
            border-radius: 1rem;
            box-shadow: 0 10px 25px rgba(0,0,0,0.08);
        }
    </style>

    @stack('styles')
</head>
<body>

<div class="container-fluid auth-container">
    <div class="row h-100 justify-content-center align-items-center">
    <div class="col-12 col-md-8 col-lg-5">
        <!-- Logo + Title -->
        <div class="text-center mb-4">
            <div class="mb-3">
                {!! file_get_contents(public_path('images/logosimbolo-SENA.svg')) !!}
            </div>
            <h4 class="fw-bold mb-1">{{ config('app.name') }}</h4>
            <span class="text-muted">SENA</span>
        </div>

        <!-- Auth Card -->
        <div class="card auth-card">
            <div class="card-body p-4 p-md-5">
                @yield('content')
            </div>
        </div>
    </div>
</div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

@stack('scripts')
</body>
</html>
