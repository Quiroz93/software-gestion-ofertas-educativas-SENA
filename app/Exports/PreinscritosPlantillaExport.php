<?php

namespace App\Exports;

use App\Models\Programa;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use PhpOffice\PhpSpreadsheet\Cell\DataValidation;

class PreinscritosPlantillaExport implements WithMultipleSheets
{
    public function sheets(): array
    {
        return [
            new PreinscritosPlantillaSheet(),
            new ProgramasListSheet(),
        ];
    }
}

class PreinscritosPlantillaSheet implements WithHeadings, WithTitle, WithEvents, ShouldAutoSize
{
    public function headings(): array
    {
        return [
            'Tipo Documento',
            'Número Documento',
            'Nombres',
            'Apellidos',
            'Correo',
            'Celular',
            'Programa de Formación',
            'Número de Ficha',
            'Estado',
        ];
    }

    public function title(): string
    {
        return 'Plantilla Preinscritos';
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();

                // Insertar 6 filas para encabezado institucional
                $sheet->insertNewRowBefore(1, 6);

                // Logo SENA
                $logoPngPath = public_path('images/Logosimbolo-SENA.png');
                if (file_exists($logoPngPath)) {
                    $drawing = new Drawing();
                    $drawing->setName('Logo SENA');
                    $drawing->setDescription('Logo SENA');
                    $drawing->setPath($logoPngPath);
                    $drawing->setHeight(60);
                    $drawing->setWidth(60);
                    $drawing->setCoordinates('B1');
                    $drawing->setOffsetX(0);
                    $drawing->setOffsetY(0);
                    $drawing->setWorksheet($sheet);
                }

                // Título institucional
                $sheet->mergeCells('C1:J2');
                $sheet->setCellValue('C1', config('app.name', 'SENA') . "\nPLANTILLA CARGA MASIVA PREINSCRITOS");
                $sheet->getStyle('C1')->applyFromArray([
                    'font' => ['bold' => true, 'size' => 14, 'color' => ['rgb' => '00304D']],
                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_CENTER,
                        'vertical' => Alignment::VERTICAL_CENTER,
                        'wrapText' => true,
                    ],
                ]);

                // Subtítulo
                $sheet->mergeCells('A3:J3');
                $sheet->setCellValue('A3', 'Formato oficial para importación de preinscritos');
                $sheet->getStyle('A3')->applyFromArray([
                    'font' => ['bold' => true, 'size' => 11, 'color' => ['rgb' => '00304D']],
                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_CENTER,
                        'vertical' => Alignment::VERTICAL_CENTER,
                    ],
                ]);

                // Nota de uso
                $sheet->mergeCells('A4:J4');
                $sheet->setCellValue('A4', 'Complete una fila por preinscrito. Use listas desplegables en Tipo Documento, Programa y Estado. NO MODIFIQUE la columna "Número de Ficha" (se calcula automáticamente).');
                $sheet->getStyle('A4')->applyFromArray([
                    'font' => ['size' => 10, 'color' => ['rgb' => '666666']],
                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_CENTER,
                        'vertical' => Alignment::VERTICAL_CENTER,
                    ],
                ]);

                // Estilos de encabezados de tabla (fila 7)
                $sheet->getStyle('A7:I7')->applyFromArray([
                    'font' => ['bold' => true, 'color' => ['rgb' => '00304D']],
                    'fill' => [
                        'fillType' => Fill::FILL_SOLID,
                        'startColor' => ['rgb' => '39A900'],
                    ],
                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_CENTER,
                        'vertical' => Alignment::VERTICAL_CENTER,
                    ],
                ]);

                // Proteger columna H (Número de Ficha) con fondo diferente
                $sheet->getStyle('H8:H1000')->applyFromArray([
                    'fill' => [
                        'fillType' => Fill::FILL_SOLID,
                        'startColor' => ['rgb' => 'F0F0F0'],
                    ],
                ]);

                $sheet->getRowDimension(1)->setRowHeight(60);
                $sheet->getRowDimension(2)->setRowHeight(18);
                $sheet->getRowDimension(3)->setRowHeight(18);
                $sheet->getRowDimension(4)->setRowHeight(18);

                // Agregar validación de datos en columna G (Programa de Formación) desde fila 8 hasta 1000
                $validation = $sheet->getCell('G8')->getDataValidation();
                $validation->setType(DataValidation::TYPE_LIST);
                $validation->setErrorStyle(DataValidation::STYLE_INFORMATION);
                $validation->setAllowBlank(false);
                $validation->setShowInputMessage(true);
                $validation->setShowErrorMessage(true);
                $validation->setShowDropDown(true);
                $validation->setErrorTitle('Entrada no válida');
                $validation->setError('Debe seleccionar un programa de la lista desplegable.');
                $validation->setPromptTitle('Seleccione un programa');
                $validation->setPrompt('Haga clic en la flecha para ver la lista de programas disponibles.');
                $validation->setFormula1('Programas!$B$2:$B$1000');

                // Copiar validación a todas las filas de la columna G
                for ($row = 8; $row <= 1000; $row++) {
                    $sheet->getCell('G' . $row)->setDataValidation(clone $validation);
                }

                // Agregar fórmula VLOOKUP en columna H (Número de Ficha) para buscar el código
                for ($row = 8; $row <= 1000; $row++) {
                    $sheet->setCellValue('H' . $row, '=IF(G' . $row . '="","",VLOOKUP(G' . $row . ',Programas!$B$2:$C$1000,2,0))');
                }

                // Dropdown para Tipo de Documento (columna A)
                $validationTipoDoc = $sheet->getCell('A8')->getDataValidation();
                $validationTipoDoc->setType(DataValidation::TYPE_LIST);
                $validationTipoDoc->setErrorStyle(DataValidation::STYLE_INFORMATION);
                $validationTipoDoc->setAllowBlank(false);
                $validationTipoDoc->setShowInputMessage(true);
                $validationTipoDoc->setShowErrorMessage(true);
                $validationTipoDoc->setShowDropDown(true);
                $validationTipoDoc->setErrorTitle('Tipo de documento no válido');
                $validationTipoDoc->setError('Debe seleccionar un tipo de documento de la lista: cc, ti, ce, ppt, pas, pa, pep, nit');
                $validationTipoDoc->setPromptTitle('Seleccione tipo de documento');
                $validationTipoDoc->setPrompt('Tipos disponibles: cc (Cédula), ti (Tarjeta Identidad), ce (Cédula Extranjería), ppt (Permiso Protección Temporal), pas (Pasaporte), pa (Permiso Asilo), pep (PEP), nit (NIT)');
                $validationTipoDoc->setFormula1('"cc,ti,ce,ppt,pas,pa,pep,nit"');

                // Copiar validación a todas las filas de columna A
                for ($row = 8; $row <= 1000; $row++) {
                    $sheet->getCell('A' . $row)->setDataValidation(clone $validationTipoDoc);
                }

                // Dropdown para Estado (columna I)
                $validationEstado = $sheet->getCell('I8')->getDataValidation();
                $validationEstado->setType(DataValidation::TYPE_LIST);
                $validationEstado->setErrorStyle(DataValidation::STYLE_INFORMATION);
                $validationEstado->setAllowBlank(true); // Estado es opcional
                $validationEstado->setShowInputMessage(true);
                $validationEstado->setShowErrorMessage(true);
                $validationEstado->setShowDropDown(true);
                $validationEstado->setErrorTitle('Estado no válido');
                $validationEstado->setError('Debe seleccionar un estado de la lista: inscrito, por_inscribir, con_novedad');
                $validationEstado->setPromptTitle('Seleccione estado');
                $validationEstado->setPrompt('Estados disponibles: inscrito, por_inscribir (predeterminado), con_novedad. Si se deja vacío, se asignará "por_inscribir".');
                $validationEstado->setFormula1('"inscrito,por_inscribir,con_novedad"');

                // Copiar validación a todas las filas de columna I
                for ($row = 8; $row <= 1000; $row++) {
                    $sheet->getCell('I' . $row)->setDataValidation(clone $validationEstado);
                }
            },
        ];
    }
}

// Hoja oculta con la lista de programas
class ProgramasListSheet implements WithHeadings, WithTitle, WithEvents
{
    private $programas;

    public function __construct()
    {
        // Obtener todos los programas activos
        $this->programas = Programa::where('estado', 'activo')
            ->orderBy('nombre')
            ->get(['id', 'nombre', 'numero_ficha']);
    }

    public function headings(): array
    {
        return ['ID', 'Nombre del Programa', 'Número de Ficha'];
    }

    public function title(): string
    {
        return 'Programas';
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();

                // Encabezados con estilo SENA
                $sheet->getStyle('A1:C1')->applyFromArray([
                    'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
                    'fill' => [
                        'fillType' => Fill::FILL_SOLID,
                        'startColor' => ['rgb' => '00304D'],
                    ],
                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_CENTER,
                        'vertical' => Alignment::VERTICAL_CENTER,
                    ],
                ]);

                // Llenar datos de programas
                $row = 2;
                foreach ($this->programas as $programa) {
                    $sheet->setCellValue('A' . $row, $programa->id);
                    $sheet->setCellValue('B' . $row, $programa->nombre);
                    $sheet->setCellValue('C' . $row, $programa->numero_ficha);
                    $row++;
                }

                // Auto-ajustar ancho de columnas
                $sheet->getColumnDimension('A')->setWidth(10);
                $sheet->getColumnDimension('B')->setWidth(60);
                $sheet->getColumnDimension('C')->setWidth(15);

                // Ocultar la hoja (comentar esta línea si quieres ver la hoja para debugging)
                $sheet->setSheetState(\PhpOffice\PhpSpreadsheet\Worksheet\Worksheet::SHEETSTATE_HIDDEN);
            },
        ];
    }
}
