@extends('layouts.admin')

@section('title', 'Opciones de Consolidación')

@section('content_header')
<div class="d-flex justify-content-between align-items-center">
    <h1 class="m-0">
        <i class="bi bi-sliders text-primary"></i>
        Seleccionar Opciones de Consolidación
    </h1>
    <div>
        <a href="{{ route('preinscritos.consolidaciones.import') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left"></i>
            Volver
        </a>
    </div>
</div>
@endsection

@section('content')
<div class="container-fluid">
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title">Se detectaron archivos REGIONAL SANTANDER</h3>
        </div>
        <div class="card-body">
            <div class="alert alert-info">
                <i class="bi bi-info-circle me-2"></i>
                <strong>Se encontraron {{ count($archivosInfo['regional'] ?? []) }} archivo(s) REGIONAL SANTANDER</strong>
                <br>
                Por favor seleccione cómo desea consolidar los datos:
            </div>

            <form action="{{ route('preinscritos.consolidaciones.processOptions') }}" method="POST">
                @csrf

                <!-- Opciones para REGIONAL SANTANDER -->
                <div class="mb-4">
                    <h5 class="mb-3">
                        <i class="bi bi-file-earmark-excel text-success me-2"></i>
                        Archivos REGIONAL SANTANDER
                    </h5>

                    <div class="option-group">
                        <div class="form-check-card mb-3" onclick="document.getElementById('opcion_completo').click()">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="opcion_regional" 
                                       id="opcion_completo" value="completo" checked>
                                <label class="form-check-label" for="opcion_completo">
                                    <strong>Consolidar Completo</strong>
                                    <span class="badge bg-info ms-2">RECOMENDADO</span>
                                </label>
                            </div>
                            <div class="ms-4 mt-2 text-muted small">
                                <i class="bi bi-info-circle me-1"></i>
                                Extrae TODOS los datos del archivo incluyendo:
                                <ul class="mt-2 mb-0">
                                    <li>Datos personnales (nombres, apellidos, teléfonos, correo)</li>
                                    <li>Información de pruebas (tipo, resultado, estado, fecha)</li>
                                    <li>Información adicional (NIS, dígito, día pico y placa)</li>
                                </ul>
                            </div>
                        </div>

                        <div class="form-check-card" onclick="document.getElementById('opcion_esencial').click()">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="opcion_regional" 
                                       id="opcion_esencial" value="esencial">
                                <label class="form-check-label" for="opcion_esencial">
                                    <strong>Consolidar Solo Datos Esenciales</strong>
                                </label>
                            </div>
                            <div class="ms-4 mt-2 text-muted small">
                                <i class="bi bi-info-circle me-1"></i>
                                Extrae solo la información básica:
                                <ul class="mt-2 mb-0">
                                    <li>Tipo y número de documento</li>
                                    <li>Nombre completo</li>
                                    <li>Código de ficha y programa</li>
                                    <li>Estado del registro</li>
                                    <li>Teléfonos (fijo y móvil)</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Resumen de archivos a procesar -->
                <div class="row mt-4">
                    <div class="col-md-6">
                        @if(!empty($archivosInfo['regional']))
                        <div class="card bg-light">
                            <div class="card-header">
                                <h6 class="mb-0">Archivos REGIONAL SANTANDER</h6>
                            </div>
                            <div class="card-body">
                                <ul class="list-unstyled mb-0">
                                    @foreach($archivosInfo['regional'] as $indice => $archivo)
                                        <li class="mb-2">
                                            <i class="bi bi-file-earmark-excel text-success me-2"></i>
                                            {{ $archivo['nombre_original'] }}
                                        </li>
                                    @endforeach
                                </ul>
                                <div class="alert alert-warning mt-3 mb-0 py-2">
                                    <small>
                                        <i class="bi bi-exclamation-triangle me-1"></i>
                                        Total: {{ count($archivosInfo['regional']) }} archivo(s)
                                    </small>
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>

                    <div class="col-md-6">
                        @if(!empty($archivosInfo['preinscritos']))
                        <div class="card bg-light">
                            <div class="card-header">
                                <h6 class="mb-0">Archivos de Preinscritos</h6>
                            </div>
                            <div class="card-body">
                                <ul class="list-unstyled mb-0">
                                    @foreach($archivosInfo['preinscritos'] as $indice => $archivo)
                                        <li class="mb-2">
                                            <i class="bi bi-file-earmark-spreadsheet text-primary me-2"></i>
                                            {{ $archivo['nombre_original'] }}
                                        </li>
                                    @endforeach
                                </ul>
                                <div class="alert alert-info mt-3 mb-0 py-2">
                                    <small>
                                        <i class="bi bi-info-circle me-1"></i>
                                        Se procesarán normalmente
                                    </small>
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Botones de acción -->
                <div class="mt-4 pt-3 border-top">
                    <button type="submit" class="btn btn-success">
                        <i class="bi bi-check-circle me-2"></i>
                        Continuar con la consolidación
                    </button>
                    <a href="{{ route('preinscritos.consolidaciones.import') }}" class="btn btn-secondary ms-2">
                        <i class="bi bi-arrow-counterclockwise me-2"></i>
                        Cancelar
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Información adicional -->
    <div class="card mt-4">
        <div class="card-header">
            <h5 class="mb-0">
                <i class="bi bi-question-circle me-2"></i>
                ¿Cuál opción debo seleccionar?
            </h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <h6 class="mb-2">✓ Consolidar Completo</h6>
                    <p class="text-muted small mb-0">
                        Selecciona esta opción si necesitas guardar toda la información del reporte de REGIONAL SANTANDER
                        para análisis posterior o auditoría. Incluye información de pruebas, contacto y datos adicionales.
                    </p>
                </div>
                <div class="col-md-6">
                    <h6 class="mb-2">✓ Consolidar Solo Datos Esenciales</h6>
                    <p class="text-muted small mb-0">
                        Selecciona esta opción si solo necesitas los datos básicos de los aspirantes
                        (documento, ficha, programa). Más rápido y usa menos espacio de almacenamiento.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.form-check-card {
    padding: 1rem;
    border: 2px solid #e9ecef;
    border-radius: 0.5rem;
    margin-bottom: 1rem;
    transition: all 0.3s ease;
    cursor: pointer;
}

.form-check-card:hover {
    background-color: #f8f9fa;
    border-color: #0d6efd;
    box-shadow: 0 0.125rem 0.25rem rgba(0,0,0,.075);
}

.form-check-card:has(input:checked) {
    background-color: #e7f1ff;
    border-color: #0d6efd;
    border-width: 2px;
}

.form-check-card input:checked + label {
    color: #0d6efd;
    font-weight: 600;
}

.form-check-card input:checked ~ div {
    color: #084298;
}

.form-check-input {
    cursor: pointer;
    width: 1.25rem;
    height: 1.25rem;
}

.form-check-input:checked {
    background-color: #0d6efd;
    border-color: #0d6efd;
}

.form-check-label {
    cursor: pointer;
}
</style>

<script>
// Asegurar que los radio buttons funcionen correctamente
document.addEventListener('DOMContentLoaded', function() {
    // Agregar evento click a las tarjetas
    document.querySelectorAll('.form-check-card').forEach(function(card) {
        card.addEventListener('click', function(e) {
            // Evitar doble clic en el input
            if (e.target.type !== 'radio') {
                const radio = this.querySelector('input[type="radio"]');
                if (radio) {
                    radio.checked = true;
                }
            }
        });
    });
    
    // Actualizar estilos cuando se selecciona
    document.querySelectorAll('input[name="opcion_regional"]').forEach(function(radio) {
        radio.addEventListener('change', function() {
            console.log('Opción seleccionada:', this.value);
        });
    });
});
</script>
@endsection
