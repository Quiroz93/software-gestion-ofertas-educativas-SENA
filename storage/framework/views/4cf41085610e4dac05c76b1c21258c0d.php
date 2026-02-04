<div class="card <?php echo e($class ?? ''); ?>">
    <?php if(isset($header)): ?>
    <div class="card-header <?php echo e($headerClass ?? ''); ?>">
        <?php echo e($header); ?>

    </div>
    <?php endif; ?>

    <div class="card-body <?php echo e($bodyClass ?? ''); ?>">
        <?php if(isset($title)): ?>
        <h5 class="card-title"><?php echo e($title); ?></h5>
        <?php endif; ?>

        <?php if(isset($subtitle)): ?>
        <h6 class="card-subtitle mb-2 text-muted"><?php echo e($subtitle); ?></h6>
        <?php endif; ?>

        <?php echo e($slot); ?>

    </div>

    <?php if(isset($footer)): ?>
    <div class="card-footer <?php echo e($footerClass ?? ''); ?>">
        <?php echo e($footer); ?>

    </div>
    <?php endif; ?>
</div>
<?php /**PATH C:\Users\Saave\Documents\project\SOES\SoeSoftware2\resources\views/components/u-i/card.blade.php ENDPATH**/ ?>