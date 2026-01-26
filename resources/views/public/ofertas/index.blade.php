@extends('layouts.public')

@section('title', 'Ofertas Educativas | Centro CATA')

@section('content')

{{-- ===================== --}}
{{-- Banner principal --}}
{{-- ===================== --}}
<section class="bg-ligth text-white position-relative" style="font-family: 'worksans sans-serif';">

    <img src="{{ asset('images/oferta4.jpeg') }}"
         class="w-100 position-absolute top-0 start-0 h-100 object-fit-cover opacity-50 editable"
         data-model="oferta"
         data-model-id="0"
         data-key="banner_image"
         data-type="image"
         alt="Oferta educativa CATA">

    <div class="container position-relative py-5 text-dark">
        <div class="row">
            <div class="col-lg-8">

                <h1 class="display-5 fw-bold editable"
                    data-model="oferta"
                    data-model-id="0"
                    data-key="banner_title"
                    data-type="text">
                    {{ getCustomContent('oferta', 'banner_title', 'Primera Oferta Educativa Centro SENA CATA') }}
                </h1>

                <p class="lead mt-3 editable"
                   data-model="oferta"
                   data-model-id="0"
                   data-key="banner_subtitle"
                   data-type="text">
                    {{ getCustomContent('oferta', 'banner_subtitle', 'Centro Agro Empresarial y Turístico de los Andes') }}
                </p>

                <p class="mt-4 editable"
                   data-model="oferta"
                   data-model-id="0"
                   data-key="banner_slogan"
                   data-type="text">
                    {{ getCustomContent('oferta', 'banner_slogan', 'Fórmate hoy para transformar tu futuro profesional con educación pertinente, gratuita y de alta calidad.') }}
                </p>

            </div>
        </div>
    </div>
</section>

@can('public_content.edit')
    <div class="alert alert-info">
        Modo edición activado - Haz clic en cualquier elemento editable
    </div>
@endcan

{{-- ===================== --}}
{{-- Sección motivacional --}}
{{-- ===================== --}}
<section class="py-5 bg-light" style="font-family: 'worksans sans-serif';">
    <div class="container text-center">

        <h2 class="fw-bold mb-3 editable"
            data-model="oferta"
            data-model-id="0"
            data-key="motivational_title"
            data-type="text">
            {{ getCustomContent('oferta', 'motivational_title', 'Educación que transforma regiones') }}
        </h2>

        <p class="lead editable"
           data-model="oferta"
           data-model-id="0"
           data-key="motivational_text"
           data-type="text">
            {{ getCustomContent('oferta', 'motivational_text', 'En el Centro CATA formamos talento humano con competencias reales para el sector agroempresarial y turístico, contribuyendo al desarrollo sostenible de los Andes.') }}
        </p>
        </p>

    </div>
</section>

{{-- ===================== --}}
{{-- Listado de ofertas --}}
{{-- ===================== --}}
<section class="py-5" style="font-family: 'worksans sans-serif';">
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
                        <img src="{{ $oferta->custom('imagen')
                            ? asset('storage/' . $oferta->custom('imagen'))
                            : asset('images/ofertas/default.jpg') }}"
                             class="card-img-top"
                             alt="{{ $oferta->nombre }}">

                        <div class="card-body d-flex flex-column">

                            <h5 class="card-title">
                                {{ $oferta->custom('titulo', $oferta->nombre) }}
                            </h5>

                            <p class="card-text text-muted">
                                {{ Str::limit($oferta->custom('descripcion', ''), 120) }}
                            </p>

                            <ul class="list-unstyled small mb-3">
                                <li>
                                    <strong>Inicio:</strong>
                                    {{ is_string($oferta->fecha_inicio) ? \Carbon\Carbon::parse($oferta->fecha_inicio)->format('d/m/Y') : $oferta->fecha_inicio?->format('d/m/Y') }}
                                </li>
                                <li>
                                    <strong>Fin:</strong>
                                    {{ is_string($oferta->fecha_fin) ? \Carbon\Carbon::parse($oferta->fecha_fin)->format('d/m/Y') : $oferta->fecha_fin?->format('d/m/Y') }}
                                </li>
                                <li>
                                    <strong>Modalidad:</strong>
                                    {{ $oferta->custom('modalidad', 'N/A') }}
                                </li>
                            </ul>

                            <a href="{{ route('public.ofertasEducativas.show', $oferta->id) }}"
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
<section class="py-5 bg-primary text-white" style="font-family: 'worksans sans-serif';">
    <div class="container text-center">

        <h2 class="fw-bold editable"
            data-model="oferta"
            data-model-id="0"
            data-key="cta_title"
            data-type="text">
            {{ getCustomContent('oferta', 'cta_title', 'Inscripciones abiertas') }}
        </h2>

        <p class="lead editable"
           data-model="oferta"
           data-model-id="0"
           data-key="cta_text"
           data-type="text">
            {{ getCustomContent('oferta', 'cta_text', 'Da el primer paso hacia tu proyecto de vida. La formación que necesitas está a tu alcance.') }}
        </p>
        </p>

    </div>
</section>

@endsection