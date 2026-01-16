<?php

namespace App\Http\Controllers;

use App\Models\nivel_formacion;
use App\Models\NivelFormacion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;



class NivelFormacionController extends Controller
{
    /**
     * Despliega una lista de recursos
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        Gate::authorize('niveles_formacion.view', NivelFormacion::class);
        $niveles_formacion = NivelFormacion::all();
        return view('nivel_formacion.index', compact('niveles_formacion'));
    }

    /**
     * Despliega el formulario para crear un nuevo recurso
     * @return \Illuminate\Contracts\View\View
     */
    public function create()
    {
        Gate::authorize('niveles_formacion.create', NivelFormacion::class);
        return view('nivel_formacion.create');
    }

    /**
     * Crea un nuevo recurso
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        Gate::authorize('niveles_formacion.create', NivelFormacion::class);
        NivelFormacion::create($request->all());
        return redirect()->route('niveles_formacion.index')->with('success', 'Nivel de formacion creado correctamente');
    }

    /**
     * Despliega el recurso especificado
     * @param NivelFormacion $id
     * @return \Illuminate\Contracts\View\View
     */
    public function show(NivelFormacion $id)
    {
        Gate::authorize('niveles_formacion.view', $id);
        $nivel_formacion = NivelFormacion::find($id);
        return view('nivel_formacion.show', compact('nivel_formacion'));
    }

    /**
     * Despliega el formulario para editar el recurso especificado
     * @param NivelFormacion $id
     * @return \Illuminate\Contracts\View\View
     */
    public function edit(NivelFormacion $id)
    {
        Gate::authorize('niveles_formacion.update', $id);
        $nivel_formacion = NivelFormacion::find($id);
        return view('nivel_formacion.edit', compact('nivel_formacion'))->with('success', 'Nivel de formacion cargado correctamente para editar');
    }

    /**
     * Actualiza el recurso especificado en almacenamiento
     * @param Request $request
     * @param NivelFormacion $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, NivelFormacion $id)
    {
        Gate::authorize('niveles_formacion.update', $id);
        $id->update($request->all());
        return redirect()->route('niveles_formacion.index')->with('success', 'Nivel de formacion actualizado correctamente');
    }

    /**
     * Elimina el recurso especificado de almacenamiento
     * @param NivelFormacion $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(NivelFormacion $id)
    {
        Gate::authorize('niveles_formacion.delete', $id);
        $nivel_formacion = NivelFormacion::find($id);
        $nivel_formacion->delete();
        return redirect()->route('niveles_formacion.index')->with('success', 'Nivel de formacion eliminado correctamente');
    }
}
