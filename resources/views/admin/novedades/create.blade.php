@extends('layouts.admin')

@section('title', 'Crear Novedad')

@section('content_header')
<div class="d-flex justify-content-between align-items-center">
    <h1 class="m-0">
        <i class="bi bi-plus-circle text-primary"></i>
        Crear Nueva Novedad
    </h1>
    <a href="{{ route('novedades.index') }}" class="btn btn-outline-secondary">
        <i class="bi bi-arrow-left"></i>
        Volver
    </a>
</div>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-10 offset-lg-1">
            <!-- Sección de Filtros -->
            <div class="card card-outline card-info mb-4">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="bi bi-funnel"></i>
                        Buscar Preinscrito
                    </h3>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label for="filter_documento" class="form-label">
                                <i class="bi bi-card-text"></i>
                                Número de Documento
                            </label>
                            <input type="text" class="form-control" id="filter_documento" 
                                   placeholder="Ej: 1096950023">
                        </div>
                        <div class="col-md-4">
                            <label for="filter_nombre" class="form-label">
                                <i class="bi bi-person"></i>
                                Nombres / Apellidos
                            </label>
                            <input type="text" class="form-control" id="filter_nombre" 
                                   placeholder="Ej: Juan Pérez">
                        </div>
                        <div class="col-md-4">
                            <label for="filter_programa" class="form-label">
                                <i class="bi bi-mortarboard"></i>
                                Programa
                            </label>
                            <select class="form-select" id="filter_programa">
                                <option value="">-- Todos --</option>
                                @php
                                    $programas = \App\Models\Programa::orderBy('nombre')->get();
                                @endphp
                                @foreach ($programas as $prog)
                                    <option value="{{ $prog->id }}">{{ $prog->nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row g-3 mt-2">
                        <div class="col-md-4">
                            <label for="filter_estado" class="form-label">
                                <i class="bi bi-circle-fill"></i>
                                Estado del Preinscrito
                            </label>
                            <select class="form-select" id="filter_estado">
                                <option value="">-- Todos --</option>
                                <option value="inscrito">Inscrito</option>
                                <option value="por_inscribir">Por Inscribir</option>
                                <option value="con_novedad">Con Novedad</option>
                            </select>
                        </div>
                        <div class="col-md-8">
                            <label class="form-label">&nbsp;</label>
                            <div>
                                <button type="button" class="btn btn-info btn-sm" id="btn_buscar">
                                    <i class="bi bi-search"></i>
                                    Buscar
                                </button>
                                <button type="button" class="btn btn-secondary btn-sm" id="btn_limpiar">
                                    <i class="bi bi-arrow-clockwise"></i>
                                    Limpiar
                                </button>
                            </div>
                        </div>
                    </div>
                    <!-- Tabla de resultados -->
                    <div class="mt-3" id="resultado_busqueda" style="display: none;">
                        <div class="table-responsive">
                            <table class="table table-hover table-sm">
                                <thead class="table-light">
                                    <tr>
                                        <th>Documento</th>
                                        <th>Nombres</th>
                                        <th>Programa</th>
                                        <th>Estado</th>
                                        <th>Seleccionar</th>
                                    </tr>
                                </thead>
                                <tbody id="tabla_resultados">
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Formulario de Novedad -->
            <div class="card card-outline card-primary">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="bi bi-form-check"></i>
                        Formulario de Registro de Novedad
                    </h3>
                </div>

                <form action="{{ route('novedades.store') }}" method="POST">
                    @csrf

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

                        <!-- Información del Preinscrito Seleccionado -->
                        <div id="preinscrito_info" class="alert alert-light border mb-3" style="display: none;">
                            <div class="row">
                                <div class="col-md-4">
                                    <strong>Documento:</strong> <span id="info_documento">-</span>
                                </div>
                                <div class="col-md-4">
                                    <strong>Nombre:</strong> <span id="info_nombre">-</span>
                                </div>
                                <div class="col-md-4">
                                    <strong>Programa:</strong> <span id="info_programa">-</span>
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-md-4">
                                    <strong>Estado:</strong> <span id="info_estado">-</span>
                                </div>
                                <div class="col-md-4">
                                    <strong>Correo:</strong> <span id="info_correo">-</span>
                                </div>
                                <div class="col-md-4">
                                    <strong>Teléfono:</strong> <span id="info_telefono">-</span>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="preinscrito_id" class="form-label">
                                Preinscrito Seleccionado <span class="text-danger">*</span>
                            </label>
                            <select class="form-select @error('preinscrito_id') is-invalid @enderror" 
                                    id="preinscrito_id" name="preinscrito_id" required>
                                <option value="">-- Selecciona un preinscrito --</option>
                            </select>
                            @error('preinscrito_id')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="tipo_novedad_id" class="form-label">
                                Tipo de Novedad
                            </label>
                            <select class="form-select @error('tipo_novedad_id') is-invalid @enderror" 
                                    id="tipo_novedad_id" name="tipo_novedad_id">
                                <option value="">-- Selecciona un tipo --</option>
                                @foreach ($tiposNovedad as $tipo)
                                    <option value="{{ $tipo->id }}" {{ old('tipo_novedad_id') == $tipo->id ? 'selected' : '' }}>
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
                                <option value="">-- Selecciona un estado --</option>
                                <option value="abierta" {{ old('estado') === 'abierta' ? 'selected' : '' }}>Abierta</option>
                                <option value="en_gestion" {{ old('estado') === 'en_gestion' ? 'selected' : '' }}>En Gestión</option>
                                <option value="resuelta" {{ old('estado') === 'resuelta' ? 'selected' : '' }}>Resuelta</option>
                                <option value="cancelada" {{ old('estado') === 'cancelada' ? 'selected' : '' }}>Cancelada</option>
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
                                      placeholder="Describe la novedad..." required>{{ old('descripcion') }}</textarea>
                            @error('descripcion')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="card-footer">
                        <button type="submit" class="btn btn-outline-primary">
                            <i class="bi bi-save"></i>
                            Guardar
                        </button>
                        <a href="{{ route('novedades.index') }}" class="btn btn-outline-secondary">
                            <i class="bi bi-times"></i>
                            Cancelar
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    const apiUrl = '{{ route("api.preinscritos.index") }}';
    let preinscritos = [];

    // Cargar preinscritos al iniciar
    async function cargarPreinscritos() {
        try {
            const response = await fetch(apiUrl);
            preinscritos = await response.json();
            console.log('Preinscritos cargados:', preinscritos.length);
        } catch (e) {
            console.error('Error loading preinscritos:', e);
        }
    }

    // Filtrar y mostrar resultados
    function buscarPreinscritos() {
        const documento = document.getElementById('filter_documento').value.toLowerCase();
        const nombre = document.getElementById('filter_nombre').value.toLowerCase();
        const programa = document.getElementById('filter_programa').value;
        const estado = document.getElementById('filter_estado').value;

        let resultados = preinscritos.filter(p => {
            let coincide = true;

            if (documento && !p.numero_documento.toLowerCase().includes(documento)) {
                coincide = false;
            }

            if (nombre) {
                const nombreCompleto = (p.nombre_completo || '').toLowerCase();
                if (!nombreCompleto.includes(nombre)) {
                    coincide = false;
                }
            }

            if (programa && p.programa_id != programa) {
                coincide = false;
            }

            if (estado && p.estado !== estado) {
                coincide = false;
            }

            return coincide;
        });

        mostrarResultados(resultados);
    }

    // Mostrar resultados en tabla
    function mostrarResultados(resultados) {
        const tbody = document.getElementById('tabla_resultados');
        tbody.innerHTML = '';

        if (resultados.length === 0) {
            tbody.innerHTML = '<tr><td colspan="5" class="text-center text-muted">Sin resultados</td></tr>';
        } else {
            resultados.forEach(p => {
                const tr = document.createElement('tr');
                const estadoBadge = getEstadoBadge(p.estado);
                
                tr.innerHTML = `
                    <td><code>${p.numero_documento}</code></td>
                    <td>${p.nombre_completo}</td>
                    <td><small>${p.programa_nombre || '-'}</small></td>
                    <td>${estadoBadge}</td>
                    <td>
                        <button type="button" class="btn btn-sm btn-outline-primary" 
                                onclick="seleccionarPreinscrito(${p.id}, '${p.numero_documento.replace(/'/g, "\\'")}', '${p.nombre_completo.replace(/'/g, "\\'")}')">
                            <i class="bi bi-check-circle"></i>
                            Seleccionar
                        </button>
                    </td>
                `;
                tbody.appendChild(tr);
            });
        }

        document.getElementById('resultado_busqueda').style.display = 'block';
    }

    // Obtener badge del estado
    function getEstadoBadge(estado) {
        const badges = {
            'inscrito': '<span class="badge bg-success">Inscrito</span>',
            'por_inscribir': '<span class="badge bg-warning">Por Inscribir</span>',
            'con_novedad': '<span class="badge bg-danger">Con Novedad</span>'
        };
        return badges[estado] || estado;
    }

    // Seleccionar preinscrito
    function seleccionarPreinscrito(id, documento, nombre) {
        // Actualizar select
        const select = document.getElementById('preinscrito_id');
        
        // Limpiar opciones anteriores excepto la primera
        while (select.options.length > 1) {
            select.remove(1);
        }

        // Agregar nueva opción y seleccionar
        const option = document.createElement('option');
        option.value = id;
        option.textContent = nombre + ' (' + documento + ')';
        option.selected = true;
        select.appendChild(option);

        // Obtener datos completos del preinscrito
        const preinscrito = preinscritos.find(p => p.id == id);
        if (preinscrito) {
            mostrarInfoPreinscrito(preinscrito);
        }

        // Scroll al formulario
        document.querySelector('.card.card-outline.card-primary').scrollIntoView({ behavior: 'smooth' });
    }

    // Mostrar información del preinscrito
    function mostrarInfoPreinscrito(preinscrito) {
        document.getElementById('info_documento').textContent = preinscrito.numero_documento || '-';
        document.getElementById('info_nombre').textContent = preinscrito.nombre_completo || '-';
        document.getElementById('info_programa').textContent = preinscrito.programa_nombre || '-';
        document.getElementById('info_estado').textContent = preinscrito.estado ? preinscrito.estado.replace('_', ' ').toUpperCase() : '-';
        document.getElementById('info_correo').textContent = preinscrito.correo_principal || '-';
        document.getElementById('info_telefono').textContent = preinscrito.celular_principal || '-';
        document.getElementById('preinscrito_info').style.display = 'block';
    }

    // Event listeners
    document.getElementById('btn_buscar').addEventListener('click', buscarPreinscritos);
    document.getElementById('btn_limpiar').addEventListener('click', function() {
        document.getElementById('filter_documento').value = '';
        document.getElementById('filter_nombre').value = '';
        document.getElementById('filter_programa').value = '';
        document.getElementById('filter_estado').value = '';
        document.getElementById('resultado_busqueda').style.display = 'none';
    });

    // Buscar en tiempo real
    ['filter_documento', 'filter_nombre', 'filter_programa', 'filter_estado'].forEach(id => {
        document.getElementById(id).addEventListener('change', buscarPreinscritos);
        document.getElementById(id).addEventListener('keyup', buscarPreinscritos);
    });

    // Al cambiar el select principal
    document.getElementById('preinscrito_id').addEventListener('change', function() {
        if (this.value) {
            const preinscrito = preinscritos.find(p => p.id == this.value);
            if (preinscrito) {
                mostrarInfoPreinscrito(preinscrito);
            }
        } else {
            document.getElementById('preinscrito_info').style.display = 'none';
        }
    });

    // Cargar preinscritos al iniciar
    cargarPreinscritos();
</script>
@endsection
