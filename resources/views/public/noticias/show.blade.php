@extends('layouts.bootstrap')

@section('title', $noticia->titulo)

@section('content')
<div class="container-fluid">
    <!-- Hero Section -->
    <div class="bg-primary text-white py-5 mb-5 rounded-lg overflow-hidden">
        <div class="container">
            <!-- Breadcrumbs -->
            <nav aria-label="breadcrumb" class="mb-3">
                <ol class="breadcrumb breadcrumb-dark mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-white-50">Inicio</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('public.ultimaNoticias.index') }}" class="text-white-50">Noticias</a></li>
                    <li class="breadcrumb-item active text-white">{{ $noticia->titulo_corta }}</li>
                </ol>
            </nav>

            <!-- Title and Meta -->
            <h1 class="display-4 fw-bold mb-3">{{ $noticia->titulo }}</h1>

            <div class="d-flex flex-wrap gap-3">
                <small class="text-white-50">
                    <i class="bi bi-calendar me-1"></i>
                    {{ $noticia->created_at->format('d \\d\\e F \\d\\e Y') }}
                </small>
                <small class="text-white-50">
                    <i class="bi bi-clock me-1"></i>
                    {{ $noticia->created_at->diffForHumans() }}
                </small>
                @if($noticia->categoria)
                <span class="badge bg-light text-dark">{{ $noticia->categoria }}</span>
                @endif
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="container mb-5">
        <div class="row g-4">
            <!-- Left Column - Article Content -->
            <div class="col-lg-8">
                <!-- Featured Image -->
                <div class="mb-4 rounded-lg overflow-hidden">
                    <div class="bg-light d-flex align-items-center justify-content-center" style="height: 400px;">
                        <i class="bi bi-image text-secondary" style="font-size: 3rem;"></i>
                    </div>
                </div>

                <!-- Article Content -->
                <div class="card shadow-sm border-0 mb-4 rounded-lg">
                    <div class="card-body">
                        <div class="fs-5 lh-lg">
                            {!! nl2br(e($noticia->contenido)) !!}
                        </div>
                    </div>
                </div>

                <!-- Article Meta -->
                <div class="card shadow-sm border-0 mb-4 rounded-lg">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <small class="text-muted d-block mb-1">Publicado por</small>
                                <strong>Centro CATA</strong>
                            </div>
                            <div class="col-md-6">
                                <small class="text-muted d-block mb-1">Última actualización</small>
                                <strong>{{ $noticia->updated_at->format('d/m/Y H:i') }}</strong>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Share Section -->
                <div class="card shadow-sm border-0 rounded-lg">
                    <div class="card-body">
                        <h6 class="fw-bold mb-3">
                            <i class="bi bi-share me-2 text-primary"></i>Compartir esta noticia
                        </h6>
                        <div class="d-flex gap-2">
                            <a href="#" class="btn btn-sm btn-outline-primary" title="Compartir en Facebook">
                                <i class="bi bi-facebook"></i>
                            </a>
                            <a href="#" class="btn btn-sm btn-outline-primary" title="Compartir en Twitter">
                                <i class="bi bi-twitter"></i>
                            </a>
                            <a href="#" class="btn btn-sm btn-outline-primary" title="Compartir en LinkedIn">
                                <i class="bi bi-linkedin"></i>
                            </a>
                            <a href="mailto:?subject={{ urlencode($noticia->titulo) }}&body={{ urlencode(route('public.ultimaNoticias.show', $noticia)) }}"
                               class="btn btn-sm btn-outline-primary" title="Enviar por correo">
                                <i class="bi bi-envelope"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column - Sidebar -->
            <div class="col-lg-4">
                <!-- Related News -->
                @php
                    $relatedNews = \App\Models\Noticia::where('id', '!=', $noticia->id)
                        ->latest()
                        ->take(3)
                        ->get();
                @endphp

                @if($relatedNews->count() > 0)
                <div class="card shadow-sm border-0 mb-4 rounded-lg">
                    <div class="card-body">
                        <h6 class="card-title fw-bold mb-3">
                            <i class="bi bi-link-45deg me-2 text-info"></i>Noticias Relacionadas
                        </h6>

                        <div class="d-flex flex-column gap-3">
                            @foreach($relatedNews as $related)
                            <a href="{{ route('public.ultimaNoticias.show', $related) }}"
                               class="text-decoration-none border-bottom pb-3 transition"
                               style="color: inherit;">
                                <h6 class="fw-bold text-primary mb-1">{{ $related->titulo_medio }}</h6>
                                <small class="text-muted">
                                    <i class="bi bi-calendar me-1"></i>
                                    {{ $related->created_at->format('d M Y') }}
                                </small>
                            </a>
                            @endforeach
                        </div>
                    </div>
                </div>
                @endif

                <!-- Newsletter CTA -->
                <div class="card shadow-sm border-0 mb-4 rounded-lg bg-primary text-white">
                    <div class="card-body">
                        <h6 class="card-title fw-bold mb-2">
                            <i class="bi bi-bell me-2"></i>Manténete Informado
                        </h6>
                        <p class="small mb-3">Suscríbete a nuestro newsletter para recibir todas las noticias</p>
                        <button class="btn btn-sm btn-light w-100" data-bs-toggle="modal" data-bs-target="#newsletterModal">
                            <i class="bi bi-envelope me-1"></i>Suscribirse
                        </button>
                    </div>
                </div>

                <!-- Categories -->
                <div class="card shadow-sm border-0 rounded-lg">
                    <div class="card-body">
                        <h6 class="card-title fw-bold mb-3">
                            <i class="bi bi-tag me-2 text-success"></i>Categorías
                        </h6>
                        <div class="d-flex flex-wrap gap-2">
                            <span class="badge bg-secondary">Educación</span>
                            <span class="badge bg-secondary">Programas</span>
                            <span class="badge bg-secondary">Centro CATA</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- CTA Section -->
    <div class="bg-light rounded-lg p-5 mb-5">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <h4 class="fw-bold mb-2">¿Te interesa formarte con nosotros?</h4>
                <p class="text-muted mb-0">Explora nuestros programas educativos disponibles</p>
            </div>
            <div class="col-lg-4 text-lg-end mt-3 mt-lg-0">
                <a href="{{ route('public.programas.index') }}" class="btn btn-primary">
                    <i class="bi bi-arrow-right me-2"></i>Ver Programas
                </a>
            </div>
        </div>
    </div>

    <!-- Back Button -->
    <div class="container mb-5">
        <a href="{{ route('public.ultimaNoticias.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-2"></i>Volver a Noticias
        </a>
    </div>
</div>

<!-- Newsletter Modal -->
<div class="modal fade" id="newsletterModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title fw-bold">Suscripción a Newsletter</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" action="#">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="email" class="form-label">Correo Electrónico</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <small class="text-muted">Nos comprometemos a no compartir tu correo con terceros.</small>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Suscribirse</button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    .transition {
        transition: all 0.3s ease;
    }

    .hover-shadow:hover {
        box-shadow: 0 0.5rem 1.5rem rgba(0, 0, 0, 0.15) !important;
        transform: translateY(-5px);
    }

    .rounded-lg {
        border-radius: 1rem;
    }

    .breadcrumb-dark .breadcrumb-item.active {
        color: rgba(255, 255, 255, 0.8);
    }
</style>
@endsection
