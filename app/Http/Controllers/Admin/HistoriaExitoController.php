<?php

namespace App\Http\Controllers\Admin;

use App\Models\HistoriaExito;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;

class HistoriaExitoController extends \App\Http\Controllers\Controller
{
    use AuthorizesRequests;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('viewAny', HistoriaExito::class);
        $historias = HistoriaExito::all();
        return view('admin.historia_de_exito.index', compact('historias'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('create', HistoriaExito::class);
        return view('admin.historia_de_exito.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->authorize('create', HistoriaExito::class);
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(HistoriaExito $historiaExito)
    {
        $this->authorize('view', $historiaExito);
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(HistoriaExito $historiaExito)
    {
        $this->authorize('update', $historiaExito);
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, HistoriaExito $historiaExito)
    {
        $this->authorize('update', $historiaExito);
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(HistoriaExito $historiaExito)
    {
        $this->authorize('delete', $historiaExito);
        //
    }
}
