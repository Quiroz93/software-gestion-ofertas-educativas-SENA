@extends('layouts.admin')

@section('title', 'Crear Registro Rechazado')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="h3 mb-0">
                        <i class="bi bi-person-x text-danger me-2"></i>
                        Nuevo Registro Rechazado
                    </h1>
                    <p class="text-muted mb-0">Registro manual de preinscrito rechazado</p>
                </div>
                <div>
                    <a href="{{ route('admin.preinscritos-rechazados.index') }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-left"></i> Volver
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header bg-success text-white">
            <h5 class="mb-0">
                <i class="bi bi-plus-circle"></i> Datos del Registro
            </h5>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('admin.preinscritos-rechazados.store') }}">
                @csrf

                <div class="row g-3">
                    <div class="col-md-6">
                        <label for="nombre_completo" class="form-label">Nombre Completo</label>
                        <input type="text" class="form-control" id="nombre_completo" name="nombre_completo" value="{{ old('nombre_completo') }}" required>
                    </div>

                    <div class="col-md-3">
                        <label for="tipo_documento" class="form-label">Tipo de Documento</label>
                        <select class="form-select" id="tipo_documento" name="tipo_documento" required>
                            <option value="">Seleccione...</option>
                            @foreach($tiposDocumento as $valor => $etiqueta)
                                <option value="{{ $valor }}" {{ old('tipo_documento') === $valor ? 'selected' : '' }}>
                                    {{ $etiqueta }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label for="numero_documento" class="form-label">Número de Documento</label>
                        <input type="text" class="form-control" id="numero_documento" name="numero_documento" value="{{ old('numero_documento') }}" required>
                    </div>

                    <div class="col-md-4">
                        <label for="telefono" class="form-label">Teléfono</label>
                        <input type="text" class="form-control" id="telefono" name="telefono" value="{{ old('telefono') }}">
                    </div>

                    <div class="col-md-4">
                        <label for="correo" class="form-label">Correo Electrónico</label>
                        <input type="email" class="form-control" id="correo" name="correo" value="{{ old('correo') }}">
                    </div>

                    <div class="col-md-4">
                        <label for="programa" class="form-label">Programa</label>
                        <input type="text" class="form-control" id="programa" name="programa" value="{{ old('programa') }}">
                    </div>

                    <div class="col-md-4">
                        <label for="motivo" class="form-label">Motivo de Rechazo</label>
                        <select class="form-select" id="motivo" name="motivo" required>
                            <option value="">Seleccione...</option>
                            @foreach($motivos as $motivo)
                                <option value="{{ $motivo }}" {{ old('motivo') === $motivo ? 'selected' : '' }}>
                                    {{ ucwords(str_replace('_', ' ', $motivo)) }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label for="fila_excel" class="form-label">Fila en Archivo</label>
                        <input type="number" class="form-control" id="fila_excel" name="fila_excel" value="{{ old('fila_excel') }}" min="1">
                    </div>

                    <div class="col-md-12">
                        <label for="datos_json" class="form-label">Datos Originales (JSON)</label>
                        <textarea class="form-control" id="datos_json" name="datos_json" rows="4">{{ old('datos_json') }}</textarea>
                        <div class="form-text">Opcional. Use este campo para almacenar los datos del archivo original.</div>
                    </div>
                </div>

                <div class="mt-4">
                    <button type="submit" class="btn btn-success">
                        <i class="bi bi-check-circle"></i> Guardar Registro
                    </button>
                    <a href="{{ route('admin.preinscritos-rechazados.index') }}" class="btn btn-outline-secondary">
                        Cancelar
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
