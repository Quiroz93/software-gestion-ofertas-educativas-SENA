# REFERENCIA RÁPIDA: SISTEMA DE NOVEDADES EN PREINSCRITOS

**Última Actualización:** 2 de Febrero de 2026  
**Versión:** 1.0.0

---

## 📍 ARCHIVOS MODIFICADOS

### 1. Base de Datos
- ✅ `database/migrations/2026_02_03_031958_add_novedades_fields_to_preinscritos_table.php` - **NUEVA MIGRACIÓN**

### 2. Modelos
- ✅ `app/Models/Preinscrito.php` - Actualizado con 7 cambios

### 3. Controladores
- ✅ `app/Http/Controllers/Admin/PresritoController.php` - Actualizado con 8 cambios

### 4. Vistas
- ✅ `resources/views/admin/preinscritos/index.blade.php` - Agregados 2 filtros + 1 columna

---

## 🗂️ ESTRUCTURA DE TABLA

```
TABLA: preinscritos

CAMPOS DE NOVEDAD:
  novedades VARCHAR(text)              - Descripción de la novedad
  tipo_novedad ENUM(6 opciones)        - Categoría: cambio_programa, cambio_contacto, error_datos, etc.
  novedad_resuelta BOOLEAN             - true/false (default: false)
  fecha_resolucion TIMESTAMP           - Cuándo se resolvió
  resuelto_por BIGINT FK               - Usuario que resolvió (→ users.id)

ÍNDICES:
  INDEX tipo_novedad                   - Optimiza filtros
  INDEX novedad_resuelta               - Optimiza filtros

TIPOS NOVEDAD PERMITIDOS:
  'cambio_programa'       ← Cambio de programa formativo
  'cambio_contacto'       ← Cambio de email, teléfono, etc.
  'error_datos'           ← Información registrada incorrectamente
  'no_comparecencia'      ← No se presentó a la capacitación
  'cambio_ubicacion'      ← Cambio de municipio/ubicación
  'otra'                  ← Otras situaciones
```

---

## 🔌 MÉTODOS DISPONIBLES EN PREINSCRITO

### Scopes (Filtros)
```php
$query->byEstado('con_novedad')              // Filtrar por estado
$query->byTipoNovedad('cambio_contacto')    // Filtrar por tipo novedad
$query->byNovedadResuelta(false)             // Filtrar por resolución
$query->conNoveadesAbierta()                 // Solo con novedad sin resolver

// Usar en cadena:
Preinscrito::byEstado('con_novedad')
            ->byTipoNovedad('cambio_programa')
            ->byNovedadResuelta(false)
            ->paginate(15);
```

### Helpers (Métodos de Utilidad)
```php
Preinscrito::getTiposNovedades()             // Array de tipos disponibles
$presrito->etiqueta_tipo_novedad             // Texto legible del tipo

// Ej:
$tipos = Preinscrito::getTiposNovedades();
// Retorna: ['cambio_programa' => 'Cambio de Programa', ...]
```

### Relaciones
```php
$presrito->resolvedBy()                      // Usuario que resolvió
$presrito->programa()                        // Programa asociado
$presrito->createdBy()                       // Usuario que creó el registro
$presrito->updatedBy()                       // Usuario que actualiza
```

---

## 🎮 EJEMPLOS DE USO EN CONTROLADOR

### Obtener Novedades Pendientes
```php
public function novedadesPendientes()
{
    $novedades = Preinscrito::conNoveadesAbierta()
        ->with('programa', 'createdBy')
        ->paginate(15);
        
    return view('admin.preinscritos.novedades-pendientes', 
               compact('novedades'));
}
```

### Filtrar con Request
```php
public function index(Request $request)
{
    $query = Preinscrito::with('programa', 'createdBy', 'updatedBy');
    
    if ($request->filled('tipo_novedad')) {
        $query->byTipoNovedad($request->tipo_novedad);
    }
    
    if ($request->filled('novedad_resuelta')) {
        $query->byNovedadResuelta($request->novedad_resuelta === 'pendiente' ? false : true);
    }
    
    $preinscritos = $query->paginate(15);
    $tiposNovedades = Preinscrito::getTiposNovedades();
    
    return view('admin.preinscritos.index', 
               compact('preinscritos', 'tiposNovedades'));
}
```

### Resolver Novedad
```php
public function resolverNovedad(Request $request, Preinscrito $presrito)
{
    $presrito->update([
        'novedad_resuelta' => true,
        'fecha_resolucion' => now(),
        'resuelto_por' => auth()->id(),
    ]);
    
    return redirect()->route('preinscritos.show', $presrito)
                    ->with('success', 'Novedad resuelta exitosamente');
}
```

---

## 🎨 EJEMPLOS EN VISTAS (BLADE)

### Mostrar Tipo de Novedad
```blade
@if($presrito->estado === 'con_novedad')
    <strong>Tipo:</strong> {{ $presrito->etiqueta_tipo_novedad }}
    <p>{{ $presrito->novedades }}</p>
@endif
```

### Mostrar Estado de Resolución
```blade
@if($presrito->novedad_resuelta)
    <span class="badge bg-success">
        <i class="fas fa-check-circle"></i> Resuelta
    </span>
    <small>
        Por: {{ $presrito->resolvedBy->name }} 
        el {{ $presrito->fecha_resolucion->format('d/m/Y') }}
    </small>
@else
    <span class="badge bg-danger">
        <i class="fas fa-exclamation-triangle"></i> Pendiente
    </span>
@endif
```

### Dropdown de Tipos Novedad
```blade
<select name="tipo_novedad">
    <option value="">-- Seleccionar --</option>
    @foreach(Preinscrito::getTiposNovedades() as $valor => $etiqueta)
        <option value="{{ $valor }}" 
                {{ old('tipo_novedad') == $valor ? 'selected' : '' }}>
            {{ $etiqueta }}
        </option>
    @endforeach
</select>
```

---

## 🔍 QUERIES SQL GENERADAS

### Filtrar por Novedad Pendiente
```sql
SELECT * FROM preinscritos
WHERE estado = 'con_novedad'
  AND novedad_resuelta = 0
ORDER BY created_at DESC;

-- ÍNDICES USADOS:
-- - estado (index)
-- - novedad_resuelta (index)
```

### Contar por Tipo
```sql
SELECT tipo_novedad, COUNT(*) as total
FROM preinscritos
WHERE estado = 'con_novedad'
  AND novedad_resuelta = 0
GROUP BY tipo_novedad;
```

### Con Join a Usuarios
```sql
SELECT p.*, u.name as resuelto_por_nombre
FROM preinscritos p
LEFT JOIN users u ON p.resuelto_por = u.id
WHERE p.novedad_resuelta = 1
ORDER BY p.fecha_resolucion DESC;
```

---

## ⚠️ VALIDACIONES IMPORTANTES

### Al Guardar Preinscrito
```php
// En StorePresritoRequest:
'estado' => 'required|in:inscrito,por_inscribir,con_novedad',
'tipo_novedad' => 'nullable|in:cambio_programa,cambio_contacto,error_datos,no_comparecencia,cambio_ubicacion,otra',
'novedades' => 'nullable|string|max:1000',
```

### Al Resolver Novedad
```php
// En UpdatePresritoRequest:
'novedad_resuelta' => 'boolean',
// Se rellenan automáticamente:
// - fecha_resolucion = now()
// - resuelto_por = auth()->id()
```

---

## 📊 ESTADÍSTICAS ÚTILES

### Contar Novedades Totales
```php
$totalNovedades = Preinscrito::where('estado', 'con_novedad')->count();
```

### Novedades Pendientes por Tipo
```php
$pendientesPorTipo = Preinscrito::where('estado', 'con_novedad')
    ->where('novedad_resuelta', false)
    ->groupBy('tipo_novedad')
    ->selectRaw('tipo_novedad, COUNT(*) as total')
    ->get();
```

### Tiempo Promedio de Resolución
```php
$tiempoPromedio = Preinscrito::whereNotNull('fecha_resolucion')
    ->selectRaw('AVG(DATEDIFF(fecha_resolucion, created_at)) as dias')
    ->first();
```

### Preinscritos Resueltos por Usuario
```php
$porUsuario = Preinscrito::whereNotNull('resuelto_por')
    ->with('resolvedBy')
    ->groupBy('resuelto_por')
    ->selectRaw('resuelto_por, COUNT(*) as total')
    ->get();
```

---

## 🐛 TROUBLESHOOTING

### Los filtros no funcionan
```
✓ Verificar que el request lleve los parámetros:
  GET /admin/preinscritos?tipo_novedad=cambio_contacto&novedad_resuelta=pendiente
  
✓ Confirmar que el controlador procesa los filtros:
  if ($request->filled('tipo_novedad')) {
      $query->byTipoNovedad($request->tipo_novedad);
  }
```

### Las novedades no se guardan
```
✓ Verificar que los campos están en $fillable del modelo:
  'novedades', 'tipo_novedad', 'novedad_resuelta', 'fecha_resolucion', 'resuelto_por'
  
✓ Confirmar que la migración se ejecutó:
  php artisan migrate
```

### La columna no aparece en la tabla
```
✓ Verificar que la vista está actualizada:
  <th>Novedad</th>
  
✓ Verificar que se pasa la variable a la vista:
  compact(..., 'tiposNovedades')
  
✓ Limpiar cache si es necesario:
  php artisan view:clear
```

---

## 📚 DOCUMENTACIÓN RELACIONADA

1. **[ANALISIS_FILTROS_NOVEDADES.md](ANALISIS_FILTROS_NOVEDADES.md)**
   - Análisis completo del problema

2. **[IMPLEMENTACION_NOVEDADES_PREINSCRITOS.md](IMPLEMENTACION_NOVEDADES_PREINSCRITOS.md)**
   - Guía detallada de implementación

3. **[VERIFICACION_FINAL_NOVEDADES.md](VERIFICACION_FINAL_NOVEDADES.md)**
   - Verificación técnica completa

4. **[RESUMEN_EJECUTIVO_NOVEDADES.md](RESUMEN_EJECUTIVO_NOVEDADES.md)**
   - Resumen para ejecutivos

---

## 🎯 CASOS DE USO RÁPIDOS

```
Crear preinscrito con novedad:
  → Rellenar campo "estado" = con_novedad
  → Rellenar campo "tipo_novedad" = cambio_contacto (ej.)
  → Escribir descripción en "novedades"
  → Guardar

Filtrar novedades pendientes:
  → Ir a /admin/preinscritos
  → Seleccionar Estado = "Con Novedad"
  → Seleccionar Estado de Novedad = "Pendientes"
  → Clickear "Buscar"

Resolver novedad:
  → Abrir preinscrito con novedad
  → Clickear "Editar"
  → Marcar "Novedad Resuelta" = true
  → Guardar
  → Sistema registra automáticamente fecha y usuario

Ver reportes:
  → Ir a Reportes
  → Ver estadísticas de novedades
  → Filtrar por tipo si es necesario
```

---

## 💾 BACKUP Y RECUPERACIÓN

### Backup de Migración
```bash
# La migración está en:
database/migrations/2026_02_03_031958_add_novedades_fields_to_preinscritos_table.php

# Reversible con:
php artisan migrate:rollback
```

### Restaurar a Versión Anterior
```bash
# Si necesita revertir los cambios:
php artisan migrate:rollback

# Y eliminar el campo en MySQL directamente si es necesario:
ALTER TABLE preinscritos DROP COLUMN novedades;
```

---

**Última actualización:** 2 de Febrero de 2026  
**Versionable:** Sí  
**Producción:** ✅ Listo
