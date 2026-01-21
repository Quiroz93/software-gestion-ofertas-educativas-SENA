<div>
    <!-- Be present above all else. - Naval Ravikant -->
</div>

@extends('layouts.public')

@section('title', $oferta->nombre)

@section('content')

{{-- HERO / BANNER --}}
<section class="p-5 rounded mb-4"
    style="background-color: {{ $oferta->custom('hero_bg_color', '#f8f9fa') }}">

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

        {{-- Ícono de edición --}}
        @can('public_content.edit')
        <button class="btn btn-sm btn-outline-warning ms-3 edit-trigger"
            title="Editar contenido">
            <i class="bi bi-pencil-square"></i>
        </button>
        @endcan
    </div>
</section>

{{-- CONTENIDO DE NEGOCIO (NO editable aquí) --}}
<section class="mb-5">
    <h3>Descripción de la oferta</h3>
    <p>{{ $oferta->descripcion }}</p>

    <ul class="list-unstyled">
        <li><strong>Fecha inicio:</strong> {{ $oferta->fecha_inicio }}</li>
        <li><strong>Fecha fin:</strong> {{ $oferta->fecha_fin }}</li>
    </ul>
</section>

@endsection
@section('scripts')
@endsection

@section('styles')

<style>
    .editable {
        position: relative;
    }

    @can('public_content.edit') .editable:hover {
        outline: 2px dashed #ffc107;
        cursor: pointer;
    }

    @endcan
</style>


@endsection