<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Noticia;
use Illuminate\Http\Request;

class PublicNoticiaController extends Controller
{
    public function index()
    {
        // Usando get() en lugar de paginate() debido a bug en Laravel 12
        // con AbstractPaginator::links() y call_user_func()
        $noticias = Noticia::where('activa', true)
            ->latest()
            ->get();
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
