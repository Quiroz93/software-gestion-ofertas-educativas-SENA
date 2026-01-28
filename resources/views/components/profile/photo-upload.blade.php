<div class="card shadow-sm">
    <div class="card-body">
        <h5 class="card-title mb-3">
            <i class="bi bi-camera me-2"></i>Foto de Perfil
        </h5>
        
        <div class="text-center mb-3">
            <!-- Current Photo -->
            <div class="position-relative d-inline-block">
                <img id="profilePhotoPreview" 
                     src="{{ $user->profile_photo_url }}" 
                     alt="{{ $user->name }}"
                     class="rounded-circle border border-3 border-light shadow"
                     style="width: 150px; height: 150px; object-fit: cover;">
                
                @if($user->profile_photo_path)
                <!-- Delete Photo Button -->
                <form method="POST" 
                      action="{{ route('profile.photo.destroy') }}" 
                      class="d-inline"
                      onsubmit="return confirm('¿Estás seguro de eliminar tu foto de perfil?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" 
                            class="btn btn-danger btn-sm rounded-circle position-absolute top-0 end-0"
                            style="width: 32px; height: 32px; padding: 0;">
                        <i class="bi bi-trash"></i>
                    </button>
                </form>
                @endif
            </div>
        </div>

        <!-- Upload Form -->
        <form method="POST" 
              action="{{ route('profile.photo.update') }}" 
              enctype="multipart/form-data">
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
                    Formatos: JPG, PNG, GIF. Tamaño máximo: 2MB.
                </small>
            </div>

            <div class="d-grid">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-upload me-2"></i>Subir Foto
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
function previewPhoto(event) {
    const file = event.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('profilePhotoPreview').src = e.target.result;
        };
        reader.readAsDataURL(file);
    }
}
</script>
@endpush
