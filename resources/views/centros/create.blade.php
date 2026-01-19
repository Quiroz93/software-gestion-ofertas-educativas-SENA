@extends('layouts.app')

@section('title', 'Agregar Centro')

@section('content_header')
<div class="d-flex justify-content-between align-items-center">
    <h1 class="m-0">
        <i class="fas fa-plus-circle text-primary"></i>
        Agregar Centro
    </h1>

    <a href="{{ route('centros.index') }}" class="btn btn-outline-secondary">
        <i class="fas fa-arrow-left"></i>
        Volver
    </a>
</div>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            {{-- Errores de validación --}}
            @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <h5 class="alert-heading"><i class="fas fa-exclamation-triangle"></i> Errores de validación</h5>
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            @endif

            {{-- Tarjeta del Formulario --}}
            @can('centros.create')
            <div class="card card-outline card-primary shadow-sm">
                <div class="card-header">
                    <h3 class="card-title">Información del Centro</h3>
                </div>

                <form action="{{ route('centros.store') }}" method="POST" class="form-horizontal">
                    @csrf

                    <div class="card-body">
                        {{-- Nombre del Centro --}}
                        <div class="form-group row">
                            <label for="nombre" class="col-sm-2 col-form-label">Nombre del Centro</label>
                            <div class="col-sm-10">
                                <input type="text"
                                    class="form-control @error('nombre') is-invalid @enderror"
                                    id="nombre"
                                    name="nombre"
                                    value="{{ old('nombre') }}"
                                    placeholder="Ingrese el nombre del centro"
                                    required>
                                @error('nombre')
                                <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        {{-- Dirección --}}
                        <div class="form-group row">
                            <label for="direccion" class="col-sm-2 col-form-label">Dirección</label>
                            <div class="col-sm-10">
                                <input type="text"
                                    class="form-control @error('direccion') is-invalid @enderror"
                                    id="direccion"
                                    name="direccion"
                                    value="{{ old('direccion') }}"
                                    placeholder="Ingrese la dirección del centro"
                                    required>
                                @error('direccion')
                                <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        {{-- Teléfono --}}
                        <div class="form-group row">
                            <label for="telefono" class="col-sm-2 col-form-label">Teléfono</label>
                            <div class="col-sm-10">
                                <input type="tel"
                                    class="form-control @error('telefono') is-invalid @enderror"
                                    id="telefono"
                                    name="telefono"
                                    value="{{ old('telefono') }}"
                                    placeholder="Ingrese el teléfono del centro">
                                @error('telefono')
                                <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        {{-- Correo --}}
                        <div class="form-group row">
                            <label for="correo" class="col-sm-2 col-form-label">Correo</label>
                            <div class="col-sm-10">
                                <input type="email"
                                    class="form-control @error('correo') is-invalid @enderror"
                                    id="correo"
                                    name="correo"
                                    value="{{ old('correo') }}"
                                    placeholder="Ingrese el correo del centro">
                                @error('correo')
                                <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    {{-- Pie del formulario --}}
                    <div class="card-footer">
                        <div class="float-right">
                            <a href="{{ route('centros.index') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-times"></i> Cancelar
                            </a>
                            <button type="submit" class="btn btn-outline-success">
                                <i class="fas fa-save"></i> Guardar Centro
                            </button>
                        </div>
                    </div>
                </form>
            </div>
            @else
            <div class="alert alert-danger">
                <i class="fas fa-ban"></i> No estás autorizado para crear centros.
            </div>
            @endcan
        </div>
    </div>
</div>
@endsection