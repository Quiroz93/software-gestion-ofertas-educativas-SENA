@php
    $isEdit = isset($homeCarousel);
    $route = $isEdit ? route('admin.home-carousel.update', $homeCarousel) : route('admin.home-carousel.store');
    $method = $isEdit ? 'PUT' : 'POST';
@endphp

<form action="{{ $route }}" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
    @csrf
    @method($method)

    <div class="row">
        {{-- Título --}}
        <div class="col-md-12 mb-4">
            <label for="title" class="form-label fw-medium">
                <i class="bi bi-type text-sena"></i> Título del slide *
            </label>
            <input type="text" 
                   class="form-control @error('title') is-invalid @enderror" 
                   id="title" 
                   name="title" 
                   value="{{ old('title', $homeCarousel->title ?? '') }}"
                   placeholder="Ingrese el título del slide"
                   required>
            @error('title')
                <div class="invalid-feedback d-block">
                    <i class="bi bi-exclamation-circle"></i> {{ $message }}
                </div>
            @enderror
        </div>

        {{-- Descripción --}}
        <div class="col-md-12 mb-4">
            <label for="description" class="form-label fw-medium">
                <i class="bi bi-chat-left-text text-sena"></i> Descripción
            </label>
            <textarea class="form-control @error('description') is-invalid @enderror" 
                      id="description" 
                      name="description" 
                      rows="3"
                      placeholder="Ingrese una descripción del slide (opcional)"
                      maxlength="500">{{ old('description', $homeCarousel->description ?? '') }}</textarea>
            <small class="text-muted d-block mt-2">
                <span id="descriptionCount">{{ strlen(old('description', $homeCarousel->description ?? '')) }}</span>/500 caracteres
            </small>
            @error('description')
                <div class="invalid-feedback d-block">
                    <i class="bi bi-exclamation-circle"></i> {{ $message }}
                </div>
            @enderror
        </div>

        {{-- Imagen --}}
        <div class="col-md-12 mb-4">
            <label for="image" class="form-label fw-medium">
                <i class="bi bi-image text-sena"></i> Imagen del slide
            </label>
            
            @if($isEdit && $homeCarousel->image_path)
                <div class="mb-3 d-flex align-items-center gap-3 p-3 bg-light rounded">
                    <img src="{{ asset('storage/' . $homeCarousel->image_path) }}" 
                         alt="{{ $homeCarousel->title }}"
                         style="max-width: 150px; max-height: 100px; object-fit: cover; border-radius: 4px;">
                    <div>
                        <p class="mb-2"><strong>Imagen actual</strong></p>
                        <label class="form-check-label d-flex align-items-center gap-2 cursor-pointer">
                            <input type="checkbox" class="form-check-input" name="remove_image" id="remove_image">
                            Eliminar imagen actual
                        </label>
                    </div>
                </div>
                <hr class="my-3">
            @endif

            <div class="mb-3">
                <input type="file" 
                       class="form-control @error('image') is-invalid @enderror" 
                       id="image" 
                       name="image" 
                       accept="image/jpeg,image/png,image/jpg,image/gif"
                       onchange="previewImage(event)">
                <small class="text-muted d-block mt-2">
                    Formatos: JPEG, PNG, JPG, GIF • Tamaño máximo: 2 MB
                </small>
                @error('image')
                    <div class="invalid-feedback d-block">
                        <i class="bi bi-exclamation-circle"></i> {{ $message }}
                    </div>
                @enderror
            </div>

            {{-- Preview de imagen nueva --}}
            <div id="imagePreview" class="mb-3" style="display: none;">
                <img id="previewImg" src="" alt="Preview" style="max-width: 200px; max-height: 150px; border-radius: 4px;">
            </div>
        </div>

        {{-- Botón de acción --}}
        <div class="col-md-6 mb-4">
            <label for="button_text" class="form-label fw-medium">
                <i class="bi bi-hand-index text-sena"></i> Texto del botón
            </label>
            <input type="text" 
                   class="form-control @error('button_text') is-invalid @enderror" 
                   id="button_text" 
                   name="button_text" 
                   value="{{ old('button_text', $homeCarousel->button_text ?? '') }}"
                   placeholder="ej. Conocer más"
                   maxlength="100">
            @error('button_text')
                <div class="invalid-feedback d-block">
                    <i class="bi bi-exclamation-circle"></i> {{ $message }}
                </div>
            @enderror
        </div>

        {{-- URL del botón --}}
        <div class="col-md-6 mb-4">
            <label for="button_url" class="form-label fw-medium">
                <i class="bi bi-link-45deg text-sena"></i> URL del botón
            </label>
            <input type="url" 
                   class="form-control @error('button_url') is-invalid @enderror" 
                   id="button_url" 
                   name="button_url" 
                   value="{{ old('button_url', $homeCarousel->button_url ?? '') }}"
                   placeholder="https://ejemplo.com"
                   maxlength="255">
            @error('button_url')
                <div class="invalid-feedback d-block">
                    <i class="bi bi-exclamation-circle"></i> {{ $message }}
                </div>
            @enderror
        </div>

        {{-- Posición --}}
        <div class="col-md-6 mb-4">
            <label for="position" class="form-label fw-medium">
                <i class="bi bi-arrow-down-up text-sena"></i> Orden de aparición *
            </label>
            <input type="number" 
                   class="form-control @error('position') is-invalid @enderror" 
                   id="position" 
                   name="position" 
                   value="{{ old('position', $homeCarousel->position ?? 0) }}"
                   min="0"
                   required>
            <small class="text-muted d-block mt-2">
                Los slides aparecerán en orden ascendente. (0, 1, 2, etc.)
            </small>
            @error('position')
                <div class="invalid-feedback d-block">
                    <i class="bi bi-exclamation-circle"></i> {{ $message }}
                </div>
            @enderror
        </div>

        {{-- Estado activo --}}
        <div class="col-md-6 mb-4">
            <div class="form-check mt-4">
                <input type="checkbox" 
                       class="form-check-input" 
                       id="is_active" 
                       name="is_active"
                       value="1"
                       {{ old('is_active', $homeCarousel->is_active ?? true) ? 'checked' : '' }}>
                <label class="form-check-label fw-medium" for="is_active">
                    <i class="bi bi-eye text-sena"></i> Mostrar este slide en el home
                </label>
                <small class="d-block text-muted mt-1">
                    Desactiva para ocultar sin eliminar
                </small>
            </div>
        </div>
    </div>

    {{-- Botones de acción --}}
    <div class="row mt-4">
        <div class="col-md-12">
            <div class="d-flex gap-2 justify-content-between align-items-center">
                <a href="{{ route('admin.home-carousel.index') }}" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-left"></i> Cancelar
                </a>
                <button type="submit" class="btn btn-sena">
                    <i class="bi bi-check-lg"></i> {{ $isEdit ? 'Actualizar slide' : 'Crear slide' }}
                </button>
            </div>
        </div>
    </div>
</form>

@push('scripts')
<script>
    // Preview de imagen
    function previewImage(event) {
        const file = event.target.files[0];
        const preview = document.getElementById('imagePreview');
        const previewImg = document.getElementById('previewImg');

        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                previewImg.src = e.target.result;
                preview.style.display = 'block';
            };
            reader.readAsDataURL(file);
        } else {
            preview.style.display = 'none';
        }
    }

    // Contador de caracteres para descripción
    document.getElementById('description').addEventListener('input', function() {
        document.getElementById('descriptionCount').textContent = this.value.length;
    });

    // Validación
    (function() {
        'use strict';
        window.addEventListener('load', function() {
            let forms = document.querySelectorAll('.needs-validation');
            Array.prototype.slice.call(forms).forEach(function(form) {
                form.addEventListener('submit', function(event) {
                    if (!form.checkValidity()) {
                        event.preventDefault();
                        event.stopPropagation();
                    }
                    form.classList.add('was-validated');
                }, false);
            });
        }, false);
    })();
</script>
@endpush
