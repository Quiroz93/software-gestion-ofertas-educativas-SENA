@extends('layouts.admin')

@section('title', 'Cargar Archivo Externo')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="h3 mb-0">
                        <i class="fas fa-file-upload text-success"></i>
                        Carga Masiva de Preinscritos
                    </h1>
                    <p class="text-muted mb-0">Importación desde archivos Excel</p>
                </div>
                <div>
                    <a href="{{ route('preinscritos.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left"></i> Volver
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card card-outline card-success">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-upload"></i>
                        Subir archivos
                    </h3>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('preinscritos.import.store') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label for="archivos" class="form-label">Archivos Excel</label>
                            <input class="form-control" type="file" id="archivos" name="archivos[]" multiple accept=".xlsx,.xls,.csv" required>
                            <div class="form-text">Formatos permitidos: .xlsx, .xls, .csv</div>
                        </div>
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-cloud-upload-alt"></i> Cargar archivos
                        </button>
                        <a href="{{ route('preinscritos.import.template') }}" class="btn btn-outline-primary ms-2">
                            <i class="fas fa-file-excel"></i> Descargar plantilla
                        </a>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card border-success">
                <div class="card-header bg-success text-white">
                    <h6 class="mb-0">
                        <i class="fas fa-info-circle"></i> Formato requerido
                    </h6>
                </div>
                <div class="card-body">
                    <p class="mb-2">La fila de encabezados debe estar en las primeras 15 filas y contener:</p>
                    <ul class="small mb-3">
                        <li>Tipo Documento</li>
                        <li>Número Documento</li>
                        <li>Nombres</li>
                        <li>Apellidos</li>
                        <li>Correo (opcional)</li>
                        <li>Celular (opcional)</li>
                        <li><strong class="text-success">Programa de Formación (lista desplegable)</strong></li>
                        <li><strong class="text-success">Número de Ficha (automático)</strong></li>
                        <li>Estado (opcional)</li>
                    </ul>

                    <div class="alert alert-info small mb-3">
                        <i class="fas fa-lightbulb"></i>
                        <strong>Nueva funcionalidad:</strong> La plantilla incluye lista desplegable de programas. 
                        Al seleccionar un programa, el número de ficha se calcula automáticamente.
                    </div>

                    <p class="small text-danger mb-3">
                        <i class="fas fa-exclamation-circle"></i>
                        <strong>IMPORTANTE:</strong> No modifique manualmente la columna "Número de Ficha". 
                        El sistema validará que coincida con el programa seleccionado. 
                        Las modificaciones manuales causarán el rechazo del registro.
                    </p>

                    <p class="mb-2"><strong>Valores válidos de Tipo Documento:</strong></p>
                    <p class="small text-muted mb-0">cc, ti, ce, ppt, pa, pep, nit</p>
                </div>
            </div>
        </div>
    </div>

    <div class="card mt-4">
        <div class="card-header">
            <h3 class="card-title">
                <i class="fas fa-table"></i> Ejemplo de encabezados
            </h3>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-sm">
                    <thead class="table-light">
                        <tr>
                            <th>Tipo Documento</th>
                            <th>Número Documento</th>
                            <th>Nombres</th>
                            <th>Apellidos</th>
                            <th>Correo</th>
                            <th>Celular</th>
                            <th>Programa de Formación</th>
                            <th>Número de Ficha</th>
                            <th>Estado</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>cc</td>
                            <td>123456789</td>
                            <td>Juan</td>
                            <td>Pérez</td>
                            <td>juan.perez@correo.com</td>
                            <td>3001234567</td>
                            <td><span class="badge bg-success">Seleccionar de lista</span></td>
                            <td><span class="badge bg-secondary">Automático</span></td>
                            <td>por_inscribir</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="alert alert-warning mt-3 mb-0">
                <i class="fas fa-exclamation-triangle"></i>
                Si un registro tiene datos incompletos, documento duplicado, programa inválido o inconsistencia entre programa y ficha, se enviará a la lista de rechazados.
            </div>
        </div>
    </div>
</div>
@endsection
