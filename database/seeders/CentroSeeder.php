<?php

namespace Database\Seeders;

use App\Models\Centro;
use Illuminate\Database\Seeder;

class CentroSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $centros = [
            [
                'nombre' => 'Centro de Comercio y Servicios',
                'direccion' => 'Cra. 45 #32-65, Bogotá, Cundinamarca',
                'telefono' => '(1) 5922222',
                'correo' => 'comercio@sena.edu.co'
            ],
            [
                'nombre' => 'Centro de Formación en Manufactura',
                'direccion' => 'Cra. 50 #35-80, Bogotá, Cundinamarca',
                'telefono' => '(1) 5912345',
                'correo' => 'manufactura@sena.edu.co'
            ],
            [
                'nombre' => 'Centro de Tecnologías Avanzadas',
                'direccion' => 'Cra. 55 #38-90, Bogotá, Cundinamarca',
                'telefono' => '(1) 5934567',
                'correo' => 'tecnologias@sena.edu.co'
            ],
            [
                'nombre' => 'Centro de Innovación y Emprendimiento',
                'direccion' => 'Cra. 60 #40-50, Bogotá, Cundinamarca',
                'telefono' => '(1) 5956789',
                'correo' => 'innovacion@sena.edu.co'
            ],
            [
                'nombre' => 'Centro Regional Cauca',
                'direccion' => 'Cra. 6 #4-50, Popayán, Cauca',
                'telefono' => '(2) 8244444',
                'correo' => 'cauca@sena.edu.co'
            ],
            [
                'nombre' => 'Centro Agroempresarial y turistico de los antes',
                'direccion' => 'Cra. 10 #12-34, Los Antes, Santander',
                'telefono' => '(7) 6200000',
                'correo' => 'agroempresarial@sena.edu.co'
            ]
        ];

        foreach ($centros as $centro) {
            Centro::create($centro);
        }
    }
}
