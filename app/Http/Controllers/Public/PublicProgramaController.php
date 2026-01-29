<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Programa;
use App\Models\Red;
use App\Models\NivelFormacion;
use Illuminate\Http\Request;

class PublicProgramaController extends Controller
{
    public function index(Request $request)
    {
        // Get all redes and niveles for filters
        $redes = Red::all();
        $niveles = NivelFormacion::all();
        
        // Build query for programas
        $query = Programa::with(['red', 'nivelFormacion', 'centro']);
        
        // Apply filters if present
        if ($request->filled('red')) {
            $query->where('red_id', $request->red);
        }
        
        if ($request->filled('nivel')) {
            $query->where('nivel_formacion_id', $request->nivel);
        }
        
        // Get programas with pagination
        $programas = $query->paginate(10);
        
        return view('public.programas.index', compact('programas', 'redes', 'niveles'));
    }
}
