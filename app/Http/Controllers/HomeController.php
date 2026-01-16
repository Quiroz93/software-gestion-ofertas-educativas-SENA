<?php

namespace App\Http\Controllers;

use App\Models\Noticia;
use Illuminate\Http\Request;
use illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Gate;

class HomeController extends Controller
{


     /**
      * Despliega la página de inicio
      * @return \Illuminate\Contracts\View\View
      */
    public function index()
    {
        Gate::authorize('viewAny', Noticia::class);
        $noticias = Noticia::where('activa', true)
            ->latest()
            ->take(4)
            ->get();

        return view('home', compact('noticias'));
    }
}
