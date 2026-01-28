@extends('layouts.admin')

@section('title', 'Editar Competencia')

@section('content_header')
<div class="d-flex justify-content-between align-items-center">
    <h1 class="m-0">
        <i class="fas fa-edit text-primary"></i>
        Editar Competencia
    </h1>

    <a href="{{ route('competencias.index') }}" class="btn btn-outline-secondary">
        <i class="fas fa-arrow-left"></i>
        Volver
    </a>
</div>
@stop

@section('content')

@can('competencias.edit')

<div class="row">
    <div class="col-md-8 offset-md-2">
        <div class="card card-outline card-primary shadow-sm">

            {{-- HEADER --}}
            <div class="card-header">
                <h3 class="card-title fw-bold">
                    Información de la competencia
                </h3>
            </div>

            <form action="" method="POST">
                @csrf
                @method('PUT')

                {{-- BODY --}}
                <div class="card-body">

                    <div class="form-group">
                        <label for="nombre">
                            <strong>Nombre de la competencia</strong>
                        </label>
                        <input type="text"
                               name="nombre"
                               id="nombre"
                               value=""
                               class="form-control"
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
                                  required></textarea>
                    </div>

                </div>

                {{-- FOOTER --}}
                <div class="card-footer d-flex justify-content-end">
                    <a href="{{ route('competencias.index') }}" class="btn btn-outline-secondary me-1">
                        <i class="fas fa-times"></i>
                        Cancelar
                    </a>

                    <button type="submit" class="btn btn-outline-success">
                        <i class="fas fa-save"></i>
                        Guardar cambios
                    </button>
                </div>
            </form>

        </div>
    </div>
</div>

@else
<div class="alert alert-danger">
    <i class="fas fa-ban"></i>
    No estás autorizado para editar competencias.
</div>
@endcan

@endsection
