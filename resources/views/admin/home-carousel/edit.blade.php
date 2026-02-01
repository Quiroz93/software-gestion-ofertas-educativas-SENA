@extends('layouts.bootstrap')

@section('title', 'Editar Slide - Carousel del Home')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            {{-- Header --}}
            <div class="d-flex align-items-center justify-content-between mb-4">
                <div>
                    <h1 class="h3 mb-1">
                        <i class="bi bi-pencil-square text-sena"></i> Editar slide
                    </h1>
                    <p class="text-muted">Modifica la información del slide: "{{ $homeCarousel->title }}"</p>
                </div>
            </div>

            {{-- Card con formulario --}}
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    @include('admin.home-carousel._form')
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
