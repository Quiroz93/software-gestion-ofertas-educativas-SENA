@extends('layouts.admin')

@section('title', 'Detalle de Novedad')

@section('content_header')
<div class="d-flex justify-content-between align-items-center">
    <h1 class="m-0">
        <i class="bi bi-exclamation-triangle text-primary"></i>
        Detalle de Novedad
    </h1>
    <div>
        <a href="{{ route('novedades.edit', $novedad) }}" class="btn btn-outline-warning">
            <i class="bi bi-pencil"></i>
            Editar
        </a>
        <a href="{{ route('novedades.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left"></i>
            Volver
        </a>
    </div>
</div>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-8">
            <div class="card card-outline card-primary mb-4">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="bi bi-info-circle"></i>
                        Información de la Novedad
                    </h3>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label text-muted">Preinscrito</label>
                            <p class="fw-semibold">
                                {{ $novedad->preinscrito->nombre_completo }}<br>
                                <small class="text-muted">{{ strtoupper($novedad->preinscrito->tipo_documento) }}-{{ $novedad->preinscrito->numero_documento }}</small>
                            </p>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label text-muted">Programa</label>
                            <p class="fw-semibold">
                                {{ $novedad->preinscrito->programa->nombre ?? 'Sin asignar' }}<br>
                                <small class="text-muted">{{ $novedad->preinscrito->programa->numero_ficha ?? 'N/A' }}</small>
                            </p>
                        </div>
                    </div>

                    <hr>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label text-muted">Tipo de Novedad</label>
                            <p>
                                @if ($novedad->tipoNovedad)
                                    <span class="badge bg-secondary">{{ $novedad->tipoNovedad->nombre }}</span>
                                @else
                                    <span class="badge bg-light text-dark">Sin tipo</span>
                                @endif
                            </p>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label text-muted">Estado Actual</label>
                            <p>
                                @php
                                    $colorEstado = match($novedad->estado) {
                                        'abierta' => 'danger',
                                        'en_gestion' => 'warning',
                                        'resuelta' => 'success',
                                        'cancelada' => 'secondary',
                                        default => 'light',
                                    };
                                @endphp
                                <span class="badge bg-{{ $colorEstado }}">{{ $novedad->etiqueta_estado }}</span>
                            </p>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label text-muted">Descripción</label>
                        <div class="p-3 bg-light rounded">
                            {{ $novedad->descripcion }}
                        </div>
                    </div>

                    <hr>

                    <div class="row">
                        <div class="col-md-4">
                            <label class="form-label text-muted">Creado por</label>
                            <p class="fw-semibold">{{ $novedad->createdBy->name ?? 'Sistema' }}</p>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label text-muted">Fecha de Creación</label>
                            <p class="fw-semibold">{{ $novedad->created_at->format('d/m/Y H:i') }}</p>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label text-muted">Última Actualización</label>
                            <p class="fw-semibold">{{ $novedad->updated_at->format('d/m/Y H:i') }}</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Historial de Cambios --}}
            @if ($novedad->historial->count() > 0)
                <div class="card card-outline card-info">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="bi bi-clock-history"></i>
                            Historial de Cambios ({{ $novedad->historial->count() }})
                        </h3>
                    </div>
                    <div class="card-body">
                        <div class="timeline">
                            @foreach ($novedad->historial as $cambio)
                                <div class="timeline-item">
                                    <div class="timeline-point timeline-point-warning"></div>
                                    <div class="timeline-content">
                                        <div class="d-flex justify-content-between align-items-start">
                                            <div>
                                                <h6 class="mb-1">
                                                    <span class="badge bg-secondary">{{ $cambio->estado_anterior }}</span>
                                                    <i class="bi bi-arrow-right"></i>
                                                    <span class="badge bg-success">{{ $cambio->estado_nuevo }}</span>
                                                </h6>
                                                @if ($cambio->comentario)
                                                    <p class="text-muted mb-0">{{ $cambio->comentario }}</p>
                                                @endif
                                            </div>
                                            <small class="text-muted">{{ $cambio->created_at->format('d/m/Y H:i') }}</small>
                                        </div>
                                        @if ($cambio->changedBy)
                                            <small class="text-muted">Por: {{ $cambio->changedBy->name }}</small>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif
        </div>

        <div class="col-lg-4">
            {{-- Panel de Acciones --}}
            <div class="card card-outline card-success mb-4">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="bi bi-lightning"></i>
                        Acciones Rápidas
                    </h3>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('novedades.edit', $novedad) }}" class="btn btn-outline-primary">
                            <i class="bi bi-pencil"></i>
                            Editar Novedad
                        </a>
                        
                        @if ($novedad->estado !== 'resuelta')
                            <form action="{{ route('novedades.cambiar-estado', $novedad) }}" method="POST">
                                @csrf
                                <input type="hidden" name="estado" value="resuelta">
                                <button type="submit" class="btn btn-outline-success w-100">
                                    <i class="bi bi-check-circle"></i>
                                    Marcar Resuelta
                                </button>
                            </form>
                        @endif

                        @if ($novedad->estado !== 'cancelada')
                            <form action="{{ route('novedades.cambiar-estado', $novedad) }}" method="POST">
                                @csrf
                                <input type="hidden" name="estado" value="cancelada">
                                <button type="submit" class="btn btn-outline-secondary w-100">
                                    <i class="bi bi-x-circle"></i>
                                    Cancelar
                                </button>
                            </form>
                        @endif

                        <a href="{{ route('preinscritos.show', $novedad->preinscrito) }}" class="btn btn-outline-info">
                            <i class="bi bi-person"></i>
                            Ver Preinscrito
                        </a>
                    </div>
                </div>
            </div>

            {{-- Información de Auditoría --}}
            <div class="card card-outline card-secondary">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="bi bi-shield-check"></i>
                        Auditoría
                    </h3>
                </div>
                <div class="card-body">
                    <dl class="row">
                        <dt class="col-sm-6 text-muted">ID Novedad:</dt>
                        <dd class="col-sm-6"><code>{{ $novedad->id }}</code></dd>

                        <dt class="col-sm-6 text-muted">ID Preinscrito:</dt>
                        <dd class="col-sm-6"><code>{{ $novedad->preinscrito_id }}</code></dd>

                        <dt class="col-sm-6 text-muted">Cambios:</dt>
                        <dd class="col-sm-6">
                            <span class="badge bg-info">{{ $novedad->historial->count() }}</span>
                        </dd>
                    </dl>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .timeline {
        position: relative;
        padding: 0;
    }

    .timeline-item {
        display: flex;
        margin-bottom: 20px;
    }

    .timeline-point {
        width: 12px;
        height: 12px;
        border-radius: 50%;
        background: #ccc;
        position: absolute;
        left: 8px;
        top: 8px;
    }

    .timeline-point-warning {
        background: #ffc107;
    }

    .timeline-content {
        margin-left: 40px;
        padding: 10px;
        border-left: 2px solid #e9ecef;
    }
</style>
@endsection
