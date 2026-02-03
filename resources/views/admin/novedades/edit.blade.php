@extends('layouts.admin')

@section('title', 'Editar Novedad')

@section('content_header')
<div class="d-flex justify-content-between align-items-center">
    <h1 class="m-0">
        <i class="bi bi-pencil text-primary"></i>
        Editar Novedad
    </h1>
    <a href="{{ route('novedades.show', $novedad) }}" class="btn btn-outline-secondary">
        <i class="bi bi-arrow-left"></i>
        Volver
    </a>
</div>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-8 offset-lg-2">
            <div class="card card-outline card-primary">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="bi bi-form-check"></i>
                        Formulario de Edición
                    </h3>
                </div>

                <form action="{{ route('novedades.update', $novedad) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="card-body">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <strong>¡Error!</strong> Revisa los campos:
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <div class="alert alert-info">
                            <strong>Preinscrito:</strong> {{ $novedad->preinscrito->nombre_completo }}<br>
                            <strong>Documento:</strong> {{ $novedad->preinscrito->numero_documento }}<br>
                            <strong>Creado por:</strong> {{ $novedad->createdBy->name ?? 'Sistema' }} el {{ $novedad->created_at->format('d/m/Y H:i') }}
                        </div>

                        <div class="mb-3">
                            <label for="tipo_novedad_id" class="form-label">
                                Tipo de Novedad
                            </label>
                            <select class="form-select @error('tipo_novedad_id') is-invalid @enderror" 
                                    id="tipo_novedad_id" name="tipo_novedad_id">
                                <option value="">-- Selecciona un tipo --</option>
                                @foreach ($tiposNovedad as $tipo)
                                    <option value="{{ $tipo->id }}" {{ old('tipo_novedad_id', $novedad->tipo_novedad_id) == $tipo->id ? 'selected' : '' }}>
                                        {{ $tipo->nombre }}
                                    </option>
                                @endforeach
                            </select>
                            @error('tipo_novedad_id')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="estado" class="form-label">
                                Estado <span class="text-danger">*</span>
                            </label>
                            <select class="form-select @error('estado') is-invalid @enderror" 
                                    id="estado" name="estado" required>
                                @foreach ($estados as $valor => $etiqueta)
                                    <option value="{{ $valor }}" {{ old('estado', $novedad->estado) === $valor ? 'selected' : '' }}>
                                        {{ $etiqueta }}
                                    </option>
                                @endforeach
                            </select>
                            @error('estado')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="descripcion" class="form-label">
                                Descripción <span class="text-danger">*</span>
                            </label>
                            <textarea class="form-control @error('descripcion') is-invalid @enderror" 
                                      id="descripcion" name="descripcion" rows="5" 
                                      required>{{ old('descripcion', $novedad->descripcion) }}</textarea>
                            @error('descripcion')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="comentario_cambio" class="form-label">
                                Comentario del Cambio
                            </label>
                            <textarea class="form-control @error('comentario_cambio') is-invalid @enderror" 
                                      id="comentario_cambio" name="comentario_cambio" rows="3" 
                                      placeholder="Agrega un comentario si cambias el estado...">{{ old('comentario_cambio') }}</textarea>
                            @error('comentario_cambio')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="card-footer">
                        <button type="submit" class="btn btn-outline-primary">
                            <i class="bi bi-save"></i>
                            Guardar Cambios
                        </button>
                        <a href="{{ route('novedades.show', $novedad) }}" class="btn btn-outline-secondary">
                            <i class="bi bi-times"></i>
                            Cancelar
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
