# 🧪 Comandos de Validación - Correcciones Multimedia

**Guía rápida para validar que todas las correcciones funcionan correctamente**

---

## 1️⃣ Verificar Base de Datos

### Verificar campos agregados a custom_contents
```bash
php artisan tinker
```

```php
// Dentro de tinker:
Schema::hasColumn('custom_contents', 'metadata')    // Debe retornar: true
Schema::hasColumn('custom_contents', 'alt_text')    // Debe retornar: true
Schema::hasColumn('custom_contents', 'title')       // Debe retornar: true

// Ver estructura completa
DB::select('DESCRIBE custom_contents');

// Verificar índice
DB::select('SHOW INDEX FROM custom_contents WHERE Key_name = "idx_contentable_key"');
```

---

## 2️⃣ Ejecutar Tests de Seguridad

### Tests completos
```bash
# Todos los tests
php artisan test

# Solo tests de multimedia
php artisan test tests/Feature/MediaContentSecurityTest.php

# Con output detallado
php artisan test tests/Feature/MediaContentSecurityTest.php --verbose

# Ver cobertura (si tienes xdebug)
php artisan test --coverage
```

### Resultado esperado:
```
✓ test_path_traversal_attack_is_rejected_in_store
✓ test_path_traversal_with_dots_is_rejected
✓ test_nonexistent_file_is_rejected
✓ test_valid_image_upload_succeeds
✓ test_file_deletion_cascades_to_references
✓ test_invalid_category_is_rejected
✓ test_unauthorized_user_cannot_upload
✓ test_store_with_existing_file_succeeds

Tests: 8 passed
```

---

## 3️⃣ Validar Query Count (N+1)

### Método 1: Laravel Debugbar
```bash
# Instalar Laravel Debugbar (solo desarrollo)
composer require barryvdh/laravel-debugbar --dev
```

Luego visitar: `http://localhost:8000/public/ofertas`  
Ver tab "Queries" → Debe mostrar ~2-3 queries

### Método 2: Logging Manual
Agregar temporalmente en `PublicOfertaController`:

```php
public function index()
{
    \DB::enableQueryLog();
    
    $ofertas = Oferta::where('estado', 'activo')
        ->with([...])
        ->paginate(12);
    
    $queries = \DB::getQueryLog();
    \Log::info('Query Count: ' . count($queries));
    
    return view('public.ofertas.index', compact('ofertas'));
}
```

Ver logs:
```bash
tail -f storage/logs/laravel.log
```

**Esperado:** Query Count: 2-3

---

## 4️⃣ Test Manual de Seguridad

### Test 1: Path Traversal
```bash
# Abrir navegador DevTools → Console
fetch('/public/media/store', {
    method: 'POST',
    headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
    },
    body: JSON.stringify({
        model: 'oferta',
        model_id: 0,
        key: 'test',
        file_path: '../../../../.env',
        type: 'image'
    })
})
.then(res => res.json())
.then(data => console.log(data));
```

**Esperado:**
```json
{
    "message": "The given data was invalid.",
    "errors": {
        "file_path": ["The file path must start with media/."]
    }
}
```

### Test 2: Archivo Inexistente
```javascript
fetch('/public/media/store', {
    method: 'POST',
    headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
    },
    body: JSON.stringify({
        model: 'oferta',
        model_id: 0,
        key: 'test',
        file_path: 'media/ofertas/nonexistent.jpg',
        type: 'image'
    })
})
.then(res => res.json())
.then(data => console.log(data));
```

**Esperado:**
```json
{
    "success": false,
    "message": "El archivo no existe en el servidor"
}
```

---

## 5️⃣ Validar Helpers

### Test en Tinker
```bash
php artisan tinker
```

```php
// Test getCustomContent con archivo inexistente
getCustomContent('oferta', 'imagen_falsa', 'fallback.jpg')
// Debe retornar: 'fallback.jpg'

// Test getMediaUrl
getMediaUrl('oferta', 'banner_image', asset('images/default.jpg'))
// Debe retornar: URL completa o default

// Test getMediaMetadata
getMediaMetadata('oferta', 'banner_image', 'alt_text', 'Default alt')
// Debe retornar: alt_text o 'Default alt'
```

---

## 6️⃣ Validar Cascading Delete

### Crear archivo de prueba
```bash
php artisan tinker
```

```php
// 1. Crear archivo fake en storage
Storage::disk('public')->put('media/ofertas/test_delete.jpg', 'test content');

// 2. Crear múltiples referencias
\App\Models\CustomContent::create([
    'contentable_type' => 'App\Models\Oferta',
    'contentable_id' => 0,
    'key' => 'test1',
    'value' => 'media/ofertas/test_delete.jpg',
    'type' => 'image'
]);

\App\Models\CustomContent::create([
    'contentable_type' => 'App\Models\Oferta',
    'contentable_id' => 1,
    'key' => 'test2',
    'value' => 'media/ofertas/test_delete.jpg',
    'type' => 'image'
]);

// 3. Verificar referencias existen
\App\Models\CustomContent::where('value', 'media/ofertas/test_delete.jpg')->count()
// Debe retornar: 2

exit
```

### Eliminar vía API (con autenticación)
```javascript
// En DevTools Console (estando logueado con permisos)
fetch('/public/media/delete', {
    method: 'DELETE',
    headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
    },
    body: JSON.stringify({
        file_path: 'media/ofertas/test_delete.jpg'
    })
})
.then(res => res.json())
.then(data => console.log(data));
```

**Esperado:**
```json
{
    "success": true,
    "message": "Archivo y referencias eliminados correctamente",
    "data": {
        "references_deleted": 2,
        "file_path": "media/ofertas/test_delete.jpg"
    }
}
```

### Verificar en BD
```bash
php artisan tinker
```

```php
// Debe retornar 0 (referencias eliminadas)
\App\Models\CustomContent::where('value', 'media/ofertas/test_delete.jpg')->count()

// Archivo debe estar eliminado
Storage::disk('public')->exists('media/ofertas/test_delete.jpg')  // false
```

---

## 7️⃣ Verificar Performance en Producción

### Usando Chrome DevTools
1. Abrir `http://localhost:8000/public/ofertas`
2. DevTools → Network tab
3. Recargar página
4. Ver tiempo de carga

**Antes de fix:** ~250-300ms  
**Después de fix:** ~50-100ms  

### Usando Laravel Telescope (si instalado)
```bash
composer require laravel/telescope --dev
php artisan telescope:install
php artisan migrate
```

Visitar: `http://localhost:8000/telescope/queries`  
Filtrar por ruta `/public/ofertas`  
Ver número de queries ejecutadas

---

## 8️⃣ Logs y Monitoreo

### Ver logs en tiempo real
```bash
# Laravel logs
tail -f storage/logs/laravel.log

# Solo errores
tail -f storage/logs/laravel.log | grep ERROR

# Intentos de path traversal (si los hay)
tail -f storage/logs/laravel.log | grep "path traversal"
```

### Verificar permisos
```bash
php artisan tinker
```

```php
// Verificar que el permiso existe
\Spatie\Permission\Models\Permission::where('name', 'public_content.edit')->exists()
// Debe retornar: true

// Ver usuarios con el permiso
\App\Models\User::permission('public_content.edit')->count()
```

---

## 9️⃣ Validar Vista de Ofertas

### Verificar que usa eager loading
```bash
php artisan tinker
```

```php
// Simular el controller
$ofertas = \App\Models\Oferta::where('estado', 'activo')
    ->with(['customContents' => function($query) {
        $query->whereIn('key', ['imagen', 'titulo', 'descripcion', 'modalidad']);
    }])
    ->paginate(12);

// Verificar que customContents está cargado
$ofertas->first()->relationLoaded('customContents')  // Debe ser true
```

### Inspeccionar HTML generado
1. Visitar `http://localhost:8000/public/ofertas`
2. Click derecho → Inspeccionar
3. Buscar elemento `<img>` de oferta
4. Verificar tiene atributo `loading="lazy"`
5. Verificar tiene atributo `alt` con texto descriptivo

---

## 🔟 Rollback (Si es necesario)

### Revertir migración
```bash
php artisan migrate:rollback --step=1
```

### Ver historial de migraciones
```bash
php artisan migrate:status
```

---

## ✅ Checklist de Validación Completa

- [ ] Migración ejecutada sin errores
- [ ] Campos `metadata`, `alt_text`, `title` existen en BD
- [ ] Índice `idx_contentable_key` creado
- [ ] Tests de seguridad pasan (8/8)
- [ ] Path Traversal bloqueado
- [ ] Archivos inexistentes retornan fallback
- [ ] Cascading delete funciona
- [ ] Query count reducido a 2-3
- [ ] Vista usa `loading="lazy"`
- [ ] Vista usa atributos `alt` dinámicos
- [ ] Helpers nuevos funcionan
- [ ] No hay errores en logs
- [ ] Performance mejoró

---

## 📞 Troubleshooting

### Error: "Class Permission not found"
```bash
# Instalar Spatie Permission (si no está)
composer require spatie/laravel-permission
php artisan vendor:publish --provider="Spatie\Permission\PermissionServiceProvider"
php artisan migrate
```

### Error: "SQLSTATE[42S21]: Column already exists"
La migración ya fue ejecutada. Verificar con:
```bash
php artisan migrate:status
```

### Tests fallan por permisos
Verificar que `database/database.sqlite` existe (para testing):
```bash
touch database/database.sqlite
```

O usar MySQL para testing en `.env.testing`.

---

**Documento actualizado:** 28 de Enero, 2026  
**Validado por:** Sistema de correcciones multimedia
