<?php

namespace App\Http\Controllers;

use App\Models\Noticia;
use Illuminate\Http\Request;
use illuminate\Routing\Controller as BaseController;

class HomeController extends Controller
{


    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $noticias = Noticia::where('activa', true)
            ->latest()
            ->take(4)
            ->get();

        return view('home', compact('noticias'));
    }
}
