<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PublicHistoriaExitoController extends Controller
{
    public function index()
    {
        // Pass empty collection to handle gracefully in view
        return view('public.historias_exito.index', [
            'historias' => collect(),
        ]);
    }
}
