<div class="card shadow-sm <?php echo e($class ?? ''); ?>">
    <div class="card-body">
        <div class="d-flex align-items-center">
            <!-- Profile Photo -->
            <div class="me-3">
                <img src="<?php echo e($user->profile_photo_url); ?>" 
                     alt="<?php echo e($user->name); ?>"
                     class="rounded-circle border border-2"
                     style="width: 80px; height: 80px; object-fit: cover;">
            </div>

            <!-- User Info -->
            <div class="flex-grow-1">
                <h5 class="card-title mb-1"><?php echo e($user->name); ?></h5>
                <p class="text-muted mb-1">
                    <i class="bi bi-envelope me-1"></i><?php echo e($user->email); ?>

                </p>
                
                <?php if($user->phone): ?>
                <p class="text-muted mb-1">
                    <i class="bi bi-telephone me-1"></i><?php echo e($user->phone); ?>

                </p>
                <?php endif; ?>

                <?php if($user->location): ?>
                <p class="text-muted mb-1">
                    <i class="bi bi-geo-alt me-1"></i><?php echo e($user->location); ?>

                </p>
                <?php endif; ?>

                <?php if($user->website): ?>
                <p class="mb-0">
                    <i class="bi bi-link-45deg me-1"></i>
                    <a href="<?php echo e($user->website); ?>" target="_blank" class="text-decoration-none">
                        <?php echo e($user->website); ?>

                    </a>
                </p>
                <?php endif; ?>
            </div>

            <!-- Action Slot -->
            <?php if(isset($actions)): ?>
            <div class="ms-3">
                <?php echo e($actions); ?>

            </div>
            <?php endif; ?>
        </div>

        <!-- Bio -->
        <?php if($user->bio): ?>
        <hr class="my-3">
        <div>
            <strong class="d-block mb-2">Biografía:</strong>
            <p class="text-muted mb-0"><?php echo e($user->bio); ?></p>
        </div>
        <?php endif; ?>

        <!-- Additional Content Slot -->
        <?php if(isset($slot) && !empty(trim($slot))): ?>
        <hr class="my-3">
        <div>
            <?php echo e($slot); ?>

        </div>
        <?php endif; ?>
    </div>
</div>
<?php /**PATH C:\Users\Saave\Documents\project\SOES\SoeSoftware2\resources\views/components/profile/user-card.blade.php ENDPATH**/ ?>