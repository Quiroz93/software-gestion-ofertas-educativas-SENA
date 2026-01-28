<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\\Models\\NivelFormacion;
use Illuminate\\Http\\Request;

class PublicNivelFormacionController extends Controller
{
    public function index()
    {
        $niveles = NivelFormacion::all();
        return view('public.nivel_formaciones.index', compact('niveles'));
    }
}
