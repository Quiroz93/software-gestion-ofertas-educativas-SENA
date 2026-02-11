@extends('layouts.bootstrap')

@section('title', 'Programas de Formación')

@push('styles')
    @vite(['resources/css/design-system.css'])
@endpush

@section('content')
<div class="container py-5">
    <!-- HERO MODERNO -->
    @php
        // Usar el primer content_public_programas que exista para algún programa como contenido general
        $publicContent = null;
        foreach($programas as $p) {
            if ($p->contentPublicPrograma) {
                $publicContent = $p->contentPublicPrograma;
                break;
            }
        }
    @endphp
    <section class="hero-section hero-bg-green mb-5 shadow-lg">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-8 text-lg-start text-center">
                    <h1 class="display-4 fw-bold mb-3">{{ $publicContent->hero_title ?? 'Descubre tu futuro en el SENA' }}</h1>
                    <p class="lead mb-4">{{ $publicContent->hero_description ?? 'Formación de calidad, docentes expertos y trayectorias que transforman vidas. ¡Elige tu programa y da el siguiente paso hacia tus metas!' }}</p>
                    <div class="d-flex flex-wrap gap-3 justify-content-lg-start justify-content-center">
                        <a href="#listado" class="btn btn-light btn-lg shadow-sm px-4 py-2 fw-semibold">
                            <i class="bi bi-search me-2"></i>Explorar programas
                        </a>
                        <a href="mailto:info@example.com" class="btn btn-outline-light btn-lg px-4 py-2 fw-semibold">
                            <i class="bi bi-chat-dots me-2"></i>Solicitar orientación
                        </a>
                    </div>
                </div>
                <div class="col-lg-4 d-none d-lg-block text-end">
                    @if(!empty($publicContent->hero_image))
                        <img src="{{ $publicContent->hero_image }}" alt="Programas SENA" class="img-fluid rounded shadow-lg" style="max-height: 260px;">
                    @else
                        <img src="/images/hero-programas.svg" alt="Programas SENA" class="img-fluid rounded shadow-lg" style="max-height: 260px;">
                    @endif
                </div>
            </div>
        </div>
    </section>

    <!-- FILTROS MODERNOS -->
    <section class="mb-5">
        <div class="bg-white rounded shadow p-4">
            <form method="GET" class="row g-3 align-items-end">
                <div class="col-md-4">
                    <label class="form-label fw-semibold text-sena-blue">Red de conocimiento</label>
                    <select name="red" class="form-select" onchange="this.form.submit()">
                        <option value="">Todas las redes</option>
                        @foreach ($redes as $red)
                            <option value="{{ $red->id }}" @selected(request('red') == $red->id)>{{ $red->nombre }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold text-sena-blue">Nivel de formación</label>
                    <select name="nivel" class="form-select" onchange="this.form.submit()">
                        <option value="">Todos los niveles</option>
                        @foreach ($niveles as $nivel)
                            <option value="{{ $nivel->id }}" @selected(request('nivel') == $nivel->id)>{{ $nivel->nombre }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <a href="{{ url()->current() }}" class="btn btn-outline-sena w-100">
                        <i class="bi bi-arrow-counterclockwise me-2"></i>Limpiar filtros
                    </a>
                </div>
            </form>
        </div>
    </section>

    <!-- LISTADO MODERNO DE PROGRAMAS -->
    <section id="listado">
        <div class="row g-4">
            @forelse ($programas as $programa)
                <div class="col-md-6 col-lg-4">
                    <div class="card shadow h-100 border-0 rounded-lg animate__animated animate__fadeInUp">
                        <div class="card-body d-flex flex-column">
                            <div class="mb-3">
                                <span class="badge bg-sena-accent text-sena-green mb-2">{{ $programa->nivelFormacion->nombre ?? 'Nivel' }}</span>
                                <h3 class="h5 fw-bold text-sena-blue mb-1">{{ $programa->nombre }}</h3>
                                <p class="text-muted mb-2">{{ $programa->descripcion_corta }}</p>
                            </div>
                            <ul class="list-unstyled mb-3">
                                <li class="mb-1"><i class="bi bi-clock icon-small text-sena-yellow"></i> <strong>Duración:</strong> {{ $programa->duracion_meses ?? 'N/D' }} meses</li>
                                <li class="mb-1"><i class="bi bi-geo-alt icon-small text-sena-blue"></i> <strong>Centro:</strong> {{ $programa->centro->nombre ?? 'N/A' }}</li>
                                <li class="mb-1"><i class="bi bi-diagram-3 icon-small text-sena-green"></i> <strong>Red:</strong> {{ $programa->red->nombre ?? 'N/A' }}</li>
                                <li class="mb-1"><i class="bi bi-laptop icon-small text-sena-green"></i> <strong>Modalidad:</strong> {{ $programa->modalidad ?? 'N/A' }}</li>
                                <li class="mb-1"><i class="bi bi-people icon-small text-sena-blue"></i> <strong>Cupos:</strong> {{ $programa->cupos ?? 'N/A' }}</li>
                            </ul>
                            <div class="mt-auto d-flex flex-column gap-2">
                                <a href="{{ route('public.programasDeFormacion.show', $programa) }}" class="btn btn-outline-sena w-100 fw-semibold">
                                    <i class="bi bi-eye me-2"></i>Ver detalles
                                </a>
                                <a href="{{ route('public.inscripcion.formulario', $programa) }}" class="btn btn-sena-green w-100 fw-semibold" style="background: var(--sena-green); color: #fff;">
                                    <i class="bi bi-pencil-square me-2"></i>Inscribirme ahora
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="alert alert-info text-center py-5">
                        <i class="bi bi-info-circle me-2" style="font-size: 2rem;"></i>
                        <p class="mb-0">No hay programas disponibles con los filtros seleccionados</p>
                    </div>
                </div>
            @endforelse
        </div>
        @if(method_exists($programas, 'render'))
            <div class="d-flex justify-content-center mt-5">
                {{ $programas->appends(request()->query())->links() }}
            </div>
        @endif
    </section>

    <!-- SECCIÓN MOTIVACIONAL -->
    <section class="hero-section hero-bg-blue mt-5 mb-0 shadow-lg">
        <div class="container py-4">
            <div class="row align-items-center">
                <div class="col-lg-9 text-lg-start text-center">
                    <h2 class="fw-bold mb-3">¡Transforma tu vida con el SENA!</h2>
                    <p class="lead mb-0">Nuestros egresados acceden a mejores oportunidades laborales y contribuyen al desarrollo regional. ¡Tú puedes ser el próximo caso de éxito!</p>
                </div>
                <div class="col-lg-3 d-none d-lg-block text-end">
                    <img src="/images/motivacion-sena.svg" alt="Motivación SENA" class="img-fluid rounded shadow-lg" style="max-height: 140px;">
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
