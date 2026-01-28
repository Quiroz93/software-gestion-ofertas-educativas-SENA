# 📁 ALGORITMO DE GESTIÓN DE CONTENIDO MULTIMEDIA

**Proyecto:** SoeSoftware2  
**Servicio:** MediaService  
**Fecha:** Enero 2026  
**Propósito:** Documentar el algoritmo completo de upload, listado, eliminación y generación de thumbnails para contenido multimedia

---

## 📋 ÍNDICE

1. [Resumen Ejecutivo](#resumen-ejecutivo)
2. [Algoritmo Principal: processUpload()](#algoritmo-principal-processupload)
3. [Validación de Seguridad](#validación-de-seguridad)
4. [Generación de Thumbnails](#generación-de-thumbnails)
5. [Listado de Archivos](#listado-de-archivos)
6. [Eliminación Segura](#eliminación-segura)
7. [Flujo Completo Cliente-Servidor](#flujo-completo-cliente-servidor)
8. [Estructura de Almacenamiento](#estructura-de-almacenamiento)
9. [Manejo de Errores](#manejo-de-errores)
10. [Performance y Optimización](#performance-y-optimización)

---

## 🎯 RESUMEN EJECUTIVO

El **MediaService** implementa un algoritmo robusto de 7 pasos para gestionar contenido multimedia con énfasis en:

- **Seguridad**: Doble validación MIME (cliente + servidor real)
- **Performance**: Thumbnails automáticos con Intervention Image
- **Organización**: Rutas estructuradas por tipo y categoría
- **Trazabilidad**: Metadata completa con usuario y timestamp
- **Escalabilidad**: Fácil extensión de tipos MIME permitidos

### Tecnologías Utilizadas

```php
- Laravel 12.48.1
- Intervention Image v3 (GD o Imagick driver)
- Storage facade (disk 'public')
- finfo (PHP file information)
```

---

## 🔄 ALGORITMO PRINCIPAL: processUpload()

### Diagrama de Flujo

```
┌─────────────────────────────────────────────────────────┐
│ 1. VALIDACIÓN DE SEGURIDAD                              │
│    ├─ Verificar MIME type declarado vs real             │
│    ├─ Usar finfo_file() para MIME verdadero             │
│    └─ Rechazar si no coincide con permitidos            │
└──────────────────┬──────────────────────────────────────┘
                   ↓
┌─────────────────────────────────────────────────────────┐
│ 2. GENERACIÓN DE NOMBRE ÚNICO                           │
│    ├─ Extraer extensión y validar lista prohibida       │
│    ├─ Crear slug del nombre original                    │
│    ├─ Agregar 8 caracteres aleatorios                   │
│    └─ Formato: {nombre-slug}-{random8}.{ext}            │
└──────────────────┬──────────────────────────────────────┘
                   ↓
┌─────────────────────────────────────────────────────────┐
│ 3. DETERMINACIÓN DE RUTA                                │
│    ├─ Validar path traversal (..)                       │
│    ├─ Sanitizar categoría con Str::slug()               │
│    └─ Construir: media/{tipo}/{categoria}/              │
└──────────────────┬──────────────────────────────────────┘
                   ↓
┌─────────────────────────────────────────────────────────┐
│ 4. ALMACENAMIENTO EN DISCO                              │
│    └─ $file->storeAs($path, $fileName, 'public')        │
└──────────────────┬──────────────────────────────────────┘
                   ↓
┌─────────────────────────────────────────────────────────┐
│ 5. GENERACIÓN DE METADATA                               │
│    ├─ file_name, file_size, mime_type                   │
│    ├─ uploaded_at, uploaded_by (auth()->id())           │
│    └─ dimensions (width x height para imágenes)         │
└──────────────────┬──────────────────────────────────────┘
                   ↓
┌─────────────────────────────────────────────────────────┐
│ 6. GENERACIÓN DE THUMBNAIL (solo imágenes NO gif)       │
│    ├─ Verificar ImageManager disponible                 │
│    ├─ Leer imagen con Intervention Image                │
│    ├─ Aplicar cover(200x150, crop centrado, 85%)        │
│    ├─ Guardar en: .../thumbnails/                       │
│    └─ Si falla: log warning, continuar                  │
└──────────────────┬──────────────────────────────────────┘
                   ↓
┌─────────────────────────────────────────────────────────┐
│ 7. RETORNAR RESULTADO                                   │
│    └─ Array con: success, file_path, url,               │
│       thumbnail_url, metadata                           │
└─────────────────────────────────────────────────────────┘
```

### Código Completo

```php
public function processUpload(UploadedFile $file, string $type, string $category): array
{
    // 1. Validar tipo MIME real
    $this->validateMimeType($file, $type);

    // 2. Generar nombre único y seguro
    $fileName = $this->generateFileName($file);

    // 3. Determinar ruta de almacenamiento
    $path = $this->getStoragePath($type, $category);

    // 4. Almacenar archivo
    $filePath = $file->storeAs($path, $fileName, $this->disk);

    // 5. Generar metadata
    $metadata = $this->generateMetadata($file, $filePath, $type);

    // 6. Intentar generar thumbnail para imágenes (NO para GIFs)
    $thumbnailUrl = null;
    if (($type === 'image') && !str_ends_with(strtolower($file->getClientOriginalName()), '.gif')) {
        try {
            $thumbnailPath = $this->generateThumbnail($filePath);
            if ($thumbnailPath) {
                $thumbnailUrl = Storage::disk($this->disk)->url($thumbnailPath);
            }
        } catch (Exception $e) {
            Log::warning("Thumbnail generation failed for {$filePath}: " . $e->getMessage());
        }
    }

    $fileUrl = Storage::disk($this->disk)->url($filePath);

    return [
        'success' => true,
        'file_path' => $filePath,
        'url' => $fileUrl,
        'thumbnail_url' => $thumbnailUrl ?? $fileUrl,
        'metadata' => $metadata
    ];
}
```

### Resultado Esperado

```json
{
  "success": true,
  "file_path": "media/images/programas/curso-sena-5a8b3c2d.jpg",
  "url": "http://domain/storage/media/images/programas/curso-sena-5a8b3c2d.jpg",
  "thumbnail_url": "http://domain/storage/media/images/programas/thumbnails/curso-sena-5a8b3c2d.jpg",
  "metadata": {
    "file_name": "curso-sena.jpg",
    "file_path": "media/images/programas/curso-sena-5a8b3c2d.jpg",
    "file_size": 245678,
    "mime_type": "image/jpeg",
    "uploaded_at": "2026-01-27T10:30:00.000000Z",
    "uploaded_by": 1,
    "dimensions": {
      "width": 1920,
      "height": 1080
    }
  }
}
```

---

## 🔒 VALIDACIÓN DE SEGURIDAD

### Algoritmo de validateMimeType()

```
┌─────────────────────────────────────────┐
│ VALIDACIÓN DOBLE CAPA                   │
├─────────────────────────────────────────┤
│ 1. Obtener MIME declarado               │
│    └─ $file->getMimeType()              │
│                                         │
│ 2. Verificar contra lista permitida    │
│    ├─ Imágenes: jpeg, png, gif, webp   │
│    └─ Videos: mp4, webm, ogg            │
│                                         │
│ 3. Obtener MIME REAL del archivo       │
│    ├─ finfo_open(FILEINFO_MIME_TYPE)   │
│    ├─ finfo_file($finfo, $realPath)    │
│    └─ finfo_close($finfo)               │
│                                         │
│ 4. Comparar MIME declarado vs real     │
│    └─ Si no coincide: RECHAZAR          │
└─────────────────────────────────────────┘
```

### Tipos MIME Permitidos

```php
// Imágenes
protected array $allowedImageMimes = [
    'image/jpeg',  // .jpg, .jpeg
    'image/png',   // .png
    'image/gif',   // .gif (animado)
    'image/webp'   // .webp (moderno, mejor compresión)
];

// Videos
protected array $allowedVideoMimes = [
    'video/mp4',   // .mp4 (estándar universal)
    'video/webm',  // .webm (optimizado web)
    'video/ogg'    // .ogg (open source)
];
```

### Extensiones Prohibidas

```php
private function generateFileName(UploadedFile $file): string
{
    $extension = strtolower($file->getClientOriginalExtension());
    
    // ❌ NUNCA PERMITIR
    $forbidden = [
        'php',    // Código ejecutable PHP
        'phtml',  // PHP HTML
        'php3', 'php4', 'php5',  // Versiones antiguas PHP
        'phar',   // PHP Archive (ejecutable)
        'exe',    // Ejecutable Windows
        'sh'      // Script shell Unix
    ];
    
    if (in_array($extension, $forbidden)) {
        throw new \InvalidArgumentException("Tipo de archivo prohibido");
    }
    
    // Generar nombre seguro
    $baseName = Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME));
    $unique = Str::random(8);
    
    return "{$baseName}-{$unique}.{$extension}";
}
```

### Protección Path Traversal

```php
private function getStoragePath(string $type, string $category): string
{
    // ❌ Bloquear path traversal (../)
    if (preg_match('/\.\./', $category)) {
        throw new \InvalidArgumentException('Categoría inválida');
    }

    // Sanitizar categoría (eliminar caracteres peligrosos)
    $category = Str::slug($category);

    return match($type) {
        'image', 'gif' => "media/images/{$category}",
        'video' => "media/videos/{$category}",
        default => "media/general/{$category}"
    };
}
```

**Ejemplos de Ataques Bloqueados:**

```php
// ❌ BLOQUEADO: Path traversal
$category = "../../config";  // Intentar acceder /config
// Resultado: Exception "Categoría inválida"

// ❌ BLOQUEADO: Extensión peligrosa
$file = "malware.php";  // Intentar subir PHP
// Resultado: Exception "Tipo de archivo prohibido"

// ❌ BLOQUEADO: MIME spoofing
// Cliente envía: image/jpeg
// Archivo real: application/x-php
// Resultado: Exception "El archivo no coincide con su tipo declarado"
```

---

## 🖼️ GENERACIÓN DE THUMBNAILS

### Algoritmo de generateThumbnail()

```
┌─────────────────────────────────────────────────────────┐
│ ENTRADA: filePath, width=200, height=150               │
└──────────────────┬──────────────────────────────────────┘
                   ↓
           ┌───────────────┐
           │ ¿ImageManager │  NO → Return null
           │  disponible?  │       (log warning)
           └───────┬───────┘
                   ↓ SÍ
           ┌───────────────┐
           │ ¿Archivo      │  NO → Return null
           │  existe?      │       (log error)
           └───────┬───────┘
                   ↓ SÍ
┌─────────────────────────────────────────────────────────┐
│ 1. Leer imagen                                          │
│    └─ $image = $imageManager->read($fullPath)           │
└──────────────────┬──────────────────────────────────────┘
                   ↓
┌─────────────────────────────────────────────────────────┐
│ 2. Aplicar transformación COVER                         │
│    ├─ Crop desde el centro (mantener proporciones)      │
│    ├─ Redimensionar a 200x150 px                        │
│    └─ Reducir calidad a 85% (optimizar tamaño)          │
│                                                         │
│    $image->cover($width, $height, 'center')             │
│          ->quality(85)                                  │
└──────────────────┬──────────────────────────────────────┘
                   ↓
┌─────────────────────────────────────────────────────────┐
│ 3. Generar ruta del thumbnail                           │
│    └─ Insertar /thumbnails/ antes del nombre archivo    │
│                                                         │
│    Original: media/images/programas/file.jpg            │
│    Thumb:    media/images/programas/thumbnails/file.jpg │
└──────────────────┬──────────────────────────────────────┘
                   ↓
┌─────────────────────────────────────────────────────────┐
│ 4. Crear directorio si no existe                        │
│    └─ mkdir($thumbnailDir, 0755, true)                  │
└──────────────────┬──────────────────────────────────────┘
                   ↓
┌─────────────────────────────────────────────────────────┐
│ 5. Guardar thumbnail                                    │
│    └─ $image->save($fullThumbPath)                      │
└──────────────────┬──────────────────────────────────────┘
                   ↓
           ┌───────────────┐
           │ Return path   │
           │ del thumbnail │
           └───────────────┘
```

### Configuración de ImageManager

```php
public function __construct()
{
    try {
        if (extension_loaded('gd')) {
            // Opción 1: PHP GD (más común)
            $this->imageManager = new ImageManager(new GdDriver());
            
        } elseif (extension_loaded('imagick')) {
            // Opción 2: ImageMagick (más potente)
            $this->imageManager = new ImageManager(
                new \Intervention\Image\Drivers\Imagick\Driver()
            );
            
        } else {
            // ⚠️ Ninguna extensión disponible
            $this->imageManager = null;
            Log::warning('Neither GD nor Imagick PHP extensions are loaded - thumbnail generation will be disabled');
        }
    } catch (\Exception $e) {
        $this->imageManager = null;
        Log::error('Failed to initialize ImageManager: ' . $e->getMessage());
    }
}
```

### Lógica de Cover vs Resize

```php
// ❌ RESIZE: Distorsiona imagen si proporciones diferentes
$image->resize(200, 150);  // Imagen 16:9 → se estira a 4:3

// ✅ COVER: Crop inteligente desde el centro
$image->cover(200, 150, 'center');  // Imagen 16:9 → recorta bordes, mantiene calidad
```

**Ejemplo Visual:**

```
Original (1920x1080 = 16:9)
┌─────────────────────────────┐
│                             │
│       CONTENIDO IMAGEN      │  cover(200, 150)
│                             │  ──────────────→
└─────────────────────────────┘

Thumbnail (200x150 = 4:3)
      ┌───────────┐
      │ CONTENIDO │  ← Crop desde centro
      │   IMAGEN  │    Mantiene calidad
      └───────────┘
```

### Excepciones: GIFs Animados

```php
// ⚠️ NO generar thumbnails para GIFs
if (($type === 'image') && !str_ends_with(strtolower($file->getClientOriginalName()), '.gif')) {
    // Solo aquí generar thumbnail
}

// Razón: Los GIFs pierden animación al procesarse
// Solución: Usar GIF original como thumbnail
```

---

## 📂 LISTADO DE ARCHIVOS

### Algoritmo de listFiles()

```
┌─────────────────────────────────────────┐
│ ENTRADA: type, category                 │
└──────────────────┬──────────────────────┘
                   ↓
┌─────────────────────────────────────────┐
│ 1. Construir ruta                       │
│    └─ media/{type}/{category}/          │
└──────────────────┬──────────────────────┘
                   ↓
           ┌───────────────┐
           │ ¿Directorio   │  NO → Return []
           │   existe?     │
           └───────┬───────┘
                   ↓ SÍ
┌─────────────────────────────────────────┐
│ 2. Obtener todos los archivos          │
│    └─ Storage::files($path)             │
└──────────────────┬──────────────────────┘
                   ↓
┌─────────────────────────────────────────┐
│ 3. Mapear cada archivo                  │
│    ├─ path, url, name                   │
│    ├─ size, modified                    │
│    ├─ is_gif (detectar extensión)       │
│    └─ thumbnail_url (si existe)         │
│                                         │
│    Si NO es GIF:                        │
│      ├─ Buscar en .../thumbnails/       │
│      └─ Fallback: usar URL original     │
│                                         │
│    Si es GIF:                           │
│      └─ Usar URL original (animado)     │
└──────────────────┬──────────────────────┘
                   ↓
┌─────────────────────────────────────────┐
│ 4. Ordenar por fecha descendente       │
│    └─ sortByDesc('modified')            │
└──────────────────┬──────────────────────┘
                   ↓
┌─────────────────────────────────────────┐
│ 5. Retornar array                       │
└─────────────────────────────────────────┘
```

### Estructura de Respuesta

```php
[
    [
        'path' => 'media/images/programas/curso-5a8b3c2d.jpg',
        'url' => 'http://domain/storage/media/images/programas/curso-5a8b3c2d.jpg',
        'name' => 'curso-5a8b3c2d.jpg',
        'size' => 245678,  // bytes
        'modified' => 1738067400,  // Unix timestamp
        'is_gif' => false,
        'thumbnail_url' => 'http://domain/storage/.../thumbnails/curso-5a8b3c2d.jpg'
    ],
    [
        'path' => 'media/images/programas/animacion.gif',
        'url' => 'http://domain/storage/media/images/programas/animacion.gif',
        'name' => 'animacion.gif',
        'size' => 1024000,
        'modified' => 1738066800,
        'is_gif' => true,
        'thumbnail_url' => 'http://domain/storage/media/images/programas/animacion.gif'  // ← Mismo URL (GIF animado)
    ]
]
```

### Lógica de Thumbnail URL

```php
// Para imágenes normales (jpg, png, webp)
if ($type === 'image' && !$fileData['is_gif']) {
    $thumbPath = str_replace('media/', 'media/thumbnails/', $file);
    
    if (Storage::disk($this->disk)->exists($thumbPath)) {
        // ✅ Thumbnail existe
        $fileData['thumbnail_url'] = Storage::disk($this->disk)->url($thumbPath);
    } else {
        // ⚠️ Thumbnail no existe (error previo), usar original
        $fileData['thumbnail_url'] = $fileUrl;
    }
}

// Para GIFs animados
elseif ($type === 'gif') {
    // ✅ Usar URL original para mantener animación
    $fileData['thumbnail_url'] = $fileUrl;
}
```

---

## 🗑️ ELIMINACIÓN SEGURA

### Algoritmo de deleteFile()

```
┌─────────────────────────────────────────┐
│ ENTRADA: filePath                       │
│          (ej: media/images/prog/x.jpg)  │
└──────────────────┬──────────────────────┘
                   ↓
┌─────────────────────────────────────────┐
│ 1. Eliminar archivo principal           │
│    └─ $deleted = Storage::delete($path) │
└──────────────────┬──────────────────────┘
                   ↓
┌─────────────────────────────────────────┐
│ 2. Generar ruta del thumbnail           │
│    └─ Insertar /thumbnails/ en path     │
│                                         │
│    Original: media/images/prog/x.jpg    │
│    Thumb:    media/images/prog/         │
│              thumbnails/x.jpg           │
└──────────────────┬──────────────────────┘
                   ↓
           ┌───────────────┐
           │ ¿Thumbnail    │  NO → Skip
           │   existe?     │
           └───────┬───────┘
                   ↓ SÍ
┌─────────────────────────────────────────┐
│ 3. Eliminar thumbnail                   │
│    └─ Storage::delete($thumbPath)       │
└──────────────────┬──────────────────────┘
                   ↓
┌─────────────────────────────────────────┐
│ 4. Retornar resultado                   │
│    └─ true si exitoso, false si error   │
└─────────────────────────────────────────┘
```

### Código Completo

```php
public function deleteFile(string $filePath): bool
{
    // Eliminar archivo principal
    $deleted = Storage::disk($this->disk)->delete($filePath);

    // Intentar eliminar thumbnail si existe
    $thumbPath = str_replace('media/', 'media/thumbnails/', $filePath);
    if (Storage::disk($this->disk)->exists($thumbPath)) {
        Storage::disk($this->disk)->delete($thumbPath);
    }

    return $deleted;
}
```

### Casos de Uso

```php
// ✅ CASO 1: Eliminar imagen con thumbnail
$service->deleteFile('media/images/programas/curso-abc123.jpg');
// Resultado:
// - Eliminado: media/images/programas/curso-abc123.jpg
// - Eliminado: media/images/programas/thumbnails/curso-abc123.jpg

// ✅ CASO 2: Eliminar GIF (sin thumbnail)
$service->deleteFile('media/images/programas/animacion.gif');
// Resultado:
// - Eliminado: media/images/programas/animacion.gif
// - No busca thumbnail (no existe)

// ✅ CASO 3: Eliminar video
$service->deleteFile('media/videos/tutoriales/intro.mp4');
// Resultado:
// - Eliminado: media/videos/tutoriales/intro.mp4
// - No busca thumbnail (no aplica)
```

---

## 🔄 FLUJO COMPLETO CLIENTE-SERVIDOR

### Diagrama de Secuencia

```
USUARIO              FRONTEND             CONTROLLER           SERVICE             STORAGE
  │                     │                     │                   │                   │
  │ 1. Clic en          │                     │                   │                   │
  │    imagen editable  │                     │                   │                   │
  ├────────────────────>│                     │                   │                   │
  │                     │                     │                   │                   │
  │                     │ 2. Mostrar modal    │                   │                   │
  │                     │    de upload        │                   │                   │
  │<────────────────────┤                     │                   │                   │
  │                     │                     │                   │                   │
  │ 3. Seleccionar      │                     │                   │                   │
  │    archivo          │                     │                   │                   │
  ├────────────────────>│                     │                   │                   │
  │                     │                     │                   │                   │
  │                     │ 4. POST FormData    │                   │                   │
  │                     │    /public/media/   │                   │                   │
  │                     │    upload           │                   │                   │
  │                     ├────────────────────>│                   │                   │
  │                     │                     │                   │                   │
  │                     │                     │ 5. Middleware     │                   │
  │                     │                     │    auth +         │                   │
  │                     │                     │    permission     │                   │
  │                     │                     │                   │                   │
  │                     │                     │ 6. Validar        │                   │
  │                     │                     │    request        │                   │
  │                     │                     │                   │                   │
  │                     │                     │ 7. authorize()    │                   │
  │                     │                     │    check          │                   │
  │                     │                     │                   │                   │
  │                     │                     │ 8. processUpload()│                   │
  │                     │                     ├──────────────────>│                   │
  │                     │                     │                   │                   │
  │                     │                     │                   │ 9. Validar MIME   │
  │                     │                     │                   │    (doble capa)   │
  │                     │                     │                   │                   │
  │                     │                     │                   │ 10. Generar       │
  │                     │                     │                   │     nombre único  │
  │                     │                     │                   │                   │
  │                     │                     │                   │ 11. storeAs()     │
  │                     │                     │                   ├──────────────────>│
  │                     │                     │                   │                   │
  │                     │                     │                   │ 12. Archivo       │
  │                     │                     │                   │     guardado      │
  │                     │                     │                   │<──────────────────┤
  │                     │                     │                   │                   │
  │                     │                     │                   │ 13. Generar       │
  │                     │                     │                   │     thumbnail     │
  │                     │                     │                   │                   │
  │                     │                     │                   │ 14. Thumbnail     │
  │                     │                     │                   │     guardado      │
  │                     │                     │                   ├──────────────────>│
  │                     │                     │                   │<──────────────────┤
  │                     │                     │                   │                   │
  │                     │                     │ 15. Return data   │                   │
  │                     │                     │<──────────────────┤                   │
  │                     │                     │                   │                   │
  │                     │                     │ 16. Update        │                   │
  │                     │                     │     CustomContent │                   │
  │                     │                     │     record        │                   │
  │                     │                     │                   │                   │
  │                     │ 17. JSON response   │                   │                   │
  │                     │     {success, url}  │                   │                   │
  │                     │<────────────────────┤                   │                   │
  │                     │                     │                   │                   │
  │                     │ 18. Actualizar DOM  │                   │                   │
  │                     │     <img src>       │                   │                   │
  │                     │                     │                   │                   │
  │ 19. Imagen          │                     │                   │                   │
  │     actualizada     │                     │                   │                   │
  │<────────────────────┤                     │                   │                   │
```

### Request de Upload

```javascript
// Frontend JavaScript
const formData = new FormData();
formData.append('file', fileInput.files[0]);
formData.append('model', 'home');
formData.append('model_id', '0');
formData.append('key', 'hero_image');
formData.append('type', 'image');
formData.append('category', 'home');
formData.append('alt_text', 'Imagen hero principal');

fetch('/public/media/upload', {
    method: 'POST',
    headers: {
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
    },
    body: formData
})
.then(response => response.json())
.then(data => {
    if (data.success) {
        // Actualizar imagen en DOM
        document.querySelector('img[data-key="hero_image"]').src = data.url;
    }
});
```

### Controller: MediaContentController

```php
public function upload(Request $request)
{
    // Autorización
    $this->authorize('public_content.edit');

    // Validación
    $validated = $request->validate([
        'file' => 'required|file|max:10240',  // 10 MB
        'model' => 'required|string',
        'model_id' => 'required',
        'key' => 'required|string',
        'type' => 'required|in:image,video,gif',
        'category' => 'required|string',
        'alt_text' => 'nullable|string'
    ]);

    // Procesar upload con MediaService
    $result = $this->mediaService->processUpload(
        $request->file('file'),
        $validated['type'],
        $validated['category']
    );

    // Actualizar CustomContent
    CustomContent::updateOrCreate([
        'contentable_type' => $validated['model'],
        'contentable_id' => $validated['model_id'],
        'key' => $validated['key']
    ], [
        'value' => $result['file_path'],
        'type' => $validated['type'],
        'metadata' => json_encode($result['metadata']),
        'alt_text' => $validated['alt_text']
    ]);

    return response()->json([
        'success' => true,
        'url' => $result['url'],
        'thumbnail_url' => $result['thumbnail_url']
    ]);
}
```

### Response JSON

```json
{
  "success": true,
  "url": "http://domain/storage/media/images/home/hero-5a8b3c2d.jpg",
  "thumbnail_url": "http://domain/storage/media/images/home/thumbnails/hero-5a8b3c2d.jpg"
}
```

---

## 📁 ESTRUCTURA DE ALMACENAMIENTO

### Árbol de Directorios

```
storage/app/public/media/
│
├── images/
│   ├── home/
│   │   ├── hero-5a8b3c2d.jpg
│   │   ├── card1-9f2e4a1b.png
│   │   ├── thumbnails/
│   │   │   ├── hero-5a8b3c2d.jpg       (200x150)
│   │   │   └── card1-9f2e4a1b.png      (200x150)
│   │
│   ├── programas/
│   │   ├── curso-abc123.jpg
│   │   ├── animacion.gif                (sin thumbnail)
│   │   └── thumbnails/
│   │       └── curso-abc123.jpg
│   │
│   ├── ofertas/
│   │   ├── oferta1-xyz789.webp
│   │   └── thumbnails/
│   │       └── oferta1-xyz789.webp
│   │
│   └── general/
│       ├── logo-empresa.png
│       └── thumbnails/
│           └── logo-empresa.png
│
├── videos/
│   ├── tutoriales/
│   │   ├── intro-def456.mp4
│   │   ├── demo-ghi789.webm
│   │   └── posters/                     (opcional, futuro)
│   │       └── intro-def456.png
│   │
│   └── general/
│       └── presentacion.mp4
│
└── gifs/                                 (opcional, categorización específica)
    └── animaciones/
        └── loading-jkl012.gif
```

### Convenciones de Nombres

```php
// Patrón de nombres
{nombre-slug}-{random8}.{extension}

// Ejemplos reales
"curso-desarrollo-web-5a8b3c2d.jpg"
"manual-usuario-9f2e4a1b.pdf"
"intro-sena-abc12345.mp4"

// Generación
$baseName = Str::slug("Curso Desarrollo Web");  // → "curso-desarrollo-web"
$unique = Str::random(8);                       // → "5a8b3c2d"
$fileName = "{$baseName}-{$unique}.jpg";        // → "curso-desarrollo-web-5a8b3c2d.jpg"
```

### Rutas según Tipo y Categoría

```php
private function getStoragePath(string $type, string $category): string
{
    return match($type) {
        'image', 'gif' => "media/images/{$category}",
        'video' => "media/videos/{$category}",
        default => "media/general/{$category}"
    };
}

// Ejemplos
getStoragePath('image', 'programas');  // → media/images/programas
getStoragePath('video', 'tutoriales'); // → media/videos/tutoriales
getStoragePath('gif', 'animaciones');  // → media/images/animaciones
```

### URLs Públicas

```php
// Storage symlink debe existir
php artisan storage:link

// URL generada
Storage::disk('public')->url('media/images/home/hero-5a8b3c2d.jpg');
// → http://domain/storage/media/images/home/hero-5a8b3c2d.jpg

// Acceso directo desde blade
<img src="{{ asset('storage/media/images/home/hero-5a8b3c2d.jpg') }}">
```

---

## ⚠️ MANEJO DE ERRORES

### Tipos de Errores y Respuestas

```php
┌─────────────────────────────────────────────────────────────────┐
│ ERROR                      │ TIPO          │ ACCIÓN             │
├────────────────────────────┼───────────────┼────────────────────┤
│ MIME no permitido          │ Exception     │ Rechazar upload    │
│ MIME spoofing detectado    │ Exception     │ Rechazar upload    │
│ Extensión prohibida        │ Exception     │ Rechazar upload    │
│ Path traversal (..)        │ Exception     │ Rechazar upload    │
│ Archivo excede tamaño      │ Validation    │ Rechazar upload    │
│ ImageManager no disponible │ Warning       │ Continuar sin thumb│
│ Thumbnail generation falla │ Warning       │ Continuar, log     │
│ Directorio no existe       │ Auto-create   │ mkdir recursive    │
│ Storage::storeAs falla     │ Exception     │ Rechazar upload    │
└─────────────────────────────────────────────────────────────────┘
```

### Try-Catch en Thumbnail Generation

```php
// ✅ NO FALLAR UPLOAD si thumbnail falla
$thumbnailUrl = null;
if (($type === 'image') && !str_ends_with(strtolower($file->getClientOriginalName()), '.gif')) {
    try {
        $thumbnailPath = $this->generateThumbnail($filePath);
        if ($thumbnailPath) {
            $thumbnailUrl = Storage::disk($this->disk)->url($thumbnailPath);
        }
    } catch (Exception $e) {
        // ⚠️ Log warning pero continuar
        Log::warning("Thumbnail generation failed for {$filePath}: " . $e->getMessage());
    }
}

// Si thumbnail falla, usar URL original
$fileUrl = Storage::disk($this->disk)->url($filePath);
return [
    'success' => true,
    'url' => $fileUrl,
    'thumbnail_url' => $thumbnailUrl ?? $fileUrl,  // ← Fallback
    'metadata' => $metadata
];
```

### Validación en Controller

```php
public function upload(Request $request)
{
    try {
        // Autorización
        $this->authorize('public_content.edit');

        // Validación Laravel
        $validated = $request->validate([
            'file' => 'required|file|max:10240',  // 10 MB máximo
            'model' => 'required|string',
            'key' => 'required|string',
            'type' => 'required|in:image,video,gif',
            'category' => 'required|string|max:50'
        ]);

        // Procesar upload
        $result = $this->mediaService->processUpload(
            $request->file('file'),
            $validated['type'],
            $validated['category']
        );

        return response()->json(['success' => true, 'url' => $result['url']]);

    } catch (\InvalidArgumentException $e) {
        // Error de validación de seguridad
        return response()->json(['success' => false, 'error' => $e->getMessage()], 400);

    } catch (\Exception $e) {
        // Error inesperado
        Log::error('Upload failed: ' . $e->getMessage());
        return response()->json(['success' => false, 'error' => 'Error al subir archivo'], 500);
    }
}
```

### Logging Estratégico

```php
// ✅ Casos que logear

// 1. WARNING: Thumbnail falla (no crítico)
Log::warning("Thumbnail generation failed for {$filePath}: " . $e->getMessage());

// 2. ERROR: ImageManager no inicializa
Log::error('Failed to initialize ImageManager: ' . $e->getMessage());

// 3. WARNING: Extensiones no disponibles
Log::warning('Neither GD nor Imagick PHP extensions are loaded');

// 4. INFO: Operaciones exitosas
Log::info("Thumbnail generado exitosamente: {$thumbnailPath}");

// 5. ERROR: Archivo no existe al generar thumbnail
Log::error("Archivo para thumbnail no existe: {$fullPath}");

// 6. DEBUG: Skip thumbnail para debugging
Log::debug('ImageManager not available - skipping thumbnail generation');
```

---

## ⚡ PERFORMANCE Y OPTIMIZACIÓN

### Estrategias Implementadas

```
┌─────────────────────────────────────────────────────────────┐
│ ESTRATEGIA              │ IMPLEMENTACIÓN                    │
├─────────────────────────┼───────────────────────────────────┤
│ Thumbnails automáticos  │ generateThumbnail() en upload     │
│ Reducción calidad       │ quality(85) en Intervention       │
│ Dimensiones fijas       │ 200x150px (cover, no distorsión)  │
│ Skip GIFs               │ No procesar animados (preservar)  │
│ Lazy generation         │ Solo al subir, no al listar       │
│ Fallback inteligente    │ URL original si thumbnail falla   │
│ Nombres únicos          │ Evitar colisiones (slug + random) │
│ Path categorizado       │ Mejor indexación filesystem       │
└─────────────────────────────────────────────────────────────┘
```

### Benchmark Estimado

```php
// Upload de imagen 1920x1080 (245 KB) con thumbnail

┌────────────────────────────┬──────────────┐
│ PASO                       │ TIEMPO (ms)  │
├────────────────────────────┼──────────────┤
│ 1. Validación MIME         │      5-10    │
│ 2. Generar nombre          │      1-2     │
│ 3. Storage::storeAs()      │     50-100   │
│ 4. Generar metadata        │     10-20    │
│ 5. generateThumbnail()     │    100-200   │
│    ├─ read()               │     30-50    │
│    ├─ cover()              │     40-80    │
│    └─ save()               │     30-70    │
│ 6. Actualizar DB           │     20-40    │
├────────────────────────────┼──────────────┤
│ TOTAL                      │   186-372 ms │
└────────────────────────────┴──────────────┘

// Conclusión: < 400ms por upload (aceptable)
```

### Optimizaciones Futuras

```php
// 1. ⚡ Queue para thumbnails pesados
dispatch(new GenerateThumbnailJob($filePath))->onQueue('media');

// 2. ⚡ CDN para servir archivos
config(['filesystems.disks.public.url' => 'https://cdn.domain.com']);

// 3. ⚡ WebP conversion automática
$image->toWebp()->quality(80)->save($webpPath);

// 4. ⚡ Lazy loading responsive
<img src="{{ $url }}" loading="lazy" srcset="{{ $thumb }} 200w, {{ $url }} 1920w">

// 5. ⚡ Cache de listFiles()
Cache::remember("media_files_{$type}_{$category}", 600, function() {
    return $this->listFiles($type, $category);
});

// 6. ⚡ Progressive JPEGs
$image->interlace(true)->save($path);
```

### Tamaños Recomendados

```php
// Thumbnails por contexto
const THUMBNAIL_SIZES = [
    'grid' => ['width' => 200, 'height' => 150],      // Listado galería
    'preview' => ['width' => 400, 'height' => 300],   // Vista previa
    'card' => ['width' => 350, 'height' => 200],      // Cards Bootstrap
    'hero' => ['width' => 1200, 'height' => 600],     // Heros responsive
];

// Calidad por tipo
const QUALITY_LEVELS = [
    'thumbnail' => 85,    // Balance calidad/tamaño
    'preview' => 90,      // Más calidad
    'hero' => 95,         // Máxima calidad
    'download' => 100,    // Sin compresión
];
```

---

## 🔧 TROUBLESHOOTING

### Problemas Comunes

```
┌─────────────────────────────────────────────────────────────────────┐
│ PROBLEMA                        │ CAUSA              │ SOLUCIÓN     │
├─────────────────────────────────┼────────────────────┼──────────────┤
│ Thumbnails no se generan        │ GD/Imagick falta   │ Instalar ext │
│ Imágenes no visibles en browser │ storage:link falta │ php artisan  │
│ Permisos denegados al guardar   │ Permisos carpeta   │ chmod 755    │
│ Error 413 (Request too large)   │ Límite PHP/Nginx   │ Ajustar ini  │
│ Thumbnails pixelados            │ Calidad muy baja   │ Aumentar %   │
│ GIFs pierden animación          │ Procesados         │ Skip GIFs    │
│ Nombres duplicados               │ Random collision   │ Verificar 8  │
└─────────────────────────────────────────────────────────────────────┘
```

### Comandos de Diagnóstico

```bash
# Verificar extensiones PHP
php -m | grep -i gd        # Debe aparecer "gd"
php -m | grep -i imagick   # O "imagick"

# Verificar storage link
ls -la public/storage      # Debe ser symlink → ../storage/app/public

# Crear storage link
php artisan storage:link

# Verificar permisos
ls -la storage/app/public  # Debe ser drwxr-xr-x (755)

# Arreglar permisos
chmod -R 755 storage/app/public
chown -R www-data:www-data storage/app/public  # Linux

# Verificar límites PHP
php -i | grep upload_max_filesize    # Debe ser >= 10M
php -i | grep post_max_size          # Debe ser >= 10M
php -i | grep memory_limit           # Debe ser >= 128M

# Test de upload manual
php artisan tinker
$file = new \Illuminate\Http\UploadedFile('/path/test.jpg', 'test.jpg');
$service = app(\App\Services\MediaService::class);
$result = $service->processUpload($file, 'image', 'test');
dd($result);
```

---

## 📚 REFERENCIAS

### Archivos Relacionados

```
app/Services/MediaService.php                    (Servicio principal)
app/Http/Controllers/Public/MediaContentController.php
app/Models/CustomContent.php
config/filesystems.php                           (Configuración disks)
storage/app/public/media/                        (Almacenamiento físico)
```

### Documentación Externa

- [Laravel Storage](https://laravel.com/docs/12.x/filesystem)
- [Intervention Image v3](https://image.intervention.io/v3)
- [PHP GD Extension](https://www.php.net/manual/en/book.image.php)
- [ImageMagick PHP](https://www.php.net/manual/en/book.imagick.php)
- [File Information (finfo)](https://www.php.net/manual/en/book.fileinfo.php)

### Paquetes Composer

```json
{
  "require": {
    "intervention/image": "^3.0",
    "intervention/gif": "^4.0"
  }
}
```

---

## ✅ CHECKLIST DE IMPLEMENTACIÓN

### Configuración Inicial

- [ ] Instalar `intervention/image` via Composer
- [ ] Verificar extensión PHP GD o Imagick instalada
- [ ] Crear symlink con `php artisan storage:link`
- [ ] Configurar permisos 755 en `storage/app/public`
- [ ] Ajustar `upload_max_filesize` y `post_max_size` en `php.ini`

### Seguridad

- [ ] Validar MIME types en `$allowedImageMimes` y `$allowedVideoMimes`
- [ ] Verificar extensiones prohibidas en `$forbidden`
- [ ] Implementar path traversal protection
- [ ] Agregar middleware `can:public_content.edit` a rutas
- [ ] Usar `authorize()` en controllers

### Funcionalidad

- [ ] Implementar `processUpload()` con 7 pasos
- [ ] Implementar `generateThumbnail()` con fallback
- [ ] Implementar `listFiles()` con detección de GIFs
- [ ] Implementar `deleteFile()` con eliminación de thumbnails
- [ ] Probar upload de JPG, PNG, WEBP, GIF, MP4

### Testing

- [ ] Test unitario: validación MIME correcta
- [ ] Test unitario: validación MIME spoofing rechazada
- [ ] Test unitario: extensión prohibida rechazada
- [ ] Test unitario: path traversal bloqueado
- [ ] Test integración: upload completo con thumbnail
- [ ] Test integración: listado de archivos ordenado
- [ ] Test integración: eliminación con thumbnail

### Performance

- [ ] Verificar thumbnails se generan < 200ms
- [ ] Implementar calidad 85% para balance
- [ ] Skip thumbnails para GIFs
- [ ] Considerar queue para videos grandes (futuro)

---

**FIN DEL DOCUMENTO**

Este algoritmo garantiza uploads seguros, eficientes y escalables para el proyecto SoeSoftware2.
