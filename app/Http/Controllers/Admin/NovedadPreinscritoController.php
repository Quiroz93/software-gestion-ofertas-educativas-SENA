<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\StoreNovedadPreinscritoRequest;
use App\Http\Requests\UpdateNovedadPreinscritoRequest;
use App\Models\NovedadPreinscrito;
use App\Models\Preinscrito;
use App\Models\TipoNovedad;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class NovedadPreinscritoController extends \Illuminate\Routing\Controller
{
    use AuthorizesRequests;
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $this->authorize('preinscritos.novedades.admin');

        $query = NovedadPreinscrito::with(['preinscrito', 'tipoNovedad', 'createdBy'])
                                   ->orderBy('created_at', 'desc');

        if ($request->filled('estado')) {
            $query->byEstado($request->estado);
        }

        if ($request->filled('tipo_novedad_id')) {
            $query->byTipoNovedad($request->tipo_novedad_id);
        }

        if ($request->filled('search')) {
            $query->whereHas('preinscrito', function ($q) use ($request) {
                $q->where('nombres', 'like', "%{$request->search}%")
                  ->orWhere('apellidos', 'like', "%{$request->search}%")
                  ->orWhere('numero_documento', 'like', "%{$request->search}%");
            });
        }

        $novedades = $query->paginate(15);
        $tiposNovedad = TipoNovedad::activos()->orderBy('nombre')->get();
        $estados = NovedadPreinscrito::ESTADOS;

        return view('admin.novedades.index', compact('novedades', 'tiposNovedad', 'estados'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('preinscritos.novedades.admin');

        $tiposNovedad = TipoNovedad::activos()->orderBy('nombre')->get();

        return view('admin.novedades.create', compact('tiposNovedad'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreNovedadPreinscritoRequest $request)
    {
        $this->authorize('preinscritos.novedades.admin');

        $validated = $request->validated();
        $validated['created_by'] = auth()->id();

        NovedadPreinscrito::create($validated);

        return redirect()->route('novedades.index')
                       ->with('success', 'Novedad creada exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(NovedadPreinscrito $novedad)
    {
        $this->authorize('preinscritos.novedades.admin');

        $novedad->load(['preinscrito', 'tipoNovedad', 'createdBy', 'updatedBy', 'historial.changedBy']);

        return view('admin.novedades.show', compact('novedad'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(NovedadPreinscrito $novedad)
    {
        $this->authorize('preinscritos.novedades.admin');

        $tiposNovedad = TipoNovedad::activos()->orderBy('nombre')->get();
        $estados = NovedadPreinscrito::ESTADOS;

        return view('admin.novedades.edit', compact('novedad', 'tiposNovedad', 'estados'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateNovedadPreinscritoRequest $request, NovedadPreinscrito $novedad)
    {
        $this->authorize('preinscritos.novedades.admin');

        $validated = $request->validated();
        $validated['updated_by'] = auth()->id();

        // Si cambió el estado, registrar en historial
        if ($validated['estado'] !== $novedad->estado) {
            $comentario = $request->input('comentario_cambio', null);
            $novedad->cambiarEstado($validated['estado'], $comentario, auth()->id());
            unset($validated['estado']);
        }

        $novedad->update($validated);

        return redirect()->route('novedades.show', $novedad)
                       ->with('success', 'Novedad actualizada exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(NovedadPreinscrito $novedad)
    {
        $this->authorize('preinscritos.novedades.admin');

        $novedad->delete();

        return redirect()->route('novedades.index')
                       ->with('success', 'Novedad eliminada exitosamente.');
    }

    /**
     * Cambiar estado de una novedad
     */
    public function cambiarEstado(Request $request, NovedadPreinscrito $novedad)
    {
        $this->authorize('preinscritos.novedades.admin');

        $request->validate([
            'estado' => 'required|in:abierta,en_gestion,resuelta,cancelada',
            'comentario' => 'nullable|string|max:1000',
        ]);

        $novedad->cambiarEstado(
            $request->estado,
            $request->comentario,
            auth()->id()
        );

        return redirect()->back()
                       ->with('success', 'Estado actualizado exitosamente.');
    }

    /**
     * Listar novedades de un preinscrito específico (desde el show)
     */
    public function porPreinscrito(Preinscrito $preinscrito)
    {
        $this->authorize('preinscritos.novedades.admin');

        $novedades = $preinscrito->novedades()
                                 ->with(['tipoNovedad', 'createdBy', 'historial'])
                                 ->orderBy('created_at', 'desc')
                                 ->get();

        return view('admin.novedades.por-preinscrito', compact('preinscrito', 'novedades'));
    }
}
