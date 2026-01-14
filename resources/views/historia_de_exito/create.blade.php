@extends('layouts.app')

@section('title', 'Historias de éxito')

@section('content_header')
<div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1 class="m-0">Agregar Historia</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="">Competencias</a></li>
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
                    <h3 class="card-title">Información de la Historia</h3>
                </div>

                <form action="{{-- logica de crear historias de exito --}}" method="POST" class="form-horizontal">
                    @csrf

                    <div class="card-body">
                        {{-- Nombre de la Historia de Éxito --}}
                        <div class="form-group row">
                            <label for="nombre" class="col-sm-2 col-form-label">Nombre</label>
                            <div class="col-sm-10">
                                <input type="text"
                                    placeholder="Ingrese el nombre de la Historia de Éxito"
                                    name="nombre"
                                    id="nombre"
                                    class="form-control">
                        </div>
                    </div>

                    {{-- titulo de la Historia de Éxito --}}
                        <div class="form-group row">
                            <label for="titulo" class="col-sm-2 col-form-label">Titulo</label>
                            <div class="col-sm-10">
                                <input type="text"
                                    placeholder="Ingrese el titulo de la Historia de Éxito"
                                    name="titulo"
                                    id="titulo"
                                    class="form-control">
                        </div>
                    </div>

                    {{-- Descripción de la Historia de Éxito --}}
                    <div class="form-group row">
                        <label for="descripcion" class="col-sm-2 col-form-label">Descripción</label>
                        <div class="col-sm-10">
                            <textarea placeholder="Descripcion de la Historia de exito"
                            name="descripcion" 
                            id="descripcion" 
                            class="form-control"></textarea>
                        </div>
                    </div>

                    {{-- fecha de la Historia de Éxito --}}
                        <div class="form-group row">
                            <label for="fecha" class="col-sm-2 col-form-label">Fecha</label>
                            <div class="col-sm-10">
                                <input type="date"
                                    placeholder="Ingrese la fecha de la Historia de Éxito"
                                    name="fecha"
                                    id="fecha"
                                    class="form-control">
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
                                <i class="fas fa-save"></i> Guardar Historia
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection