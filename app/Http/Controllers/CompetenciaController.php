<?php

namespace App\Http\Controllers;

use App\Models\Competencia;
use Illuminate\Http\Request;
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
     * @param Competencia $competencia
     * @return \Illuminate\Contracts\View\View
     */
    public function show(Competencia $competencia)
    {
        Gate::authorize('competencias.view', $competencia);
        return view('competencias.show', compact('competencia'));
    }

    /**
     * Despliega el formulario para editar el recurso especificado
     * @param Competencia $competencia
     * @return \Illuminate\Contracts\View\View
     */
    public function edit(Competencia $competencia)
    {
        Gate::authorize('competencias.update', $competencia);
        return view('competencias.edit', compact('competencia'));
    }

    /**
     * Actualiza el recurso especificado en almacenamiento
     * @param Request $request
     * @param Competencia $competencia
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Competencia $competencia)
    {
        Gate::authorize('competencias.update', $competencia);
        $competencia->update($request->all());
        return redirect()->route('competencias.index')->with('success', 'Competencia actualizada correctamente');
    }

    /**
     * Elimina el recurso especificado de almacenamiento
     * @param Competencia $competencia
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Competencia $competencia)
    {
        Gate::authorize('competencias.delete', $competencia);
        $competencia->delete();
        return redirect()->route('competencias.index')->with('success', 'Competencia eliminada correctamente');
    }
}
