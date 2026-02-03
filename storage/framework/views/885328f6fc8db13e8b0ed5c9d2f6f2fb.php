

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
                    <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalGenerarReporte">
                        <i class="fas fa-file-alt"></i> Generar reporte
                    </button>
                    <button type="button" class="btn btn-success btn-sm" onclick="generarExcel()">
                        <i class="fas fa-file-excel"></i> Generar Excel
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

    <!-- Modal Generar Reporte -->
    <div class="modal fade" id="modalGenerarReporte" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Generar reporte</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <div class="modal-body">
                    Selecciona cómo deseas guardar el reporte.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-outline-primary" onclick="guardarSoloBD()">
                        Guardar solo en BD
                    </button>
                    <button type="button" class="btn btn-success" onclick="guardarYGenerarExcel()">
                        Guardar y generar Excel
                    </button>
                </div>
            </div>
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
function submitReporte(actionUrl) {
    const form = document.getElementById('form-filtros');
    if (!form) {
        return;
    }

    const formData = new FormData(form);
    const postForm = document.createElement('form');
    postForm.method = 'POST';
    postForm.action = actionUrl;

    const csrf = document.createElement('input');
    csrf.type = 'hidden';
    csrf.name = '_token';
    csrf.value = <?php echo json_encode(csrf_token(), 15, 512) ?>;
    postForm.appendChild(csrf);

    for (const [key, value] of formData.entries()) {
        if (value !== null && value !== '') {
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = key;
            input.value = value;
            postForm.appendChild(input);
        }
    }

    document.body.appendChild(postForm);
    postForm.submit();
}

function generarExcel() {
    submitReporte('<?php echo e(route('preinscritos.exportar')); ?>');
}

function guardarSoloBD() {
    const modal = bootstrap.Modal.getInstance(document.getElementById('modalGenerarReporte'));
    if (modal) {
        modal.hide();
    }
    submitReporte('<?php echo e(route('preinscritos.reportar')); ?>');
}

function guardarYGenerarExcel() {
    const modal = bootstrap.Modal.getInstance(document.getElementById('modalGenerarReporte'));
    if (modal) {
        modal.hide();
    }
    submitReporte('<?php echo e(route('preinscritos.exportar')); ?>');
}

async function downloadWithChooser(url, filename) {
    if (!url) {
        return;
    }

    if (window.showSaveFilePicker) {
        try {
            const response = await fetch(url, { credentials: 'same-origin' });
            if (!response.ok) {
                throw new Error('No se pudo descargar el archivo.');
            }
            const blob = await response.blob();
            const handle = await window.showSaveFilePicker({
                suggestedName: filename || 'reporte_preinscritos.xlsx',
                types: [
                    {
                        description: 'Archivo Excel',
                        accept: {
                            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet': ['.xlsx']
                        }
                    }
                ]
            });
            const writable = await handle.createWritable();
            await writable.write(blob);
            await writable.close();

            Swal.fire({
                icon: 'success',
                title: 'Archivo guardado',
                text: 'El reporte se guardó correctamente.'
            });
            return;
        } catch (error) {
            if (error && error.name === 'AbortError') {
                Swal.fire({
                    icon: 'info',
                    title: 'Descarga cancelada',
                    text: 'No se guardó el archivo.'
                });
                return;
            }

            Swal.fire({
                icon: 'warning',
                title: 'Descarga directa',
                text: 'No fue posible abrir el selector. Se iniciará la descarga.'
            });
        }
    }

    window.location.href = url;
}

function imprimirReporte() {
    const tabla = document.getElementById('tablaReporte');
    if (!tabla || tabla.rows.length === 0) {
        Swal.fire({
            icon: 'warning',
            title: 'Sin datos',
            text: 'No hay datos para imprimir.'
        });
        return;
    }

    const ventana = window.open('', '_blank');
    const html = `
        <html>
            <head>
                <title>Reporte de Preinscritos - SENA</title>
                <style>
                    body { font-family: Arial, sans-serif; margin: 20px; }
                    h2 { text-align: center; color: #333; }
                    table { width: 100%; border-collapse: collapse; margin-top: 20px; }
                    th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
                    th { background-color: #f2f2f2; font-weight: bold; }
                    tr:nth-child(even) { background-color: #f9f9f9; }
                    .fecha { text-align: center; margin-top: 20px; color: #666; font-size: 12px; }
                </style>
            </head>
            <body>
                <h2>Reporte de Preinscritos - SENA</h2>
                ${tabla.outerHTML}
                <div class="fecha">
                    Reporte generado el ${new Date().toLocaleString('es-CO')}
                </div>
            </body>
        </html>
    `;
    ventana.document.write(html);
    ventana.document.close();
    ventana.print();
}
</script>

<?php if(session('success')): ?>
<script>
    const downloadUrl = <?php echo json_encode(session('download_url'), 15, 512) ?>;
    const downloadName = <?php echo json_encode(session('download_name'), 15, 512) ?>;

    if (downloadUrl) {
        Swal.fire({
            icon: 'success',
            title: 'Reporte generado',
            text: <?php echo json_encode(session('success'), 15, 512) ?>,
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
            text: <?php echo json_encode(session('success'), 15, 512) ?>
        });
    }
</script>
<?php endif; ?>

<?php if(session('error')): ?>
<script>
    Swal.fire({
        icon: 'error',
        title: 'Error',
        text: <?php echo json_encode(session('error'), 15, 512) ?>
    });
</script>
<?php endif; ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\AdminSena\Documents\SoeSoftware2\resources\views/admin/preinscritos/reportes.blade.php ENDPATH**/ ?>