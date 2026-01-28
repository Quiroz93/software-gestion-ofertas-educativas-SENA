# 🧪 Plan de Testing - Validación de Fallos Multimedia

**Documento:** Casos de prueba para validar cada fallo identificado  
**Vinculado a:** [FALLOS_MULTIMEDIA_VISTAS_EDITABLES.md](FALLOS_MULTIMEDIA_VISTAS_EDITABLES.md)

---

## 📋 Pruebas Manuales (QA Testing)

### TEST 1: Path Traversal Vulnerability
**Fallo:** #1 - Path Traversal y Validación  
**Severidad:** 🔴 CRÍTICA

#### Pasos:
1. Abrir DevTools → Network tab
2. Click en elemento editable (imagen)
3. Intercept la request POST a `/public/content/store`
4. Modificar payload:
```json
{
  "model": "oferta",
  "model_id": 0,
  "key": "banner_image",
  "value": "../../../../.env",
  "type": "image"
}
```

#### Esperado:
✅ Request rechazada con error 422
```json
{
  "success": false,
  "message": "Error de validación",
  "errors": {
    "value": ["El campo value debe comenzar con media/"]
  }
}
```

#### Actual (antes del fix):
❌ Request aceptada
```json
{
  "success": true,
  "message": "Contenido actualizado correctamente"
}
```

---

### TEST 2: Validación de Existencia de Archivo
**Fallo:** #2 - Sin validación de existencia  
**Severidad:** 🔴 CRÍTICA

#### Pasos:
1. Subir imagen válida → se guarda como `media/ofertas/123.jpg`
2. Abrir DevTools → Storage → Delete archivo manualmente (simular)
3. Recargar página
4. Ver si imagen aparece con 404 o fallback

#### Esperado:
✅ Imagen muestra fallback (imagen default)

#### Actual (antes del fix):
❌ Imagen muestra 404 (URL rota)

---

### TEST 3: MIME Type Spoofing
**Fallo:** #3 - MIME Type Spoofing  
**Severidad:** 🟠 MEDIA

#### Pasos:
1. Renombrar archivo `shell.php` a `shell.php.jpg`
2. Intentar subir a modal de edición
3. Interceptar request en DevTools
4. Ver headers de MIME type

#### Esperado:
✅ Upload rechazado
```json
{
  "success": false,
  "message": "El archivo no es un image válido. MIME real: application/x-php"
}
```

#### Actual (antes del fix):
❌ Upload aceptado con MIME spoofed

---

### TEST 4: Eliminación en Cascada
**Fallo:** #5 - Sin eliminación en cascada  
**Severidad:** 🔴 CRÍTICA

#### Pasos:
1. Crear oferta con imagen → se guarda referencia en BD
2. Eliminar imagen del modal
3. Verificar:
   - [ ] Archivo eliminado de storage
   - [ ] Referencia eliminada de custom_contents tabla

SQL para verificar:
```sql
SELECT * FROM custom_contents 
WHERE value LIKE 'media/ofertas/%' 
AND key = 'imagen';
```

#### Esperado:
✅ 0 registros después de eliminar

#### Actual (antes del fix):
❌ Registros quedan en BD

---

### TEST 5: N+1 Query Problem
**Fallo:** #8 - N+1 Queries  
**Severidad:** 🟡 MEDIA

#### Pasos:
1. Agregar 10 ofertas activas
2. Ir a `/public/ofertas`
3. Abrir DevTools → Network → XHR (si está disponible)
4. O usar `DB::getQueryLog()` en desarrollo:

```php
// En routes/web.php o middleware
if (config('app.debug')) {
    \DB::listen(function ($query) {
        \Log::info("Query: {$query->sql}");
    });
}
```

#### Verificar:
- [ ] Número de queries es 1 + (3×10) = 31 ❌
- [ ] Después del fix: ~2-3 queries ✅

#### Esperado (después del fix):
```
Query 1: SELECT * FROM ofertas WHERE estado = 'activo' (1 query)
Query 2: SELECT * FROM custom_contents WHERE ... IN (...) (1 query)
Total: 2 queries ✅
```

---

## 🔬 Pruebas Automatizadas (Unit/Feature Tests)

### Test Suite para MediaContentController

**Archivo:** `tests/Feature/MediaContentControllerTest.php`

```php
<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\CustomContent;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;

class MediaContentControllerTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;

    protected function setUp(): void
    {
        parent::setUp();

        // Crear usuario con permiso
        $this->user = User::factory()->create();
        $this->user->givePermissionTo('public_content.edit');

        // Mock storage
        Storage::fake('public');
    }

    /**
     * ✅ TEST 1: Path Traversal Prevention
     */
    public function test_path_traversal_attack_rejected()
    {
        $this->actingAs($this->user);

        $response = $this->postJson('/public/content/store', [
            'model' => 'oferta',
            'model_id' => 0,
            'key' => 'banner_image',
            'value' => '../../../../.env',
            'type' => 'image',
            'file_path' => '../../../../.env'
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['file_path']);
    }

    /**
     * ✅ TEST 2: File Existence Validation
     */
    public function test_nonexistent_file_rejected_on_store()
    {
        $this->actingAs($this->user);

        $response = $this->postJson('/public/media/store', [
            'model' => 'oferta',
            'model_id' => 0,
            'key' => 'banner_image',
            'file_path' => 'media/ofertas/nonexistent.jpg',
            'type' => 'image',
            'metadata' => []
        ]);

        $response->assertStatus(422);
        $response->assertJsonFragment([
            'success' => false,
            'message' => 'El archivo no existe en el servidor'
        ]);
    }

    /**
     * ✅ TEST 3: Valid File Upload
     */
    public function test_valid_image_upload_succeeds()
    {
        $this->actingAs($this->user);

        $file = UploadedFile::fake()->image('test.jpg');

        $response = $this->postJson('/public/media/upload', [
            'file' => $file,
            'type' => 'image',
            'category' => 'ofertas'
        ]);

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'success',
            'file_path',
            'url',
            'metadata'
        ]);

        // Verificar archivo en storage
        Storage::disk('public')->assertExists($response->json('file_path'));
    }

    /**
     * ✅ TEST 4: MIME Type Validation
     */
    public function test_php_file_upload_rejected()
    {
        $this->actingAs($this->user);

        // Crear archivo PHP fake
        $file = UploadedFile::fake()->create('shell.php', 1000);

        $response = $this->postJson('/public/media/upload', [
            'file' => $file,
            'type' => 'image',
            'category' => 'ofertas'
        ]);

        // Laravel rechazará por MIME type
        $response->assertStatus(422);
    }

    /**
     * ✅ TEST 5: Cascading Delete
     */
    public function test_file_deletion_cascades_to_references()
    {
        $this->actingAs($this->user);

        // Crear archivo fake
        Storage::fake('public');
        Storage::disk('public')->put('media/ofertas/test.jpg', 'fake image content');

        // Crear múltiples referencias
        CustomContent::create([
            'contentable_type' => 'App\Models\Oferta',
            'contentable_id' => 0,
            'key' => 'banner_image',
            'value' => 'media/ofertas/test.jpg',
            'type' => 'image'
        ]);

        CustomContent::create([
            'contentable_type' => 'App\Models\Oferta',
            'contentable_id' => 1,
            'key' => 'imagen',
            'value' => 'media/ofertas/test.jpg',
            'type' => 'image'
        ]);

        // Verificar referencias existen
        $this->assertEquals(2, CustomContent::where(
            'value', 'media/ofertas/test.jpg'
        )->count());

        // Eliminar archivo
        $response = $this->deleteJson('/public/media/delete', [
            'file_path' => 'media/ofertas/test.jpg'
        ]);

        $response->assertStatus(200);
        $response->assertJsonFragment(['success' => true]);

        // Verificar referencias fueron eliminadas
        $this->assertEquals(0, CustomContent::where(
            'value', 'media/ofertas/test.jpg'
        )->count());

        // Verificar archivo fue eliminado
        Storage::disk('public')->assertMissing('media/ofertas/test.jpg');
    }

    /**
     * ✅ TEST 6: Category Validation
     */
    public function test_invalid_category_rejected()
    {
        $this->actingAs($this->user);

        $file = UploadedFile::fake()->image('test.jpg');

        $response = $this->postJson('/public/media/upload', [
            'file' => $file,
            'type' => 'image',
            'category' => 'malicious-path/../../../'
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['category']);
    }

    /**
     * ✅ TEST 7: Authorization Check
     */
    public function test_unauthorized_user_cannot_upload()
    {
        // Usuario sin permisos
        $user = User::factory()->create();
        $this->actingAs($user);

        $file = UploadedFile::fake()->image('test.jpg');

        $response = $this->postJson('/public/media/upload', [
            'file' => $file,
            'type' => 'image',
            'category' => 'ofertas'
        ]);

        $response->assertStatus(403);
        $response->assertJsonFragment([
            'success' => false,
            'message' => 'No tienes permisos para subir archivos'
        ]);
    }

    /**
     * ✅ TEST 8: File Size Limit
     */
    public function test_file_exceeding_size_limit_rejected()
    {
        $this->actingAs($this->user);

        // Crear archivo > 50MB
        $file = UploadedFile::fake()->create('large.jpg', 51201); // 51.2MB

        $response = $this->postJson('/public/media/upload', [
            'file' => $file,
            'type' => 'image',
            'category' => 'ofertas'
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['file']);
    }

    /**
     * ✅ TEST 9: Valid Store Operation
     */
    public function test_valid_store_operation()
    {
        $this->actingAs($this->user);

        // Primero subir archivo
        $file = UploadedFile::fake()->image('test.jpg');
        $uploadResponse = $this->postJson('/public/media/upload', [
            'file' => $file,
            'type' => 'image',
            'category' => 'ofertas'
        ]);

        $filePath = $uploadResponse->json('file_path');

        // Luego guardar referencia
        $storeResponse = $this->postJson('/public/media/store', [
            'model' => 'oferta',
            'model_id' => 0,
            'key' => 'banner_image',
            'file_path' => $filePath,
            'type' => 'image',
            'metadata' => [
                'width' => 1200,
                'height' => 600
            ]
        ]);

        $storeResponse->assertStatus(200);

        // Verificar se guardó en BD
        $this->assertDatabaseHas('custom_contents', [
            'contentable_type' => 'App\Models\Oferta',
            'contentable_id' => 0,
            'key' => 'banner_image',
            'value' => $filePath,
            'type' => 'image'
        ]);
    }
}
```

### Ejecutar tests:
```bash
php artisan test tests/Feature/MediaContentControllerTest.php
```

---

## 📊 Performance Testing

### TEST: Query Count Validation

**Archivo:** `tests/Feature/QueryCountTest.php`

```php
<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Oferta;
use App\Models\CustomContent;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;

class QueryCountTest extends TestCase
{
    use RefreshDatabase;

    /**
     * ✅ Validar que index no tiene N+1 queries
     */
    public function test_ofertas_index_no_n_plus_one()
    {
        // Crear 10 ofertas con contenido personalizado
        $ofertas = Oferta::factory()->count(10)->create(['estado' => 'activo']);

        foreach ($ofertas as $oferta) {
            CustomContent::create([
                'contentable_type' => 'App\Models\Oferta',
                'contentable_id' => $oferta->id,
                'key' => 'imagen',
                'value' => 'media/ofertas/test.jpg',
                'type' => 'image'
            ]);

            CustomContent::create([
                'contentable_type' => 'App\Models\Oferta',
                'contentable_id' => $oferta->id,
                'key' => 'titulo',
                'value' => 'Test Title',
                'type' => 'text'
            ]);
        }

        // Iniciar query log
        DB::enableQueryLog();

        // Hacer request
        $response = $this->get('/public/ofertas');

        $queryCount = count(DB::getQueryLog());

        // ❌ Antes del fix: ~31 queries (1 + 3×10)
        // ✅ Después del fix: ~2-3 queries
        $this->assertLessThan(5, $queryCount, 
            "Se ejecutaron {$queryCount} queries, esperadas menos de 5. N+1 detectado!");

        $response->assertStatus(200);
    }
}
```

Ejecutar:
```bash
php artisan test tests/Feature/QueryCountTest.php --env=testing
```

---

## 🔐 Security Testing

### TEST: SQL Injection Prevention

```php
public function test_sql_injection_in_key_field()
{
    $this->actingAs($this->user);

    $response = $this->postJson('/public/content/store', [
        'model' => 'oferta',
        'model_id' => "0 OR 1=1",  // SQL injection attempt
        'key' => 'banner_image',
        'value' => 'test',
        'type' => 'text'
    ]);

    // Debería validar que model_id es integer
    $response->assertStatus(422);
}
```

---

## ✅ Checklist de Validación

### Antes del Deployment:

- [ ] Todos los tests pasan
- [ ] Query count < 5 en ofertas index
- [ ] Path traversal rechazado
- [ ] Archivos inexistentes muestran fallback
- [ ] Eliminación de archivos elimina referencias
- [ ] MIME type validation funciona
- [ ] Archivo size limit enforced
- [ ] Authorization checks funcionan
- [ ] N+1 queries resuelto

### Performance Baselines:

| Métrica | Antes | Después |
|---------|-------|---------|
| Queries index ofertas | 31 | 2-3 |
| Load time (10 ofertas) | 250ms | 50ms |
| DB connections | 10+ | 2 |

---

## 🚀 Commands para Testing

```bash
# Ejecutar suite completa
php artisan test

# Solo media tests
php artisan test tests/Feature/MediaContentControllerTest.php

# Con verbose
php artisan test --verbose

# Solo fallos
php artisan test --only-failures

# Coverage
php artisan test --coverage

# Database assertions
php artisan test tests/Feature/QueryCountTest.php --env=testing
```

