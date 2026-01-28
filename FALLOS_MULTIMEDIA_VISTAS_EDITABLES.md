# 🔴 Análisis: Fallos en Manejo de Recursos Multimedia - Vistas Públicas Editables

**Fecha:** Enero 27, 2026  
**Scope:** Manejo multimedia en index de ofertas (public.ofertas.index)  
**Estado:** ⚠️ CRÍTICO - Múltiples vulnerabilidades y malas prácticas identificadas

---

## 📊 Resumen Ejecutivo

Se han identificado **14 fallos críticos y medios** en el manejo de recursos multimedia en las vistas públicas editables, especialmente en el index de ofertas. Los problemas van desde vulnerabilidades de seguridad, falta de validación de integridad de archivos, hasta problemas de rendimiento y UX.

---

## 🔴 Fallos Identificados

### **GRUPO 1: SEGURIDAD Y VALIDACIÓN**

#### 1. ⛔ Path Traversal y Validación Insuficiente de Rutas
**Ubicación:** [CustomContentController.php](app/Http/Controllers/Public/CustomContentController.php#L156-L170)  
**Severidad:** 🔴 CRÍTICA

```php
// ❌ PROBLEMA:
'file_path' => 'required|string',  // Solo validación de string!
```

**Riesgo:**
- El usuario podría guardar rutas como `../../storage/private.jpg`
- Acceso a archivos fuera del directorio permitido
- Lectura de archivos sensibles (config, env, etc.)

**Ejemplo de ataque:**
```javascript
// Malicious payload
{
  "file_path": "../../../../.env",  // Apunta al archivo .env
  "model": "oferta",
  "model_id": 1
}
```

**Recomendación:**
```php
$request->validate([
    'file_path' => [
        'required',
        'string',
        'starts_with:media/',  // Restringir a carpeta específica
        'not_regex:/\.\.\/',   // Prohibir path traversal
    ],
    // ...
]);
```

---

#### 2. ⛔ Almacenamiento de Rutas sin Validación de Existencia
**Ubicación:** [MediaContentController.php](app/Http/Controllers/Public/MediaContentController.php#L140-L180)  
**Severidad:** 🔴 CRÍTICA

```php
// ❌ PROBLEMA:
[
    'value' => $request->file_path,  // Se almacena sin verificar que el archivo existe
    'type' => $request->type,
    'metadata' => $request->metadata
]
```

**Riesgo:**
- Referencias a archivos que no existen
- URLs rotas que devuelven 404
- Datos inconsistentes en BD
- Experiencia de usuario degradada (imágenes no cargan)

**Flujo problemático:**
1. Usuario sube imagen → archivo se almacena
2. Usuario guarda referencia a `media/ofertas/123.jpg`
3. Administrador elimina el archivo del storage manualmente
4. La referencia en BD sigue existiendo → URL rota

---

#### 3. ⛔ MIME Type Spoofing - Validación Incompleta
**Ubicación:** [MediaService.php](app/Services/MediaService.php#L265-L285)  
**Severidad:** 🟠 MEDIA

```php
// ⚠️ INSUFICIENTE:
private function validateMimeType(UploadedFile $file, string $type): void
{
    $mime = $file->getMimeType();  // Obtiene MIME del cliente
    
    $allowed = match($type) {
        'image', 'gif' => $this->allowedImageMimes,
        'video' => $this->allowedVideoMimes,
    };
    
    if (!in_array($mime, $allowed)) {
        throw new \InvalidArgumentException("Tipo de archivo no permitido: {$mime}");
    }
```

**Riesgo:**
- Cliente envía `.jpg.php` con MIME `image/jpeg`
- Archivo se almacena y se ejecuta como PHP si está en ruta servible
- RCE (Remote Code Execution) potencial

**Solución:** Ya está parcialmente implementada pero incompleta:
```php
// ✅ Lo que está en el código:
$finfo = finfo_open(FILEINFO_MIME_TYPE);
$realMime = finfo_file($finfo, $file->getRealPath());
// ❌ Pero no se valida contra $realMime, solo contra $mime del cliente
```

---

#### 4. ⛔ Sin Sanitización de Nombres de Archivo
**Ubicación:** [MediaService.php](app/Services/MediaService.php#L55)  
**Severidad:** 🟠 MEDIA

```php
// ⚠️ PROBLEMA:
protected function generateFileName(UploadedFile $file): string
{
    // El método no está completo en el archivo
    // Pero necesita sanitizar el nombre original
}
```

**Riesgo:**
- Nombres con caracteres especiales: `imagen;rm -rf .jpg`
- Nombres extremadamente largos
- Unicode malicioso
- Double extensions: `shell.php.jpg`

**Recomendación:**
```php
protected function generateFileName(UploadedFile $file): string
{
    $originalName = $file->getClientOriginalName();
    $extension = $file->getClientOriginalExtension();
    
    // Sanitizar nombre
    $sanitized = preg_replace('/[^a-zA-Z0-9._-]/', '', 
        pathinfo($originalName, PATHINFO_FILENAME));
    
    // Generar único
    return sprintf(
        '%s_%d.%s',
        $sanitized,
        time(),
        strtolower($extension)
    );
}
```

---

### **GRUPO 2: INTEGRIDAD Y CONSISTENCIA DE DATOS**

#### 5. ⛔ Sin Eliminación en Cascada de Referencias Multimedia
**Ubicación:** [MediaContentController.php](app/Http/Controllers/Public/MediaContentController.php#L220-L240)  
**Severidad:** 🔴 CRÍTICA

```php
// ❌ PROBLEMA:
public function delete(Request $request)
{
    // Solo elimina el archivo físico
    $deleted = $this->mediaService->deleteFile($request->file_path);
    // NO elimina referencias en custom_contents tabla!
}
```

**Riesgo:**
- **Huérfanos en BD:** referencias a archivos que no existen
- **Datos fantás**ma: registros que apuntan a nada
- **URLs rotas:** todas las imágenes que usaban ese archivo

**Ejemplo:**
```
1. Archivo: storage/media/ofertas/banner.jpg
2. Referencias en BD: 5 registros en custom_contents apuntan a este archivo
3. Usuario elimina el archivo
4. Las 5 referencias quedan "huérfanas" → URLs rotas en 5 lugares
```

**Solución:**
```php
public function delete(Request $request)
{
    $this->authorize('public_content.edit');
    
    $filePath = $request->validate(['file_path' => 'required|string']);
    
    // 1. Eliminar referencias en BD
    CustomContent::where('value', $filePath)->delete();
    
    // 2. Eliminar archivo físico
    $deleted = $this->mediaService->deleteFile($filePath);
    
    return response()->json([
        'success' => $deleted,
        'message' => $deleted ? 'Archivo eliminado' : 'Error'
    ]);
}
```

---

#### 6. ⛔ Sin Validación de Existencia en `getCustomContent()`
**Ubicación:** [helpers.php](app/Helpers/helpers.php#L5-L30)  
**Severidad:** 🟠 MEDIA

```php
// ❌ PROBLEMA:
function getCustomContent($modelName, $key, $default = null)
{
    // No verifica si el archivo de la ruta existe
    // Solo retorna el valor (path) de la BD
    $content = CustomContent::where([
        'contentable_type' => $modelClass,
        'contentable_id' => 0,
        'key' => $key,
    ])->first();
    
    return $content?->value ?? $default;
    // Retorna ruta aunque el archivo no exista
}
```

**En Vista:**
```blade
@php
    $bannerImagePath = getCustomContent('oferta', 'banner_image', null);
    $bannerImageUrl = $bannerImagePath 
        ? asset('storage/' . $bannerImagePath)
        : asset('images/oferta4.jpeg');
@endphp
```

**Riesgo:**
- Si el archivo fue eliminado manualmente, `asset()` genera URLs válidas pero 404
- La imagen nunca carga
- Sin feedback visual para el usuario

---

#### 7. ⛔ Sin Validación de Tipo de Contenido Almacenado
**Ubicación:** [resources/views/public/ofertas/index.blade.php](resources/views/public/ofertas/index.blade.php#L123-L135)  
**Severidad:** 🟠 MEDIA

```php
// ⚠️ INSUFICIENTE:
@php
    $imagenPath = $oferta->custom('imagen');  // ¿Qué pasa si value = "malicious.php"?
    $imagenUrl = $imagenPath 
        ? asset('storage/' . $imagenPath)
        : asset('images/ofertas/default.jpg');
@endphp
<img src="{{ $imagenUrl }}" ... >  // Renderiza sin validar
```

**Riesgo:**
- Si alguien manualmente inserta `<script>alert('xss')</script>` en custom_contents
- La vista lo renderizaría (aunque limitado en `<img src>`)
- Potencial XSS en contextos vulnerables

---

### **GRUPO 3: RENDIMIENTO Y OPTIMIZACIÓN**

#### 8. ⛔ N+1 Queries - Carga Ineficiente en Ofertas
**Ubicación:** [resources/views/public/ofertas/index.blade.php](resources/views/public/ofertas/index.blade.php#L117-L150)  
**Severidad:** 🟡 MEDIA

```blade
@forelse($ofertas as $oferta)
    <img src="{{ $imagenUrl }}" 
         class="card-img-top editable" ... >
    
    <h5>{{ $oferta->custom('titulo', $oferta->nombre) }}</h5>
    <p>{{ Str::limit($oferta->custom('descripcion', ''), 120) }}</p>
    <li>{{ $oferta->custom('modalidad', 'N/A') }}</li>
@endforelse
```

**Problema:**
```
N ofertas en loop:
- 1 query: SELECT * FROM ofertas WHERE estado = 'activo'
- N queries: SELECT * FROM custom_contents WHERE ... for each $oferta->custom()
  - Total: 1 + (N × 3) queries!
  
Ejemplo: 10 ofertas = 31 queries total 😱
```

**Solución:**
```php
// En PublicOfertaController:
public function index()
{
    $ofertas = Oferta::where('estado', 'activo')
        ->with(['customContents' => function($q) {
            $q->whereIn('key', ['imagen', 'titulo', 'descripcion', 'modalidad']);
        }])
        ->orderBy('fecha_inicio')
        ->get();
    
    return view('public.ofertas.index', compact('ofertas'));
}
```

---

#### 9. ⛔ Sin Caché de Imágenes - Cada Refresh Recarga desde Storage
**Ubicación:** [resources/views/layouts/public.blade.php](resources/views/layouts/public.blade.php#L400-L450)  
**Severidad:** 🟡 MEDIA

```javascript
// ⚠️ PROBLEMA:
function loadExistingFiles(type) {
    // Cada vez que el usuario abre el modal, hace fetch a /public/media/list
    fetch(url, { ... })  // Sin caché!
}
```

**Impacto:**
- Cada edición: recarga lista completa de archivos
- Sin Headers HTTP `Cache-Control`
- Lectura innecesaria del filesystem

---

#### 10. ⛔ Lazy Loading Incompleto en Grid de Archivos
**Ubicación:** [resources/views/layouts/public.blade.php](resources/views/layouts/public.blade.php#L500-L530)  
**Severidad:** 🟡 MEDIA

```javascript
// ⚠️ PARCIALMENTE IMPLEMENTADO:
function initLazyLoading() {
    const imageObserver = new IntersectionObserver((entries, observer) => {
        // Solo carga imágenes cuando entran en viewport
        // Pero:
        // - No hay placeholder skeleton
        // - Sin blur-up effect
        // - Sin handling de errores de carga
    });
}
```

---

### **GRUPO 4: FUNCIONALIDAD Y FLUJOS**

#### 11. ⛔ Sin Validación de Limites de Almacenamiento
**Ubicación:** [MediaService.php](app/Services/MediaService.php#L55-L95)  
**Severidad:** 🟠 MEDIA

```php
// ❌ FALTA:
public function processUpload(UploadedFile $file, string $type, string $category): array
{
    // Valida: 'file' => 'max:51200' (50MB)
    // Pero NO valida:
    // ❌ Espacio total del servidor
    // ❌ Cuota por usuario
    // ❌ Cuota por categoría (ofertas, programas, etc)
}
```

**Riesgo:**
- Usuario malicioso sube 1000 archivos de 50MB cada uno
- Llena el storage del servidor
- Aplicación se vuelve inoperante

---

#### 12. ⛔ Sin Gestión de Versiones o Historial de Cambios
**Ubicación:** Todo el flujo de multimedia  
**Severidad:** 🟡 MEDIA

**Problema:**
```
Usuario edita imagen de oferta:
1. Sube imagen_v1.jpg → se guarda
2. Sube imagen_v2.jpg → sobrescribe en BD
3. Quiere volver a imagen_v1.jpg → No hay backup!
```

**Riesgo:**
- Sin auditoría de cambios
- Imposible recuperar versiones anteriores
- No hay registro de quién cambió qué

---

#### 13. ⛔ Sin Confirmación de Eliminación Real
**Ubicación:** [resources/views/layouts/public.blade.php](resources/views/layouts/public.blade.php#L555-L575)  
**Severidad:** 🟠 MEDIA

```javascript
// ⚠️ PROBLEMA:
if (!confirm(`¿Estás seguro de que deseas eliminar "${fileName}"?`)) {
    return;  // Solo confirm() del navegador
}
// Luego de confirmar, elimina sin dar feedback real
```

**Riesgo:**
- El confirm() puede ser cancelado sin problema
- Pero la lista de archivos no se "refrescaría" correctamente
- Usuario podría tener dos imágenes del mismo archivo

---

#### 14. ⛔ Sin Soporte Real para Metadatos de Multimedia
**Ubicación:** [CustomContent.php](app/Models/CustomContent.php)  
**Severidad:** 🟡 MEDIA

```php
// ❌ PROBLEMA:
protected $fillable = [
    'contentable_type',
    'contentable_id',
    'key',
    'value',      // Solo texto/path
    'type',       // Solo enum: text, html, image, color, json
];
// Falta campo para metadata JSON
```

**Debería tener:**
```php
protected $fillable = [
    'value',          // Path del archivo
    'metadata',       // JSON con: {url, width, height, size, mime_type, alt_text}
    'alt_text',       // Accesibilidad: atributo alt
    'title',          // Accesibilidad: atributo title
];
```

**Impacto en Accesibilidad:**
```blade
{{-- ❌ ACTUAL (sin atributos de accesibilidad): --}}
<img src="{{ $imagenUrl }}" class="card-img-top editable">

{{-- ✅ DEBERÍA SER: --}}
<img src="{{ $imagenUrl }}" 
     alt="{{ $oferta->custom('imagen_alt', '') }}"
     title="{{ $oferta->custom('imagen_title', '') }}"
     class="card-img-top editable">
```

---

## 🔧 Matriz de Riesgos

| ID | Fallo | Severidad | Impacto | Esfuerzo Fix |
|---|---|---|---|---|
| 1 | Path Traversal | 🔴 | Seguridad del servidor | 1h |
| 2 | Sin validación existencia | 🔴 | URLs rotas, UX degradada | 1.5h |
| 3 | MIME Type Spoofing | 🟠 | RCE potencial | 0.5h |
| 4 | Sin sanitización nombres | 🟠 | Inyección de comandos | 0.5h |
| 5 | Sin cascada de eliminación | 🔴 | Huérfanos en BD | 1h |
| 6 | Sin validar existencia de archivo | 🟠 | URLs 404 | 0.5h |
| 7 | Sin validar tipo contenido | 🟠 | Potencial XSS | 0.5h |
| 8 | N+1 Queries | 🟡 | Rendimiento | 1h |
| 9 | Sin caché | 🟡 | Rendimiento | 0.5h |
| 10 | Lazy loading incompleto | 🟡 | UX pobre | 1h |
| 11 | Sin límites almacenamiento | 🟠 | Disk full | 1h |
| 12 | Sin versionado | 🟡 | Sin recuperación | 2h |
| 13 | Sin confirmación real | 🟠 | Errores de UX | 0.5h |
| 14 | Sin metadatos | 🟡 | Accesibilidad | 1.5h |

**Total:** 12.5 horas de trabajo

---

## 📋 Checklist de Validación Faltante

### Backend Validation Checklist
- [ ] Validar `file_path` con whitelist de prefijos (`media/`)
- [ ] Validar que archivo existe en storage antes de guardar referencia
- [ ] Validar MIME type real (no solo del cliente)
- [ ] Sanitizar nombres de archivo
- [ ] Eliminar referencias en cascada al borrar archivo
- [ ] Validar límites de espacio
- [ ] Generar checksums (MD5/SHA256) de archivos
- [ ] Loguear todas las operaciones de eliminación

### Frontend Validation Checklist
- [ ] Validar existencia de archivo antes de mostrar en imagen
- [ ] Mostrar placeholder si archivo no existe
- [ ] Confirmar eliminación con modal robusto
- [ ] Mostrar feedback visual real de eliminación
- [ ] Implementar skeleton loaders
- [ ] Caché HTTP headers
- [ ] Compresión de imágenes antes de upload

### Database Schema Checklist
- [ ] Agregar columna `metadata` JSON a custom_contents
- [ ] Agregar columna `alt_text` para accesibilidad
- [ ] Agregar índices en `(contentable_type, contentable_id, key)`
- [ ] Agregar foreign key a custom_contents (con ON DELETE CASCADE)

---

## 🛠️ Recomendación Inmediata

**Prioridad CRÍTICA (Hacer primero):**
1. ✅ Path Traversal validation
2. ✅ Validación de existencia de archivo
3. ✅ Eliminación en cascada

**Prioridad ALTA (Siguiente sprint):**
4. MIME Type validation mejorada
5. Sanitización de nombres
6. N+1 query fix
7. Límites de almacenamiento

**Prioridad MEDIA (Futuro):**
8. Versionado
9. Metadatos completos
10. Accesibilidad

---

## 📚 Referencias a Documentación del Proyecto

- [PLAN_INTEGRACION_MULTIMEDIA.md](docs/PLAN_INTEGRACION_MULTIMEDIA.md) - Contiene el análisis inicial del sistema
- [MANUAL_VISTAS_EDITABLES.md](docs/MANUAL_VISTAS_EDITABLES.md) - Manual de implementación de vistas editables

---

**Generado:** 2026-01-27  
**Analista:** AI Assistant  
**Estado:** 🔴 Requiere acción inmediata
