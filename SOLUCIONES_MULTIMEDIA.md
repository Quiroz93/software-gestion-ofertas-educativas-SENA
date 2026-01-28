# 🔧 Soluciones de Implementación - Fallos Multimedia

**Documento Complementario a:** [FALLOS_MULTIMEDIA_VISTAS_EDITABLES.md](FALLOS_MULTIMEDIA_VISTAS_EDITABLES.md)

---

## 1️⃣ FIX CRÍTICA: Path Traversal Validation

**Archivo:** `app/Http/Controllers/Public/MediaContentController.php`

```php
<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\CustomContent;
use App\Services\MediaService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

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
     */
    public function list(Request $request)
    {
        try {
            $type = $request->get('type', 'image');
            $category = $request->get('category', 'general');
            $page = $request->get('page', 1);
            $perPage = 12;

            // Validar categoria para evitar path traversal
            if (!$this->isValidCategory($category)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Categoría no válida'
                ], 422);
            }

            $allFiles = $this->mediaService->listFiles($type, $category);

            $total = count($allFiles);
            $totalPages = ceil($total / $perPage);
            $page = max(1, min($page, $totalPages));
            
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
     * Upload de archivo con validaciones completas
     */
    public function upload(Request $request)
    {
        try {
            $this->authorize('public_content.edit');

            $maxSize = 51200; // 50MB en KB

            $request->validate([
                'file' => 'required|file|mimes:jpeg,jpg,png,gif,webp,mp4,webm,ogv|max:' . $maxSize,
                'type' => 'required|in:image,video,gif',
                'category' => 'required|string|alpha_dash|max:50'
            ]);

            // ✅ Validar categoría
            if (!$this->isValidCategory($request->category)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Categoría no válida'
                ], 422);
            }

            // ✅ Validar MIME type real
            $this->validateRealMimeType($request->file('file'), $request->type);

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
            Log::error('Error al subir archivo: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al subir archivo',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Guardar referencia multimedia con validaciones
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
                    'starts_with:media/',      // ✅ FIX: Restringir a carpeta media
                    'not_regex:/\.\.\//',      // ✅ FIX: Prohibir path traversal
                ],
                'type' => 'required|in:image,video,gif',
                'metadata' => 'nullable|array'
            ]);

            // ✅ FIX: Validar que el archivo existe en storage
            if (!Storage::disk('public')->exists($request->file_path)) {
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

            // Guardar referencia
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

        } catch (\Exception $e) {
            Log::error('Error al guardar multimedia: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al guardar multimedia',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * ✅ FIX: Eliminar archivo con eliminación en cascada
     */
    public function delete(Request $request)
    {
        try {
            $this->authorize('public_content.edit');

            $request->validate([
                'file_path' => [
                    'required',
                    'string',
                    'starts_with:media/',      // ✅ FIX: Restringir a carpeta media
                    'not_regex:/\.\.\//',      // ✅ FIX: Prohibir path traversal
                ]
            ]);

            $filePath = $request->file_path;

            // ✅ FIX: Paso 1 - Eliminar todas las referencias en custom_contents
            $referencesDeleted = CustomContent::where('value', $filePath)
                ->delete();

            // ✅ FIX: Log de referencias eliminadas
            if ($referencesDeleted > 0) {
                Log::info("Eliminadas {$referencesDeleted} referencias a {$filePath}");
            }

            // ✅ FIX: Paso 2 - Eliminar archivo físico
            $fileDeleted = $this->mediaService->deleteFile($filePath);

            if (!$fileDeleted) {
                Log::warning("Archivo no encontrado para eliminar: {$filePath}");
                return response()->json([
                    'success' => false,
                    'message' => 'El archivo no se encontró en el servidor'
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

    // ============ Métodos Privados ============

    /**
     * ✅ FIX: Validar que la categoría es permitida
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
            'general'
        ];

        return in_array($category, $allowedCategories);
    }

    /**
     * ✅ FIX: Validar MIME type real vs declarado
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

        // ✅ Validar MIME real
        if (!in_array($realMime, $allowedMimes)) {
            throw new \InvalidArgumentException(
                "El archivo no es un {$type} válido. MIME real: {$realMime}"
            );
        }

        // ✅ Detectar double extensions
        $extension = strtolower($file->getClientOriginalExtension());
        $filename = $file->getClientOriginalName();
        
        if (substr_count($filename, '.') > 1) {
            // Potencial double extension como .php.jpg
            $parts = explode('.', $filename);
            $secondToLast = strtolower($parts[-2]);
            
            if (in_array($secondToLast, ['php', 'phtml', 'phar', 'php5', 'php7', 'php8'])) {
                throw new \InvalidArgumentException('Extensión de archivo no permitida');
            }
        }
    }
}
```

---

## 2️⃣ FIX: Modelo CustomContent con Metadatos

**Archivo:** `app/Models/CustomContent.php`

```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomContent extends Model
{
    protected $fillable = [
        'contentable_type',
        'contentable_id',
        'key',
        'value',
        'type',
        'metadata',          // ✅ NEW: JSON para metadatos
        'alt_text',          // ✅ NEW: Accesibilidad
        'title',             // ✅ NEW: Accesibilidad
    ];

    protected $casts = [
        'metadata' => 'array',   // ✅ Castear a array JSON
    ];

    /**
     * Relación polimórfica inversa
     */
    public function contentable()
    {
        return $this->morphTo();
    }

    /**
     * ✅ NEW: Obtener URL verificada (si es multimedia)
     */
    public function getVerifiedUrl(): ?string
    {
        if (!in_array($this->type, ['image', 'video', 'gif'])) {
            return null;
        }

        // Si almacenamos rutas relativas, construir URL completa
        $path = $this->value;
        
        if (str_starts_with($path, 'media/')) {
            return asset('storage/' . $path);
        }

        return $this->value;
    }

    /**
     * ✅ NEW: Verificar si el archivo existe
     */
    public function fileExists(): bool
    {
        if (!in_array($this->type, ['image', 'video', 'gif'])) {
            return true; // No es multimedia
        }

        $path = $this->value;
        
        if (str_starts_with($path, 'storage/')) {
            $path = str_replace('storage/', '', $path);
        }

        return \Illuminate\Support\Facades\Storage::disk('public')
            ->exists($path);
    }

    /**
     * ✅ NEW: Obtener metadata segura
     */
    public function getMetadata($key, $default = null)
    {
        return $this->metadata[$key] ?? $default;
    }
}
```

---

## 3️⃣ FIX: Helper con Validación de Existencia

**Archivo:** `app/Helpers/helpers.php`

```php
<?php

use App\Models\CustomContent;
use Illuminate\Support\Facades\Storage;

if (!function_exists('getCustomContent')) {
    /**
     * ✅ Obtener contenido personalizado con validación
     * 
     * @param string $modelName - Nombre del modelo
     * @param string $key - Clave del contenido
     * @param mixed $default - Valor por defecto
     * @return mixed
     */
    function getCustomContent($modelName, $key, $default = null)
    {
        $modelClass = 'App\\Models\\' . ucfirst($modelName);
        
        if (!class_exists($modelClass)) {
            return $default;
        }
        
        $content = CustomContent::where([
            'contentable_type' => $modelClass,
            'contentable_id' => 0,
            'key' => $key,
        ])->first();
        
        if (!$content) {
            return $default;
        }

        // ✅ FIX: Si es multimedia, validar que existe
        if (in_array($content->type, ['image', 'video', 'gif'])) {
            if (!$content->fileExists()) {
                // Archivo no existe - retornar default
                return $default;
            }
        }

        return $content->value ?? $default;
    }
}

if (!function_exists('getMediaUrl')) {
    /**
     * ✅ NEW: Obtener URL de multimedia verificada
     */
    function getMediaUrl($modelName, $key, $default = null)
    {
        $modelClass = 'App\\Models\\' . ucfirst($modelName);
        
        if (!class_exists($modelClass)) {
            return $default;
        }
        
        $content = CustomContent::where([
            'contentable_type' => $modelClass,
            'contentable_id' => 0,
            'key' => $key,
        ])->first();
        
        if (!$content) {
            return $default;
        }

        // Validar existencia
        if (!$content->fileExists()) {
            return $default;
        }

        return $content->getVerifiedUrl() ?? $default;
    }
}

if (!function_exists('getMediaMetadata')) {
    /**
     * ✅ NEW: Obtener metadatos de multimedia
     */
    function getMediaMetadata($modelName, $key, $metadataKey = null, $default = null)
    {
        $modelClass = 'App\\Models\\' . ucfirst($modelName);
        
        if (!class_exists($modelClass)) {
            return $default;
        }
        
        $content = CustomContent::where([
            'contentable_type' => $modelClass,
            'contentable_id' => 0,
            'key' => $key,
        ])->first();
        
        if (!$content) {
            return $default;
        }

        if ($metadataKey) {
            return $content->getMetadata($metadataKey, $default);
        }

        return $content->metadata ?? $default;
    }
}
```

---

## 4️⃣ FIX: Migración para Agregar Campos

**Archivo:** `database/migrations/2026_01_27_add_multimedia_fields.php`

```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Agregar campos de multimedia a custom_contents
     */
    public function up(): void
    {
        Schema::table('custom_contents', function (Blueprint $table) {
            // ✅ Agregar columnas si no existen
            if (!Schema::hasColumn('custom_contents', 'metadata')) {
                $table->json('metadata')->nullable()->after('type');
            }

            if (!Schema::hasColumn('custom_contents', 'alt_text')) {
                $table->string('alt_text')->nullable()->after('metadata');
            }

            if (!Schema::hasColumn('custom_contents', 'title')) {
                $table->string('title')->nullable()->after('alt_text');
            }

            // ✅ Agregar índices para mejor rendimiento
            $table->index(['contentable_type', 'contentable_id', 'key']);
        });
    }

    /**
     * Revertir cambios
     */
    public function down(): void
    {
        Schema::table('custom_contents', function (Blueprint $table) {
            $table->dropColumn(['metadata', 'alt_text', 'title']);
            $table->dropIndex(['contentable_type', 'contentable_id', 'key']);
        });
    }
};
```

Ejecutar:
```bash
php artisan migrate
```

---

## 5️⃣ FIX: Vista Editada con Validaciones

**Archivo:** `resources/views/public/ofertas/index.blade.php` (Secciones críticas)

```blade
{{-- ✅ FIX: Usar helper mejorado para validar existencia --}}
@php
    $bannerImageUrl = getMediaUrl('oferta', 'banner_image', asset('images/oferta4.jpeg'));
    $bannerAlt = getMediaMetadata('oferta', 'banner_image', 'alt_text', 'Banner de oferta educativa');
@endphp

<img src="{{ $bannerImageUrl }}"
    class="w-100 position-absolute top-0 start-0 h-100 object-fit-cover opacity-50 editable"
    alt="{{ $bannerAlt }}"
    title="{{ getMediaMetadata('oferta', 'banner_image', 'title', 'Haz clic para editar') }}"
    data-model="oferta"
    data-model-id="0"
    data-key="banner_image"
    data-type="image">

{{-- Loop de ofertas con eager loading --}}
@forelse($ofertas as $oferta)
    @php
        // ✅ FIX: Usar URL verificada
        $imagenUrl = $oferta->customContents()
            ->where('key', 'imagen')
            ->first()
            ?->getVerifiedUrl() ?? asset('images/ofertas/default.jpg');
    @endphp
    
    <div class="col-md-6 col-lg-4">
        <div class="card h-100 shadow-sm border-0">
            <img src="{{ $imagenUrl }}"
                class="card-img-top editable"
                alt="{{ $oferta->custom('imagen_alt', $oferta->nombre) }}"
                title="{{ $oferta->custom('imagen_title', 'Haz clic para editar') }}"
                data-model="oferta"
                data-model-id="{{ $oferta->id }}"
                data-key="imagen"
                data-type="image"
                style="height: 250px; object-fit: cover;">
        </div>
    </div>
@endforelse
```

---

## 6️⃣ FIX: Controlador de Ofertas con Eager Loading

**Archivo:** `app/Http/Controllers/Public/PublicOfertaController.php`

```php
<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Oferta;
use Illuminate\Http\Request;

class PublicOfertaController extends Controller
{
    public function index()
    {
        // ✅ FIX: Eager load de customContents para evitar N+1
        $ofertas = Oferta::where('estado', 'activo')
            ->with([
                'customContents' => function($query) {
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
            ->paginate(12); // ✅ Agregar paginación

        return view('public.ofertas.index', compact('ofertas'));
    }

    public function show(Oferta $oferta)
    {
        abort_unless($oferta->estado === 'activo', 404);

        // ✅ Eager load personalizado
        $oferta->load('customContents');

        return view('public.ofertas.show', compact('oferta'));
    }
}
```

---

## 7️⃣ FIX: JavaScript para Modal Mejorado

**Archivo:** `resources/views/layouts/public.blade.php` (Dentro de la sección de JavaScript)

```javascript
// ✅ FIX: Confirmación más robusta para eliminación
$('.delete-file-btn').on('click', function(e) {
    e.stopPropagation();
    
    const filePath = $(this).closest('.file-card').attr('data-file-path');
    const fileName = $(this).closest('.file-card').find('small').first().text();
    
    // ✅ FIX: Usar modal en lugar de confirm()
    showDeleteConfirmation(fileName, filePath, $(this));
});

function showDeleteConfirmation(fileName, filePath, element) {
    // Crear modal dinámico
    const modalHtml = `
        <div class="modal fade" id="deleteConfirmModal" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content border-danger">
                    <div class="modal-header border-danger">
                        <h5 class="modal-title text-danger">
                            <i class="bi bi-exclamation-triangle"></i> Eliminar archivo
                        </h5>
                        <button type="button" class="btn-close" data-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <p class="mb-0">
                            ¿Estás seguro de que deseas eliminar <strong>"${fileName}"</strong>?
                        </p>
                        <small class="text-danger">
                            Esta acción también eliminará todas las referencias a este archivo en la base de datos.
                        </small>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">
                            Cancelar
                        </button>
                        <button type="button" class="btn btn-danger" id="confirmDeleteBtn">
                            Eliminar
                        </button>
                    </div>
                </div>
            </div>
        </div>
    `;

    $('body').append(modalHtml);
    const $modal = $('#deleteConfirmModal');
    $modal.modal('show');

    // ✅ Acción de confirmación
    $('#confirmDeleteBtn').one('click', function() {
        deleteFileFromServer(filePath, element);
        $modal.on('hidden.bs.modal', function() {
            $(this).remove();
        });
        $modal.modal('hide');
    });

    $modal.on('hidden.bs.modal', function() {
        $(this).remove();
    });
}

// ✅ FIX: Agregar caché headers para lista de archivos
function loadExistingFiles(type) {
    const model = $('#cc-model').val();
    const cacheKey = `files_${type}_${model}`;
    const cachedData = sessionStorage.getItem(cacheKey);
    
    // ✅ Usar caché de sesión si existe y es reciente
    if (cachedData) {
        const data = JSON.parse(cachedData);
        if (Date.now() - data.timestamp < 5 * 60 * 1000) { // 5 minutos
            renderFilesGrid(data.files, type);
            return;
        }
    }

    // Si no hay caché, hacer fetch
    const url = `/public/media/list?type=${type}&category=${model}`;

    fetch(url, {
        headers: {
            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            "Cache-Control": "max-age=300" // 5 minutos
        }
    })
    .then(res => {
        if (!res.ok) throw new Error('Error al cargar archivos');
        return res.json();
    })
    .then(data => {
        // ✅ Guardar en caché
        sessionStorage.setItem(cacheKey, JSON.stringify({
            files: data.files,
            timestamp: Date.now()
        }));

        if (data.files && data.files.length > 0) {
            renderFilesGrid(data.files, type);
        } else {
            $('#filesGrid').html(`
                <div class="col-12 text-center py-5">
                    <i class="bi bi-folder2-open" style="font-size: 3rem; color: #6c757d;"></i>
                    <p class="text-muted mt-3 mb-0">No hay archivos disponibles</p>
                </div>
            `);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        $('#filesGrid').html(`
            <div class="col-12 text-center py-4">
                <i class="bi bi-exclamation-triangle text-danger"></i>
                <p class="text-danger mt-2">Error al cargar archivos</p>
            </div>
        `);
    });
}
```

---

## ✅ Checklist de Implementación

- [ ] Crear migración de campos multimedia
- [ ] Actualizar modelo CustomContent
- [ ] Actualizar helpers con validación
- [ ] Actualizar MediaContentController con todas las validaciones
- [ ] Actualizar PublicOfertaController con eager loading
- [ ] Actualizar vista de ofertas
- [ ] Actualizar JavaScript del modal
- [ ] Probar eliminación de archivos
- [ ] Probar URLs rotas devuelven fallback
- [ ] Prueba de N+1 queries

---

**Tiempo total de implementación:** ~4 horas

