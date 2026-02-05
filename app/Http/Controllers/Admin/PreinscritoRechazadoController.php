<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PreinscritoRechazado;
use Illuminate\Http\Request;

class PreinscritoRechazadoController extends Controller
{
    public function index(Request $request)
    {
        $query = PreinscritoRechazado::query()->orderBy('created_at', 'desc');
        
        // Filtros
        if ($request->filled('motivo')) {
            $query->where('motivo', $request->motivo);
        }
        
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nombre_completo', 'LIKE', "%{$search}%")
                  ->orWhere('numero_documento', 'LIKE', "%{$search}%")
                  ->orWhere('correo', 'LIKE', "%{$search}%");
            });
        }
        
        $rechazados = $query->paginate(50);
        
        // Obtener motivos únicos para filtro
        $motivos = PreinscritoRechazado::select('motivo')
            ->distinct()
            ->whereNotNull('motivo')
            ->pluck('motivo')
            ->toArray();
        
        return view('admin.preinscritos-rechazados.index', compact('rechazados', 'motivos'));
    }
    
    public function show($id)
    {
        $rechazado = PreinscritoRechazado::findOrFail($id);
        return view('admin.preinscritos-rechazados.show', compact('rechazado'));
    }
    
    public function destroy($id)
    {
        $rechazado = PreinscritoRechazado::findOrFail($id);
        $rechazado->delete();
        
        return redirect()->route('admin.preinscritos-rechazados.index')
            ->with('success', 'Registro eliminado correctamente');
    }
}
