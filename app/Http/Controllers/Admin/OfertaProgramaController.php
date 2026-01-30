<?php

namespace App\Http\Controllers\Admin;

use App\Models\OfertaPrograma;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class OfertaProgramaController extends \App\Http\Controllers\Controller
{
    /**
     * Despliega la lista de ofertas de programa
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        Gate::authorize('ofertasProgramas.view', OfertaPrograma::class);
        $ofertasProgramas = OfertaPrograma::all();
        return view('admin.ofertasProgramas.index', compact('ofertasProgramas'));
    }

    /**
     * Despliega el formulario para crear una nueva oferta de programa
     * @return \Illuminate\Contracts\View\View
     */
    public function create()
    {
        Gate::authorize('ofertasProgramas.create', OfertaPrograma::class);
        return view('admin.ofertasProgramas.create');
    }

    /**
     * Crea una nueva oferta de programa
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        Gate::authorize('ofertasProgramas.create', OfertaPrograma::class);
        OfertaPrograma::create($request->all());
        return redirect()->route('ofertasProgramas.index')->with('success', 'Oferta Programa creada exitosamente');
    }

    /**
     * Despliega los detalles de una oferta de programa
     * @param OfertaPrograma $ofertaPrograma
     * @return \Illuminate\Contracts\View\View
     */
    public function show(OfertaPrograma $ofertaPrograma)
    {
        Gate::authorize('ofertasProgramas.view', $ofertaPrograma);
        return view('admin.ofertasProgramas.show', compact('ofertaPrograma'));
    }

    /**
     * Despliega el formulario para editar una oferta de programa
     * @param OfertaPrograma $ofertaPrograma
     * @return \Illuminate\Contracts\View\View
     */
    public function edit(OfertaPrograma $ofertaPrograma)
    {
        Gate::authorize('ofertasProgramas.update', $ofertaPrograma);
        return view('admin.ofertasProgramas.edit', compact('ofertaPrograma'));
    }

    /**
     * Actualiza una oferta de programa
     * @param Request $request
     * @param OfertaPrograma $ofertaPrograma
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, OfertaPrograma $ofertaPrograma)
    {
        Gate::authorize('ofertasProgramas.update', $ofertaPrograma);
        $ofertaPrograma->update($request->all());
        return redirect()->route('ofertasProgramas.index')->with('success', 'Oferta Programa actualizada exitosamente');
    }

    /**
     * Elimina una oferta de programa
     * @param OfertaPrograma $ofertaPrograma
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(OfertaPrograma $ofertaPrograma)
    {
        Gate::authorize('ofertasProgramas.delete', $ofertaPrograma);
        $ofertaPrograma->delete();
        return redirect()->route('ofertasProgramas.index')->with('success', 'Oferta Programa eliminada exitosamente');
    }
}
