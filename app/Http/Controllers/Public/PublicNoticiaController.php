<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Noticia;
use Illuminate\Http\Request;

class PublicNoticiaController extends Controller
{
    public function index()
    {
        $noticias = Noticia::where('activa', true)->paginate(10);
        return view('public.noticias.index', compact('noticias'));
    }

    public function show(Noticia $ultimaNoticia)
    {
        // Verificar que la noticia esté activa
        if (!$ultimaNoticia->activa) {
            abort(404);
        }

        return view('public.noticias.show', compact('ultimaNoticia'));
    }
}
