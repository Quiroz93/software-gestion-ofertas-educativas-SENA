@extends('layouts.app')

@section('title', 'Competencias')

@section('content_header')
<div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1 class="m-0">Agregar Competencia</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('centro.index') }}">Competencias</a></li>
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
            @can('create_competencias')
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Información de la Competencia</h3>
                </div>

                <form action="{{-- logica de crear competencias --}}" method="POST" class="form-horizontal">
                    @csrf

                    <div class="card-body">
                        {{-- Nombre del Centro --}}
                        <div class="form-group row">
                            <label for="nombre" class="col-sm-2 col-form-label">Nombre de la competencia</label>
                            <div class="col-sm-10">
                                <input type="text"
                                    placeholder="Ingrese el nombre de la Competencia"
                                    name="nombre"
                                    id="nombre"
                                    class="form-control">
                        </div>
                    </div>

                    {{-- Descripción del Centro --}}
                    <div class="form-group row">
                        <label for="descripcion" class="col-sm-2 col-form-label">Descripción</label>
                        <div class="col-sm-10">
                            <textarea placeholder="Descripcion de la competencia"
                            name="descripcion" 
                            id="descripcion" 
                            class="form-control"></textarea>
                        </div>
                    </div>

                    {{-- Pie del formulario --}}
                    <div class="card-footer">
                        <div class="float-right">
                            <a href="{{-- logica de regreso --}}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Cancelar
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Guardar Competencia
                            </button>
                        </div>
                    </div>
                </form>
            </div>
            @else
            <div class="alert alert-danger">
                <i class="fas fa-ban"></i> No estás autorizado para crear competencias.
            </div>
            @endcan
        </div>
    </div>
</div>
@endsection