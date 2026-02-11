@extends('layouts.bootstrap')

@section('title', 'Programas de Formación')

@push('styles')
    @vite(['resources/css/public/programas.css'])
@endpush

@section('content')
<div class="container-fluid">
    @php
        $totalProgramas = $programas->count();
    @endphp

    <!-- Hero institucional -->
    <section class="mb-5">
        <div class="container">
            <div class="row g-4 align-items-stretch">
                <div class="col-lg-7">
                    <div class="h-100 p-4 p-lg-5 rounded-4 text-white" style="background: linear-gradient(135deg, #0a6a2b 0%, #0f8b38 45%, #0a6a2b 100%);">
                        <span class="badge rounded-pill" style="background: rgba(255,255,255,0.2);">Formacion para el trabajo</span>
                        <h1 class="display-5 fw-bold mt-3 mb-3">Programas de Formacion</h1>
                        <p class="lead mb-4">
                            Oferta educativa del Centro Agro Empresarial y Turistico de los Andes, orientada
                            al desarrollo de competencias pertinentes para el territorio.
                        </p>
                        <div class="d-flex flex-wrap gap-2">
                            <a href="#listado" class="btn btn-outline-sena bg-white">
                                <i class="bi bi-arrow-down me-2"></i>Explorar programas
                            </a>
                            <a href="{{ route('public.ofertasEducativas.index') }}" class="btn btn-outline-light">
                                <i class="bi bi-list-check me-2"></i>Ver ofertas
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-5">
                    <div class="h-100 p-4 p-lg-5 rounded-4" style="background: var(--neutral-bg);">
                        <h2 class="h4 fw-bold mb-3" style="color: var(--sena-blue-dark);">Formacion con respaldo institucional</h2>
                        <p class="text-muted mb-4">
                            Programas actualizados, docentes expertos y articulacion con el sector productivo.
                            Consulta requisitos, duraciones y sedes disponibles.
                        </p>
                        <div class="row g-3">
                            <div class="col-6">
                                <div class="p-3 rounded-3 bg-white border">
                                    <div class="fw-bold" style="color: var(--sena-green);">{{ $totalProgramas }}</div>
                                    <small class="text-muted">Programas en publicacion</small>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="p-3 rounded-3 bg-white border">
                                    <div class="fw-bold" style="color: var(--sena-blue-dark);">Cobertura regional</div>
                                    <small class="text-muted">Centros y sedes</small>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="p-3 rounded-3 border" style="border-color: var(--sena-blue-light);">
                                    <div class="d-flex align-items-center">
                                        <i class="bi bi-shield-check me-2" style="color: var(--sena-green);"></i>
                                        <small class="text-muted">Informacion oficial y gratuita para la comunidad</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Principios de formacion -->
    <section class="container mb-5">
        <div class="row g-4">
            <div class="col-lg-4">
                <div class="p-4 rounded-4 h-100" style="background: var(--neutral-bg);">
                    <h3 class="h5 fw-bold" style="color: var(--sena-blue-dark);">Pertinencia productiva</h3>
                    <p class="text-muted mb-0">Planes curriculares alineados con necesidades del sector y tendencias laborales.</p>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="p-4 rounded-4 h-100" style="background: var(--neutral-bg);">
                    <h3 class="h5 fw-bold" style="color: var(--sena-blue-dark);">Trayectorias formativas</h3>
                    <p class="text-muted mb-0">Rutas de aprendizaje que fortalecen tu perfil y facilitan la insercion laboral.</p>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="p-4 rounded-4 h-100" style="background: var(--neutral-bg);">
                    <h3 class="h5 fw-bold" style="color: var(--sena-blue-dark);">Bienestar y acompanamiento</h3>
                    <p class="text-muted mb-0">Equipo academico disponible para orientar tu proceso de formacion.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Filtros -->
    <section class="container mb-5">
        <div class="p-4 rounded-4" style="background: var(--neutral-bg);">
            <div class="d-flex flex-wrap justify-content-between align-items-center mb-3">
                <h5 class="fw-bold mb-0" style="color: var(--sena-blue-dark);">
                    <i class="bi bi-funnel me-2"></i>Filtrar programas
                </h5>
                <small class="text-muted">Selecciona red o nivel para afinar tu busqueda</small>
            </div>
            <form method="GET" class="row g-3">
                <div class="col-md-4">
                    <label class="form-label fw-semibold" style="color: var(--sena-blue-dark);">Red de conocimiento</label>
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
                    <label class="form-label fw-semibold" style="color: var(--sena-blue-dark);">Nivel de formacion</label>
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
                        <i class="bi bi-arrow-counterclockwise me-2"></i>Limpiar filtros
                    </a>
                </div>
            </form>
        </div>
    </section>

    <!-- Listado de programas -->
    <section class="container mb-5" id="listado">
        <div class="d-flex flex-wrap justify-content-between align-items-center mb-4">
            <div>
                <h3 class="h4 fw-bold mb-1" style="color: var(--sena-blue-dark);">Programas disponibles</h3>
                <p class="text-muted mb-0">Consulta duracion, modalidad y sedes asociadas.</p>
            </div>
            <span class="badge rounded-pill" style="background: var(--sena-green);">{{ $totalProgramas }} en publicacion</span>
        </div>

        @forelse ($programas as $programa)
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body p-4">
                    <div class="d-flex flex-wrap justify-content-between align-items-start mb-3">
                        <div>
                            <h4 class="h6 fw-bold mb-2" style="color: var(--sena-green);">{{ $programa->nombre }}</h4>
                            <p class="text-muted mb-0">{{ $programa->descripcion_larga ?? '' }}</p>
                        </div>
                        <span class="badge" style="background: var(--neutral-bg); color: var(--sena-blue-dark);">
                            <i class="bi bi-check-circle me-1" style="color: var(--sena-green);"></i>Activo
                        </span>
                    </div>

                    <div class="d-flex flex-wrap gap-3 mb-3">
                        <div class="d-flex align-items-center">
                            <i class="bi bi-hourglass-split me-2" style="color: var(--sena-blue-light);"></i>
                            <small class="text-muted"><strong>{{ $programa->duracion_meses ?? 'N/D' }}</strong> meses</small>
                        </div>
                        <div class="d-flex align-items-center">
                            <i class="bi bi-diagram-3 me-2" style="color: var(--sena-yellow);"></i>
                            <small class="text-muted">{{ $programa->red->nombre ?? 'Sin red' }}</small>
                        </div>
                        <div class="d-flex align-items-center">
                            <i class="bi bi-mortarboard me-2" style="color: var(--sena-green-dark);"></i>
                            <small class="text-muted">{{ $programa->nivelFormacion->nombre ?? 'Sin nivel' }}</small>
                        </div>
                        @if($programa->numero_ficha)
                            <div class="d-flex align-items-center">
                                <i class="bi bi-hash me-2" style="color: var(--sena-blue-dark);"></i>
                                <small class="text-muted">Ficha {{ $programa->numero_ficha }}</small>
                            </div>
                        @endif
                        @if($programa->modalidad)
                            <div class="d-flex align-items-center">
                                <i class="bi bi-laptop me-2" style="color: var(--sena-green);"></i>
                                <small class="text-muted">{{ $programa->modalidad }}</small>
                            </div>
                        @endif
                        @if($programa->jornada)
                            <div class="d-flex align-items-center">
                                <i class="bi bi-clock me-2" style="color: var(--sena-yellow);"></i>
                                <small class="text-muted">{{ $programa->jornada }}</small>
                            </div>
                        @endif
                        @if(!is_null($programa->cupos))
                            <div class="d-flex align-items-center">
                                <i class="bi bi-people me-2" style="color: var(--sena-green-dark);"></i>
                                <small class="text-muted">Cupos: {{ $programa->cupos }}</small>
                            </div>
                        @endif
                        @if($programa->centro)
                            <div class="d-flex align-items-center">
                                <i class="bi bi-geo-alt me-2" style="color: var(--sena-blue-light);"></i>
                                <small class="text-muted">{{ $programa->centro->nombre }}</small>
                            </div>
                        @endif
                        @if($programa->municipio)
                            <div class="d-flex align-items-center">
                                <i class="bi bi-pin-map me-2" style="color: var(--sena-blue-dark);"></i>
                                <small class="text-muted">{{ $programa->municipio->nombre }}</small>
                            </div>
                        @endif
                    </div>

                    <!-- Associated Offers -->
                    @if($programa->ofertas->count() > 0)
                    <div class="mb-3 p-2 rounded-3" style="background-color: var(--neutral-bg); border-left: 3px solid var(--sena-green);">
                        <small class="text-muted d-block mb-2">
                            <i class="bi bi-collection me-1"></i><strong>Oferta(s) asociada(s):</strong>
                        </small>
                        <div class="d-flex flex-wrap gap-2">
                            @foreach($programa->ofertas->take(2) as $oferta)
                            <a href="{{ route('public.ofertasEducativas.show', $oferta) }}" 
                               class="badge rounded-pill text-decoration-none" 
                               style="background-color: var(--sena-green); color: white; cursor: pointer;">
                                {{ $oferta->nombre }}
                            </a>
                            @endforeach
                            @if($programa->ofertas->count() > 2)
                            <span class="badge rounded-pill" style="background-color: rgba(57, 169, 0, 0.15); color: var(--sena-green);">
                                +{{ $programa->ofertas->count() - 2 }} más
                            </span>
                            @endif
                        </div>
                    </div>
                    @endif

                    <div class="d-flex justify-content-between align-items-center">
                        <small class="text-muted"><i class="bi bi-info-circle me-1"></i>Informacion publica</small>
                        <a href="{{ route('public.programasDeFormacion.show', $programa) }}" class="btn btn-primary-sena btn-sm">
                            Ver detalles <i class="bi bi-arrow-right ms-1"></i>
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <div class="alert text-center py-5" style="background-color: var(--neutral-bg); border: 1px solid var(--sena-blue-light); color: var(--sena-blue-dark);">
                <i class="bi bi-info-circle me-2" style="font-size: 2rem;"></i>
                <p class="mb-0">No hay programas disponibles con los filtros seleccionados</p>
            </div>
        @endforelse

        @if(method_exists($programas, 'render'))
            <div class="d-flex justify-content-center mt-5">
                {{ $programas->appends(request()->query())->links() }}
            </div>
        @endif
    </section>

    <!-- Orientacion -->
    <section class="container mb-5">
        <div class="row g-4 align-items-center">
            <div class="col-lg-8">
                <div class="p-4 rounded-4" style="background: var(--sena-green); color: #fff;">
                    <h4 class="fw-bold mb-2">Necesitas orientacion?</h4>
                    <p class="mb-0">Contacta con nuestro equipo de asesoría academica para resolver tus dudas.</p>
                </div>
            </div>
            <div class="col-lg-4 text-lg-end">
                <a href="mailto:info@example.com" class="btn btn-outline-sena bg-white w-100 w-lg-auto">
                    <i class="bi bi-envelope me-2"></i>Solicitar informacion
                </a>
            </div>
        </div>
    </section>
</div>
@endsection
