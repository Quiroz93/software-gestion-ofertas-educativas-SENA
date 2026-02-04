

<?php $__env->startSection('title', __('Iniciar sesión')); ?>

<?php $__env->startSection('content'); ?>
    <!-- Session Status -->
    <?php if($status = session('status')): ?>
        <div class="alert alert-success mb-3"><?php echo e($status); ?></div>
    <?php endif; ?>

    <form method="POST" action="<?php echo e(route('login')); ?>" class="bg-white border border-success rounded-3 p-4 shadow-sm">
        <?php echo csrf_field(); ?>

        <!-- Email Address -->
        <div class="mb-3">
            <label for="email" class="form-label"><?php echo e(__('Correo electrónico')); ?></label>
            <input id="email" class="form-control <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" type="email" name="email" value="<?php echo e(old('email')); ?>" required autofocus autocomplete="username" />
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
            <input id="password" class="form-control <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" type="password" name="password" required autocomplete="current-password" />
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

        <!-- Remember Me -->
        <div class="mb-3 form-check">
            <input id="remember_me" type="checkbox" class="form-check-input" name="remember">
            <label class="form-check-label" for="remember_me"><?php echo e(__('Recordar usuario')); ?></label>
        </div>

        <div class="d-flex align-items-center justify-content-between mt-3">
            <?php if(Route::has('password.request')): ?>
                <a class="link-secondary text-decoration-none" href="<?php echo e(route('password.request')); ?>">
                    <?php echo e(__('¿Olvidaste tu contraseña?')); ?>

                </a>
            <?php endif; ?>
        </div>
        <div class="row mt-4">
            <div class="col-6">
                <a href="<?php echo e(route('welcome')); ?>" class="btn btn-outline-secondary btn-sm">Cancelar</a>
            </div>
            <div class="col-6">
                <button type="submit" class="btn btn-outline-success float-end btn-sm">
                <?php echo e(__('Iniciar sesión')); ?>

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

<?php echo $__env->make('layouts.auth', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Saave\Documents\project\SOES\SoeSoftware2\resources\views/auth/login.blade.php ENDPATH**/ ?>