<?php
    // Calcular dimensiones de celdas combinadas
    $headerRows = 6;
    $dataStartRow = 8;
?>

<table>
    <tr>
        <td colspan="3" rowspan="1" style="text-align: center; font-weight: bold; font-size: 14px; background-color: #00B050; color: white; padding: 10px;">
            <?php echo e($header['titulo']); ?>

        </td>
    </tr>
    <tr>
        <td></td>
        <td></td>
        <td></td>
    </tr>
    <tr>
        <td style="font-weight: bold; font-size: 10px;">Código Ficha:</td>
        <td style="font-size: 10px;"><?php echo e($header['codigo_ficha']); ?></td>
        <td></td>
    </tr>
    <tr>
        <td style="font-weight: bold; font-size: 10px;">Programa de Formación:</td>
        <td style="font-size: 10px;"><?php echo e($header['programa']); ?></td>
        <td></td>
    </tr>
    <tr>
        <td style="font-weight: bold; font-size: 10px;">Total de Registros:</td>
        <td style="font-size: 10px;"><?php echo e($totalRegistros); ?></td>
        <td></td>
    </tr>
    <tr>
        <td style="font-weight: bold; font-size: 9px;">Fecha de Generación:</td>
        <td style="font-size: 9px;"><?php echo e(now()->format('d/m/Y H:i:s')); ?></td>
        <td></td>
    </tr>
    <tr>
        <td style="height: 5px;"></td>
        <td></td>
        <td></td>
    </tr>
    <tr style="background-color: #00B050; color: white; font-weight: bold; text-align: center;">
        <td style="border: 1px solid #000000; padding: 8px;">Identificación</td>
        <td style="border: 1px solid #000000; padding: 8px;">Nombre</td>
        <td style="border: 1px solid #000000; padding: 8px;">Estado</td>
    </tr>

    <?php $__empty_1 = true; $__currentLoopData = $datos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $registro): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <tr style="text-align: center;">
            <td style="border: 1px solid #CCCCCC; padding: 6px;"><?php echo e($registro['Identificación']); ?></td>
            <td style="border: 1px solid #CCCCCC; padding: 6px; text-align: left;"><?php echo e($registro['Nombre']); ?></td>
            <td style="border: 1px solid #CCCCCC; padding: 6px;"><?php echo e($registro['Estado']); ?></td>
        </tr>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <tr>
            <td colspan="3" style="text-align: center; padding: 10px; font-style: italic; color: #666;">
                Sin registros para mostrar
            </td>
        </tr>
    <?php endif; ?>
</table>
<?php /**PATH C:\Users\AdminSena\Documents\SoeSoftware2\resources\views/exports/preinscritos.blade.php ENDPATH**/ ?>