<?php

namespace App\Http\Controllers;

use App\Models\NivelFormacion;
use App\Models\Programa;
use App\Models\Red;
use Illuminate\Http\Request;

class PublicProgramaController extends Controller
{
    public function index(Request $request)
    {
        $programas = Programa::with(['red', 'nivelFormacion'])
            ->when($request->red, fn ($q) => $q->where('red_id', $request->red))
            ->when($request->nivel, fn ($q) => $q->where('nivel_formacion_id', $request->nivel))
            ->get();

        return view('public.programas.index', [
            'programas' => $programas,
            'redes'     => Red::all(),
            'niveles'   => NivelFormacion::all(),
        ]);
    }

    public function show(Programa $programa)
    {
        return view('public.programas.show', compact('programa'));
    }
}

