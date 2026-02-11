<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', config('app.name', 'SENA')) - Admin</title>

    {{-- Favicon --}}
    <link rel="icon" href="{{ asset('favicons/favicon.ico') }}" type="image/x-icon">

    {{-- Bootstrap 5 CSS --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    {{-- Bootstrap Icons --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">

    {{-- Font Awesome --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    {{-- Admin Assets --}}
    @vite(['resources/css/sena-utilities.css', 'resources/css/admin/admin.css', 'resources/css/admin/admin-layout.css', 'resources/css/components/pagination-sena.css', 'resources/js/admin/admin.js'])

    @yield('css')
</head>
<body>
    <div class="app-wrapper">
        {{-- Sidebar Overlay --}}
        <div class="sidebar-overlay" id="sidebarOverlay"></div>
        
        {{-- Sidebar (incluido desde partials) --}}
        @include('partials.sidebar')

        {{-- Main Content --}}
        <div class="main-content">
            {{-- Navbar --}}
            <nav class="navbar navbar-expand-lg navbar-light sticky-top">
                <div class="container-fluid">
                    <button class="btn btn-outline-success d-lg-none me-2" 
                            type="button"
                            data-bs-toggle="offcanvas" 
                            data-bs-target="#sidebar-mobile" 
                            aria-controls="sidebar-mobile">
                        <i class="bi bi-list" style="font-size: 1.25rem;"></i>
                    </button>

                    <span class="navbar-brand mb-0 h1">@yield('title', config('app.name', 'SENA'))</span>

                    <div class="ms-auto d-flex align-items-center gap-3">
                        {{-- User Dropdown --}}
                        @auth
                        <div class="dropdown">
                            <button class="btn btn-link dropdown-toggle text-dark text-decoration-none"
                                    type="button" data-bs-toggle="dropdown">
                                <i class="bi bi-person-circle me-2"></i>
                                {{ Auth::user()->name }}
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li>
                                    <a class="dropdown-item" href="{{ route('profile.edit') }}">
                                        <i class="bi bi-person me-2"></i>Perfil
                                    </a>
                                </li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="dropdown-item text-danger">
                                            <i class="bi bi-box-arrow-right me-2"></i>Cerrar sesión
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                        @endauth
                    </div>
                </div>
            </nav>

            {{-- Content Area --}}
            <div class="content-area fade-in">
                {{-- Content Header (page title and navigation) --}}
                @hasSection('content_header')
                <div class="content-header mb-4">
                    @yield('content_header')
                </div>
                @endif

                {{-- Breadcrumbs --}}
                @hasSection('breadcrumbs')
                <nav aria-label="breadcrumb" class="mb-4">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Inicio</a></li>
                        @yield('breadcrumbs')
                    </ol>
                </nav>
                @endif

                {{-- Alerts --}}
                @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="bi bi-exclamation-triangle me-2"></i>
                    <strong>Errores de validación:</strong>
                    <ul class="mb-0 mt-2">
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
                @endif

                @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="bi bi-check-circle me-2"></i>
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
                @endif

                @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="bi bi-x-circle me-2"></i>
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
                @endif

                {{-- Main Content --}}
                @yield('content')
            </div>

            {{-- Footer --}}
            <footer class="bg-light text-muted py-3 px-4 border-top mt-auto text-center">
                <small>&copy; {{ date('Y') }} {{ config('app.name', 'SENA') }}. Todos los derechos reservados.</small>
            </footer>
        </div>
    </div>

    {{-- Bootstrap 5 JS --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    {{-- jQuery (para DataTables, etc.) --}}
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    {{-- SweetAlert2 --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    {{-- DataTables --}}
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">

    {{-- Success Alert --}}
    @if (session('success'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                icon: 'success',
                title: '¡Éxito!',
                text: '{{ session("success") }}',
                confirmButtonText: 'Aceptar',
                timer: 3000
            });
        });
    </script>
    @endif

    @if (session('error'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                icon: 'error',
                title: 'Atención',
                text: '{{ session("error") }}',
                confirmButtonText: 'Aceptar'
            });
        });
    </script>
    @endif

    @if (session('permission_error'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                icon: 'info',
                title: 'Acceso restringido',
                text: '{{ session("permission_error") }}',
                confirmButtonText: 'Aceptar'
            });
        });
    </script>
    @endif

    {{-- Delete Confirmation --}}
    <script>
        function confirmarEliminacion(event) {
            event.preventDefault();
            const form = event.target.closest('form');

            Swal.fire({
                title: '¿Estás seguro?',
                text: "¡No podrás revertir esto!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        }
    </script>

     {{-- Sidebar Toggle - Ahora usa Bootstrap 5 Offcanvas --}}
    <script>
        // No necesitamos JavaScript personalizado, Bootstrap 5 maneja el offcanvas automáticamente
        // Pero mantenemos cierre al hacer clic en enlaces para mejor UX móvil
        document.querySelectorAll('#sidebar-mobile .nav-link').forEach(link => {
            link.addEventListener('click', function() {
                const offcanvas = bootstrap.Offcanvas.getInstance(document.getElementById('sidebar-mobile'));
                if (offcanvas && window.innerWidth < 992) {
                    offcanvas.hide();
                }
            });
        });

        // También para el sidebar desktop en tablets
        document.querySelectorAll('.sidebar-nav-link').forEach(link => {
            link.addEventListener('click', function() {
                if (window.innerWidth < 992 && document.getElementById('sidebar-desktop')) {
                    document.getElementById('sidebar-desktop').classList.remove('show');
                    document.getElementById('sidebarOverlay').classList.remove('show');
                    document.body.classList.remove('sidebar-open');
                }
            });
        });
    </script>

    {{-- DataTables Initialization --}}
    <script>
        $(function() {
            $('#myTable, #preinscritos-table').DataTable({
                responsive: true,
                autoWidth: false,
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.10.21/i18n/Spanish.json'
                }
            });
        });
    </script>

    @yield('js')
</body>
</html>
