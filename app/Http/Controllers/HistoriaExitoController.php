<?php

namespace App\Http\Controllers;

use App\Models\HistoriaExito;
use Illuminate\Http\Request;

class HistoriaExitoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $historias = HistoriaExito::all();
        return view('historia_de_exito.index', compact('historias'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(HistoriaExito $historiaExito)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(HistoriaExito $historiaExito)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, HistoriaExito $historiaExito)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(HistoriaExito $historiaExito)
    {
        //
    }
}
