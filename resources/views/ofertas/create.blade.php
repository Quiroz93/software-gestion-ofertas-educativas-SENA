@extends('layouts.app')

@section('title', 'Ofertas')

@section('content_header')
<div class="d-flex justify-content-between align-items-center">
    <h1 class="m-0">
        <i class="fas fa-plus-circle text-primary"></i>
        Agregar oferta
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

            <form action="{{ route('ofertas.store') }}" method="POST" class="form-horizontal">
                @csrf

                {{-- BODY --}}
                <div class="card-body">

                    {{-- Nombre --}}
                    <div class="form-group">
                        <label for="nombre"><strong>Nombre</strong></label>
                        <input type="text"
                               name="nombre"
                               id="nombre"
                               placeholder="Ingrese el nombre de la oferta"
                               class="form-control">
                    </div>

                    {{-- Centro --}}
                    <div class="form-group">
                        <label for="centro_id"><strong>Centro</strong></label>
                        <select name="centro_id" id="centro_id" class="form-control" required>
                            <option value="">Seleccione un centro</option>
                            @if($centros)
                                @foreach($centros as $centro)
                                    <option value="{{ $centro->id }}">{{ $centro->nombre }}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>

                    {{-- Año --}}
                    <div class="form-group">
                        <label for="año"><strong>Año</strong></label>
                        <input type="number"
                               name="año"
                               id="año"
                               placeholder="Ingrese el año"
                               class="form-control"
                               min="2000"
                               max="2099">
                    </div>

                    {{-- Fecha inicio --}}
                    <div class="form-group">
                        <label for="fecha_inicio"><strong>Fecha inicio</strong></label>
                        <input type="date"
                               name="fecha_inicio"
                               id="fecha_inicio"
                               class="form-control">
                    </div>

                    {{-- Fecha fin --}}
                    <div class="form-group">
                        <label for="fecha_fin"><strong>Fecha fin</strong></label>
                        <input type="date"
                               name="fecha_fin"
                               id="fecha_fin"
                               class="form-control">
                    </div>

                    {{-- Estado --}}
                    <div class="form-group">
                        <label for="estado"><strong>Estado</strong></label>
                        <select name="estado" id="estado" class="form-control">
                            <option value="">Seleccione</option>
                            <option value="activo">Activo</option>
                            <option value="inactivo">Inactivo</option>
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
                        Guardar oferta
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>

@endsection
