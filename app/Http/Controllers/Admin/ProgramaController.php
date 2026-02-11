<?php

namespace App\Http\Controllers\Admin;

use App\Models\Programa;
use App\Models\NivelFormacion;
use App\Models\Centro;
use App\Models\Red;
use App\Models\Municipio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class ProgramaController extends \App\Http\Controllers\Controller
{
    /**
     * Despliega la lista de programas
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        Gate::authorize('programas.view');
        $programas = Programa::all();
        return view('admin.programas.index', compact('programas'));
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
        $municipios = Municipio::all();
        return view('admin.programas.create', compact('nivel_formaciones', 'redes', 'centros', 'municipios'));
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
            'numero_ficha' => 'nullable|string|max:50',
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
            'municipio_id' => 'nullable|exists:municipios,id',
            'is_featured' => 'boolean',
        ]);

        $data['is_featured'] = $request->has('is_featured');

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
        return view('admin.programas.show', compact('programa'));
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
        $municipios = Municipio::all();
        return view('admin.programas.edit', compact('programa', 'nivel_formaciones', 'redes', 'centros', 'municipios'));
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
            'numero_ficha' => 'nullable|string|max:50',
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
            'municipio_id' => 'nullable|exists:municipios,id',
            'is_featured' => 'boolean',
        ]);

        $data['is_featured'] = $request->has('is_featured');

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

    /**
     * Genera y retorna el código QR del enlace de inscripción del programa
     * @param Programa $programa
     * @return \Illuminate\Http\Response
     */
    public function generarQR(Programa $programa)
    {
        Gate::authorize('programas.view', $programa);
        
        // Obtener enlace de inscripción desde custom_contents
        $enlaceInscripcion = $programa->customContents()
            ->where('key', 'enlace_inscripcion')
            ->value('value');
        
        if (!$enlaceInscripcion) {
            return response()->json([
                'error' => 'Este programa no tiene un enlace de inscripción configurado'
            ], 404);
        }
        
        // Generar QR code
        $qrCode = \SimpleSoftwareIO\QrCode\Facades\QrCode::size(300)
            ->format('svg')
            ->generate($enlaceInscripcion);
        
        // Guardar en custom_contents para futura referencia
        $programa->customContents()->updateOrCreate(
            ['key' => 'qr_code'],
            ['value' => $qrCode]
        );
        
        return response($qrCode)->header('Content-Type', 'image/svg+xml');
    }

    /**
     * Descarga el código QR del programa como archivo SVG
     * @param Programa $programa
     * @return \Symfony\Component\HttpFoundation\StreamedResponse
     */
    public function descargarQR(Programa $programa)
    {
        Gate::authorize('programas.view', $programa);
        
        // Obtener QR almacenado o generar nuevo
        $qrCode = $programa->customContents()
            ->where('key', 'qr_code')
            ->value('value');
        
        if (!$qrCode) {
            // Si no existe, generar uno nuevo
            $enlaceInscripcion = $programa->customContents()
                ->where('key', 'enlace_inscripcion')
                ->value('value');
            
            if (!$enlaceInscripcion) {
                abort(404, 'Este programa no tiene un enlace de inscripción configurado');
            }
            
            $qrCode = \SimpleSoftwareIO\QrCode\Facades\QrCode::size(300)
                ->format('svg')
                ->generate($enlaceInscripcion);
        }
        
        $fileName = 'qr_' . \Illuminate\Support\Str::slug($programa->nombre) . '.svg';
        
        return response($qrCode)
            ->header('Content-Type', 'image/svg+xml')
            ->header('Content-Disposition', 'attachment; filename="' . $fileName . '"');
    }
}
