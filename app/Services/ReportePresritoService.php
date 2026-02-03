<?php

namespace App\Services;

use App\Models\Preinscrito;
use Illuminate\Support\Collection;

/**
 * Servicio para construir reportes de preinscritos
 * Gestiona filtros, agregación de datos y lógica de reporte
 */
class ReportePresritoService
{
    /**
     * Obtener preinscritos según filtros
     */
    public function obtenerPrescritos(array $filtros): Collection
    {
        $query = Preinscrito::query()
            ->with(['programa', 'createdBy'])
            ->whereNull('deleted_at');

        // Aplicar filtros
        if (!empty($filtros['programa_id'])) {
            $query->where('programa_id', $filtros['programa_id']);
        }

        if (!empty($filtros['estado'])) {
            $query->where('estado', $filtros['estado']);
        }

        if (!empty($filtros['tipo_documento'])) {
            $query->where('tipo_documento', $filtros['tipo_documento']);
        }

        if (!empty($filtros['search'])) {
            $search = $filtros['search'];
            $query->where(function ($q) use ($search) {
                $q->where('nombres', 'like', "%{$search}%")
                    ->orWhere('apellidos', 'like', "%{$search}%")
                    ->orWhere('numero_documento', 'like', "%{$search}%")
                    ->orWhere('correo_principal', 'like', "%{$search}%");
            });
        }

        return $query->orderBy('apellidos')->orderBy('nombres')->get();
    }

    /**
     * Determinar si el reporte es de una sola ficha
     */
    public function esUnaSolaFicha(Collection $preinscritos): bool
    {
        if ($preinscritos->isEmpty()) {
            return false;
        }

        $fichas = $preinscritos->pluck('programa.numero_ficha')->unique();
        return $fichas->count() === 1;
    }

    /**
     * Obtener información del header del reporte
     */
    public function obtenerHeaderReporte(Collection $preinscritos): array
    {
        $esUnaSolaFicha = $this->esUnaSolaFicha($preinscritos);

        $header = [
            'titulo' => 'Reporte de Inscripciones',
            'es_una_sola_ficha' => $esUnaSolaFicha,
            'total_registros' => $preinscritos->count(),
        ];

        if ($esUnaSolaFicha && $preinscritos->isNotEmpty()) {
            $primerPrograma = $preinscritos->first()->programa;
            $header['codigo_ficha'] = $primerPrograma->numero_ficha ?? 'N/A';
            $header['programa'] = $primerPrograma->nombre ?? 'N/A';
        } else {
            $header['codigo_ficha'] = 'N/A';
            $header['programa'] = 'N/A';
        }

        return $header;
    }

    /**
     * Preparar datos para la tabla del reporte
     */
    public function prepararDatosReporte(Collection $preinscritos): array
    {
        return $preinscritos->map(function ($presrito) {
            return [
                'Identificación' => $presrito->numero_documento,
                'Nombre' => $presrito->nombres . ' ' . $presrito->apellidos,
                'Estado' => $this->obtenerEtiquetaEstado($presrito->estado),
            ];
        })->toArray();
    }

    /**
     * Obtener etiqueta del estado
     */
    private function obtenerEtiquetaEstado(string $estado): string
    {
        $estados = Preinscrito::getEstados();
        return $estados[$estado] ?? $estado;
    }

    /**
     * Serializar filtros para auditoría
     */
    public function serializarFiltros(array $filtros): array
    {
        $filtrosSerialized = [];

        if (!empty($filtros['programa_id'])) {
            $programa = \App\Models\Programa::find($filtros['programa_id']);
            $filtrosSerialized['programa'] = $programa?->nombre ?? $filtros['programa_id'];
        }

        if (!empty($filtros['estado'])) {
            $estados = Preinscrito::getEstados();
            $filtrosSerialized['estado'] = $estados[$filtros['estado']] ?? $filtros['estado'];
        }

        if (!empty($filtros['tipo_documento'])) {
            $tiposDocumento = Preinscrito::getTiposDocumento();
            $filtrosSerialized['tipo_documento'] = $tiposDocumento[$filtros['tipo_documento']] ?? $filtros['tipo_documento'];
        }

        if (!empty($filtros['search'])) {
            $filtrosSerialized['busqueda'] = $filtros['search'];
        }

        return !empty($filtrosSerialized) ? $filtrosSerialized : ['sin_filtros' => true];
    }
}
