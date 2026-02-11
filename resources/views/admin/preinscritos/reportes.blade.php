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
                    <button type="button" class="btn btn-primary btn-sm" onclick="generarReporte()">
                        <i class="fas fa-file-alt"></i> Generar reporte
                    </button>
                    <button type="button" class="btn btn-success btn-sm" onclick="generarExcel()">
                        <i class="fas fa-file-excel"></i> Generar Excel
                    </button>
                    <button type="button" class="btn btn-info btn-sm" onclick="exportarSOFIAPlus()" title="Exportar en formato SOFIA Plus del SENA">
                        <i class="fas fa-file-upload"></i> SOFIA Plus
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
    /**
     * Función para generar reporte (solo registrar en BD)
     */
    function generarReporte() {
        const form = document.getElementById('form-filtros');
        const formData = new FormData(form);
        
        // Crear formulario temporal y enviarlo
        const tempForm = document.createElement('form');
        tempForm.method = 'POST';
        tempForm.action = "{{ route('preinscritos.reportar') }}";
        
        // Agregar token CSRF
        const csrfInput = document.createElement('input');
        csrfInput.type = 'hidden';
        csrfInput.name = '_token';
        csrfInput.value = '{{ csrf_token() }}';
        tempForm.appendChild(csrfInput);
        
        // Agregar todos los campos del formulario
        for (let [key, value] of formData.entries()) {
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = key;
            input.value = value;
            tempForm.appendChild(input);
        }
        
        document.body.appendChild(tempForm);
        tempForm.submit();
    }

    /**
     * Función para generar Excel
     */
    function generarExcel() {
        const form = document.getElementById('form-filtros');
        const formData = new FormData(form);
        
        Swal.fire({
            title: 'Generando Excel...',
            text: 'Por favor espere',
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });

        // Crear formulario temporal y enviarlo
        const tempForm = document.createElement('form');
        tempForm.method = 'POST';
        tempForm.action = "{{ route('preinscritos.generar-excel') }}";
        
        // Agregar token CSRF
        const csrfInput = document.createElement('input');
        csrfInput.type = 'hidden';
        csrfInput.name = '_token';
        csrfInput.value = '{{ csrf_token() }}';
        tempForm.appendChild(csrfInput);
        
        // Agregar todos los campos del formulario
        for (let [key, value] of formData.entries()) {
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = key;
            input.value = value;
            tempForm.appendChild(input);
        }
        
        document.body.appendChild(tempForm);
        tempForm.submit();
    }

    /**
     * Función para descargar archivo Excel en formato SOFIA Plus
     */
    function exportarSOFIAPlus() {
        const form = document.getElementById('form-filtros');
        const formData = new FormData(form);
        
        // Crear formulario temporal
        const tempForm = document.createElement('form');
        tempForm.method = 'POST';
        tempForm.action = "{{ route('preinscritos.exportar-sofia-plus') }}";
        
        // Agregar token CSRF
        const csrfInput = document.createElement('input');
        csrfInput.type = 'hidden';
        csrfInput.name = '_token';
        csrfInput.value = '{{ csrf_token() }}';
        tempForm.appendChild(csrfInput);
        
        // Agregar todos los campos del formulario
        for (let [key, value] of formData.entries()) {
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = key;
            input.value = value;
            tempForm.appendChild(input);
        }
        
        document.body.appendChild(tempForm);
        tempForm.submit();
        document.body.removeChild(tempForm);
    }

    /**
     * Función para imprimir reporte
     */
    function imprimirReporte() {
        const form = document.getElementById('form-filtros');
        const params = new URLSearchParams(new FormData(form)).toString();
        const url = "{{ route('reportes.imprimir') }}" + (params ? '?' + params : '');
        
        window.open(url, '_blank');
    }

    /**
     * Función auxiliar para descargar archivos
     */
    function downloadWithChooser(url, filename) {
        const a = document.createElement('a');
        a.href = url;
        a.download = filename;
        document.body.appendChild(a);
        a.click();
        document.body.removeChild(a);
    }
</script>

@if(session('success'))
<script>
    const downloadUrl = "{{ session('download_url') }}";
    const downloadName = "{{ session('download_name') }}";

    if (downloadUrl) {
        Swal.fire({
            icon: 'success',
            title: 'Reporte generado',
            text: "{{ session('success') }}",
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
            text: "{{ session('success') }}",
        });
    }
</script>
@endif

@if(session('error'))
<script>
    Swal.fire({
        icon: 'error',
        title: 'Error',
        text: "{{ session('error') }}"
    });
</script>
@endif
@endsection
