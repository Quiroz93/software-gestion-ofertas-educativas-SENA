<li class="nav-item dropdown">
    <a class="nav-link dropdown-toggle d-flex align-items-center"
        href="#"
        id="userDropdown"
        role="button"
        data-bs-toggle="dropdown"
        aria-expanded="false">
        <span class="bi bi-hand text-light me-2">¡Bienvenido!</span>
        <img src="{{ Auth::user()->profile_photo_url }}"
            class="rounded-circle me-2"
            style="width: 32px; height: 32px; object-fit: cover;"
            alt="{{ Auth::user()->name }}">
        <span class="d-none d-md-inline">{{ Auth::user()->name }}</span>
    </a>
    <ul class="dropdown-menu dropdown-menu-end shadow" aria-labelledby="userDropdown">
        <!-- User Info -->
        <li class="px-3 py-2 border-bottom">
            <div class="d-flex align-items-center">
                <img src="{{ Auth::user()->profile_photo_url }}"
                    class="rounded-circle me-2"
                    style="width: 40px; height: 40px; object-fit: cover;"
                    alt="{{ Auth::user()->name }}">
                <div>
                    <strong class="d-block">{{ Auth::user()->name }}</strong>
                    <small class="text-muted">{{ Auth::user()->email }}</small>
                </div>
            </div>
        </li>

        <!-- Menu Items -->
        <li>
            <a class="dropdown-item" href="{{ route('home') }}">
                <i class="bi bi-house me-2"></i>Home
            </a>
        </li>
        
        @if (Auth::user()->hasRole('admin') || Auth::user()->hasRole('SuperAdmin'))
        <li>
            <a class="dropdown-item" href="{{ route('dashboard') }}">
                <i class="bi bi-speedometer2 me-2"></i>Dashboard
            </a>
        </li>
        @endif
        
        <li>
            <a class="dropdown-item" href="{{ route('profile.edit') }}">
                <i class="bi bi-person-circle me-2"></i>Mi Perfil
            </a>
        </li>
        <li>
            <a class="dropdown-item" href="#">
                <i class="bi bi-gear me-2"></i>Configuración
            </a>
        </li>

        @if (Auth::user()->hasRole('admin') || Auth::user()->hasRole('SuperAdmin'))
        <li>
            <hr class="dropdown-divider">
        </li>

        <!-- Admin Panel -->
        <li>
            <a class="dropdown-item" href="{{ route('dashboard') }}">
                <i class="bi bi-shield-lock me-2"></i>Panel de Administración
            </a>
        </li>
        @endif

        <li>
            <hr class="dropdown-divider">
        </li>

        <!-- Logout -->
        <li>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="dropdown-item text-danger">
                    <i class="bi bi-box-arrow-right me-2"></i>Cerrar Sesión
                </button>
            </form>
        </li>
    </ul>
</li>

<style>
    .dropdown-item {
        transition: background-color 0.2s ease;
    }

    .dropdown-item:hover {
        background-color: #f8f9fa;
    }

    .dropdown-item.text-danger:hover {
        background-color: #f8d7da;
    }
</style>