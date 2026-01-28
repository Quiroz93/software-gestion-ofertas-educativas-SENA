# SISTEMA DE EDICIÓN EN TIEMPO REAL Y GESTIÓN MULTIMEDIA
## SoeSoftware - Guía Técnica y Operativa

---

## 1. ARQUITECTURA GENERAL

### 1.1 Componentes Principales

```
┌─────────────────────────────────────────────────────────────┐
│                     VISTA (BLADE)                           │
│  Elementos HTML con atributos data-* (editable)            │
└─────────────────────────────────────────────────────────────┘
                            ↓
┌─────────────────────────────────────────────────────────────┐
│              FRONTEND (JavaScript/AJAX)                      │
│  Captura eventos, valida, envía al backend                 │
└─────────────────────────────────────────────────────────────┘
                            ↓
┌─────────────────────────────────────────────────────────────┐
│           CONTROLLERS & SERVICES                             │
│  CustomContentController                                    │
│  MediaService                                               │
│  MediaContentController                                     │
└─────────────────────────────────────────────────────────────┘
                            ↓
┌─────────────────────────────────────────────────────────────┐
│              DATABASE & STORAGE                              │
│  CustomContent (tabla)                                      │
│  Storage/public/media/ (archivos)                           │
└─────────────────────────────────────────────────────────────┘
```

---

## 2. EDICIÓN DE TEXTOS EN TIEMPO REAL

### 2.1 Cómo Funciona

#### Paso 1: Marcar Elemento como Editable en Blade

```blade
<!-- Elemento de texto editable -->
<h2 class="editable"
    data-model="home"           <!-- Nombre del modelo -->
    data-model-id="0"           <!-- ID del registro (0 = genérico) -->
    data-key="hero_title"       <!-- Clave del contenido -->
    data-type="text">           <!-- Tipo de contenido -->
    {!! getCustomContent('home', 'hero_title', 'Valor por defecto') !!}
</h2>

<!-- Párrafo editable -->
<p class="editable"
   data-model="home"
   data-model-id="0"
   data-key="hero_description"
   data-type="text">
    {!! getCustomContent('home', 'hero_description', 'Descripción...') !!}
</p>

<!-- Imagen editable -->
<img src="{{ asset('storage/' . getCustomContent('home', 'hero_image', 'default.jpg')) }}"
     class="editable"
     data-model="home"
     data-model-id="0"
     data-key="hero_image"
     data-type="image"
     alt="Hero Image">

<!-- Contenido HTML editable -->
<div class="editable"
     data-model="home"
     data-model-id="0"
     data-key="rich_content"
     data-type="html">
    {!! getCustomContent('home', 'rich_content', '<p>Contenido HTML</p>') !!}
</div>
```

#### Paso 2: Capturar Cambios en Frontend

**Flujo (requiere JavaScript en la aplicación)**:

1. Usuario hace clic en elemento editable
2. Frontend detecta clase `editable`
3. Activa modo edición (contenteditable o input)
4. Usuario modifica el contenido
5. Al perder foco o presionar guardar:
   - Valida el contenido
   - Envia AJAX POST a `/api/custom-content/store`
   - Muestra feedback de guardado

#### Paso 3: Procesar en Backend

**Endpoint**: `POST /api/custom-content/store`

**Controller**: `CustomContentController@store`

```php
public function store(Request $request)
{
    try {
        // 🔐 Autorización
        $this->authorize('public_content.edit');
        
        // 🧪 Validación
        $data = $request->validate([
            'model'     => 'required|string',
            'model_id'  => 'required|integer',
            'key'       => 'required|string|max:255',
            'value'     => 'nullable',
            'type'      => 'nullable|string|in:text,html,image,color,json',
        ]);
        
        // 🧠 Resolver el modelo
        $modelClass = 'App\\Models\\' . Str::studly($data['model']);
        
        // 💾 Guardar o actualizar CustomContent
        if ($data['model_id'] == 0) {
            // Contenido genérico (página completa)
            $content = CustomContent::where([
                'contentable_type' => $modelClass,
                'contentable_id' => 0,
                'key' => $data['key'],
            ])->first();
            
            if ($content) {
                $content->update([
                    'value' => $data['value'],
                    'type'  => $data['type'] ?? 'text',
                ]);
            } else {
                $content = CustomContent::create([
                    'contentable_type' => $modelClass,
                    'contentable_id' => 0,
                    'key' => $data['key'],
                    'value' => $data['value'],
                    'type'  => $data['type'] ?? 'text',
                ]);
            }
        } else {
            // Contenido específico (asociado a modelo)
            $modelInstance = $modelClass::findOrFail($data['model_id']);
            $content = $modelInstance->customContents()
                ->updateOrCreate(
                    ['key' => $data['key']],
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
            'message' => 'No tienes permisos'
        ], 403);
    } catch (\Exception $e) {
        return response()->json([
            'message' => 'Error: ' . $e->getMessage()
        ], 500);
    }
}
```

### 2.2 Tipos de Contenido Soportados

| Tipo | Descripción | Validación | Ejemplo |
|------|-------------|-----------|---------|
| `text` | Texto simple | Max 65,535 caracteres | Títulos, descripciones |
| `html` | HTML enriquecido | Sanitizado | Párrafos con formato |
| `color` | Código de color | Formato #HEX | `#228B22` |
| `json` | Datos estructurados | JSON válido | Arrays, objetos |
| `image` | Ruta de imagen | Ruta al archivo | `media/images/...jpg` |

### 2.3 Modelo de Datos: CustomContent

```php
// Tabla: custom_contents
Schema::create('custom_contents', function (Blueprint $table) {
    $table->id();
    
    // Relación polimórfica
    $table->string('contentable_type');           // Ej: 'App\\Models\\Home'
    $table->unsignedBigInteger('contentable_id'); // Ej: 0 (genérico) o ID específico
    
    // Contenido
    $table->string('key');                        // Ej: 'hero_title'
    $table->longText('value')->nullable();        // El contenido en sí
    $table->string('type')->default('text');      // text, html, image, etc.
    
    // Metadata y Accesibilidad
    $table->json('metadata')->nullable();         // Info adicional
    $table->string('alt_text')->nullable();       // Para images
    $table->string('title')->nullable();          // Tooltip/título
    
    $table->timestamps();
    $table->index(['contentable_type', 'contentable_id', 'key']);
});
```

### 2.4 Obtener Contenido: Helper

```php
// En app/Helpers/CustomContentHelper.php
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
    
    return $content?->value ?? $default;
}

// Uso en Blade:
<h1>{{ getCustomContent('home', 'hero_title', 'Título por defecto') }}</h1>
```

### 2.5 Permisos Requeridos

```php
// En authorize() del controller se valida:
// 'public_content.edit' - Permiso para editar contenido público
$this->authorize('public_content.edit');

// Esto se verifica contra:
// - Tabla permissions
// - Tabla role_has_permissions
// - Tabla model_has_permissions (para usuarios específicos)
```

---

## 3. GESTIÓN DE MULTIMEDIA

### 3.1 Servicio: MediaService

**Ubicación**: `app/Services/MediaService.php`

**Responsabilidades**:
- Validar archivos subidos
- Generar nombres seguros
- Crear thumbnails
- Listar archivos disponibles
- Eliminar archivos

#### Métodos Principales

```php
class MediaService
{
    /**
     * 1. PROCESAR UPLOAD DE ARCHIVO
     */
    public function processUpload(
        UploadedFile $file, 
        string $type,        // 'image', 'video', 'gif'
        string $category     // 'ofertas', 'programas', 'general'
    ): array
    {
        // ✅ Valida MIME type real (no confía en extensión)
        // ✅ Genera nombre único y seguro
        // ✅ Almacena en Storage
        // ✅ Genera metadata
        // ✅ Crea thumbnail (para imágenes no-GIF)
        
        return [
            'success' => true,
            'file_path' => 'media/images/programa_abc123.jpg',
            'url' => 'https://sena.local/storage/media/images/...',
            'thumbnail_url' => 'https://sena.local/storage/media/thumbnails/...',
            'metadata' => [
                'width' => 1920,
                'height' => 1080,
                'size' => 524288,
                // ...
            ]
        ];
    }

    /**
     * 2. LISTAR ARCHIVOS DISPONIBLES
     */
    public function listFiles(string $type, string $category): array
    {
        // Retorna array de archivos con:
        // - path, url, name, size
        // - thumbnail_url (si existe)
        // - is_gif (para manejo especial de GIFs animados)
        
        return [
            [
                'path' => 'media/images/file1.jpg',
                'url' => 'https://...',
                'thumbnail_url' => 'https://.../thumbnails/...',
                'name' => 'file1.jpg',
                'size' => 512000,
                'is_gif' => false
            ],
            // ...
        ];
    }

    /**
     * 3. ELIMINAR ARCHIVO
     */
    public function deleteFile(string $filePath): bool
    {
        // Elimina archivo y thumbnail si existe
        // Retorna true/false
    }

    /**
     * 4. GENERAR THUMBNAIL
     */
    protected function generateThumbnail(string $filePath): ?string
    {
        // Usa Intervention/Image para redimensionar
        // Crea versión de 300x200px
        // NO se aplica a GIFs (mantiene animación)
        // Maneja errores si GD/Imagick no disponibles
    }

    /**
     * 5. VALIDAR MIME TYPE
     */
    protected function validateMimeType(UploadedFile $file, string $type): void
    {
        // Valida MIME type real (no la extensión)
        // Lanza excepción si no es válido
        // Previene ataques de inyección de archivos
    }

    /**
     * 6. GENERAR NOMBRE SEGURO
     */
    protected function generateFileName(UploadedFile $file): string
    {
        // Genera: nombre_slug-timestamp-random.ext
        // Previene inyección de rutas
        // Previene sobrescritura de archivos
    }

    /**
     * 7. GENERAR METADATA
     */
    protected function generateMetadata(
        UploadedFile $file, 
        string $filePath, 
        string $type
    ): array
    {
        // Para imágenes: obtiene ancho, alto
        // Para videos: obtiene duración (si es posible)
        // Para todos: obtiene tamaño, MIME
    }
}
```

### 3.2 Extensiones Permitidas

```php
protected array $allowedImageMimes = [
    'image/jpeg',  // .jpg, .jpeg
    'image/png',   // .png
    'image/gif',   // .gif (con manejo especial para animaciones)
    'image/webp'   // .webp
];

protected array $allowedVideoMimes = [
    'video/mp4',   // .mp4
    'video/webm',  // .webm
    'video/ogg'    // .ogg
];
```

### 3.3 Estructura de Almacenamiento

```
storage/app/public/
├── media/
│   ├── images/
│   │   ├── oferta_123_abc.jpg
│   │   ├── programa_456_def.png
│   │   └── ...
│   ├── videos/
│   │   ├── tutorial_001.mp4
│   │   └── ...
│   ├── gifs/
│   │   ├── animacion_001.gif
│   │   └── ...
│   └── thumbnails/
│       ├── oferta_123_abc.jpg     (300x200px)
│       ├── programa_456_def.png   (300x200px)
│       └── ...
```

**Ventajas**:
- Organización clara por tipo
- Fácil limpieza de archivos huérfanos
- Thumbnails separados para mejor caché

### 3.4 Casos Especiales

#### GIFs Animados
```php
// En MediaService::processUpload()

// NO se crea thumbnail para GIFs (perderíamos animación)
if (($type === 'image') && !str_ends_with($file, '.gif')) {
    // Generar thumbnail solo para imágenes estáticas
    $thumbnailUrl = $this->generateThumbnail($filePath);
} else {
    // Para GIFs: usar URL original para mantener animación
    $thumbnailUrl = $fileUrl;
}
```

#### Validación de Archivos
```php
// Valida MIME type real (no confía en extensión)
$finfo = finfo_open(FILEINFO_MIME_TYPE);
$realMimeType = finfo_file($finfo, $file->getRealPath());
finfo_close($finfo);

if (!in_array($realMimeType, $this->allowedImageMimes)) {
    throw new Exception('MIME type no permitido');
}
```

---

## 4. CONTROLLER: MediaContentController

**Ubicación**: `app/Http/Controllers/Public/MediaContentController.php`

```php
class MediaContentController extends Controller
{
    /**
     * ENDPOINT 1: Subir archivo
     * POST /api/media/upload
     */
    public function upload(Request $request)
    {
        // Validar que sea admin/editor
        $this->authorize('media.upload');
        
        // Validar archivo
        $request->validate([
            'file' => 'required|file|max:10240', // 10MB
            'type' => 'required|in:image,video,gif',
            'category' => 'required|in:ofertas,programas,general',
        ]);
        
        // Procesar con MediaService
        $result = (new MediaService())
            ->processUpload(
                $request->file('file'),
                $request->get('type'),
                $request->get('category')
            );
        
        if ($result['success']) {
            // Guardar referencia en CustomContent
            CustomContent::create([
                'contentable_type' => 'App\\Models\\MediaFile',
                'contentable_id' => 0,
                'key' => basename($result['file_path']),
                'value' => $result['file_path'],
                'type' => $request->get('type'),
                'metadata' => $result['metadata'],
            ]);
            
            return response()->json($result);
        }
        
        return response()->json([
            'success' => false,
            'message' => 'Error al procesar archivo'
        ], 422);
    }

    /**
     * ENDPOINT 2: Listar archivos
     * GET /api/media/list?type=image&category=ofertas
     */
    public function list(Request $request)
    {
        // Validar permisos
        $this->authorize('media.view');
        
        $type = $request->get('type', 'image');
        $category = $request->get('category', 'general');
        
        $files = (new MediaService())
            ->listFiles($type, $category);
        
        return response()->json([
            'success' => true,
            'files' => $files
        ]);
    }

    /**
     * ENDPOINT 3: Eliminar archivo
     * DELETE /api/media/delete
     */
    public function delete(Request $request)
    {
        $this->authorize('media.delete');
        
        $request->validate([
            'file_path' => 'required|string',
        ]);
        
        $deleted = (new MediaService())
            ->deleteFile($request->get('file_path'));
        
        if ($deleted) {
            return response()->json([
                'success' => true,
                'message' => 'Archivo eliminado'
            ]);
        }
        
        return response()->json([
            'success' => false,
            'message' => 'Error al eliminar'
        ], 422);
    }
}
```

---

## 5. FLUJO COMPLETO: EDITAR IMAGEN EN HERO

### Escenario: Admin quiere cambiar la imagen del hero en home

```
┌─────────────────────────────────────────────────────────────┐
│ 1. VISTA (resources/views/home.blade.php)                  │
│                                                              │
│ <img src="{{asset('storage/...')}}"                        │
│      class="editable"                                       │
│      data-model="home"                                      │
│      data-model-id="0"                                      │
│      data-key="hero_image"                                  │
│      data-type="image">                                     │
└─────────────────────────────────────────────────────────────┘
           ↓ Usuario hace clic en imagen
┌─────────────────────────────────────────────────────────────┐
│ 2. FRONTEND JS                                               │
│                                                              │
│ - Detecta clase "editable"                                 │
│ - Muestra modal de upload                                  │
│ - Usuario selecciona archivo                               │
│ - Envía: POST /api/media/upload                           │
│   {                                                         │
│     file: File,                                            │
│     type: 'image',                                         │
│     category: 'general'                                    │
│   }                                                         │
└─────────────────────────────────────────────────────────────┘
           ↓
┌─────────────────────────────────────────────────────────────┐
│ 3. BACKEND: MediaContentController@upload                  │
│                                                              │
│ - Valida permisos: authorize('media.upload')               │
│ - Valida archivo:                                          │
│   * Size < 10MB                                            │
│   * MIME type válido (image/jpeg, etc.)                    │
│   * No es archivo ejecutable disfrazado                    │
└─────────────────────────────────────────────────────────────┘
           ↓
┌─────────────────────────────────────────────────────────────┐
│ 4. BACKEND: MediaService@processUpload                     │
│                                                              │
│ - Genera nombre seguro:                                    │
│   hero_image_20260127_a7d2f9.jpg                           │
│                                                              │
│ - Almacena en: storage/public/media/images/                │
│   → hero_image_20260127_a7d2f9.jpg (original)             │
│                                                              │
│ - Extrae metadata:                                         │
│   * Ancho: 1920px                                          │
│   * Alto: 1080px                                           │
│   * Tamaño: 524288 bytes                                   │
│   * MIME: image/jpeg                                       │
│                                                              │
│ - Genera thumbnail (300x200):                              │
│   → storage/public/media/thumbnails/                       │
│   → hero_image_20260127_a7d2f9.jpg                         │
└─────────────────────────────────────────────────────────────┘
           ↓
┌─────────────────────────────────────────────────────────────┐
│ 5. BACKEND: Guardar referencia                              │
│                                                              │
│ CustomContent::create([                                     │
│   'contentable_type' => 'App\\Models\\Home',               │
│   'contentable_id' => 0,                                   │
│   'key' => 'hero_image',                                   │
│   'value' => 'media/images/hero_image_20260127_a7d2f9.jpg',│
│   'type' => 'image',                                       │
│   'metadata' => [                                          │
│     'width' => 1920,                                       │
│     'height' => 1080,                                      │
│     'size' => 524288,                                      │
│   ]                                                         │
│ ]);                                                         │
└─────────────────────────────────────────────────────────────┘
           ↓ Respuesta al frontend
┌─────────────────────────────────────────────────────────────┐
│ 6. RESPONSE JSON                                             │
│ {                                                            │
│   "success": true,                                          │
│   "file_path": "media/images/hero_image_20260127_a7d2f9.jpg",
│   "url": "https://sena.local/storage/media/images/...",   │
│   "thumbnail_url": "https://sena.local/storage/.../...",  │
│   "metadata": { ... }                                      │
│ }                                                           │
└─────────────────────────────────────────────────────────────┘
           ↓ Frontend actualiza vista
┌─────────────────────────────────────────────────────────────┐
│ 7. ACTUALIZAR VISTA                                          │
│                                                              │
│ - Envía POST /api/custom-content/store                     │
│ {                                                           │
│   model: 'home',                                           │
│   model_id: 0,                                             │
│   key: 'hero_image',                                       │
│   value: 'media/images/hero_image_20260127_a7d2f9.jpg',  │
│   type: 'image'                                            │
│ }                                                          │
└─────────────────────────────────────────────────────────────┘
           ↓
┌─────────────────────────────────────────────────────────────┐
│ 8. BACKEND: CustomContentController@store                  │
│                                                              │
│ - Valida permisos: authorize('public_content.edit')        │
│ - Busca o crea CustomContent con esa clave                │
│ - Actualiza el campo 'value' con la nueva ruta             │
└─────────────────────────────────────────────────────────────┘
           ↓
┌─────────────────────────────────────────────────────────────┐
│ 9. RESULTADO FINAL                                           │
│                                                              │
│ ✅ Imagen guardada en storage                              │
│ ✅ Thumbnail generado                                      │
│ ✅ CustomContent actualizado                               │
│ ✅ Próxima carga: imagen nueva se muestra automáticamente  │
│                                                              │
│ <img src="/storage/media/images/hero_image_20260127_a7d2f9.jpg">
└─────────────────────────────────────────────────────────────┘
```

---

## 6. SEGURIDAD

### 6.1 Validaciones en CustomContentController

```php
// ✅ Autorización
$this->authorize('public_content.edit');

// ✅ Validación de datos
$data = $request->validate([
    'model'     => 'required|string',
    'model_id'  => 'required|integer',
    'key'       => 'required|string|max:255',
    'value'     => 'nullable|string',
    'type'      => 'nullable|string|in:text,html,image,color,json',
]);

// ✅ Verificación de modelo
$modelClass = 'App\\Models\\' . Str::studly($data['model']);
if (!class_exists($modelClass)) {
    return response()->json(['message' => 'Modelo no válido'], 422);
}

// ✅ Sanitización de HTML (si se implementa)
if ($data['type'] === 'html') {
    $data['value'] = Purifier::clean($data['value']);
}
```

### 6.2 Validaciones en MediaService

```php
// ✅ Valida MIME type real (no extensión)
$this->validateMimeType($file, $type);

// ✅ Genera nombre seguro (sin caracteres especiales)
$fileName = $this->generateFileName($file);

// ✅ Almacena fuera del web root (en storage/)
$path = $this->getStoragePath($type, $category);

// ✅ Previene path traversal
// No permite: ../../etc/passwd, etc.
```

### 6.3 Permisos Requeridos

Todos los endpoints requieren permisos:

| Acción | Permiso Requerido | Usuarios |
|--------|-------------------|----------|
| Editar contenido texto | `public_content.edit` | Admin, Editor |
| Subir archivos | `media.upload` | Admin, Editor |
| Ver galería media | `media.view` | Admin, Editor |
| Eliminar archivos | `media.delete` | Admin |

---

## 7. LIMITACIONES ACTUALES Y MEJORAS

### 7.1 Estado Actual

✅ **Funcional**:
- Edición básica de texto
- Upload de imágenes
- Generación de thumbnails
- Listado de archivos

⚠️ **Limitaciones**:
- No hay preview de cambios antes de guardar
- No hay historial de versiones
- GD/Imagick puede no estar disponible
- No hay limpieza automática de archivos huérfanos

### 7.2 Mejoras Sugeridas

```php
// 1. Versionado de contenido
CustomContent::query()
    ->create([
        'version' => $previousVersion + 1,
        'created_by' => auth()->id(),
        'is_published' => true,
    ]);

// 2. Limpieza de huérfanos
php artisan media:cleanup-orphaned

// 3. Caché de CustomContent
Cache::remember("custom_content.{$model}.{$key}", 
    60*60*24, 
    fn() => CustomContent::where(...)->first()
);

// 4. Vista previa antes de guardar
CustomContent::create(['is_draft' => true]);
// Luego publicar con: $content->publish();

// 5. Validación de contenido HTML
$sanitized = Purifier::clean($htmlContent);
```

---

## 8. EJEMPLOS DE USO

### 8.1 Agregar Campo Editable a Nueva Vista

```blade
@extends('layouts.bootstrap')

@section('content')

<!-- Título editable -->
<h1 class="editable"
    data-model="programa"
    data-model-id="{{ $programa->id }}"
    data-key="titulo_personalizado"
    data-type="text">
    {{ getCustomContent('programa', 'titulo_personalizado', $programa->nombre) }}
</h1>

<!-- Imagen editable -->
<img src="{{ asset('storage/' . getCustomContent('programa', 'imagen_destacada', 'default.jpg')) }}"
     class="editable"
     data-model="programa"
     data-model-id="{{ $programa->id }}"
     data-key="imagen_destacada"
     data-type="image"
     style="max-width: 100%;">

<!-- HTML enriquecido -->
<div class="editable"
     data-model="programa"
     data-model-id="{{ $programa->id }}"
     data-key="descripcion_html"
     data-type="html">
    {!! getCustomContent('programa', 'descripcion_html', '<p>Descripción...</p>') !!}
</div>

@endsection
```

### 8.2 Crear Migración para CustomContent

```php
Schema::create('custom_contents', function (Blueprint $table) {
    $table->id();
    $table->string('contentable_type');
    $table->unsignedBigInteger('contentable_id');
    $table->string('key');
    $table->longText('value')->nullable();
    $table->string('type')->default('text');
    $table->json('metadata')->nullable();
    $table->string('alt_text')->nullable();
    $table->string('title')->nullable();
    $table->timestamps();
    $table->index(['contentable_type', 'contentable_id', 'key']);
});
```

### 8.3 Rutas para API de Edición

```php
// routes/api.php
Route::middleware(['auth:sanctum', 'verified'])->group(function () {
    // Edición de contenido
    Route::post('/custom-content/store', [CustomContentController::class, 'store']);
    
    // Multimedia
    Route::post('/media/upload', [MediaContentController::class, 'upload']);
    Route::get('/media/list', [MediaContentController::class, 'list']);
    Route::delete('/media/delete', [MediaContentController::class, 'delete']);
});
```

---

## 9. TROUBLESHOOTING

### Problema: "No se puede generar thumbnail"

**Causa**: GD o Imagick no disponibles

**Solución**:
```bash
# Instalar GD (en Ubuntu/Debian)
sudo apt-get install php8.4-gd

# O agregar a php.ini
extension=gd

# Reiniciar PHP-FPM
sudo systemctl restart php8.4-fpm
```

### Problema: "Archivo no se guarda"

**Causas posibles**:
- Permisos insuficientes en `storage/public/`
- Storage no está linkeado

**Solución**:
```bash
# Verificar link simbólico
php artisan storage:link

# Verificar permisos
chmod -R 775 storage/app/public/
```

### Problema: "Cambios no aparecen en el frontend"

**Causas posibles**:
- Caché no actualizado
- Helper no está registrado

**Solución**:
```bash
# Limpiar caché
php artisan cache:clear
php artisan view:clear

# Verificar que CustomContentHelper esté en composer.json
# "files": ["app/Helpers/CustomContentHelper.php"]
```

---

## 10. CHECKLIST DE IMPLEMENTACIÓN

Para agregar edición en vivo a una nueva vista:

- [ ] Crear tabla `custom_contents` (migración)
- [ ] Registrar helper en `composer.json`
- [ ] Importar helper en vista: `@php use App\Helpers\CustomContentHelper; @endphp`
- [ ] Agregar clase `editable` y atributos data-*
- [ ] Crear/actualizar CustomContent records
- [ ] Validar permisos en sistema
- [ ] Probar edición
- [ ] Probar upload de multimedia
- [ ] Verificar caché está limpio

---

**Documento actualizado**: 27 de enero de 2026
**Versión**: 1.0
**Estado**: Funcional y documentado
