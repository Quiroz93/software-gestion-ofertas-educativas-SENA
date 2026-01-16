<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use App\Models\Centro;
use Illuminate\Support\Facades\Gate;

class CentroController extends Controller
{
    use AuthorizesRequests;

    /**
     * Despliega una lista de recursos
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        Gate::authorize("viewAny", Centro::class);
        $centros = Centro::all();
        return view('centro.index', compact('centros'));
    }

    /**
     * Despliega el formulario para crear un nuevo recurso
     * @return \Illuminate\Contracts\View\View
     */
    public function create()
    {
        Gate::authorize('centros.create', Centro::class);
            return view('centro.create');
    }

    /**
     * Crea y almacena un nuevo recurso en almacenamiento
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        Gate::authorize('centros.create', Centro::class);
        $data = $request->validate([
            'nombre' => 'required|string|max:255',
            'direccion' => 'required|string|max:255',
            'telefono' => 'required|string|max:20',
            'correo' => 'required|email|max:255',
        ]);
        Centro::create($data);
        return redirect()->route('centro.index')->with('success','Elemento creado con exito');
    }

    /**
     * Despliega el recurso especificado
     * @param Centro $centro
     * @return \Illuminate\Contracts\View\View
     */
    public function show(Centro $centro)
    {
        Gate::authorize('centros.view', $centro);
        return view('centro.show', compact('centro'));
    }

    /**
     * Despliega el formulario para editar el recurso especificado
     * @param string $id
     * @return \Illuminate\Contracts\View\View
     */
    public function edit(string $id)
    {
        Gate::authorize('centros.update', $id);
        $centro = Centro::findOrFail($id);
        return view('centro.edit', compact('centro'));
    }

    /**
     * Actualiza el recurso especificado en almacenamiento
     * @param Request $request
     * @param string $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, string $id)
    {
        Gate::authorize('centros.update', $id);
        $centro = Centro::findOrFail($id);
        $data = $request->validate([
            'nombre' => 'required|string|max:255',
            'direccion' => 'required|string|max:255',
            'telefono' => 'required|string|max:20',
            'correo' => 'required|email|max:255',
        ]);
        $centro->update($data);
        return redirect()->route('centro.index')->with('success','Elemento actualizado con exito');
    }

    /**
     * Elimina el recurso especificado de almacenamiento
     * @param Centro $centro
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Centro $centro)
    {
        Gate::authorize('centros.delete', $centro);
        $centro->delete();
        return redirect()->route('centro.index')->with('success','Elemento eliminado con exito');
    }
}
