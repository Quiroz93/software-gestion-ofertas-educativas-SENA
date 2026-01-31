@extends('layouts.bootstrap')

@section('title', 'Inicio')

@section('content')
<div class="container home">

    {{-- ================= HERO ================= --}}
    @php
        $heroBgPath = getCustomContent('home', 'hero_background', null);
        $heroBgUrl = $heroBgPath ? asset('storage/' . $heroBgPath) : asset('images/background_1.png');
    @endphp

    <section class="hero" aria-label="Sección principal">
        <div class="hero-card" style="background-image:url('{{ $heroBgUrl }}')">
            <div class="hero-overlay"></div>

            <div class="hero-content">
                <h1 class="editable"
                    data-model="home" data-model-id="0" data-key="hero_title" data-type="text">
                    {!! getCustomContent('home', 'hero_title', 'Bienvenido a la plataforma SENA') !!}
                </h1>

                <p class="lead editable"
                    data-model="home" data-model-id="0" data-key="hero_description" data-type="text">
                    {!! getCustomContent('home', 'hero_description', 'Explora programas de formación y oportunidades de crecimiento profesional') !!}
                </p>

                <a href="#programas" class="btn btn-primary-sena">
                    <i class="bi bi-arrow-down"></i>
                    Explorar programas
                </a>
            </div>
        </div>
    </section>

    {{-- ================= PROGRAMAS ================= --}}
    <section id="programas" class="mt-5" aria-label="Programas de formación">
        <header class="mb-4">
            <h2 class="h3 fw-semibold">
                <i class="bi bi-mortarboard icon-outline"></i>
                Programas de formación
            </h2>
            <p class="text-muted">Conoce nuestra oferta educativa disponible</p>
        </header>

        <div class="features">
            @foreach($programas ?? [] as $programa)
                <article class="card">
                    <h3 class="card-title">{{ $programa->nombre }}</h3>
                    <p class="text-muted">{{ Str::limit($programa->descripcion, 120) }}</p>
                    <a href="{{ route('public.programasDeFormacion.show', $programa) }}" class="btn btn-outline-sena btn-sm">Ver más</a>
                </article>
            @endforeach
            @if(empty($programas) || count($programas) === 0)
                <div class="card">
                    <p class="text-muted mb-0">No hay programas disponibles actualmente.</p>
                </div>
            @endif

        </div>
    </section>

    {{-- ================= GALERÍA ================= --}}
    <section class="mt-5" aria-label="Galería institucional">
        <header class="mb-4">
            <h2 class="h3 fw-semibold">
                <i class="bi bi-images icon-outline"></i>
                Galería institucional
            </h2>
        </header>

        <div class="features">
            @foreach($galeria ?? [] as $imagen)
                <figure class="card">
                    <img src="{{ asset('storage/'.$imagen->ruta) }}" alt="{{ $imagen->titulo ?? 'Imagen institucional SENA' }}" class="img-fluid rounded">
                    @if(!empty($imagen->titulo))
                        <figcaption class="small text-muted mt-2">{{ $imagen->titulo }}</figcaption>
                    @endif
                </figure>
            @endforeach
            @if(empty($galeria) || count($galeria) === 0)
                <div class="card">
                    <p class="text-muted mb-0">Galería no disponible.</p>
                </div>
            @endif
        </div>
    </section>

    {{-- ================= NOTICIAS ================= --}}
    <section class="mt-5" aria-label="Noticias y novedades">
        <header class="mb-4">
            <h2 class="h3 fw-semibold">
                <i class="bi bi-newspaper icon-outline"></i>
                Noticias
            </h2>
        </header>

        <div class="features">
            @foreach($noticias ?? [] as $noticia)
                <article class="card">
                    <span class="badge mb-2">{{ $noticia->categoria ?? 'General' }}</span>
                    <h3 class="card-title">{{ $noticia->titulo }}</h3>
                    <p class="text-muted">{{ Str::limit($noticia->descripcion, 100) }}</p>
                    <a href="{{ route('public.ultimaNoticias.show', $noticia) }}" class="btn btn-outline-sena btn-sm">Leer noticia</a>
                </article>
            @endforeach
            @if(empty($noticias) || count($noticias) === 0)
                <div class="card">
                    <p class="text-muted mb-0">No hay noticias publicadas.</p>
                </div>
            @endif
        </div>
    </section>

</div>
@endsection
