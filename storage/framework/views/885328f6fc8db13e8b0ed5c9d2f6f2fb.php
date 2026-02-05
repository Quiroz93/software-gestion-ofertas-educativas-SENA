<?php $__env->startSection('title', 'Reportes - Preinscritos'); ?>

<?php $__env->startSection('content_header'); ?>
<div class="d-flex justify-content-between align-items-center">
    <h1 class="m-0">
        <i class="fas fa-chart-bar text-primary"></i>
        Reportes de Preinscritos
    </h1>
    <a href="<?php echo e(route('preinscritos.index')); ?>" class="btn btn-outline-secondary">
        <i class="fas fa-arrow-left"></i>
        Volver
    </a>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <!-- Estadísticas -->
    <div class="row mb-4">
        <div class="col-lg-3 col-md-6 mb-2">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <h6 class="card-title">Total de Preinscritos</h6>
                    <h2 class="mb-0"><?php echo e($estadisticas['total']); ?></h2>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 mb-2">
            <div class="card bg-success text-white">
                <div class="card-body">
                    <h6 class="card-title">Inscritos</h6>
                    <h2 class="mb-0"><?php echo e($estadisticas['inscrito']); ?></h2>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 mb-2">
            <div class="card bg-warning text-white">
                <div class="card-body">
                    <h6 class="card-title">Por Inscribir</h6>
                    <h2 class="mb-0"><?php echo e($estadisticas['por_inscribir']); ?></h2>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 mb-2">
            <div class="card bg-danger text-white">
                <div class="card-body">
                    <h6 class="card-title">Con Novedad</h6>
                    <h2 class="mb-0"><?php echo e($estadisticas['con_novedad']); ?></h2>
                </div>
            </div>
        </div>
    </div>

    <!-- Filtros -->
    <div class="card card-outline card-primary mb-4">
        <div class="card-header">
            <h3 class="card-title">
                <i class="fas fa-filter"></i>
                Filtros de Reporte
            </h3>
        </div>
        <div class="card-body">
            <form id="form-filtros" method="GET" action="<?php echo e(route('preinscritos.reportes')); ?>" class="row g-3">
                <div class="col-md-4">
                    <label for="programa_id" class="form-label">Programa</label>
                    <select class="form-select form-select-sm" id="programa_id" name="programa_id">
                        <option value="">-- Todos los programas --</option>
                        <?php $__currentLoopData = $programas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $programa): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($programa->id); ?>" <?php echo e(request('programa_id') == $programa->id ? 'selected' : ''); ?>>
                                <?php echo e($programa->nombre); ?>

                            </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>

                <div class="col-md-4">
                    <label for="estado" class="form-label">Estado</label>
                    <select class="form-select form-select-sm" id="estado" name="estado">
                        <option value="">-- Todos los estados --</option>
                        <?php $__currentLoopData = $estados; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $valor => $etiqueta): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($valor); ?>" <?php echo e(request('estado') == $valor ? 'selected' : ''); ?>>
                                <?php echo e($etiqueta); ?>

                            </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>

                <div class="col-md-4">
                    <label for="tipo_documento" class="form-label">Tipo de Documento</label>
                    <select class="form-select form-select-sm" id="tipo_documento" name="tipo_documento">
                        <option value="">-- Todos --</option>
                        <?php $__currentLoopData = $tiposDocumento; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $valor => $etiqueta): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($valor); ?>" <?php echo e(request('tipo_documento') == $valor ? 'selected' : ''); ?>>
                                <?php echo e($etiqueta); ?>

                            </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>

                <div class="col-12">
                    <button type="submit" class="btn btn-outline-primary btn-sm">
                        <i class="fas fa-search"></i> Aplicar filtros
                    </button>
                    <button type="button" class="btn btn-primary btn-sm" onclick="generarReporte()">
                        <i class="fas fa-file-alt"></i> Generar reporte
                    </button>
                    <button type="button" class="btn btn-success btn-sm" onclick="generarExcel()">
                        <i class="fas fa-file-excel"></i> Generar Excel
                    </button>
                    <button type="button" class="btn btn-info btn-sm" onclick="exportarSOFIAPlus()" title="Exportar en formato SOFIA Plus del SENA">
                        <i class="fas fa-file-upload"></i> SOFIA Plus
                    </button>
                    <a href="<?php echo e(route('preinscritos.reportes')); ?>" class="btn btn-outline-secondary btn-sm">
                        <i class="fas fa-redo"></i> Limpiar
                    </a>
                    <button type="button" class="btn btn-outline-info btn-sm" onclick="imprimirReporte()">
                        <i class="fas fa-print"></i> Imprimir
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Tabla de Reportes -->
    <?php if($preinscritos->count() > 0): ?>
        <div class="card card-outline card-primary">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-list"></i>
                    Datos del Reporte (<?php echo e($preinscritos->count()); ?> registros)
                </h3>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-hover table-sm" id="tablaReporte">
                        <thead class="table-primary">
                            <tr>
                                <th>Nombre Completo</th>
                                <th>Documento</th>
                                <th>Celular</th>
                                <th>Correo</th>
                                <th>Programa</th>
                                <th>Ficha</th>
                                <th>Estado</th>
                                <th>Registrado</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $preinscritos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $presrito): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><?php echo e($presrito->nombre_completo); ?></td>
                                    <td>
                                        <small>
                                            <?php echo e(strtoupper($presrito->tipo_documento)); ?>-<?php echo e($presrito->numero_documento); ?>

                                        </small>
                                    </td>
                                    <td>
                                        <small><?php echo e($presrito->celular_principal); ?></small>
                                    </td>
                                    <td>
                                        <small><?php echo e($presrito->correo_principal); ?></small>
                                    </td>
                                    <td>
                                        <small><?php echo e($presrito->programa->nombre ?? 'Sin asignar'); ?></small>
                                    </td>
                                    <td>
                                        <small><?php echo e($presrito->programa->numero_ficha ?? 'N/A'); ?></small>
                                    </td>
                                    <td>
                                        <small>
                                            <span class="badge bg-<?php echo e($presrito->estado === 'inscrito' ? 'success' : ($presrito->estado === 'por_inscribir' ? 'warning' : 'danger')); ?>">
                                                <?php echo e($presrito->etiqueta_estado); ?>

                                            </span>
                                        </small>
                                    </td>
                                    <td>
                                        <small><?php echo e($presrito->created_at->format('d/m/Y')); ?></small>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer">
                <small class="text-muted">
                    Reporte generado el <?php echo e(now()->format('d/m/Y H:i:s')); ?>

                </small>
            </div>
        </div>

        <!-- Resumen por Programa -->
        <div class="row mt-4">
            <?php
                $porPrograma = $preinscritos->groupBy('programa_id');
            ?>

            <?php $__currentLoopData = $porPrograma; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $programaId => $grupo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php
                    $programa = $grupo->first()->programa;
                    $porEstado = $grupo->groupBy('estado');
                ?>
                <div class="col-md-6 mb-4">
                    <div class="card card-outline card-info">
                        <div class="card-header">
                            <h5 class="card-title mb-0">
                                <?php echo e($programa->nombre ?? 'Sin asignar'); ?>

                            </h5>
                        </div>
                        <div class="card-body">
                            <ul class="list-unstyled">
                                <li class="mb-2">
                                    <strong>Total:</strong>
                                    <span class="badge bg-primary"><?php echo e($grupo->count()); ?></span>
                                </li>
                                <?php $__currentLoopData = $estados; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $valor => $etiqueta): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php
                                        $cantidad = $porEstado->get($valor, collect())->count();
                                    ?>
                                    <li class="mb-2">
                                        <strong><?php echo e($etiqueta); ?>:</strong>
                                        <span class="badge bg-<?php echo e($valor === 'inscrito' ? 'success' : ($valor === 'por_inscribir' ? 'warning' : 'danger')); ?>">
                                            <?php echo e($cantidad); ?>

                                        </span>
                                    </li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </ul>
                        </div>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    <?php else: ?>
        <div class="alert alert-info">
            <i class="fas fa-info-circle"></i>
            No hay datos para mostrar con los filtros aplicados.
        </div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>
<script>
    /**
     * Función para generar reporte (solo registrar en BD)
     */
    function generarReporte() {
        const form = document.getElementById('form-filtros');
        const formData = new FormData(form);
        
        // Crear formulario temporal y enviarlo
        const tempForm = document.createElement('form');
        tempForm.method = 'POST';
        tempForm.action = "<?php echo e(route('preinscritos.reportar')); ?>";
        
        // Agregar token CSRF
        const csrfInput = document.createElement('input');
        csrfInput.type = 'hidden';
        csrfInput.name = '_token';
        csrfInput.value = '<?php echo e(csrf_token()); ?>';
        tempForm.appendChild(csrfInput);
        
        // Agregar todos los campos del formulario
        for (let [key, value] of formData.entries()) {
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = key;
            input.value = value;
            tempForm.appendChild(input);
        }
        
        document.body.appendChild(tempForm);
        tempForm.submit();
    }

    /**
     * Función para generar Excel
     */
    function generarExcel() {
        const form = document.getElementById('form-filtros');
        const formData = new FormData(form);
        
        Swal.fire({
            title: 'Generando Excel...',
            text: 'Por favor espere',
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });

        // Crear formulario temporal y enviarlo
        const tempForm = document.createElement('form');
        tempForm.method = 'POST';
        tempForm.action = "<?php echo e(route('preinscritos.generar-excel')); ?>";
        
        // Agregar token CSRF
        const csrfInput = document.createElement('input');
        csrfInput.type = 'hidden';
        csrfInput.name = '_token';
        csrfInput.value = '<?php echo e(csrf_token()); ?>';
        tempForm.appendChild(csrfInput);
        
        // Agregar todos los campos del formulario
        for (let [key, value] of formData.entries()) {
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = key;
            input.value = value;
            tempForm.appendChild(input);
        }
        
        document.body.appendChild(tempForm);
        tempForm.submit();
    }

    /**
     * Función para descargar archivo Excel en formato SOFIA Plus
     */
    function exportarSOFIAPlus() {
        const form = document.getElementById('form-filtros');
        const formData = new FormData(form);
        
        // Crear formulario temporal
        const tempForm = document.createElement('form');
        tempForm.method = 'POST';
        tempForm.action = "<?php echo e(route('preinscritos.exportar-sofia-plus')); ?>";
        
        // Agregar token CSRF
        const csrfInput = document.createElement('input');
        csrfInput.type = 'hidden';
        csrfInput.name = '_token';
        csrfInput.value = '<?php echo e(csrf_token()); ?>';
        tempForm.appendChild(csrfInput);
        
        // Agregar todos los campos del formulario
        for (let [key, value] of formData.entries()) {
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = key;
            input.value = value;
            tempForm.appendChild(input);
        }
        
        document.body.appendChild(tempForm);
        tempForm.submit();
        document.body.removeChild(tempForm);
    }

    /**
     * Función para imprimir reporte
     */
    function imprimirReporte() {
        const form = document.getElementById('form-filtros');
        const params = new URLSearchParams(new FormData(form)).toString();
        const url = "<?php echo e(route('reportes.imprimir')); ?>" + (params ? '?' + params : '');
        
        window.open(url, '_blank');
    }

    /**
     * Función auxiliar para descargar archivos
     */
    function downloadWithChooser(url, filename) {
        const a = document.createElement('a');
        a.href = url;
        a.download = filename;
        document.body.appendChild(a);
        a.click();
        document.body.removeChild(a);
    }
</script>

<?php if(session('success')): ?>
<script>
    const downloadUrl = "<?php echo e(session('download_url')); ?>";
    const downloadName = "<?php echo e(session('download_name')); ?>";

    if (downloadUrl) {
        Swal.fire({
            icon: 'success',
            title: 'Reporte generado',
            text: "<?php echo e(session('success')); ?>",
            showCancelButton: true,
            confirmButtonText: 'Descargar',
            cancelButtonText: 'Cerrar'
        }).then((result) => {
            if (result.isConfirmed) {
                downloadWithChooser(downloadUrl, downloadName);
            }
        });
    } else {
        Swal.fire({
            icon: 'success',
            title: 'Reporte generado',
            text: "<?php echo e(session('success')); ?>",
        });
    }
</script>
<?php endif; ?>

<?php if(session('error')): ?>
<script>
    Swal.fire({
        icon: 'error',
        title: 'Error',
        text: "<?php echo e(session('error')); ?>"
    });
</script>
<?php endif; ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\AdminSena\Documents\SoeSoftware2\resources\views/admin/preinscritos/reportes.blade.php ENDPATH**/ ?>