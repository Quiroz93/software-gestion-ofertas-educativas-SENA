

<?php $__env->startSection('title', __('Verificar Correo Electrónico')); ?>

<?php $__env->startSection('content'); ?>
    <div class="mb-4 small text-secondary">
        <?php echo e(__('gracias por registrarte! Antes de comenzar, ¿podrías verificar tu dirección de correo electrónico haciendo clic en el enlace que acabamos de enviarte? Si no recibiste el correo electrónico, ¡nosotros te enviaremos otro!')); ?>

    </div>

    <?php if(session('status') == 'verification-link-sent'): ?>
        <div class="mb-4 small text-success fw-bold">
            <?php echo e(__('Un nuevo enlace de verificación ha sido enviado a la dirección de correo electrónico que proporcionaste durante el registro.')); ?>

        </div>
    <?php endif; ?>

    <div class="mt-4 d-flex align-items-center justify-content-between">
        <form method="POST" action="<?php echo e(route('verification.send')); ?>">
            <?php echo csrf_field(); ?>
            <button type="submit" class="btn btn-primary">
                <?php echo e(__('Reenviar correo de verificación')); ?>

            </button>
        </form>

        <form method="POST" action="<?php echo e(route('logout')); ?>">
            <?php echo csrf_field(); ?>
            <button type="submit" class="btn btn-link text-decoration-none">
                <?php echo e(__('Cerrar sesión')); ?>

            </button>
        </form>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.auth', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Saave\Documents\project\SOES\SoeSoftware2\resources\views/auth/verify-email.blade.php ENDPATH**/ ?>