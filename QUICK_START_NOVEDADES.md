# 🚀 QUICK START - MÓDULO NOVEDADES

## Acceso a las Rutas

### Gestión de Tipos de Novedad
```
📋 Listar tipos              GET  /admin/tipos-novedad
➕ Crear tipo                GET  /admin/tipos-novedad/create
💾 Guardar tipo             POST  /admin/tipos-novedad
👁️  Ver tipo                  GET  /admin/tipos-novedad/{id}
✏️  Editar tipo              GET  /admin/tipos-novedad/{id}/edit
🔄 Actualizar tipo          PUT  /admin/tipos-novedad/{id}
🗑️  Eliminar tipo           DELETE /admin/tipos-novedad/{id}
```

### Gestión de Novedades
```
📋 Listar novedades         GET  /admin/novedades
➕ Crear novedad            GET  /admin/novedades/create
💾 Guardar novedad         POST  /admin/novedades
👁️  Ver novedad              GET  /admin/novedades/{id}
✏️  Editar novedad          GET  /admin/novedades/{id}/edit
🔄 Actualizar novedad      PUT  /admin/novedades/{id}
🗑️  Eliminar novedad       DELETE /admin/novedades/{id}
🔀 Cambiar estado          POST  /admin/novedades/{id}/cambiar-estado
📊 Novedades por preinscrito GET  /admin/preinscritos/{id}/novedades
```

---

## Estados Válidos

| Estado | Color | Significado |
|--------|-------|-------------|
| `abierta` | 🔴 Rojo | Nueva novedad, en espera |
| `en_gestion` | 🟡 Amarillo | En proceso de resolución |
| `resuelta` | 🟢 Verde | Problema resolucionado |
| `cancelada` | ⚫ Gris | Cancelada/No aplica |

---

## Permisos Requeridos

```php
// Gestión de Tipos
'novedad.tipos.admin'

// Gestión de Novedades  
'preinscritos.novedades.admin'
```

**Asignado a:** Admin role

---

## Flujos Típicos

### 1️⃣ Crear Tipo de Novedad
```
1. GET /admin/tipos-novedad/create
2. Llenar: nombre, descripción
3. Marcar: activo (checkbox)
4. POST /admin/tipos-novedad
5. ✅ Creado
```

### 2️⃣ Crear Novedad
```
1. GET /admin/novedades/create
2. Seleccionar: preinscrito
3. Seleccionar: tipo de novedad
4. Seleccionar: estado (ej: abierta)
5. Escribir: descripción
6. POST /admin/novedades
7. ✅ Creada + Historial automático
```

### 3️⃣ Cambiar Estado de Novedad
```
1. GET /admin/novedades/{id}
2. Botón: "Cambiar a En Gestión" (o correspondiente)
3. POST /admin/novedades/{id}/cambiar-estado
4. ✅ Estado actualizado
5. ✅ Entrada en historial automáticamente
```

### 4️⃣ Ver Historial Completo
```
1. GET /admin/novedades/{id}
2. Timeline en columna central muestra:
   - Estado anterior → Estado nuevo
   - Usuario que realizó cambio
   - Comentario (si aplica)
   - Fecha y hora exacta
3. Ordenado de más reciente a más antiguo
```

---

## Modelos y Relaciones

### TipoNovedad
```php
$tipo->novedades();              // Todas las novedades de este tipo
$tipo->novedades()->count();     // Contar novedades
```

### NovedadPreinscrito
```php
$novedad->preinscrito;           // Preinscrito asociado
$novedad->tipoNovedad;           // Tipo de novedad
$novedad->createdBy;             // Usuario que creó
$novedad->updatedBy;             // Usuario que actualizó
$novedad->historial;             // Historial de cambios
```

### NovedadHistorial
```php
$historial->novedad;             // Novedad relacionada
$historial->changedBy;           // Usuario que cambió
```

### Preinscrito
```php
$preinscrito->novedades();       // Todas sus novedades
```

---

## Scopes Disponibles

### TipoNovedad
```php
TipoNovedad::activos()                    // Solo activos
TipoNovedad::search('texto')              // Buscar en nombre/descripción
```

### NovedadPreinscrito
```php
NovedadPreinscrito::byEstado('abierta')   // Por estado
NovedadPreinscrito::byTipoNovedad(1)      // Por tipo
NovedadPreinscrito::byPreinscrito(1)      // Por preinscrito
NovedadPreinscrito::abiertas()            // Solo abiertas
```

### NovedadHistorial
```php
NovedadHistorial::byNovedad(1)            // Por novedad (DESC)
```

---

## Método Special: cambiarEstado()

### Sintaxis
```php
$novedad->cambiarEstado(
    $nuevoEstado,     // 'abierta', 'en_gestion', 'resuelta', 'cancelada'
    $comentario,      // Opcional: comentario del cambio
    $userId           // ID del usuario que realiza cambio
);
```

### Ejemplo
```php
$novedad->cambiarEstado(
    'resuelta',
    'Problema resuelto completamente',
    auth()->id()
);
```

### Lo que hace automáticamente
1. ✅ Valida que el estado sea válido
2. ✅ Actualiza `estado` en novedad
3. ✅ Registra `updated_by`
4. ✅ **Crea entrada en historial automáticamente**
5. ✅ Almacena comentario en historial
6. ✅ Guarda timestamp exacto

---

## Búsqueda y Filtrado

### En Tipos
```
🔍 Campo de búsqueda: Busca en nombre y descripción
☑️ Filtro Activo: Muestra solo tipos activos o inactivos
```

### En Novedades
```
🔍 Campo de búsqueda: Busca en nombre preinscrito, apellido, documento
📌 Filtro Tipo: Seleccionar tipo específico
🎯 Filtro Estado: Mostrar por estado (abierta, en_gestion, etc.)
```

---

## Tablas de Datos

### Tipos de Novedad
| Columna | Contenido |
|---------|-----------|
| Nombre | Nombre del tipo |
| Descripción | Descripción breve |
| # Novedades | Cantidad de novedades de este tipo |
| Estado | Activo/Inactivo badge |
| Acciones | Editar, Eliminar |

### Novedades
| Columna | Contenido |
|---------|-----------|
| Preinscrito | Nombre completo + Programa |
| Documento | Número de documento badge |
| Tipo | Tipo de novedad |
| Estado | Badge coloreado (rojo/amarillo/verde/gris) |
| Creador | Usuario que creó |
| Fecha | Fecha de creación |
| Acciones | Ver, Editar, Eliminar |

---

## Formularios

### Crear/Editar Tipo
```
Nombre (requerido)              : Texto corto
Descripción (opcional)          : Textarea larga
Activo (por defecto checked)    : Checkbox
```

### Crear/Editar Novedad
```
Preinscrito (requerido)         : Select searchable
Tipo de Novedad (opcional)      : Dropdown
Estado (requerido)              : Dropdown enum
Descripción (requerido)         : Textarea larga
Comentario Cambio (opcional)    : Textarea (solo en edit)
```

---

## Base de Datos Directa

### Ver Tipos
```sql
SELECT * FROM tipos_novedad WHERE activo = 1;
```

### Ver Novedades por Estado
```sql
SELECT * FROM novedades_preinscritos WHERE estado = 'abierta';
```

### Ver Historial de una Novedad
```sql
SELECT * FROM novedades_historial 
WHERE novedad_id = 1 
ORDER BY created_at DESC;
```

### Contar Cambios por Usuario
```sql
SELECT changed_by, COUNT(*) as cambios
FROM novedades_historial
GROUP BY changed_by;
```

---

## Integración con Preinscrito

### Ver novedades de un preinscrito
```php
$preinscrito = Preinscrito::find(1);
$novedades = $preinscrito->novedades;
```

### O vía ruta
```
GET /admin/preinscritos/1/novedades
```

---

## Errores Comunes

| Error | Solución |
|-------|----------|
| 403 Unauthorized | Verificar permisos en rol del usuario |
| 404 Not Found | Verificar que el ID de novedad existe |
| Validation Error | Completar campos requeridos |
| CRLF Warning | Git warning, no afecta funcionalidad |

---

## Tips de Performance

1. **Eager Load Relations** en controladores para evitar N+1
   ```php
   NovedadPreinscrito::with('preinscrito', 'tipoNovedad', 'historial')
   ```

2. **Usar Scopes** para filtros complejos
   ```php
   NovedadPreinscrito::byEstado('abierta')->byTipoNovedad(1)
   ```

3. **Paginar Resultados** automáticamente cada 20 items
   ```php
   ->paginate(20)
   ```

4. **Índices** ya están optimizados en migraciones

---

## Archivos de Referencia

| Archivo | Propósito |
|---------|-----------|
| `NOVEDADES_MODULO_COMPLETADO.md` | Documentación técnica completa |
| `IMPLEMENTACION_FINALIZADA.md` | Resumen de implementación |
| `app/Models/TipoNovedad.php` | Modelo de tipos |
| `app/Models/NovedadPreinscrito.php` | Modelo de novedades |
| `app/Models/NovedadHistorial.php` | Modelo de auditoría |
| `app/Http/Controllers/Admin/TipoNovedadController.php` | Controlador tipos |
| `app/Http/Controllers/Admin/NovedadPreinscritoController.php` | Controlador novedades |
| `resources/views/admin/novedades/` | Todas las vistas |
| `routes/web.php` | Rutas registradas (líneas 1-34) |
| `database/seeders/DatabaseSeeder.php` | Permisos seeded |

---

## Comando de Rollback (en caso necesario)

```bash
# Revertir migraciones
php artisan migrate:rollback --step=3

# Revertir TODO
php artisan migrate:reset
```

---

## Comando para Verificar Todo

```bash
# Listar rutas
php artisan route:list | grep -i novedad

# Verificar permisos
php artisan tinker
>>> Spatie\Permission\Models\Permission::where('name', 'LIKE', '%novedad%')->get();

# Verificar tablas
>>> Schema::hasTable('tipos_novedad')
```

---

## 📞 Soporte Rápido

- ✅ Implementación 100% completada
- ✅ Listo para producción
- ✅ Código limpio y documentado
- ✅ Errores: Revisar logs en `storage/logs/laravel.log`
- ✅ Problemas de BD: Ejecutar `php artisan migrate:refresh`

---

**Última Actualización:** 2026-02-04  
**Versión:** 1.0  
**Estado:** ✅ OPERATIVO
