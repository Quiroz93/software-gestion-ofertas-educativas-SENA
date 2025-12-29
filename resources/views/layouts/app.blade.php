<!DOCTYPE html>
<<<<<<< HEAD
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
      @yield('title')
    </title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>


<body class="bg-light">

    @extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Dashboard</h1>
@endsection

@section('content')
    <p>Bienvenido al sistema.</p>
@endsection
    @extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Dashboard</h1>
@endsection

@section('content')
    <p>Bienvenido al sistema.</p>
@endsection

<div class="container">
    @yield('content')
</div>

<!-- SweetAlert2 -->
<script src="{{ asset('vendor/sweetalert2/sweetalert2.all.min.js') }}"></script>

<!-- Mensajes automáticos -->
@if(session('success'))
<script>
Swal.fire({
    icon: 'success',
    title: 'Operación exitosa',
    text: '{{ session("success") }}',
    timer: 2000,
    showConfirmButton: false
});
</script>
@endif

</body>
</html>
=======
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>layout</title>
</head>
<body>
    
</body>
</html>
    <header>
        <h1>Welcome to SENA-CATA</h1>
        <h2>Contenedor de layout app standard</h2>
    </header>
    <main>
        @yield('content')
    </main>
    <footer>
        <p>&copy; 2025 SENA-CATA</p>
    </footer>   
>>>>>>> 7a339ed4bc2bb97ee1962c7d4121114af46f2790
