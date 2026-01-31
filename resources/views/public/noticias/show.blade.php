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
            <span class="badge">{{ $ultimaNoticia->categoria ?? 'Noticia' }}</span>
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
                    class="img-fluid rounded"
                    style="width: 100%; max-height: 500px; object-fit: cover; border: 1px solid rgba(0,0,0,0.06);">
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
                        <article class="card h-100" style="padding: 1.25rem;">
                            <span class="badge mb-2" style="width: fit-content;">
                                {{ $noticiaRelacionada->categoria ?? 'General' }}
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
                                Leer más
                            </a>
                        </article>
                    </div>
                @endforeach
            </div>
        </section>
    @endif

</div>
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
</style>
@endpush
