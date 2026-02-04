<?php

namespace App\Http\Controllers\Admin;

use App\Models\Oferta;
use App\Models\Centro;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;

class OfertaController extends \App\Http\Controllers\Controller
{
     /**
     * Despliega la lista de ofertas
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        Gate::authorize('ofertas.view', Oferta::class);
        $ofertas = Oferta::all();
        return view('admin.ofertas.index', compact('ofertas'));
    }

    /**
     * Despliega el formulario para crear una nueva oferta
     * @return \Illuminate\Contracts\View\View
     */
    public function create()
    {
        Gate::authorize('ofertas.create', Oferta::class);
        $centros = Centro::all();
        return view('admin.ofertas.create', compact('centros'));
    }

     /**
     * Crea una nueva oferta
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        Gate::authorize('ofertas.create', Oferta::class);
        Oferta::create($request->all());
        return redirect()->route('ofertas.index')->with('success', 'Oferta creada exitosamente');
    }

    /**
     * Despliega los detalles de una oferta
     * @param Oferta $oferta
     * @return \Illuminate\Contracts\View\View
     */
    public function show(Oferta $oferta)
    {
        Gate::authorize('ofertas.view', $oferta);
        return view('admin.ofertas.show', compact('oferta'));
    }

    /**
     * Despliega el formulario para editar una oferta
     * @param Oferta $oferta
     * @return \Illuminate\Contracts\View\View
     */
    public function edit(Oferta $oferta)
    {
        Gate::authorize('ofertas.update', $oferta);
        $centros = Centro::all();
        return view('admin.ofertas.edit', compact('oferta', 'centros'));
    }

    /**
     * Actualiza una oferta
     * @param Request $request
     * @param Oferta $oferta
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Oferta $oferta)
    {
        Gate::authorize('ofertas.update', $oferta);
        $oferta->update($request->all());
        return redirect()->route('ofertas.index')->with('success', 'Oferta actualizada exitosamente');
    }

     /**
     * Despliega el formulario para eliminar una oferta
     * @param Oferta $oferta
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Oferta $oferta)
    {
        Gate::authorize('ofertas.delete', $oferta);

        // Verificar si la oferta tiene ofertas de programa asociadas
        if ($oferta->ofertasProgramas()->count() > 0) {
            return redirect()->route('ofertas.index')->with('error', 'No se puede eliminar la oferta porque tiene ofertas de programa asociadas');
        }

        $oferta->delete();
        return redirect()->route('ofertas.index')->with('success', 'Oferta eliminada exitosamente');
    }
}

