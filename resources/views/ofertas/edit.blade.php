@extends('layouts.app')

@section('title', 'Ofertas')

@section('content_header')
<div class="d-flex justify-content-between align-items-center">
    <h1 class="m-0">
        <i class="fas fa-edit text-primary"></i>
        Editar oferta
    </h1>

    <a href="{{ route('ofertas.index') }}" class="btn btn-outline-secondary">
        <i class="fas fa-arrow-left"></i>
        Volver
    </a>
</div>
@stop

@section('content')

<div class="row">
    <div class="col-md-8 offset-md-2">

        <div class="card card-outline card-primary shadow-sm">

            {{-- HEADER --}}
            <div class="card-header">
                <h3 class="card-title fw-bold">
                    Información de la oferta
                </h3>
            </div>

            <form action="{{ route('ofertas.update', $oferta) }}" method="POST" class="form-horizontal">
                @csrf
                @method('PUT')

                {{-- BODY --}}
                <div class="card-body">

                    {{-- Nombre --}}
                    <div class="form-group">
                        <label for="nombre"><strong>Nombre</strong></label>
                        <input type="text"
                               name="nombre"
                               id="nombre"
                               value="{{ $oferta->nombre }}"
                               class="form-control">
                    </div>

                    {{-- Año --}}
                    <div class="form-group">
                        <label for="anio"><strong>Año</strong></label>
                        <input type="number"
                               name="anio"
                               id="anio"
                               value="{{ $oferta->anio }}"
                               class="form-control">
                    </div>

                    {{-- Fecha inicio --}}
                    <div class="form-group">
                        <label for="fecha_inicio"><strong>Fecha inicio</strong></label>
                        <input type="date"
                               name="fecha_inicio"
                               id="fecha_inicio"
                               value="{{ $oferta->fecha_inicio }}"
                               class="form-control">
                    </div>

                    {{-- Fecha final --}}
                    <div class="form-group">
                        <label for="fecha_final"><strong>Fecha final</strong></label>
                        <input type="date"
                               name="fecha_final"
                               id="fecha_final"
                               value="{{ $oferta->fecha_final }}"
                               class="form-control">
                    </div>

                    {{-- Estado --}}
                    <div class="form-group">
                        <label for="estado"><strong>Estado</strong></label>
                        <select name="estado" id="estado" class="form-control">
                            <option value="activo" {{ $oferta->estado == 'activo' ? 'selected' : '' }}>Activo</option>
                            <option value="inactivo" {{ $oferta->estado == 'inactivo' ? 'selected' : '' }}>Inactivo</option>
                        </select>
                    </div>

                </div>

                {{-- FOOTER --}}
                <div class="card-footer d-flex justify-content-end">
                    <a href="{{ route('ofertas.index') }}" class="btn btn-outline-secondary me-1">
                        <i class="fas fa-times"></i>
                        Cancelar
                    </a>

                    <button type="submit" class="btn btn-outline-success">
                        <i class="fas fa-save"></i>
                        Guardar cambios
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>

@endsection
