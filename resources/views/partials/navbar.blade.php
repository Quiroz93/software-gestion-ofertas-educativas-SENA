<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="container-fluid">
        <!-- Brand -->
        @auth
            <a class="navbar-brand" href="{{ route('home') }}">
                <i class="bi bi-mortarboard-fill me-2"></i>
                {{ config('app.name', 'Laravel') }}
            </a>
        @else
            <a class="navbar-brand" href="{{ route('public.programasDeFormacion.index') }}">
                <i class="bi bi-mortarboard-fill me-2"></i>
                {{ config('app.name', 'Laravel') }}
            </a>
        @endauth

        <!-- Mobile Toggle -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" 
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Navigation Links -->
        <div class="collapse navbar-collapse" id="navbarNav">
            <!-- Left Side -->
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    @auth
                        <a class="nav-link {{ request()->is('home') ? 'active' : '' }}" href="{{ route('home') }}">
                            <i class="bi bi-house-door me-1"></i>Inicio
                        </a>
                    @else
                        <a class="nav-link {{ request()->is('programasDeFormacion*') ? 'active' : '' }}" href="{{ route('public.programasDeFormacion.index') }}">
                            <i class="bi bi-house-door me-1"></i>Inicio
                        </a>
                    @endauth
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('programasDeFormacion*') ? 'active' : '' }}" href="{{ route('public.programasDeFormacion.index') }}">
                        <i class="bi bi-journal-code me-1"></i>Programas
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('ofertasEducativas*') ? 'active' : '' }}" href="{{ route('public.ofertasEducativas.index') }}">
                        <i class="bi bi-megaphone me-1"></i>Ofertas
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('ultimaNoticias*') ? 'active' : '' }}" href="{{ route('public.ultimaNoticias.index') }}">
                        <i class="bi bi-newspaper me-1"></i>Noticias
                    </a>
                </li>
            </ul>

            <!-- Right Side -->
            <ul class="navbar-nav ms-auto">
                @guest
                    @if (Route::has('login'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">
                                <i class="bi bi-box-arrow-in-right me-1"></i>Iniciar Sesión
                            </a>
                        </li>
                    @endif

                    @if (Route::has('register'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">
                                <i class="bi bi-person-plus me-1"></i>Registrarse
                            </a>
                        </li>
                    @endif
                @else
                    @include('partials.user-menu')
                @endguest
            </ul>
        </div>
    </div>
</nav>
