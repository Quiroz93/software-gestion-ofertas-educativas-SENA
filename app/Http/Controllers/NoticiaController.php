<?php

namespace App\Http\Controllers;

use App\Models\Noticia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class NoticiaController extends Controller
{
    /**
     * Despliega una lista de recursos
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        Gate::authorize('noticias.view', Noticia::class);
        $noticias = Noticia::latest()->get();

        return view('noticias.index', compact('noticias'));
    }


    /**
     * Despliega el formulario para crear una nueva noticia
     * @return \Illuminate\Contracts\View\View  
     */
    public function create()
    {
        Gate::authorize('noticias.create', Noticia::class);
        return view('noticias.create');
    }

    /**
     * Crea una nueva noticia
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        Gate::authorize('noticias.create', Noticia::class);
        Noticia::create($request->all());
        return redirect()->route('noticias.index')->with('success', 'Noticia creada exitosamente');
    }

    /**
     * Despliega los detalles de una noticia
     * @param Noticia $noticia
     * @return \Illuminate\Contracts\View\View
     */
    public function show(Noticia $noticia)
    {
        Gate::authorize('noticias.view', $noticia);
        return view('noticias.show', compact('noticia'));
    }

    /**
     * Despliega el formulario para editar una noticia
     * @param Noticia $noticia
     * @return \Illuminate\Contracts\View\View
     */
    public function edit(Noticia $noticia)
    {
        Gate::authorize('noticias.update', $noticia);
        return view('noticias.edit', compact('noticia'));
    }

    /**
     * Actualiza una noticia
     * @param Request $request
     * @param Noticia $noticia
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Noticia $noticia)
    {
        Gate::authorize('noticias.update', $noticia);
        $noticia->update($request->all());
        return redirect()->route('noticias.index')->with('success', 'Noticia actualizada exitosamente');
    }

    /**
     * Elimina una noticia
     * @param Noticia $noticia
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Noticia $noticia)
    {
        Gate::authorize('noticias.delete', $noticia);
        $noticia->delete();
        return redirect()->route('noticias.index')->with('success', 'Noticia eliminada exitosamente');
    }
}
