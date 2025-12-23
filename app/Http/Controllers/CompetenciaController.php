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
        $competencia = Competencia::all();
        return view('competencia.index', compact('competencia'));
    }

    /**
     * Mostrar el formulario para crear un nuevo recurso.
     */
    public function create()
    {
        return view('competencia.create');
    }

    /**
     * Crear y almacenar un nuevo recurso en almacenamiento.
     */
    public function store(Request $request)
    {
        $competencia = Competencia::create($request->all());
        return redirect()->route('competencia.index');
    }

    /**
     * Desplegar el recurso especificado.
     */
    public function show(competencia $competencia)
    {
        $competencia->find($competencia->id);
        return view('competencia.show', compact('competencia'));
    }

    /**
     * Mostrar el formulario para editar el recurso especificado.
     */
    public function edit(Required $id)
    {
        $competencia = Competencia::find($id);
        return view('competencia.edit', compact('competencia'));
    }

    /**
     * Actualizar el recurso especificado en almacenamiento.
     */
    public function update(Request $request, competencia $competencia)
    {
        //
    }

    /**
     * Remover el recurso especificado de almacenamiento.
     */
    public function destroy(competencia $competencia)
    {
        //
    }
}
