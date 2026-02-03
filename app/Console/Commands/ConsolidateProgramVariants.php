<?php

namespace App\Console\Commands;

use App\Models\Programa;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class ConsolidateProgramVariants extends Command
{
    protected $signature = 'programs:consolidate-variants';
    protected $description = 'Consolida variantes de nombres de programas en un nombre único';

    public function handle()
    {
        // Mapeo de variantes a nombre canónico y número de ficha
        $mapeoVariantes = [
            'ADSO' => [
                'nombre_canonical' => 'Análisis y Desarrollo de Software',
                'numero_ficha' => '3410551',
                'variantes' => ['ADSO', 'ANALISIS Y DESARROLLO DE SOFTWARE', 'ANALISIS Y DISEÑO DE SOFTWARE', 'ANALISIS Y DISE', 'DESARROLLO DE SOFTWARE', 'SISTEMAS'],
            ],
            'COSMETOLOGIA' => [
                'nombre_canonical' => 'Cosmetología y Estética Integral',
                'numero_ficha' => '3410528',
                'variantes' => ['COSMETOLOGIA', 'COSMETOLOGÍA', 'TC.COSMETOLOGIA', 'COSMETOLOGIA Y ESTETICA INTEGRAL', 'COSMETOLOGIA Y ESTETICA IONTEGRAL'],
            ],
            'DIBUJO' => [
                'nombre_canonical' => 'Dibujo Arquitectónico - FIC',
                'numero_ficha' => '3410525',
                'variantes' => ['DIBUJO', 'DIBUJO ARQUITECTONICO', 'DIBUJO ARQUTECTONICO', 'DIBUJO ARQUITECTÓNICO'],
            ],
            'TOPOGRAFIA' => [
                'nombre_canonical' => 'Levantamientos Topográficos y Georeferenciación',
                'numero_ficha' => '3410534', // Genérico para topografía
                'variantes' => ['TOPOGRAFIA', 'TOPOGRAFIA', 'TOPOGRAFÍA', 'TOPOGAFIA', 'TOPOGRFÍA', 'TPOGAFÍA', 'LEVANTAMIENTO TOPOGRAFICO', 'TOPOGRAFÍA'],
            ],
            'PRIMERA_INFANCIA' => [
                'nombre_canonical' => 'Atención Integral a la Primera Infancia',
                'numero_ficha' => '3410527',
                'variantes' => ['PRIMERA INFANCIA', 'ATENCION INTEGRAL A LA PRIMERA INFANCIA', 'ATENCION INTEGRAL A PRIMERA INFANCIA', 'GESTIO A LA PRIMERA INFANCA'],
            ],
            'ADMINISTRACION' => [
                'nombre_canonical' => 'Gestión Administrativa',
                'numero_ficha' => '3410568',
                'variantes' => ['GESTION ADMINISTRATIVA', 'GESTION ADMINSITRATIVA', 'ADMINISTRACION', 'ADMINISTRATIVA', 'GETION ADMINISTRATIVA', 'ADMINISTRACION DE EMPRESAS'],
            ],
            'ACTIVIDAD_FISICA' => [
                'nombre_canonical' => 'Actividad Física',
                'numero_ficha' => '3410548',
                'variantes' => ['ACTIVIDAD FISICA', 'ACTIVIDAD FÍSICA', 'ACTTIVIDAD FISICA', 'EJECUCION DE PROGRAMAS DEPORTIVOS', 'DEPORTIVO'],
            ],
            'PANADERIA' => [
                'nombre_canonical' => 'Procesos de Panadería',
                'numero_ficha' => '3410523',
                'variantes' => ['PANADERIA', 'PANDERIA', 'PROCESOS DE PANADERIA', 'PROCESOS DE PANADERÍA'],
            ],
            'PELUQUERIA' => [
                'nombre_canonical' => 'Peluquería',
                'numero_ficha' => '1000028',
                'variantes' => ['PELUQUERIA', 'PELUQUERÍA'],
            ],
            'ENFERMERIA' => [
                'nombre_canonical' => 'Enfermería',
                'numero_ficha' => '1000015',
                'variantes' => ['ENFERMERIA', 'ENERMERIA'],
            ],
            'CONSTRUCCION' => [
                'nombre_canonical' => 'Construcción en Edificaciones',
                'numero_ficha' => '1000004',
                'variantes' => ['CONSTRUCCION EN EDIFICACIONES', 'CONSTRUCCION', 'CONSTRUCCION/ELECTRICIDAD', 'CONSTUCCIO', 'CONSTRUCCIÓN'],
            ],
            'CONTABILIDAD' => [
                'nombre_canonical' => 'Gestión Contable y de Información Financiera',
                'numero_ficha' => '1000018',
                'variantes' => ['CONTABILIDAD', 'GESTION CONTABLE', 'GESTION CONTABLE Y DE INFORMACION FINANCIERA', 'CONTABILIDAD -VIRTUAL', 'CONTABILIDAD VIRTUAL'],
            ],
            'SISTEMAS_INTEGRADOS' => [
                'nombre_canonical' => 'Coordinación de Sistemas Integrados de Gestión',
                'numero_ficha' => '1000011',
                'variantes' => ['COORDINACION DE SISTEMAS', 'COORDINACION DE SISTEMAS INTEGRADOS DE GESTION', 'COORDINACION EN SISTEMAS INTEGRADOS DE GESTION', 'COORDINACION DE SISTEMAS INTEGRADOS Y DE GESTION'],
            ],
            'COCINA' => [
                'nombre_canonical' => 'Cocina',
                'numero_ficha' => '1000003',
                'variantes' => ['COCINA'],
            ],
            'MECANICA_MOTOS' => [
                'nombre_canonical' => 'Mantenimiento de Motos y Motocarros',
                'numero_ficha' => '1000024',
                'variantes' => ['MANTENIMIENTO DE MOTOS Y MOTOCARROS', 'MANTENIMIENTOS DE MOTOS Y MOTOCARROS', 'GESTION EMPRESARIAL/ MECANICA'],
            ],
            'PRODUCCION_AGRICOLA' => [
                'nombre_canonical' => 'Gestión de la Producción Agrícola',
                'numero_ficha' => '1000019',
                'variantes' => ['GESTION DE LA PRODUCCION AGRICOLA', 'CULTIVOS AGRICOLAS', 'PRODUCCION GANADERA'],
            ],
            'CUIDADOR' => [
                'nombre_canonical' => 'Curso de Cuidador',
                'numero_ficha' => '1000013',
                'variantes' => ['CURSO DE CUIDADOR'],
            ],
            'CARNES' => [
                'nombre_canonical' => 'Procesamiento de Carnes',
                'numero_ficha' => '1000029',
                'variantes' => ['PROCESAMIENTO DE CARNES'],
            ],
            'EMPRESARIAL' => [
                'nombre_canonical' => 'Gestión Empresarial',
                'numero_ficha' => '1000020',
                'variantes' => ['GESTION EMPRESARIAL'],
            ],
            'IDIOMAS' => [
                'nombre_canonical' => 'Inglés',
                'numero_ficha' => '1000022',
                'variantes' => ['INGLES'],
            ],
            'SALUD' => [
                'nombre_canonical' => 'Salud Ocupacional',
                'numero_ficha' => '1000031',
                'variantes' => ['SALUD OCUPACIONAL'],
            ],
        ];

        $normalizePrograma = function (?string $nombre): string {
            $value = Str::ascii((string) $nombre);
            $value = strtoupper(trim($value));
            $value = preg_replace('/\s+/', ' ', $value);
            return $value;
        };

        // Crear índice inverso: variante normalizada => datos canónicos
        $indiceVariantes = [];
        foreach ($mapeoVariantes as $key => $datos) {
            foreach ($datos['variantes'] as $variante) {
                $varianteNorm = $normalizePrograma($variante);
                $indiceVariantes[$varianteNorm] = $datos;
            }
        }

        $programasActualizados = 0;
        $noConsolidados = [];

        // Obtener todos los programas
        $programas = Programa::orderBy('nombre')->get();

        $this->info("Procesando " . $programas->count() . " programas para consolidar variantes...\n");

        foreach ($programas as $programa) {
            $nombreNorm = $normalizePrograma($programa->nombre);

            // Buscar en el índice de variantes
            if (isset($indiceVariantes[$nombreNorm])) {
                $datos = $indiceVariantes[$nombreNorm];
                $nombreCanal = $datos['nombre_canonical'];
                $numeroFicha = $datos['numero_ficha'];

                if ($programa->nombre !== $nombreCanal || $programa->numero_ficha !== $numeroFicha) {
                    $programa->update([
                        'nombre' => $nombreCanal,
                        'numero_ficha' => $numeroFicha,
                    ]);

                    $this->line("✓ {$programa->nombre} → {$nombreCanal} ({$numeroFicha})");
                    $programasActualizados++;
                }
            } else {
                // Intentar eliminar programas con N/A o sin identificación
                if ($programa->nombre === 'N/A' || $programa->nombre === '') {
                    $programa->delete();
                    $this->line("✗ {$programa->nombre} (eliminado)");
                } else {
                    $noConsolidados[] = $programa->nombre;
                }
            }
        }

        $this->newLine();
        $this->info("✓ {$programasActualizados} programas consolidados");

        if (!empty($noConsolidados)) {
            $this->warn("\n⚠ Programas no reconocidos (" . count($noConsolidados) . "):");
            foreach ($noConsolidados as $nombre) {
                $this->line("  - {$nombre}");
            }
        } else {
            $this->info("\n✓ Todos los programas han sido consolidados exitosamente!");
        }

        // Mostrar programas únicos consolidados
        $programasUnicos = Programa::distinct('numero_ficha')
            ->where('numero_ficha', 'like', '341%')
            ->orWhere('numero_ficha', 'like', '100%')
            ->count();

        $this->newLine();
        $this->info("Resumen final:");
        $this->line("  Total de programas: " . Programa::count());
        $this->line("  Programas únicos (sin duplicados): " . Programa::distinct('nombre')->count());
    }
}
