<div class="modal fade" id="<?php echo e($id); ?>" tabindex="-1" aria-labelledby="<?php echo e($id); ?>Label" aria-hidden="true">
    <div class="modal-dialog <?php echo e($size ?? ''); ?> <?php echo e($centered ? 'modal-dialog-centered' : ''); ?> <?php echo e($scrollable ? 'modal-dialog-scrollable' : ''); ?>">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="<?php echo e($id); ?>Label">
                    <?php echo e($title ?? 'Modal'); ?>

                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <?php echo e($slot); ?>

            </div>
            <?php if(isset($footer)): ?>
            <div class="modal-footer">
                <?php echo e($footer); ?>

            </div>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php /**PATH C:\Users\Saave\Documents\project\SOES\SoeSoftware2\resources\views/components/u-i/modal.blade.php ENDPATH**/ ?>