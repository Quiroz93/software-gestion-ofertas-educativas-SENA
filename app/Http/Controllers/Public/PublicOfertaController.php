<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Oferta;
use Illuminate\Http\Request;


class PublicOfertaController extends Controller
{
    public function index()
    {
        $ofertas = Oferta::where('estado', 'publicada')
            ->orderBy('fecha_inicio')
            ->get();

        return view('public.ofertas.index', compact('ofertas'));
    }

    public function show(Oferta $oferta)
    {
        abort_unless($oferta->estado === 'publicada', 404);

        return view('public.ofertas.show', compact('oferta'));
    }
}
