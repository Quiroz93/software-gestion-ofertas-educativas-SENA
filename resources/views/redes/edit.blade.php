@extends('layouts.app')

@section('title', 'Redes')

@section('content_header')
<div class="d-flex justify-content-between align-items-center">
    <h1 class="m-0">
        <i class="fas fa-network-wired text-primary"></i>
        Editar red
    </h1>

    <a href="{{-- logica de regreso --}}" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i>
        Volver
    </a>
</div>
@stop

@section('content')

<div class="row">
    <div class="col-md-8 col-lg-6 mx-auto">

        <div class="card card-outline card-primary shadow-sm">

            {{-- HEADER --}}
            <div class="card-header">
                <h3 class="card-title fw-bold">
                    Información de la red
                </h3>
            </div>

            <form action="{{-- logica de crear niveles de formacion --}}" method="POST">
                @csrf
                {{-- @method('PUT') --}}

                {{-- BODY --}}
                <div class="card-body">

                    {{-- Nombre --}}
                    <div class="form-group">
                        <label for="nombre">
                            <strong>Nombre</strong>
                        </label>
                        <input type="text"
                               name="nombre"
                               id="nombre"
                               class="form-control"
                               value="{{-- logica para mostrar el nombre de la red --}}"
                               required>
                    </div>

                    {{-- Descripción --}}
                    <div class="form-group">
                        <label for="perfil">
                            <strong>Descripción</strong>
                        </label>
                        <textarea name="perfil"
                                  id="perfil"
                                  rows="4"
                                  class="form-control"
                                  required>{{-- logica para mostrar la descripcion de la red --}}</textarea>
                    </div>

                </div>

                {{-- FOOTER --}}
                <div class="card-footer d-flex justify-content-between">
                    <a href="{{-- logica de regreso --}}" class="btn btn-outline-secondary">
                        <i class="fas fa-times"></i>
                        Cancelar
                    </a>

                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i>
                        Guardar red
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>

@endsection
