<?php

namespace App\Console\Commands;

use App\Models\Programa;
use Illuminate\Console\Command;

class MergeDuplicatePrograms extends Command
{
    protected $signature = 'programs:merge-duplicates';
    protected $description = 'Fusiona programas duplicados (mismo nombre y número de ficha)';

    public function handle()
    {
        $this->info("Buscando programas duplicados...\n");

        // Agrupar programas por nombre y número de ficha
        $grupos = Programa::selectRaw('nombre, numero_ficha, COUNT(*) as total, GROUP_CONCAT(id) as ids')
            ->groupBy('nombre', 'numero_ficha')
            ->having('total', '>', 1)
            ->get();

        if ($grupos->isEmpty()) {
            $this->info("✓ No hay programas duplicados.");
            return;
        }

        $programasMerged = 0;

        foreach ($grupos as $grupo) {
            $ids = array_map('intval', explode(',', $grupo->ids));
            $programaPrincipal = Programa::find($ids[0]);
            $duplicados = array_slice($ids, 1);

            $this->info("Consolidando: {$grupo->nombre} (Fichas: {$grupo->numero_ficha})");

            foreach ($duplicados as $idDuplicado) {
                $programaDuplicado = Programa::find($idDuplicado);

                // Reasignar todos los preinscritos al programa principal
                $preinscritos = $programaDuplicado->preinscritos()->get();
                
                foreach ($preinscritos as $preinscrito) {
                    $preinscrito->update(['programa_id' => $programaPrincipal->id]);
                    $this->line("  → Preinscrito #{$preinscrito->id} reasignado");
                }

                // Eliminar el programa duplicado
                $programaDuplicado->delete();
                $this->line("  ✗ Programa duplicado #{$idDuplicado} eliminado");
            }

            $programasMerged++;
            $this->newLine();
        }

        $this->info("✓ {$programasMerged} grupos de programas consolidados");
        $this->info("Total de programas únicos: " . Programa::count());
    }
}
