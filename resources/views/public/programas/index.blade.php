@extends('layouts.bootstrap')

@section('title', 'Programas de Formación')

@section('content')
<div class="container-fluid">
    <!-- Hero Section -->
    <div style="background-color: var(--sena-green);" class="text-white py-5 mb-5 rounded-bottom-lg">
        <div class="container">
            <div class="row align-items-center g-4">
                <div class="col-lg-8">
                    <h1 class="display-4 fw-bold mb-3">Programas de Formación</h1>
                    <p class="lead mb-4">
                        <i class="bi bi-info-circle me-2"></i>
                        Descubre nuestra oferta educativa diseñada para fortalecer tus competencias
                        y abrir nuevas oportunidades laborales
                    </p>
                    <a href="#listado" class="btn btn-outline-sena bg-white">
                        <i class="bi bi-arrow-down me-2"></i>Ver Programas
                    </a>
                </div>
                <div class="col-lg-4 text-center">
                    <i class="bi bi-book-half display-3 text-white opacity-50"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Benefits Section -->
    <div class="container mb-5 py-4">
        <h3 class="h2 text-center fw-bold mb-5" style="color: var(--sena-blue-dark);">¿Por qué elegirnos?</h3>
        <div class="row g-4">
            <div class="col-md-4">
                <div class="text-center">
                    <div style="background-color: rgba(57,169,0,0.08);" class="rounded-circle p-4 d-inline-block mb-3">
                        <i class="bi bi-check-circle" style="font-size: 2rem; color: var(--sena-green);"></i>
                    </div>
                    <h5 class="fw-bold" style="color: var(--sena-blue-dark);">Programas Actualizados</h5>
                    <p class="text-muted">Alineados con las tendencias del mercado laboral</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="text-center">
                    <div style="background-color: rgba(80,229,249,0.12);" class="rounded-circle p-4 d-inline-block mb-3">
                        <i class="bi bi-person-check" style="font-size: 2rem; color: var(--sena-blue-light);"></i>
                    </div>
                    <h5 class="fw-bold" style="color: var(--sena-blue-dark);">Docentes Expertos</h5>
                    <p class="text-muted">Profesionales con experiencia real en la industria</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="text-center">
                    <div style="background-color: rgba(253,195,0,0.12);" class="rounded-circle p-4 d-inline-block mb-3">
                        <i class="bi bi-award" style="font-size: 2rem; color: var(--sena-yellow);"></i>
                    </div>
                    <h5 class="fw-bold" style="color: var(--sena-blue-dark);">Certificación</h5>
                    <p class="text-muted">Respaldo institucional y reconocimiento laboral</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters Section -->
    <div class="container mb-5">
        <div style="background-color: var(--neutral-bg);" class="p-4 rounded-lg">
            <h5 class="fw-bold mb-4" style="color: var(--sena-blue-dark);">
                <i class="bi bi-funnel me-2"></i>Filtrar Programas
            </h5>
            <form method="GET" class="row g-3">
                <div class="col-md-4">
                    <label class="form-label fw-semibold" style="color: var(--sena-blue-dark);">Red</label>
                    <select name="red" class="form-select" onchange="this.form.submit()">
                        <option value="">Todas las redes</option>
                        @foreach ($redes as $red)
                            <option value="{{ $red->id }}" @selected(request('red') == $red->id)>
                                {{ $red->nombre }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-4">
                    <label class="form-label fw-semibold" style="color: var(--sena-blue-dark);">Nivel de Formación</label>
                    <select name="nivel" class="form-select" onchange="this.form.submit()">
                        <option value="">Todos los niveles</option>
                        @foreach ($niveles as $nivel)
                            <option value="{{ $nivel->id }}" @selected(request('nivel') == $nivel->id)>
                                {{ $nivel->nombre }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-4 d-flex align-items-end">
                    <a href="{{ url()->current() }}" class="btn btn-outline-sena w-100">
                        <i class="bi bi-arrow-counterclockwise me-2"></i>Limpiar Filtros
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Programs List -->
    <div class="container mb-5" id="listado">
        <h3 class="h4 fw-bold mb-4" style="color: var(--sena-blue-dark);">
            <i class="bi bi-grid-3x2-gap me-2" style="color: var(--sena-green);"></i>
            Programas Disponibles ({{ count($programas) }})
        </h3>

        @forelse ($programas as $programa)
            <div class="row mb-4">
                <div class="col-lg-12">
                    <div class="card overflow-hidden">
                        <div class="row g-0">
                            <!-- Image -->
                            <div class="col-md-3 bg-light d-flex align-items-center justify-content-center" style="min-height: 250px; background-color: var(--neutral-bg) !important;">
                                <div class="text-center">
                                    <i class="bi bi-book-half" style="font-size: 3rem; color: var(--sena-green);"></i>
                                </div>
                            </div>

                            <!-- Content -->
                            <div class="col-md-9">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-start mb-2">
                                        <h5 class="card-title fw-bold" style="color: var(--sena-green);">{{ $programa->nombre }}</h5>
                                        <span class="badge badge-programa">
                                            <i class="bi bi-check-circle me-1"></i>Activo
                                        </span>
                                    </div>

                                    <p class="card-text text-muted" style="margin-bottom: 1rem;">
                                        {{ $programa->descripcion_larga ?? '' }}
                                    </p>

                                    <!-- Details -->
                                    <div class="row g-3 mb-3">
                                        <div class="col-auto">
                                            <small class="text-muted">
                                                <i class="bi bi-hourglass-split me-1" style="color: var(--sena-blue-light);"></i>
                                                <strong>{{ $programa->duracion_meses ?? 'N/D' }}</strong> meses
                                            </small>
                                        </div>
                                        <div class="col-auto">
                                            <small class="text-muted">
                                                <i class="bi bi-diagram-3 me-1" style="color: var(--sena-yellow);"></i>
                                                <strong>{{ $programa->red->nombre ?? 'Sin red' }}</strong>
                                            </small>
                                        </div>
                                        <div class="col-auto">
                                            <small class="text-muted">
                                                <i class="bi bi-mortarboard me-1" style="color: var(--sena-green-dark);"></i>
                                                <strong>{{ $programa->nivelFormacion->nombre ?? 'Sin nivel' }}</strong>
                                            </small>
                                        </div>
                                        @if($programa->numero_ficha)
                                            <div class="col-auto">
                                                <small class="text-muted">
                                                    <i class="bi bi-hash me-1" style="color: var(--sena-blue-dark);"></i>
                                                    <strong>Ficha:</strong> {{ $programa->numero_ficha }}
                                                </small>
                                            </div>
                                        @endif
                                        @if($programa->modalidad)
                                            <div class="col-auto">
                                                <small class="text-muted">
                                                    <i class="bi bi-laptop me-1" style="color: var(--sena-green);"></i>
                                                    <strong>{{ $programa->modalidad }}</strong>
                                                </small>
                                            </div>
                                        @endif
                                        @if($programa->jornada)
                                            <div class="col-auto">
                                                <small class="text-muted">
                                                    <i class="bi bi-clock me-1" style="color: var(--sena-yellow);"></i>
                                                    <strong>{{ $programa->jornada }}</strong>
                                                </small>
                                            </div>
                                        @endif
                                        @if(!is_null($programa->cupos))
                                            <div class="col-auto">
                                                <small class="text-muted">
                                                    <i class="bi bi-people me-1" style="color: var(--sena-green-dark);"></i>
                                                    <strong>Cupos:</strong> {{ $programa->cupos }}
                                                </small>
                                            </div>
                                        @endif
                                        @if($programa->centro)
                                            <div class="col-auto">
                                                <small class="text-muted">
                                                    <i class="bi bi-geo-alt me-1" style="color: var(--sena-blue-light);"></i>
                                                    <strong>{{ $programa->centro->nombre }}</strong>
                                                </small>
                                            </div>
                                        @endif
                                        @if($programa->municipio)
                                            <div class="col-auto">
                                                <small class="text-muted">
                                                    <i class="bi bi-pin-map me-1" style="color: var(--sena-blue-dark);"></i>
                                                    <strong>{{ $programa->municipio->nombre }}</strong>
                                                </small>
                                            </div>
                                        @endif
                                    </div>

                                    <!-- Button -->
                                                <a href="{{ route('public.programasDeFormacion.show', $programa) }}"
                                                    class="btn btn-primary-sena btn-sm">
                                        <i class="bi bi-arrow-right me-1"></i>Ver Detalles Completos
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="alert text-center py-5" style="background-color: var(--neutral-bg); border: 1px solid var(--sena-blue-light); color: var(--sena-blue-dark);">
                <i class="bi bi-info-circle me-2" style="font-size: 2rem;"></i>
                <p class="mb-0">No hay programas disponibles con los filtros seleccionados</p>
            </div>
        @endforelse

        <!-- Pagination -->
        @if(method_exists($programas, 'render'))
            <div class="d-flex justify-content-center mt-5">
                {{ $programas->appends(request()->query())->links() }}
            </div>
        @endif
    </div>

    <!-- CTA Section -->
    <div style="background-color: var(--neutral-bg);" class="py-5 rounded-lg mb-5">
        <div class="container text-center">
            <h3 class="h4 fw-bold mb-3" style="color: var(--sena-blue-dark);">¿Necesitas más información?</h3>
            <p class="text-muted" style="margin-bottom: 1.5rem;">Contacta con nuestro equipo de asesoría académica</p>
            <a href="mailto:info@example.com" class="btn btn-primary-sena">
                <i class="bi bi-envelope me-2"></i>Enviar Consulta
            </a>
        </div>
    </div>
</div>
@endsection
