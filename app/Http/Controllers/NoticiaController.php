<?php

namespace App\Http\Controllers;

use App\Models\noticia;
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
        $noticias = Noticia::where('activa', true)
            ->latest()
            ->take(4)
            ->get();

        return view('home', compact('noticias'));
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
     * @param noticia $noticia
     * @return \Illuminate\Contracts\View\View
     */
    public function show(noticia $noticia)
    {
        Gate::authorize('noticias.view', $noticia);
        return view('noticias.show', compact('noticia'));
    }

    /**
     * Despliega el formulario para editar una noticia
     * @param noticia $noticia
     * @return \Illuminate\Contracts\View\View
     */
    public function edit(noticia $noticia)
    {
        Gate::authorize('noticias.update', $noticia);
        return view('noticias.edit', compact('noticia'));
    }

    /**
     * Actualiza una noticia
     * @param Request $request
     * @param noticia $noticia
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, noticia $noticia)
    {
        Gate::authorize('noticias.update', $noticia);
        $noticia->update($request->all());
        return redirect()->route('noticias.index')->with('success', 'Noticia actualizada exitosamente');
    }

    /**
     * Elimina una noticia
     * @param noticia $noticia
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(noticia $noticia)
    {
        Gate::authorize('noticias.delete', $noticia);
        $noticia->delete();
        return redirect()->route('noticias.index')->with('success', 'Noticia eliminada exitosamente');
    }
}
