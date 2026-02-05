<?php

namespace App\Exports;

use App\Models\ConsolidacionPreinscrito;
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
        return [
            'ID',
            'Tipo Documento',
            'Número Documento',
            'Nombre Completo',
            'Estado',
            'Código Ficha',
            'Nombre Programa',
            'Observaciones',
            'Fecha del Reporte',
        ];
    }

    public function map($detalle): array
    {
        $this->rowCount++;
        
        return [
            $detalle->id,
            $detalle->tipo_documento,
            $detalle->numero_documento,
            $detalle->nombre_completo,
            $detalle->estado ?? 'N/A',
            $detalle->codigo_ficha ?? 'N/A',
            $detalle->nombre_programa ?? 'N/A',
            $detalle->observaciones ?? '',
            $detalle->created_at ? $detalle->created_at->format('Y-m-d H:i:s') : '',
        ];
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
                $usuario = auth()->user();
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
