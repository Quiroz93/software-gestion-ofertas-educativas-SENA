@extends('layouts.app')

@section('title', 'Programas')

@section('content_header')
<div class="d-flex justify-content-between align-items-center">
    <h1 class="m-0">
        <i class="fas fa-plus-circle text-primary"></i>
        Agregar programa
    </h1>

    <a href="{{-- lógica de regreso --}}" class="btn btn-outline-secondary">
        <i class="fas fa-arrow-left"></i>
        Volver
    </a>
</div>
@stop

@section('content')

<div class="row">
    <div class="col-md-8 offset-md-2">

        <div class="card card-outline card-primary shadow-sm">

            {{-- HEADER --}}
            <div class="card-header">
                <h3 class="card-title fw-bold text-uppercase">
                    Información del programa
                </h3>
            </div>

            <form action="{{-- lógica de crear programa --}}" method="POST">
                @csrf

                {{-- BODY --}}
                <div class="card-body">

                    <div class="form-group">
                        <label for="nombre">
                            <strong>Nombre</strong>
                        </label>
                        <input
                            type="text"
                            name="nombre"
                            id="nombre"
                            class="form-control"
                            placeholder="Ingrese el nombre del programa"
                        >
                    </div>

                    <div class="form-group">
                        <label for="descripcion">
                            <strong>Descripción</strong>
                        </label>
                        <textarea
                            name="descripcion"
                            id="descripcion"
                            class="form-control"
                            rows="3"
                            placeholder="Ingrese la descripción del programa"
                        ></textarea>
                    </div>

                    <div class="form-group">
                        <label for="requisito">
                            <strong>Requisitos</strong>
                        </label>
                        <textarea
                            name="requisito"
                            id="requisito"
                            class="form-control"
                            rows="3"
                            placeholder="Ingrese los requisitos del programa"
                        ></textarea>
                    </div>

                    <div class="form-group">
                        <label for="duracion">
                            <strong>Duración (meses)</strong>
                        </label>
                        <input
                            type="number"
                            name="duracion"
                            id="duracion"
                            class="form-control"
                            placeholder="Ingrese la duración en meses"
                        >
                    </div>

                </div>

                {{-- FOOTER --}}
                <div class="card-footer d-flex justify-content-end">
                    <a href="{{-- enlace al index de ofertas --}}" class="btn btn-outline-secondary me-1">
                        <i class="fas fa-times"></i>
                        Cancelar
                    </a>
                    <button type="submit" class="btn btn-outline-success">
                        <i class="fas fa-save"></i>
                        Guardar programa
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>

@endsection
