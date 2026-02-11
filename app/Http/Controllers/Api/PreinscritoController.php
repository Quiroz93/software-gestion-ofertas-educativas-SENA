<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Preinscrito;
use Illuminate\Http\JsonResponse;

class PreinscritoController extends Controller
{
    public function index(): JsonResponse
    {
        $preinscritos = Preinscrito::with('programa')
            ->select('id', 'nombres', 'apellidos', 'numero_documento', 'tipo_documento', 'celular_principal', 'correo_principal', 'programa_id', 'estado')
            ->orderBy('nombres')
            ->get()
            ->map(function ($p) {
                return [
                    'id' => $p->id,
                    'nombre_completo' => $p->nombre_completo,
                    'nombres' => $p->nombres,
                    'apellidos' => $p->apellidos,
                    'numero_documento' => $p->numero_documento,
                    'tipo_documento' => $p->tipo_documento,
                    'celular_principal' => $p->celular_principal,
                    'correo_principal' => $p->correo_principal,
                    'programa_id' => $p->programa_id,
                    'programa_nombre' => $p->programa?->nombre,
                    'estado' => $p->estado,
                ];
            });

        return response()->json($preinscritos);
    }
}
