<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Preinscrito;
use App\Models\PreinscritoRechazado;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

    public function create()
    {
        $tiposDocumento = Preinscrito::getTiposDocumento();
        $motivos = $this->getMotivosDisponibles();

        return view('admin.preinscritos-rechazados.create', compact('tiposDocumento', 'motivos'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nombre_completo' => ['required', 'string', 'max:255'],
            'tipo_documento' => ['required', 'string', 'max:20'],
            'numero_documento' => ['required', 'string', 'max:50'],
            'telefono' => ['nullable', 'string', 'max:50'],
            'programa' => ['nullable', 'string', 'max:255'],
            'correo' => ['nullable', 'email', 'max:255'],
            'motivo' => ['required', 'string', 'max:100'],
            'fila_excel' => ['nullable', 'integer', 'min:1'],
            'datos_json' => ['nullable', 'string'],
        ]);

        $data['created_by'] = Auth::id();

        PreinscritoRechazado::create($data);

        return redirect()->route('admin.preinscritos-rechazados.index')
            ->with('success', 'Registro rechazado creado correctamente.');
    }
    
    public function show($id)
    {
        $rechazado = PreinscritoRechazado::findOrFail($id);
        return view('admin.preinscritos-rechazados.show', compact('rechazado'));
    }

    public function edit($id)
    {
        $rechazado = PreinscritoRechazado::findOrFail($id);
        $tiposDocumento = Preinscrito::getTiposDocumento();
        $motivos = $this->getMotivosDisponibles();

        return view('admin.preinscritos-rechazados.edit', compact('rechazado', 'tiposDocumento', 'motivos'));
    }

    public function update(Request $request, $id)
    {
        $rechazado = PreinscritoRechazado::findOrFail($id);

        $data = $request->validate([
            'nombre_completo' => ['required', 'string', 'max:255'],
            'tipo_documento' => ['required', 'string', 'max:20'],
            'numero_documento' => ['required', 'string', 'max:50'],
            'telefono' => ['nullable', 'string', 'max:50'],
            'programa' => ['nullable', 'string', 'max:255'],
            'correo' => ['nullable', 'email', 'max:255'],
            'motivo' => ['required', 'string', 'max:100'],
            'fila_excel' => ['nullable', 'integer', 'min:1'],
            'datos_json' => ['nullable', 'string'],
        ]);

        $rechazado->update($data);

        return redirect()->route('admin.preinscritos-rechazados.index')
            ->with('success', 'Registro rechazado actualizado correctamente.');
    }
    
    public function destroy($id)
    {
        $rechazado = PreinscritoRechazado::findOrFail($id);
        $rechazado->delete();
        
        return redirect()->route('admin.preinscritos-rechazados.index')
            ->with('success', 'Registro eliminado correctamente');
    }

    private function getMotivosDisponibles(): array
    {
        return [
            'documento_duplicado',
            'sin_programa_asignado',
            'inconsistencia_programa',
            'datos_incompletos',
            'otro',
        ];
    }
}
