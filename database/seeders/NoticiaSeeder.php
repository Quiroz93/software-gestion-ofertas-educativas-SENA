<?php

namespace Database\Seeders;

use App\Models\Noticia;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class NoticiaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
public function run(): void
{
    Noticia::create([
        'titulo' => 'Inscripciones Abiertas 2026',
        'descripcion' => 'Ya están abiertas las inscripciones para programas técnicos y tecnológicos.',
    ]);

    Noticia::create([
        'titulo' => 'Nueva Formación Complementaria',
        'descripcion' => 'Cursos cortos disponibles para aprendices y comunidad.',
    ]);
}
}