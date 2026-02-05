# ANÁLISIS: FILTROS PARA PREINSCRITOS CON NOVEDAD

**Fecha:** 2 de Febrero de 2026  
**Estado:** ⚠️ ANÁLISIS CRÍTICO REQUERIDO

---

## 📋 HALLAZGOS PRINCIPALES

### ✅ FILTRO EXISTE - PERO CAMPO NO EXISTE

#### 1. Sistema de Filtros (FUNCIONA)
- **Archivo:** `app/Http/Controllers/Admin/PresritoController.php` (Línea 35-48)
- **Método:** `index(Request $request)`
- **Filtros Implementados:**
  - ✅ `programa_id` → `byPrograma()`
  - ✅ `estado` → `byEstado()`
  - ✅ `tipo_documento` → `byTipoDocumento()`
  - ✅ `numero_documento` → `byNumeroDocumento()`
  - ✅ `nombre` → `byNombre()`

#### 2. Estado "con_novedad" DEFINIDO
- **Archivo:** `app/Models/Preinscrito.php` (Línea 146-149)
- **Método:** `getEstados()`
- **Estados Disponibles:**
  ```php
  'inscrito' => 'Inscrito',
  'por_inscribir' => 'Por Inscribir',
  'con_novedad' => 'Con Novedad',  // ← EXISTE
  ```

#### 3. Vista FILTROS IMPLEMENTADOS
- **Archivo:** `resources/views/admin/preinscritos/index.blade.php` (Línea 57-87)
- **Select de Estado:** Muestra los 3 estados incluyendo "Con Novedad"
- **HTML Generated:**
  ```html
  <option value="con_novedad">Con Novedad</option>
  ```

#### 4. Reporte MENCIONA "con_novedad"
- **Archivo:** `app/Http/Controllers/Admin/PresritoController.php` (Línea 225-231)
- **Método:** `reportes(Request $request)`
- **Estadísticas Generadas:**
  ```php
  'con_novedad' => $preinscritos->where('estado', 'con_novedad')->count(),
  ```

---

## ❌ PROBLEMA CRÍTICO

### Campo 'novedades' NO EXISTE en la tabla `preinscritos`

**Esquema Actual de la Tabla:**
```
TABLA: preinscritos
├── id (bigint)
├── nombres (varchar)
├── apellidos (varchar)
├── tipo_documento (enum: cc, ti, ce, ppt, pa, pep, nit)
├── numero_documento (varchar) - UNIQUE
├── celular_principal (varchar)
├── celular_alternativo (varchar)
├── correo_principal (varchar)
├── correo_alternativo (varchar)
├── programa_id (bigint) - FK
├── estado (enum) ← ⚠️ SOLO 3 VALORES
│   ├ 'inscrito'
│   ├ 'por_inscribir'
│   └ 'con_novedad'
├── comentarios (text) ← Para notas generales
├── created_by (bigint) - FK
├── updated_by (bigint) - FK
├── created_at (timestamp)
├── updated_at (timestamp)
└── deleted_at (timestamp)
```

**Campos Faltantes:**
- ❌ `novedades` - Campo específico para registrar detalles de novedades
- ❌ `tipo_novedad` - Categoría de la novedad (cambio programa, cambio contacto, etc.)
- ❌ `fecha_novedad` - Cuándo se reportó
- ❌ `resuelto` - Si la novedad fue resuelta
- ❌ `fecha_resolucion` - Cuándo se resolvió

---

## 🔍 ANÁLISIS DE FLUJO ACTUAL

### Cómo Funciona HOY (SIN el campo específico):

```
┌─────────────────┐
│ Vista Index     │ Filtro: estado = 'con_novedad'
└────────┬────────┘
         │
         ▼
┌─────────────────┐
│ Controlador     │ $query->byEstado('con_novedad')
│ PresritoController
└────────┬────────┘
         │
         ▼
┌─────────────────┐
│ Modelo Scope    │ where('estado', 'con_novedad')
│ byEstado()      │
└────────┬────────┘
         │
         ▼
┌─────────────────┐
│ Base de Datos   │ Filtra registros con estado = 'con_novedad'
│ SELECT * FROM   │ Muestra: nombres, apellidos, programa, etc.
│ preinscritos    │ ❌ PERO NO MUESTRA DETALLES DE LA NOVEDAD
└─────────────────┘
```

**Problema:** El estado `'con_novedad'` solo marca que EXISTE novedad, pero no guarda QUÉ es la novedad.

---

## 📊 RECOMENDACIONES

### Opción 1: Campo `novedades` simple (RECOMENDADO)
**Migración:**
```php
Schema::table('preinscritos', function (Blueprint $table) {
    $table->text('novedades')->nullable()->after('comentarios');
    // Descripción libre de la novedad
});
```

**Ventajas:**
- ✅ Fácil implementación
- ✅ Flexible (describe cualquier tipo de novedad)
- ✅ Compatible con sistema actual

**Limitaciones:**
- No hay categorización automática
- Búsqueda por tipo de novedad requiere SQL complejo

---

### Opción 2: Campos completos (ÓPTIMO)
**Migración:**
```php
Schema::table('preinscritos', function (Blueprint $table) {
    $table->text('novedades')->nullable()->after('comentarios');
    $table->enum('tipo_novedad', [
        'cambio_programa',
        'cambio_contacto',
        'error_datos',
        'no_comparecencia',
        'cambio_ubicacion',
        'otra'
    ])->nullable()->after('novedades');
    $table->boolean('novedad_resuelta')->default(false)->after('tipo_novedad');
    $table->timestamp('fecha_resolucion')->nullable()->after('novedad_resuelta');
    $table->unsignedBigInteger('resuelto_por')->nullable()->after('fecha_resolucion');
    
    $table->foreign('resuelto_por')->references('id')->on('users')
        ->onDelete('set null');
});
```

**Ventajas:**
- ✅ Estructura profesional
- ✅ Trazabilidad completa
- ✅ Reportes detallados
- ✅ Seguimiento de resoluciones

---

### Opción 3: Tabla Separada (ESCALABLE)
**Crear tabla `preinscrito_novedades`:**
```php
Schema::create('preinscrito_novedades', function (Blueprint $table) {
    $table->id();
    $table->unsignedBigInteger('preinscrito_id');
    $table->enum('tipo', [
        'cambio_programa',
        'cambio_contacto',
        'error_datos',
        'no_comparecencia',
        'cambio_ubicacion',
        'otra'
    ]);
    $table->text('descripcion');
    $table->enum('estado', ['abierta', 'en_proceso', 'resuelta'])->default('abierta');
    $table->unsignedBigInteger('reportada_por');
    $table->unsignedBigInteger('resuelta_por')->nullable();
    $table->text('resolucion')->nullable();
    $table->timestamp('fecha_resolucion')->nullable();
    $table->timestamps();
    
    $table->foreign('preinscrito_id')->references('id')
        ->on('preinscritos')->onDelete('cascade');
    $table->foreign('reportada_por')->references('id')
        ->on('users')->onDelete('set null');
    $table->foreign('resuelta_por')->references('id')
        ->on('users')->onDelete('set null');
});
```

**Ventajas:**
- ✅ Historial completo de novedades
- ✅ Múltiples novedades por preinscrito
- ✅ Seguimiento detallado
- ✅ Escalable a futuro

**Limitaciones:**
- Requiere cambios en controlador y vistas
- Más complejo inicialmente

---

## 🛠️ RECOMENDACIÓN FINAL

**Opción 2 (Campos completos)** es la mejor porque:
1. ✅ Mantiene la lógica actual (`estado = 'con_novedad'`)
2. ✅ Agrega información específica de la novedad
3. ✅ Permite seguimiento de resoluciones
4. ✅ No requiere restructuración mayor
5. ✅ Escalable a futuro (puede evolucionarse a tabla separada)

---

## 📝 PRÓXIMOS PASOS

1. **Crear Migración:** Opción 2 recomendada
2. **Actualizar Modelo:** Agregar campos a `$fillable` y validaciones
3. **Actualizar Controlador:** Procesar nuevos campos
4. **Actualizar Vistas:** 
   - Show: Mostrar detalles de novedad
   - Edit: Editar novedades y tipo
   - Index: Indicar visualmente preinscritos con novedad
5. **Crear Seeders:** Datos de prueba

---

## 📌 RESUMEN EJECUTIVO

| Aspecto | Estado | Detalles |
|---------|--------|----------|
| Filtro existe | ✅ SÍ | Implementado en controlador y vista |
| Campo 'novedades' | ❌ NO | No existe en tabla preinscritos |
| Estado 'con_novedad' | ✅ SÍ | Definido como valor de estado enum |
| Funcionalidad actual | ⚠️ PARCIAL | Marca novedad pero no detalla qué es |
| Recomendación | ⭐ Opción 2 | Campos completos con seguimiento |

**Conclusión:** El sistema filtra por "con_novedad" correctamente, pero necesita campo dedicado para almacenar DETALLES de la novedad.
