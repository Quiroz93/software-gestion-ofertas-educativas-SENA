@extends('layouts.bootstrap')

@section('title', $programa->nombre)

@push('styles')
    @vite(['resources/css/design-system.css'])
@endpush

@section('content')
@php $publicContent = $programa->contentPublicPrograma; @endphp
<div class="container py-5">
    <!-- HERO MODERNO -->
    <section class="hero-section" style="background: linear-gradient(135deg, #e6f6fb 0%, #cbeafd 100%); color: var(--sena-blue-dark);">
        <div class="container">
            <nav aria-label="breadcrumb" class="mb-3">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-sena-blue" style="opacity: 0.8;">Inicio</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('public.programasDeFormacion.index') }}" class="text-sena-blue" style="opacity: 0.8;">Programas</a></li>
                    <li class="breadcrumb-item active text-sena-blue" aria-current="page">{{ $programa->nombre }}</li>
                </ol>
            </nav>
            <div class="row align-items-center mt-3">
                <div class="col-lg-8">
                    <h1 class="display-4 fw-bold mb-3">{{ $publicContent->hero_title ?? $programa->nombre }}</h1>
                    <p class="lead mb-4">{{ $publicContent->hero_description ?? ($programa->descripcion ?? 'No disponible') }}</p>
                    <div class="d-flex flex-wrap gap-3">
                        <a href="#inscripcion" class="btn btn-light btn-lg shadow-sm px-4 py-2 fw-semibold">
                            <i class="bi bi-pencil-square me-2"></i>Inscribirme ahora
                        </a>
                        <a href="#detalles" class="btn btn-outline-sena btn-lg px-4 py-2 fw-semibold">
                            <i class="bi bi-info-circle me-2"></i>Ver detalles
                        </a>
                    </div>
                </div>
                <div class="col-lg-4 d-none d-lg-block text-end">
                    @if(!empty($publicContent->hero_image))
                        <img src="{{ $publicContent->hero_image }}" alt="Programa SENA" class="img-fluid rounded shadow-lg" style="max-height: 220px;">
                    @else
                        <img src="/images/hero-programas.svg" alt="Programa SENA" class="img-fluid rounded shadow-lg" style="max-height: 220px;">
                    @endif
                </div>
            </div>
        </div>
    </section>
    <div class="row mt-4">
        <!-- Columna principal -->
        <div class="col-lg-8 mb-4">
            <!-- SECCIÓN DE VIDEO DETALLE DEL PROGRAMA -->
            <div id="detalles" class="mb-4">
                <h4 class="fw-bold mb-3 text-sena-blue"><i class="bi bi-play-circle me-2"></i>Video del Programa</h4>
                @if(isset($programa->detalle) && $programa->detalle->video_url)
                    <div class="ratio ratio-16x9 rounded shadow mb-3">
                        <iframe src="{{ Str::contains($programa->detalle->video_url, 'youtube') ? str_replace('watch?v=', 'embed/', $programa->detalle->video_url) : $programa->detalle->video_url }}" title="Video del Programa" allowfullscreen></iframe>
                    </div>
                @else
                    <div class="alert alert-info d-flex align-items-center" role="alert">
                        <i class="bi bi-info-circle me-2"></i>
                        <span>No se ha registrado un video para este programa. ¡Próximamente podrás conocer más a través de contenido multimedia!</span>
                    </div>
                @endif
            </div>
            <!-- FIN SECCIÓN DE VIDEO -->
            @if($programa->detalle && $programa->detalle->imagenes_blob && is_array($programa->detalle->imagenes_blob))
            <div class="mb-3">
                <h6 class="fw-bold mb-2"><i class="bi bi-images me-1"></i>Galería</h6>
                <div class="row g-2">
                    @foreach($programa->detalle->imagenes_blob as $img)
                    <div class="col-6 col-md-4">
                        <img src="data:image/jpeg;base64,{{ $img }}" class="img-fluid rounded shadow-sm" alt="Imagen Programa">
                    </div>
                    @endforeach
                </div>
            </div>
            @endif
            <!-- Requisitos -->
            <div class="card shadow border-0 rounded-lg mb-4 animate__animated animate__fadeInUp">
                <div class="card-body">
                    <h4 class="fw-bold mb-3 text-sena-green"><i class="bi bi-check-circle me-2"></i>Requisitos</h4>
                    <p class="text-muted">{{ $programa->requisitos ?? 'No especificados' }}</p>
                </div>
            </div>
            <!-- Observaciones -->
            @if($programa->observaciones)
            <div class="card shadow border-0 rounded-lg mb-4 animate__animated animate__fadeInUp">
                <div class="card-body">
                    <h4 class="fw-bold mb-3 text-sena-green"><i class="bi bi-info-circle me-2"></i>Observaciones</h4>
                    <p class="text-muted mb-0">{{ $programa->observaciones }}</p>
                </div>
            </div>
            @endif
            <!-- Competencias -->
            <div class="card shadow border-0 rounded-lg mb-4 animate__animated animate__fadeInUp">
                <div class="card-body">
                    <h4 class="fw-bold mb-3 text-sena-green"><i class="bi bi-star me-2"></i>Competencias</h4>
                    @if($programa->competencias->count() > 0)
                    <div class="row g-2">
                        @foreach($programa->competencias as $competencia)
                        <div class="col-md-6">
                            <div class="p-3 bg-sena-accent rounded shadow-sm mb-2">
                                <h6 class="fw-bold mb-1">{{ $competencia->nombre }}</h6>
                                <small class="text-muted">{{ $competencia->descripcion_corta ?? '' }}</small>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @else
                    <div class="alert alert-info mb-0" role="alert">
                        <i class="bi bi-info-circle me-2"></i>{{ $publicContent->competencias_fallback ?? 'Estamos actualizando esta sección. Aún no se han registrado competencias para este programa. ¡Vuelve pronto para más información!' }}
                    </div>
                    @endif
                </div>
            </div>
            <!-- Proyectos Destacados -->
            @if($programa->historiasExito && $programa->historiasExito->count() > 0)
            <div class="card shadow border-0 rounded-lg mb-4 animate__animated animate__fadeInUp">
                <div class="card-body">
                    <h4 class="fw-bold mb-4 text-sena-green"><i class="bi bi-trophy me-2"></i>Proyectos Destacados</h4>
                    <div class="row g-4">
                        @foreach($programa->historiasExito as $historia)
                        <div class="col-12">
                            <div class="p-3 bg-sena-accent rounded shadow-sm mb-2">
                                <h6 class="fw-bold mb-1">{{ $historia->titulo }}</h6>
                                <small class="text-muted">{{ $historia->resumen ?? '' }}</small>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            @endif
        </div>
        <!-- Columna lateral (sidebar) -->
        <div class="col-lg-4">
            <div class="card shadow border-0 rounded-lg mb-4 animate__animated animate__fadeInRight">
                <div class="card-body">
                    <h5 class="fw-bold mb-3 text-sena-blue"><i class="bi bi-info-circle me-2"></i>Información general</h5>
                    <ul class="list-unstyled mb-4">
                        <li class="mb-2"><i class="bi bi-diagram-3 icon-small text-sena-green"></i> <strong>Red:</strong> {{ $programa->red->nombre ?? 'N/A' }}</li>
                        <li class="mb-2"><i class="bi bi-mortarboard icon-small text-sena-green"></i> <strong>Nivel:</strong> {{ $programa->nivelFormacion->nombre ?? 'N/A' }}</li>
                        <li class="mb-2"><i class="bi bi-laptop icon-small text-sena-green"></i> <strong>Modalidad:</strong> {{ $programa->modalidad ?? 'N/A' }}</li>
                        <li class="mb-2"><i class="bi bi-clock icon-small text-sena-yellow"></i> <strong>Jornada:</strong> {{ $programa->jornada ?? 'N/A' }}</li>
                        <li class="mb-2"><i class="bi bi-people icon-small text-sena-blue"></i> <strong>Cupos:</strong> {{ $programa->cupos ?? 'N/A' }}</li>
                        <li class="mb-2"><i class="bi bi-hash icon-small text-sena-blue"></i> <strong>Ficha:</strong> {{ $programa->numero_ficha ?? 'N/A' }}</li>
                        <li class="mb-2"><i class="bi bi-building icon-small text-sena-blue"></i> <strong>Centro:</strong> {{ $programa->centro->nombre ?? 'N/A' }}</li>
                        <li class="mb-2"><i class="bi bi-pin-map icon-small text-sena-blue"></i> <strong>Municipio:</strong> {{ $programa->municipio->nombre ?? 'N/A' }}</li>
                    </ul>
                    @php
                        // Usar enlace de inscripción si existe, si no, dejar el botón deshabilitado
                        $enlaceInscripcion = $programa->customContents()
                            ? $programa->customContents()->where('key', 'enlace_inscripcion')->value('value')
                            : null;
                    @endphp
                    <a id="inscripcion" href="{{ $enlaceInscripcion ? $enlaceInscripcion : '#' }}" class="btn fw-semibold mb-2 w-100" style="background: var(--sena-green); color: #fff; border: none;">
                        <i class="bi bi-pencil-square me-2"></i>Inscribirme ahora
                    </a>
                    <a href="{{ route('public.programasDeFormacion.index') }}" class="btn btn-outline-sena w-100 fw-semibold">
                        <i class="bi bi-arrow-left me-2"></i>Volver a programas
                    </a>
                </div>
            </div>
            {{-- Card de perfil de instructor o fallback --}}
            @php
                $instructor = $programa->instructor;
                if (!$instructor) {
                    $nombre = $programa->customContents()->where('key', 'perfil_instructor_general_nombre')->value('value') ?? 'INSTRUCTOR SENA';
                    $apellidos = $programa->customContents()->where('key', 'perfil_instructor_general_apellidos')->value('value') ?? '';
                    $perfil_profesional = $programa->customContents()->where('key', 'perfil_instructor_general_perfil')->value('value') ?? 'Instructor certificado SENA. Comprometido con la formación de calidad y el desarrollo de competencias para el trabajo.';
                    $experiencia = $programa->customContents()->where('key', 'perfil_instructor_general_experiencia')->value('value') ?? 'Experiencia en formación profesional integral y acompañamiento a aprendices.';
                    $correo = $programa->customContents()->where('key', 'perfil_instructor_general_correo')->value('value') ?? 'contacto@sena.edu.co';
                    $instructor = (object) compact('nombre', 'apellidos', 'perfil_profesional', 'experiencia', 'correo');
                }
            @endphp
            @include('public.programas._instructor_card', ['instructor' => $instructor])
        </div>
    </div>
    <!-- FIN ROW PRINCIPAL -->
   
@endsection