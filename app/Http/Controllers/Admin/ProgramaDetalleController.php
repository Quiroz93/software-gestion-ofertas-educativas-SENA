<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProgramaDetalle;
use App\Models\Programa;

class ProgramaDetalleController extends Controller
{
    public function index()
    {
        $detalles = ProgramaDetalle::all();
        return view('admin.programa_detalles.index', compact('detalles'));
    }

    public function create()
    {
        $programas = Programa::orderBy('nombre')->get();
        return view('admin.programa_detalles.create', compact('programas'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'programa_id' => 'required|exists:programas,id',
            'contextualizacion' => 'nullable|string',
            'video_url' => 'nullable|url',
            'video_file' => 'nullable|file|mimetypes:video/mp4,video/avi,video/mpeg,video/quicktime',
            'imagenes' => 'nullable|array',
            'imagenes.*' => 'nullable|file|image',
        ]);

        // Video: guardar archivo binario si se sube, o la URL si no
        $videoFile = null;
        if ($request->hasFile('video_file')) {
            $videoFile = file_get_contents($request->file('video_file')->getRealPath());
        }

        // Imágenes: guardar archivos binarios en imagenes_blob
        $imagenesBlob = [];
        if ($request->hasFile('imagenes')) {
            foreach ($request->file('imagenes') as $img) {
                $imagenesBlob[] = base64_encode(file_get_contents($img->getRealPath()));
            }
        }

        $detalle = ProgramaDetalle::create([
            'programa_id' => $validated['programa_id'],
            'contextualizacion' => $validated['contextualizacion'] ?? null,
            'video_url' => $validated['video_url'] ?? null,
            'video_file' => $videoFile,
            'imagenes' => null, // Si quieres guardar rutas, aquí
            'imagenes_blob' => $imagenesBlob,
        ]);

        return redirect()->route('admin.programa_detalles.index')->with('success', 'Detalle creado correctamente');
    }

    public function edit(ProgramaDetalle $programaDetalle)
    {
        $programas = Programa::orderBy('nombre')->get();
        return view('admin.programa_detalles.edit', compact('programaDetalle', 'programas'));
    }

    public function update(Request $request, ProgramaDetalle $programaDetalle)
    {
        $validated = $request->validate([
            'contextualizacion' => 'nullable|string',
            'video_url' => 'nullable|url',
            'video_file' => 'nullable|file|mimetypes:video/mp4,video/avi,video/mpeg,video/quicktime',
            'imagenes' => 'nullable|array',
            'imagenes.*' => 'nullable|file|image',
        ]);

        // Video: actualizar archivo binario si se sube, o la URL si no
        if ($request->hasFile('video_file')) {
            $programaDetalle->video_file = file_get_contents($request->file('video_file')->getRealPath());
            $programaDetalle->video_url = null;
        } elseif (!empty($validated['video_url'])) {
            $programaDetalle->video_url = $validated['video_url'];
            $programaDetalle->video_file = null;
        }

        // Imágenes: actualizar archivos binarios en imagenes_blob si se suben
        if ($request->hasFile('imagenes')) {
            $imagenesBlob = [];
            foreach ($request->file('imagenes') as $img) {
                $imagenesBlob[] = base64_encode(file_get_contents($img->getRealPath()));
            }
            $programaDetalle->imagenes_blob = $imagenesBlob;
        }

        $programaDetalle->contextualizacion = $validated['contextualizacion'] ?? $programaDetalle->contextualizacion;
        $programaDetalle->save();

        return redirect()->route('admin.programa_detalles.index')->with('success', 'Detalle actualizado correctamente');
    }

    public function destroy(ProgramaDetalle $programaDetalle)
    {
        $programaDetalle->delete();
        return redirect()->route('admin.programa_detalles.index')->with('success', 'Detalle eliminado correctamente');
    }
}
