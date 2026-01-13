@extends('layouts.app')

@section('title', 'Dashboard')

@section('content_header')
<h1>Bienvenido, {{ auth()->user()->name }}</h1>
@endsection

@section('content')
<div class="d-flex align-items-center gap-2">
    <i class="fas fa-home text-primary fs-4"></i>
    <h2 class="mb-0 fw-semibold text-xl text-gray-800">
        {{ __('Home') }}
    </h2>
</div>

<div class="container my-4">
    <div id="carouselDark" class="carousel carousel-dark slide" data-bs-ride="carousel">
        <div class="carousel-indicators">
            <button type="button" data-bs-target="#carouselDark" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
            <button type="button" data-bs-target="#carouselDark" data-bs-slide-to="1" aria-label="Slide 2"></button>
            <button type="button" data-bs-target="#carouselDark" data-bs-slide-to="2" aria-label="Slide 3"></button>
        </div>
        <div class="carousel-inner">
            <div class="carousel-item active" data-bs-interval="10000">
                <img src="..." class="d-block w-100" alt="...">
                <div class="carousel-caption d-none d-md-block">
                    <h5>First slide label</h5>
                    <p>Some representative placeholder content for the first slide.</p>
                </div>
            </div>
            <div class="carousel-item" data-bs-interval="2000">
                <img src="..." class="d-block w-100" alt="...">
                <div class="carousel-caption d-none d-md-block">
                    <h5>Second slide label</h5>
                    <p>Some representative placeholder content for the second slide.</p>
                </div>
            </div>
            <div class="carousel-item">
                <img src="..." class="d-block w-100" alt="...">
                <div class="carousel-caption d-none d-md-block">
                    <h5>Third slide label</h5>
                    <p>Some representative placeholder content for the third slide.</p>
                </div>
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselDark" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselDark" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>
</div>

<section>
    <div class="d-flex align-items-center mb-3 mt-4">
        <i class="fas fa-layer-group text-success fs-4 me-2 mt-4 mb-4"></i>
        <h4 class="fw-bold mb-0">Información y Módulos</h4>
    </div>
    <hr>

    <div class="row g-4">

        {{-- Centros --}}
        <div class="col-md-3">
            <div class="card h-100 shadow-sm border-0 text-center">
                <div class="card-body">
                    <i class="bi bi-building fs-2 text-primary mb-2"></i>
                    <h6 class="fw-bold">Centros</h6>
                    <p class="text-muted small">
                        Centros de formación.
                    </p>
                </div>
            </div>
        </div>

        {{-- Programas --}}
        <div class="col-md-3">
            <div class="card h-100 shadow-sm border-0 text-center">
                <div class="card-body">
                    <i class="bi bi-journal-bookmark fs-2 text-success mb-2"></i>
                    <h6 class="fw-bold">Programas</h6>
                    <p class="text-muted small">
                        Programas educativos.
                    </p>
                </div>
            </div>
        </div>

        {{-- Ofertas --}}
        <div class="col-md-3">
            <div class="card h-100 shadow-sm border-0 text-center">
                <div class="card-body">
                    <i class="bi bi-mortarboard fs-2 text-warning mb-2"></i>
                    <h6 class="fw-bold">Ofertas</h6>
                    <p class="text-muted small">
                        Ofertas educativas vigentes.
                    </p>
                </div>
            </div>
        </div>

        {{-- Noticias dinámicas --}}
        @foreach($noticias as $noticia)
        <div class="col-md-3">
            <div class="card h-100 shadow-sm border-0">
                <div class="card-body">
                    <h6 class="fw-bold">
                        <i class="bi bi-newspaper me-1 text-info"></i>
                        {{ $noticia->titulo }}
                    </h6>
                    <p class="text-muted small">
                        {{ Str::limit($noticia->descripcion, 90) }}
                    </p>
                </div>
            </div>
        </div>
        @endforeach

        {{-- Instructores --}}
        <div class="col-md-3">
            <div class="card h-100 shadow-sm border-0 text-center">
                <div class="card-body">
                    <i class="bi bi-mortarboard fs-2 text-warning mb-2"></i>
                    <h6 class="fw-bold">Instructores</h6>
                    <p class="text-muted small">
                        Perfil de nuestros instructores
                    </p>
                </div>
            </div>
        </div>

        {{-- Historias --}}
        <div class="col-md-3">
            <div class="card h-100 shadow-sm border-0 text-center">
                <div class="card-body">
                    <i class="bi bi-mortarboard fs-2 text-warning mb-2"></i>
                    <h6 class="fw-bold">Historias</h6>
                    <p class="text-muted small">
                        Conoce las experiencias que se viven en el Centro Agroempresarial y Turístico de los Andes
                    </p>
                </div>
            </div>
        </div>

        {{-- Modelos a seguir --}}
        <div class="col-md-3">
            <div class="card h-100 shadow-sm border-0 text-center">
                <div class="card-body">
                    <i class="bi bi-mortarboard fs-2 text-warning mb-2"></i>
                    <h6 class="fw-bold">Reconocimientos</h6>
                    <p class="text-muted small">
                        Conoce a nuestros aprendices mas destacados e inspirate a ser parte de nustra <span class="fw-bold mb-0">FAMILIA CATA</span>
                    </p>
                </div>
            </div>
        </div>
    </div>

</section>
@endsection

@section('footer')
<div class="text-center mt-4">
    © 2026 SENA · Centro Agroempresarial y turístico de los Andes
</div>
@endsection
