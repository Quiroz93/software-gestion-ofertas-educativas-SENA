<div class="offcanvas offcanvas-start" tabindex="-1" id="sidebar" aria-labelledby="sidebarLabel">
    <!-- Offcanvas Header -->
    <div class="offcanvas-header bg-primary text-white">
        <h5 class="offcanvas-title" id="sidebarLabel">
            <i class="bi bi-list-ul me-2"></i>Menú
        </h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>

    <!-- Offcanvas Body -->
    <div class="offcanvas-body p-0">
        <!-- User Panel -->
        @auth
        <div class="user-panel bg-light border-bottom p-3 mb-3">
            <div class="d-flex align-items-center">
                <div class="me-3">
                    <img src="{{ Auth::user()->profile_photo_url }}" 
                         class="rounded-circle" 
                         style="width: 50px; height: 50px; object-fit: cover;"
                         alt="{{ Auth::user()->name }}">
                </div>
                <div class="flex-grow-1">
                    <strong class="d-block">{{ Auth::user()->name }}</strong>
                    <small class="text-muted">{{ Auth::user()->email }}</small>
                </div>
            </div>
        </div>
        @endauth

        <!-- Navigation Menu -->
        <nav class="nav flex-column">
            <!-- Dashboard -->
            <a class="nav-link {{ request()->is('home') ? 'active' : '' }}" href="{{ route('home') }}">
                <i class="bi bi-speedometer2 me-2"></i>Dashboard
            </a>

            @can('viewAny', App\Models\Programa::class)
            <!-- Programas -->
            <a class="nav-link {{ request()->is('programas*') ? 'active' : '' }}" href="{{ route('programas.index') }}">
                <i class="bi bi-journal-code me-2"></i>Programas
            </a>
            @endcan

            @can('viewAny', App\Models\Oferta::class)
            <!-- Ofertas -->
            <a class="nav-link {{ request()->is('ofertas*') ? 'active' : '' }}" href="{{ route('ofertas.index') }}">
                <i class="bi bi-megaphone me-2"></i>Ofertas
            </a>
            @endcan

            @can('viewAny', App\Models\Noticia::class)
            <!-- Noticias -->
            <a class="nav-link {{ request()->is('noticias*') ? 'active' : '' }}" href="{{ route('noticias.index') }}">
                <i class="bi bi-newspaper me-2"></i>Noticias
            </a>
            @endcan

            @can('viewAny', App\Models\Instructor::class)
            <!-- Instructores -->
            <a class="nav-link {{ request()->is('instructores*') ? 'active' : '' }}" href="{{ route('instructores.index') }}">
                <i class="bi bi-person-badge me-2"></i>Instructores
            </a>
            @endcan

            @can('viewAny', App\Models\Centro::class)
            <!-- Centros -->
            <a class="nav-link {{ request()->is('centros*') ? 'active' : '' }}" href="{{ route('centros.index') }}">
                <i class="bi bi-building me-2"></i>Centros
            </a>
            @endcan

            <!-- Divider -->
            <hr class="my-2">

            @auth
            <!-- Profile -->
            <a class="nav-link {{ request()->is('profile*') ? 'active' : '' }}" href="{{ route('profile.edit') }}">
                <i class="bi bi-person-circle me-2"></i>Mi Perfil
            </a>

            <!-- Settings -->
            <a class="nav-link {{ request()->is('settings*') ? 'active' : '' }}" href="#">
                <i class="bi bi-gear me-2"></i>Configuración
            </a>

            <!-- Logout -->
            <form method="POST" action="{{ route('logout') }}" class="d-inline">
                @csrf
                <button type="submit" class="nav-link border-0 bg-transparent w-100 text-start">
                    <i class="bi bi-box-arrow-right me-2"></i>Cerrar Sesión
                </button>
            </form>
            @endauth
        </nav>
    </div>
</div>

<!-- Sidebar Toggle Button (for mobile) -->
<button class="btn btn-primary d-lg-none position-fixed bottom-0 end-0 m-3 rounded-circle shadow" 
        type="button" 
        data-bs-toggle="offcanvas" 
        data-bs-target="#sidebar" 
        aria-controls="sidebar"
        style="width: 56px; height: 56px; z-index: 1040;">
    <i class="bi bi-list fs-4"></i>
</button>

<style>
    .nav-link {
        color: #495057;
        padding: 0.75rem 1rem;
        transition: all 0.3s ease;
        border-left: 3px solid transparent;
    }
    
    .nav-link:hover {
        background-color: #f8f9fa;
        color: #0d6efd;
        border-left-color: #0d6efd;
    }
    
    .nav-link.active {
        background-color: #e7f1ff;
        color: #0d6efd;
        border-left-color: #0d6efd;
        font-weight: 500;
    }
    
    .nav-link i {
        width: 20px;
        text-align: center;
    }
</style>
