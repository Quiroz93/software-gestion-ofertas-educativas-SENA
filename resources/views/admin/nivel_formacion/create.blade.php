@extends('layouts.admin')

@section('title', 'Nivel de Formación')

@section('content_header')
<div class="d-flex justify-content-between align-items-center">
    <h1 class="m-0">
        <i class="fas fa-plus-circle text-primary"></i>
        Agregar Nivel de Formación
    </h1>

    <a href="{{route('niveles_formacion.index')}}" class="btn btn-outline-secondary">
        <i class="fas fa-arrow-left"></i>
        Volver
    </a>
</div>
@stop

@section('content')

    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">

            <div class="card card-outline card-primary shadow-sm">

                {{-- HEADER --}}
                <div class="card-header">
                    <h3 class="card-title fw-bold">
                        Información del nivel de formación
                    </h3>
                </div>

                <form action="{{ route('niveles_formacion.store') }}" method="POST">
                    @csrf

                    {{-- BODY --}}
                    <div class="card-body">

                        <div class="form-group">
                            <label for="nombre">
                                <strong>Nombre</strong>
                            </label>
                            <input type="text" name="nombre" id="nombre" class="form-control"
                                placeholder="Ingrese el nombre del nivel de formación">
                        </div>

                        <div class="form-group">
                            <label for="descripcion">
                                <strong>Descripción</strong>
                            </label>
                            <textarea name="descripcion" id="descripcion" rows="3" class="form-control"
                                placeholder="Descripción del nivel de formación"></textarea>
                        </div>
                    </div>

                {{-- FOOTER --}}
                <div class="card-footer d-flex justify-content-end">
                    <a href="{{route('niveles_formacion.index')}}" class="btn btn-outline-secondary me-1">
                        <i class="fas fa-times"></i>
                        Cancelar
                    </a>

                        <button type="submit" class="btn btn-outline-success">
                            <i class="fas fa-save"></i>
                            Guardar nivel
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>

@endsection
