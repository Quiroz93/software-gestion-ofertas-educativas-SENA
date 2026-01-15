@extends('layouts.app')

@section('title', 'instructores')

@section('content_header')
<div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1 class="m-0">Agregar instructor</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="">Instructores</a></li>
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
                    <h3 class="card-title">Información del instructor</h3>
                </div>

                <form action="{{-- logica de crear instructores --}}" method="POST" class="form-horizontal">
                    @csrf

                    <div class="card-body">
                        {{-- Nombre del Instructor --}}
                        <div class="form-group row">
                            <label for="nombre" class="col-sm-2 col-form-label">Nombre</label>
                            <div class="col-sm-10">
                                <input type="text"
                                    placeholder="Ingrese el nombre del Instructor"
                                    name="nombre"
                                    id="nombre"
                                    class="form-control">
                            </div>
                        </div>
                            <div class="form-group row">
                            <label for="apellido" class="col-sm-2 col-form-label">Apellido</label>
                            <div class="col-sm-10">
                                <input type="text"
                                    placeholder="Ingrese el apellido del Instructor"
                                    name="apellido"
                                    id="apellido"
                                    class="form-control">
                            </div>
                        </div>
                        {{-- perfil del Instructor --}}
                        <div class="form-group row">
                            <label for="perfil" class="col-sm-2 col-form-label">Perfil</label>
                            <div class="col-sm-10">
                                <textarea placeholder="Perfil del Instructor"
                                    name="perfil"
                                    id="perfil"
                                    class="form-control"></textarea>
                            </div>
                        </div>

                        {{-- experiencia del Instructor --}}
                        <div class="form-group row">
                            <label for="experiencia" class="col-sm-2 col-form-label">Experiencia</label>
                            <div class="col-sm-10">
                                <input type="text"
                                    placeholder="Ingrese la experiencia del Instructor"
                                    name="experiencia"
                                    id="experiencia"
                                    class="form-control">
                            </div>
                        </div>

                        {{-- correo del Instructor --}}
                        <div class="form-group row">
                            <label for="correo" class="col-sm-2 col-form-label">Correo</label>
                            <div class="col-sm-10">
                                <input type="email"
                                    placeholder="Ingrese el correo del Instructor"
                                    name="correo"
                                    id="correo"
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
                                <i class="fas fa-save"></i> Guardar Instructor
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection