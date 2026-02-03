<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\StoreTipoNovedadRequest;
use App\Http\Requests\UpdateTipoNovedadRequest;
use App\Models\TipoNovedad;
use Illuminate\Http\Request;

class TipoNovedadController extends \Illuminate\Routing\Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $this->authorize('novedad.tipos.admin');

        $query = TipoNovedad::query();

        if ($request->filled('search')) {
            $query->search($request->search);
        }

        if ($request->filled('activo')) {
            $query->where('activo', $request->boolean('activo'));
        }

        $tiposNovedad = $query->orderBy('nombre')->paginate(15);

        return view('admin.novedades.tipos.index', compact('tiposNovedad'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('novedad.tipos.admin');

        return view('admin.novedades.tipos.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTipoNovedadRequest $request)
    {
        $this->authorize('novedad.tipos.admin');

        TipoNovedad::create($request->validated());

        return redirect()->route('tipos-novedad.index')
                       ->with('success', 'Tipo de novedad creado exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(TipoNovedad $tipoNovedad)
    {
        $this->authorize('novedad.tipos.admin');

        return view('admin.novedades.tipos.show', compact('tipoNovedad'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TipoNovedad $tipoNovedad)
    {
        $this->authorize('novedad.tipos.admin');

        return view('admin.novedades.tipos.edit', compact('tipoNovedad'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTipoNovedadRequest $request, TipoNovedad $tipoNovedad)
    {
        $this->authorize('novedad.tipos.admin');

        $tipoNovedad->update($request->validated());

        return redirect()->route('tipos-novedad.index')
                       ->with('success', 'Tipo de novedad actualizado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TipoNovedad $tipoNovedad)
    {
        $this->authorize('novedad.tipos.admin');

        $tipoNovedad->delete();

        return redirect()->route('tipos-novedad.index')
                       ->with('success', 'Tipo de novedad eliminado exitosamente.');
    }
}
