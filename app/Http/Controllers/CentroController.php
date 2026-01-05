<?php

namespace App\Http\Controllers;

use App\Models\centro;
use Illuminate\Http\Request;
use Psy\Util\Str;
use Symfony\Contracts\Service\Attribute\Required;

class CentroController extends Controller
{
    /**
     * Desplegar una lista de los recursos.
     */
    public function index()
    {
        $centros = Centro::all();
        return view('centro.index', compact('centros'));
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
        Centro::create($request->all());
        return redirect()->route('centro.index')->with('success','Elemento creado con exito');
    }

    /**
     * Desplegar el recurso especificado.
     */
    public function show(String $id)
    {
        $centro = Centro::find($id);
        return view('centro.show', compact('centro'));
    }

    /**
     * Mostrar el formulario para editar el recurso especificado.
     */
    public function edit(string $id)
    {
        $centro = Centro::find($id);
        return view('centro.edit', compact('centro'))->with('success','Elemento editado con exito');
    }

    /**
     * Actualizar el recurso especificado en almacenamiento.
     */
    public function update(Request $request, String $id)
    {
        $centro = Centro::find($id);
        $centro->update($request->all());
        return redirect()->route('centro.index')->with('success','Elemento actualizado con exito');
    }

    /**
     * Remover el recurso especificado de almacenamiento.
     */
    public function destroy(String $id)
    {
        $centro = Centro::find($id);
        $centro->delete();
        return redirect()->route('centro.index')->with('success','Elemento eliminado con exito');
    }
}
