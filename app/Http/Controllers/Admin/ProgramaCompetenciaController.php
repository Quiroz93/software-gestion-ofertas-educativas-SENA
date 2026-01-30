<?php

namespace App\Http\Controllers\Admin;

use App\Models\ProgramaCompetencia;
use Illuminate\Http\Request;

class ProgramaCompetenciaController extends \App\Http\Controllers\Controller
{
    /**
     * Despliega la lista de programas competencias
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        $programasCompetencias = ProgramaCompetencia::all();
        return view('admin.programasCompetencias.index', compact('programasCompetencias'));
    }

    /**
     * Despliega el formulario para crear un programa competencia
     * @return \Illuminate\Contracts\View\View
     */
    public function create()
    {
        return view('admin.programasCompetencias.create');
    }

    /**
     * Crea un programa competencia
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        ProgramaCompetencia::create($request->all());
        return redirect()->route('programasCompetencias.index')->with('success', 'Programa Competencia creada exitosamente');
    }

    /**
     * Despliega los detalles de un programa competencia
     * @param ProgramaCompetencia $programaCompetencia
     * @return \Illuminate\Contracts\View\View
     */
    public function show(ProgramaCompetencia $programaCompetencia)
    {
        return view('admin.programasCompetencias.show', compact('programaCompetencia'));
    }

    /**
     * Despliega el formulario para editar un programa competencia
     * @param ProgramaCompetencia $programaCompetencia
     * @return \Illuminate\Contracts\View\View
     */
    public function edit(ProgramaCompetencia $programaCompetencia)
    {
        return view('admin.programasCompetencias.edit', compact('programaCompetencia'));
    }

    /**
     * Actualiza un programa competencia
     * @param Request $request
     * @param ProgramaCompetencia $programaCompetencia
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, ProgramaCompetencia $programaCompetencia)
    {
        $programaCompetencia->update($request->all());
        return redirect()->route('programasCompetencias.index')->with('success', 'Programa Competencia actualizada exitosamente');
    }

    /**
     * Elimina un programa competencia
     * @param ProgramaCompetencia $programaCompetencia
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(ProgramaCompetencia $programaCompetencia)
    {
        $programaCompetencia->delete();
        return redirect()->route('programasCompetencias.index')->with('success', 'Programa Competencia eliminada exitosamente');
    }
}
