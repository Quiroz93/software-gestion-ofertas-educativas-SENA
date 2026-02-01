<?php

namespace Database\Seeders;

use App\Models\Municipio;
use Illuminate\Database\Seeder;

class MunicipioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $municipios = [
            ['nombre' => 'Bucaramanga', 'codigo' => '68001', 'departamento' => 'Santander'],
            ['nombre' => 'Floridablanca', 'codigo' => '68276', 'departamento' => 'Santander'],
            ['nombre' => 'Girón', 'codigo' => '68307', 'departamento' => 'Santander'],
            ['nombre' => 'Piedecuesta', 'codigo' => '68547', 'departamento' => 'Santander'],
            ['nombre' => 'Barrancabermeja', 'codigo' => '68081', 'departamento' => 'Santander'],
            ['nombre' => 'San Gil', 'codigo' => '68679', 'departamento' => 'Santander'],
            ['nombre' => 'Socorro', 'codigo' => '68773', 'departamento' => 'Santander'],
            ['nombre' => 'Málaga', 'codigo' => '68432', 'departamento' => 'Santander'],
            ['nombre' => 'Barbosa', 'codigo' => '68077', 'departamento' => 'Santander'],
            ['nombre' => 'Vélez', 'codigo' => '68855', 'departamento' => 'Santander'],
            ['nombre' => 'Lebrija', 'codigo' => '68406', 'departamento' => 'Santander'],
            ['nombre' => 'Sabana de Torres', 'codigo' => '68655', 'departamento' => 'Santander'],
            ['nombre' => 'Rionegro', 'codigo' => '68615', 'departamento' => 'Santander'],
            ['nombre' => 'Zapatoca', 'codigo' => '68895', 'departamento' => 'Santander'],
            ['nombre' => 'Charalá', 'codigo' => '68190', 'departamento' => 'Santander'],
            ['nombre' => 'El Carmen de Chucurí', 'codigo' => '68235', 'departamento' => 'Santander'],
            ['nombre' => 'Puerto Wilches', 'codigo' => '68575', 'departamento' => 'Santander'],
            ['nombre' => 'Simacota', 'codigo' => '68755', 'departamento' => 'Santander'],
            ['nombre' => 'San Vicente de Chucurí', 'codigo' => '68689', 'departamento' => 'Santander'],
            ['nombre' => 'Landázuri', 'codigo' => '68397', 'departamento' => 'Santander'],
        ];

        foreach ($municipios as $municipio) {
            Municipio::create($municipio);
        }
    }
}
