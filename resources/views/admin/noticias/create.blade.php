@extends('layouts.admin')

@section('title', 'Crear Noticia')

@section('content_header')
<div class="d-flex justify-content-between align-items-center">
    <h1 class="m-0">
        <i class="fas fa-plus text-primary"></i>
        Crear Nueva Noticia
    </h1>

    <a href="{{ route('noticias.index') }}" class="btn btn-outline-secondary">
        <i class="fas fa-arrow-left"></i>
        Volver
    </a>
</div>
@endsection

@section('content')

<div class="row">
    <div class="col-md-8 offset-md-2">

        <div class="card card-outline card-primary shadow-sm">

            {{-- HEADER --}}
            <div class="card-header">
                <h3 class="card-title fw-bold">
                    Información de la noticia
                </h3>
            </div>

            <form action="{{ route('noticias.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                {{-- BODY --}}
                <div class="card-body">

                    {{-- Título --}}
                    <div class="form-group mb-3">
                        <label for="titulo"><strong>Título</strong> <span class="text-danger">*</span></label>
                        <input type="text"
                               name="titulo"
                               id="titulo"
                               value="{{ old('titulo') }}"
                               class="form-control @error('titulo') is-invalid @enderror"
                               required>
                        @error('titulo')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Descripción --}}
                    <div class="form-group mb-3">
                        <label for="descripcion"><strong>Descripción</strong> <span class="text-danger">*</span></label>
                        <textarea name="descripcion"
                                  id="descripcion"
                                  rows="6"
                                  class="form-control @error('descripcion') is-invalid @enderror"
                                  required>{{ old('descripcion') }}</textarea>
                        @error('descripcion')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Imagen --}}
                    <div class="form-group mb-3">
                        <label for="imagen"><strong>Imagen</strong></label>
                        <input type="file"
                               name="imagen"
                               id="imagen"
                               class="form-control @error('imagen') is-invalid @enderror"
                               accept="image/*"
                               onchange="previewImage(event)">
                        <small class="form-text text-muted">
                            Formatos permitidos: JPG, PNG, GIF. Tamaño máximo: 2MB
                        </small>
                        @error('imagen')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        
                        {{-- Vista previa de imagen --}}
                        <div id="imagePreview" class="mt-3" style="display: none;">
                            <label class="d-block mb-2">
                                <strong class="text-success">
                                    <i class="fas fa-eye me-1"></i>Vista previa
                                </strong>
                            </label>
                            <div class="border border-success rounded p-3 bg-light position-relative">
                                <img id="previewImg" 
                                     class="img-fluid rounded" 
                                     style="max-width: 100%; max-height: 400px; object-fit: contain;">
                                <button type="button" 
                                        class="btn btn-sm btn-danger position-absolute top-0 end-0 m-2"
                                        onclick="removePreview()"
                                        title="Cancelar selección">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    {{-- Estado (Activa) --}}
                    <div class="form-group mb-3">
                        <div class="form-check">
                            <input type="checkbox"
                                   name="activa"
                                   id="activa"
                                   value="1"
                                   class="form-check-input"
                                   {{ old('activa', true) ? 'checked' : '' }}>
                            <label class="form-check-label" for="activa">
                                <strong>Noticia activa</strong>
                            </label>
                            <small class="form-text text-muted d-block">
                                Las noticias activas se mostrarán en el sitio público
                            </small>
                        </div>
                    </div>

                </div>

                {{-- FOOTER --}}
                <div class="card-footer">
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('noticias.index') }}" class="btn btn-secondary">
                            <i class="fas fa-times"></i>
                            Cancelar
                        </a>
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-save"></i>
                            Guardar noticia
                        </button>
                    </div>
                </div>

            </form>

        </div>

    </div>
</div>

@endsection

@push('scripts')
<script>
function previewImage(event) {
    const file = event.target.files[0];
    const preview = document.getElementById('imagePreview');
    const previewImg = document.getElementById('previewImg');
    
    if (file) {
        // Validar tamaño (2MB)
        if (file.size > 2048000) {
            Swal.fire({
                icon: 'error',
                title: 'Archivo muy grande',
                text: 'La imagen no debe superar los 2MB',
                confirmButtonColor: '#39A900'
            });
            event.target.value = '';
            return;
        }
        
        // Validar tipo
        if (!file.type.match('image.*')) {
            Swal.fire({
                icon: 'error',
                title: 'Formato inválido',
                text: 'Solo se permiten imágenes (JPG, PNG, GIF)',
                confirmButtonColor: '#39A900'
            });
            event.target.value = '';
            return;
        }
        
        const reader = new FileReader();
        reader.onload = function(e) {
            previewImg.src = e.target.result;
            preview.style.display = 'block';
        };
        reader.readAsDataURL(file);
    }
}

function removePreview() {
    const input = document.getElementById('imagen');
    const preview = document.getElementById('imagePreview');
    
    input.value = '';
    preview.style.display = 'none';
}
</script>
@endpush
