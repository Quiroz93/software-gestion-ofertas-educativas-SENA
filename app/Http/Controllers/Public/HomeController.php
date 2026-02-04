<?php

namespace App\Http\Controllers\Public;

use App\Models\Noticia;
use App\Models\HomeCarousel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
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

        $programas = Programa::where('estado', 'Activo')
            ->latest()
            ->take(4)
            ->get();

        $slides = HomeCarousel::where('is_active', true)
            ->orderBy('position')
            ->get();

        return view('public.home', compact('noticias', 'programas', 'slides'));
    }
}
