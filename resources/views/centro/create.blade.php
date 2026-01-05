@extends('adminlte::page')

@section('title', 'Centros')

@section('content')
<div class="container">
    <div class="row">

        {{-- Título --}}
        <div class="col-12">
            <h1 class="text-center font-weight-bold mb-3">Agregar Centro</h1>
        </div>

        {{-- Botón volver --}}
        <div class="col-12 mb-3">
            <a href="{{ route('centro.index') }}" class="btn btn-primary">
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
        <div class="col-12">
            <form action="{{ route('centro.store') }}" method="POST">
                @csrf

                <div class="row">
                    <div class="col-6">
                        <label class="form-label mt-3">Nombre del Centro</label>
                        <input type="text" class="form-control" name="nombre" for="nombre"
                               value="{{ old('nombre') }}" required>
                    </div>

                    <div class="col-6">
                        <label class="form-label mt-3">Dirección</label>
                        <input type="text" class="form-control" name="direccion"
                               value="{{ old('direccion') }}" required>
                    </div>
                </div>

                <div class="row">
                    <div class="col-6">
                        <label class="form-label mt-3">Teléfono</label>
                        <input type="tel" class="form-control" name="telefono"
                               value="{{ old('telefono') }}">
                    </div>

                    <div class="col-6">
                        <label class="form-label mt-3">Correo</label>
                        <input type="email" class="form-control" name="correo"
                               value="{{ old('correo') }}">
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
        </div>

    </div>
</div>
@endsection
