<?php

namespace App\Http\Controllers;

use App\Models\centro;
use Illuminate\Http\Request;

class CentroController extends Controller
{
    /**
     * Desplegar una lista de los recursos.
     */
    public function index()
    {
        $centro = Centro::all();
        return view('centros.index', compact('centro'));
    }

    /**
     * Mostrar el formulario para crear un nuevo recurso.
     */
    public function create()
    {
            return view('centro.create');
    }

    /**
     * Crear y almacenar un nuevo recurso en almacenamiento.
     */
    public function store(Request $request)
    {
        $centro = Centro::create($request->all());
        return redirect()->route('centro.index');
    }

    /**
     * Desplegar el recurso especificado.
     */
    public function show(centro $centro)
    {
        $centro->find($centro->id);
        return view('centro.show', compact('centro'));
    }

    /**
     * Mostrar el formulario para editar el recurso especificado.
     */
    public function edit(centro $centro)
    {
        $centro->find($centro->id);
        return view('centro.edit', compact('centro'));
    }

    /**
     * Actualizar el recurso especificado en almacenamiento.
     */
    public function update(Request $request, centro $id)
    {
        $id->update($request->all());
        return redirect()->route('centro.index');
    }

    /**
     * Remover el recurso especificado de almacenamiento.
     */
    public function destroy(centro $centro)
    {
        $centro::find($centro->id)->delete();
        return redirect()->route('centro.index');
    }
}
