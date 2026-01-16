<?php

namespace App\Http\Controllers;

use App\Models\nivel_formacion;
use App\Models\NivelFormacion;
use Illuminate\Http\Request;

class NivelFormacionController extends Controller
{
    /**
     * Desplegar una lista de los recursos.
     */
    public function index()
    {
        $niveles_formacion = NivelFormacion::all();
        return view('nivel_formacion.index', compact('niveles_formacion'));
    }

    /**
     * Mostrar el formulario para crear un nuevo recurso.
     */
    public function create()
    {
        return view('nivel_formacion.create');
    }

    /**
     * Almacenar un recurso recién creado en almacenamiento.
     */
    public function store(Request $request)
    {
        NivelFormacion::create($request->all());
        return redirect()->route('niveles_formacion.index');
    }

    /**
     * Desplegar el recurso especificado.
     */
    public function show(NivelFormacion $id)
    {
        $nivel_formacion = NivelFormacion::find($id);
        return view('nivel_formacion.show', compact('nivel_formacion'));
    }

    /**
     * Mostrar el formulario para editar el recurso especificado.
     */
    public function edit(NivelFormacion $id)
    {
        $nivel_formacion = NivelFormacion::find($id);
        return view('nivel_formacion.edit', compact('nivel_formacion'))->with('success', 'Nivel de formacion cargado correctamente para editar');
    }

    /**
     * Actualizar el recurso especificado en almacenamiento.
     */
    public function update(Request $request, NivelFormacion $id)
    {
        $id->update($request->all());
        return redirect()->route('nivel_formacion.index')->with('success', 'Nivel de formacion actualizado correctamente');
    }

    /**
     * Remover el recurso especificado de almacenamiento.
     */
    public function destroy(NivelFormacion $id)
    {
        $nivel_formacion = NivelFormacion::find($id);
        $nivel_formacion->delete();
        return redirect()->route('nivel_formacion.index')->with('success', 'Nivel de formacion eliminado correctamente');
    }
}
