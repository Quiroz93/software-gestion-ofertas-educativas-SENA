@extends('layouts.admin')

@section('title', 'Programas')

@section('content_header')
<div class="d-flex justify-content-between align-items-center">
    <h1 class="m-0">
        <i class="fas fa-edit text-primary"></i>
        Editar programa
    </h1>

    <a href="{{route('programas.index')}}" class="btn btn-outline-secondary">
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
                <h3 class="card-title fw-bold text-uppercase">
                    Información del programa
                </h3>
            </div>

            <form action="{{ route('programas.update', $programa) }}" method="POST">
                @csrf
                @method('PUT')

                {{-- BODY --}}
                <div class="card-body">

                    <div class="form-group">
                        <label for="nombre">
                            <strong>Nombre</strong>
                        </label>
                        <input
                            type="text"
                            name="nombre"
                            id="nombre"
                            class="form-control"
                            value="{{ old('nombre', $programa->nombre) }}">
                    </div>

                    <div class="form-group">
                        <label for="numero_ficha">
                            <strong>Número de ficha</strong>
                        </label>
                        <input
                            type="text"
                            name="numero_ficha"
                            id="numero_ficha"
                            class="form-control"
                            value="{{ old('numero_ficha', $programa->numero_ficha) }}">
                    </div>

                    <div class="form-group">
                        <label for="descripcion">
                            <strong>Descripción</strong>
                        </label>
                        <textarea
                            name="descripcion"
                            id="descripcion"
                            class="form-control"
                            rows="3">{{ old('descripcion', $programa->descripcion) }}</textarea>
                    </div>

                    <div class="form-group">
                        <label for="requisito">
                            <strong>Requisitos</strong>
                        </label>
                        <textarea
                            name="requisitos"
                            id="requisitos"
                            class="form-control"
                            rows="3">{{ old('requisitos', $programa->requisitos) }}</textarea>
                    </div>

                    <div class="form-group">
                        <label for="duracion">
                            <strong>Duración (meses)</strong>
                        </label>
                        <input
                            type="number"
                            name="duracion_meses"
                            id="duracion_meses"
                            class="form-control"
                            value="{{ old('duracion_meses', $programa->duracion_meses) }}">
                    </div>

                    <div class="form-group">
                        <label for="modalidad">
                            <strong>Modalidad</strong>
                        </label>
                        <input type="text" name="modalidad" id="modalidad" class="form-control" value="{{ old('modalidad', $programa->modalidad) }}">
                    </div>

                    <div class="form-group">
                        <label for="jornada">
                            <strong>Jornada</strong>
                        </label>
                        <input type="text" name="jornada" id="jornada" class="form-control" value="{{ old('jornada', $programa->jornada) }}">
                    </div>

                    <div class="form-group">
                        <label for="titulo_otorgado">
                            <strong>Título Otorgado</strong>
                        </label>
                        <input type="text" name="titulo_otorgado" id="titulo_otorgado" class="form-control" value="{{ old('titulo_otorgado', $programa->titulo_otorgado) }}">
                    </div>

                    <div class="form-group">
                        <label for="codigo_snies">
                            <strong>Código SNIES</strong>
                        </label>
                        <input type="text" name="codigo_snies" id="codigo_snies" class="form-control" value="{{ old('codigo_snies', $programa->codigo_snies) }}">
                    </div>

                    <div class="form-group">
                        <label for="registro_calidad">
                            <strong>Registro de Calidad</strong>
                        </label>
                        <input type="text" name="registro_calidad" id="registro_calidad" class="form-control" value="{{ old('registro_calidad', $programa->registro_calidad) }}">
                    </div>

                    <div class="form-group">
                        <label for="fecha_registro">
                            <strong>Fecha de Registro</strong>
                        </label>
                        <input type="date" name="fecha_registro" id="fecha_registro" class="form-control" value="{{ old('fecha_registro', optional($programa->fecha_registro)->format('Y-m-d')) }}">
                    </div>

                    <div class="form-group">
                        <label for="fecha_actualizacion">
                            <strong>Fecha de Actualización</strong>
                        </label>
                        <input type="date" name="fecha_actualizacion" id="fecha_actualizacion" class="form-control" value="{{ old('fecha_actualizacion', optional($programa->fecha_actualizacion)->format('Y-m-d')) }}">
                    </div>

                    <div class="form-group">
                        <label for="estado">
                            <strong>Estado</strong>
                        </label>
                        <input type="text" name="estado" id="estado" class="form-control" value="{{ old('estado', $programa->estado) }}">
                    </div>

                    <div class="form-group">
                        <label for="observaciones">
                            <strong>Observaciones</strong>
                        </label>
                        <textarea name="observaciones" id="observaciones" class="form-control" rows="3">{{ old('observaciones', $programa->observaciones) }}</textarea>
                    </div>

                    <div class="form-group">
                        <label for="centro_id"><strong>Centro</strong></label>
                        <select name="centro_id" id="centro_id" class="form-control">
                            <option value="" disabled>Seleccione un centro</option>
                            @foreach($centros as $centro)
                            <option value="{{ $centro->id }}" {{ old('centro_id', $programa->centro_id) == $centro->id ? 'selected' : '' }}>{{ $centro->nombre }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="municipio_id"><strong>Municipio</strong></label>
                        <select name="municipio_id" id="municipio_id" class="form-control">
                            <option value="" disabled selected>Seleccione un municipio</option>
                            @foreach($municipios as $municipio)
                            <option value="{{ $municipio->id }}" {{ old('municipio_id', $programa->municipio_id) == $municipio->id ? 'selected' : '' }}>{{ $municipio->nombre }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="red_id"><strong>Red de Conocimiento</strong></label>
                        <select name="red_id" id="red_id" class="form-control">
                            <option value="" disabled>Seleccione una red</option>
                            @foreach($redes as $red)
                            <option value="{{ $red->id }}" {{ old('red_id', $programa->red_id) == $red->id ? 'selected' : '' }}>{{ $red->nombre }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="nivel_formacion_id"><strong>Nivel de Formación</strong></label>
                        <select name="nivel_formacion_id" id="nivel_formacion_id" class="form-control">
                            <option value="" disabled>Seleccione un nivel</option>
                            @foreach($nivel_formaciones as $nivel)
                            <option value="{{ $nivel->id }}" {{ old('nivel_formacion_id', $programa->nivel_formacion_id) == $nivel->id ? 'selected' : '' }}>{{ $nivel->nombre }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="cupos"><strong>Cupos</strong></label>
                        <input type="number" name="cupos" id="cupos" class="form-control" value="{{ old('cupos', $programa->cupos) }}">
                    </div>

                    <div class="form-group mt-3">
                        <div class="form-check">
                            <input
                                class="form-check-input"
                                type="checkbox"
                                id="is_featured"
                                name="is_featured"
                                value="1"
                                {{ old('is_featured', $programa->is_featured) ? 'checked' : '' }}
                            >
                            <label class="form-check-label" for="is_featured">
                                <strong>Destacar en home</strong>
                            </label>
                        </div>
                        <small class="text-muted d-block mt-1">Se mostrara en Programas Destacados del home.</small>
                    </div>
                </div>

        </div>

        {{-- FOOTER --}}
        <div class="card-footer d-flex justify-content-end">
            <a href="{{ route('programas.index') }}" class="btn btn-outline-secondary me-1">
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

@endsection