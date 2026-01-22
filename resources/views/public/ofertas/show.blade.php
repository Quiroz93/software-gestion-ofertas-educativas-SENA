@extends('layouts.public')

@section('title', $oferta->nombre)

@section('content')

{{-- HERO / BANNER --}}
<section class="p-5 rounded mb-4"
    style="background-color: {{ $oferta->custom('hero_bg_color', '#f8f9fa') }};">

    <div class="d-flex align-items-start justify-content-between">

        <div>
            {{-- Título editable --}}
            <h1 class="fw-bold editable"
                data-model="oferta"
                data-model-id="{{ $oferta->id }}"
                data-key="banner_title"
                data-type="text">

                {{ $oferta->custom('banner_title', $oferta->nombre) }}
            </h1>

            {{-- Slogan editable --}}
            <p class="lead editable"
                data-model="oferta"
                data-model-id="{{ $oferta->id }}"
                data-key="slogan"
                data-type="text">

                {{ $oferta->custom('slogan', 'Inscripciones abiertas') }}
            </p>
        </div>

    </div>
</section>

<section class="mb-5">
    <h3 class="fw-bold editable"
        data-model="oferta"
        data-model-id="{{ $oferta->id }}"
        data-key="description_title"
        data-type="text">
        {{ $oferta->custom('description_title', 'Descripción de la oferta') }}
    </h3>
    <p class="editable"
        data-model="oferta"
        data-model-id="{{ $oferta->id }}"
        data-key="descripcion"
        data-type="textarea">
        {{ $oferta->descripcion }}
    </p>

    <ul class="list-unstyled">
        <li><strong>Fecha inicio:</strong> {{ is_string($oferta->fecha_inicio) ? \Carbon\Carbon::parse($oferta->fecha_inicio)->format('d/m/Y') : $oferta->fecha_inicio?->format('d/m/Y') }}</li>
        <li><strong>Fecha fin:</strong> {{ is_string($oferta->fecha_fin) ? \Carbon\Carbon::parse($oferta->fecha_fin)->format('d/m/Y') : $oferta->fecha_fin?->format('d/m/Y') }}</li>
    </ul>
</section>

@endsection