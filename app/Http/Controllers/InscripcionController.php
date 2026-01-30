<?php

namespace App\Http\Controllers;

use App\Models\Inscripcion;
use App\Models\Programa;
use App\Http\Requests\InscripcionRequest;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class InscripcionController extends Controller
{
    /**
     * Mostrar formulario de inscripción a un programa
     */
    public function create(Programa $programa): View
    {
        // Verificar que el usuario esté autenticado
        if (!auth()->check()) {
            throw new AuthorizationException('Debes estar autenticado para inscribirte');
        }

        // Verificar que el usuario tenga rol de aprendiz
        if (!auth()->user()->hasRole('aprendiz')) {
            throw new AuthorizationException('Solo los aprendices pueden inscribirse a programas');
        }

        $user = auth()->user();

        // Verificar si ya está inscrito
        $yaInscrito = Inscripcion::where('user_id', $user->id)
            ->where('programa_id', $programa->id)
            ->whereIn('estado', ['activo', 'finalizado'])
            ->exists();

        if ($yaInscrito) {
            return back()->with('error', 'Ya estás inscrito en este programa');
        }

        // Cargar relaciones necesarias
        $programa->load('competencias', 'instructor');

        return view('public.inscribirse', [
            'programa' => $programa,
            'user' => $user
        ]);
    }

    /**
     * Guardar inscripción del usuario a un programa
     */
    public function store(InscripcionRequest $request, Programa $programa): RedirectResponse
    {
        // Verificar que el usuario esté autenticado
        if (!auth()->check()) {
            return back()->with('error', 'Debes estar autenticado');
        }

        $user = auth()->user();

        // Verificar que el usuario tenga rol de aprendiz
        if (!$user->hasRole('aprendiz')) {
            return back()->with('error', 'Solo los aprendices pueden inscribirse');
        }

        try {
            DB::beginTransaction();

            // 1. Validar que no esté duplicada la inscripción
            $existente = Inscripcion::where('user_id', $user->id)
                ->where('programa_id', $programa->id)
                ->whereIn('estado', ['activo', 'finalizado'])
                ->first();

            if ($existente) {
                DB::rollBack();
                return back()->with('error', 'Ya estás inscrito en este programa');
            }

            // 2. Validar cupo disponible (si está configurado)
            if ($programa->cupo_maximo !== null) {
                $inscritosActivos = Inscripcion::where('programa_id', $programa->id)
                    ->where('estado', 'activo')
                    ->count();

                if ($inscritosActivos >= $programa->cupo_maximo) {
                    DB::rollBack();
                    return back()->with('error', 'El programa ha alcanzado su cupo máximo de inscritos');
                }
            }

            // 3. Validar requisitos del programa (si existen)
            if ($programa->requisitos) {
                $cumpleRequisitos = $this->validarRequisitos($user, $programa);
                if (!$cumpleRequisitos) {
                    DB::rollBack();
                    return back()->with('error', 'No cumples con los requisitos para este programa');
                }
            }

            // 4. Crear la inscripción
            $inscripcion = Inscripcion::create([
                'user_id' => $user->id,
                'programa_id' => $programa->id,
                'instructor_id' => $programa->instructor_id,
                'fecha_inscripcion' => now()->toDateString(),
                'estado' => 'activo',
                'observaciones' => $request->input('observaciones', null),
            ]);

            DB::commit();

            return redirect()->route('programas.show', $programa)
                ->with('status', 'inscripcion-exitosa')
                ->with('message', '¡Te has inscrito exitosamente al programa!');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Error al procesar tu inscripción: ' . $e->getMessage());
        }
    }

    /**
     * Retirar usuario de un programa (inscripción)
     */
    public function destroy(Inscripcion $inscripcion): RedirectResponse
    {
        // Autorizar que sea el usuario propietario o admin
        if (!auth()->check() || (auth()->id() !== $inscripcion->user_id && !auth()->user()->hasRole('admin'))) {
            throw new AuthorizationException('No tienes permiso para realizar esta acción');
        }

        try {
            DB::beginTransaction();

            // Actualizar estado a 'retirado'
            $inscripcion->update([
                'estado' => 'retirado',
                'fecha_retiro' => now()->toDateString(),
            ]);

            DB::commit();

            return back()
                ->with('status', 'inscripcion-retirada')
                ->with('message', 'Te has retirado del programa exitosamente');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Error al procesar tu retiro: ' . $e->getMessage());
        }
    }

    /**
     * Validar si el usuario cumple con los requisitos del programa
     * 
     * @param \App\Models\User $user
     * @param \App\Models\Programa $programa
     * @return bool
     */
    protected function validarRequisitos($user, $programa): bool
    {
        // Si no hay requisitos especificados, permitir inscripción
        if (!$programa->requisitos) {
            return true;
        }

        // Ejemplos de validaciones de requisitos:
        // - Haber completado otro programa
        // - Tener cierta edad mínima
        // - Tener competencias previas

        // TODO: Implementar lógica específica según requisitos del programa
        // Por ahora, permitir siempre
        return true;
    }

    /**
     * Listar inscripciones del usuario autenticado
     */
    public function misinscripciones()
    {
        if (!auth()->check()) {
            return back()->with('error', 'Debes estar autenticado');
        }

        $inscripciones = auth()->user()
            ->inscripciones()
            ->with('programa', 'instructor')
            ->orderBy('fecha_inscripcion', 'desc')
            ->paginate(10);

        return view('public.mis-inscripciones', [
            'inscripciones' => $inscripciones
        ]);
    }
}
