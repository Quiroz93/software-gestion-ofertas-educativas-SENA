<?php

namespace Database\Seeders;

use App\Models\Oferta;
use Illuminate\Database\Seeder;

class OfertaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $ofertas = [
            [
                'nombre' => 'Oferta Académica 2026-1',
                'año' => 2026,
                'fecha_inicio' => '2026-02-01',
                'fecha_fin' => '2026-12-15',
                'estado' => 'Abierta',
                'centro_id' => 1
            ],
            [
                'nombre' => 'Oferta Académica 2026-2',
                'año' => 2026,
                'fecha_inicio' => '2026-08-01',
                'fecha_fin' => '2027-06-30',
                'estado' => 'En Programación',
                'centro_id' => 2
            ],
            [
                'nombre' => 'Oferta Especial Empresarial 2026',
                'año' => 2026,
                'fecha_inicio' => '2026-03-15',
                'fecha_fin' => '2026-11-30',
                'estado' => 'Abierta',
                'centro_id' => 3
            ],
            [
                'nombre' => 'Formación Complementaria Permanente',
                'año' => 2026,
                'fecha_inicio' => '2026-01-15',
                'fecha_fin' => '2027-01-14',
                'estado' => 'Abierta',
                'centro_id' => 1
            ],
            [
                'nombre' => 'Oferta Regional Cauca 2026',
                'año' => 2026,
                'fecha_inicio' => '2026-02-15',
                'fecha_fin' => '2026-10-31',
                'estado' => 'Abierta',
                'centro_id' => 5
            ]
        ];

        foreach ($ofertas as $oferta) {
            Oferta::create($oferta);
        }
    }
}
