<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Oferta;
use Illuminate\Http\Request;

class PublicOfertaController extends Controller
{
    public function index() 
    {
        $ofertas= Oferta ::all();
        return view('public.ofertas.index', compact('ofertas'));
    }
}
