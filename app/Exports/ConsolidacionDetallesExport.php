<?php

namespace App\Exports;

use App\Models\ConsolidacionPreinscrito;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;

class ConsolidacionDetallesExport implements FromQuery, WithHeadings, WithMapping, WithTitle, ShouldAutoSize, WithStyles, WithEvents
{
    protected $consolidacion;
    protected $filtros;
    protected $rowCount = 0;
    protected $registrosFiltrados = 0;

    public function __construct(ConsolidacionPreinscrito $consolidacion, array $filtros = [])
    {
        $this->consolidacion = $consolidacion;
        $this->filtros = $filtros;
        
        // Contar registros después de aplicar filtros
        $query = $this->consolidacion->detalles();
        
        if (!empty($filtros['codigo_ficha'])) {
            $query->where('codigo_ficha', 'like', '%' . $filtros['codigo_ficha'] . '%');
        }
        
        if (!empty($filtros['estado'])) {
            $query->where('estado', $filtros['estado']);
        }
        
        $this->registrosFiltrados = $query->count();
    }

    public function query()
    {
        $query = $this->consolidacion->detalles()->orderBy('id');

        if (!empty($this->filtros['codigo_ficha'])) {
            $query->where('codigo_ficha', 'like', '%' . $this->filtros['codigo_ficha'] . '%');
        }

        if (!empty($this->filtros['estado'])) {
            $query->where('estado', $this->filtros['estado']);
        }

        return $query;
    }

    public function headings(): array
    {
        // Si es consolidación flexible: usar columnas seleccionadas desde observaciones
        if ($this->consolidacion->tipo_consolidacion === 'flexible') {
            return $this->getFlexibleHeadings();
        }
        
        // Headings básicos comunes
        $commonHeadings = [
            'ID',
            'Tipo Documento',
            'Número Documento',
            'Nombre Completo',
            'Estado',
            'Código Ficha',
            'Nombre Programa',
        ];
        
        // Si es consolidación esencial de REGIONAL: sin observaciones, con teléfonos
        if ($this->consolidacion->tipo_consolidacion === 'regional_esencial') {
            return array_merge($commonHeadings, [
                'Teléfono Fijo',
                'Teléfono Móvil',
            ]);
        }
        
        // Si es consolidación completa de REGIONAL: con observaciones y todos los campos
        if ($this->consolidacion->tipo_consolidacion === 'regional_completo') {
            return array_merge($commonHeadings, [
                'Observaciones',
                'NIS',
                'Correo Electrónico',
                'Teléfono Fijo',
                'Teléfono Móvil',
                'Tipo Prueba',
                'Resultado Prueba',
                'Fecha Cargue',
                'Estado Prueba',
                'Motivo Prueba',
                'Fecha Prueba',
                'Acceso Preferente',
                'Dígito',
                'Día Pico y Placa',
            ]);
        }
        
        // Otros tipos de consolidación (preinscritos normales): headings básicos con observaciones
        return array_merge($commonHeadings, [
            'Observaciones',
        ]);
    }
    
    /**
     * Obtiene headings para consolidación flexible basándose en columnas seleccionadas
     */
    private function getFlexibleHeadings(): array
    {
        $metadata = $this->consolidacion->observaciones;
        if (!is_array($metadata)) {
            $metadata = json_decode((string)$metadata, true) ?? [];
        }
        $columnasSeleccionadas = $metadata['columnas_seleccionadas'] ?? [];
        
        if (empty($columnasSeleccionadas)) {
            // Fallback a headings básicos
            return ['ID', 'Tipo Documento', 'Número Documento', 'Nombre Completo', 'Estado', 'Código Ficha', 'Nombre Programa'];
        }
        
        $headings = ['ID'];
        
        $labelMap = [
            'tipo_documento' => 'Tipo Documento',
            'numero_documento' => 'Número Documento',
            'nombre_completo' => 'Nombre Completo',
            'nombres' => 'Nombres',
            'apellidos' => 'Apellidos',
            'estado' => 'Estado',
            'codigo_ficha' => 'Código Ficha',
            'nombre_programa' => 'Nombre Programa',
            'correo_electronico' => 'Correo Electrónico',
            'telefono_fijo' => 'Teléfono Fijo',
            'telefono_movil' => 'Teléfono Móvil',
            'nis' => 'NIS',
            'tipo_prueba' => 'Tipo Prueba',
            'resultado_prueba' => 'Resultado Prueba',
            'fecha_cargue' => 'Fecha Cargue',
            'estado_prueba' => 'Estado Prueba',
            'motivo_prueba' => 'Motivo Prueba',
            'fecha_prueba' => 'Fecha Prueba',
            'acceso_preferente' => 'Acceso Preferente',
            'digito' => 'Dígito',
            'dia_pico_placa' => 'Día Pico y Placa',
        ];
        
        foreach ($columnasSeleccionadas as $col) {
            $headings[] = $labelMap[$col] ?? ucwords(str_replace('_', ' ', $col));
        }
        
        return $headings;
    }

    public function map($detalle): array
    {
        $this->rowCount++;
        
        // Si es consolidación flexible: mapear solo columnas seleccionadas
        if ($this->consolidacion->tipo_consolidacion === 'flexible') {
            return $this->mapFlexible($detalle);
        }
        
        // Datos básicos comunes
        $row = [
            $detalle->id,
            $detalle->tipo_documento,
            $detalle->numero_documento,
            $detalle->nombre_completo,
            $detalle->estado ?? 'N/A',
            $detalle->codigo_ficha ?? 'N/A',
            $detalle->nombre_programa ?? 'N/A',
        ];
        
        // Si es consolidación esencial: sin observaciones, agregar teléfonos
        if ($this->consolidacion->tipo_consolidacion === 'regional_esencial') {
            $row = array_merge($row, [
                $detalle->telefono_fijo ?? '',
                $detalle->telefono_movil ?? '',
            ]);
            return $row;
        }
        
        // Si es consolidación completa: observaciones + todos los campos REGIONAL
        if ($this->consolidacion->tipo_consolidacion === 'regional_completo') {
            $row = array_merge($row, [
                $detalle->observaciones ?? '',
                $detalle->nis ?? '',
                $detalle->correo_electronico ?? '',
                $detalle->telefono_fijo ?? '',
                $detalle->telefono_movil ?? '',
                $detalle->tipo_prueba ?? '',
                $detalle->resultado_prueba ?? '',
                $detalle->fecha_cargue ?? '',
                $detalle->estado_prueba ?? '',
                $detalle->motivo_prueba ?? '',
                $detalle->fecha_prueba ?? '',
                $detalle->acceso_preferente ?? '',
                $detalle->digito ?? '',
                $detalle->dia_pico_placa ?? '',
            ]);
            return $row;
        }
        
        // Otros tipos: datos básicos con observaciones
        $row = array_merge($row, [
            $detalle->observaciones ?? '',
        ]);
        
        return $row;
    }
    
    /**
     * Mapea detalle para consolidación flexible (columnas dinámicas)
     */
    private function mapFlexible($detalle): array
    {
        $metadata = $this->consolidacion->observaciones;
        if (!is_array($metadata)) {
            $metadata = json_decode((string)$metadata, true) ?? [];
        }
        $columnasSeleccionadas = $metadata['columnas_seleccionadas'] ?? [];
        
        $row = [$detalle->id];
        
        foreach ($columnasSeleccionadas as $col) {
            $value = $detalle->{$col} ?? '';
            
            // Formateo especial para algunos campos
            if (in_array($col, ['fecha_cargue', 'fecha_prueba']) && $value) {
                $value = \Carbon\Carbon::parse($value)->format('Y-m-d H:i:s');
            }
            
            $row[] = $value;
        }
        
        return $row;
    }

    public function title(): string
    {
        return substr($this->consolidacion->nombre_consolidacion, 0, 31);
    }

    public function styles(Worksheet $sheet)
    {
        return [];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();
                
                // Insertar 7 filas al inicio para el logo y encabezado institucional
                $sheet->insertNewRowBefore(1, 7);
                
                // LOGO DEL SENA
                $logoPngPath = public_path('images/Logosimbolo-SENA.png');
                
                if (file_exists($logoPngPath)) {
                    // Insertar imagen PNG del logo
                    $drawing = new Drawing();
                    $drawing->setName('Logo SENA');
                    $drawing->setDescription('Logo SENA');
                    $drawing->setPath($logoPngPath);
                    $drawing->setHeight(75);
                    $drawing->setWidth(75);
                    $drawing->setCoordinates('B1');
                    $drawing->setOffsetX(2000); // Offset negativo para desplazar a la izquierda
                    $drawing->setOffsetY(25); // Sin offset vertical para alineación en D1
                    $drawing->setWorksheet($sheet);
                    
                    $sheet->getRowDimension(1)->setRowHeight(70);
                    $sheet->getRowDimension(2)->setRowHeight(10);
                } else {
                    // Fallback: mostrar texto "SENA" estilizado
                    $sheet->mergeCells('A1:A2');
                    $sheet->setCellValue('A1', 'SENA');
                    $sheet->getStyle('A1')->applyFromArray([
                        'font' => ['bold' => true, 'size' => 20, 'color' => ['rgb' => '39A900']],
                        'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER],
                        'fill' => [
                            'fillType' => Fill::FILL_SOLID,
                            'startColor' => ['rgb' => 'F0F0F0']
                        ]
                    ]);
                    $sheet->getRowDimension(1)->setRowHeight(30);
                    $sheet->getRowDimension(2)->setRowHeight(30);
                }
                
                $sheet->getColumnDimension('A')->setWidth(15);
                
                // Título institucional
                $sheet->mergeCells('B1:I2');
                $sheet->setCellValue('B1', config('app.name', 'SENA') . "\nCONSOLIDACIÓN DE INSCRIPCIONES \nCENTRO AGROEMPRESARIAL Y TURÍSTICO DE LOS ANDES");
                $sheet->getStyle('B1')->applyFromArray([
                    'font' => ['bold' => true, 'size' => 16, 'color' => ['rgb' => '39A900']],
                    'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER, 'wrapText' => true]
                ]);
                
                // Nombre de la consolidación
                $sheet->mergeCells('A3:I3');
                $sheet->setCellValue('A3', $this->consolidacion->nombre_consolidacion);
                $sheet->getStyle('A3')->applyFromArray([
                    'font' => ['bold' => true, 'size' => 12],
                    'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER]
                ]);
                
                // Metadatos
                $sheet->mergeCells('A4:B4');
                $sheet->mergeCells('C4:D4');
                $sheet->mergeCells('A5:B5');
                $sheet->mergeCells('C5:D5');
                $sheet->mergeCells('F4:G4');
                $sheet->mergeCells('F5:G5');
                
                $sheet->mergeCells('A6:I6');
                
                // Usuario que genera
                $usuario = Auth::user();
                $nombreUsuario = $usuario ? $usuario->name : 'Sistema';
                
                $sheet->setCellValue('E4', 'Fecha:');
                $sheet->setCellValue('F4', \Carbon\Carbon::now('America/Bogota')->format('d/m/Y H:i'));
                $sheet->setCellValue('E5', 'Usuario:');
                $sheet->setCellValue('F5', $nombreUsuario);
                
                $sheet->setCellValue('A6', 'Total registros en reporte: ' . $this->registrosFiltrados . (count($this->filtros) > 0 && (isset($this->filtros['codigo_ficha']) || isset($this->filtros['estado'])) ? ' (filtrados)' : '') . ' de ' . $this->consolidacion->total_registros . ' en la consolidación');
                
                // Estilos para las celdas de información
                $sheet->getStyle('A4:D4')->applyFromArray([
                    'font' => ['size' => 11],
                    'alignment' => ['horizontal' => Alignment::HORIZONTAL_LEFT, 'vertical' => Alignment::VERTICAL_CENTER]
                ]);
                
                $sheet->getStyle('E4')->applyFromArray([
                    'font' => ['bold' => true]
                ]);
                
                $sheet->getStyle('A5:D5')->applyFromArray([
                    'font' => ['size' => 11],
                    'alignment' => ['horizontal' => Alignment::HORIZONTAL_LEFT, 'vertical' => Alignment::VERTICAL_CENTER]
                ]);
                
                $sheet->getStyle('E5')->applyFromArray([
                    'font' => ['bold' => true]
                ]);
                
                $sheet->getStyle('A6')->applyFromArray([
                    'font' => ['bold' => true, 'size' => 11],
                    'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER]
                ]);
                
                // Si hay filtros aplicados, mostrarlos
                $filtrosTexto = [];
                if (!empty($this->filtros['codigo_ficha'])) {
                    $filtrosTexto[] = 'Ficha: ' . $this->filtros['codigo_ficha'];
                }
                if (!empty($this->filtros['estado'])) {
                    $filtrosTexto[] = 'Estado: ' . $this->filtros['estado'];
                }
                
                if (!empty($filtrosTexto)) {
                    $sheet->mergeCells('A7:I7');
                    $sheet->setCellValue('A7', 'Filtros aplicados: ' . implode(', ', $filtrosTexto));
                    $sheet->getStyle('A7')->applyFromArray([
                        'font' => ['italic' => true, 'color' => ['rgb' => '666666']],
                        'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER]
                    ]);
                }
                
                // Línea en blanco (fila 8 estará vacía)
                
                // ENCABEZADOS DE COLUMNA (ahora en fila 9)
                $sheet->getStyle('A8:I8')->applyFromArray([
                    'font' => ['bold' => true, 'color' => ['rgb' => '00304D']], // Azul oscuro SENA
                    'fill' => [
                        'fillType' => Fill::FILL_SOLID,
                        'startColor' => ['rgb' => '39A900'] // Verde SENA
                    ],
                    'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER]
                ]);
                
                // Bordes para la tabla de datos (desde fila 9 hasta la última)
                $lastRow = 9 + $this->rowCount;
                $sheet->getStyle('A9:I' . $lastRow)->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => Border::BORDER_THIN,
                            'color' => ['rgb' => 'CCCCCC']
                        ]
                    ]
                ]);
                
                // Alternar colores de filas de datos (desde fila 10)
                for ($i = 10; $i <= $lastRow; $i++) {
                    if ($i % 2 == 0) {
                        $sheet->getStyle('A' . $i . ':I' . $i)->applyFromArray([
                            'fill' => [
                                'fillType' => Fill::FILL_SOLID,
                                'startColor' => ['rgb' => 'F8F9FA']
                            ]
                        ]);
                    }
                }
            },
        ];
    }
}
