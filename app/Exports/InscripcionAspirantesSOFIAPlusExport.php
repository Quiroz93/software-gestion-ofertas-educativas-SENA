<?php

namespace App\Exports;

use App\Models\Preinscrito;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
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
class InscripcionAspirantesSOFIAPlusExport implements FromCollection, WithHeadings, WithStyles, WithColumnWidths
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

        // Mapear los datos al formato SOFIA Plus
        return $preinscritos->map(function ($preinscrito) {
            return [
                'tipo_documento' => $this->mapearTipoDocumento($preinscrito->tipo_documento),
                'numero_documento' => $preinscrito->numero_documento,
                'apellidos' => strtoupper($preinscrito->apellidos),
                'nombres' => strtoupper($preinscrito->nombres),
                'email' => $preinscrito->correo_principal,
                'telefono' => $preinscrito->celular_alternativo ?? '',
                'celular' => $preinscrito->celular_principal,
                'codigo_ficha' => $preinscrito->programa ? $preinscrito->programa->codigo_ficha : '',
                'nombre_programa' => $preinscrito->programa ? strtoupper($preinscrito->programa->nombre) : '',
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
            'TIPO DOCUMENTO',
            'NÚMERO DOCUMENTO',
            'APELLIDOS',
            'NOMBRES',
            'EMAIL',
            'TELÉFONO',
            'CELULAR',
            'CÓDIGO FICHA',
            'NOMBRE PROGRAMA',
        ];
    }

    /**
     * Ancho de columnas
     */
    public function columnWidths(): array
    {
        return [
            'A' => 18,  // Tipo Documento
            'B' => 20,  // Número Documento
            'C' => 25,  // Apellidos
            'D' => 25,  // Nombres
            'E' => 30,  // Email
            'F' => 18,  // Teléfono
            'G' => 18,  // Celular
            'H' => 18,  // Código Ficha
            'I' => 40,  // Nombre Programa
        ];
    }

    /**
     * Aplicar estilos al Excel - Optimizado para rendimiento
     */
    public function styles(Worksheet $sheet): array
    {
        // Color verde institucional SENA
        $colorSena = 'FF00B050';

        // Estilos solo para la fila de encabezados
        $headerStyle = [
            'font' => [
                'bold' => true,
                'size' => 11,
                'color' => ['rgb' => 'FFFFFF'],
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => $colorSena],
            ],
        ];

        return [
            // Aplicar estilos solo a la fila de encabezados
            1 => $headerStyle,
        ];
    }
}
