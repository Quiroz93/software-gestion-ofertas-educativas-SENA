<?php $__env->startSection('title', 'Detalle de Consolidación'); ?>

<?php $__env->startSection('content_header'); ?>
<div class="d-flex justify-content-between align-items-center">
    <h1 class="m-0">
        <i class="bi bi-layers text-primary"></i>
        <?php echo e($consolidacion->nombre_consolidacion); ?>

    </h1>
    <div class="d-flex gap-2">
        <a href="<?php echo e(route('preinscritos.consolidaciones.exportar', ['consolidacion' => $consolidacion->id] + request()->only(['codigo_ficha', 'estado']))); ?>" 
           class="btn btn-success">
            <i class="bi bi-file-earmark-excel"></i>
            Exportar a Excel
        </a>
        <a href="<?php echo e(route('preinscritos.consolidaciones.index')); ?>" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left"></i>
            Volver
        </a>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <div class="card mb-4">
        <div class="card-body">
            <div class="row">
                <div class="col-md-4">
                    <div class="text-muted">Usuario</div>
                    <div class="fw-semibold"><?php echo e($consolidacion->createdBy?->name ?? 'N/A'); ?></div>
                </div>
                <div class="col-md-4">
                    <div class="text-muted">Fecha</div>
                    <div class="fw-semibold"><?php echo e($consolidacion->created_at->format('Y-m-d H:i')); ?></div>
                </div>
                <div class="col-md-4">
                    <div class="text-muted">Resumen</div>
                    <div class="fw-semibold">
                        Archivos: <?php echo e($consolidacion->total_archivos); ?> | Registros: <?php echo e($consolidacion->total_registros); ?> | Descartados: <?php echo e($consolidacion->total_descartados); ?>

                    </div>
                </div>
            </div>
            <div class="mt-3 text-muted">
                <?php echo e($consolidacion->descripcion); ?>

            </div>
        </div>
    </div>

    <?php if(session('import_report')): ?>
        <div class="card border-success mb-4">
            <div class="card-header bg-success text-white">
                Resultado de importación
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3">
                        <div class="text-muted">Total archivos</div>
                        <div class="fw-semibold"><?php echo e(session('import_report.total_archivos')); ?></div>
                    </div>
                    <div class="col-md-3">
                        <div class="text-muted">Registros válidos</div>
                        <div class="fw-semibold"><?php echo e(session('import_report.total_registros')); ?></div>
                    </div>
                    <div class="col-md-3">
                        <div class="text-muted">Descartados</div>
                        <div class="fw-semibold"><?php echo e(session('import_report.total_descartados')); ?></div>
                    </div>
                    <div class="col-md-3">
                        <div class="text-muted">Duplicados</div>
                        <div class="fw-semibold"><?php echo e(session('import_report.duplicados')); ?></div>
                    </div>
                </div>

                <?php if(!empty(session('import_report.errores_archivos'))): ?>
                    <hr>
                    <h6>Errores por archivo</h6>
                    <ul class="mb-0">
                        <?php $__currentLoopData = session('import_report.errores_archivos'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li><?php echo e($error); ?></li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                <?php endif; ?>
            </div>
        </div>
    <?php endif; ?>

    <div class="card card-outline card-primary mb-4">
        <div class="card-header">
            <h3 class="card-title"><i class="bi bi-funnel"></i> Filtros de detalle</h3>
        </div>
        <div class="card-body">
            <form method="GET" action="<?php echo e(route('preinscritos.consolidaciones.show', $consolidacion)); ?>" class="row g-3">
                <div class="col-md-5">
                    <label class="form-label">Código de ficha</label>
                    <input type="text" name="codigo_ficha" class="form-control" value="<?php echo e(request('codigo_ficha')); ?>">
                </div>
                <div class="col-md-5">
                    <label class="form-label">Estado</label>
                    <select name="estado" class="form-select">
                        <option value="">-- Todos --</option>
                        <?php $__currentLoopData = $estados; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $estado): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($estado); ?>" <?php echo e(request('estado') == $estado ? 'selected' : ''); ?>><?php echo e($estado); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                <div class="col-md-2 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-search"></i>
                        Filtrar
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-body table-responsive">
            <table class="table table-striped align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Tipo Doc</th>
                        <th>Número</th>
                        <th>Nombre completo</th>
                        <th>Estado</th>
                        <th>Ficha</th>
                        <th>Programa</th>
                        <th>Observaciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $detalles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $detalle): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td><?php echo e($detalle->tipo_documento); ?></td>
                            <td><?php echo e($detalle->numero_documento); ?></td>
                            <td><?php echo e($detalle->nombre_completo); ?></td>
                            <td><?php echo e($detalle->estado ?? 'N/A'); ?></td>
                            <td><?php echo e($detalle->codigo_ficha ?? 'N/A'); ?></td>
                            <td><?php echo e($detalle->nombre_programa ?? 'N/A'); ?></td>
                            <td style="min-width: 260px;">
                                <form action="<?php echo e(route('preinscritos.consolidaciones.detalles.update', $detalle)); ?>" method="POST" class="d-flex gap-2">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('PUT'); ?>
                                    <input type="text" name="observaciones" class="form-control form-control-sm" value="<?php echo e($detalle->observaciones); ?>" placeholder="Observaciones">
                                    <button type="submit" class="btn btn-sm btn-outline-success" title="Guardar">
                                        <i class="bi bi-check-lg"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="7" class="text-center text-muted">No hay registros para mostrar.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        <div class="card-footer">
            <?php echo e($detalles->links()); ?>

        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\AdminSena\Documents\SoeSoftware2\resources\views/admin/preinscritos/consolidaciones/show.blade.php ENDPATH**/ ?>