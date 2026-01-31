@extends('layouts.bootstrap')

@section('title', 'Noticias y Artículos')

@section('content')
<div class="container-fluid">
    <!-- Hero Section -->
        <div class="text-white py-5 mb-5 rounded-lg overflow-hidden"
            style="background-color: var(--sena-green);">
        <div class="container position-relative py-4">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <h1 class="display-4 fw-bold mb-3">
                        <i class="bi bi-newspaper me-3"></i>Noticias y Artículos
                    </h1>
                    <p class="lead mb-0">Mantente informado de las últimas novedades del Centro CATA</p>
                </div>
                <div class="col-lg-4 text-lg-end d-none d-lg-block">
                    <i class="bi bi-newspaper text-white" style="font-size: 5rem; opacity: 0.3;"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Destacados Section -->
    @if($noticias->count() > 0)
    <div class="container mb-5">
        <h3 class="h3 fw-bold mb-4" style="color: var(--sena-blue-dark);">
            <i class="bi bi-star-fill me-2" style="color: var(--sena-yellow);"></i>Destacado
        </h3>

        <div class="row g-4">
            @foreach($noticias->take(1) as $noticia)
            <div class="col-12">
                <div class="card overflow-hidden h-100">
                    <div class="row g-0 h-100">
                        <!-- Image -->
                        <div class="col-lg-5 bg-light d-flex align-items-center justify-content-center" style="min-height: 300px;">
                            @if($noticia->imagen)
                                <img src="{{ asset('storage/' . $noticia->imagen) }}" 
                                     class="w-100 h-100" 
                                     alt="{{ $noticia->titulo }}"
                                     style="object-fit: cover;">
                            @else
                                <i class="bi bi-image text-secondary" style="font-size: 3rem;"></i>
                            @endif
                        </div>

                        <!-- Content -->
                        <div class="col-lg-7 d-flex flex-column">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-start mb-3">
                                    <span class="badge bg-warning text-dark">
                                        <i class="bi bi-fire me-1"></i>Destacado
                                    </span>
                                    <small class="text-muted">
                                        <i class="bi bi-calendar me-1"></i>
                                        {{ $noticia->created_at->format('d/m/Y') }}
                                    </small>
                                </div>

                                <h5 class="card-title fw-bold h4 mb-3">{{ $noticia->titulo }}</h5>

                                <p class="card-text text-muted mb-4">
                                    {{ $noticia->descripcion_larga }}
                                </p>

                                          <a href="{{ route('public.ultimaNoticias.show', $noticia) }}"
                                              class="btn btn-primary-sena stretched-link">
                                    <i class="bi bi-arrow-right me-2"></i>Leer más
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif

    <!-- All News Grid -->
    <div class="container mb-5">
        <h3 class="h3 fw-bold mb-4" style="color: var(--sena-blue-dark);">
            <i class="bi bi-list-check me-2" style="color: var(--sena-green);"></i>Todas las Noticias
            @if($noticias->count() > 1)
                <span class="badge bg-success ms-2">{{ $noticias->count() }}</span>
            @endif
        </h3>

        @if($noticias->count() > 0)
        <div class="row g-4">
            @foreach($noticias->skip(1) as $noticia)
            <div class="col-lg-4 col-md-6">
                <div class="card h-100">
                    <!-- Image -->
                    <div class="bg-light d-flex align-items-center justify-content-center" style="height: 200px; overflow: hidden;">
                        @if($noticia->imagen)
                            <img src="{{ asset('storage/' . $noticia->imagen) }}" 
                                 class="w-100 h-100" 
                                 alt="{{ $noticia->titulo }}"
                                 style="object-fit: cover;">
                        @else
                            <i class="bi bi-image text-secondary" style="font-size: 2rem;"></i>
                        @endif
                    </div>

                    <!-- Content -->
                    <div class="card-body d-flex flex-column">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <span class="badge bg-success text-white small">
                                <i class="bi bi-newspaper me-1"></i>Noticia
                            </span>
                            <small class="text-muted">
                                <i class="bi bi-calendar3"></i>
                                {{ $noticia->created_at->format('d/m/Y') }}
                            </small>
                        </div>

                        <h6 class="card-title fw-bold mb-2">{{ $noticia->titulo_medio }}</h6>

                        <p class="card-text text-muted small mb-3 flex-grow-1">
                            {{ $noticia->descripcion_media }}
                        </p>

                                <a href="{{ route('public.ultimaNoticias.show', $noticia) }}"
                                    class="btn btn-outline-sena btn-sm">
                            <i class="bi bi-arrow-right me-1"></i>Leer
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Pagination -->
        {{-- Pagination disabled due to Laravel 12 bug with AbstractPaginator::links() 
             Error: call_user_func(): Argument #1 ($callback) must be a valid callback
             TODO: Re-enable when Laravel 12 fixes the pagination callback issue
        <div class="d-flex justify-content-center mt-5">
            {!! $noticias->links('vendor.pagination.bootstrap-5') !!}
        </div>
        --}}
        @else
        <div class="alert text-center py-5" style="background-color: var(--neutral-bg); border: 1px solid var(--sena-blue-light); color: var(--sena-blue-dark);">
            <i class="bi bi-info-circle me-2" style="font-size: 2rem;"></i>
            <p class="mb-0">No hay noticias disponibles en este momento</p>
        </div>
        @endif
    </div>

    <!-- Newsletter CTA -->
    <div class="bg-light rounded-lg p-5 text-center mb-5" style="background-color: var(--neutral-bg);">
        <h4 class="fw-bold mb-2" style="color: var(--sena-blue-dark);">¿Quieres estar siempre informado?</h4>
        <p class="text-muted mb-3">Suscríbete a nuestro newsletter para recibir las últimas noticias</p>
        <button class="btn btn-primary-sena" data-bs-toggle="modal" data-bs-target="#newsletterModal">
            <i class="bi bi-envelope me-2"></i>Suscribirse
        </button>
    </div>
</div>

<!-- Newsletter Modal -->
<div class="modal fade" id="newsletterModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title fw-bold" style="color: var(--sena-blue-dark);">Suscripción a Newsletter</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" action="#">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="email" class="form-label">Correo Electrónico</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-sena" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary-sena">Suscribirse</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
