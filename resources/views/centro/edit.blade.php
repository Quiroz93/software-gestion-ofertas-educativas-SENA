@extends('layouts.app')

@section('title', 'Centros')

@section('content')


<div class="container">
    <div class="row">

        {{-- Título --}}
        <div class="col-12">
            <h1 class="text-center font-weight-bold mb-3">Editar Centro</h1>
        </div>

        {{-- Botón volver --}}
        <div class="col-12 mb-3"><a href="{{ route('centro.index') }}" class="btn btn-primary">
                Volver
            </a>
        </div>

        {{-- Errores de validación --}}
        @if ($errors->any())
        <div class="col-12">
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
        @endif

        {{-- Formulario --}}
        <div class="col-12 md-4">
            @canany(['centros.edit','centros.update'])
            <form action="{{ route('centro.update', $centro->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row">
                    <div class="col-6">
                        <label class="form-label mt-3">Nombre del Centro</label>
                        <input type="text" class="form-control" name="nombre"
                            value="{{ $centro->nombre }}" @old('nombre') required>
                    </div>

                    <div class="col-6">
                        <label class="form-label mt-3">Dirección</label>
                        <input type="text" class="form-control" name="direccion" value="{{ $centro->direccion }}" @old('direccion') required>
                    </div>
                </div>

                <div class="row">
                    <div class="col-6">
                        <label class="form-label mt-3">Teléfono</label>
                        <input type="tel" class="form-control" name="telefono" value="{{ $centro->telefono }}" @old('telefono')>
                    </div>

                    <div class="col-6">
                        <label class="form-label mt-3">Correo</label>
                        <input type="email" class="form-control" name="correo" value="{{ $centro->correo }}" @old('correo')>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12 text-center mt-4">
                        <button type="submit" class="btn btn-success">
                            Guardar Centro
                        </button>
                    </div>
                </div>

            </form>
            <!-- Fin del formulario -->
            @else
            <div class="alert alert-danger">
                <i class="fas fa-ban"></i> No estás autorizado para editar este centro.
            </div>
            @endcan
        </div>

    </div>
</div>

@endsection