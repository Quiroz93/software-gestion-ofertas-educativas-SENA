@extends('layouts.app')

@section('title', 'Agregar Historia de éxito')

@section('content_header')
<div class="d-flex justify-content-between align-items-center">
    <h1 class="m-0">
        <i class="fas fa-plus-circle text-primary"></i>
        Agregar Historia de Éxito
    </h1>

    <a href="{{ route('historias.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i>
        Volver
    </a>
</div>
@stop

@section('content')

@can('historias.create')

<div class="row">
    <div class="col-md-8 offset-md-2">
        <div class="card card-outline card-primary shadow-sm">

            {{-- HEADER --}}
            <div class="card-header">
                <h3 class="card-title fw-bold">
                    Información de la historia
                </h3>
            </div>

            <form action="{{ route('historias.store') }}" method="POST">
                @csrf

                {{-- BODY --}}
                <div class="card-body">

                    <div class="form-group">
                        <label for="nombre">
                            <strong>Nombre</strong>
                        </label>
                        <input type="text"
                               name="nombre"
                               id="nombre"
                               class="form-control"
                               placeholder="Ingrese el nombre de la historia de éxito"
                               required>
                    </div>

                    <div class="form-group">
                        <label for="titulo">
                            <strong>Título</strong>
                        </label>
                        <input type="text"
                               name="titulo"
                               id="titulo"
                               class="form-control"
                               placeholder="Ingrese el título de la historia de éxito"
                               required>
                    </div>

                    <div class="form-group">
                        <label for="descripcion">
                            <strong>Descripción</strong>
                        </label>
                        <textarea name="descripcion"
                                  id="descripcion"
                                  rows="4"
                                  class="form-control"
                                  placeholder="Descripción de la historia de éxito"
                                  required></textarea>
                    </div>

                    <div class="form-group">
                        <label for="fecha">
                            <strong>Fecha</strong>
                        </label>
                        <input type="date"
                               name="fecha"
                               id="fecha"
                               class="form-control"
                               required>
                    </div>

                </div>

                {{-- FOOTER --}}
                <div class="card-footer d-flex justify-content-between">
                    <a href="{{ route('historias.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-times"></i>
                        Cancelar
                    </a>

                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i>
                        Guardar historia
                    </button>
                </div>
            </form>

        </div>
    </div>
</div>

@else
<div class="alert alert-danger">
    <i class="fas fa-ban"></i>
    No estás autorizado para crear historias de éxito.
</div>
@endcan

@endsection
