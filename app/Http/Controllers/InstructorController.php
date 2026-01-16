<?php

namespace App\Http\Controllers;

use App\Models\Instructor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class InstructorController extends Controller
{
    /**
     * Despliega una lista de recursos
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        Gate::authorize('viewAny', Instructor::class);
        $instructors = Instructor::all();
        return view('instructores.index', compact('instructors'));
    }

    /**
     * Despliega el formulario para crear un nuevo recurso
     * @return \Illuminate\Contracts\View\View
     */
    public function create()
    {
        Gate::authorize('instructores.create', Instructor::class);
        return view('instructores.create');
    }

    /**
     * Crea un nuevo recurso en almacenamiento
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        Gate::authorize('instructores.create', Instructor::class);
        Instructor::create($request->all());
        return redirect()->route('instructores.index')->with('success', 'Instructor creado exitosamente');
    }

    /**
     * Despliega el recurso especificado
     * @param Instructor $instructor
     * @return \Illuminate\Contracts\View\View
     */
    public function show(Instructor $instructor)
    {
        Gate::authorize('view', $instructor);
        return view('instructores.show', compact('instructor'));
    }

    /**
     * Despliega el formulario para editar el recurso especificado
     * @param Instructor $instructor
     * @return \Illuminate\Contracts\View\View
     */
    public function edit(Instructor $instructor)
    {
        Gate::authorize('instructores.update', $instructor);
        return view('instructores.edit', compact('instructor'));
    }

    /**
     * Actualiza el recurso especificado en almacenamiento
     * @param Request $request
     * @param Instructor $instructor
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Instructor $instructor)
    {
        Gate::authorize('instructores.update', $instructor);
        $instructor->update($request->all());
        return redirect()->route('instructores.index')->with('success', 'Instructor actualizado exitosamente');
    }

    /**
     * Elimina el recurso especificado de almacenamiento
     * @param Instructor $instructor
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Instructor $instructor)
    {
        Gate::authorize('instructores.delete', $instructor);
        $instructor->delete();
        return redirect()->route('instructores.index')->with('success', 'Instructor eliminado exitosamente');
    }
}
