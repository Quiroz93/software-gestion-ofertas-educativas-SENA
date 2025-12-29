<?php

namespace App\Http\Controllers;

use App\Models\nivel_formacion;
use Illuminate\Http\Request;

class NivelFormacionController extends Controller
{
    /**
     * Desplegar una lista de los recursos.
     */
    public function index()
    {
        $nivel_formacion = nivel_formacion::all();
        return view('nivel_formacion.index', compact('nivel_formacion'));
    }

    /**
     * Mostrar el formulario para crear un nuevo recurso.
     */
    public function create()
    {
        return view('nivel_formacion.create');
    }

    /**
     * Mostrar el formulario para crear un nuevo recurso.
     */
    public function store(Request $request)
    {
        nivel_formacion::create($request->all());
        return redirect()->route('nivel_formacion.index');
    }

    /**
     * Desplegar el recurso especificado.
     */
    public function show(nivel_formacion $id)
    {
        $nivel_formacion = nivel_formacion::find($id);
        return view('nivel_formacion.show', compact('nivel_formacion'));
    }

    /**
     * Mostrar el formulario para editar el recurso especificado.
     */
    public function edit(nivel_formacion $id)
    {
        $nivel_formacion = nivel_formacion::find($id);
        return view('nivel_formacion.edit', compact('nivel_formacion'))->with('success', 'Nivel de formacion cargado correctamente para editar');
    }

    /**
     * Actualizar el recurso especificado en almacenamiento.
     */
    public function update(Request $request, nivel_formacion $id)
    {
        $id->update($request->all());
        return redirect()->route('nivel_formacion.index')->with('success', 'Nivel de formacion actualizado correctamente');
    }

    /**
     * Remover el recurso especificado de almacenamiento.
     */
    public function destroy(nivel_formacion $id)
    {
        $nivel_formacion = nivel_formacion::find($id);
        $nivel_formacion->delete();
        return redirect()->route('nivel_formacion.index')->with('success', 'Nivel de formacion eliminado correctamente');
    }
}
