<!DOCTYPE html>
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
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
    <div class="container">
        <a class="navbar-brand" href="">
            Gestión de Ofertas
    </div>
</nav>


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