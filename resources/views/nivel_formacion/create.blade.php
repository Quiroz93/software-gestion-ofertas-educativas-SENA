@extends('layouts.app')

@section('title', 'Nivel de formacion')

@section('content_header')
<div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1 class="m-0">Agregar Nivel de Formación</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="">Nivel de Formación</a></li>
                <li class="breadcrumb-item active">Crear</li>
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
                    <h3 class="card-title">Información del Nivel de formación</h3>
                </div>

                <form action="{{-- logica de crear niveles de formacion --}}" method="POST" class="form-horizontal">
                    @csrf

                    <div class="card-body">
                        {{-- Nombre del Nivel de Formación --}}
                        <div class="form-group row">
                            <label for="nombre" class="col-sm-2 col-form-label">Nombre</label>
                            <div class="col-sm-10">
                                <input type="text"
                                    placeholder="Ingrese el nombre del Nivel de Formación"
                                    name="nombre"
                                    id="nombre"
                                    class="form-control">
                            </div>
                        </div>
                        {{-- descripcion del Nivel de Formación --}}
                        <div class="form-group row">
                            <label for="perfil" class="col-sm-2 col-form-label">Perfil</label>
                            <div class="col-sm-10">
                                <textarea placeholder="descripción del Nivel de Formación"
                                    name="perfil"
                                    id="perfil"
                                    class="form-control"></textarea>
                            </div>
                        </div>

                    </di>

                    {{-- Pie del formulario --}}
                    <div class="card-footer">
                        <div class="float-right">
                            <a href="{{-- logica de regreso --}}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Cancelar
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Guardar Nivel
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection