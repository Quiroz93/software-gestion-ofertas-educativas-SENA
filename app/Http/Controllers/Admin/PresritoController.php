<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\StorePresritoRequest;
use App\Http\Requests\UpdatePresritoRequest;
use App\Models\Preinscrito;
use App\Models\Programa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

/**
 * Controlador para la gestión de Preinscritos
 * Gestiona las operaciones CRUD completas del módulo de aprendices preinscritos
 */
class PresritoController extends \App\Http\Controllers\Controller
{
    /**
     * Mostrar la lista de aprendices preinscritos
     * 
     * @return \Illuminate\Contracts\View\View
     */
    public function index(Request $request)
    {
        Gate::authorize('preinscritos.view');

        $query = Preinscrito::with('programa', 'createdBy', 'updatedBy');

        // Aplicar filtros si existen
        if ($request->filled('programa_id')) {
            $query->byPrograma($request->programa_id);
        }

        if ($request->filled('estado')) {
            $query->byEstado($request->estado);
        }

        if ($request->filled('tipo_documento')) {
            $query->byTipoDocumento($request->tipo_documento);
        }

        if ($request->filled('numero_documento')) {
            $query->byNumeroDocumento($request->numero_documento);
        }

        if ($request->filled('nombre')) {
            $query->byNombre($request->nombre);
        }

        if ($request->filled('tipo_novedad')) {
            $query->byTipoNovedad($request->tipo_novedad);
        }

        if ($request->filled('novedad_resuelta')) {
            $query->byNovedadResuelta($request->novedad_resuelta === 'pendiente' ? false : true);
        }

        $preinscritos = $query->paginate(15);
        $programas = Programa::all();
        $estados = Preinscrito::getEstados();
        $tiposDocumento = Preinscrito::getTiposDocumento();
        $tiposNovedades = Preinscrito::getTiposNovedades();

        return view('admin.preinscritos.index', compact('preinscritos', 'programas', 'estados', 'tiposDocumento', 'tiposNovedades'));
    }

    /**
     * Mostrar el formulario para crear un nuevo preinscrito
     * 
     * @return \Illuminate\Contracts\View\View
     */
    public function create()
    {
        Gate::authorize('preinscritos.create');

        $programas = Programa::all();
        $estados = Preinscrito::getEstados();
        $tiposDocumento = Preinscrito::getTiposDocumento();
        $tiposNovedades = Preinscrito::getTiposNovedades();

        return view('admin.preinscritos.create', compact('programas', 'estados', 'tiposDocumento', 'tiposNovedades'));
    }

    /**
     * Almacenar un nuevo preinscrito en la base de datos
     * 
     * @param StorePresritoRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StorePresritoRequest $request)
    {
        try {
            DB::beginTransaction();

            // Validar que el documento no exista
            if (Preinscrito::documentoExiste($request->numero_documento)) {
                DB::rollBack();
                return redirect()->back()
                    ->with('error', 'El número de documento ya está registrado.')
                    ->withInput();
            }

            // Crear el nuevo preinscrito
            Preinscrito::create($request->validated());

            DB::commit();

            return redirect()->route('preinscritos.index')
                ->with('success', 'Preinscrito creado exitosamente.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Error al crear el preinscrito: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Mostrar los detalles de un preinscrito
     * 
     * @param Preinscrito $presrito
     * @return \Illuminate\Contracts\View\View
     */
    public function show(Preinscrito $presrito)
    {
        Gate::authorize('preinscritos.view', $presrito);
        $presrito->load('programa', 'createdBy', 'updatedBy');

        return view('admin.preinscritos.show', compact('presrito'));
    }

    /**
     * Mostrar el formulario para editar un preinscrito
     * 
     * @param Preinscrito $presrito
     * @return \Illuminate\Contracts\View\View
     */
    public function edit(Preinscrito $presrito)
    {
        Gate::authorize('preinscritos.edit', $presrito);

        $programas = Programa::all();
        $estados = Preinscrito::getEstados();
        $tiposDocumento = Preinscrito::getTiposDocumento();
        $tiposNovedades = Preinscrito::getTiposNovedades();

        return view('admin.preinscritos.edit', compact('presrito', 'programas', 'estados', 'tiposDocumento', 'tiposNovedades'));
    }

    /**
     * Actualizar un preinscrito en la base de datos
     * 
     * @param UpdatePresritoRequest $request
     * @param Preinscrito $presrito
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdatePresritoRequest $request, Preinscrito $presrito)
    {
        try {
            DB::beginTransaction();

            // Validar que el documento no esté duplicado (excluyendo el registro actual)
            if ($request->numero_documento !== $presrito->numero_documento) {
                if (Preinscrito::documentoExiste($request->numero_documento, $presrito->id)) {
                    DB::rollBack();
                    return redirect()->back()
                        ->with('error', 'El número de documento ya está registrado.')
                        ->withInput();
                }
            }

            // Actualizar el preinscrito
            $presrito->update($request->validated());

            DB::commit();

            return redirect()->route('preinscritos.index')
                ->with('success', 'Preinscrito actualizado exitosamente.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Error al actualizar el preinscrito: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Eliminar un preinscrito (Soft Delete)
     * 
     * @param Preinscrito $presrito
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Preinscrito $presrito)
    {
        Gate::authorize('preinscritos.delete', $presrito);

        try {
            DB::beginTransaction();

            $presrito->delete();

            DB::commit();

            return redirect()->route('preinscritos.index')
                ->with('success', 'Preinscrito eliminado exitosamente.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Error al eliminar el preinscrito: ' . $e->getMessage());
        }
    }

    /**
     * Mostrar reporte de preinscritos con filtros
     * Preparado para futura exportación a Excel
     * 
     * @param Request $request
     * @return \Illuminate\Contracts\View\View
     */
    public function reportes(Request $request)
    {
        Gate::authorize('preinscritos.view');

        $query = Preinscrito::with('programa');

        // Aplicar filtros
        if ($request->filled('programa_id')) {
            $query->byPrograma($request->programa_id);
        }

        if ($request->filled('estado')) {
            $query->byEstado($request->estado);
        }

        if ($request->filled('tipo_documento')) {
            $query->byTipoDocumento($request->tipo_documento);
        }

        if ($request->filled('tipo_novedad')) {
            $query->byTipoNovedad($request->tipo_novedad);
        }

        if ($request->filled('novedad_resuelta')) {
            $query->byNovedadResuelta($request->novedad_resuelta === 'pendiente' ? false : true);
        }

        // Obtener los datos
        $preinscritos = $query->orderBy('programa_id')->get();
        $programas = Programa::all();
        $estados = Preinscrito::getEstados();
        $tiposDocumento = Preinscrito::getTiposDocumento();
        $tiposNovedades = Preinscrito::getTiposNovedades();

        // Estadísticas
        $estadisticas = [
            'total' => $preinscritos->count(),
            'inscrito' => $preinscritos->where('estado', 'inscrito')->count(),
            'por_inscribir' => $preinscritos->where('estado', 'por_inscribir')->count(),
            'con_novedad' => $preinscritos->where('estado', 'con_novedad')->count(),
            'novedades_resueltas' => $preinscritos->where('novedad_resuelta', true)->count(),
            'novedades_pendientes' => $preinscritos->where('novedad_resuelta', false)->count(),
        ];

        return view('admin.preinscritos.reportes', compact('preinscritos', 'programas', 'estados', 'tiposDocumento', 'tiposNovedades', 'estadisticas'));
    }

    /**
     * Restaurar un preinscrito eliminado
     * 
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function restore($id)
    {
        Gate::authorize('preinscritos.restore');

        try {
            DB::beginTransaction();

            $presrito = Preinscrito::onlyTrashed()->findOrFail($id);
            $presrito->restore();

            DB::commit();

            return redirect()->route('preinscritos.index')
                ->with('success', 'Preinscrito restaurado exitosamente.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Error al restaurar el preinscrito: ' . $e->getMessage());
        }
    }
}
