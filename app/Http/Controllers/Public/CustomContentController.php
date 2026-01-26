<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\CustomContent;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Log;

class CustomContentController extends Controller
{
    use AuthorizesRequests;
    
    /**
     * Almacena o actualiza contenido personalizado
     */
    public function store(Request $request)
    {
        try {
            // 🔐 Seguridad
            $this->authorize('public_content.edit');

            // 🐛 Debug: Log datos recibidos
            Log::info('Datos recibidos en CustomContent:', $request->all());

            // 🧪 Validación
            $data = $request->validate([
                'model'     => 'required|string',
                'model_id'  => 'required|integer',
                'key'       => 'required|string|max:255',
                'value'     => 'nullable',
                'type'      => 'nullable|string|in:text,html,image,color,json',
            ]);

            // 🧠 Resolver modelo dinámicamente
            $modelClass = 'App\\Models\\' . Str::studly($data['model']);

            if (! class_exists($modelClass)) {
                return response()->json([
                    'message' => 'Modelo no válido'
                ], 422);
            }

            // 🔍 Si model_id es 0, buscar o crear un registro genérico
            // Esto permite contenido de página sin estar asociado a un registro específico
            if ($data['model_id'] == 0) {
                // Para contenido genérico, buscar o crear manualmente
                $content = CustomContent::where([
                    'contentable_type' => $modelClass,
                    'contentable_id' => 0,
                    'key' => $data['key'],
                ])->first();

                if ($content) {
                    // Actualizar si existe
                    $content->update([
                        'value' => $data['value'],
                        'type'  => $data['type'] ?? 'text',
                    ]);
                } else {
                    // Crear si no existe
                    $content = CustomContent::create([
                        'contentable_type' => $modelClass,
                        'contentable_id' => 0,
                        'key' => $data['key'],
                        'value' => $data['value'],
                        'type'  => $data['type'] ?? 'text',
                    ]);
                }
            } else {
                // Para contenido específico, usar la relación polimórfica del modelo
                $modelInstance = $modelClass::findOrFail($data['model_id']);

                $content = $modelInstance->customContents()->updateOrCreate(
                    [
                        'key' => $data['key'],
                    ],
                    [
                        'value' => $data['value'],
                        'type'  => $data['type'] ?? 'text',
                    ]
                );
            }

            return response()->json([
                'message' => 'Contenido actualizado correctamente',
                'data'    => $content,
            ]);
            
        } catch (\Illuminate\Auth\Access\AuthorizationException $e) {
            return response()->json([
                'message' => 'No tienes permisos para editar contenido público'
            ], 403);
            
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'message' => 'Error de validación',
                'errors' => $e->errors()
            ], 422);
            
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'message' => 'El registro solicitado no existe'
            ], 404);
            
        } catch (\Exception $e) {
            Log::error('Error al guardar contenido personalizado: ' . $e->getMessage(), [
                'exception' => get_class($e),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString(),
            ]);
            return response()->json([
                'message' => 'Error al guardar el contenido: ' . $e->getMessage()
            ], 500);
        }
    }
}
