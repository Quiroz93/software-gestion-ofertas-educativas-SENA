{{-- Formulario reutilizable para Crear y Editar Municipios --}}

<div class="form-group mb-3">
    <label for="codigo" class="form-label">
        <strong>Código DANE <span class="text-danger">*</span></strong>
    </label>
    <input 
        type="text" 
        name="codigo" 
        id="codigo" 
        class="form-control @error('codigo') is-invalid @enderror"
        value="{{ old('codigo', $municipio->codigo ?? '') }}"
        placeholder="Ej: 11001"
        maxlength="50"
        required>
    @error('codigo')
    <div class="invalid-feedback">
        <i class="bi bi-exclamation-circle"></i>
        {{ $message }}
    </div>
    @enderror
    <small class="form-text text-muted">
        Código único del municipio según el DANE
    </small>
</div>

<div class="form-group mb-3">
    <label for="nombre" class="form-label">
        <strong>Nombre del Municipio <span class="text-danger">*</span></strong>
    </label>
    <input 
        type="text" 
        name="nombre" 
        id="nombre" 
        class="form-control @error('nombre') is-invalid @enderror"
        value="{{ old('nombre', $municipio->nombre ?? '') }}"
        placeholder="Ej: Bogotá D.C."
        maxlength="255"
        required>
    @error('nombre')
    <div class="invalid-feedback">
        <i class="bi bi-exclamation-circle"></i>
        {{ $message }}
    </div>
    @enderror
</div>

<div class="form-group mb-3">
    <label for="departamento" class="form-label">
        <strong>Departamento</strong>
    </label>
    <input 
        type="text" 
        name="departamento" 
        id="departamento" 
        class="form-control @error('departamento') is-invalid @enderror"
        value="{{ old('departamento', $municipio->departamento ?? '') }}"
        placeholder="Ej: Cundinamarca"
        maxlength="255">
    @error('departamento')
    <div class="invalid-feedback">
        <i class="bi bi-exclamation-circle"></i>
        {{ $message }}
    </div>
    @enderror
</div>

@if(isset($municipio) && $municipio->exists)
<div class="alert alert-info">
    <i class="bi bi-info-circle-fill me-2"></i>
    <strong>Programas asociados:</strong> {{ $municipio->programas->count() }}
    @if($municipio->programas->count() > 0)
    <br>
    <small>No podrá eliminar este municipio mientras tenga programas asociados.</small>
    @endif
</div>
@endif
