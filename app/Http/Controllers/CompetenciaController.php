<?php

namespace App\Http\Controllers;

use App\Models\competencia;
use Illuminate\Http\Request;
use Symfony\Contracts\Service\Attribute\Required;

class CompetenciaController extends Controller
{
    /**
     * Desplegar una lista de los recursos.
     */
    public function index()
    {
        $competencias = Competencia::all();
        return view('competencias.index', compact('competencias'));
    }

    /**
     * Mostrar el formulario para crear un nuevo recurso.
     */
    public function create()
    {
        return view('competencias.create');
    }

    /**
     * Crear y almacenar un nuevo recurso en almacenamiento.
     */
    public function store(Request $request)
    {
        $competencia = Competencia::create($request->all());
        return redirect()->route('competencias.index')->with('success', 'Competencia creada correctamente');
    }

    /**
     * Desplegar el recurso especificado.
     */
    public function show(competencia $competencia)
    {
        $competencia->find($competencia->id);
        return view('competencias.show', compact('competencia'));
    }

    /**
     * Mostrar el formulario para editar el recurso especificado.
     */
    public function edit(Required $id)
    {
        $competencia = Competencia::find($id);
        return view('competencias.edit', compact('competencia'))->with('success', 'Competencia cargada correctamente para editar');
    }

    /**
     * Actualizar el recurso especificado en almacenamiento.
     */
    public function update(Request $request, competencia $id)
    {
        $id->update($request->all());
        return redirect()->route('competencias.index')->with('success', 'Competencia actualizada correctamente');
    }

    /**
     * Remover el recurso especificado de almacenamiento.
     */
    public function destroy(competencia $id)
    {
        $competencia = Competencia::find($id);
        $competencia->delete();
        return redirect()->route('competencias.index')->with('success', 'Competencia eliminada correctamente');
    }
}
