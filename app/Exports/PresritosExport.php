<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Color;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

/**
 * Export class para reportes de preinscritos
 * Genera Excel con formato institucional SENA
 */
class PresritosExport implements FromView, WithStyles, ShouldAutoSize
{
    /**
     * Datos del reporte
     */
    protected $headerReporte;
    protected $datosReporte;
    protected $totalRegistros;

    /**
     * Constructor
     */
    public function __construct($headerReporte, $datosReporte, $totalRegistros)
    {
        $this->headerReporte = $headerReporte;
        $this->datosReporte = $datosReporte;
        $this->totalRegistros = $totalRegistros;
    }

    /**
     * Retornar vista del reporte
     */
    public function view(): View
    {
        return view('exports.preinscritos', [
            'header' => $this->headerReporte,
            'datos' => $this->datosReporte,
            'totalRegistros' => $this->totalRegistros,
        ]);
    }

    /**
     * Aplicar estilos al reporte
     */
    public function styles(Worksheet $sheet): array
    {
        // Colores institucionales SENA
        $colorSena = 'FF00B050'; // Verde SENA
        $colorFondo = 'FFF2F2F2'; // Gris claro

        return [
            // Row 1: Título
            1 => [
                'font' => ['bold' => true, 'size' => 14, 'color' => ['rgb' => 'FFFFFF']],
                'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER],
                'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => $colorSena]],
            ],
            // Rows 3-5: Headers de información
            '3:5' => [
                'alignment' => ['horizontal' => Alignment::HORIZONTAL_LEFT, 'vertical' => Alignment::VERTICAL_CENTER],
                'font' => ['bold' => true, 'size' => 10],
            ],
            // Row 7: Headers de tabla
            7 => [
                'font' => ['bold' => true, 'size' => 11, 'color' => ['rgb' => 'FFFFFF']],
                'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER],
                'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => $colorSena]],
                'borders' => [
                    'allBorders' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['rgb' => '000000']],
                ],
            ],
        ];
    }
}
