<?php

namespace App\Http\Controllers\Admin;

use App\Models\Municipio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class MunicipioController extends \App\Http\Controllers\Controller
{
    /**
     * Despliega la lista de municipios
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        Gate::authorize('municipios.view');
        $municipios = Municipio::orderBy('departamento')->orderBy('nombre')->get();
        return view('admin.municipios.index', compact('municipios'));
    }

    /**
     * Despliega el formulario para crear un nuevo municipio
     * @return \Illuminate\Contracts\View\View
     */
    public function create()
    {
        Gate::authorize('municipios.create');
        return view('admin.municipios.create');
    }

    /**
     * Crea un nuevo municipio
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        Gate::authorize('municipios.create');
        
        $data = $request->validate([
            'nombre' => 'required|string|max:255',
            'codigo' => 'required|string|max:50|unique:municipios,codigo',
            'departamento' => 'nullable|string|max:255',
        ]);

        Municipio::create($data);

        return redirect()->route('municipios.index')->with('success', 'Municipio creado exitosamente');
    }

    /**
     * Despliega los detalles de un municipio
     * @param Municipio $municipio
     * @return \Illuminate\Contracts\View\View
     */
    public function show(Municipio $municipio)
    {
        Gate::authorize('municipios.show', $municipio);
        return view('admin.municipios.show', compact('municipio'));
    }

    /**
     * Despliega el formulario para editar un municipio
     * @param Municipio $municipio
     * @return \Illuminate\Contracts\View\View
     */
    public function edit(Municipio $municipio)
    {
        Gate::authorize('municipios.edit', $municipio);
        return view('admin.municipios.edit', compact('municipio'));
    }

    /**
     * Actualiza un municipio
     * @param Request $request
     * @param Municipio $municipio
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Municipio $municipio)
    {
        Gate::authorize('municipios.edit', $municipio);
        
        $data = $request->validate([
            'nombre' => 'required|string|max:255',
            'codigo' => 'required|string|max:50|unique:municipios,codigo,' . $municipio->id,
            'departamento' => 'nullable|string|max:255',
        ]);

        $municipio->update($data);

        return redirect()->route('municipios.index')->with('success', 'Municipio actualizado exitosamente');
    }

    /**
     * Elimina un municipio
     * @param Municipio $municipio
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Municipio $municipio)
    {
        Gate::authorize('municipios.delete', $municipio);
        
        // Verificar si hay programas asociados
        if ($municipio->programas()->count() > 0) {
            return redirect()->route('municipios.index')
                ->with('error', 'No se puede eliminar el municipio porque tiene programas asociados');
        }
        
        $municipio->delete();
        
        return redirect()->route('municipios.index')->with('success', 'Municipio eliminado exitosamente');
    }
}
