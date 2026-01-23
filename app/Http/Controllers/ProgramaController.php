<?php

namespace App\Http\Controllers;

use App\Models\Programa;
use App\Models\NivelFormacion;
use App\Models\Red;
use App\Models\Centro;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class ProgramaController extends Controller
{
    /**
     * Despliega la lista de programas
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        Gate::authorize('programas.view');
        $programas = Programa::all();
        return view('programas.index', compact('programas'));
    }

    /**
     * Despliega el formulario para crear un nuevo programa
     * @return \Illuminate\Contracts\View\View
     */
    public function create()
    {
        Gate::authorize('programas.create');
        $nivel_formaciones = NivelFormacion::all();
        $redes = Red::all();
        $centros = Centro::all();
        return view('programas.create', compact('nivel_formaciones', 'redes', 'centros'));
    }

    /**
     * Crea un nuevo programa
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        Gate::authorize('programas.create');
        $data = $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'requisitos' => 'nullable|string',
            'duracion_meses' => 'nullable|integer',
            'red_id' => 'nullable|exists:redes,id',
            'nivel_formacion_id' => 'nullable|exists:nivel_formaciones,id',
            'modalidad' => 'nullable|string|max:255',
            'jornada' => 'nullable|string|max:255',
            'titulo_otorgado' => 'nullable|string|max:255',
            'codigo_snies' => 'nullable|string|max:100',
            'registro_calidad' => 'nullable|string|max:255',
            'fecha_registro' => 'nullable|date',
            'fecha_actualizacion' => 'nullable|date',
            'estado' => 'nullable|string|max:100',
            'observaciones' => 'nullable|string',
            'centro_id' => 'nullable|exists:centros,id',
            'cupos' => 'nullable|integer',
        ]);

        Programa::create($data);

        return redirect()->route('programas.index')->with('success', 'Programa creado exitosamente');
    }

    /**
     * Despliega los detalles de un programa
     * @param Programa $programa
     * @return \Illuminate\Contracts\View\View
     */
    public function show(Programa $programa)
    {
        Gate::authorize('programas.show', $programa);
        return view('programas.show', compact('programa'));
    }

    /**
     * Despliega el formulario para editar un programa
     * @param Programa $programa
     * @return \Illuminate\Contracts\View\View
     */
    public function edit(Programa $programa)
    {
        Gate::authorize('programas.edit', $programa);
        $nivel_formaciones = NivelFormacion::all();
        $redes = Red::all();
        $centros = Centro::all();
        return view('programas.edit', compact('programa', 'nivel_formaciones', 'redes', 'centros'));
    }

    /**
     * Actualiza un programa
     * @param Request $request
     * @param Programa $programa
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Programa $programa)
    {
        Gate::authorize('programas.edit', $programa);
        $data = $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'requisitos' => 'nullable|string',
            'duracion_meses' => 'nullable|integer',
            'red_id' => 'nullable|exists:redes,id',
            'nivel_formacion_id' => 'nullable|exists:nivel_formaciones,id',
            'modalidad' => 'nullable|string|max:255',
            'jornada' => 'nullable|string|max:255',
            'titulo_otorgado' => 'nullable|string|max:255',
            'codigo_snies' => 'nullable|string|max:100',
            'registro_calidad' => 'nullable|string|max:255',
            'fecha_registro' => 'nullable|date',
            'fecha_actualizacion' => 'nullable|date',
            'estado' => 'nullable|string|max:100',
            'observaciones' => 'nullable|string',
            'centro_id' => 'nullable|exists:centros,id',
            'cupos' => 'nullable|integer',
        ]);

        $programa->update($data);

        return redirect()->route('programas.index')->with('success', 'Programa actualizado exitosamente');
    }

    /**
     * Elimina un programa
     * @param Programa $programa
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Programa $programa)
    {
        Gate::authorize('programas.delete', $programa);
        $programa->delete();
        return redirect()->route('programas.index')->with('success', 'Programa eliminado exitosamente');
    }
}
