<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Oferta;
use App\Models\Programa;
use App\Models\Inscrito;
use App\Models\Preinscrito;

class EstadisticasPreinscritosTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        // Crea usuario admin autenticado
        $this->user = User::factory()->create(['role' => 'admin']);
        $this->actingAs($this->user);
    }

    /** @test */
    public function puede_filtrar_por_anio_oferta_y_programa()
    {
        $oferta = Oferta::factory()->create(['año' => 2026]);
        $programa = Programa::factory()->create();
        $oferta->programas()->attach($programa->id);
        Inscrito::factory()->create([
            'oferta_id' => $oferta->id,
            'programa_id' => $programa->id,
            'anio' => 2026,
            'estado' => 'activo',
        ]);
        $response = $this->getJson(route('admin.estadisticas-preinscritos.metricas', [
            'anio' => 2026,
            'oferta_id' => $oferta->id,
            'programa_id' => $programa->id,
        ]));
        $response->assertStatus(200)
            ->assertJsonFragment(['total_inscritos' => 1]);
    }

    /** @test */
    public function valida_conteos_de_estados_en_preinscritos()
    {
        $oferta = Oferta::factory()->create(['año' => 2026]);
        $programa = Programa::factory()->create();
        $oferta->programas()->attach($programa->id);
        Preinscrito::factory()->create([
            'programa_id' => $programa->id,
            'estado' => 'rechazado',
        ]);
        Preinscrito::factory()->create([
            'programa_id' => $programa->id,
            'estado' => 'con_novedad',
        ]);
        $response = $this->getJson(route('admin.estadisticas-preinscritos.metricas', [
            'anio' => 2026,
            'oferta_id' => $oferta->id,
            'programa_id' => $programa->id,
        ]));
        $response->assertStatus(200)
            ->assertJsonFragment(['rechazados' => 1])
            ->assertJsonFragment(['con_novedad' => 1]);
    }

    /** @test */
    public function rechaza_parametros_invalidos()
    {
        $response = $this->getJson(route('admin.estadisticas-preinscritos.metricas', [
            'anio' => 'no-num',
        ]));
        $response->assertStatus(422)
            ->assertJsonFragment(['error' => 'Año inválido']);
    }
}
