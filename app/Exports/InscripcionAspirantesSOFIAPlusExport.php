<?php

namespace App\Exports;

use App\Models\Preinscrito;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

/**
 * Export class para generar archivo de inscripción de aspirantes en formato SOFIA Plus
 * 
 * Genera un Excel compatible con el formato estándar de SOFIA Plus del SENA
 * para la inscripción de aspirantes a programas de formación.
 * 
 * Columnas del formato:
 * - Tipo Documento (cc, ce, pa, ppt, ti, etc.)
 * - Número Documento
 * - Apellidos
 * - Nombres
 * - Email
 * - Teléfono
 * - Celular
 * - Código Ficha
 * - Nombre del Programa
 */
class InscripcionAspirantesSOFIAPlusExport implements FromCollection, WithHeadings, WithColumnWidths, WithCustomStartCell, WithEvents
{
    /**
     * Filtros opcionales para limitar los registros
     */
    protected $estado = null;
    protected $programa_id = null;
    protected $fecha_desde = null;
    protected $fecha_hasta = null;

    /**
     * Constructor
     */
    public function __construct($estado = null, $programa_id = null, $fecha_desde = null, $fecha_hasta = null)
    {
        $this->estado = $estado;
        $this->programa_id = $programa_id;
        $this->fecha_desde = $fecha_desde;
        $this->fecha_hasta = $fecha_hasta;
    }

    /**
     * Obtener la colección de datos
     */
    public function collection()
    {
        $query = Preinscrito::with('programa')
            ->where('deleted_at', null);

        // Aplicar filtros
        if ($this->estado) {
            $query->where('estado', $this->estado);
        }

        if ($this->programa_id) {
            $query->where('programa_id', $this->programa_id);
        }

        if ($this->fecha_desde) {
            $query->whereDate('created_at', '>=', $this->fecha_desde);
        }

        if ($this->fecha_hasta) {
            $query->whereDate('created_at', '<=', $this->fecha_hasta);
        }

        $preinscritos = $query->orderBy('apellidos')
            ->orderBy('nombres')
            ->get();

        // Mapear los datos al formato SOFIA Plus (plantilla de referencia)
        return $preinscritos->map(function ($preinscrito) {
            return [
                'resultado_registro' => '',
                'tipo_documento' => $this->mapearTipoDocumento($preinscrito->tipo_documento),
                'numero_documento' => $preinscrito->numero_documento,
                'codigo_ficha' => $preinscrito->programa ? $preinscrito->programa->numero_ficha : '',
                'tipo_poblacion' => '',
                'tipo_organizacion' => '',
                'codigo_empresa' => '',
                'columna_reservada' => '',
            ];
        });
    }

    /**
     * Mapear los valores internos al formato SOFIA Plus
     * 
     * @param string $tipo Tipo de documento en formato interno
     * @return string Tipo de documento en formato SOFIA Plus
     */
    protected function mapearTipoDocumento($tipo)
    {
        $mapeo = [
            'cc' => 'CC',          // Cédula de Ciudadanía
            'ce' => 'CE',          // Cédula de Extranjería
            'pa' => 'PA',          // Permiso de Asilo
            'ppt' => 'PPT',        // Permiso por Protección Temporal
            'pep' => 'PEP',        // Permiso Especial de Permanencia
            'pas' => 'PAS',        // Pasaporte
            'ti' => 'TI',          // Tarjeta de Identidad
            'nit' => 'NIT',        // NIT
        ];

        return $mapeo[$tipo] ?? strtoupper($tipo);
    }

    /**
     * Encabezados del reporte
     */
    public function headings(): array
    {
        return [
            "Resultado del Registro\n(Reservado para el sistema)",
            'Tipo de Identificación',
            'Numero de Identificación',
            'Código de la ficha',
            'Tipo Población Aspirante',
            '',
            "Codigo Empresa\n(Solo si la ficha es cerrada)",
            '',
        ];
    }

    /**
     * Ancho de columnas
     */
    public function columnWidths(): array
    {
        return [
            'A' => 28,
            'B' => 20,
            'C' => 22,
            'D' => 18,
            'E' => 32,
            'F' => 22,
            'G' => 22,
            'H' => 14,
            'I' => 60,
        ];
    }

    /**
     * Definir la celda de inicio para los encabezados
     */
    public function startCell(): string
    {
        return 'A2';
    }

    /**
     * Aplicar estructura y estilos similares al formato de referencia
     */
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();

                $titulo = 'FORMATO PARA LA INSCRIPCIÓN DE ASPIRANTES EN SOFIA PLUS v1.0';
                $sheet->mergeCells('A1:H1');
                $sheet->setCellValue('A1', $titulo);

                $sheet->mergeCells('E2:F2');

                $tipoPoblacion = $this->obtenerListaTipoPoblacion();
                if ($tipoPoblacion['nota'] !== '') {
                    $sheet->setCellValue('I1', $tipoPoblacion['nota']);
                }

                $row = 2;
                foreach ($tipoPoblacion['items'] as $item) {
                    $sheet->setCellValue('I' . $row, $item);
                    $row++;
                }

                $ultimoFilaLista = max(2, $row - 1);

                $sheet->getRowDimension(1)->setRowHeight(24);
                $sheet->getRowDimension(2)->setRowHeight(36);

                $sheet->getStyle('A1:H1')->applyFromArray([
                    'font' => [
                        'bold' => true,
                        'size' => 11,
                    ],
                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_CENTER,
                        'vertical' => Alignment::VERTICAL_CENTER,
                    ],
                    'fill' => [
                        'fillType' => Fill::FILL_SOLID,
                        'startColor' => ['rgb' => 'C6E0B4'],
                    ],
                ]);

                $sheet->getStyle('A2:H2')->applyFromArray([
                    'font' => [
                        'bold' => true,
                        'size' => 10,
                    ],
                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_CENTER,
                        'vertical' => Alignment::VERTICAL_CENTER,
                        'wrapText' => true,
                    ],
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => Border::BORDER_THIN,
                            'color' => ['rgb' => '000000'],
                        ],
                    ],
                ]);

                $sheet->getStyle('I1')->applyFromArray([
                    'font' => [
                        'bold' => true,
                        'size' => 9,
                        'color' => ['rgb' => 'C00000'],
                    ],
                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_LEFT,
                        'vertical' => Alignment::VERTICAL_TOP,
                        'wrapText' => true,
                    ],
                ]);

                $sheet->getStyle('I2:I' . $ultimoFilaLista)->applyFromArray([
                    'font' => [
                        'size' => 9,
                    ],
                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_LEFT,
                        'vertical' => Alignment::VERTICAL_CENTER,
                        'wrapText' => true,
                    ],
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => Border::BORDER_THIN,
                            'color' => ['rgb' => '000000'],
                        ],
                    ],
                ]);
            },
        ];
    }

    /**
     * Obtener nota y lista de tipo de poblacion desde elementosdeexcel.md
     */
    private function obtenerListaTipoPoblacion(): array
    {
        $path = base_path('elementosdeexcel.md');
        if (!is_readable($path)) {
            return ['nota' => '', 'items' => []];
        }

        $lines = file($path, FILE_IGNORE_NEW_LINES);
        $lines = array_values(array_filter(array_map('trim', $lines), function ($line) {
            return $line !== '' && $line !== '```';
        }));

        $nota = array_shift($lines) ?? '';

        return [
            'nota' => $nota,
            'items' => $lines,
        ];
    }
}
