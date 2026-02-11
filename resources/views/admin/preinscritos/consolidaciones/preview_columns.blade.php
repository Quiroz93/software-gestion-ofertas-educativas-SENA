@extends('layouts.admin')

@section('title', 'Seleccionar Columnas para Consolidación')

@section('content_header')
<div class="d-flex justify-content-between align-items-center">
    <h1 class="m-0">
        <i class="bi bi-columns-gap text-primary"></i>
        Seleccionar Columnas para Consolidación
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
            <h3 class="card-title">
                <i class="bi bi-file-earmark-check me-2"></i>
                Archivos Analizados: {{ $totalArchivos }}
            </h3>
        </div>
        <div class="card-body">
            <!-- Información sobre archivos cargados -->
            <div class="alert alert-info mb-4">
                <i class="bi bi-info-circle me-2"></i>
                <strong>Análisis completado</strong>
                <p class="mb-0 mt-2">
                    Se analizaron {{ $totalArchivos }} archivo(s) y se detectaron {{ count($columnas) }} columna(s) únicas.
                    Seleccione las columnas que desea incluir en la consolidación final.
                </p>
            </div>

            <!-- Preview de archivos analizados -->
            <div class="row mb-4">
                <div class="col-12">
                    <h5 class="mb-3">
                        <i class="bi bi-files me-2"></i>
                        Archivos Cargados
                    </h5>
                    <div class="table-responsive">
                        <table class="table table-sm table-bordered">
                            <thead class="table-light">
                                <tr>
                                    <th width="5%">#</th>
                                    <th width="35%">Nombre del Archivo</th>
                                    <th width="15%">Columnas</th>
                                    <th width="15%">Registros</th>
                                    <th width="30%">Metadata Detectada</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($archivos as $idx => $archivo)
                                <tr>
                                    <td>{{ $idx + 1 }}</td>
                                    <td>
                                        <i class="bi bi-file-earmark-excel text-success me-1"></i>
                                        {{ $archivo['nombre_archivo'] }}
                                    </td>
                                    <td class="text-center">
                                        <span class="badge bg-info">{{ $archivo['total_columns'] }}</span>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge bg-success">{{ $archivo['total_registros'] }}</span>
                                    </td>
                                    <td class="small text-muted">
                                        @if(!empty($archivo['metadata']))
                                            @php
                                                $metadataKeys = array_keys($archivo['metadata']);
                                                $firstThree = array_slice($metadataKeys, 0, 3);
                                            @endphp
                                            @foreach($firstThree as $key)
                                                <div class="text-truncate">
                                                    <strong>{{ $key }}:</strong> {{ Str::limit($archivo['metadata'][$key], 30) }}
                                                </div>
                                            @endforeach
                                            @if(count($metadataKeys) > 3)
                                                <small class="text-muted">...y {{ count($metadataKeys) - 3 }} más</small>
                                            @endif
                                        @else
                                            <span class="text-muted">Sin metadata</span>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Formulario de selección de columnas -->
            <form action="{{ route('preinscritos.consolidaciones.processColumns') }}" method="POST">
                @csrf

                <div class="row">
                    <div class="col-12">
                        <h5 class="mb-3">
                            <i class="bi bi-list-check me-2"></i>
                            Columnas Detectadas
                            <button type="button" class="btn btn-sm btn-outline-primary ms-2" onclick="toggleAllColumns(true)">
                                <i class="bi bi-check-all"></i> Seleccionar Todas
                            </button>
                            <button type="button" class="btn btn-sm btn-outline-secondary ms-1" onclick="toggleAllColumns(false)">
                                <i class="bi bi-x-circle"></i> Deseleccionar Todas
                            </button>
                        </h5>

                        <div class="alert alert-warning">
                            <i class="bi bi-exclamation-triangle me-2"></i>
                            Las columnas marcadas como <span class="badge bg-info">RECOMENDADA</span> son esenciales para identificar registros.
                        </div>

                        <div class="row">
                            @foreach($columnas as $columna)
                            <div class="col-md-6 col-lg-4 mb-3">
                                <div class="form-check-card-column">
                                    <div class="form-check">
                                        <input class="form-check-input column-checkbox" 
                                               type="checkbox" 
                                               name="columnas[]" 
                                               id="col_{{ $columna['nombre'] }}" 
                                               value="{{ $columna['nombre'] }}"
                                               {{ $columna['recomendada'] ? 'checked' : '' }}>
                                        <label class="form-check-label" for="col_{{ $columna['nombre'] }}">
                                            <strong>{{ $columna['etiqueta'] }}</strong>
                                            @if($columna['recomendada'])
                                                <span class="badge bg-info ms-2">RECOMENDADA</span>
                                            @endif
                                        </label>
                                    </div>
                                    <div class="ms-4 mt-1 text-muted small">
                                        <code class="text-secondary">{{ $columna['nombre'] }}</code>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Resumen de selección -->
                <div class="row mt-4">
                    <div class="col-12">
                        <div class="card bg-light">
                            <div class="card-body">
                                <h6 class="mb-3">
                                    <i class="bi bi-clipboard-check me-2"></i>
                                    Resumen de Selección
                                </h6>
                                <p class="mb-2">
                                    <strong>Total de columnas seleccionadas:</strong> 
                                    <span class="badge bg-primary" id="selected-count">{{ count(array_filter($columnas, fn($c) => $c['recomendada'])) }}</span>
                                </p>
                                <p class="mb-0 text-muted small">
                                    La consolidación final incluirá solo las columnas seleccionadas. 
                                    Los archivos que no contengan alguna de estas columnas tendrán valores vacíos en esas celdas.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Botones de acción -->
                <div class="row mt-4">
                    <div class="col-12 d-flex justify-content-between">
                        <a href="{{ route('preinscritos.consolidaciones.import') }}" class="btn btn-outline-secondary">
                            <i class="bi bi-arrow-left"></i>
                            Cancelar
                        </a>
                        <button type="submit" class="btn btn-primary btn-lg">
                            <i class="bi bi-check-circle me-2"></i>
                            Continuar con la Consolidación
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
.form-check-card-column {
    padding: 1rem;
    border: 2px solid #e9ecef;
    border-radius: 0.5rem;
    cursor: pointer;
    transition: all 0.3s ease;
    height: 100%;
    background-color: #fff;
}

.form-check-card-column:hover {
    background-color: #f8f9fa;
    border-color: #0d6efd;
    box-shadow: 0 0.125rem 0.25rem rgba(0,0,0,.075);
}

.form-check-card-column:has(input:checked) {
    background-color: #e7f1ff;
    border-color: #0d6efd;
    border-width: 2px;
}

.form-check-card-column input:checked + label {
    color: #0d6efd;
    font-weight: 600;
}

.form-check-card-column .form-check {
    margin-bottom: 0;
}

table.table-sm td, table.table-sm th {
    vertical-align: middle;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Actualizar contador de selección
    updateSelectedCount();
    
    // Agregar event listeners a checkboxes
    document.querySelectorAll('.column-checkbox').forEach(function(checkbox) {
        checkbox.addEventListener('change', function() {
            updateSelectedCount();
        });
    });
    
    // Hacer clickeable toda la tarjeta (evitar doble-click en checkbox)
    document.querySelectorAll('.form-check-card-column').forEach(function(card) {
        card.addEventListener('click', function(e) {
            if (e.target.type !== 'checkbox' && e.target.tagName !== 'LABEL') {
                const checkbox = this.querySelector('.column-checkbox');
                if (checkbox) {
                    checkbox.checked = !checkbox.checked;
                    updateSelectedCount();
                }
            }
        });
    });
});

function toggleAllColumns(select) {
    document.querySelectorAll('.column-checkbox').forEach(function(checkbox) {
        checkbox.checked = select;
    });
    updateSelectedCount();
}

function updateSelectedCount() {
    const checked = document.querySelectorAll('.column-checkbox:checked').length;
    document.getElementById('selected-count').textContent = checked;
}
</script>
@endsection
