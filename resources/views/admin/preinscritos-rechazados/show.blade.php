@extends('layouts.admin')

@section('title', 'Detalle de Registro Rechazado')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="h3 mb-0">
                        <i class="bi bi-file-earmark-text me-2"></i>
                        Detalle de Registro Rechazado
                    </h1>
                </div>
                <div>
                    <a href="{{ route('admin.preinscritos-rechazados.index') }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-left"></i> Volver
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        {{-- Información Principal --}}
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-danger text-white">
                    <h5 class="mb-0">
                        <i class="bi bi-person-x"></i> 
                        Información del Registro
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="text-muted small">Nombre Completo</label>
                            <p class="h5">{{ $rechazado->nombre_completo }}</p>
                        </div>
                        <div class="col-md-6">
                            <label class="text-muted small">Tipo y Número de Documento</label>
                            <p class="h5">
                                <span class="badge bg-secondary">{{ strtoupper($rechazado->tipo_documento) }}</span>
                                {{ $rechazado->numero_documento }}
                            </p>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="text-muted small">Teléfono</label>
                            <p class="mb-0">
                                @if($rechazado->telefono)
                                    <i class="bi bi-phone"></i> {{ $rechazado->telefono }}
                                @else
                                    <span class="text-muted">No registrado</span>
                                @endif
                            </p>
                        </div>
                        <div class="col-md-6">
                            <label class="text-muted small">Correo Electrónico</label>
                            <p class="mb-0">
                                @if($rechazado->correo)
                                    <i class="bi bi-envelope"></i> {{ $rechazado->correo }}
                                @else
                                    <span class="text-muted">No registrado</span>
                                @endif
                            </p>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-12">
                            <label class="text-muted small">Programa</label>
                            <p class="mb-0">{{ $rechazado->programa ?: 'Sin programa' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Datos JSON Originales --}}
            <div class="card mt-3">
                <div class="card-header">
                    <h6 class="mb-0">
                        <i class="bi bi-code-square"></i> 
                        Datos Originales del Archivo
                    </h6>
                </div>
                <div class="card-body">
                    @php
                        $datos = is_string($rechazado->datos_json) 
                            ? json_decode($rechazado->datos_json, true) 
                            : $rechazado->datos_json;
                    @endphp
                    
                    @if(is_array($datos))
                        <div class="table-responsive">
                            <table class="table table-sm table-bordered">
                                <thead class="table-light">
                                    <tr>
                                        <th>Campo</th>
                                        <th>Valor</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($datos as $index => $valor)
                                        <tr>
                                            <td><strong>Campo {{ $index + 1 }}</strong></td>
                                            <td>{{ $valor ?: '(vacío)' }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <pre class="bg-light p-3 rounded">{{ $rechazado->datos_json }}</pre>
                    @endif
                </div>
            </div>
        </div>

        {{-- Panel Lateral --}}
        <div class="col-md-4">
            {{-- Motivo de Rechazo --}}
            <div class="card mb-3">
                <div class="card-header bg-warning">
                    <h6 class="mb-0">
                        <i class="bi bi-exclamation-triangle"></i> 
                        Motivo de Rechazo
                    </h6>
                </div>
                <div class="card-body">
                    @if($rechazado->motivo == 'documento_duplicado')
                        <div class="alert alert-warning mb-0">
                            <i class="bi bi-files"></i>
                            <strong>Documento Duplicado</strong>
                            <p class="mb-0 small mt-2">
                                El número de documento ya existe en la base de datos o aparece múltiples veces en el archivo.
                            </p>
                        </div>
                    @elseif($rechazado->motivo == 'sin_programa_asignado')
                        <div class="alert alert-info mb-0">
                            <i class="bi bi-question-circle"></i>
                            <strong>Sin Programa Asignado</strong>
                            <p class="mb-0 small mt-2">
                                No se pudo identificar o asignar un programa de formación válido.
                            </p>
                        </div>
                    @elseif($rechazado->motivo == 'datos_incompletos')
                        <div class="alert alert-secondary mb-0">
                            <i class="bi bi-exclamation-triangle"></i>
                            <strong>Datos Incompletos</strong>
                            <p class="mb-0 small mt-2">
                                Faltan datos obligatorios como nombre o número de documento.
                            </p>
                        </div>
                    @else
                        <div class="alert alert-danger mb-0">
                            <strong>{{ ucwords(str_replace('_', ' ', $rechazado->motivo)) }}</strong>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Información de Registro --}}
            <div class="card">
                <div class="card-header">
                    <h6 class="mb-0">
                        <i class="bi bi-info-circle"></i> 
                        Información Adicional
                    </h6>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <small class="text-muted">Fila del Archivo</small>
                        <p class="mb-0"><strong>{{ $rechazado->fila_excel }}</strong></p>
                    </div>
                    
                    <div class="mb-3">
                        <small class="text-muted">Fecha de Registro</small>
                        <p class="mb-0">{{ $rechazado->created_at->format('d/m/Y H:i') }}</p>
                    </div>
                </div>
            </div>

            {{-- Acciones --}}
            <div class="card mt-3">
                <div class="card-body">
                    <form action="{{ route('admin.preinscritos-rechazados.destroy', $rechazado->id) }}" 
                          method="POST"
                          onsubmit="return confirm('¿Está seguro de eliminar este registro?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger w-100">
                            <i class="bi bi-trash"></i> 
                            Eliminar Registro
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
