@extends('layouts.admin')

@section('title', 'Editar Preinscrito')

@section('content_header')
<div class="d-flex justify-content-between align-items-center">
    <h1 class="m-0">
        <i class="fas fa-edit text-primary"></i>
        Editar Preinscrito: {{ $presrito->nombre_completo }}
    </h1>
    <a href="{{ route('preinscritos.index') }}" class="btn btn-outline-secondary">
        <i class="fas fa-arrow-left"></i>
        Volver
    </a>
</div>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-8 offset-lg-2">
            <div class="card card-outline card-primary">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-form"></i>
                        Formulario de Edición
                    </h3>
                </div>

                <form action="{{ route('preinscritos.update', $presrito->id) }}" method="POST" id="formPresrito">
                    @csrf
                    @method('PUT')

                    <div class="card-body">
                        <!-- Alertas de error -->
                        @if($errors->any())
                            <div class="alert alert-danger">
                                <strong>¡Error!</strong> Revisa los campos que contienen errores:
                                <ul class="mb-0">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <!-- Datos Personales -->
                        <h5 class="mb-3">
                            <i class="fas fa-user"></i>
                            Datos Personales
                        </h5>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="nombres" class="form-label">
                                    Nombres <span class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control @error('nombres') is-invalid @enderror" 
                                       id="nombres" name="nombres" value="{{ old('nombres', $presrito->nombres) }}" 
                                       placeholder="Ej: Juan" required>
                                @error('nombres')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="apellidos" class="form-label">
                                    Apellidos <span class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control @error('apellidos') is-invalid @enderror" 
                                       id="apellidos" name="apellidos" value="{{ old('apellidos', $presrito->apellidos) }}" 
                                       placeholder="Ej: Pérez González" required>
                                @error('apellidos')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Documento de Identidad -->
                        <h5 class="mb-3">
                            <i class="fas fa-id-card"></i>
                            Documento de Identidad
                        </h5>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="tipo_documento" class="form-label">
                                    Tipo de Documento <span class="text-danger">*</span>
                                </label>
                                <select class="form-select @error('tipo_documento') is-invalid @enderror" 
                                        id="tipo_documento" name="tipo_documento" required>
                                    <option value="">-- Selecciona un tipo --</option>
                                    @foreach($tiposDocumento as $valor => $etiqueta)
                                        <option value="{{ $valor }}" {{ old('tipo_documento', $presrito->tipo_documento) == $valor ? 'selected' : '' }}>
                                            {{ $etiqueta }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('tipo_documento')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="numero_documento" class="form-label">
                                    Número de Documento <span class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control @error('numero_documento') is-invalid @enderror" 
                                       id="numero_documento" name="numero_documento" value="{{ old('numero_documento', $presrito->numero_documento) }}" 
                                       placeholder="Ej: 1234567890" required>
                                @error('numero_documento')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Información de Contacto -->
                        <h5 class="mb-3">
                            <i class="fas fa-phone"></i>
                            Información de Contacto
                        </h5>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="celular_principal" class="form-label">
                                    Celular Principal <span class="text-danger">*</span>
                                </label>
                                <input type="tel" class="form-control @error('celular_principal') is-invalid @enderror" 
                                       id="celular_principal" name="celular_principal" value="{{ old('celular_principal', $presrito->celular_principal) }}" 
                                       placeholder="Ej: 3001234567" required>
                                @error('celular_principal')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="celular_alternativo" class="form-label">
                                    Celular Alternativo
                                </label>
                                <input type="tel" class="form-control @error('celular_alternativo') is-invalid @enderror" 
                                       id="celular_alternativo" name="celular_alternativo" value="{{ old('celular_alternativo', $presrito->celular_alternativo) }}" 
                                       placeholder="Ej: 3187654321">
                                @error('celular_alternativo')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="correo_principal" class="form-label">
                                    Correo Principal <span class="text-danger">*</span>
                                </label>
                                <input type="email" class="form-control @error('correo_principal') is-invalid @enderror" 
                                       id="correo_principal" name="correo_principal" value="{{ old('correo_principal', $presrito->correo_principal) }}" 
                                       placeholder="Ej: ejemplo@correo.com" required>
                                @error('correo_principal')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="correo_alternativo" class="form-label">
                                    Correo Alternativo
                                </label>
                                <input type="email" class="form-control @error('correo_alternativo') is-invalid @enderror" 
                                       id="correo_alternativo" name="correo_alternativo" value="{{ old('correo_alternativo', $presrito->correo_alternativo) }}" 
                                       placeholder="Ej: alternativo@correo.com">
                                @error('correo_alternativo')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Información de Formación -->
                        <h5 class="mb-3">
                            <i class="fas fa-graduation-cap"></i>
                            Información de Formación
                        </h5>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="programa_id" class="form-label">
                                    Programa <span class="text-danger">*</span>
                                </label>
                                <select class="form-select @error('programa_id') is-invalid @enderror" 
                                        id="programa_id" name="programa_id" required>
                                    <option value="">-- Selecciona un programa --</option>
                                    @foreach($programas as $programa)
                                        <option value="{{ $programa->id }}" {{ old('programa_id', $presrito->programa_id) == $programa->id ? 'selected' : '' }}>
                                            {{ $programa->nombre }} ({{ $programa->numero_ficha }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('programa_id')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="estado" class="form-label">
                                    Estado <span class="text-danger">*</span>
                                </label>
                                <select class="form-select @error('estado') is-invalid @enderror" 
                                        id="estado" name="estado" required>
                                    <option value="">-- Selecciona un estado --</option>
                                    @foreach($estados as $valor => $etiqueta)
                                        <option value="{{ $valor }}" {{ old('estado', $presrito->estado) == $valor ? 'selected' : '' }}>
                                            {{ $etiqueta }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('estado')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Información Adicional -->
                        <h5 class="mb-3">
                            <i class="fas fa-sticky-note"></i>
                            Información Adicional
                        </h5>

                        <div class="row mb-3">
                            <div class="col-12">
                                <label for="comentarios" class="form-label">
                                    Comentarios
                                </label>
                                <textarea class="form-control @error('comentarios') is-invalid @enderror" 
                                          id="comentarios" name="comentarios" rows="4" 
                                          placeholder="Agrega comentarios o notas adicionales...">{{ old('comentarios', $presrito->comentarios) }}</textarea>
                                @error('comentarios')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Sección de Novedad (Opcional) -->
                        <hr class="my-4">
                        <h5 class="mb-3">
                            <i class="fas fa-exclamation-triangle text-warning"></i>
                            Registrar Novedad (Opcional)
                        </h5>
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle"></i>
                            <strong>Nota:</strong> Si el preinscrito requiere una novedad desde el inicio, completa esta sección. Esto es independiente del estado del preinscrito.
                        </div>

                        <div class="row mb-3">
                            <div class="col-12">
                                <div class="form-check form-switch mb-3">
                                    <input class="form-check-input" type="checkbox" id="tiene_novedad" name="tiene_novedad" 
                                           value="1" {{ old('tiene_novedad') ? 'checked' : '' }}
                                           onchange="toggleNovedadFields()">
                                    <label class="form-check-label" for="tiene_novedad">
                                        <strong>Este preinscrito tiene una novedad</strong>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div id="novedad_fields" style="display: {{ old('tiene_novedad') ? 'block' : 'none' }};">
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="tipo_novedad_id" class="form-label">
                                        Tipo de Novedad
                                    </label>
                                    <select class="form-select @error('tipo_novedad_id') is-invalid @enderror" 
                                            id="tipo_novedad_id" name="tipo_novedad_id">
                                        <option value="">-- Selecciona un tipo (opcional) --</option>
                                        @foreach($tiposNovedades as $key => $tipo)
                                            @php
                                                $tipoId = is_object($tipo) ? $tipo->id : $key;
                                                $tipoNombre = is_object($tipo) ? $tipo->nombre : $tipo;
                                            @endphp
                                            <option value="{{ $tipoId }}" {{ old('tipo_novedad_id') == $tipoId ? 'selected' : '' }}>
                                                {{ $tipoNombre }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('tipo_novedad_id')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="novedad_estado" class="form-label">
                                        Estado de la Novedad <span class="text-danger">*</span>
                                    </label>
                                    <select class="form-select @error('novedad_estado') is-invalid @enderror" 
                                            id="novedad_estado" name="novedad_estado">
                                        <option value="">-- Selecciona un estado --</option>
                                        <option value="abierta" {{ old('novedad_estado') == 'abierta' ? 'selected' : '' }}>Abierta</option>
                                        <option value="en_gestion" {{ old('novedad_estado') == 'en_gestion' ? 'selected' : '' }}>En Gestión</option>
                                        <option value="resuelta" {{ old('novedad_estado') == 'resuelta' ? 'selected' : '' }}>Resuelta</option>
                                        <option value="cancelada" {{ old('novedad_estado') == 'cancelada' ? 'selected' : '' }}>Cancelada</option>
                                    </select>
                                    @error('novedad_estado')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-12">
                                    <label for="novedad_descripcion" class="form-label">
                                        Descripción de la Novedad <span class="text-danger">*</span>
                                    </label>
                                    <textarea class="form-control @error('novedad_descripcion') is-invalid @enderror" 
                                              id="novedad_descripcion" name="novedad_descripcion" rows="4" 
                                              placeholder="Describe la novedad o situación especial del preinscrito...">{{ old('novedad_descripcion') }}</textarea>
                                    @error('novedad_descripcion')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                    <small class="text-muted">Este campo es requerido cuando se marca que el preinscrito tiene novedad.</small>
                                </div>
                            </div>
                        </div>

                        <!-- Información de Auditoría -->
                        <div class="alert alert-light border mt-3">
                            <small class="text-muted d-block">
                                <strong>Creado:</strong> {{ $presrito->created_at->format('d/m/Y H:i') }}
                                @if($presrito->createdBy)
                                    por {{ $presrito->createdBy->name }}
                                @endif
                            </small>
                            <small class="text-muted d-block">
                                <strong>Última actualización:</strong> {{ $presrito->updated_at->format('d/m/Y H:i') }}
                                @if($presrito->updatedBy)
                                    por {{ $presrito->updatedBy->name }}
                                @endif
                            </small>
                        </div>
                    </div>

                    <div class="card-footer">
                        <button type="submit" class="btn btn-outline-primary">
                            <i class="fas fa-save"></i>
                            Guardar Cambios
                        </button>
                        <a href="{{ route('preinscritos.index') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-times"></i>
                            Cancelar
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    // Mostrar/ocultar campos de novedad
    function toggleNovedadFields() {
        const checkbox = document.getElementById('tiene_novedad');
        const fields = document.getElementById('novedad_fields');
        const estado = document.getElementById('novedad_estado');
        const descripcion = document.getElementById('novedad_descripcion');
        
        if (checkbox.checked) {
            fields.style.display = 'block';
            estado.required = true;
            descripcion.required = true;
        } else {
            fields.style.display = 'none';
            estado.required = false;
            descripcion.required = false;
            estado.value = '';
            descripcion.value = '';
            document.getElementById('tipo_novedad_id').value = '';
        }
    }

    // Validación de formulario
    document.getElementById('formPresrito').addEventListener('submit', function(e) {
        const numeroDocumento = document.getElementById('numero_documento').value;
        if (!numeroDocumento || numeroDocumento.length < 5) {
            e.preventDefault();
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'El número de documento debe tener al menos 5 caracteres.'
            });
            return false;
        }

        // Validar campos de novedad si está marcado
        const tieneNovedad = document.getElementById('tiene_novedad').checked;
        if (tieneNovedad) {
            const estadoNovedad = document.getElementById('novedad_estado').value;
            const descripcionNovedad = document.getElementById('novedad_descripcion').value;
            
            if (!estadoNovedad || !descripcionNovedad) {
                e.preventDefault();
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Debes completar el estado y descripción de la novedad.'
                });
                return false;
            }
        }
    });

    // Inicializar estado de campos al cargar
    document.addEventListener('DOMContentLoaded', function() {
        toggleNovedadFields();
    });
</script>
@endsection
