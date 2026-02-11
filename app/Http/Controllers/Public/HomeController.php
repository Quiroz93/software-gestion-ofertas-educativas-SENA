<?php

namespace App\Http\Controllers\Public;

use App\Models\Noticia;
use App\Models\HomeCarousel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Oferta;
use App\Models\Programa;
use Illuminate\Support\Facades\Gate;

class HomeController extends Controller
{


     /**
      * Despliega la página de inicio
      * @return \Illuminate\Contracts\View\View
      */
    public function index()
    {
        $noticias = Noticia::where('activa', true)
            ->latest()
            ->take(4)
            ->get();

        $eventos = Oferta::where('estado', 'activo')
            ->with([
                'customContents' => function ($query) {
                    $query->whereIn('key', ['imagen', 'imagen_alt', 'imagen_title']);
                }
            ])
            ->orderBy('fecha_inicio')
            ->take(3)
            ->get();

        $featuredProgramas = Programa::where('estado', 'Activo')
            ->where('is_featured', true)
            ->with('nivelFormacion')
            ->orderBy('updated_at', 'desc')
            ->take(8)
            ->get();

        $slides = HomeCarousel::where('is_active', true)
            ->orderBy('position')
            ->get();

        return view('public.home', compact('noticias', 'eventos', 'featuredProgramas', 'slides'));
    }
}
