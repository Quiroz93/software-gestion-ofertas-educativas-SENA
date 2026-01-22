<?php

namespace App\Http\Controllers;

use App\Models\Red;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class RedController extends Controller
{
    /**
     * Despliega la lista de redes
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        Gate::authorize('redes_conocimiento.view');
        $redes = Red::all();
        return view('redes.index', compact('redes'));
    }

    /**
     * Despliega el formulario para crear una nueva red
     * @return \Illuminate\Contracts\View\View
     */
    public function create()
    {
        Gate::authorize('redes_conocimiento.create');
        return view('redes.create');
    }

    /**
     * Crea una nueva red
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        Gate::authorize('redes_conocimiento.create');
        Red::create($request->all());
        return redirect()->route('redes_conocimiento.index')->with('success', 'Red creada exitosamente');
    }

    /**
     * Despliega los detalles de una red
     * @param Red $red
     * @return \Illuminate\Contracts\View\View
     */
    public function show(Red $red)
    {
        Gate::authorize('redes_conocimiento.show', $red);
        return view('redes.show', compact('red'));
    }

    /**
     * Despliega el formulario para editar una red
     * @param Red $red
     * @return \Illuminate\Contracts\View\View
     */
    public function edit(Red $red)
    {
        Gate::authorize('redes_conocimiento.edit', $red);
        return view('redes.edit', compact('red'));
    }

    /**
     * Actualiza los datos de una red
     * @param Request $request
     * @param Red $red
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Red $red)
    {
        Gate::authorize('redes_conocimiento.edit', $red);
        $red->update($request->all());
        return redirect()->route('redes_conocimiento.index')->with('success', 'Red actualizada exitosamente');
    }

    /**
     * Elimina una red
     * @param Red $red
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Red $red)
    {
        Gate::authorize('redes_conocimiento.delete', $red);
        $red->delete();
        return redirect()->route('redes_conocimiento.index')->with('success', 'Red eliminada exitosamente');
    }
}
