@extends('layouts.public')

<div>
    <!-- No surplus words or unnecessary actions. - Marcus Aurelius -->
</div>

@section('title', 'Ofertas Educativas | Centro CATA')

@section('content')

{{-- ===================== --}}
{{-- Banner principal --}}
{{-- ===================== --}}
<section class="bg-dark text-white position-relative">

    <img src="{{ asset('images/banners/oferta-cata.jpg') }}"
         class="w-100 position-absolute top-0 start-0 h-100 object-fit-cover opacity-50"
         alt="Oferta educativa CATA">

    <div class="container position-relative py-5">
        <div class="row">
            <div class="col-lg-8">

                <h1 class="display-5 fw-bold editable"
                    data-model="oferta"
                    data-model-id="0"
                    data-key="banner_title">
                    Primera Oferta Educativa
                    Centro SENA CATA
                </h1>

                <p class="lead mt-3 editable"
                   data-model="oferta"
                   data-model-id="0"
                   data-key="banner_subtitle">
                    Centro Agro Empresarial y Turístico de los Andes
                </p>

                <p class="mt-4 editable"
                   data-model="oferta"
                   data-model-id="0"
                   data-key="banner_slogan">
                    Fórmate hoy para transformar tu futuro profesional
                    con educación pertinente, gratuita y de alta calidad.
                </p>

            </div>
        </div>
    </div>
</section>

{{-- ===================== --}}
{{-- Sección motivacional --}}
{{-- ===================== --}}
<section class="py-5 bg-light">
    <div class="container text-center">

        <h2 class="fw-bold mb-3 editable"
            data-model="oferta"
            data-model-id="0"
            data-key="motivational_title">
            Educación que transforma regiones
        </h2>

        <p class="lead editable"
           data-model="oferta"
           data-model-id="0"
           data-key="motivational_text">
            En el Centro CATA formamos talento humano con competencias
            reales para el sector agroempresarial y turístico,
            contribuyendo al desarrollo sostenible de los Andes.
        </p>

    </div>
</section>

{{-- ===================== --}}
{{-- Listado de ofertas --}}
{{-- ===================== --}}
<section class="py-5">
    <div class="container">

        <div class="row mb-4">
            <div class="col text-center">
                <h2 class="fw-bold">Ofertas Educativas Disponibles</h2>
                <p class="text-muted">
                    Conoce nuestras oportunidades de formación vigentes
                </p>
            </div>
        </div>

        <div class="row g-4">

            @forelse($ofertas as $oferta)
                <div class="col-md-6 col-lg-4">

                    <div class="card h-100 shadow-sm border-0">

                        {{-- Imagen de la oferta --}}
                        <img src="{{ $oferta->imagen
                            ? asset('storage/' . $oferta->imagen)
                            : asset('images/ofertas/default.jpg') }}"
                             class="card-img-top"
                             alt="{{ $oferta->titulo }}">

                        <div class="card-body d-flex flex-column">

                            <h5 class="card-title">
                                {{ $oferta->titulo }}
                            </h5>

                            <p class="card-text text-muted">
                                {{ Str::limit($oferta->descripcion, 120) }}
                            </p>

                            <ul class="list-unstyled small mb-3">
                                <li>
                                    <strong>Inicio:</strong>
                                    {{ $oferta->fecha_inicio?->format('d/m/Y') }}
                                </li>
                                <li>
                                    <strong>Fin:</strong>
                                    {{ $oferta->fecha_fin?->format('d/m/Y') }}
                                </li>
                                <li>
                                    <strong>Modalidad:</strong>
                                    {{ $oferta->modalidad }}
                                </li>
                            </ul>

                            <a href="{{ route('public.ofertas.show', $oferta) }}"
                               class="btn btn-outline-primary mt-auto">
                                Ver detalles
                            </a>

                        </div>
                    </div>

                </div>
            @empty
                <div class="col text-center">
                    <p class="text-muted">
                        Actualmente no hay ofertas educativas publicadas.
                    </p>
                </div>
            @endforelse

        </div>
    </div>
</section>

{{-- ===================== --}}
{{-- Banner inferior --}}
{{-- ===================== --}}
<section class="py-5 bg-primary text-white">
    <div class="container text-center">

        <h2 class="fw-bold editable"
            data-model="oferta"
            data-model-id="0"
            data-key="cta_title">
            Inscripciones abiertas
        </h2>

        <p class="lead editable"
           data-model="oferta"
           data-model-id="0"
           data-key="cta_text">
            Da el primer paso hacia tu proyecto de vida.
            La formación que necesitas está a tu alcance.
        </p>

    </div>
</section>

@endsection

@section('scripts')
@endsection

@section('styles')
@can('public_content.edit')
<style>
    .editable {
        position: relative;
        cursor: pointer;
    }

    .editable:hover {
        outline: 2px dashed #ffc107;
        background-color: rgba(255, 193, 7, 0.1);
        transition: all 0.2s ease;
    }

    .editable:hover::after {
        content: '\f4cb'; /* Bootstrap Icon pencil-square */
        font-family: 'bootstrap-icons';
        position: absolute;
        top: 5px;
        right: 5px;
        background: #ffc107;
        color: #000;
        padding: 4px 8px;
        border-radius: 4px;
        font-size: 12px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.2);
    }
</style>
@endcan
@endsection