<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\CustomContent;
use App\Services\MediaService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Log;

class MediaContentController extends Controller
{
    use AuthorizesRequests;

    protected MediaService $mediaService;

    public function __construct(MediaService $mediaService)
    {
        $this->middleware('auth');
        $this->middleware('can:public_content.edit');
        $this->mediaService = $mediaService;
    }

    /**
     * Listar archivos multimedia existentes
     * 
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function list(Request $request)
    {
        try {
            $type = $request->get('type', 'image');
            $category = $request->get('category', 'general');

            $files = $this->mediaService->listFiles($type, $category);

            return response()->json([
                'success' => true,
                'files' => $files,
                'count' => count($files)
            ]);

        } catch (\Exception $e) {
            Log::error('Error al listar archivos multimedia: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al listar archivos',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Upload de nuevo archivo multimedia
     * 
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function upload(Request $request)
    {
        try {
            $this->authorize('public_content.edit');

            $request->validate([
                'file' => 'required|file|mimes:jpeg,jpg,png,gif,webp,mp4,webm,ogv|max:51200', // 50MB
                'type' => 'required|in:image,video,gif',
                'category' => 'required|string|alpha_dash|max:50'
            ]);

            $result = $this->mediaService->processUpload(
                $request->file('file'),
                $request->type,
                $request->category
            );

            return response()->json($result);

        } catch (\Illuminate\Auth\Access\AuthorizationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'No tienes permisos para subir archivos'
            ], 403);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error de validación',
                'errors' => $e->errors()
            ], 422);

        } catch (\InvalidArgumentException $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 422);

        } catch (\Exception $e) {
            Log::error('Error al subir archivo multimedia: ' . $e->getMessage(), [
                'exception' => get_class($e),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);
            return response()->json([
                'success' => false,
                'message' => 'Error al subir archivo',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Guardar referencia multimedia en custom_contents
     * 
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        try {
            $this->authorize('public_content.edit');

            $request->validate([
                'model' => 'required|string',
                'model_id' => 'required|integer',
                'key' => 'required|string|max:255',
                'file_path' => 'required|string',
                'type' => 'required|in:image,video,gif',
                'metadata' => 'nullable|array'
            ]);

            // Resolver modelo dinámicamente
            $modelClass = 'App\\Models\\' . Str::studly($request->model);

            if (!class_exists($modelClass)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Modelo no válido'
                ], 422);
            }

            // Contenido genérico (model_id = 0) o específico
            if ($request->model_id == 0) {
                $content = CustomContent::updateOrCreate(
                    [
                        'contentable_type' => $modelClass,
                        'contentable_id' => 0,
                        'key' => $request->key,
                    ],
                    [
                        'value' => $request->file_path,
                        'type' => $request->type,
                        'metadata' => $request->metadata
                    ]
                );
            } else {
                $modelInstance = $modelClass::findOrFail($request->model_id);

                $content = $modelInstance->customContents()->updateOrCreate(
                    ['key' => $request->key],
                    [
                        'value' => $request->file_path,
                        'type' => $request->type,
                        'metadata' => $request->metadata
                    ]
                );
            }

            return response()->json([
                'success' => true,
                'message' => 'Multimedia guardado correctamente',
                'data' => $content
            ]);

        } catch (\Illuminate\Auth\Access\AuthorizationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'No tienes permisos para editar contenido público'
            ], 403);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error de validación',
                'errors' => $e->errors()
            ], 422);

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'El registro solicitado no existe'
            ], 404);

        } catch (\Exception $e) {
            Log::error('Error al guardar multimedia: ' . $e->getMessage(), [
                'exception' => get_class($e),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);
            return response()->json([
                'success' => false,
                'message' => 'Error al guardar multimedia',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Eliminar archivo multimedia
     * 
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete(Request $request)
    {
        try {
            $this->authorize('public_content.edit');

            $request->validate([
                'file_path' => 'required|string'
            ]);

            $deleted = $this->mediaService->deleteFile($request->file_path);

            return response()->json([
                'success' => $deleted,
                'message' => $deleted ? 'Archivo eliminado correctamente' : 'Error al eliminar archivo'
            ]);

        } catch (\Illuminate\Auth\Access\AuthorizationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'No tienes permisos para eliminar archivos'
            ], 403);

        } catch (\Exception $e) {
            Log::error('Error al eliminar archivo: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al eliminar archivo',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
