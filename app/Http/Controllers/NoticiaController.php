<?php

namespace App\Http\Controllers;

use App\Models\noticia;
use Illuminate\Http\Request;

class NoticiaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $noticias = Noticia::where('activa', true)
            ->latest()
            ->take(4)
            ->get();

        return view('home', compact('noticias'));
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
    public function show(noticia $noticia)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(noticia $noticia)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, noticia $noticia)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(noticia $noticia)
    {
        //
    }
}
