@extends('layouts.admin')

@section('title', 'Importar Preinscritos')

@section('content_header')
<div class="d-flex justify-content-between align-items-center">
    <h1 class="m-0">
        <i class="bi bi-upload text-primary"></i>
        Importación y Consolidación de Datos
    </h1>
    <div>
        <a href="{{ route('preinscritos.consolidaciones.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left"></i>
            Volver
        </a>
    </div>
</div>
@endsection

@section('content')
<div class="container-fluid">
    <!-- Información de tipos de archivos soportados -->
    <div class="row mb-4">
        <div class="col-md-6">
            <div class="card border-primary">
                <div class="card-header bg-primary text-white">
                    <i class="bi bi-file-earmark-spreadsheet me-2"></i>
                    <strong>Archivos de Preinscritos</strong>
                </div>
                <div class="card-body">
                    <p class="text-muted small mb-2">Archivos Excel estándar de preinscritos</p>
                    <div class="list-group list-group-flush">
                        <div class="list-group-item px-0 py-2">
                            <small><i class="bi bi-check-circle text-success me-2"></i>Se procesan automáticamente</small>
                        </div>
                        <div class="list-group-item px-0 py-2">
                            <small><i class="bi bi-check-circle text-success me-2"></i>Detecta encabezados</small>
                        </div>
                        <div class="list-group-item px-0 py-2">
                            <small><i class="bi bi-check-circle text-success me-2"></i>Evita duplicados</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card border-success">
                <div class="card-header bg-success text-white">
                    <i class="bi bi-file-earmark-excel me-2"></i>
                    <strong>Archivos REGIONAL SANTANDER</strong>
                </div>
                <div class="card-body">
                    <p class="text-muted small mb-2">Reportes generados por el sistema SOFIA Plus</p>
                    <div class="list-group list-group-flush">
                        <div class="list-group-item px-0 py-2">
                            <small><i class="bi bi-check-circle text-success me-2"></i>Se detectan automáticamente</small>
                        </div>
                        <div class="list-group-item px-0 py-2">
                            <small><i class="bi bi-check-circle text-success me-2"></i>Opciones de consolidación</small>
                        </div>
                        <div class="list-group-item px-0 py-2">
                            <small><i class="bi bi-check-circle text-success me-2"></i>Guarda datos completos</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title"><i class="bi bi-upload me-2"></i>Carga múltiple de archivos Excel</h3>
        </div>
        <div class="card-body">
            <form action="{{ route('preinscritos.consolidaciones.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label class="form-label"><strong>Seleccione archivos Excel</strong></label>
                    <input type="file" name="archivos[]" class="form-control" multiple accept=".xls,.xlsx" required>
                    <div class="form-text mt-2">
                        <i class="bi bi-info-circle me-1"></i>
                        Puede seleccionar múltiples archivos. El sistema detectará automáticamente el tipo de archivo.
                    </div>
                </div>

                <div class="alert alert-info">
                    <div class="row g-2">
                        <div class="col-md-6">
                            <strong><i class="bi bi-lightbulb me-2"></i>Detección Automática</strong>
                            <p class="mb-0 small mt-2">
                                El sistema analiza cada archivo y detecta si es un reporte REGIONAL SANTANDER o un archivo de preinscritos.
                            </p>
                        </div>
                        <div class="col-md-6">
                            <strong><i class="bi bi-gear me-2"></i>Opciones Flexibles</strong>
                            <p class="mb-0 small mt-2">
                                Si detecta archivos REGIONAL SANTANDER, te permitirá elegir entre guardar todos los datos o solo lo esencial.
                            </p>
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn btn-success">
                    <i class="bi bi-cloud-arrow-up me-2"></i>
                    Cargar y procesar archivos
                </button>
            </form>
        </div>
    </div>

    @if($errors->any())
        <div class="card mt-4 border-danger">
            <div class="card-header bg-danger text-white">
                <i class="bi bi-exclamation-circle me-2"></i>
                Errores detectados
            </div>
            <div class="card-body">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif

    @if(session('import_errors'))
        <div class="card mt-4 border-warning">
            <div class="card-header bg-warning text-dark">
                <i class="bi bi-exclamation-triangle me-2"></i>
                Errores encontrados durante la importación
            </div>
            <div class="card-body">
                <ul class="mb-0">
                    @foreach(session('import_errors') as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif

    <!-- Guía de uso -->
    <div class="card mt-4">
        <div class="card-header">
            <h5 class="mb-0"><i class="bi bi-question-circle me-2"></i>Guía de uso</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <h6><strong>Paso 1: Seleccionar archivos</strong></h6>
                    <p class="text-muted small">Elige uno o múltiples archivos Excel de tu equipo.</p>
                    
                    <h6 class="mt-3"><strong>Paso 2: Detección automática</strong></h6>
                    <p class="text-muted small">El sistema analiza automáticamente cada archivo para determinar su tipo.</p>
                </div>
                <div class="col-md-6">
                    <h6><strong>Paso 3: Seleccionar opciones</strong></h6>
                    <p class="text-muted small">Si hay archivos REGIONAL SANTANDER, elige cómo consolidarlos.</p>
                    
                    <h6 class="mt-3"><strong>Paso 4: Procesamiento</strong></h6>
                    <p class="text-muted small">Se consolidan los datos y se eliminarán duplicados automáticamente.</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
