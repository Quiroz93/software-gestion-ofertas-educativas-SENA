@extends('layouts.bootstrap')

@section('title', $ultimaNoticia->titulo . ' - SENA')

@section('content')
<div class="container" style="max-width: 900px; margin-top: 2rem; margin-bottom: 4rem;">

    {{-- Breadcrumb institucional --}}
    <nav aria-label="breadcrumb" class="mb-3">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}" class="hover-sena">Inicio</a></li>
            <li class="breadcrumb-item"><a href="{{ route('public.ultimaNoticias.index') }}" class="hover-sena">Noticias</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ Str::limit($ultimaNoticia->titulo, 50) }}</li>
        </ol>
    </nav>

    {{-- Artículo principal --}}
    <article class="card" style="padding: 2.5rem; border: 1px solid rgba(0,0,0,0.08);">
        
        {{-- Badge de categoría --}}
        <div class="mb-3">
            <span class="badge bg-success text-white">
                <i class="bi bi-newspaper me-1"></i>Noticia
            </span>
        </div>

        {{-- Título --}}
        <h1 class="h2 fw-bold mb-3" style="color: var(--sena-blue-dark); line-height: 1.3;">
            {{ $ultimaNoticia->titulo }}
        </h1>

        {{-- Fecha de publicación --}}
        <p class="text-muted small mb-4">
            <i class="bi bi-calendar3"></i>
            Publicado el {{ $ultimaNoticia->created_at->locale('es')->isoFormat('D [de] MMMM [de] YYYY') }}
        </p>

        {{-- Imagen destacada (si existe) --}}
        @if($ultimaNoticia->imagen)
            <figure class="mb-4">
                <img 
                    src="{{ asset('storage/' . $ultimaNoticia->imagen) }}" 
                    alt="{{ $ultimaNoticia->titulo }}" 
                    class="img-fluid rounded news-image-clickable"
                    id="newsImage"
                    role="button"
                    data-bs-toggle="modal"
                    data-bs-target="#imageModal"
                    style="width: 100%; height: auto; border: 1px solid rgba(0,0,0,0.06); box-shadow: 0 4px 12px rgba(0,0,0,0.08); cursor: pointer; transition: transform 0.3s ease, box-shadow 0.3s ease;">
                <figcaption class="text-center text-muted small mt-2">
                    <i class="bi bi-zoom-in me-1"></i>Haz clic en la imagen para ampliar
                </figcaption>
            </figure>
        @endif

        {{-- Contenido principal --}}
        <div class="noticia-content" style="font-size: 1.05rem; line-height: 1.7; color: var(--sena-blue-dark);">
            {!! nl2br(e($ultimaNoticia->descripcion)) !!}
        </div>

        {{-- Separador --}}
        <hr class="my-4" style="border-color: rgba(0,0,0,0.08);">

        {{-- Acciones --}}
        <div class="d-flex gap-2 flex-wrap">
            <a href="{{ route('public.ultimaNoticias.index') }}" class="btn btn-outline-sena">
                <i class="bi bi-arrow-left"></i>
                Volver a noticias
            </a>
            <a href="{{ route('home') }}" class="btn btn-outline-sena">
                <i class="bi bi-house-door"></i>
                Ir al inicio
            </a>
        </div>
    </article>

    {{-- Sección: Más noticias recientes --}}
    @php
        $noticiasRelacionadas = App\Models\Noticia::where('activa', true)
            ->where('id', '!=', $ultimaNoticia->id)
            ->latest()
            ->take(3)
            ->get();
    @endphp

    @if($noticiasRelacionadas->isNotEmpty())
        <section class="mt-5">
            <h2 class="h4 fw-semibold mb-3" style="color: var(--sena-blue-dark);">
                <i class="bi bi-newspaper icon-outline"></i>
                Más noticias
            </h2>

            <div class="row g-3">
                @foreach($noticiasRelacionadas as $noticiaRelacionada)
                    <div class="col-md-4">
                        <article class="card h-100" style="overflow: hidden;">
                            {{-- Imagen miniatura --}}
                            @if($noticiaRelacionada->imagen)
                                <div style="height: 150px; overflow: hidden;">
                                    <img src="{{ asset('storage/' . $noticiaRelacionada->imagen) }}" 
                                         class="w-100 h-100" 
                                         alt="{{ $noticiaRelacionada->titulo }}"
                                         style="object-fit: cover;">
                                </div>
                            @else
                                <div class="bg-light d-flex align-items-center justify-content-center" style="height: 150px;">
                                    <i class="bi bi-image text-secondary" style="font-size: 2rem;"></i>
                                </div>
                            @endif
                            
                            <div style="padding: 1.25rem;">
                                <span class="badge bg-success text-white mb-2" style="width: fit-content;">
                                    <i class="bi bi-newspaper me-1"></i>Noticia
                                </span>
                                <h3 class="h6 fw-semibold mb-2">
                                    <a href="{{ route('public.ultimaNoticias.show', $noticiaRelacionada) }}" 
                                       class="hover-sena text-decoration-none" 
                                       style="color: var(--sena-blue-dark);">
                                        {{ Str::limit($noticiaRelacionada->titulo, 60) }}
                                    </a>
                                </h3>
                                <p class="text-muted small mb-3">
                                    {{ Str::limit($noticiaRelacionada->descripcion, 80) }}
                                    </p>
                                <a href="{{ route('public.ultimaNoticias.show', $noticiaRelacionada) }}" 
                                   class="btn btn-outline-sena btn-sm mt-auto">
                                    <i class="bi bi-arrow-right me-1"></i>Leer más
                                </a>
                            </div>
                        </article>
                    </div>
                @endforeach
            </div>
        </section>
    @endif

</div>

{{-- Modal para ver imagen completa --}}
@if($ultimaNoticia->imagen)
<div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content bg-dark">
            <div class="modal-header border-0">
                <h5 class="modal-title text-white" id="imageModalLabel">
                    <i class="bi bi-image me-2"></i>{{ $ultimaNoticia->titulo }}
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center p-0" style="background: #000;">
                <img 
                    src="{{ asset('storage/' . $ultimaNoticia->imagen) }}" 
                    alt="{{ $ultimaNoticia->titulo }}" 
                    class="img-fluid"
                    style="max-height: 80vh; width: auto; object-fit: contain;">
            </div>
        </div>
    </div>
</div>
@endif
@endsection

@push('styles')
<style>
    /* Estilos institucionales SENA */
    .breadcrumb {
        background: transparent;
        padding: 0;
        margin: 0;
    }
    
    .breadcrumb-item + .breadcrumb-item::before {
        content: "›";
        color: var(--sena-blue-dark);
        opacity: 0.5;
    }
    
    .breadcrumb-item a {
        color: var(--sena-blue-dark);
        text-decoration: none;
    }
    
    .breadcrumb-item.active {
        color: var(--text-muted);
    }

    /* Espaciado en contenido de noticia */
    .noticia-content p {
        margin-bottom: 1rem;
    }

    /* Iconos outline SENA */
    .icon-outline {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 32px;
        height: 32px;
        border-radius: 6px;
        background: rgba(57,169,0,0.08);
        color: var(--sena-green, #39A900);
        margin-right: 0.5rem;
        font-size: 1.1rem;
    }

    /* Imagen clickeable para modal */
    .news-image-clickable {
        max-height: none !important;
    }

    .news-image-clickable:hover {
        transform: scale(1.02);
        box-shadow: 0 8px 24px rgba(57, 169, 0, 0.2) !important;
    }

    /* Modal personalizado */
    #imageModal .modal-content {
        border: none;
        border-radius: 0.5rem;
    }

    #imageModal .modal-header {
        background: rgba(0, 0, 0, 0.8);
        padding: 1rem 1.5rem;
    }

    #imageModal .modal-body {
        padding: 0 !important;
        display: flex;
        align-items: center;
        justify-content: center;
        min-height: 300px;
    }

    /* Caption de imagen */
    figure figcaption {
        font-style: italic;
        margin-top: 0.5rem;
        opacity: 0.8;
    }
</style>
@endpush
