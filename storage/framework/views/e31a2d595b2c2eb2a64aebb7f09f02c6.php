<?php $__env->startSection('title', 'Mi Perfil'); ?>

<?php $__env->startSection('content'); ?>
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <!-- Page Header -->
            <div class="mb-4">
                <h1 class="h2 mb-2">
                    <i class="bi bi-person-circle me-2"></i>Mi Perfil
                </h1>
                <p class="text-muted">Administra la información de tu cuenta y configuración</p>
            </div>

            <!-- Success Messages -->
            <?php if(session('status')): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="bi bi-check-circle me-2"></i>
                    <?php if(session('status') === 'profile-updated'): ?>
                        Perfil actualizado correctamente.
                    <?php elseif(session('status') === 'password-updated'): ?>
                        Contraseña actualizada correctamente.
                    <?php elseif(session('status') === 'photo-updated'): ?>
                        Foto de perfil actualizada correctamente.
                    <?php elseif(session('status') === 'photo-deleted'): ?>
                        Foto de perfil eliminada correctamente.
                    <?php else: ?>
                        <?php echo e(session('status')); ?>

                    <?php endif; ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <div class="row g-4">
                <!-- Left Column -->
                <div class="col-md-4">
                    <!-- Profile Photo Upload -->
                    <?php if (isset($component)) { $__componentOriginal4bc1f249ddb38a5083b1b44ee7cad7bf = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal4bc1f249ddb38a5083b1b44ee7cad7bf = $attributes; } ?>
<?php $component = App\View\Components\Profile\PhotoUpload::resolve(['user' => $user] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('profile.photo-upload'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\Profile\PhotoUpload::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal4bc1f249ddb38a5083b1b44ee7cad7bf)): ?>
<?php $attributes = $__attributesOriginal4bc1f249ddb38a5083b1b44ee7cad7bf; ?>
<?php unset($__attributesOriginal4bc1f249ddb38a5083b1b44ee7cad7bf); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal4bc1f249ddb38a5083b1b44ee7cad7bf)): ?>
<?php $component = $__componentOriginal4bc1f249ddb38a5083b1b44ee7cad7bf; ?>
<?php unset($__componentOriginal4bc1f249ddb38a5083b1b44ee7cad7bf); ?>
<?php endif; ?>

                    <!-- User Card -->
                    <div class="mt-4">
                        <?php if (isset($component)) { $__componentOriginalab91f5e183508c704d28f6c65b9009c7 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalab91f5e183508c704d28f6c65b9009c7 = $attributes; } ?>
<?php $component = App\View\Components\Profile\UserCard::resolve(['user' => $user,'class' => 'mb-3'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('profile.user-card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\Profile\UserCard::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalab91f5e183508c704d28f6c65b9009c7)): ?>
<?php $attributes = $__attributesOriginalab91f5e183508c704d28f6c65b9009c7; ?>
<?php unset($__attributesOriginalab91f5e183508c704d28f6c65b9009c7); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalab91f5e183508c704d28f6c65b9009c7)): ?>
<?php $component = $__componentOriginalab91f5e183508c704d28f6c65b9009c7; ?>
<?php unset($__componentOriginalab91f5e183508c704d28f6c65b9009c7); ?>
<?php endif; ?>
                    </div>
                </div>

                <!-- Right Column -->
                <div class="col-md-8">
                    <!-- Update Profile Information -->
                    <?php if (isset($component)) { $__componentOriginala9097957eef4bf3d58655f8c20bcfc56 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginala9097957eef4bf3d58655f8c20bcfc56 = $attributes; } ?>
<?php $component = App\View\Components\UI\Card::resolve(['class' => 'mb-4'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('u-i.card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\UI\Card::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
                         <?php $__env->slot('header', null, []); ?> 
                            <h5 class="mb-0">
                                <i class="bi bi-info-circle me-2"></i>Información del Perfil
                            </h5>
                         <?php $__env->endSlot(); ?>

                        <form method="POST" action="<?php echo e(route('profile.update')); ?>">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('PATCH'); ?>

                            <!-- Name -->
                            <div class="mb-3">
                                <label for="name" class="form-label">Nombre <span class="text-danger">*</span></label>
                                <input type="text" 
                                       class="form-control <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                       id="name" 
                                       name="name" 
                                       value="<?php echo e(old('name', $user->name)); ?>" 
                                       required>
                                <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="invalid-feedback"><?php echo e($message); ?></div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>

                            <!-- Email -->
                            <div class="mb-3">
                                <label for="email" class="form-label">Correo Electrónico <span class="text-danger">*</span></label>
                                <input type="email" 
                                       class="form-control <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                       id="email" 
                                       name="email" 
                                       value="<?php echo e(old('email', $user->email)); ?>" 
                                       required>
                                <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="invalid-feedback"><?php echo e($message); ?></div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                <?php if($user->email_verified_at === null): ?>
                                    <small class="text-warning">
                                        <i class="bi bi-exclamation-triangle me-1"></i>
                                        Tu correo electrónico no está verificado.
                                    </small>
                                <?php endif; ?>
                            </div>

                            <!-- Bio -->
                            <div class="mb-3">
                                <label for="bio" class="form-label">Biografía</label>
                                <textarea class="form-control <?php $__errorArgs = ['bio'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                          id="bio" 
                                          name="bio" 
                                          rows="3"><?php echo e(old('bio', $user->bio)); ?></textarea>
                                <?php $__errorArgs = ['bio'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="invalid-feedback"><?php echo e($message); ?></div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>

                            <!-- Phone -->
                            <div class="mb-3">
                                <label for="phone" class="form-label">Teléfono</label>
                                <input type="tel" 
                                       class="form-control <?php $__errorArgs = ['phone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                       id="phone" 
                                       name="phone" 
                                       value="<?php echo e(old('phone', $user->phone)); ?>">
                                <?php $__errorArgs = ['phone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="invalid-feedback"><?php echo e($message); ?></div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>

                            <!-- Location -->
                            <div class="mb-3">
                                <label for="location" class="form-label">Ubicación</label>
                                <input type="text" 
                                       class="form-control <?php $__errorArgs = ['location'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                       id="location" 
                                       name="location" 
                                       value="<?php echo e(old('location', $user->location)); ?>">
                                <?php $__errorArgs = ['location'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="invalid-feedback"><?php echo e($message); ?></div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>

                            <!-- Website -->
                            <div class="mb-3">
                                <label for="website" class="form-label">Sitio Web</label>
                                <input type="url" 
                                       class="form-control <?php $__errorArgs = ['website'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                       id="website" 
                                       name="website" 
                                       value="<?php echo e(old('website', $user->website)); ?>" 
                                       placeholder="https://ejemplo.com">
                                <?php $__errorArgs = ['website'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="invalid-feedback"><?php echo e($message); ?></div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>

                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-save me-2"></i>Guardar Cambios
                                </button>
                                <a href="<?php echo e(route('home')); ?>" class="btn btn-outline-secondary">
                                    Cancelar
                                </a>
                            </div>
                        </form>
                     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginala9097957eef4bf3d58655f8c20bcfc56)): ?>
<?php $attributes = $__attributesOriginala9097957eef4bf3d58655f8c20bcfc56; ?>
<?php unset($__attributesOriginala9097957eef4bf3d58655f8c20bcfc56); ?>
<?php endif; ?>
<?php if (isset($__componentOriginala9097957eef4bf3d58655f8c20bcfc56)): ?>
<?php $component = $__componentOriginala9097957eef4bf3d58655f8c20bcfc56; ?>
<?php unset($__componentOriginala9097957eef4bf3d58655f8c20bcfc56); ?>
<?php endif; ?>

                    <!-- Update Password -->
                    <?php if (isset($component)) { $__componentOriginala9097957eef4bf3d58655f8c20bcfc56 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginala9097957eef4bf3d58655f8c20bcfc56 = $attributes; } ?>
<?php $component = App\View\Components\UI\Card::resolve(['class' => 'mb-4'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('u-i.card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\UI\Card::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
                         <?php $__env->slot('header', null, []); ?> 
                            <h5 class="mb-0">
                                <i class="bi bi-shield-lock me-2"></i>Actualizar Contraseña
                            </h5>
                         <?php $__env->endSlot(); ?>

                        <form method="POST" action="<?php echo e(route('password.update')); ?>">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('PUT'); ?>

                            <!-- Current Password -->
                            <div class="mb-3">
                                <label for="current_password" class="form-label">Contraseña Actual <span class="text-danger">*</span></label>
                                <input type="password" 
                                       class="form-control <?php $__errorArgs = ['current_password', 'updatePassword'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                       id="current_password" 
                                       name="current_password" 
                                       required>
                                <?php $__errorArgs = ['current_password', 'updatePassword'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="invalid-feedback"><?php echo e($message); ?></div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>

                            <!-- New Password -->
                            <div class="mb-3">
                                <label for="password" class="form-label">Nueva Contraseña <span class="text-danger">*</span></label>
                                <input type="password" 
                                       class="form-control <?php $__errorArgs = ['password', 'updatePassword'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                       id="password" 
                                       name="password" 
                                       required>
                                <?php $__errorArgs = ['password', 'updatePassword'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="invalid-feedback"><?php echo e($message); ?></div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>

                            <!-- Confirm Password -->
                            <div class="mb-3">
                                <label for="password_confirmation" class="form-label">Confirmar Contraseña <span class="text-danger">*</span></label>
                                <input type="password" 
                                       class="form-control <?php $__errorArgs = ['password_confirmation', 'updatePassword'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                       id="password_confirmation" 
                                       name="password_confirmation" 
                                       required>
                                <?php $__errorArgs = ['password_confirmation', 'updatePassword'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="invalid-feedback"><?php echo e($message); ?></div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>

                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-key me-2"></i>Actualizar Contraseña
                            </button>
                        </form>
                     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginala9097957eef4bf3d58655f8c20bcfc56)): ?>
<?php $attributes = $__attributesOriginala9097957eef4bf3d58655f8c20bcfc56; ?>
<?php unset($__attributesOriginala9097957eef4bf3d58655f8c20bcfc56); ?>
<?php endif; ?>
<?php if (isset($__componentOriginala9097957eef4bf3d58655f8c20bcfc56)): ?>
<?php $component = $__componentOriginala9097957eef4bf3d58655f8c20bcfc56; ?>
<?php unset($__componentOriginala9097957eef4bf3d58655f8c20bcfc56); ?>
<?php endif; ?>

                    <!-- Delete Account -->
                    <?php if (isset($component)) { $__componentOriginala9097957eef4bf3d58655f8c20bcfc56 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginala9097957eef4bf3d58655f8c20bcfc56 = $attributes; } ?>
<?php $component = App\View\Components\UI\Card::resolve(['class' => 'border-danger'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('u-i.card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\UI\Card::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
                         <?php $__env->slot('header', null, ['class' => 'bg-danger text-white']); ?> 
                            <h5 class="mb-0">
                                <i class="bi bi-exclamation-triangle me-2"></i>Eliminar Cuenta
                            </h5>
                         <?php $__env->endSlot(); ?>

                        <p class="text-muted mb-3">
                            Una vez que tu cuenta sea eliminada, todos sus recursos y datos serán eliminados permanentemente. 
                            Antes de eliminar tu cuenta, por favor descarga cualquier dato o información que desees conservar.
                        </p>

                        <button type="button" 
                                class="btn btn-danger" 
                                data-bs-toggle="modal" 
                                data-bs-target="#deleteAccountModal">
                            <i class="bi bi-trash me-2"></i>Eliminar Cuenta
                        </button>
                     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginala9097957eef4bf3d58655f8c20bcfc56)): ?>
<?php $attributes = $__attributesOriginala9097957eef4bf3d58655f8c20bcfc56; ?>
<?php unset($__attributesOriginala9097957eef4bf3d58655f8c20bcfc56); ?>
<?php endif; ?>
<?php if (isset($__componentOriginala9097957eef4bf3d58655f8c20bcfc56)): ?>
<?php $component = $__componentOriginala9097957eef4bf3d58655f8c20bcfc56; ?>
<?php unset($__componentOriginala9097957eef4bf3d58655f8c20bcfc56); ?>
<?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Delete Account Modal -->
<?php if (isset($component)) { $__componentOriginalf81c519e48f7de4093e3e06a3dbf8713 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf81c519e48f7de4093e3e06a3dbf8713 = $attributes; } ?>
<?php $component = App\View\Components\UI\Modal::resolve(['id' => 'deleteAccountModal','centered' => true] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('u-i.modal'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\UI\Modal::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
     <?php $__env->slot('title', null, []); ?> 
        <i class="bi bi-exclamation-triangle text-danger me-2"></i>Eliminar Cuenta
     <?php $__env->endSlot(); ?>

    <p>¿Estás seguro de que deseas eliminar tu cuenta? Esta acción no se puede deshacer.</p>
    <p class="text-danger fw-bold">Todos tus datos serán eliminados permanentemente.</p>

    <form method="POST" action="<?php echo e(route('profile.destroy')); ?>">
        <?php echo csrf_field(); ?>
        <?php echo method_field('DELETE'); ?>

        <div class="mb-3">
            <label for="password_delete" class="form-label">Confirma tu contraseña para continuar:</label>
            <input type="password" 
                   class="form-control <?php $__errorArgs = ['password', 'userDeletion'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                   id="password_delete" 
                   name="password" 
                   placeholder="Contraseña" 
                   required>
            <?php $__errorArgs = ['password', 'userDeletion'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <div class="invalid-feedback"><?php echo e($message); ?></div>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>

         <?php $__env->slot('footer', null, []); ?> 
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                Cancelar
            </button>
            <button type="submit" class="btn btn-danger">
                <i class="bi bi-trash me-2"></i>Eliminar Cuenta
            </button>
         <?php $__env->endSlot(); ?>
    </form>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalf81c519e48f7de4093e3e06a3dbf8713)): ?>
<?php $attributes = $__attributesOriginalf81c519e48f7de4093e3e06a3dbf8713; ?>
<?php unset($__attributesOriginalf81c519e48f7de4093e3e06a3dbf8713); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalf81c519e48f7de4093e3e06a3dbf8713)): ?>
<?php $component = $__componentOriginalf81c519e48f7de4093e3e06a3dbf8713; ?>
<?php unset($__componentOriginalf81c519e48f7de4093e3e06a3dbf8713); ?>
<?php endif; ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.bootstrap', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Saave\Documents\project\SOES\SoeSoftware2\resources\views/profile/edit.blade.php ENDPATH**/ ?>