<?php if($paginator->hasPages()): ?>
    <nav class="d-flex justify-items-center justify-content-between" aria-label="Paginación">
        
        <div class="d-flex justify-content-between flex-fill d-sm-none">
            <ul class="pagination pagination-sena">
                <?php if($paginator->onFirstPage()): ?>
                    <li class="page-item disabled" aria-disabled="true">
                        <span class="page-link">
                            <span class="icon-nav icon-nav-prev" aria-hidden="true"></span>
                            <span class="visually-hidden"><?php echo app('translator')->get('pagination.previous'); ?></span>
                        </span>
                    </li>
                <?php else: ?>
                    <li class="page-item">
                        <a class="page-link" href="<?php echo e($paginator->previousPageUrl()); ?>" rel="prev" aria-label="<?php echo app('translator')->get('pagination.previous'); ?>">
                            <span class="icon-nav icon-nav-prev" aria-hidden="true"></span>
                            <span class="visually-hidden"><?php echo app('translator')->get('pagination.previous'); ?></span>
                        </a>
                    </li>
                <?php endif; ?>

                <?php if($paginator->hasMorePages()): ?>
                    <li class="page-item">
                        <a class="page-link" href="<?php echo e($paginator->nextPageUrl()); ?>" rel="next" aria-label="<?php echo app('translator')->get('pagination.next'); ?>">
                            <span class="icon-nav icon-nav-next" aria-hidden="true"></span>
                            <span class="visually-hidden"><?php echo app('translator')->get('pagination.next'); ?></span>
                        </a>
                    </li>
                <?php else: ?>
                    <li class="page-item disabled" aria-disabled="true">
                        <span class="page-link">
                            <span class="icon-nav icon-nav-next" aria-hidden="true"></span>
                            <span class="visually-hidden"><?php echo app('translator')->get('pagination.next'); ?></span>
                        </span>
                    </li>
                <?php endif; ?>
            </ul>
        </div>

        
        <div class="d-none flex-sm-fill d-sm-flex align-items-sm-center justify-content-sm-between">
            
            <div>
                <p class="pagination-info mb-0">
                    <?php echo __('Showing'); ?>

                    <span class="pagination-info-value"><?php echo e($paginator->firstItem()); ?></span>
                    <?php echo __('to'); ?>

                    <span class="pagination-info-value"><?php echo e($paginator->lastItem()); ?></span>
                    <?php echo __('of'); ?>

                    <span class="pagination-info-value"><?php echo e($paginator->total()); ?></span>
                    <?php echo __('results'); ?>

                </p>
            </div>

            
            <div>
                <ul class="pagination pagination-sena">
                    
                    <?php if($paginator->onFirstPage()): ?>
                        <li class="page-item disabled" aria-disabled="true" aria-label="<?php echo app('translator')->get('pagination.previous'); ?>">
                            <span class="page-link">
                                <span class="icon-nav icon-nav-prev" aria-hidden="true"></span>
                            </span>
                        </li>
                    <?php else: ?>
                        <li class="page-item">
                            <a class="page-link"
                               href="<?php echo e($paginator->previousPageUrl()); ?>"
                               rel="prev"
                               aria-label="<?php echo app('translator')->get('pagination.previous'); ?>">
                                <span class="icon-nav icon-nav-prev" aria-hidden="true"></span>
                            </a>
                        </li>
                    <?php endif; ?>

                    
                    <?php $__currentLoopData = $elements; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $element): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php if(is_string($element)): ?>
                            <li class="page-item page-item-separator disabled" aria-disabled="true">
                                <span class="page-link"><?php echo e($element); ?></span>
                            </li>
                        <?php endif; ?>

                        <?php if(is_array($element)): ?>
                            <?php $__currentLoopData = $element; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $page => $url): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php if($page == $paginator->currentPage()): ?>
                                    <li class="page-item active" aria-current="page" aria-label="Página <?php echo e($page); ?>">
                                        <span class="page-link"><?php echo e($page); ?></span>
                                    </li>
                                <?php else: ?>
                                    <li class="page-item">
                                        <a class="page-link"
                                           href="<?php echo e($url); ?>"
                                           aria-label="Ir a página <?php echo e($page); ?>">
                                            <?php echo e($page); ?>

                                        </a>
                                    </li>
                                <?php endif; ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php endif; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                    
                    <?php if($paginator->hasMorePages()): ?>
                        <li class="page-item">
                            <a class="page-link"
                               href="<?php echo e($paginator->nextPageUrl()); ?>"
                               rel="next"
                               aria-label="<?php echo app('translator')->get('pagination.next'); ?>">
                                <span class="icon-nav icon-nav-next" aria-hidden="true"></span>
                            </a>
                        </li>
                    <?php else: ?>
                        <li class="page-item disabled" aria-disabled="true" aria-label="<?php echo app('translator')->get('pagination.next'); ?>">
                            <span class="page-link">
                                <span class="icon-nav icon-nav-next" aria-hidden="true"></span>
                            </span>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>
<?php endif; ?>
<?php /**PATH C:\Users\Saave\Documents\project\SOES\SoeSoftware2\resources\views/vendor/pagination/bootstrap-5.blade.php ENDPATH**/ ?>