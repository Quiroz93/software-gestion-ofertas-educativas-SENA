@extends('layouts.app')

@section('title', 'Agregar Instructor')

@section('content_header')
<div class="d-flex justify-content-between align-items-center">
    <h1 class="m-0">
        <i class="fas fa-plus-circle text-primary"></i>
        Agregar Instructor
    </h1>

    <a href="{{ route('instructores.index') }}" class="btn btn-outline-secondary">
        <i class="fas fa-arrow-left"></i>
        Volver
    </a>
</div>
@stop

@section('content')

@can('instructores.create')

<div class="row">
    <div class="col-md-8 offset-md-2">
        <div class="card card-outline card-primary shadow-sm">

            {{-- HEADER --}}
            <div class="card-header">
                <h3 class="card-title fw-bold">
                    Información del instructor
                </h3>
            </div>

            <form action="" method="POST">
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
                               placeholder="Ingrese el nombre del instructor"
                               required>
                    </div>

                    <div class="form-group">
                        <label for="apellido">
                            <strong>Apellido</strong>
                        </label>
                        <input type="text"
                               name="apellido"
                               id="apellido"
                               class="form-control"
                               placeholder="Ingrese el apellido del instructor"
                               required>
                    </div>

                    <div class="form-group">
                        <label for="perfil">
                            <strong>Perfil</strong>
                        </label>
                        <textarea name="perfil"
                                  id="perfil"
                                  rows="3"
                                  class="form-control"
                                  placeholder="Perfil del instructor"
                                  required></textarea>
                    </div>

                    <div class="form-group">
                        <label for="experiencia">
                            <strong>Experiencia</strong>
                        </label>
                        <input type="text"
                               name="experiencia"
                               id="experiencia"
                               class="form-control"
                               placeholder="Ingrese la experiencia del instructor"
                               required>
                    </div>

                    <div class="form-group">
                        <label for="correo">
                            <strong>Correo</strong>
                        </label>
                        <input type="email"
                               name="correo"
                               id="correo"
                               class="form-control"
                               placeholder="Ingrese el correo del instructor"
                               required>
                    </div>

                </div>

                {{-- FOOTER --}}
                <div class="card-footer d-flex justify-content-end">
                    <a href="{{ route('instructores.index') }}" class="btn btn-outline-secondary me-1">
                        <i class="fas fa-times"></i>
                        Cancelar
                    </a>

                    <button type="submit" class="btn btn-outline-success">
                        <i class="fas fa-save"></i>
                        Guardar instructor
                    </button>
                </div>
            </form>

        </div>
    </div>
</div>

@else
<div class="alert alert-danger">
    <i class="fas fa-ban"></i>
    No estás autorizado para crear instructores.
</div>
@endcan

@endsection
