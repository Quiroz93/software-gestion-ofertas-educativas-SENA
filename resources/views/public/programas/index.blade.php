@extends('layouts.bootstrap')

@section('title', 'Programas de Formación')

@section('content')
<div class="container-fluid">
    <!-- Hero Section -->
    <div class="bg-primary text-white py-5 mb-5 rounded-bottom-lg">
        <div class="container">
            <div class="row align-items-center g-4">
                <div class="col-lg-8">
                    <h1 class="display-4 fw-bold mb-3">Programas de Formación</h1>
                    <p class="lead mb-4">
                        <i class="bi bi-info-circle me-2"></i>
                        Descubre nuestra oferta educativa diseñada para fortalecer tus competencias
                        y abrir nuevas oportunidades laborales
                    </p>
                    <a href="#listado" class="btn btn-light btn-lg">
                        <i class="bi bi-arrow-down me-2"></i>Ver Programas
                    </a>
                </div>
                <div class="col-lg-4 text-center">
                    <i class="bi bi-book-half display-3 text-light opacity-50"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Benefits Section -->
    <div class="container mb-5 py-4">
        <h3 class="h2 text-center fw-bold mb-5">¿Por qué elegirnos?</h3>
        <div class="row g-4">
            <div class="col-md-4">
                <div class="text-center">
                    <div class="bg-success bg-opacity-10 rounded-circle p-4 d-inline-block mb-3">
                        <i class="bi bi-check-circle text-success" style="font-size: 2rem;"></i>
                    </div>
                    <h5 class="fw-bold">Programas Actualizados</h5>
                    <p class="text-muted">Alineados con las tendencias del mercado laboral</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="text-center">
                    <div class="bg-primary bg-opacity-10 rounded-circle p-4 d-inline-block mb-3">
                        <i class="bi bi-person-check text-primary" style="font-size: 2rem;"></i>
                    </div>
                    <h5 class="fw-bold">Docentes Expertos</h5>
                    <p class="text-muted">Profesionales con experiencia real en la industria</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="text-center">
                    <div class="bg-warning bg-opacity-10 rounded-circle p-4 d-inline-block mb-3">
                        <i class="bi bi-award text-warning" style="font-size: 2rem;"></i>
                    </div>
                    <h5 class="fw-bold">Certificación</h5>
                    <p class="text-muted">Respaldo institucional y reconocimiento laboral</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters Section -->
    <div class="container mb-5">
        <div class="bg-light p-4 rounded-lg">
            <h5 class="fw-bold mb-4">
                <i class="bi bi-funnel me-2"></i>Filtrar Programas
            </h5>
            <form method="GET" class="row g-3">
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Red</label>
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
                    <label class="form-label fw-semibold">Nivel de Formación</label>
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
                    <a href="{{ url()->current() }}" class="btn btn-outline-secondary w-100">
                        <i class="bi bi-arrow-counterclockwise me-2"></i>Limpiar Filtros
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Programs List -->
    <div class="container mb-5" id="listado">
        <h3 class="h4 fw-bold mb-4">
            <i class="bi bi-grid-3x2-gap me-2 text-primary"></i>
            Programas Disponibles ({{ count($programas) }})
        </h3>

        @forelse ($programas as $programa)
            <div class="row mb-4">
                <div class="col-lg-12">
                    <div class="card border-0 shadow-sm hover-shadow transition rounded-lg overflow-hidden">
                        <div class="row g-0">
                            <!-- Image -->
                            <div class="col-md-3 bg-light d-flex align-items-center justify-content-center" style="min-height: 250px;">
                                <div class="text-center">
                                    <i class="bi bi-book-half text-primary" style="font-size: 3rem;"></i>
                                </div>
                            </div>

                            <!-- Content -->
                            <div class="col-md-9">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-start mb-2">
                                        <h5 class="card-title fw-bold text-primary">{{ $programa->nombre }}</h5>
                                        <span class="badge bg-success">
                                            <i class="bi bi-check-circle me-1"></i>Activo
                                        </span>
                                    </div>

                                    <p class="card-text text-muted mb-3">
                                        {{ Str::limit($programa->descripcion, 200) }}
                                    </p>

                                    <!-- Details -->
                                    <div class="row g-3 mb-3">
                                        <div class="col-auto">
                                            <small class="text-muted">
                                                <i class="bi bi-hourglass-split me-1 text-info"></i>
                                                <strong>{{ $programa->duracion_meses ?? 'N/D' }}</strong> meses
                                            </small>
                                        </div>
                                        <div class="col-auto">
                                            <small class="text-muted">
                                                <i class="bi bi-diagram-3 me-1 text-warning"></i>
                                                <strong>{{ $programa->red->nombre }}</strong>
                                            </small>
                                        </div>
                                        <div class="col-auto">
                                            <small class="text-muted">
                                                <i class="bi bi-mortarboard me-1 text-danger"></i>
                                                <strong>{{ $programa->nivelFormacion->nombre }}</strong>
                                            </small>
                                        </div>
                                    </div>

                                    <!-- Button -->
                                    <a href="{{ route('public.programasDeFormacion.show', $programa) }}"
                                       class="btn btn-primary btn-sm">
                                        <i class="bi bi-arrow-right me-1"></i>Ver Detalles Completos
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="alert alert-info text-center py-5">
                <i class="bi bi-info-circle me-2" style="font-size: 2rem;"></i>
                <p class="mb-0">No hay programas disponibles con los filtros seleccionados</p>
            </div>
        @endforelse

        <!-- Pagination -->
        @if(method_exists($programas, 'render'))
            <div class="d-flex justify-content-center mt-5">
                {{ $programas->links() }}
            </div>
        @endif
    </div>

    <!-- CTA Section -->
    <div class="bg-light py-5 rounded-lg mb-5">
        <div class="container text-center">
            <h3 class="h4 fw-bold mb-3">¿Necesitas más información?</h3>
            <p class="text-muted mb-4">Contacta con nuestro equipo de asesoría académica</p>
            <a href="mailto:info@example.com" class="btn btn-primary">
                <i class="bi bi-envelope me-2"></i>Enviar Consulta
            </a>
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
    
    .rounded-bottom-lg {
        border-radius: 0 0 1rem 1rem;
    }
    
    .rounded-lg {
        border-radius: 1rem;
    }
</style>
@endsection
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
