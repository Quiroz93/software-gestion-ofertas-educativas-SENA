@extends('layouts.app')

@section('title', 'Oferta Educativa')

@section('content')

<!-- HERO / JUMBOTRON -->

<div class="container-fluid bg-primary text-white py-5 mb-5">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-7">
                <h1 class="display-5 fw-bold">Impulsa tu futuro profesional</h1>
                <p class="lead mt-3">
                    Descubre nuestra oferta educativa diseñada para fortalecer tus competencias,
                    mejorar tu perfil profesional y abrir nuevas oportunidades laborales.
                </p>
                <div class="mt-4">
                    <a href="#ofertas" class="btn btn-light btn-lg me-2">Ver programas</a>
                    <a href="#contacto" class="btn btn-outline-light btn-lg">Solicitar información</a>
                </div>
            </div>
            <div class="col-lg-5 text-center d-none d-lg-block">
                <!-- Imagen ilustrativa: reemplazar por asset real -->
                <img src="{{ asset('images/education-hero.png') }}" alt="Educación" class="img-fluid rounded shadow">
            </div>
        </div>
    </div>
</div>

<!-- SECCIÓN DE BENEFICIOS -->

<div class="container mb-5">
    <div class="row text-center mb-4">
        <div class="col">
            <h2 class="fw-bold">¿Por qué elegirnos?</h2>
            <p class="text-muted">Formación de calidad orientada a resultados reales</p>
        </div>
    </div>


<div class="row g-4">
    <div class="col-md-4">
        <div class="card h-100 shadow-sm border-0">
            <div class="card-body text-center">
                <i class="bi bi-mortarboard fs-1 text-primary mb-3"></i>
                <h5 class="card-title">Programas actualizados</h5>
                <p class="card-text text-muted">
                    Contenidos alineados con las necesidades actuales del mercado laboral.
                </p>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card h-100 shadow-sm border-0">
            <div class="card-body text-center">
                <i class="bi bi-people fs-1 text-primary mb-3"></i>
                <h5 class="card-title">Docentes expertos</h5>
                <p class="card-text text-muted">
                    Profesionales con experiencia práctica y enfoque pedagógico.
                </p>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card h-100 shadow-sm border-0">
            <div class="card-body text-center">
                <i class="bi bi-award fs-1 text-primary mb-3"></i>
                <h5 class="card-title">Certificación</h5>
                <p class="card-text text-muted">
                    Obtén certificados que respaldan y fortalecen tu perfil profesional.
                </p>
            </div>
        </div>
    </div>
</div>


</div>

<!-- LISTADO DE OFERTAS EDUCATIVAS -->

<div class="container mb-5" id="ofertas">
    <div class="row mb-4">
        <div class="col text-center">
            <h2 class="fw-bold">Nuestra Oferta Educativa</h2>
            <p class="text-muted">Explora los programas disponibles y elige el ideal para ti</p>
        </div>
    </div>


<div class="row g-4">
    <!-- CARD PROGRAMA -->
    <div class="col-md-6 col-lg-4">
        <div class="card h-100 shadow-sm">
            <img src="{{ asset('images/programa-1.jpg') }}" class="card-img-top" alt="Programa 1">
            <div class="card-body">
                <h5 class="card-title">Técnico en Desarrollo de Software</h5>
                <p class="card-text text-muted">
                    Aprende a crear aplicaciones web y de escritorio usando tecnologías modernas.
                </p>
            </div>
            <div class="card-footer bg-white border-0 d-flex justify-content-between align-items-center">
                <span class="badge bg-success">Disponible</span>
                <a href="#" class="btn btn-sm btn-primary">Ver detalles</a>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-lg-4">
        <div class="card h-100 shadow-sm">
            <img src="{{ asset('images/programa-2.jpg') }}" class="card-img-top" alt="Programa 2">
            <div class="card-body">
                <h5 class="card-title">Gestión Administrativa</h5>
                <p class="card-text text-muted">
                    Desarrolla habilidades en procesos administrativos y organizacionales.
                </p>
            </div>
            <div class="card-footer bg-white border-0 d-flex justify-content-between align-items-center">
                <span class="badge bg-success">Disponible</span>
                <a href="#" class="btn btn-sm btn-primary">Ver detalles</a>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-lg-4">
        <div class="card h-100 shadow-sm">
            <img src="{{ asset('images/programa-3.jpg') }}" class="card-img-top" alt="Programa 3">
            <div class="card-body">
                <h5 class="card-title">Marketing Digital</h5>
                <p class="card-text text-muted">
                    Estrategias digitales, redes sociales y posicionamiento de marca.
                </p>
            </div>
            <div class="card-footer bg-white border-0 d-flex justify-content-between align-items-center">
                <span class="badge bg-warning text-dark">Próximamente</span>
                <a href="#" class="btn btn-sm btn-outline-secondary disabled">No disponible</a>
            </div>
        </div>
    </div>
</div>


</div>

<!-- LLAMADO A LA ACCIÓN -->

<div class="container-fluid bg-light py-5" id="contacto">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h3 class="fw-bold">¿Deseas más información?</h3>
                <p class="text-muted mb-0">
                    Contáctanos y te asesoraremos para que elijas el programa ideal para ti.
                </p>
            </div>
            <div class="col-md-4 text-md-end mt-3 mt-md-0">
                <a href="#" class="btn btn-primary btn-lg">Contáctanos</a>
            </div>
        </div>
    </div>
</div>
@endsection
