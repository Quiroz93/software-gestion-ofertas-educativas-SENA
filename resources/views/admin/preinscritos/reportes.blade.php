@extends('layouts.admin')

@section('title', 'Reportes - Preinscritos')

@section('content_header')
<div class="d-flex justify-content-between align-items-center">
    <h1 class="m-0">
        <i class="fas fa-chart-bar text-primary"></i>
        Reportes de Preinscritos
    </h1>
    <a href="{{ route('preinscritos.index') }}" class="btn btn-outline-secondary">
        <i class="fas fa-arrow-left"></i>
        Volver
    </a>
</div>
@endsection

@section('content')
<div class="container-fluid">
    <!-- Estadísticas -->
    <div class="row mb-4">
        <div class="col-lg-3 col-md-6 mb-2">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <h6 class="card-title">Total de Preinscritos</h6>
                    <h2 class="mb-0">{{ $estadisticas['total'] }}</h2>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 mb-2">
            <div class="card bg-success text-white">
                <div class="card-body">
                    <h6 class="card-title">Inscritos</h6>
                    <h2 class="mb-0">{{ $estadisticas['inscrito'] }}</h2>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 mb-2">
            <div class="card bg-warning text-white">
                <div class="card-body">
                    <h6 class="card-title">Por Inscribir</h6>
                    <h2 class="mb-0">{{ $estadisticas['por_inscribir'] }}</h2>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 mb-2">
            <div class="card bg-danger text-white">
                <div class="card-body">
                    <h6 class="card-title">Con Novedad</h6>
                    <h2 class="mb-0">{{ $estadisticas['con_novedad'] }}</h2>
                </div>
            </div>
        </div>
    </div>

    <!-- Filtros -->
    <div class="card card-outline card-primary mb-4">
        <div class="card-header">
            <h3 class="card-title">
                <i class="fas fa-filter"></i>
                Filtros de Reporte
            </h3>
        </div>
        <div class="card-body">
            <form id="form-filtros" method="GET" action="{{ route('preinscritos.reportes') }}" class="row g-3">
                <div class="col-md-4">
                    <label for="programa_id" class="form-label">Programa</label>
                    <select class="form-select form-select-sm" id="programa_id" name="programa_id">
                        <option value="">-- Todos los programas --</option>
                        @foreach($programas as $programa)
                            <option value="{{ $programa->id }}" {{ request('programa_id') == $programa->id ? 'selected' : '' }}>
                                {{ $programa->nombre }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-4">
                    <label for="estado" class="form-label">Estado</label>
                    <select class="form-select form-select-sm" id="estado" name="estado">
                        <option value="">-- Todos los estados --</option>
                        @foreach($estados as $valor => $etiqueta)
                            <option value="{{ $valor }}" {{ request('estado') == $valor ? 'selected' : '' }}>
                                {{ $etiqueta }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-4">
                    <label for="tipo_documento" class="form-label">Tipo de Documento</label>
                    <select class="form-select form-select-sm" id="tipo_documento" name="tipo_documento">
                        <option value="">-- Todos --</option>
                        @foreach($tiposDocumento as $valor => $etiqueta)
                            <option value="{{ $valor }}" {{ request('tipo_documento') == $valor ? 'selected' : '' }}>
                                {{ $etiqueta }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-12">
                    <button type="submit" class="btn btn-outline-primary btn-sm">
                        <i class="fas fa-search"></i> Aplicar filtros
                    </button>
                    <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalGenerarReporte">
                        <i class="fas fa-file-alt"></i> Generar reporte
                    </button>
                    <button type="button" class="btn btn-success btn-sm" onclick="generarExcel()">
                        <i class="fas fa-file-excel"></i> Generar Excel
                    </button>
                    <a href="{{ route('preinscritos.reportes') }}" class="btn btn-outline-secondary btn-sm">
                        <i class="fas fa-redo"></i> Limpiar
                    </a>
                    <button type="button" class="btn btn-outline-info btn-sm" onclick="imprimirReporte()">
                        <i class="fas fa-print"></i> Imprimir
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Generar Reporte -->
    <div class="modal fade" id="modalGenerarReporte" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Generar reporte</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <div class="modal-body">
                    Selecciona cómo deseas guardar el reporte.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-outline-primary" onclick="guardarSoloBD()">
                        Guardar solo en BD
                    </button>
                    <button type="button" class="btn btn-success" onclick="guardarYGenerarExcel()">
                        Guardar y generar Excel
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabla de Reportes -->
    @if($preinscritos->count() > 0)
        <div class="card card-outline card-primary">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-list"></i>
                    Datos del Reporte ({{ $preinscritos->count() }} registros)
                </h3>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-hover table-sm" id="tablaReporte">
                        <thead class="table-primary">
                            <tr>
                                <th>Nombre Completo</th>
                                <th>Documento</th>
                                <th>Celular</th>
                                <th>Correo</th>
                                <th>Programa</th>
                                <th>Ficha</th>
                                <th>Estado</th>
                                <th>Registrado</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($preinscritos as $presrito)
                                <tr>
                                    <td>{{ $presrito->nombre_completo }}</td>
                                    <td>
                                        <small>
                                            {{ strtoupper($presrito->tipo_documento) }}-{{ $presrito->numero_documento }}
                                        </small>
                                    </td>
                                    <td>
                                        <small>{{ $presrito->celular_principal }}</small>
                                    </td>
                                    <td>
                                        <small>{{ $presrito->correo_principal }}</small>
                                    </td>
                                    <td>
                                        <small>{{ $presrito->programa->nombre ?? 'Sin asignar' }}</small>
                                    </td>
                                    <td>
                                        <small>{{ $presrito->programa->numero_ficha ?? 'N/A' }}</small>
                                    </td>
                                    <td>
                                        <small>
                                            <span class="badge bg-{{ $presrito->estado === 'inscrito' ? 'success' : ($presrito->estado === 'por_inscribir' ? 'warning' : 'danger') }}">
                                                {{ $presrito->etiqueta_estado }}
                                            </span>
                                        </small>
                                    </td>
                                    <td>
                                        <small>{{ $presrito->created_at->format('d/m/Y') }}</small>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer">
                <small class="text-muted">
                    Reporte generado el {{ now()->format('d/m/Y H:i:s') }}
                </small>
            </div>
        </div>

        <!-- Resumen por Programa -->
        <div class="row mt-4">
            @php
                $porPrograma = $preinscritos->groupBy('programa_id');
            @endphp

            @foreach($porPrograma as $programaId => $grupo)
                @php
                    $programa = $grupo->first()->programa;
                    $porEstado = $grupo->groupBy('estado');
                @endphp
                <div class="col-md-6 mb-4">
                    <div class="card card-outline card-info">
                        <div class="card-header">
                            <h5 class="card-title mb-0">
                                {{ $programa->nombre ?? 'Sin asignar' }}
                            </h5>
                        </div>
                        <div class="card-body">
                            <ul class="list-unstyled">
                                <li class="mb-2">
                                    <strong>Total:</strong>
                                    <span class="badge bg-primary">{{ $grupo->count() }}</span>
                                </li>
                                @foreach($estados as $valor => $etiqueta)
                                    @php
                                        $cantidad = $porEstado->get($valor, collect())->count();
                                    @endphp
                                    <li class="mb-2">
                                        <strong>{{ $etiqueta }}:</strong>
                                        <span class="badge bg-{{ $valor === 'inscrito' ? 'success' : ($valor === 'por_inscribir' ? 'warning' : 'danger') }}">
                                            {{ $cantidad }}
                                        </span>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="alert alert-info">
            <i class="fas fa-info-circle"></i>
            No hay datos para mostrar con los filtros aplicados.
        </div>
    @endif
</div>
@endsection

@section('js')
<script>
function submitReporte(actionUrl) {
    const form = document.getElementById('form-filtros');
    if (!form) {
        return;
    }

    const formData = new FormData(form);
    const postForm = document.createElement('form');
    postForm.method = 'POST';
    postForm.action = actionUrl;

    const csrf = document.createElement('input');
    csrf.type = 'hidden';
    csrf.name = '_token';
    csrf.value = @json(csrf_token());
    postForm.appendChild(csrf);

    for (const [key, value] of formData.entries()) {
        if (value !== null && value !== '') {
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = key;
            input.value = value;
            postForm.appendChild(input);
        }
    }

    document.body.appendChild(postForm);
    postForm.submit();
}

function generarExcel() {
    submitReporte('{{ route('preinscritos.exportar') }}');
}

function guardarSoloBD() {
    const modal = bootstrap.Modal.getInstance(document.getElementById('modalGenerarReporte'));
    if (modal) {
        modal.hide();
    }
    submitReporte('{{ route('preinscritos.reportar') }}');
}

function guardarYGenerarExcel() {
    const modal = bootstrap.Modal.getInstance(document.getElementById('modalGenerarReporte'));
    if (modal) {
        modal.hide();
    }
    submitReporte('{{ route('preinscritos.exportar') }}');
}

async function downloadWithChooser(url, filename) {
    if (!url) {
        return;
    }

    if (window.showSaveFilePicker) {
        try {
            const response = await fetch(url, { credentials: 'same-origin' });
            if (!response.ok) {
                throw new Error('No se pudo descargar el archivo.');
            }
            const blob = await response.blob();
            const handle = await window.showSaveFilePicker({
                suggestedName: filename || 'reporte_preinscritos.xlsx',
                types: [
                    {
                        description: 'Archivo Excel',
                        accept: {
                            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet': ['.xlsx']
                        }
                    }
                ]
            });
            const writable = await handle.createWritable();
            await writable.write(blob);
            await writable.close();

            Swal.fire({
                icon: 'success',
                title: 'Archivo guardado',
                text: 'El reporte se guardó correctamente.'
            });
            return;
        } catch (error) {
            if (error && error.name === 'AbortError') {
                Swal.fire({
                    icon: 'info',
                    title: 'Descarga cancelada',
                    text: 'No se guardó el archivo.'
                });
                return;
            }

            Swal.fire({
                icon: 'warning',
                title: 'Descarga directa',
                text: 'No fue posible abrir el selector. Se iniciará la descarga.'
            });
        }
    }

    window.location.href = url;
}

function imprimirReporte() {
    const tabla = document.getElementById('tablaReporte');
    if (!tabla || tabla.rows.length === 0) {
        Swal.fire({
            icon: 'warning',
            title: 'Sin datos',
            text: 'No hay datos para imprimir.'
        });
        return;
    }

    const ventana = window.open('', '_blank');
    const html = `
        <html>
            <head>
                <title>Reporte de Preinscritos - SENA</title>
                <style>
                    body { font-family: Arial, sans-serif; margin: 20px; }
                    h2 { text-align: center; color: #333; }
                    table { width: 100%; border-collapse: collapse; margin-top: 20px; }
                    th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
                    th { background-color: #f2f2f2; font-weight: bold; }
                    tr:nth-child(even) { background-color: #f9f9f9; }
                    .fecha { text-align: center; margin-top: 20px; color: #666; font-size: 12px; }
                </style>
            </head>
            <body>
                <h2>Reporte de Preinscritos - SENA</h2>
                ${tabla.outerHTML}
                <div class="fecha">
                    Reporte generado el ${new Date().toLocaleString('es-CO')}
                </div>
            </body>
        </html>
    `;
    ventana.document.write(html);
    ventana.document.close();
    ventana.print();
}
</script>

@if(session('success'))
<script>
    const downloadUrl = @json(session('download_url'));
    const downloadName = @json(session('download_name'));

    if (downloadUrl) {
        Swal.fire({
            icon: 'success',
            title: 'Reporte generado',
            text: @json(session('success')),
            showCancelButton: true,
            confirmButtonText: 'Descargar',
            cancelButtonText: 'Cerrar'
        }).then((result) => {
            if (result.isConfirmed) {
                downloadWithChooser(downloadUrl, downloadName);
            }
        });
    } else {
        Swal.fire({
            icon: 'success',
            title: 'Reporte generado',
            text: @json(session('success'))
        });
    }
</script>
@endif

@if(session('error'))
<script>
    Swal.fire({
        icon: 'error',
        title: 'Error',
        text: @json(session('error'))
    });
</script>
@endif
@endsection
