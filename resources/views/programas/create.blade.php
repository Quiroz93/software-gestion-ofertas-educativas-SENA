@extends('layouts.app')

@section('title', 'programa')

@section('content_header')
<div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1 class="m-0">Agregar Programa</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="">Programas</a></li>
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
                    <h3 class="card-title">Información del Programa</h3>
                </div>

                <form action="{{-- logica de crear historias de exito --}}" method="POST" class="form-horizontal">
                    @csrf

                    <div class="card-body">
                        {{-- Nombre del Programa --}}
                        <div class="form-group row">
                            <label for="nombre" class="col-sm-2 col-form-label">Nombre</label>
                            <div class="col-sm-10">
                                <input type="text"
                                    placeholder="Ingrese el nombre del programa"
                                    name="nombre"
                                    id="nombre"
                                    class="form-control">
                        </div>
                    </div>
                    {{-- Descripción del programa --}}
                    <div class="form-group row">
                        <label for="descripcion" class="col-sm-2 col-form-label">Descripción</label>
                        <div class="col-sm-10">
                            <textarea placeholder="Ingrese la descripción del programa"
                            name="descripcion" 
                            id="descripcion" 
                            class="form-control"></textarea>
                        </div>
                    </div>

                    {{-- requisito del programa --}}
                        <div class="form-group row">
                            <label for="requisito" class="col-sm-2 col-form-label">Requisito</label>
                            <div class="col-sm-10">
                                <textarea placeholder="Ingrese el requisito del programa"
                                    name="requisito"
                                    id="requisito"
                                    class="form-control"></textarea>
                        </div>
                    </div>


                    {{-- meses de duracion del programa --}}
                        <div class="form-group row">
                            <label for="fecha" class="col-sm-2 col-form-label">Duración en meses</label>
                            <div class="col-sm-10">
                                <input type="number"
                                    placeholder="Ingrese la duración en meses del programa"
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
                                <i class="fas fa-save"></i> Guardar Programa
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection