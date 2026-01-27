<section>
    <header>
        <h2 class="h5 text-dark">
            Foto de Perfil
        </h2>
        <p class="text-muted small">
            Actualiza la foto de perfil de tu cuenta.
        </p>
    </header>

    <div class="mt-3">
        <!-- Vista previa de la foto actual -->
        <div class="d-flex align-items-center mb-3">
            <div class="me-3">
                <img src="{{ auth()->user()->profile_photo_url }}" 
                     alt="{{ auth()->user()->name }}" 
                     class="rounded-circle"
                     style="width: 80px; height: 80px; object-fit: cover;"
                     id="photo-preview">
            </div>
            <div>
                <p class="mb-1 fw-bold">{{ auth()->user()->name }}</p>
                <p class="mb-0 text-muted small">{{ auth()->user()->email }}</p>
            </div>
        </div>

        <!-- Formulario de subida -->
        <form method="POST" action="{{ route('profile.photo.update') }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="photo" class="form-label">Seleccionar nueva foto</label>
                <input type="file" 
                       class="form-control @error('photo') is-invalid @enderror" 
                       id="photo" 
                       name="photo" 
                       accept="image/*"
                       onchange="previewPhoto(event)">
                @error('photo')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                <small class="form-text text-muted">
                    Formatos permitidos: JPEG, PNG, JPG, WEBP. Tamaño máximo: 2MB
                </small>
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-upload me-1"></i> Subir Foto
                </button>

                @if(auth()->user()->profile_photo_path)
                    <button type="button" 
                            class="btn btn-outline-danger" 
                            onclick="deletePhoto()">
                        <i class="fas fa-trash me-1"></i> Eliminar Foto
                    </button>
                @endif
            </div>
        </form>

        <!-- Formulario oculto para eliminar -->
        <form method="POST" 
              action="{{ route('profile.photo.destroy') }}" 
              id="delete-photo-form" 
              class="d-none">
            @csrf
            @method('DELETE')
        </form>
    </div>

    @push('scripts')
    <script>
        // Preview de la foto antes de subir
        function previewPhoto(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('photo-preview').src = e.target.result;
                }
                reader.readAsDataURL(file);
            }
        }

        // Confirmar eliminación de foto
        function deletePhoto() {
            if (typeof Swal !== 'undefined') {
                Swal.fire({
                    title: '¿Eliminar foto de perfil?',
                    text: "Se restaurará la foto por defecto",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Sí, eliminar',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        document.getElementById('delete-photo-form').submit();
                    }
                });
            } else {
                // Fallback si SweetAlert2 no está disponible
                if (confirm('¿Estás seguro de eliminar tu foto de perfil?')) {
                    document.getElementById('delete-photo-form').submit();
                }
            }
        }
    </script>
    @endpush
</section>
