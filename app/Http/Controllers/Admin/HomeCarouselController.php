<?php

namespace App\Http\Controllers\Admin;

use App\Models\HomeCarousel;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class HomeCarouselController extends \App\Http\Controllers\Controller
{
    use AuthorizesRequests;

    /**
     * Despliega una lista de slides del carousel
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        $slides = HomeCarousel::orderBy('position')->get();
        return view('admin.home-carousel.index', compact('slides'));
    }

    /**
     * Despliega el formulario para crear un nuevo slide
     * @return \Illuminate\Contracts\View\View
     */
    public function create()
    {
        return view('admin.home-carousel.create');
    }

    /**
     * Crea un nuevo slide en la base de datos
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:500',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'button_text' => 'nullable|string|max:100',
            'button_url' => 'nullable|url|max:255',
            'position' => 'required|integer|min:0',
            'is_active' => 'boolean',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('carousel', 'public');
            $validated['image_path'] = $imagePath;
        }

        $validated['is_active'] = $request->has('is_active');

        HomeCarousel::create($validated);

        return redirect()->route('admin.home-carousel.index')
            ->with('success', 'Slide creado exitosamente');
    }

    /**
     * Despliega el formulario para editar un slide
     * @param HomeCarousel $homeCarousel
     * @return \Illuminate\Contracts\View\View
     */
    public function edit(HomeCarousel $homeCarousel)
    {
        return view('admin.home-carousel.edit', compact('homeCarousel'));
    }

    /**
     * Actualiza un slide en la base de datos
     * @param Request $request
     * @param HomeCarousel $homeCarousel
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, HomeCarousel $homeCarousel)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:500',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'button_text' => 'nullable|string|max:100',
            'button_url' => 'nullable|url|max:255',
            'position' => 'required|integer|min:0',
            'is_active' => 'boolean',
        ]);

        // Manejo de imagen
        if ($request->hasFile('image')) {
            // Eliminar imagen antigua si existe
            if ($homeCarousel->image_path && Storage::disk('public')->exists($homeCarousel->image_path)) {
                Storage::disk('public')->delete($homeCarousel->image_path);
            }
            $imagePath = $request->file('image')->store('carousel', 'public');
            $validated['image_path'] = $imagePath;
        }

        $validated['is_active'] = $request->has('is_active');

        $homeCarousel->update($validated);

        return redirect()->route('admin.home-carousel.index')
            ->with('success', 'Slide actualizado exitosamente');
    }

    /**
     * Elimina un slide de la base de datos
     * @param HomeCarousel $homeCarousel
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(HomeCarousel $homeCarousel)
    {
        // Eliminar imagen asociada
        if ($homeCarousel->image_path && Storage::disk('public')->exists($homeCarousel->image_path)) {
            Storage::disk('public')->delete($homeCarousel->image_path);
        }

        $homeCarousel->delete();

        return redirect()->route('admin.home-carousel.index')
            ->with('success', 'Slide eliminado exitosamente');
    }

    /**
     * Toggle del estado activo/inactivo de un slide (sin recargar la página)
     * @param HomeCarousel $homeCarousel
     * @return \Illuminate\Http\JsonResponse
     */
    public function toggleActive(HomeCarousel $homeCarousel)
    {
        $homeCarousel->is_active = !$homeCarousel->is_active;
        $homeCarousel->save();

        return response()->json([
            'success' => true,
            'is_active' => $homeCarousel->is_active,
            'message' => 'Estado actualizado exitosamente'
        ]);
    }
}
