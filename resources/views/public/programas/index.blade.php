@extends('layouts.app')

@section('title', 'Oferta Educativa')

@section('content')

<!-- HERO -->
<div class="container-fluid bg-primary text-white py-5 mb-5" style="font-family: 'worksans sans-serif';">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-7">
                <h1 class="display-5 fw-bold">Impulsa tu futuro profesional</h1>
                <p class="lead mt-3">
                    Descubre nuestra oferta educativa diseñada para fortalecer tus competencias
                    y abrir nuevas oportunidades laborales.
                </p>
                <a href="#ofertas" class="btn btn-light btn-lg">Ver programas</a>
            </div>
        </div>
    </div>
</div>

<!-- BENEFICIOS -->
<div class="container mb-5" style="font-family: 'worksans sans-serif';">
    <div class="row text-center mb-4">
        <h2 class="fw-bold">¿Por qué elegirnos?</h2>
    </div>

    <div class="row g-4 text-center">
        <div class="col-md-4">
            <h5>Programas actualizados</h5>
            <p class="text-muted">Alineados al mercado laboral</p>
        </div>
        <div class="col-md-4">
            <h5>Docentes expertos</h5>
            <p class="text-muted">Experiencia real</p>
        </div>
        <div class="col-md-4">
            <h5>Certificación</h5>
            <p class="text-muted">Respaldo institucional</p>
        </div>
    </div>
</div>

<!-- FILTROS -->
<div class="container mb-4" style="font-family: 'worksans sans-serif';">
    <form method="GET" class="row g-3">
        <div class="col-md-5">
            <select name="red" class="form-select" onchange="this.form.submit()">
                <option value="">Todas las redes</option>
                @foreach ($redes as $red)
                    <option value="{{ $red->id }}" @selected(request('red') == $red->id)>
                        {{ $red->nombre }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="col-md-5">
            <select name="nivel" class="form-select" onchange="this.form.submit()">
                <option value="">Todos los niveles</option>
                @foreach ($niveles as $nivel)
                    <option value="{{ $nivel->id }}" @selected(request('nivel') == $nivel->id)>
                        {{ $nivel->nombre }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="col-md-2 d-grid">
            <a href="{{ url()->current() }}" class="btn btn-outline-secondary">Limpiar</a>
        </div>
    </form>
</div>

<!-- LISTADO DINÁMICO -->
<div class="container mb-5" id="ofertas" style="font-family: 'worksans sans-serif';">
    <div class="row g-4">

        @forelse ($programas as $programa)
            <div class="col-md-6 col-lg-4">
                <div class="card h-100 shadow-sm">
                    <div class="card-body">
                        <h5>{{ $programa->nombre }}</h5>

                        <p class="text-muted">
                            {{ Str::limit($programa->descripcion, 120) }}
                        </p>

                        <ul class="small list-unstyled">
                            <li><strong>Duración:</strong> {{ $programa->duracion_meses ?? 'N/D' }} meses</li>
                            <li><strong>Red:</strong> {{ $programa->red->nombre }}</li>
                            <li><strong>Nivel:</strong> {{ $programa->nivelFormacion->nombre }}</li>
                        </ul>

                        <a href="{{ route('public.programas.show', $programa) }}"
                           class="btn btn-sm btn-primary">
                            Ver detalles
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col">
                <div class="alert alert-info text-center">
                    No hay programas disponibles.
                </div>
            </div>
        @endforelse

    </div>
</div>

<!-- CTA FINAL -->
<div class="container-fluid bg-light py-5" style="font-family: 'worksans sans-serif';">
    <div class="container text-center">
        <h3 class="fw-bold">¿Deseas más información?</h3>
        <a href="#" class="btn btn-primary btn-lg mt-3">Contáctanos</a>
    </div>
</div>

@endsection
