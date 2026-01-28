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
        $this->mediaService = $mediaService;
    }

    /**
     * Listar archivos multimedia existentes (con paginación)
     * 
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function list(Request $request)
    {
        try {
            $type = $request->get('type', 'image');
            $category = $request->get('category', 'general');
            $page = $request->get('page', 1);
            $perPage = 12; // 12 archivos por página (grid 3x4)

            // ✅ FIX: Validar categoría para evitar path traversal
            if (!$this->isValidCategory($category)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Categoría no válida'
                ], 422);
            }

            // Obtener todos los archivos
            $allFiles = $this->mediaService->listFiles($type, $category);

            // Paginar manualmente (los resultados ya están ordenados)
            $total = count($allFiles);
            $totalPages = ceil($total / $perPage);
            $page = max(1, min($page, $totalPages)); // Asegurar página válida
            
            $start = ($page - 1) * $perPage;
            $paginatedFiles = array_slice($allFiles, $start, $perPage);

            return response()->json([
                'success' => true,
                'files' => $paginatedFiles,
                'pagination' => [
                    'page' => (int)$page,
                    'per_page' => $perPage,
                    'total' => $total,
                    'total_pages' => $totalPages,
                    'has_next' => $page < $totalPages,
                    'has_prev' => $page > 1,
                    'next_page' => $page < $totalPages ? $page + 1 : null,
                    'prev_page' => $page > 1 ? $page - 1 : null
                ]
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

            // Determinar límite de tamaño según tipo
            // GIFs: 10MB, otros: 50MB
            $maxSize = $request->type === 'gif' ? 10240 : 51200; // KB

            $request->validate([
                'file' => 'required|file|mimes:jpeg,jpg,png,gif,webp,mp4,webm,ogv|max:' . $maxSize,
                'type' => 'required|in:image,video,gif',
                'category' => 'required|string|alpha_dash|max:50'
            ]);

            // ✅ FIX: Validar categoría
            if (!$this->isValidCategory($request->category)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Categoría no válida'
                ], 422);
            }

            // ✅ FIX: Validar MIME type real
            $this->validateRealMimeType($request->file('file'), $request->type);

            $result = $this->mediaService->processUpload(
                $request->file('file'),
                $request->type,
                $request->category
            );

            // ✅ Return success without thumbnail generation for now
            // Thumbnail and poster generation can be implemented later with proper Image library setup

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
                'model' => 'required|string|alpha_dash|max:50',
                'model_id' => 'required|integer|min:0',
                'key' => 'required|string|max:255',
                'file_path' => [
                    'required',
                    'string',
                    'starts_with:media/',      // ✅ FIX: Debe empezar con media/
                    'regex:/^[a-zA-Z0-9\/._-]+$/',  // ✅ FIX: Solo caracteres seguros
                ],
                'type' => 'required|in:image,video,gif',
                'metadata' => 'nullable|array'
            ]);

            // ✅ FIX: Prohibir path traversal explícitamente
            if (str_contains($request->file_path, '..')) {
                return response()->json([
                    'success' => false,
                    'message' => 'Ruta de archivo no válida (path traversal detectado)'
                ], 422);
            }

            // ✅ FIX: Validar que el archivo existe en storage
            if (!\Illuminate\Support\Facades\Storage::disk('public')->exists($request->file_path)) {
                return response()->json([
                    'success' => false,
                    'message' => 'El archivo no existe en el servidor'
                ], 422);
            }

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
                'file_path' => [
                    'required',
                    'string',
                    'starts_with:media/',      // ✅ FIX: Debe empezar con media/
                    'regex:/^[a-zA-Z0-9\/._-]+$/',  // ✅ FIX: Solo caracteres seguros
                ]
            ]);

            // ✅ FIX: Prohibir path traversal explícitamente
            if (str_contains($request->file_path, '..')) {
                return response()->json([
                    'success' => false,
                    'message' => 'Ruta de archivo no válida (path traversal detectado)'
                ], 422);
            }

            $filePath = $request->file_path;

            // ✅ FIX: Paso 1 - Eliminar todas las referencias en custom_contents
            $referencesDeleted = CustomContent::where('value', $filePath)->delete();

            // Log de referencias eliminadas
            if ($referencesDeleted > 0) {
                Log::info("Eliminadas {$referencesDeleted} referencias a {$filePath}");
            }

            // ✅ FIX: Paso 2 - Eliminar archivo físico
            $fileDeleted = $this->mediaService->deleteFile($filePath);

            if (!$fileDeleted) {
                Log::warning("Archivo no encontrado para eliminar: {$filePath}");
                return response()->json([
                    'success' => false,
                    'message' => 'El archivo no se encontró en el servidor',
                    'data' => [
                        'references_deleted' => $referencesDeleted
                    ]
                ], 404);
            }

            return response()->json([
                'success' => true,
                'message' => 'Archivo y referencias eliminados correctamente',
                'data' => [
                    'references_deleted' => $referencesDeleted,
                    'file_path' => $filePath
                ]
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

    // ============ Métodos Privados de Validación ============

    /**
     * ✅ FIX: Validar que la categoría es permitida (whitelist)
     * 
     * @param string $category
     * @return bool
     */
    private function isValidCategory(string $category): bool
    {
        $allowedCategories = [
            'home',
            'ofertas',
            'programas',
            'instructores',
            'noticias',
            'centros',
            'competencias',
            'redes',
            'general'
        ];

        return in_array($category, $allowedCategories);
    }

    /**
     * ✅ FIX: Validar MIME type real del archivo vs declarado
     * 
     * @param \Illuminate\Http\UploadedFile $file
     * @param string $type
     * @throws \InvalidArgumentException
     */
    private function validateRealMimeType($file, string $type): void
    {
        $clientMime = $file->getMimeType();
        
        // Obtener MIME real del archivo
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $realMime = finfo_file($finfo, $file->getRealPath());
        finfo_close($finfo);

        $allowedMimes = match($type) {
            'image', 'gif' => ['image/jpeg', 'image/png', 'image/gif', 'image/webp'],
            'video' => ['video/mp4', 'video/webm', 'video/ogg'],
            default => []
        };

        // Validar MIME real
        if (!in_array($realMime, $allowedMimes)) {
            throw new \InvalidArgumentException(
                "El archivo no es un {$type} válido. MIME real: {$realMime}"
            );
        }

        // Detectar double extensions (ej: shell.php.jpg)
        $filename = $file->getClientOriginalName();
        
        if (substr_count($filename, '.') > 1) {
            $parts = explode('.', $filename);
            $extensionsCount = count($parts) - 1;
            
            // Verificar si alguna extensión intermedia es peligrosa
            for ($i = 0; $i < $extensionsCount - 1; $i++) {
                $ext = strtolower($parts[$i + 1]);
                if (in_array($ext, ['php', 'phtml', 'phar', 'php3', 'php4', 'php5', 'php7', 'php8', 'exe', 'sh', 'bat'])) {
                    throw new \InvalidArgumentException('Extensión de archivo no permitida');
                }
            }
        }
    }
}
