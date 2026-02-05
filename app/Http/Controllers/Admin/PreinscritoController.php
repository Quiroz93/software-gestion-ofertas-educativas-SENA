<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\StorePresritoRequest;
use App\Http\Requests\UpdatePresritoRequest;
use App\Models\Preinscrito;
use App\Models\TipoNovedad;
use App\Models\Programa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

/**
 * Controlador para la gestión de Preinscritos
 * Gestiona las operaciones CRUD completas del módulo de aprendices preinscritos
 * 
 * LÓGICA DE EDICIÓN MEJORADA:
 * 1. Al cargar edit(): se guardan datos originales en JavaScript
 * 2. Al enviar formulario: se comparan datos originales vs editados
 * 3. Si cambió documento o nombre/apellidos: SweetAlert ruidosa (warning)
 * 4. Si NO cambió esos datos: SweetAlert simple (info)
 * 5. Si usuario cancela: no se guardan cambios
 * 6. Si usuario confirma: 
 *    - Si hay cambios sensibles: se valida que documento no sea duplicado
 *    - Si NO hay cambios sensibles: se actualiza directamente
 */
class PreinscritoController extends \App\Http\Controllers\Controller
{
    /**
     * Mostrar la lista de aprendices preinscritos
     */
    public function index(Request $request)
    {
        Gate::authorize('preinscritos.view');

        $query = Preinscrito::with('programa', 'createdBy', 'updatedBy');

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
     */
    public function create()
    {
        Gate::authorize('preinscritos.create');

        $programas = Programa::all();
        $estados = Preinscrito::getEstados();
        $tiposDocumento = Preinscrito::getTiposDocumento();
        $tiposNovedades = TipoNovedad::query()
            ->activos()
            ->orderBy('nombre')
            ->get();

        return view('admin.preinscritos.create', compact('programas', 'estados', 'tiposDocumento', 'tiposNovedades'));
    }

    /**
     * Almacenar un nuevo preinscrito en la base de datos
     * SOLO VALIDA DOCUMENTO DUPLICADO EN CREACIÓN
     */
    public function store(StorePresritoRequest $request)
    {
        try {
            DB::beginTransaction();

            // Validación de documento duplicado SOLO en creación
            if (Preinscrito::documentoExiste($request->numero_documento)) {
                DB::rollBack();
                return redirect()->back()
                    ->with('error', 'El número de documento ya está registrado.')
                    ->withInput();
            }

            $preinscrito = Preinscrito::create($request->validated());

            if ($request->has('tiene_novedad') && $request->tiene_novedad) {
                $novedad = $preinscrito->novedades()->create([
                    'tipo_novedad_id' => $request->tipo_novedad_id,
                    'estado' => $request->novedad_estado,
                    'descripcion' => $request->novedad_descripcion,
                    'created_by' => auth()->user()->id(),
                    'updated_by' => auth()->id(),
                ]);

                if ($novedad) {
                    $novedad->historial()->create([
                        'estado_anterior' => null,
                        'estado_nuevo' => $request->novedad_estado,
                        'comentario' => 'Novedad creada al momento de registrar el preinscrito',
                        'changed_by' => auth()->id(),
                    ]);
                }
            }

            DB::commit();

            $mensaje = 'Preinscrito creado exitosamente.';
            if ($request->has('tiene_novedad') && $request->tiene_novedad) {
                $mensaje .= ' Se registró la novedad asociada.';
            }

            return redirect()->route('preinscritos.index')
                ->with('success', $mensaje);
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Error al crear el preinscrito: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Mostrar los detalles de un preinscrito
     */
    public function show(Preinscrito $preinscrito)
    {
        $presrito = $preinscrito;
        Gate::authorize('preinscritos.view', $presrito);
        $presrito->load([
            'programa', 
            'createdBy', 
            'updatedBy',
            'novedades.tipoNovedad',
            'novedades.createdBy',
            'novedades.historial.changedBy'
        ]);

        return view('admin.preinscritos.show', compact('presrito'));
    }

    /**
     * Mostrar el formulario para editar un preinscrito
     * Pasa datos originales para comparación en JavaScript
     */
    public function edit(Preinscrito $preinscrito)
    {
        $presrito = $preinscrito;
        Gate::authorize('preinscritos.edit', $presrito);

        $programas = Programa::all();
        $estados = Preinscrito::getEstados();
        $tiposDocumento = Preinscrito::getTiposDocumento();
        $tiposNovedades = TipoNovedad::query()
            ->activos()
            ->orderBy('nombre')
            ->get();

        // Datos originales para comparación en JavaScript
        $datosOriginales = [
            'numero_documento' => $presrito->numero_documento,
            'nombres' => $presrito->nombres,
            'apellidos' => $presrito->apellidos,
        ];

        return view('admin.preinscritos.edit', compact('presrito', 'programas', 'estados', 'tiposDocumento', 'tiposNovedades', 'datosOriginales'));
    }

    /**
     * Actualizar un preinscrito en la base de datos
     * 
     * FLUJO:
     * 1. Recibe flag "cambios_sensibles" desde JavaScript
     * 2. Si hay cambios sensibles (doc/nombre/apellidos) → VALIDA documento duplicado
     * 3. Si NO hay cambios sensibles → ACTUALIZA directamente sin validar
     * 4. Guarda novedades si las hay
     */
    public function update(UpdatePresritoRequest $request, Preinscrito $preinscrito)
    {
        $presrito = $preinscrito;
        try {
            DB::beginTransaction();

            // Verificar si hay cambios sensibles (documento, nombres, apellidos)
            $tieneChangiosSensibles = $request->has('cambios_sensibles') && $request->cambios_sensibles === 'true';

            // SOLO si hay cambios sensibles, validar documento duplicado
            if ($tieneChangiosSensibles) {
                $docOriginal = $request->input('documento_original');
                $docNuevo = (string)$request->numero_documento;

                // Si el documento fue modificado, validar que no exista
                if ((string)$docOriginal !== $docNuevo) {
                    if (Preinscrito::documentoExiste($docNuevo, $presrito->id)) {
                        DB::rollBack();
                        return redirect()->back()
                            ->with('error', 'El número de documento ya está registrado en la base de datos.')
                            ->withInput();
                    }
                }
            }

            // Actualizar el preinscrito
            $presrito->update($request->validated());

            // Crear novedad si se marcó la opción
            if ($request->has('tiene_novedad') && $request->tiene_novedad) {
                $novedad = $presrito->novedades()->create([
                    'tipo_novedad_id' => $request->tipo_novedad_id,
                    'estado' => $request->novedad_estado,
                    'descripcion' => $request->novedad_descripcion,
                    'created_by' => auth()->id(),
                    'updated_by' => auth()->id(),
                ]);

                // Registrar historial de la creación (estado_anterior = null porque es nueva)
                if ($novedad) {
                    $novedad->historial()->create([
                        'estado_anterior' => null, // NULL indica que es una creación nueva
                        'estado_nuevo' => $request->novedad_estado,
                        'comentario' => 'Novedad creada durante la edición del preinscrito',
                        'changed_by' => auth()->id(),
                    ]);
                }
            }

            DB::commit();

            $mensaje = 'Preinscrito actualizado exitosamente.';
            if ($request->has('tiene_novedad') && $request->tiene_novedad) {
                $mensaje .= ' Se registró la novedad asociada.';
            }

            return redirect()->route('preinscritos.index')
                ->with('success', $mensaje);
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Error al actualizar el preinscrito: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Eliminar un preinscrito (Soft Delete)
     */
    public function destroy(Preinscrito $preinscrito)
    {
        $presrito = $preinscrito;
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
     */
    public function reportes(Request $request)
    {
        Gate::authorize('preinscritos.view');

        $query = Preinscrito::with('programa');

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

        $preinscritos = $query->orderBy('programa_id')->get();
        $programas = Programa::all();
        $estados = Preinscrito::getEstados();
        $tiposDocumento = Preinscrito::getTiposDocumento();
        $tiposNovedades = Preinscrito::getTiposNovedades();

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
