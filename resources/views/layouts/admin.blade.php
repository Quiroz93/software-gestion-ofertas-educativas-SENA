<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
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
    @vite(['resources/css/admin/admin.css', 'resources/css/admin/admin-layout.css', 'resources/js/admin/admin.js'])

    @yield('css')
</head>
<body>
    <div class="app-wrapper">
        {{-- Sidebar --}}
        <aside class="sidebar" id="sidebar">
            <div class="sidebar-header">
                <h5>
                    <i class="bi bi-speedometer2 me-2"></i>
                    {{ config('app.name', 'SENA') }}
                </h5>
            </div>

            <nav>
                <ul class="sidebar-nav">
                    {{-- Dashboard --}}
                    <li class="sidebar-nav-item">
                        <a href="{{ route('dashboard') }}"
                           class="sidebar-nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                            <i class="bi bi-house"></i>
                            <span>Dashboard</span>
                        </a>
                    </li>
                    
                    <li class="sidebar-nav-item px-3 py-2 mt-3">
                        <small class="text-uppercase opacity-75">Contenido publico</small>
                    </li>

                    {{-- Home --}}
                    <li class="sidebar-nav-item">
                        <a href="{{ route('home') }}"
                           class="sidebar-nav-link {{ request()->routeIs('home') ? 'active' : '' }}">
                            <i class="bi bi-house-door"></i>
                            <span>Home</span>
                        </a>
                    </li>

                    <li class="sidebar-nav-item px-3 py-2 mt-3">
                        <small class="text-uppercase opacity-75">Contenido</small>
                    </li>

                    {{-- Programas --}}
                    <li class="sidebar-nav-item">
                        <a href="{{ route('programas.index') }}"
                           class="sidebar-nav-link {{ request()->routeIs('programas.*') ? 'active' : '' }}">
                            <i class="bi bi-book"></i>
                            <span>Programas</span>
                        </a>
                    </li>

                    {{-- Ofertas --}}
                    <li class="sidebar-nav-item">
                        <a href="{{ route('ofertas.index') }}"
                           class="sidebar-nav-link {{ request()->routeIs('ofertas.*') ? 'active' : '' }}">
                            <i class="bi bi-briefcase"></i>
                            <span>Ofertas</span>
                        </a>
                    </li>

                    {{-- Noticias --}}
                    <li class="sidebar-nav-item">
                        <a href="{{ route('noticias.index') }}"
                           class="sidebar-nav-link {{ request()->routeIs('noticias.*') ? 'active' : '' }}">
                            <i class="bi bi-newspaper"></i>
                            <span>Noticias</span>
                        </a>
                    </li>

                    {{-- Historias de Éxito --}}
                    <li class="sidebar-nav-item">
                        <a href="{{ route('historias_de_exito.index') }}"
                           class="sidebar-nav-link {{ request()->routeIs('historia_de_exito.*') ? 'active' : '' }}">
                            <i class="bi bi-star"></i>
                            <span>Historias Éxito</span>
                        </a>
                    </li>

                    <li class="sidebar-nav-item px-3 py-2 mt-3">
                        <small class="text-uppercase opacity-75">Configuración</small>
                    </li>

                    {{-- Centros --}}
                    <li class="sidebar-nav-item">
                        <a href="{{ route('centros.index') }}"
                           class="sidebar-nav-link {{ request()->routeIs('centros.*') ? 'active' : '' }}">
                            <i class="bi bi-geo-alt"></i>
                            <span>Centros</span>
                        </a>
                    </li>

                    {{-- Competencias --}}
                    <li class="sidebar-nav-item">
                        <a href="{{ route('competencias.index') }}"
                           class="sidebar-nav-link {{ request()->routeIs('competencias.*') ? 'active' : '' }}">
                            <i class="bi bi-award"></i>
                            <span>Competencias</span>
                        </a>
                    </li>

                    {{-- Niveles de Formación --}}
                    <li class="sidebar-nav-item">
                        <a href="{{ route('niveles_formacion.index') }}"
                           class="sidebar-nav-link {{ request()->routeIs('niveles_formacion.*') ? 'active' : '' }}">
                            <i class="bi bi-mortarboard"></i>
                            <span>Niveles</span>
                        </a>
                    </li>

                    {{-- Redes --}}
                    <li class="sidebar-nav-item">
                        <a href="{{ route('redes_conocimiento.index') }}"
                           class="sidebar-nav-link {{ request()->routeIs('redes_conocimiento.*') ? 'active' : '' }}">
                            <i class="bi bi-diagram-3"></i>
                            <span>Redes</span>
                        </a>
                    </li>

                    {{-- Instructores --}}
                    <li class="sidebar-nav-item">
                        <a href="{{ route('instructores.index') }}"
                           class="sidebar-nav-link {{ request()->routeIs('instructores.*') ? 'active' : '' }}">
                            <i class="bi bi-people"></i>
                            <span>Instructores</span>
                        </a>
                    </li>

                    <li class="sidebar-nav-item px-3 py-2 mt-3">
                        <small class="text-uppercase opacity-75">Administración</small>
                    </li>

                    {{-- Usuarios --}}
                    <li class="sidebar-nav-item">
                        <a href="{{ route('users.index') }}"
                           class="sidebar-nav-link {{ request()->routeIs('users.*') ? 'active' : '' }}">
                            <i class="bi bi-shield-lock"></i>
                            <span>Usuarios</span>
                        </a>
                    </li>
                </ul>
            </nav>
        </aside>

        {{-- Main Content --}}
        <div class="main-content">
            {{-- Navbar --}}
            <nav class="navbar navbar-expand-lg navbar-light sticky-top">
                <div class="container-fluid">
                    <button class="btn btn-outline-secondary d-lg-none toggle-sidebar" id="sidebarToggle">
                        <i class="bi bi-list"></i>
                    </button>

                    <span class="navbar-brand ms-2">@yield('title', config('app.name', 'SENA'))</span>

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

     {{-- Sidebar Toggle Mobile --}}
    <script>
        document.getElementById('sidebarToggle')?.addEventListener('click', function() {
            document.getElementById('sidebar').classList.toggle('show');
        });

        // Close sidebar when clicking on a link
        document.querySelectorAll('.sidebar-nav-link').forEach(link => {
            link.addEventListener('click', function() {
                document.getElementById('sidebar').classList.remove('show');
            });
        });
    </script>

    {{-- DataTables Initialization --}}
    <script>
        $(function() {
            $('#myTable, .table').DataTable({
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
