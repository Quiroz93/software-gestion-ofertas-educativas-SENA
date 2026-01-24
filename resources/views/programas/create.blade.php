@extends('layouts.app')

@section('title', 'Programas')

@section('content_header')
<div class="d-flex justify-content-between align-items-center">
    <h1 class="m-0">
        <i class="fas fa-plus-circle text-primary"></i>
        Agregar programa
    </h1>

    <a href="{{route('programas.index')}}" class="btn btn-outline-secondary">
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

            <form action="{{ route('programas.store') }}" method="POST">
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
                        <label for="requisitos">
                            <strong>Requisitos</strong>
                        </label>
                        <textarea
                            name="requisitos"
                            id="requisitos"
                            class="form-control"
                            rows="3"
                            placeholder="Ingrese los requisitos del programa"
                        ></textarea>
                    </div>

                    <div class="form-group">
                        <label for="duracion_meses">
                            <strong>Duración (meses)</strong>
                        </label>
                        <input
                            type="number"
                            name="duracion_meses"
                            id="duracion_meses"
                            class="form-control"
                            placeholder="Ingrese la duración en meses"
                        >
                    </div>
                    <div>
                        <label for="red_id">
                            <strong>Red de Conocimiento</strong>
                        </label>
                        <select
                            name="red_id"
                            id="red_id"
                            class="form-control"
                        >
                            @foreach ($redes as $red)
                                <option value="{{ $red->id }}">{{ $red->nombre }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="nivel_formacion_id">
                            <strong>Nivel de Formación</strong>
                        </label>
                        <select
                            name="nivel_formacion_id"
                            id="nivel_formacion_id"
                            class="form-control"
                        >
                            @foreach ($nivelFormacion as $nivel)
                                <option value="{{ $nivel->id }}">{{ $nivel->nombre }}</option>
                            @endforeach
                        </select>
                    </div>

                </div>

                {{-- FOOTER --}}
                <div class="card-footer d-flex justify-content-end">
                    <a href="{{route('programas.index')}}" class="btn btn-outline-secondary me-1">
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
