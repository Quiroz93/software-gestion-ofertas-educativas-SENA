@extends('layouts.app')

@section('title', 'Ofertas')

@section('content_header')
<div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1 class="m-0">Agregar Oferta</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="">Ofertas</a></li>
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
                    <h3 class="card-title">Información de la oferta</h3>
                </div>

                <form action="{{-- logica de crear oferta--}}" method="POST" class="form-horizontal">
                    @csrf

                    <div class="card-body">
                        {{-- Nombre de la oferta --}}
                        <div class="form-group row">
                            <label for="nombre" class="col-sm-2 col-form-label">Nombre</label>
                            <div class="col-sm-10">
                                <input type="text"
                                    placeholder="Ingrese el nombre de la Oferta"
                                    name="nombre"
                                    id="nombre"
                                    class="form-control">
                        </div>
                    </div>
                    {{-- año de la Oferta --}}
                        <div class="form-group row">
                            <label for="fecha" class="col-sm-2 col-form-label">Año</label>
                            <div class="col-sm-10">
                                <input type="date"
                                    placeholder="Ingrese el año de la Oferta"
                                    name="fecha"
                                    id="fecha"
                                    class="form-control">
                        </div>
                    </div>
                    {{-- fecha inicial de la Oferta --}}
                        <div class="form-group row">
                            <label for="fecha_inicio" class="col-sm-2 col-form-label">Fecha Inicio</label>
                            <div class="col-sm-10">
                                <input type="date"
                                    placeholder="Ingrese la fecha de inicio de la Oferta"
                                    name="fecha_inicio"
                                    id="fecha_inicio"
                                    class="form-control">
                        </div>
                    </div>
                    {{-- fecha final de la Oferta --}}
                        <div class="form-group row">
                            <label for="fecha_final" class="col-sm-2 col-form-label">Fecha Final</label>
                            <div class="col-sm-10">
                                <input type="date"
                                    placeholder="Ingrese la fecha final de la Oferta"
                                    name="fecha_final"
                                    id="fecha_final"
                                    class="form-control">
                        </div>
                    </div>
                    {{-- estado de la Oferta --}}
                        <div class="form-group row">
                            <label for="estado" class="col-sm-2 col-form-label">Estado</label>
                            <div class="col-sm-10">
                                <select name="estado" id="estado" class="form-control">
                                    <option value="">seleccione</option>
                                    <option value="activo">Activo</option>
                                    <option value="inactivo">Inactivo</option>
                                </select>

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