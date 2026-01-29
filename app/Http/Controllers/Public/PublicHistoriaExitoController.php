<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\HistoriaExito;
use Illuminate\Http\Request;

class PublicHistoriaExitoController extends Controller
{
    public function index()
    {
        $historias = HistoriaExito::paginate(12);
        return view('public.historias_exito.index', compact('historias'));
    }
}
