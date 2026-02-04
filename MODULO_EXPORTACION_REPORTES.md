# Módulo de Exportación de Reportes de Preinscritos

## Descripción General

Módulo completo para generar archivos Excel con reportes de preinscritos. Permite filtrar datos y descargar reportes institucionalizados con formato SENA.

## Características

✅ Exportación a Excel con formato institucional  
✅ Filtros dinámicos (programa, estado, tipo documento, búsqueda)  
✅ Header del reporte con información de ficha y programa  
✅ Auditoría de exportaciones en base de datos  
✅ Historial de descargas por usuario  
✅ Validación de permisos (preinscritos.export)  
✅ Integración en sidebar admin (desktop y mobile)  

## Estructura del Proyecto

### Base de Datos

**Tabla: exportaciones**
```sql
id
user_id → users (FK)
tipo (preinscritos)
filtros_aplicados (JSON)
total_registros
nombre_archivo
ruta_archivo
created_at
updated_at
```

### Clases Principales

#### 1. **Exportacion (Modelo)**
- Ubicación: `app/Models/Exportacion.php`
- Relaciones: `usuario()` → User
- Scopes: `preinscritos()`, `recientes($dias)`

#### 2. **ReportePresritoService (Servicio)**
- Ubicación: `app/Services/ReportePresritoService.php`
- Responsabilidades:
  - Obtener preinscritos con filtros
  - Detectar si es una sola ficha
  - Preparar header del reporte
  - Serializar filtros para auditoría

#### 3. **PresritosExport (Export Class)**
- Ubicación: `app/Exports/PresritosExport.php`
- Hereda de: `FromView`, `WithStyles`, `ShouldAutoSize`
- Genera Excel con estilos SENA

#### 4. **ExportController (Controlador)**
- Ubicación: `app/Http/Controllers/Admin/ExportController.php`
- Métodos:
  - `reportes()` - Mostrar vista de reportes
  - `exportar()` - Generar y descargar Excel
  - `historial()` - Listar exportaciones del usuario

### Vistas

```
resources/views/
├── admin/preinscritos/
│   ├── reportes.blade.php
│   └── historial-exportaciones.blade.php
└── exports/
    └── preinscritos.blade.php
```

### Rutas

```php
GET  /admin/preinscritos/reportes              → ExportController@reportes
POST /admin/preinscritos/exportar              → ExportController@exportar
GET  /admin/preinscritos/historial-exportaciones → ExportController@historial
```

## Lógica de Filtros

El Excel contiene **exactamente** los registros que coinciden con los filtros:

- **Sin filtros** → Todos los preinscritos
- **programa_id** → Solo de ese programa
- **estado** → Solo con ese estado
- **tipo_documento** → Solo con ese tipo
- **search** → Nombres, apellidos, documento, correo

## Formato del Reporte

### Encabezado
```
┌─────────────────────────────────────┐
│  REPORTE DE INSCRIPCIONES           │
│                                     │
│  Código Ficha: [XXXX / N/A]        │
│  Programa: [Nombre / N/A]          │
│  Total de Registros: [N]           │
│  Fecha: [dd/mm/yyyy HH:mm:ss]      │
└─────────────────────────────────────┘
```

**Regla de Ficha:**
- Si todos los registros pertenecen a **1 sola ficha** → Mostrar código y programa
- Si hay **múltiples fichas** → Mostrar "N/A"

### Columnas de Datos
1. **Identificación** - Número de documento
2. **Nombre** - Nombres y apellidos completos
3. **Estado** - Estado del preinscrito (etiqueta legible)

## Permisos

### Permiso Requerido
`preinscritos.export`

### Roles que lo Tienen (por defecto)
- Administrador
- Cualquier rol que tenga el permiso asignado

## Auditoría

Cada exportación se registra en la tabla `exportaciones`:

```php
Exportacion::create([
    'user_id' => auth()->id(),
    'tipo' => 'preinscritos',
    'filtros_aplicados' => [...],  // JSON
    'total_registros' => $total,
    'nombre_archivo' => 'reporte_preinscritos_YYYYMMDD_HHMMSS.xlsx',
    'ruta_archivo' => 'exports/...',
]);
```

## Nombre del Archivo

Formato: `reporte_preinscritos_YYYYMMDD_HHMMSS.xlsx`

Ejemplo: `reporte_preinscritos_20260203_154530.xlsx`

## Integración en Sidebar

### Desktop (Sidebar)
```blade
@can('preinscritos.export')
<li class="sidebar-nav-item">
    <a href="{{ route('preinscritos.reportes') }}" class="sidebar-nav-link">
        <i class="bi bi-file-earmark-spreadsheet"></i>
        <span>Reportes</span>
    </a>
</li>
@endcan
```

### Mobile (Offcanvas)
```blade
@can('preinscritos.export')
<a class="nav-link" href="{{ route('preinscritos.reportes') }}">
    <i class="bi bi-file-earmark-spreadsheet me-2"></i>Reportes
</a>
@endcan
```

## Flujo de Uso

1. Usuario hace clic en botón "Reportes" en index de preinscritos
2. Sistema redirige a `/admin/preinscritos/reportes`
3. Usuario (opcional) aplica filtros
4. Usuario hace clic en "Descargar Excel"
5. Sistema:
   - Valida permisos
   - Filtra preinscritos
   - Construye reporte
   - Registra exportación en BD
   - Retorna descarga de archivo
6. Usuario puede ver historial de exportaciones

## Instalación / Migración

```bash
# 1. Ejecutar migración
php artisan migrate

# 2. Crear permiso
php artisan tinker
>>> Spatie\Permission\Models\Permission::firstOrCreate(['name' => 'preinscritos.export']);
```

## Archivos Modificados

```
✅ app/Models/Exportacion.php (NUEVO)
✅ app/Services/ReportePresritoService.php (NUEVO)
✅ app/Exports/PresritosExport.php (NUEVO)
✅ app/Http/Controllers/Admin/ExportController.php (NUEVO)
✅ resources/views/admin/preinscritos/reportes.blade.php (ACTUALIZADO)
✅ resources/views/admin/preinscritos/historial-exportaciones.blade.php (NUEVO)
✅ resources/views/exports/preinscritos.blade.php (NUEVO)
✅ resources/views/partials/sidebar.blade.php (ACTUALIZADO)
✅ routes/web.php (ACTUALIZADO)
✅ database/migrations/2026_02_03_000005_create_exportaciones_table.php (NUEVO)
✅ database/seeders/DatabaseSeeder.php (ACTUALIZADO)
```

## Variables de Entorno

No requiere variables de entorno especiales. Usa la configuración estándar de Laravel Excel.

## Validación

- ✅ Permiso requerido antes de acceder
- ✅ Validación de filtros
- ✅ Validación de registros encontrados
- ✅ Manejo de excepciones en generación
- ✅ Logs automáticos en BD

## Testing

Para probar manualmente:

```bash
# Entrar a tinker
php artisan tinker

# Verificar tabla
>>> Schema::hasTable('exportaciones')
=> true

# Crear exportación manualmente
>>> Exportacion::create([...])

# Ver exportaciones del usuario
>>> Exportacion::where('user_id', 1)->get()
```

## Próximas Mejoras (Opcionales)

- [ ] Descargar archivos guardados desde historial
- [ ] Reportes por rango de fechas
- [ ] Gráficas de estadísticas
- [ ] Exportación a PDF
- [ ] Envío por email
- [ ] Programación de reportes automáticos

---

**Versión:** 1.0  
**Fecha:** 03/02/2026  
**Autor:** Sistema SOE-SENA  
**Estado:** ✅ Producción
