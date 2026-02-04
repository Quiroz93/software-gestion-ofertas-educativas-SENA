<?php

namespace Database\Seeders;

use App\Models\TipoNovedad;
use Illuminate\Database\Seeder;

class TipoNovedadSeeder extends Seeder
{
    public function run(): void
    {
        $tipos = [
            [
                'nombre' => 'cambio_programa',
                'descripcion' => 'Cambio de programa formativo',
                'activo' => true,
            ],
            [
                'nombre' => 'cambio_contacto',
                'descripcion' => 'Cambio de email, teléfono u otros datos de contacto',
                'activo' => true,
            ],
            [
                'nombre' => 'error_datos',
                'descripcion' => 'Información registrada incorrectamente',
                'activo' => true,
            ],
            [
                'nombre' => 'no_comparecencia',
                'descripcion' => 'No se presentó a la capacitación o citación',
                'activo' => true,
            ],
            [
                'nombre' => 'cambio_ubicacion',
                'descripcion' => 'Cambio de municipio o ubicación',
                'activo' => true,
            ],
            [
                'nombre' => 'otra',
                'descripcion' => 'Otras situaciones',
                'activo' => true,
            ],
        ];

        foreach ($tipos as $tipo) {
            TipoNovedad::withTrashed()->updateOrCreate(
                ['nombre' => $tipo['nombre']],
                [
                    'descripcion' => $tipo['descripcion'],
                    'activo' => $tipo['activo'],
                    'deleted_at' => null,
                ]
            );
        }
    }
}