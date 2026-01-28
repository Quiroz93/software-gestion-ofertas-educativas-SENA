<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PublicNivelFormacionController extends Controller
{
    public function index()
    {
        return view('public.nivel_formaciones.index');
    }
}
