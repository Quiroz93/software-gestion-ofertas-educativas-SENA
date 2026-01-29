<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Programa;
use App\Models\Red;
use App\Models\NivelFormacion;
use Illuminate\Http\Request;

class PublicProgramaController extends Controller
{
    public function index()
    {
        $query = Programa::with(['red', 'nivelFormacion']);
        
        // Apply filters if provided with validation
        if (request('red') && is_numeric(request('red'))) {
            $query->where('red_id', request('red'));
        }
        
        if (request('nivel') && is_numeric(request('nivel'))) {
            $query->where('nivel_formacion_id', request('nivel'));
        }
        
        $programas = $query->paginate(10);
        $redes = Red::all();
        $niveles = NivelFormacion::all();
        
        return view('public.programas.index', compact('programas', 'redes', 'niveles'));
    }
}
