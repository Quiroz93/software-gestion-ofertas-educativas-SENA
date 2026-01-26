# Plan de Integración de Elementos Multimedia en Vistas Públicas Editables

## 📋 Índice
1. [Análisis del Sistema Actual](#análisis-del-sistema-actual)
2. [Objetivos del Plan](#objetivos-del-plan)
3. [Arquitectura Propuesta](#arquitectura-propuesta)
4. [Diseño de Base de Datos](#diseño-de-base-de-datos)
5. [Componentes Técnicos](#componentes-técnicos)
6. [Flujo de Trabajo del Usuario](#flujo-de-trabajo-del-usuario)
7. [Implementación Frontend](#implementación-frontend)
8. [Implementación Backend](#implementación-backend)
9. [Soporte Multimedia Extendido](#soporte-multimedia-extendido)
10. [Seguridad y Validaciones](#seguridad-y-validaciones)
11. [Plan de Implementación por Fases](#plan-de-implementación-por-fases)
12. [Casos de Uso](#casos-de-uso)

---

## 📊 Análisis del Sistema Actual

### Estado Actual del Sistema

#### ✅ Componentes Existentes

**1. Modelo CustomContent**
```php
// Ubicación: app/Models/CustomContent.php
protected $fillable = [
    'contentable_type',  // Modelo polimórfico
    'contentable_id',    // ID del registro (0 = genérico)
    'key',               // Clave única del contenido
    'value',             // Valor almacenado (texto)
    'type',              // Tipo: text, html, image, color, json
];
```

**Capacidades actuales:**
- ✅ Almacenamiento de texto plano
- ✅ Soporte teórico para tipo `image` (ya validado)
- ✅ Relación polimórfica con cualquier modelo
- ✅ Contenido genérico (model_id = 0)
- ✅ Contenido específico por registro

**Limitaciones:**
- ❌ Solo almacena rutas de archivos como texto
- ❌ No hay gestión física de archivos
- ❌ No hay validación de existencia de archivos
- ❌ No hay preview ni file chooser
- ❌ No hay eliminación de archivos obsoletos

**2. Controller CustomContentController**
```php
// Ubicación: app/Http/Controllers/Public/CustomContentController.php
public function store(Request $request)
{
    $data = $request->validate([
        'model'     => 'required|string',
        'model_id'  => 'required|integer',
        'key'       => 'required|string|max:255',
        'value'     => 'nullable',
        'type'      => 'nullable|string|in:text,html,image,color,json',
    ]);
    // ... lógica de almacenamiento
}
```

**Capacidades actuales:**
- ✅ Validación básica de datos
- ✅ Manejo de contenido genérico y específico
- ✅ Autorización mediante `public_content.edit`
- ✅ Manejo de errores robusto

**Limitaciones:**
- ❌ Solo acepta texto en `value`
- ❌ No procesa archivos upload (multipart/form-data)
- ❌ No gestiona almacenamiento físico
- ❌ No valida archivos multimedia

**3. Vista Public Layout - Modal de Edición**
```javascript
// Ubicación: resources/views/layouts/public.blade.php
// Modal básico con textarea para texto
<textarea class="form-control" id="cc-value" rows="4"></textarea>
```

**Capacidades actuales:**
- ✅ Modal Bootstrap 4 funcional
- ✅ Edición de texto plano
- ✅ Detección de elementos `.editable`
- ✅ Guardado mediante Fetch API

**Limitaciones:**
- ❌ Solo textarea para texto
- ❌ No hay file input
- ❌ No hay preview de imágenes
- ❌ No hay file browser/chooser
- ❌ Interfaz única para todos los tipos

**4. Sistema de Archivos**

**Configuración actual:**
```php
// config/filesystems.php
'disks' => [
    'public' => [
        'driver' => 'local',
        'root' => storage_path('app/public'),
        'url' => env('APP_URL').'/storage',
        'visibility' => 'public',
    ],
],
```

**Estructura de archivos:**
```
public/
├── images/              ← Archivos estáticos actuales
│   ├── oferta1.jpeg
│   ├── oferta2.jpeg
│   └── ...
storage/app/public/      ← Archivos dinámicos (vacío actualmente)
```

**Estado:**
- ✅ Disco `public` configurado
- ⚠️ Symlink `php artisan storage:link` probablemente no ejecutado
- ⚠️ Imágenes estáticas en `public/images/`
- ❌ No hay organización por módulos
- ❌ No hay limpieza de archivos huérfanos

### Flujo Actual de Edición de Texto

```
┌─────────────────────────────────────────────────────────────┐
│ Usuario autenticado con permiso 'public_content.edit'      │
└──────────────────────┬──────────────────────────────────────┘
                       ▼
         ┌──────────────────────────┐
         │ Click en elemento con    │
         │ class="editable"         │
         │ data-type="text"         │
         └──────────┬───────────────┘
                    ▼
         ┌──────────────────────────┐
         │ Modal se abre con:       │
         │ - Textarea con valor     │
         │ - Botón Guardar          │
         │ - Botón Cancelar         │
         └──────────┬───────────────┘
                    ▼
         ┌──────────────────────────┐
         │ Usuario edita texto      │
         │ y presiona Guardar       │
         └──────────┬───────────────┘
                    ▼
         ┌──────────────────────────┐
         │ Fetch POST a             │
         │ /public/content/store    │
         │ JSON: {model, key, value}│
         └──────────┬───────────────┘
                    ▼
         ┌──────────────────────────┐
         │ Controller valida y      │
         │ guarda en custom_contents│
         └──────────┬───────────────┘
                    ▼
         ┌──────────────────────────┐
         │ Response JSON success    │
         │ Modal se cierra          │
         │ Contenido se actualiza   │
         └──────────────────────────┘
```

### Diagnóstico Técnico

| Componente | Estado | Notas |
|------------|--------|-------|
| Base de datos | ✅ Lista | Campo `type` soporta `image` |
| Validación backend | ✅ Lista | Ya acepta tipo `image` |
| Storage config | ✅ Lista | Disco `public` configurado |
| Modal UI | ⚠️ Requiere extensión | Solo soporta textarea |
| File upload | ❌ No existe | Necesario implementar |
| File browser | ❌ No existe | Necesario implementar |
| Preview | ❌ No existe | Necesario implementar |
| Gestión física | ❌ No existe | Necesario implementar |

---

## 🎯 Objetivos del Plan

### Objetivos Funcionales

1. **Edición de Imágenes**
   - ✅ Click en imagen editable abre modal especializado
   - ✅ Selección desde carpetas del sistema
   - ✅ Upload de nuevas imágenes
   - ✅ Preview antes de guardar
   - ✅ Reemplazo de imagen actual

2. **Edición de Videos**
   - ✅ Soporte para MP4, WebM, OGG
   - ✅ Upload con validación de tamaño
   - ✅ Preview con reproductor
   - ✅ Integración con YouTube/Vimeo (opcional)

3. **Edición de GIFs**
   - ✅ Tratamiento como imagen
   - ✅ Preview animado
   - ✅ Validación de tamaño

### Objetivos Técnicos

1. **Backend**
   - ✅ Endpoint para upload de archivos
   - ✅ Endpoint para listar archivos existentes
   - ✅ Validación por tipo MIME
   - ✅ Gestión de almacenamiento
   - ✅ Limpieza de archivos obsoletos

2. **Frontend**
   - ✅ Modal dinámico según tipo de contenido
   - ✅ File browser con vista previa
   - ✅ Drag & drop upload
   - ✅ Progress bar para uploads
   - ✅ Crop/resize de imágenes (opcional)

3. **Seguridad**
   - ✅ Validación de tipos de archivo
   - ✅ Límites de tamaño
   - ✅ Sanitización de nombres
   - ✅ Autorización consistente

---

## 🏗️ Arquitectura Propuesta

### Diagrama de Componentes

```
┌─────────────────────────────────────────────────────────────┐
│                     VISTA PÚBLICA                           │
│  ┌──────────────┐  ┌──────────────┐  ┌──────────────┐     │
│  │ Elemento     │  │ Elemento     │  │ Elemento     │     │
│  │ Editable     │  │ Editable     │  │ Editable     │     │
│  │ type="text"  │  │ type="image" │  │ type="video" │     │
│  └──────┬───────┘  └──────┬───────┘  └──────┬───────┘     │
└─────────┼──────────────────┼──────────────────┼─────────────┘
          │                  │                  │
          ▼                  ▼                  ▼
┌─────────────────────────────────────────────────────────────┐
│               SISTEMA DE MODAL DINÁMICO                     │
│  ┌──────────────────────────────────────────────────────┐  │
│  │ Detector de Tipo (data-type)                         │  │
│  └────┬─────────────────────┬──────────────────┬────────┘  │
│       │                     │                  │            │
│  ┌────▼─────┐         ┌─────▼────┐      ┌─────▼────┐      │
│  │ Text     │         │ Media    │      │ Video    │      │
│  │ Editor   │         │ Manager  │      │ Manager  │      │
│  └──────────┘         └────┬─────┘      └────┬─────┘      │
│                            │                  │            │
│                   ┌────────▼──────────────────▼────┐       │
│                   │  File Browser Component        │       │
│                   │  - Lista archivos existentes   │       │
│                   │  - Upload nuevo archivo        │       │
│                   │  - Preview en tiempo real      │       │
│                   └────────┬───────────────────────┘       │
└────────────────────────────┼───────────────────────────────┘
                             │
                             ▼
┌─────────────────────────────────────────────────────────────┐
│                    BACKEND API                              │
│  ┌──────────────────────────────────────────────────────┐  │
│  │ MediaContentController                                │  │
│  │  - upload(Request)      → Subir archivo              │  │
│  │  - list(Request)        → Listar archivos            │  │
│  │  - delete(Request)      → Eliminar archivo           │  │
│  │  - store(Request)       → Guardar referencia         │  │
│  └────────────────┬─────────────────────────────────────┘  │
│                   │                                         │
│  ┌────────────────▼─────────────────────────────────────┐  │
│  │ MediaService                                          │  │
│  │  - processUpload()     → Validar y almacenar         │  │
│  │  - generateThumbnail() → Crear miniatura             │  │
│  │  - cleanOrphans()      → Limpiar archivos huérfanos  │  │
│  └────────────────┬─────────────────────────────────────┘  │
└───────────────────┼───────────────────────────────────────-┘
                    │
                    ▼
┌─────────────────────────────────────────────────────────────┐
│                SISTEMA DE ARCHIVOS                          │
│  ┌──────────────────────────────────────────────────────┐  │
│  │ storage/app/public/                                   │  │
│  │  ├── media/                                           │  │
│  │  │   ├── images/                                      │  │
│  │  │   │   ├── ofertas/                                 │  │
│  │  │   │   ├── programas/                               │  │
│  │  │   │   └── general/                                 │  │
│  │  │   ├── videos/                                      │  │
│  │  │   └── thumbnails/                                  │  │
│  └──────────────────────────────────────────────────────┘  │
│                                                             │
│  ┌──────────────────────────────────────────────────────┐  │
│  │ Database: custom_contents                             │  │
│  │  - value: "media/images/ofertas/banner-123.jpg"      │  │
│  │  - type: "image"                                      │  │
│  │  - metadata: JSON con dimensiones, tamaño, etc.      │  │
│  └──────────────────────────────────────────────────────┘  │
└─────────────────────────────────────────────────────────────┘
```

---

## 🗄️ Diseño de Base de Datos

### Extensión de la Tabla `custom_contents`

```sql
ALTER TABLE custom_contents 
ADD COLUMN metadata JSON NULL COMMENT 'Metadatos del archivo (dimensiones, tamaño, mime_type, etc.)';
```

**Estructura extendida:**
```php
Schema::table('custom_contents', function (Blueprint $table) {
    $table->json('metadata')->nullable()->after('type');
});
```

### Estructura de Metadata para Imágenes

```json
{
    "file_name": "banner-ofertas-2024.jpg",
    "file_path": "media/images/ofertas/banner-ofertas-2024.jpg",
    "file_size": 245678,
    "mime_type": "image/jpeg",
    "dimensions": {
        "width": 1920,
        "height": 1080
    },
    "thumbnail": "media/thumbnails/ofertas/banner-ofertas-2024-thumb.jpg",
    "uploaded_at": "2026-01-26T10:30:00Z",
    "uploaded_by": 5
}
```

### Estructura de Metadata para Videos

```json
{
    "file_name": "video-institucional.mp4",
    "file_path": "media/videos/institucional/video-institucional.mp4",
    "file_size": 15728640,
    "mime_type": "video/mp4",
    "duration": 120,
    "dimensions": {
        "width": 1280,
        "height": 720
    },
    "thumbnail": "media/thumbnails/videos/video-institucional-thumb.jpg",
    "uploaded_at": "2026-01-26T10:30:00Z",
    "uploaded_by": 5,
    "external_url": null
}
```

### Índices Recomendados

```sql
-- Índice para búsquedas por tipo
CREATE INDEX idx_custom_contents_type ON custom_contents(type);

-- Índice compuesto para búsquedas frecuentes
CREATE INDEX idx_custom_contents_lookup 
ON custom_contents(contentable_type, contentable_id, type);
```

---

## 🧩 Componentes Técnicos

### 1. Backend: MediaContentController

**Ubicación:** `app/Http/Controllers/Public/MediaContentController.php`

```php
<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Services\MediaService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MediaContentController extends Controller
{
    protected MediaService $mediaService;

    public function __construct(MediaService $mediaService)
    {
        $this->middleware('auth');
        $this->middleware('can:public_content.edit');
        $this->mediaService = $mediaService;
    }

    /**
     * Listar archivos multimedia existentes
     */
    public function list(Request $request)
    {
        $type = $request->get('type', 'image'); // image, video
        $category = $request->get('category', 'general'); // ofertas, programas, general
        
        $files = $this->mediaService->listFiles($type, $category);
        
        return response()->json([
            'files' => $files,
            'count' => count($files)
        ]);
    }

    /**
     * Upload de nuevo archivo multimedia
     */
    public function upload(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:jpeg,jpg,png,gif,webp,mp4,webm,ogv|max:51200', // 50MB
            'type' => 'required|in:image,video,gif',
            'category' => 'required|string'
        ]);

        $result = $this->mediaService->processUpload(
            $request->file('file'),
            $request->type,
            $request->category
        );

        return response()->json($result);
    }

    /**
     * Guardar referencia multimedia en custom_contents
     */
    public function store(Request $request)
    {
        $request->validate([
            'model' => 'required|string',
            'model_id' => 'required|integer',
            'key' => 'required|string',
            'file_path' => 'required|string',
            'type' => 'required|in:image,video,gif',
            'metadata' => 'nullable|array'
        ]);

        // Lógica similar a CustomContentController::store
        // pero especializada para multimedia
        
        return response()->json([
            'message' => 'Multimedia guardado correctamente'
        ]);
    }

    /**
     * Eliminar archivo multimedia
     */
    public function delete(Request $request)
    {
        $request->validate([
            'file_path' => 'required|string'
        ]);

        $deleted = $this->mediaService->deleteFile($request->file_path);

        return response()->json([
            'success' => $deleted,
            'message' => $deleted ? 'Archivo eliminado' : 'Error al eliminar'
        ]);
    }
}
```

### 2. Backend: MediaService

**Ubicación:** `app/Services/MediaService.php`

```php
<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image; // Opcional: para thumbnails

class MediaService
{
    protected string $disk = 'public';
    protected array $allowedImageMimes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
    protected array $allowedVideoMimes = ['video/mp4', 'video/webm', 'video/ogg'];

    /**
     * Procesar upload de archivo
     */
    public function processUpload(UploadedFile $file, string $type, string $category): array
    {
        // 1. Validar tipo MIME
        $this->validateMimeType($file, $type);

        // 2. Generar nombre único
        $fileName = $this->generateFileName($file);

        // 3. Determinar ruta de almacenamiento
        $path = $this->getStoragePath($type, $category);

        // 4. Almacenar archivo
        $filePath = $file->storeAs($path, $fileName, $this->disk);

        // 5. Generar metadata
        $metadata = $this->generateMetadata($file, $filePath, $type);

        // 6. Generar thumbnail si es necesario
        if ($type === 'image') {
            $metadata['thumbnail'] = $this->generateThumbnail($filePath);
        }

        return [
            'success' => true,
            'file_path' => $filePath,
            'url' => Storage::disk($this->disk)->url($filePath),
            'metadata' => $metadata
        ];
    }

    /**
     * Listar archivos existentes
     */
    public function listFiles(string $type, string $category): array
    {
        $path = $this->getStoragePath($type, $category);
        $files = Storage::disk($this->disk)->files($path);

        return collect($files)->map(function ($file) {
            return [
                'path' => $file,
                'url' => Storage::disk($this->disk)->url($file),
                'name' => basename($file),
                'size' => Storage::disk($this->disk)->size($file),
                'modified' => Storage::disk($this->disk)->lastModified($file)
            ];
        })->toArray();
    }

    /**
     * Eliminar archivo
     */
    public function deleteFile(string $filePath): bool
    {
        // Eliminar archivo principal
        $deleted = Storage::disk($this->disk)->delete($filePath);

        // Eliminar thumbnail si existe
        $thumbPath = str_replace('media/', 'media/thumbnails/', $filePath);
        Storage::disk($this->disk)->delete($thumbPath);

        return $deleted;
    }

    /**
     * Limpiar archivos huérfanos (sin referencias en DB)
     */
    public function cleanOrphans(): int
    {
        // TODO: Implementar lógica para comparar archivos físicos
        // con referencias en custom_contents y eliminar los que no existen
        return 0;
    }

    // ============ Métodos Privados ============

    private function validateMimeType(UploadedFile $file, string $type): void
    {
        $mime = $file->getMimeType();
        
        $allowed = match($type) {
            'image', 'gif' => $this->allowedImageMimes,
            'video' => $this->allowedVideoMimes,
            default => []
        };

        if (!in_array($mime, $allowed)) {
            throw new \InvalidArgumentException("Tipo de archivo no permitido: {$mime}");
        }
    }

    private function generateFileName(UploadedFile $file): string
    {
        $extension = $file->getClientOriginalExtension();
        $baseName = Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME));
        $unique = Str::random(8);
        
        return "{$baseName}-{$unique}.{$extension}";
    }

    private function getStoragePath(string $type, string $category): string
    {
        return match($type) {
            'image', 'gif' => "media/images/{$category}",
            'video' => "media/videos/{$category}",
            default => "media/general/{$category}"
        };
    }

    private function generateMetadata(UploadedFile $file, string $filePath, string $type): array
    {
        $metadata = [
            'file_name' => $file->getClientOriginalName(),
            'file_path' => $filePath,
            'file_size' => $file->getSize(),
            'mime_type' => $file->getMimeType(),
            'uploaded_at' => now()->toISOString(),
            'uploaded_by' => auth()->id()
        ];

        // Agregar dimensiones para imágenes
        if ($type === 'image' || $type === 'gif') {
            $fullPath = Storage::disk($this->disk)->path($filePath);
            [$width, $height] = getimagesize($fullPath);
            $metadata['dimensions'] = compact('width', 'height');
        }

        return $metadata;
    }

    private function generateThumbnail(string $filePath): ?string
    {
        // Requiere: composer require intervention/image
        // TODO: Implementar generación de thumbnail con Intervention Image
        return null;
    }
}
```

### 3. Frontend: Modal Dinámico Extendido

**Ubicación:** `resources/views/layouts/public.blade.php`

**Cambios necesarios:**

1. **Detectar tipo de elemento**
2. **Renderizar modal apropiado**
3. **File browser component**
4. **Preview component**

```javascript
// Modal HTML extendido
<div class="modal fade" id="editContentModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitle">Editar contenido</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>

            <div class="modal-body">
                
                <!-- Tab para TEXTO (existente) -->
                <div id="textEditor" style="display: none;">
                    <textarea class="form-control" id="cc-value" rows="4"></textarea>
                </div>

                <!-- Tab para MULTIMEDIA (NUEVO) -->
                <div id="mediaEditor" style="display: none;">
                    
                    <!-- Preview actual -->
                    <div class="mb-3">
                        <label class="form-label">Archivo actual:</label>
                        <div id="currentMediaPreview" class="border p-3 text-center">
                            <p class="text-muted">No hay archivo asignado</p>
                        </div>
                    </div>

                    <!-- Tabs: Seleccionar existente o Upload nuevo -->
                    <ul class="nav nav-tabs mb-3" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" data-toggle="tab" href="#existingFiles">
                                Archivos existentes
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#uploadNew">
                                Subir nuevo
                            </a>
                        </li>
                    </ul>

                    <div class="tab-content">
                        
                        <!-- TAB 1: Archivos existentes -->
                        <div id="existingFiles" class="tab-pane fade show active">
                            <div class="mb-3">
                                <input type="text" class="form-control" 
                                       id="fileSearchInput" 
                                       placeholder="Buscar archivo...">
                            </div>
                            <div id="filesGrid" class="row g-2" style="max-height: 300px; overflow-y: auto;">
                                <!-- Grid de archivos cargado dinámicamente -->
                            </div>
                        </div>

                        <!-- TAB 2: Upload nuevo -->
                        <div id="uploadNew" class="tab-pane fade">
                            <div class="mb-3">
                                <label class="form-label">Seleccionar archivo:</label>
                                <input type="file" class="form-control" 
                                       id="mediaFileInput" 
                                       accept="image/*,video/*">
                            </div>

                            <!-- Drag & Drop area -->
                            <div id="dropZone" class="border border-dashed p-5 text-center">
                                <i class="bi bi-cloud-upload fs-1"></i>
                                <p>Arrastra un archivo aquí o haz click para seleccionar</p>
                            </div>

                            <!-- Progress bar -->
                            <div id="uploadProgress" class="mt-3" style="display: none;">
                                <div class="progress">
                                    <div class="progress-bar" role="progressbar"></div>
                                </div>
                            </div>

                            <!-- Preview del nuevo archivo -->
                            <div id="newMediaPreview" class="mt-3" style="display: none;">
                                <label class="form-label">Vista previa:</label>
                                <div class="border p-3 text-center">
                                    <!-- Preview se carga aquí -->
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                    Cancelar
                </button>
                <button type="button" class="btn btn-primary" id="saveContentBtn">
                    Guardar cambios
                </button>
            </div>

        </div>
    </div>
</div>
```

### 4. Frontend: JavaScript Extendido

```javascript
$(function () {
    const $modal = $('#editContentModal');
    let currentEditable = null;
    let currentType = 'text';
    let selectedFile = null;

    // ========== DETECCIÓN Y APERTURA DEL MODAL ==========
    $('.editable').on('click', function () {
        currentEditable = this;
        currentType = this.dataset.type || 'text';

        // Rellenar datos comunes
        $('#cc-model').val(this.dataset.model);
        $('#cc-model-id').val(this.dataset.modelId);
        $('#cc-key').val(this.dataset.key);

        // Mostrar editor apropiado
        if (currentType === 'text' || currentType === 'html') {
            showTextEditor(this);
        } else if (['image', 'video', 'gif'].includes(currentType)) {
            showMediaEditor(this, currentType);
        }

        $modal.modal('show');
    });

    // ========== EDITOR DE TEXTO ==========
    function showTextEditor(element) {
        $('#modalTitle').text('Editar texto');
        $('#textEditor').show();
        $('#mediaEditor').hide();
        $('#cc-value').val(element.innerText.trim());
    }

    // ========== EDITOR DE MULTIMEDIA ==========
    function showMediaEditor(element, type) {
        $('#modalTitle').text(`Editar ${type === 'image' ? 'imagen' : 'video'}`);
        $('#textEditor').hide();
        $('#mediaEditor').show();

        // Cargar preview actual
        loadCurrentMediaPreview(element, type);

        // Cargar archivos existentes
        loadExistingFiles(type, element.dataset.model);
    }

    // Cargar preview del archivo actual
    function loadCurrentMediaPreview(element, type) {
        const currentSrc = type === 'image' 
            ? element.getAttribute('src') || element.dataset.src
            : element.querySelector('source')?.getAttribute('src');

        if (currentSrc) {
            const preview = type === 'image'
                ? `<img src="${currentSrc}" class="img-fluid" style="max-height: 200px;">`
                : `<video controls style="max-height: 200px; max-width: 100%;">
                       <source src="${currentSrc}">
                   </video>`;
            $('#currentMediaPreview').html(preview);
        } else {
            $('#currentMediaPreview').html('<p class="text-muted">No hay archivo asignado</p>');
        }
    }

    // Cargar lista de archivos existentes
    function loadExistingFiles(type, category) {
        $('#filesGrid').html('<p class="text-center">Cargando...</p>');

        fetch(`/public/media/list?type=${type}&category=${category}`)
            .then(res => res.json())
            .then(data => {
                if (data.files && data.files.length > 0) {
                    renderFilesGrid(data.files, type);
                } else {
                    $('#filesGrid').html('<p class="text-muted text-center">No hay archivos</p>');
                }
            })
            .catch(err => {
                console.error('Error cargando archivos:', err);
                $('#filesGrid').html('<p class="text-danger">Error al cargar archivos</p>');
            });
    }

    // Renderizar grid de archivos
    function renderFilesGrid(files, type) {
        const grid = files.map(file => {
            const preview = type === 'image'
                ? `<img src="${file.url}" class="img-fluid">`
                : `<video style="width: 100%;"><source src="${file.url}"></video>`;

            return `
                <div class="col-md-3 col-sm-4 col-6">
                    <div class="card file-card" data-path="${file.path}" data-url="${file.url}">
                        <div class="card-body p-2 text-center" style="cursor: pointer;">
                            <div style="height: 100px; overflow: hidden;">
                                ${preview}
                            </div>
                            <small class="d-block mt-1 text-truncate">${file.name}</small>
                        </div>
                    </div>
                </div>
            `;
        }).join('');

        $('#filesGrid').html(grid);

        // Click en archivo para seleccionar
        $('.file-card').on('click', function () {
            $('.file-card').removeClass('border-primary');
            $(this).addClass('border-primary');
            selectedFile = {
                path: $(this).data('path'),
                url: $(this).data('url')
            };
        });
    }

    // ========== UPLOAD DE NUEVO ARCHIVO ==========
    
    // File input change
    $('#mediaFileInput').on('change', function (e) {
        const file = e.target.files[0];
        if (file) {
            handleFileSelection(file);
        }
    });

    // Drag & Drop
    const dropZone = document.getElementById('dropZone');
    
    dropZone.addEventListener('dragover', (e) => {
        e.preventDefault();
        dropZone.classList.add('border-primary');
    });

    dropZone.addEventListener('dragleave', () => {
        dropZone.classList.remove('border-primary');
    });

    dropZone.addEventListener('drop', (e) => {
        e.preventDefault();
        dropZone.classList.remove('border-primary');
        const file = e.dataTransfer.files[0];
        if (file) {
            handleFileSelection(file);
        }
    });

    dropZone.addEventListener('click', () => {
        $('#mediaFileInput').click();
    });

    // Procesar archivo seleccionado
    function handleFileSelection(file) {
        // Validar tipo
        const validTypes = currentType === 'image' 
            ? ['image/jpeg', 'image/png', 'image/gif', 'image/webp']
            : ['video/mp4', 'video/webm', 'video/ogg'];

        if (!validTypes.includes(file.type)) {
            alert('Tipo de archivo no válido');
            return;
        }

        // Validar tamaño (50MB máx)
        if (file.size > 50 * 1024 * 1024) {
            alert('El archivo es muy grande (máx 50MB)');
            return;
        }

        // Mostrar preview
        showNewFilePreview(file);

        // Upload automático
        uploadFile(file);
    }

    // Mostrar preview del nuevo archivo
    function showNewFilePreview(file) {
        const reader = new FileReader();
        reader.onload = (e) => {
            const preview = currentType === 'image'
                ? `<img src="${e.target.result}" class="img-fluid" style="max-height: 300px;">`
                : `<video controls style="max-height: 300px; max-width: 100%;">
                       <source src="${e.target.result}">
                   </video>`;
            
            $('#newMediaPreview div').html(preview);
            $('#newMediaPreview').show();
        };
        reader.readAsDataURL(file);
    }

    // Upload archivo al servidor
    function uploadFile(file) {
        const formData = new FormData();
        formData.append('file', file);
        formData.append('type', currentType);
        formData.append('category', $('#cc-model').val());

        $('#uploadProgress').show();
        const progressBar = $('#uploadProgress .progress-bar');

        fetch('/public/media/upload', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            body: formData
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                selectedFile = {
                    path: data.file_path,
                    url: data.url,
                    metadata: data.metadata
                };
                progressBar.css('width', '100%');
                alert('Archivo subido correctamente');
            } else {
                throw new Error(data.message || 'Error al subir');
            }
        })
        .catch(err => {
            console.error('Error:', err);
            alert('Error al subir archivo: ' + err.message);
        })
        .finally(() => {
            setTimeout(() => {
                $('#uploadProgress').hide();
                progressBar.css('width', '0%');
            }, 1000);
        });
    }

    // ========== GUARDAR CAMBIOS ==========
    $('#saveContentBtn').on('click', () => {
        if (currentType === 'text' || currentType === 'html') {
            saveTextContent();
        } else {
            saveMediaContent();
        }
    });

    function saveTextContent() {
        const payload = {
            model: $('#cc-model').val(),
            model_id: $('#cc-model-id').val(),
            key: $('#cc-key').val(),
            value: $('#cc-value').val(),
            type: currentType
        };

        fetch('/public/content/store', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            body: JSON.stringify(payload)
        })
        .then(res => res.json())
        .then(() => {
            currentEditable.innerText = payload.value;
            $modal.modal('hide');
            alert('Contenido actualizado');
        })
        .catch(err => {
            console.error('Error:', err);
            alert('Error al guardar');
        });
    }

    function saveMediaContent() {
        if (!selectedFile) {
            alert('Selecciona un archivo primero');
            return;
        }

        const payload = {
            model: $('#cc-model').val(),
            model_id: $('#cc-model-id').val(),
            key: $('#cc-key').val(),
            file_path: selectedFile.path,
            type: currentType,
            metadata: selectedFile.metadata || {}
        };

        fetch('/public/media/store', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            body: JSON.stringify(payload)
        })
        .then(res => res.json())
        .then(() => {
            // Actualizar elemento en la vista
            if (currentType === 'image') {
                currentEditable.setAttribute('src', selectedFile.url);
            } else if (currentType === 'video') {
                const source = currentEditable.querySelector('source');
                if (source) {
                    source.setAttribute('src', selectedFile.url);
                    currentEditable.load();
                }
            }

            $modal.modal('hide');
            alert('Multimedia actualizado');
            location.reload(); // Recargar para ver cambios
        })
        .catch(err => {
            console.error('Error:', err);
            alert('Error al guardar multimedia');
        });
    }
});
```

---

## 🎬 Flujo de Trabajo del Usuario

### Escenario 1: Editar Imagen Existente

```
1. Usuario con permiso 'public_content.edit' visita vista pública
2. Hace click en imagen con class="editable" data-type="image"
3. Se abre modal especializado con:
   ├─ Preview de imagen actual
   ├─ Tab "Archivos existentes"
   │   └─ Grid de imágenes disponibles en carpeta del módulo
   └─ Tab "Subir nuevo"
       ├─ Input file + Drag & Drop zone
       └─ Preview en tiempo real

4a. OPCIÓN A: Seleccionar existente
    ├─ Usuario hace click en una imagen del grid
    ├─ Se marca con borde azul
    ├─ Click en "Guardar cambios"
    ├─ Backend actualiza custom_contents.value con la ruta
    └─ Imagen se actualiza en la vista

4b. OPCIÓN B: Subir nueva
    ├─ Usuario arrastra archivo o usa file input
    ├─ Se muestra preview inmediato (FileReader)
    ├─ Upload automático inicia con progress bar
    ├─ Backend valida, almacena y retorna ruta
    ├─ Usuario ve preview confirmando el archivo
    ├─ Click en "Guardar cambios"
    ├─ Backend actualiza custom_contents.value
    └─ Imagen se actualiza en la vista
```

### Escenario 2: Agregar Imagen donde no Existía

```
1. Elemento editable sin imagen:
   <div class="editable" 
        data-type="image"
        data-src-target="banner_img">
       <p>Click para agregar imagen</p>
   </div>

2. Usuario hace click
3. Modal se abre mostrando "No hay archivo asignado"
4. Usuario sube o selecciona imagen
5. Al guardar, la vista se actualiza insertando <img>
```

### Escenario 3: Editar Video

```
1. Usuario hace click en <video> editable
2. Modal muestra:
   ├─ Reproductor con video actual
   ├─ Opción de seleccionar de archivos
   ├─ Opción de subir nuevo (MP4, WebM)
   └─ Opción de URL externa (YouTube, Vimeo)

3. Usuario selecciona/sube video
4. Preview con reproductor funcional
5. Guardar actualiza <source src="...">
```

---

## 🔒 Seguridad y Validaciones

### Validaciones Frontend

```javascript
// Tipos MIME permitidos
const ALLOWED_IMAGES = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
const ALLOWED_VIDEOS = ['video/mp4', 'video/webm', 'video/ogg'];

// Tamaños máximos
const MAX_IMAGE_SIZE = 5 * 1024 * 1024;   // 5MB
const MAX_VIDEO_SIZE = 50 * 1024 * 1024;  // 50MB
const MAX_GIF_SIZE = 10 * 1024 * 1024;    // 10MB

// Validación antes de upload
function validateFile(file, type) {
    const allowed = type === 'image' ? ALLOWED_IMAGES : ALLOWED_VIDEOS;
    const maxSize = type === 'image' ? MAX_IMAGE_SIZE : MAX_VIDEO_SIZE;

    if (!allowed.includes(file.type)) {
        throw new Error(`Tipo de archivo no permitido: ${file.type}`);
    }

    if (file.size > maxSize) {
        throw new Error(`Archivo muy grande: ${(file.size / 1024 / 1024).toFixed(2)}MB`);
    }

    return true;
}
```

### Validaciones Backend

```php
// En MediaContentController::upload()
$request->validate([
    'file' => [
        'required',
        'file',
        'mimes:jpeg,jpg,png,gif,webp,mp4,webm,ogv',
        'max:51200', // 50MB en KB
    ],
    'type' => 'required|in:image,video,gif',
    'category' => 'required|string|alpha_dash|max:50'
]);

// En MediaService::processUpload()
// Validar MIME real del archivo (no solo extensión)
$finfo = finfo_open(FILEINFO_MIME_TYPE);
$realMime = finfo_file($finfo, $file->getRealPath());
finfo_close($finfo);

if (!in_array($realMime, $this->allowedImageMimes)) {
    throw new \InvalidArgumentException('Archivo no válido');
}

// Sanitizar nombre de archivo
$safeName = Str::slug(pathinfo($fileName, PATHINFO_FILENAME));
```

### Protección contra Ataques

1. **Path Traversal**
```php
// Validar que category no contenga ../
if (preg_match('/\.\./', $category)) {
    throw new \InvalidArgumentException('Categoría inválida');
}
```

2. **File Inclusion**
```php
// No ejecutar archivos PHP subidos
$extension = strtolower($file->getClientOriginalExtension());
$forbidden = ['php', 'phtml', 'php3', 'php4', 'php5', 'phar'];

if (in_array($extension, $forbidden)) {
    throw new \InvalidArgumentException('Tipo de archivo prohibido');
}
```

3. **XSS en Nombres**
```php
// Escapar nombres al mostrar
$safeName = htmlspecialchars($file->name, ENT_QUOTES, 'UTF-8');
```

4. **Limitar por Usuario**
```php
// Límite de uploads por día
$uploadsToday = CustomContent::where('uploaded_by', auth()->id())
    ->whereDate('created_at', today())
    ->count();

if ($uploadsToday > 50) {
    throw new \Exception('Límite diario de uploads alcanzado');
}
```

---

## 📅 Plan de Implementación por Fases

### FASE 1: Fundación (2-3 días)

**Objetivo:** Preparar base técnica

**Tareas:**
- [ ] Crear migración para campo `metadata` en `custom_contents`
- [ ] Ejecutar `php artisan storage:link`
- [ ] Crear estructura de carpetas en `storage/app/public/media/`
- [ ] Instalar dependencia (opcional): `composer require intervention/image`
- [ ] Crear `MediaService` básico
- [ ] Crear `MediaContentController` básico
- [ ] Registrar rutas:
  ```php
  Route::post('/public/media/upload', [MediaContentController::class, 'upload']);
  Route::get('/public/media/list', [MediaContentController::class, 'list']);
  Route::post('/public/media/store', [MediaContentController::class, 'store']);
  ```

**Verificación:**
- Upload manual de archivo funciona
- Listado de archivos retorna JSON correcto

---

### FASE 2: Modal Básico de Imágenes (3-4 días)

**Objetivo:** Editor funcional para imágenes

**Tareas:**
- [ ] Extender modal en `public.blade.php`
- [ ] Implementar detección de `data-type="image"`
- [ ] Crear tab "Archivos existentes"
- [ ] Implementar grid de imágenes con preview
- [ ] Crear tab "Subir nuevo"
- [ ] Implementar file input + preview
- [ ] Conectar botón "Guardar" con backend
- [ ] Actualizar elemento `<img>` en vista tras guardar

**Verificación:**
- Click en imagen abre modal especializado
- Se pueden ver imágenes existentes
- Upload de nueva imagen funciona
- Preview se muestra correctamente
- Al guardar, imagen se actualiza en vista

---

### FASE 3: Drag & Drop + Progress (2 días)

**Objetivo:** Mejorar UX de upload

**Tareas:**
- [ ] Implementar drag & drop zone
- [ ] Agregar progress bar para uploads
- [ ] Validaciones frontend (tamaño, tipo)
- [ ] Mensajes de error amigables
- [ ] Spinner durante procesamiento

**Verificación:**
- Se puede arrastrar archivo al modal
- Progress bar muestra avance real
- Errores se muestran claramente

---

### FASE 4: Thumbnails (2 días)

**Objetivo:** Optimizar previews

**Tareas:**
- [ ] Implementar generación de thumbnails con Intervention Image
- [ ] Almacenar thumbnails en `media/thumbnails/`
- [ ] Usar thumbnails en grid de archivos existentes
- [ ] Lazy loading de imágenes en grid

**Verificación:**
- Grid carga rápido con thumbnails
- Thumbnails se generan automáticamente

---

### FASE 5: Soporte para Videos (3 días)

**Objetivo:** Editar videos MP4/WebM

**Tareas:**
- [ ] Extender modal para detectar `data-type="video"`
- [ ] Implementar preview con `<video>` controls
- [ ] Validar tipos MIME de video
- [ ] Ajustar límites de tamaño (50MB)
- [ ] Actualizar elementos `<video><source>` tras guardar

**Verificación:**
- Click en video abre modal
- Se pueden subir MP4, WebM
- Preview reproduce video correctamente

---

### FASE 6: GIFs Animados (1 día)

**Objetivo:** Soporte específico para GIFs

**Tareas:**
- [ ] Tratar GIFs como imágenes especiales
- [ ] Asegurar que preview muestra animación
- [ ] Ajustar límite de tamaño (10MB)

**Verificación:**
- GIFs se suben y previsualizan animados
- No se genera thumbnail estático

---

### FASE 7: Gestión Avanzada (2-3 días)

**Objetivo:** Administración de archivos

**Tareas:**
- [ ] Implementar búsqueda/filtro en grid de archivos
- [ ] Botón para eliminar archivo (con confirmación)
- [ ] Comando artisan para limpiar huérfanos:
  ```bash
  php artisan media:cleanup
  ```
- [ ] Mostrar metadata (tamaño, dimensiones, fecha)
- [ ] Paginación en listado de archivos

**Verificación:**
- Se pueden buscar archivos por nombre
- Eliminación funciona correctamente
- Comando cleanup detecta archivos sin uso

---

### FASE 8: URLs Externas (2 días)

**Objetivo:** Integrar YouTube/Vimeo

**Tareas:**
- [ ] Agregar opción "URL externa" en modal de video
- [ ] Validar URLs de YouTube/Vimeo
- [ ] Extraer video ID automáticamente
- [ ] Generar embed correcto
- [ ] Almacenar en metadata

**Ejemplo:**
```json
{
    "type": "video",
    "source": "external",
    "provider": "youtube",
    "video_id": "dQw4w9WgXcQ",
    "embed_url": "https://www.youtube.com/embed/dQw4w9WgXcQ"
}
```

---

### FASE 9: Testing & Documentación (2 días)

**Objetivo:** Asegurar calidad

**Tareas:**
- [ ] Tests unitarios para `MediaService`
- [ ] Tests de integración para `MediaContentController`
- [ ] Tests de feature para flujo completo
- [ ] Actualizar `MANUAL_VISTAS_EDITABLES.md`
- [ ] Crear guía de uso con screenshots

---

### FASE 10: Optimización (2 días)

**Objetivo:** Performance y refinamiento

**Tareas:**
- [ ] Implementar lazy loading en grid
- [ ] Comprimir imágenes al subir (opcional)
- [ ] CDN para archivos (opcional)
- [ ] Caching de listados
- [ ] Monitoreo de espacio en disco

---

## 🎯 Casos de Uso Específicos

### Caso 1: Banner de Ofertas Educativas

**Vista actual:**
```blade
<img src="{{ asset('images/oferta4.jpeg') }}"
     class="w-100 editable"
     data-model="oferta"
     data-model-id="0"
     data-key="banner_image"
     data-type="image"
     alt="Oferta educativa CATA">
```

**Flujo:**
1. Usuario click en imagen banner
2. Modal muestra:
   - Imagen actual: `oferta4.jpeg`
   - Carpeta: `media/images/ofertas/`
   - Opciones: 4 imágenes disponibles (oferta1-4)
3. Usuario sube nueva imagen: `banner-2026.jpg`
4. Preview muestra la nueva imagen
5. Guardar actualiza DB:
   ```sql
   UPDATE custom_contents 
   SET value = 'media/images/ofertas/banner-2026.jpg',
       metadata = '{"width": 1920, "height": 1080, ...}'
   WHERE key = 'banner_image' 
     AND contentable_type = 'App\\Models\\Oferta'
     AND contentable_id = 0
   ```
6. Vista se recarga mostrando nueva imagen

---

### Caso 2: Video Institucional

**Vista propuesta:**
```blade
<video class="w-100 editable"
       data-model="oferta"
       data-model-id="0"
       data-key="video_institucional"
       data-type="video"
       controls>
    <source src="{{ getCustomContent('oferta', 'video_institucional', '') }}" 
            type="video/mp4">
    Tu navegador no soporta video HTML5
</video>
```

**Flujo:**
1. Click en video
2. Modal muestra:
   - Video actual (si existe)
   - Tab "Subir nuevo": MP4, WebM
   - Tab "URL externa": YouTube/Vimeo
3. Usuario sube `institucional.mp4` (20MB)
4. Progress bar muestra 0% → 100%
5. Preview reproduce el video
6. Guardar actualiza `<source src>`

---

### Caso 3: Galería de Imágenes

**Vista propuesta:**
```blade
<div class="row">
    @foreach(range(1, 6) as $i)
        <div class="col-md-4 mb-3">
            <img src="{{ getCustomContent('oferta', "galeria_img_{$i}", 'images/placeholder.jpg') }}"
                 class="img-fluid editable"
                 data-model="oferta"
                 data-model-id="{{ $oferta->id }}"
                 data-key="galeria_img_{{ $i }}"
                 data-type="image"
                 alt="Imagen {{ $i }}">
        </div>
    @endforeach
</div>
```

**Beneficio:**
- 6 imágenes independientemente editables
- Cada una con su propio preview y upload
- Sin modificar estructura de código

---

## 📊 Estimación de Recursos

### Tiempo Total de Desarrollo

| Fase | Días | Prioridad |
|------|------|-----------|
| Fase 1: Fundación | 2-3 | ⭐⭐⭐ Crítica |
| Fase 2: Modal Imágenes | 3-4 | ⭐⭐⭐ Crítica |
| Fase 3: Drag & Drop | 2 | ⭐⭐ Alta |
| Fase 4: Thumbnails | 2 | ⭐⭐ Alta |
| Fase 5: Videos | 3 | ⭐⭐ Alta |
| Fase 6: GIFs | 1 | ⭐ Media |
| Fase 7: Gestión | 2-3 | ⭐ Media |
| Fase 8: URLs Externas | 2 | ⭐ Media |
| Fase 9: Testing | 2 | ⭐⭐ Alta |
| Fase 10: Optimización | 2 | ⭐ Baja |
| **TOTAL** | **21-25 días** | |

### Stack Tecnológico Requerido

**Backend:**
- ✅ Laravel 12 (ya instalado)
- ✅ Spatie Permissions (ya instalado)
- ⚠️ Intervention/Image (opcional, para thumbnails)

**Frontend:**
- ✅ Bootstrap 4 (ya integrado en AdminLTE)
- ✅ jQuery (ya disponible)
- ✅ Bootstrap Icons (ya cargado)
- ⚠️ Dropzone.js (opcional, para mejor UX de upload)

**Infraestructura:**
- ✅ Storage local configurado
- ⚠️ Symlink `storage:link` (ejecutar)
- ⚠️ Permisos de escritura en `storage/app/public/`

---

## 🚀 Recomendaciones Finales

### Priorización Sugerida

**MVP (Mínimo Viable):**
1. Fase 1: Fundación ✅
2. Fase 2: Modal Imágenes ✅
3. Fase 5: Videos ✅

**Mejoras Incrementales:**
4. Fase 3: Drag & Drop
5. Fase 4: Thumbnails
6. Fase 7: Gestión avanzada

**Opcionales:**
7. Fase 6: GIFs (solo si hay demanda)
8. Fase 8: URLs externas (solo si se usan videos externos)
9. Fase 10: Optimización (solo si hay problemas de performance)

### Consideraciones Importantes

1. **Espacio en Disco**
   - Monitorear uso de `storage/app/public/`
   - Implementar límites por usuario/módulo
   - Considerar CDN para producción

2. **Performance**
   - Generar thumbnails async (colas)
   - Paginar listados de archivos
   - Lazy loading en grids grandes

3. **Backup**
   - Incluir `storage/app/public/media/` en respaldos
   - Mantener sincronía con DB

4. **Migración de Archivos Existentes**
   - Mover `public/images/` a `storage/app/public/media/images/`
   - Crear registros en `custom_contents` para archivos actuales

---

## 📚 Conclusión

Este plan proporciona una ruta clara para integrar gestión multimedia completa en el sistema de vistas editables existente. 

**Ventajas del enfoque:**
- ✅ Construcción incremental por fases
- ✅ Compatible con sistema actual
- ✅ Escalable a nuevos tipos de multimedia
- ✅ UX consistente con edición de texto
- ✅ Seguridad y validaciones robustas

**Siguiente paso inmediato:**
Ejecutar **Fase 1: Fundación** para establecer la base técnica necesaria.

---

**Fecha de creación:** 26 de enero de 2026  
**Versión:** 1.0  
**Autor:** Sistema SOESoftware  
**Estado:** Propuesta pendiente de aprobación
