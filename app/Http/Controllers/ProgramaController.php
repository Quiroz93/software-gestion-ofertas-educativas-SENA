<?php

namespace App\Http\Controllers;

use App\Models\NivelFormacion;
use App\Models\Programa;
use App\Models\Red;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class ProgramaController extends Controller
{
    /**
     * Despliega la lista de programas
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        Gate::authorize('programas.view');
        $programas = Programa::all();
        return view('programas.index', compact('programas'));
    }

    /**
     * Despliega el formulario para crear un nuevo programa
     * @return \Illuminate\Contracts\View\View
     */
    public function create()
    {
        Gate::authorize('programas.create');
        $redes = Red::all();
        $nivelFormacion = NivelFormacion::all();
        return view('programas.create', compact('redes', 'nivelFormacion'));
    }

    /**
     * Crea un nuevo programa
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        Gate::authorize('programas.create');
        Programa::create($request->all());
        return redirect()->route('programas.index')->with('success', 'Programa creado exitosamente');
    }

    /**
     * Despliega los detalles de un programa
     * @param Programa $programa
     * @return \Illuminate\Contracts\View\View
     */
    public function show(Programa $programa)
    {
        Gate::authorize('programas.show', $programa);
        return view('programas.show', compact('programa'));
    }

    /**
     * Despliega el formulario para editar un programa
     * @param Programa $programa
     * @return \Illuminate\Contracts\View\View
     */
    public function edit(Programa $programa)
    {
        Gate::authorize('programas.edit', $programa);
        return view('programas.edit', compact('programa'));
    }

    /**
     * Actualiza un programa
     * @param Request $request
     * @param Programa $programa
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Programa $programa)
    {
        Gate::authorize('programas.edit', $programa);
        $programa->update($request->all());
        return redirect()->route('programas.index')->with('success', 'Programa actualizado exitosamente');
    }

    /**
     * Elimina un programa
     * @param Programa $programa
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Programa $programa)
    {
        Gate::authorize('programas.delete', $programa);
        $programa->delete();
        return redirect()->route('programas.index')->with('success', 'Programa eliminado exitosamente');
    }
}
