@extends('layouts.app')

@section('title', 'Redes')

@section('content_header')
<div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1 class="m-0">Editar Red</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="">Redes</a></li>
                <li class="breadcrumb-item active">Editar</li>
            </ol>
        </div>
    </div>
</div>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-8 offset-md-2">

            {{-- Tarjeta del Formulario --}}

            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Información de Redes</h3>
                </div>

                <form action="{{-- logica de crear niveles de formacion --}}" method="POST" class="form-horizontal">
                    @csrf

                    <div class="card-body">
                        {{-- Nombre del Nivel de Formación --}}
                        <div class="form-group row">
                            <label for="nombre" class="col-sm-2 col-form-label">Nombre</label>
                            <div class="col-sm-10">
                                <input type="text"
                                    value=" {{-- logica para mostrar el nombre de la red --}} "
                                    name="nombre"
                                    id="nombre"
                                    class="form-control">
                            </div>
                        </div>
                        {{-- descripcion del Nivel de Formación --}}
                        <div class="form-group row">
                            <label for="perfil" class="col-sm-2 col-form-label">Perfil</label>
                            <div class="col-sm-10">
                                <textarea value=" {{-- logica para mostrar la descripcion de la red --}} "
                                    name="perfil"
                                    id="perfil"
                                    class="form-control"></textarea>
                            </div>
                        </div>

                    </div>

                    {{-- Pie del formulario --}}
                    <div class="card-footer">
                        <div class="float-right">
                            <a href="{{-- logica de regreso --}}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Cancelar
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Guardar red
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection