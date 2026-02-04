<?php

namespace App\Http\Controllers\Admin;

use App\Models\Noticia;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class NoticiaController extends \App\Http\Controllers\Controller
{
    use AuthorizesRequests;
    /**
     * Despliega una lista de recursos
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        $this->authorize('viewAny', Noticia::class);
        $noticias = Noticia::latest()->get();

        return view('admin.noticias.index', compact('noticias'));
    }


    /**
     * Despliega el formulario para crear una nueva noticia
     * @return \Illuminate\Contracts\View\View  
     */
    public function create()
    {
        $this->authorize('create', Noticia::class);
        return view('admin.noticias.create');
    }

    /**
     * Crea una nueva noticia
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $this->authorize('create', Noticia::class);
        
        $validated = $request->validate([
            'titulo' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'activa' => 'boolean',
        ]);

        // Manejo de la imagen
        if ($request->hasFile('imagen')) {
            $validated['imagen'] = $request->file('imagen')->store('noticias', 'public');
        }

        $validated['activa'] = $request->has('activa');

        Noticia::create($validated);
        
        return redirect()->route('noticias.index')
            ->with('success', 'Noticia creada exitosamente');
    }

    /**
     * Despliega los detalles de una noticia
     * @param Noticia $noticia
     * @return \Illuminate\Contracts\View\View
     */
    public function show(Noticia $noticia)
    {
        $this->authorize('view', $noticia);
        return view('admin.noticias.show', compact('noticia'));
    }

    /**
     * Despliega el formulario para editar una noticia
     * @param Noticia $noticia
     * @return \Illuminate\Contracts\View\View
     */
    public function edit(Noticia $noticia)
    {
        $this->authorize('update', $noticia);
        return view('admin.noticias.edit', compact('noticia'));
    }

    /**
     * Actualiza una noticia
     * @param Request $request
     * @param Noticia $noticia
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Noticia $noticia)
    {
        $this->authorize('update', $noticia);
        
        $validated = $request->validate([
            'titulo' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'activa' => 'boolean',
        ]);

        // Manejo de la imagen
        if ($request->hasFile('imagen')) {
            // Eliminar imagen antigua si existe
            if ($noticia->imagen && Storage::disk('public')->exists($noticia->imagen)) {
                Storage::disk('public')->delete($noticia->imagen);
            }
            $validated['imagen'] = $request->file('imagen')->store('noticias', 'public');
        }

        $validated['activa'] = $request->has('activa');

        $noticia->update($validated);
        
        return redirect()->route('noticias.index')
            ->with('success', 'Noticia actualizada exitosamente');
    }

    /**
     * Elimina una noticia
     * @param Noticia $noticia
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Noticia $noticia)
    {
        $this->authorize('delete', $noticia);
        
        // Eliminar imagen asociada si existe
        if ($noticia->imagen && Storage::disk('public')->exists($noticia->imagen)) {
            Storage::disk('public')->delete($noticia->imagen);
        }
        
        $noticia->delete();
        
        return redirect()->route('noticias.index')
            ->with('success', 'Noticia eliminada exitosamente');
    }

    /**
     * Toggle del estado activa/inactiva de una noticia
     * @param Noticia $noticia
     * @return \Illuminate\Http\JsonResponse
     */
    public function toggleActive(Noticia $noticia)
    {
        $this->authorize('update', $noticia);
        
        $noticia->activa = !$noticia->activa;
        $noticia->save();

        return response()->json([
            'success' => true,
            'activa' => $noticia->activa,
            'message' => 'Estado actualizado exitosamente'
        ]);
    }
}
