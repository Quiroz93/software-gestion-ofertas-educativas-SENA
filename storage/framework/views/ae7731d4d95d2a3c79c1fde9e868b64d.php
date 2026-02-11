

<?php $__env->startSection('title', __('Registro de Usuario')); ?>

<?php $__env->startSection('content'); ?>
<?php $bootstrap = app('App\\Services\\SystemBootstrapService'); ?>

<form method="POST" action="<?php echo e(route('register')); ?>" class="bg-white border border-success rounded-3 p-4 shadow-sm">
    <?php echo csrf_field(); ?>

    <!-- Título -->
    <h2 class="h4 text-center text-success mb-4">
        <?php echo e(__('Registro de Usuario')); ?>

    </h2>

    <!-- Nombre -->
    <div class="mb-3">
        <label for="name" class="form-label"><?php echo e(__('Nombre')); ?></label>
        <input id="name" type="text" class="form-control <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
            name="name" value="<?php echo e(old('name')); ?>" required autofocus />
        <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
        <div class="invalid-feedback d-block"><?php echo e($message); ?></div>
        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
    </div>

    <!-- Email -->
    <div class="mb-3">
        <label for="email" class="form-label"><?php echo e(__('Correo Electrónico')); ?></label>
        <input id="email" type="email" class="form-control <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
            name="email" value="<?php echo e(old('email')); ?>" required />
        <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
        <div class="invalid-feedback d-block"><?php echo e($message); ?></div>
        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
    </div>

    <!-- Password -->
    <div class="mb-3">
        <label for="password" class="form-label"><?php echo e(__('Contraseña')); ?></label>
        <input id="password" type="password" class="form-control <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
            name="password" required />
        <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
        <div class="invalid-feedback d-block"><?php echo e($message); ?></div>
        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
    </div>

    <!-- Toggle Password -->
    <div class="mb-3 form-check">
        <input type="checkbox" class="form-check-input" id="togglePassword">
        <label class="form-check-label" for="togglePassword"><?php echo e(__('Ver Contraseña')); ?></label>
    </div>

    <!-- Confirm Password -->
    <div class="mb-3">
        <label for="password_confirmation" class="form-label"><?php echo e(__('Confirmar Contraseña')); ?></label>
        <input id="password_confirmation" type="password" class="form-control <?php $__errorArgs = ['password_confirmation'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
            name="password_confirmation" required />
        <?php $__errorArgs = ['password_confirmation'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
        <div class="invalid-feedback d-block"><?php echo e($message); ?></div>
        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
    </div>

    <!-- Owner Key -->
    <!-- Si el sistema no está inicializado (según DB), se solicita la owner_key -->
    <?php if(!$bootstrap->systemIsInitialized()): ?>

    <p class="text-danger small">
        <?php echo e(__('* Bienvenido: Esta clave es necesaria para inicializar el sistema. Solo se necesitará una vez. Si no se proporciona, El sistema asignara un usuariio por defecto y seguira esperando la inicialización.')); ?>

    </p>
    <div class="mb-3">
        <label for="owner_key" class="form-label">
            Clave de inicialización del sistema
        </label>

        <input
            type="password"
            name="owner_key"
            id="owner_key"
            class="form-control <?php $__errorArgs = ['owner_key'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
            required>
        <?php $__errorArgs = ['owner_key'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
        <div class="invalid-feedback d-block"><?php echo e($message); ?></div>
        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

    </div>
    <?php endif; ?>


    <!-- Acciones -->
    <div class="d-flex align-items-center justify-content-between mt-4">
        <a href="<?php echo e(route('login')); ?>" class="link-secondary text-decoration-none small">
            <?php echo e(__('¿Ya tienes una cuenta?')); ?>

        </a>
    </div>
    <div class="row mt-4">
        <div class="col-6">
            <a href="<?php echo e(route('welcome')); ?>" class="btn btn-outline-secondary  btn-sm">Cancelar</a>
        </div>
        <div class="col-6">
            <button type="submit" class="btn btn-outline-success float-end btn-sm">
                <?php echo e(__('Registrarse')); ?>

            </button>
        </div>
        
    </div>
</form>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const toggleCheckbox = document.getElementById('togglePassword');
        const passwordInput = document.getElementById('password');

        if (toggleCheckbox && passwordInput) {
            toggleCheckbox.addEventListener('change', function() {
                if (this.checked) {
                    passwordInput.type = 'text';
                } else {
                    passwordInput.type = 'password';
                }
            });
        }
    });
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.auth', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Saave\Documents\project\SOES\SoeSoftware2\resources\views/auth/register.blade.php ENDPATH**/ ?>