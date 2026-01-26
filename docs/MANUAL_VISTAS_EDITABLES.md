# Manual: Creación de Vistas Públicas 100% Editables

## 📋 Índice
1. [Introducción](#introducción)
2. [Requisitos Previos](#requisitos-previos)
3. [Estructura de Base de Datos](#estructura-de-base-de-datos)
4. [Configuración del Modelo](#configuración-del-modelo)
5. [Creación de Vistas Blade](#creación-de-vistas-blade)
6. [Controlador Público](#controlador-público)
7. [Rutas Públicas](#rutas-públicas)
8. [Permisos y Autorización](#permisos-y-autorización)
9. [Ejemplo Completo](#ejemplo-completo)
10. [Buenas Prácticas](#buenas-prácticas)
11. [Solución de Problemas](#solución-de-problemas)

---

## 📖 Introducción

Este manual describe cómo crear módulos con vistas públicas **100% editables** en SOESoftware. El sistema permite que usuarios autorizados editen contenido directamente desde la vista pública sin necesidad de acceder al panel de administración.

### Características del Sistema
- ✅ Edición en tiempo real desde la vista pública
- ✅ Soporte para contenido genérico (sin registro específico) y contenido asociado a modelos
- ✅ Persistencia en base de datos a través de relaciones polimórficas
- ✅ Validación y autorización integrada
- ✅ Manejo de errores robusto con logging

---

## ⚙️ Requisitos Previos

### 1. Tabla `custom_contents` (Ya existe)
```sql
CREATE TABLE custom_contents (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    contentable_type VARCHAR(255) NOT NULL,
    contentable_id BIGINT NOT NULL,
    `key` VARCHAR(255) NOT NULL,
    `value` TEXT,
    `type` VARCHAR(50),
    created_at TIMESTAMP,
    updated_at TIMESTAMP,
    UNIQUE KEY (contentable_type, contentable_id, `key`)
);
```

### 2. Helper Global `getCustomContent()` (Ya existe)
Ubicación: `app/Helpers/helpers.php`

### 3. Modelo `CustomContent` (Ya existe)
Ubicación: `app/Models/CustomContent.php`

### 4. Controlador `CustomContentController` (Ya existe)
Ubicación: `app/Http/Controllers/Public/CustomContentController.php`

### 5. Ruta de Guardado (Ya existe)
```php
Route::post('/public/content/store', [CustomContentController::class, 'store'])
    ->name('public.content.store')
    ->middleware('auth');
```

### 6. Permiso `public_content.edit` (Debe estar configurado)
Asegúrate de que este permiso exista y esté asignado a roles apropiados.

---

## 🗄️ Estructura de Base de Datos

### Paso 1: Crear Migración del Módulo

```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('mi_modulo', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->text('descripcion')->nullable();
            $table->string('estado')->default('activo');
            // ... otros campos necesarios ...
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mi_modulo');
    }
};
```

**Nota:** No necesitas agregar campos adicionales para el contenido editable. La tabla `custom_contents` maneja eso mediante relaciones polimórficas.

---

## 🎯 Configuración del Modelo

### Paso 2: Crear el Modelo con Relación Polimórfica

```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\CustomContent;

class MiModulo extends Model
{
    protected $table = 'mi_modulo';

    protected $fillable = [
        'nombre',
        'descripcion',
        'estado',
        // ... otros campos ...
    ];

    /**
     * 🔗 Relación polimórfica con CustomContent
     * OBLIGATORIO para contenido editable
     */
    public function customContents()
    {
        return $this->morphMany(CustomContent::class, 'contentable');
    }

    /**
     * 🔧 Helper para obtener contenido personalizado
     * OBLIGATORIO para facilitar acceso a contenido
     * 
     * @param string $key - Clave del contenido
     * @param mixed $default - Valor por defecto
     * @return mixed
     */
    public function custom(string $key, $default = null)
    {
        $content = $this->customContents()->where('key', $key)->first();
        return $content?->value ?? $default;
    }
}
```

---

## 🎨 Creación de Vistas Blade

### Paso 3: Vista Index (Listado)

```blade
@extends('layouts.public')

@section('title', 'Mi Módulo | SOESoftware')

@section('content')

{{-- ===================== --}}
{{-- Banner principal --}}
{{-- ===================== --}}
<section class="bg-light py-5">
    <div class="container">
        
        {{-- 📝 CONTENIDO GENÉRICO (model_id = 0) --}}
        <h1 class="display-4 fw-bold editable"
            data-model="miModulo"
            data-model-id="0"
            data-key="banner_title"
            data-type="text">
            {{ getCustomContent('miModulo', 'banner_title', 'Título por Defecto') }}
        </h1>

        <p class="lead editable"
           data-model="miModulo"
           data-model-id="0"
           data-key="banner_subtitle"
           data-type="text">
            {{ getCustomContent('miModulo', 'banner_subtitle', 'Subtítulo por defecto') }}
        </p>

    </div>
</section>

{{-- ===================== --}}
{{-- Listado de registros --}}
{{-- ===================== --}}
<section class="py-5">
    <div class="container">
        <div class="row g-4">
            
            @foreach($registros as $registro)
                <div class="col-md-6 col-lg-4">
                    <div class="card h-100">
                        <div class="card-body">
                            
                            {{-- 📝 CONTENIDO ESPECÍFICO (model_id = registro->id) --}}
                            <h5 class="card-title editable"
                                data-model="miModulo"
                                data-model-id="{{ $registro->id }}"
                                data-key="titulo_card"
                                data-type="text">
                                {{ $registro->custom('titulo_card', $registro->nombre) }}
                            </h5>

                            <p class="card-text editable"
                               data-model="miModulo"
                               data-model-id="{{ $registro->id }}"
                               data-key="descripcion_card"
                               data-type="text">
                                {{ $registro->custom('descripcion_card', $registro->descripcion) }}
                            </p>

                            <a href="{{ route('public.miModulo.show', $registro->id) }}"
                               class="btn btn-primary">
                                Ver más
                            </a>

                        </div>
                    </div>
                </div>
            @endforeach

        </div>
    </div>
</section>

@endsection
```

### Paso 4: Vista Show (Detalle)

```blade
@extends('layouts.public')

@section('title', $registro->nombre . ' | SOESoftware')

@section('content')

<section class="py-5">
    <div class="container">
        
        {{-- 📝 TÍTULO EDITABLE --}}
        <h1 class="fw-bold mb-4 editable"
            data-model="miModulo"
            data-model-id="{{ $registro->id }}"
            data-key="titulo_principal"
            data-type="text">
            {{ $registro->custom('titulo_principal', $registro->nombre) }}
        </h1>

        {{-- 📝 DESCRIPCIÓN EDITABLE --}}
        <div class="lead mb-4 editable"
             data-model="miModulo"
             data-model-id="{{ $registro->id }}"
             data-key="descripcion_completa"
             data-type="text">
            {{ $registro->custom('descripcion_completa', $registro->descripcion) }}
        </div>

        {{-- 📝 SECCIÓN ADICIONAL EDITABLE --}}
        <h3 class="fw-bold mt-5 editable"
            data-model="miModulo"
            data-model-id="{{ $registro->id }}"
            data-key="seccion_extra_titulo"
            data-type="text">
            {{ $registro->custom('seccion_extra_titulo', 'Información Adicional') }}
        </h3>

        <p class="editable"
           data-model="miModulo"
           data-model-id="{{ $registro->id }}"
           data-key="seccion_extra_contenido"
           data-type="text">
            {{ $registro->custom('seccion_extra_contenido', 'Contenido adicional aquí...') }}
        </p>

    </div>
</section>

@endsection
```

### ⚡ Atributos HTML Obligatorios para Elementos Editables

Cada elemento editable **DEBE** tener estos atributos:

| Atributo | Descripción | Valores | Ejemplo |
|----------|-------------|---------|---------|
| `class="editable"` | Clase CSS que activa la edición | `editable` | `class="editable"` |
| `data-model` | Nombre del modelo (lowercase) | Nombre del modelo sin namespace | `data-model="miModulo"` |
| `data-model-id` | ID del registro (0 para genérico) | `0` (genérico) o `{{ $registro->id }}` | `data-model-id="0"` |
| `data-key` | Clave única del contenido | String único por elemento | `data-key="banner_title"` |
| `data-type` | Tipo de contenido | `text` o `html` | `data-type="text"` |

### 📌 Ejemplo Completo de Elemento Editable

```blade
<h1 class="editable"
    data-model="miModulo"
    data-model-id="0"
    data-key="titulo_seccion"
    data-type="text">
    {{ getCustomContent('miModulo', 'titulo_seccion', 'Valor por Defecto') }}
</h1>
```

---

## 🎮 Controlador Público

### Paso 5: Crear Controlador Público

```php
<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\MiModulo;

class PublicMiModuloController extends Controller
{
    /**
     * Mostrar listado público
     */
    public function index()
    {
        $registros = MiModulo::where('estado', 'activo')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('public.miModulo.index', compact('registros'));
    }

    /**
     * Mostrar detalle público
     */
    public function show($id)
    {
        $registro = MiModulo::findOrFail($id);

        return view('public.miModulo.show', compact('registro'));
    }
}
```

---

## 🛣️ Rutas Públicas

### Paso 6: Registrar Rutas en `routes/web.php`

```php
use App\Http\Controllers\Public\PublicMiModuloController;

// Rutas públicas (sin autenticación)
Route::prefix('public')->name('public.')->group(function () {
    
    Route::get('/mi-modulo', [PublicMiModuloController::class, 'index'])
        ->name('miModulo.index');
    
    Route::get('/mi-modulo/{id}', [PublicMiModuloController::class, 'show'])
        ->name('miModulo.show');
    
});
```

---

## 🔐 Permisos y Autorización

### Paso 7: Verificar Permisos

El sistema utiliza el permiso `public_content.edit` para controlar quién puede editar contenido público.

#### Verificar si el Permiso Existe

```php
// En tinker o seeder
use Spatie\Permission\Models\Permission;

Permission::firstOrCreate(['name' => 'public_content.edit']);
```

#### Asignar Permiso a Rol

```php
use Spatie\Permission\Models\Role;

$role = Role::findByName('admin');
$role->givePermissionTo('public_content.edit');
```

#### Verificar en Vista (Opcional)

```blade
@can('public_content.edit')
    <div class="alert alert-info">
        Modo edición activado - Haz clic en cualquier elemento editable
    </div>
@endcan
```

---

## 📘 Ejemplo Completo

### Caso de Uso: Módulo de Testimonios

#### 1. Migración

```php
Schema::create('testimonios', function (Blueprint $table) {
    $table->id();
    $table->string('autor');
    $table->string('cargo')->nullable();
    $table->string('empresa')->nullable();
    $table->text('testimonio');
    $table->string('foto')->nullable();
    $table->boolean('activo')->default(true);
    $table->timestamps();
});
```

#### 2. Modelo

```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\CustomContent;

class Testimonio extends Model
{
    protected $fillable = [
        'autor',
        'cargo',
        'empresa',
        'testimonio',
        'foto',
        'activo',
    ];

    public function customContents()
    {
        return $this->morphMany(CustomContent::class, 'contentable');
    }

    public function custom(string $key, $default = null)
    {
        $content = $this->customContents()->where('key', $key)->first();
        return $content?->value ?? $default;
    }
}
```

#### 3. Vista `public/testimonios/index.blade.php`

```blade
@extends('layouts.public')

@section('title', 'Testimonios | SOESoftware')

@section('content')

<section class="bg-primary text-white py-5">
    <div class="container text-center">
        
        <h1 class="display-4 fw-bold editable"
            data-model="testimonio"
            data-model-id="0"
            data-key="page_title"
            data-type="text">
            {{ getCustomContent('testimonio', 'page_title', 'Lo Que Dicen Nuestros Estudiantes') }}
        </h1>

        <p class="lead editable"
           data-model="testimonio"
           data-model-id="0"
           data-key="page_subtitle"
           data-type="text">
            {{ getCustomContent('testimonio', 'page_subtitle', 'Conoce las experiencias de quienes ya se formaron con nosotros') }}
        </p>

    </div>
</section>

<section class="py-5">
    <div class="container">
        <div class="row g-4">
            
            @foreach($testimonios as $testimonio)
                <div class="col-md-6 col-lg-4">
                    <div class="card h-100 shadow-sm">
                        
                        @if($testimonio->foto)
                            <img src="{{ asset('storage/' . $testimonio->foto) }}"
                                 class="card-img-top"
                                 alt="{{ $testimonio->autor }}">
                        @endif

                        <div class="card-body">
                            
                            <blockquote class="blockquote mb-3 editable"
                                        data-model="testimonio"
                                        data-model-id="{{ $testimonio->id }}"
                                        data-key="testimonio_texto"
                                        data-type="text">
                                "{{ $testimonio->custom('testimonio_texto', $testimonio->testimonio) }}"
                            </blockquote>

                            <footer class="blockquote-footer">
                                <cite class="editable"
                                      data-model="testimonio"
                                      data-model-id="{{ $testimonio->id }}"
                                      data-key="autor_nombre"
                                      data-type="text">
                                    {{ $testimonio->custom('autor_nombre', $testimonio->autor) }}
                                </cite>
                                <br>
                                <small class="editable"
                                       data-model="testimonio"
                                       data-model-id="{{ $testimonio->id }}"
                                       data-key="autor_cargo"
                                       data-type="text">
                                    {{ $testimonio->custom('autor_cargo', $testimonio->cargo) }}
                                </small>
                            </footer>

                        </div>
                    </div>
                </div>
            @endforeach

        </div>
    </div>
</section>

@endsection
```

#### 4. Controlador

```php
<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Testimonio;

class PublicTestimonioController extends Controller
{
    public function index()
    {
        $testimonios = Testimonio::where('activo', true)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('public.testimonios.index', compact('testimonios'));
    }
}
```

#### 5. Ruta

```php
Route::get('/testimonios', [PublicTestimonioController::class, 'index'])
    ->name('public.testimonios.index');
```

---

## ✅ Buenas Prácticas

### 1. Nomenclatura de Keys

Usa una nomenclatura descriptiva y consistente:

```blade
✅ BIEN
data-key="banner_title"
data-key="section_hero_subtitle"
data-key="card_descripcion"

❌ MAL
data-key="titulo"
data-key="txt1"
data-key="contenido"
```

### 2. Valores por Defecto Significativos

Siempre proporciona valores por defecto descriptivos:

```blade
✅ BIEN
{{ getCustomContent('testimonio', 'page_title', 'Lo Que Dicen Nuestros Estudiantes') }}

❌ MAL
{{ getCustomContent('testimonio', 'page_title', 'Título') }}
{{ getCustomContent('testimonio', 'page_title', '') }}
```

### 3. Contenido Genérico vs Específico

- **Genérico (`model_id="0"`)**: Títulos de página, banners, secciones compartidas
- **Específico (`model_id="{{ $registro->id }}"`)**: Contenido único de cada registro

```blade
{{-- Genérico: título de página --}}
<h1 data-model-id="0" data-key="page_title">...</h1>

{{-- Específico: título de un registro --}}
<h1 data-model-id="{{ $oferta->id }}" data-key="titulo_oferta">...</h1>
```

### 4. Tipos de Contenido

Actualmente soportados:
- `text`: Texto plano (recomendado para la mayoría de casos)
- `html`: HTML rico (futuro soporte)

```blade
data-type="text"   {{-- Recomendado --}}
data-type="html"   {{-- Para contenido HTML futuro --}}
```

### 5. Organización de Archivos

```
app/
├── Models/
│   └── MiModulo.php
├── Http/
│   └── Controllers/
│       └── Public/
│           └── PublicMiModuloController.php
resources/
└── views/
    └── public/
        └── miModulo/
            ├── index.blade.php
            └── show.blade.php
```

---

## 🐛 Solución de Problemas

### Problema 1: "Call to undefined function getCustomContent()"

**Causa:** El helper no está cargado correctamente.

**Solución:**
```bash
composer dumpautoload
php artisan optimize:clear
```

### Problema 2: "The selected type is invalid"

**Causa:** Falta el atributo `data-type` o tiene un valor inválido.

**Solución:**
```blade
{{-- Asegúrate de incluir data-type --}}
<h1 class="editable"
    data-model="miModulo"
    data-model-id="0"
    data-key="titulo"
    data-type="text">  {{-- ← Obligatorio --}}
    ...
</h1>
```

### Problema 3: Contenido no persiste después de recargar

**Causa:** La vista no está usando `getCustomContent()`.

**Solución:**
```blade
{{-- ❌ MAL - texto estático --}}
<h1 class="editable" ...>
    Título Fijo
</h1>

{{-- ✅ BIEN - contenido dinámico --}}
<h1 class="editable" ...>
    {{ getCustomContent('miModulo', 'titulo', 'Título Fijo') }}
</h1>
```

### Problema 4: "El registro solicitado no existe"

**Causa:** Intentando usar `model_id` específico en contenido genérico.

**Solución:**
```blade
{{-- Para contenido de página (no asociado a registro) --}}
<h1 data-model-id="0">...</h1>

{{-- Para contenido de registro específico --}}
<h1 data-model-id="{{ $registro->id }}">...</h1>
```

### Problema 5: No aparece el icono de edición al hover

**Causa:** Usuario sin permiso `public_content.edit` o no autenticado.

**Solución:**
```php
// Asignar permiso al usuario
$user->givePermissionTo('public_content.edit');
```

### Problema 6: Error "SQLSTATE[42S22]: Column not found: contentable_type"

**Causa:** El modelo `CustomContent` no tiene los campos en `$fillable`.

**Solución:** Verificar que `app/Models/CustomContent.php` contenga:
```php
protected $fillable = [
    'contentable_type',
    'contentable_id',
    'key',
    'value',
    'type',
];
```

---

## 📊 Checklist de Implementación

Antes de considerar completo tu módulo editable, verifica:

- [ ] Modelo tiene relación `customContents()`
- [ ] Modelo tiene método `custom()`
- [ ] Vista usa clase `editable` en elementos
- [ ] Todos los elementos tienen `data-model`
- [ ] Todos los elementos tienen `data-model-id`
- [ ] Todos los elementos tienen `data-key`
- [ ] Todos los elementos tienen `data-type="text"`
- [ ] Se usa `getCustomContent()` en contenido editable
- [ ] Valores por defecto son descriptivos
- [ ] Controlador público creado
- [ ] Rutas públicas registradas
- [ ] Permiso `public_content.edit` verificado
- [ ] Probado guardado y persistencia
- [ ] Probado contenido genérico (`model_id=0`)
- [ ] Probado contenido específico (`model_id=registro->id`)

---

## 📚 Referencias

- **Layout público**: `resources/views/layouts/public.blade.php`
- **Helper**: `app/Helpers/helpers.php`
- **Modelo CustomContent**: `app/Models/CustomContent.php`
- **Controlador**: `app/Http/Controllers/Public/CustomContentController.php`
- **Ejemplo práctico**: `resources/views/public/ofertas/index.blade.php`

---

## 🎓 Conclusión

Siguiendo esta guía, cualquier módulo nuevo puede tener vistas públicas 100% editables con:
- ✨ Edición inline desde la vista pública
- 💾 Persistencia automática en base de datos
- 🔒 Control de permisos robusto
- 🎯 Contenido genérico y específico
- 🐛 Manejo de errores completo

¿Dudas? Revisa los ejemplos en `resources/views/public/ofertas/` para ver implementaciones reales.
