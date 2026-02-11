<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContentPublicPrograma;
use App\Models\Programa;
use Illuminate\Http\Request;

class ContentPublicProgramaController extends Controller
{
    public function index()
    {
        $contents = ContentPublicPrograma::with('programa')->get();
        return view('admin.content_public_programas.index', compact('contents'));
    }

    public function create()
    {
        $programas = Programa::doesntHave('contentPublicPrograma')->get();
        return view('admin.content_public_programas.create', compact('programas'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'programa_id' => 'required|exists:programas,id|unique:content_public_programas,programa_id',
            'hero_title' => 'nullable|string|max:255',
            'hero_description' => 'nullable|string',
            'hero_image' => 'nullable|string|max:255',
            'motivational_title' => 'nullable|string|max:255',
            'motivational_text' => 'nullable|string',
            'motivational_image' => 'nullable|string|max:255',
            'competencias_fallback' => 'nullable|string|max:255',
        ]);
        ContentPublicPrograma::create($data);
        return redirect()->route('admin.content_public_programas.index')->with('success', 'Contenido público creado correctamente.');
    }

    public function edit(ContentPublicPrograma $content_public_programa)
    {
        $programas = Programa::all();
        return view('admin.content_public_programas.edit', compact('content_public_programa', 'programas'));
    }

    public function update(Request $request, ContentPublicPrograma $content_public_programa)
    {
        $data = $request->validate([
            'programa_id' => 'required|exists:programas,id|unique:content_public_programas,programa_id,' . $content_public_programa->id,
            'hero_title' => 'nullable|string|max:255',
            'hero_description' => 'nullable|string',
            'hero_image' => 'nullable|string|max:255',
            'motivational_title' => 'nullable|string|max:255',
            'motivational_text' => 'nullable|string',
            'motivational_image' => 'nullable|string|max:255',
            'competencias_fallback' => 'nullable|string|max:255',
        ]);
        $content_public_programa->update($data);
        return redirect()->route('admin.content_public_programas.index')->with('success', 'Contenido público actualizado correctamente.');
    }

    public function destroy(ContentPublicPrograma $content_public_programa)
    {
        $content_public_programa->delete();
        return redirect()->route('admin.content_public_programas.index')->with('success', 'Contenido público eliminado correctamente.');
    }
}
