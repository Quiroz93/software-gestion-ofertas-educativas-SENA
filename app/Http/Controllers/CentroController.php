<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use App\Models\Centro;
use App\Models\centro as ModelsCentro;

class CentroController extends Controller
{
    use AuthorizesRequests;

    /**
     * Desplegar una lista de los recursos.
     */
    public function index()
    {
        $this->authorize("viewAny", Centro::class);
        $centros = Centro::all();
        return view('centro.index', compact('centros'));
    }

    /**
     * Mostrar el formulario para crear un nuevo recurso.
     */
    public function create()
    {
        $this->authorize('create', Centro::class);
            return view('centro.create');
    }

    /**
     * Crear y almacenar un nuevo recurso en almacenamiento.
     */
    public function store(Request $request)
    {
        $this->authorize('create', Centro::class);
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
     * Desplegar el recurso especificado.
     */
    public function show(Centro $centro)
    {
        $this->authorize('view', $centro);
        return view('centro.show', compact('centro'));
    }

    /**
     * Mostrar el formulario para editar el recurso especificado.
     */
    public function edit(Centro $centro)
    {
        $this->authorize('update', $centro);
        return view('centro.edit', compact('centro'));
    }

    /**
     * Actualizar el recurso especificado en almacenamiento.
     */
    public function update(Request $request, Centro $centro)
    {
        $this->authorize('update', $centro);
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
     * Remover el recurso especificado de almacenamiento.
     */
    public function destroy(Centro $centro)
    {
        $this->authorize('delete', $centro);
        $centro->delete();
        return redirect()->route('centro.index')->with('success','Elemento eliminado con exito');
    }
}
