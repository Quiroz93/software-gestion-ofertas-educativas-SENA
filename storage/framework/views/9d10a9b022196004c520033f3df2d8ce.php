<div class="card shadow-sm">
    <div class="card-body">
        <h5 class="card-title mb-3">
            <i class="bi bi-camera me-2"></i>Foto de Perfil
        </h5>
        
        <div class="text-center mb-3">
            <!-- Current Photo -->
            <div class="position-relative d-inline-block">
                <img id="profilePhotoPreview" 
                     src="<?php echo e($user->profile_photo_url); ?>" 
                     alt="<?php echo e($user->name); ?>"
                     class="rounded-circle border border-3 border-light shadow"
                     style="width: 150px; height: 150px; object-fit: cover;">
                
                <?php if($user->profile_photo_path): ?>
                <!-- Delete Photo Button -->
                <form method="POST" 
                      action="<?php echo e(route('profile.photo.destroy')); ?>" 
                      class="d-inline deletePhotoForm">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('DELETE'); ?>
                    <button type="button" 
                            class="btn btn-danger btn-sm rounded-circle position-absolute top-0 end-0 deletePhotoBtn"
                            style="width: 32px; height: 32px; padding: 0;">
                        <i class="bi bi-trash"></i>
                    </button>
                </form>
                <?php endif; ?>
            </div>
        </div>

        <!-- Upload Form -->
        <form method="POST" 
              action="<?php echo e(route('profile.photo.update')); ?>" 
              enctype="multipart/form-data">
            <?php echo csrf_field(); ?>
            <?php echo method_field('PUT'); ?>
            
            <div class="mb-3">
                <label for="photo" class="form-label">Seleccionar nueva foto</label>
                <input type="file" 
                       class="form-control <?php $__errorArgs = ['photo'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                       id="photo" 
                       name="photo"
                       accept="image/*"
                       onchange="previewPhoto(event)">
                <?php $__errorArgs = ['photo'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <div class="invalid-feedback"><?php echo e($message); ?></div>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
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

<?php $__env->startPush('scripts'); ?>
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

// Confirmación para eliminar foto con SweetAlert2
document.addEventListener('DOMContentLoaded', function() {
    const deletePhotoBtn = document.querySelector('.deletePhotoBtn');
    const deletePhotoForm = document.querySelector('.deletePhotoForm');
    
    if (deletePhotoBtn && deletePhotoForm) {
        deletePhotoBtn.addEventListener('click', function(e) {
            e.preventDefault();
            
            Swal.fire({
                title: '¿Eliminar foto de perfil?',
                text: 'Esta acción no se puede deshacer',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6c757d',
                confirmButtonText: '<i class="bi bi-trash me-1"></i> Sí, eliminar',
                cancelButtonText: '<i class="bi bi-x-circle me-1"></i> Cancelar',
                reverseButtons: true,
                customClass: {
                    confirmButton: 'btn btn-danger btn-sm',
                    cancelButton: 'btn btn-secondary btn-sm'
                },
                buttonsStyling: false
            }).then((result) => {
                if (result.isConfirmed) {
                    deletePhotoForm.submit();
                }
            });
        });
    }
});
</script>
<?php $__env->stopPush(); ?>
<?php /**PATH C:\Users\Saave\Documents\project\SOES\SoeSoftware2\resources\views/components/profile/photo-upload.blade.php ENDPATH**/ ?>