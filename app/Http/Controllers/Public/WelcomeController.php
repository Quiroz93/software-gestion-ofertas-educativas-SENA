<?php

namespace App\Http\Controllers\Public;

use App\Models\Noticia;
use App\Models\Oferta;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class WelcomeController extends \App\Http\Controllers\Controller
{
    /**
     * Muestra la página de bienvenida pública.
     *
     * Obtiene las últimas noticias y ofertas activas para mostrarlas
     * a los visitantes no autenticados.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        // Obtiene las 4 noticias más recientes que estén marcadas como activas.
        $noticias = Noticia::where('activa', true)->latest()->take(4)->get();

        // Obtiene las 4 ofertas más recientes.
        // Asegúrate de que el modelo Oferta exista y tenga datos.
        $ofertas = Oferta::latest()->take(4)->get();

        return view('public.welcome', compact('noticias', 'ofertas'));
    }
}
