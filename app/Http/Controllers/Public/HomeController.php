<?php

namespace App\Http\Controllers\Public;

use App\Models\Noticia;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
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

        return view('public.home', compact('noticias'));
    }
}
