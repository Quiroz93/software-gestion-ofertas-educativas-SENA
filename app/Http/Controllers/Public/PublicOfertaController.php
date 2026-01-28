<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Oferta;
use Illuminate\Http\Request;

class PublicOfertaController extends Controller
{
    public function index()
    {
        // ✅ FIX: Eager load de customContents para evitar N+1 queries
        $ofertas = Oferta::where('estado', 'activo')
            ->with([
                'customContents' => function($query) {
                    // Solo cargar las keys que se usan en la vista
                    $query->whereIn('key', [
                        'imagen',
                        'titulo',
                        'descripcion',
                        'modalidad',
                        'imagen_alt',
                        'imagen_title'
                    ]);
                }
            ])
            ->orderBy('fecha_inicio')
            ->paginate(12); // ✅ Agregar paginación para mejor rendimiento

        return view('public.ofertas.index', compact('ofertas'));
    }

    public function show(Oferta $oferta)
    {
        abort_unless($oferta->estado === 'activo', 404);

        // ✅ Eager load customContents para la vista de detalle
        $oferta->load('customContents');

        return view('public.ofertas.show', compact('oferta'));
    }
}
