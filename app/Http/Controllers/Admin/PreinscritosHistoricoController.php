<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Preinscrito;
use Illuminate\Support\Facades\DB;

class PreinscritosHistoricoController extends Controller
{
    public function respaldarYLimpiar(Request $request)
    {
        $request->validate([
            'oferta_id' => 'required|exists:ofertas,id',
        ]);

        DB::transaction(function () use ($request) {
            $preinscritos = Preinscrito::all();
            $historico = $preinscritos->map(function ($item) use ($request) {
                $data = $item->toArray();
                $data['oferta_id'] = $request->oferta_id;
                unset($data['id']);
                unset($data['deleted_at']);
                // Convertir fechas ISO8601 a formato MySQL si es necesario
                foreach (['created_at', 'updated_at', 'fecha_resolucion'] as $campo) {
                    if (isset($data[$campo]) && $data[$campo]) {
                        // Si es string tipo 2026-02-08T00:39:40.000000Z, convertir a Y-m-d H:i:s
                        if (is_string($data[$campo]) && str_contains($data[$campo], 'T')) {
                            $data[$campo] = date('Y-m-d H:i:s', strtotime($data[$campo]));
                        }
                    }
                }
                return $data;
            })->toArray();
            if (count($historico)) {
                DB::table('preinscritos_historico')->insert($historico);
            }
            // Eliminar novedades primero para evitar error de clave foránea
            DB::table('novedades_preinscritos')->delete();
            Preinscrito::query()->delete();
        });

        return redirect()->back()->with('success', 'Preinscritos respaldados y limpiados correctamente.');
    }
}
