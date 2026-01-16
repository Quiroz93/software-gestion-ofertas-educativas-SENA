<?php

namespace App\Http\Controllers;

use App\Models\HistoriaExito;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class HistoriaExitoController extends Controller
{
    /**
     * Despliega la lista de recursos
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        Gate::authorize('viewAny', HistoriaExito::class);
        $historias = HistoriaExito::all();
        return view('historia_de_exito.index', compact('historias'));
    }

    /**
     * Despliega el formulario para crear un nuevo recurso
     * @return \Illuminate\Contracts\View\View
     */
    public function create()
    {
        Gate::authorize('historias_exito.create', HistoriaExito::class);
        return view('historia_de_exito.create');
    }

    /**
     * Almacena un recurso recién creado en almacenamiento
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        Gate::authorize('historias_exito.create', HistoriaExito::class);
        HistoriaExito::create($request->all());
        return redirect()->route('historias_de_exito.index')->with('success', 'Historia de éxito creada exitosamente');
    }

    /**
     * Despliega el recurso especificado
     * @param HistoriaExito $historiaExito
     * @return \Illuminate\Contracts\View\View
     */
    public function show(HistoriaExito $historiaExito)
    {
        Gate::authorize('historias_exito.view', $historiaExito);
        return view('historia_de_exito.show', compact('historiaExito'));
    }

    /**
     * Despliega el formulario para editar el recurso especificado
     * @param HistoriaExito $historiaExito
     * @return \Illuminate\Contracts\View\View
     */
    public function edit(HistoriaExito $historiaExito)
    {
        Gate::authorize('historias_exito.update', $historiaExito);
        return view('historia_de_exito.edit', compact('historiaExito'));
    }

    /**
     * Actualiza el recurso especificado en almacenamiento
     * @param Request $request
     * @param HistoriaExito $historiaExito
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, HistoriaExito $historiaExito)
    {
        Gate::authorize('historias_exito.update', $historiaExito);
        $historiaExito->update($request->all());
        return redirect()->route('historias_de_exito.index')->with('success', 'Historia de éxito actualizada exitosamente');
    }

    /**
     * Elimina el recurso especificado de almacenamiento
     * @param HistoriaExito $historiaExito
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(HistoriaExito $historiaExito)
    {
        Gate::authorize('historias_exito.delete', $historiaExito);
        $historiaExito->delete();
        return redirect()->route('historias_de_exito.index')->with('success', 'Historia de éxito eliminada exitosamente');
    }
}
