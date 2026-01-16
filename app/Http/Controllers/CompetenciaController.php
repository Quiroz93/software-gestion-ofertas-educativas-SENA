<?php

namespace App\Http\Controllers;

use App\Models\competencia;
use Illuminate\Http\Request;
use Symfony\Contracts\Service\Attribute\Required;
use Illuminate\Support\Facades\Gate;

class CompetenciaController extends Controller
{
    /**
     * Despliega una lista de recursos
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        Gate::authorize("viewAny", Competencia::class);
        $competencias = Competencia::all();
        return view('competencias.index', compact('competencias'));
    }

    /**
     * Despliega el formulario para crear un nuevo recurso
     * @return \Illuminate\Contracts\View\View
     */
    public function create()
    {
        Gate::authorize('competencias.create', Competencia::class);
        return view('competencias.create');
    }

    /**
     * Crea y almacena un nuevo recurso en almacenamiento
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        Gate::authorize('competencias.create', Competencia::class);
        $competencia = Competencia::create($request->all());
        return redirect()->route('competencias.index')->with('success', 'Competencia creada correctamente');
    }

    /**
     * Despliega el recurso especificado
     * @param competencia $competencia
     * @return \Illuminate\Contracts\View\View
     */
    public function show(competencia $competencia)
    {
        Gate::authorize('competencias.view', $competencia);
        $competencia->find($competencia->id);
        return view('competencias.show', compact('competencia'));
    }

    /**
     * Despliega el formulario para editar el recurso especificado
     * @param Required $id
     * @return \Illuminate\Contracts\View\View
     */
    public function edit(Required $id)
    {
        Gate::authorize('competencias.update', $id);
        $competencia = Competencia::find($id);
        return view('competencias.edit', compact('competencia'))->with('success', 'Competencia cargada correctamente para editar');
    }

    /**
     * Actualiza el recurso especificado en almacenamiento
     * @param Request $request
     * @param competencia $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, competencia $id)
    {
        Gate::authorize('competencias.update', $id);
        $id->update($request->all());
        return redirect()->route('competencias.index')->with('success', 'Competencia actualizada correctamente');
    }

    /**
     * Elimina el recurso especificado de almacenamiento
     * @param competencia $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(competencia $id)
    {
        Gate::authorize('competencias.delete', $id);
        $competencia = Competencia::find($id);
        $competencia->delete();
        return redirect()->route('competencias.index')->with('success', 'Competencia eliminada correctamente');
    }
}
