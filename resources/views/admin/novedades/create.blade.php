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
        <div class="col-lg-8 offset-lg-2">
            <div class="card card-outline card-primary">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="bi bi-form-check"></i>
                        Formulario de Registro
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

                        <div class="mb-3">
                            <label for="preinscrito_id" class="form-label">
                                Preinscrito <span class="text-danger">*</span>
                            </label>
                            <select class="form-select @error('preinscrito_id') is-invalid @enderror" 
                                    id="preinscrito_id" name="preinscrito_id" required>
                                <option value="">-- Selecciona un preinscrito --</option>
                            </select>
                            @error('preinscrito_id')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted">Escribe para buscar por nombre o documento</small>
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
    // Selector de preinscritos con búsqueda
    document.getElementById('preinscrito_id').addEventListener('focus', async function() {
        if (this.options.length === 1) {
            try {
                const response = await fetch('{{ route("api.preinscritos.index") }}');
                const preinscritos = await response.json();
                preinscritos.forEach(p => {
                    const option = document.createElement('option');
                    option.value = p.id;
                    option.textContent = p.nombre_completo + ' (' + p.numero_documento + ')';
                    this.appendChild(option);
                });
            } catch (e) {
                console.error('Error loading preinscritos:', e);
            }
        }
    });
</script>
@endsection
