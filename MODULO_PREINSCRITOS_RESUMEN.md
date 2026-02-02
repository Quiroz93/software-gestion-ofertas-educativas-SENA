# Módulo CRUD Completo - Gestión de Aprendices Preinscritos ✅

## Resumen de Implementación

Se ha creado un **módulo CRUD completo y funcional** para la gestión de Aprendices Preinscritos (Preinscritos), totalmente integrado al sistema existente de SoeSoftware2 y accesible desde el sidebar administrativo.

---

## 📋 Archivos Creados

### 1. **Migración** `2026_02_02_000000_create_preinscritos_table.php`
Estructura de la tabla `preinscritos` con:
- Datos personales: nombres, apellidos
- Documento: tipo_documento, numero_documento (único e indexado)
- Contacto: celular_principal, celular_alternativo, correo_principal, correo_alternativo
- Relación: programa_id (FK hacia programas.id)
- Estado: inscrito, por_inscribir, con_novedad
- Auditoría: created_by, updated_by, timestamps, softDeletes
- Índices: programa_id, estado, tipo_documento, numero_documento

**Ejecutada exitosamente ✅**

### 2. **Modelo** `app/Models/Preinscrito.php`
Características:
- SoftDeletes para eliminación temporal
- Relaciones Eloquent:
  - `programa()`: BelongsTo Programa
  - `createdBy()`: BelongsTo User
  - `updatedBy()`: BelongsTo User
- Propiedades calculadas (Accessors):
  - `nombre_completo`: Retorna "nombres apellidos"
  - `nombre_programa`: Retorna el nombre del programa
  - `numero_ficha`: Retorna el número de ficha del programa
  - `etiqueta_estado`: Etiqueta legible del estado
  - `etiqueta_tipo_documento`: Etiqueta legible del tipo de documento
- Métodos estáticos:
  - `documentoExiste()`: Valida documentos duplicados
  - `getEstados()`: Lista de estados disponibles
  - `getTiposDocumento()`: Lista de tipos de documento
- Scopes para filtrado:
  - `byPrograma()`, `byEstado()`, `byTipoDocumento()`, `byNumeroDocumento()`, `byNombre()`

### 3. **FormRequests** 
- `app/Http/Requests/StorePresritoRequest.php`: Validación para crear
- `app/Http/Requests/UpdatePresritoRequest.php`: Validación para actualizar

Validaciones incluidas:
- nombres, apellidos: requeridos, string, máx 255
- tipo_documento: requerido, validación de valores permitidos
- numero_documento: requerido, único (excepto en updates)
- celular_principal: requerido
- correo_principal: requerido, email válido
- programa_id: requerido, existe en tabla programas
- estado: requerido, validación de valores permitidos
- comentarios: opcional, máx 1000 caracteres

### 4. **Controlador** `app/Http/Controllers/Admin/PresritoController.php`
Métodos implementados:
- **index()**: Listado con filtros (programa, estado, tipo_documento, numero_documento, nombre)
- **create()**: Formulario para crear
- **store()**: Guardar nuevo preinscrito con transacciones DB
- **show()**: Ver detalles completos
- **edit()**: Formulario para editar
- **update()**: Actualizar datos con validación de documentos duplicados
- **destroy()**: Eliminar (Soft Delete) con SweetAlert2
- **reportes()**: Reporte con estadísticas por estado y programa
- **restore()**: Restaurar registros eliminados

Características de seguridad:
- Gate::authorize() en cada método
- Transacciones DB para integridad
- Validación de documentos duplicados

### 5. **Policy** `app/Policies/PresritoPolicy.php`
Control de acceso granular:
- viewAny(), view(), create(), update(), delete()
- restore(), forceDelete()

### 6. **Seeder** `database/seeders/PresritoSeeder.php`
Crea 5 preinscritos de ejemplo con:
- Diferentes tipos de documento
- Todos los estados (inscrito, por_inscribir, con_novedad)
- Datos válidos para pruebas

**Ejecutado exitosamente ✅**

### 7. **Vistas Blade** (5 templates)

#### `resources/views/admin/preinscritos/index.blade.php`
- Tabla responsive con listado de preinscritos
- Filtros: programa, estado, tipo_documento, numero_documento
- Botones: crear, ver, editar, eliminar
- SweetAlert2 para confirmación de eliminación
- Paginación (15 por página)
- Alertas de éxito/error

#### `resources/views/admin/preinscritos/create.blade.php`
- Formulario completo para crear preinscrito
- Secciones organizadas: datos personales, documento, contacto, formación, adicional
- Validación en cliente
- Mensajes de error detallados
- Bootstrap5 styling

#### `resources/views/admin/preinscritos/edit.blade.php`
- Igual al create pero con datos precargados
- Información de auditoría (created_at, updated_at, usuarios)
- Validación de documento duplicado en updates

#### `resources/views/admin/preinscritos/show.blade.php`
- Vista detallada con cards organizadas por sección
- Información personal, documento, contacto, formación
- Enlaces directos a email y teléfono
- Historial de auditoría
- Botones de editar y eliminar
- Badges de estado con colores

#### `resources/views/admin/preinscritos/reportes.blade.php`
- Estadísticas en cards (Total, Inscrito, Por Inscribir, Con Novedad)
- Tabla de reporte con datos filtrados
- Resumen por programa y estado
- Botón de impresión (prepara datos para futura exportación Excel)
- Filtros para generar reportes personalizados

### 8. **Rutas** `routes/web.php`
Se agregaron las siguientes rutas protegidas:
```php
GET     /admin/preinscritos                    → preinscritos.index
GET     /admin/preinscritos/create             → preinscritos.create
POST    /admin/preinscritos                    → preinscritos.store
GET     /admin/preinscritos/{presrito}         → preinscritos.show
GET     /admin/preinscritos/{presrito}/edit    → preinscritos.edit
PUT     /admin/preinscritos/{presrito}         → preinscritos.update
DELETE  /admin/preinscritos/{presrito}         → preinscritos.destroy
GET     /admin/preinscritos/reportes           → preinscritos.reportes
POST    /admin/preinscritos/{id}/restore       → preinscritos.restore
```

Todas con middleware de autenticación y autorización por permisos.

### 9. **Permisos** (Actualizados en DatabaseSeeder)
Se crearon los siguientes permisos:
- `preinscritos.view`
- `preinscritos.create`
- `preinscritos.edit`
- `preinscritos.update`
- `preinscritos.delete`
- `preinscritos.restore`
- `preinscritos.force_delete`
- `preinscritos.manage`
- `preinscritos.admin` (permiso requerido para acceso al módulo)

**Los permisos se asignaron automáticamente al rol Admin ✅**

### 10. **Sidebar** `resources/views/partials/sidebar.blade.php`
Se agregó el enlace al módulo:
- Sección "Contenido" en sidebar desktop
- Sección "Contenido" en offcanvas móvil
- Solo visible si el usuario tiene permiso `preinscritos.admin`
- Icono: `bi bi-person-check`
- Ruta: `preinscritos.index`

---

## 🚀 Características Implementadas

✅ **CRUD Completo**
- Create: Crear nuevos preinscritos
- Read: Ver listado y detalles
- Update: Editar información
- Delete: Eliminar (Soft Delete)

✅ **Validaciones Robustas**
- Documentos únicos
- Emails válidos
- Tipos de documento predefinidos
- Estados controlados
- Mensajes de error en español

✅ **Filtros y Búsqueda**
- Por programa
- Por estado
- Por tipo de documento
- Por número de documento
- Por nombre

✅ **Seguridad**
- Permisos granulares con Spatie Permission
- Policies para control de acceso
- Transacciones de base de datos
- Validación de documentos duplicados
- SweetAlert2 para confirmaciones

✅ **SoftDeletes**
- Eliminación temporal
- Posibilidad de restaurar
- Registros no se pierden

✅ **Auditoría**
- created_by: Quién creó
- updated_by: Quién actualizó
- Timestamps automáticos
- Visible en vistas

✅ **Reportes** (Preparado para exportación futura)
- Estadísticas por estado
- Datos por programa
- Tabla imprimible
- Filtros personalizables
- Estructura lista para Excel

✅ **Interfaz Bootstrap5**
- Responsive en todos los dispositivos
- Sidebar desktop y móvil
- Cards y tablas Bootstrap
- Badges de estado
- Alertas de feedback

✅ **SweetAlert2**
- Confirmación de eliminación
- Alertas elegantes
- Transacciones atómicas

---

## 🔧 Uso del Módulo

### Para el Usuario Admin:

1. **Acceder al módulo**: Sidebar → "Preinscritos"
2. **Ver listado**: Automáticamente se muestran todos con paginación
3. **Filtrar**: Usar los campos de filtro en la parte superior
4. **Crear**: Botón "Nuevo Preinscrito" → llenar formulario → Guardar
5. **Ver detalles**: Click en el icono de ojo
6. **Editar**: Click en el icono de lápiz → modificar → Guardar cambios
7. **Eliminar**: Click en icono de basura → Confirmar → Se marca como eliminado
8. **Reportes**: Botón "Reportes" → filtrar → Imprimir

### Permisos Requeridos:
- `preinscritos.admin` - Acceso al módulo (visible en sidebar)
- `preinscritos.view` - Ver listado y detalles
- `preinscritos.create` - Crear nuevos
- `preinscritos.edit` - Editar
- `preinscritos.delete` - Eliminar
- `preinscritos.restore` - Restaurar eliminados

---

## 📊 Base de Datos

### Tabla: `preinscritos`
```sql
- id (BIGINT, PK)
- nombres (VARCHAR)
- apellidos (VARCHAR)
- tipo_documento (ENUM)
- numero_documento (VARCHAR, UNIQUE, INDEX)
- celular_principal (VARCHAR)
- celular_alternativo (VARCHAR, NULLABLE)
- correo_principal (VARCHAR)
- correo_alternativo (VARCHAR, NULLABLE)
- programa_id (BIGINT, FK → programas.id)
- estado (ENUM: inscrito, por_inscribir, con_novedad)
- comentarios (TEXT, NULLABLE)
- created_by (BIGINT, FK → users.id, NULLABLE)
- updated_by (BIGINT, FK → users.id, NULLABLE)
- created_at (TIMESTAMP)
- updated_at (TIMESTAMP)
- deleted_at (TIMESTAMP, NULLABLE) - SoftDelete
- INDEXES: programa_id, estado, tipo_documento, numero_documento
```

---

## ✨ Datos de Ejemplo

Se crearon 5 preinscritos de ejemplo:
1. Juan Pérez González - CC 1234567890 - Por Inscribir
2. María García López - CC 0987654321 - Inscrito
3. Carlos Rodríguez Martínez - TI 123456 - Con Novedad
4. Ana Hernández Vargas - CC 5555555555 - Por Inscribir
5. Luis Sánchez Flores - CE CE12345678 - Inscrito

Todos asociados al primer programa registrado en la base de datos.

---

## 🎯 Próximos Pasos (Opcionales)

1. **Exportación a Excel**: Usar package Laravel-Excel
2. **Importación desde Excel**: Carga masiva de preinscritos
3. **Notificaciones por Email**: Confirmar inscripción
4. **QR/Código de Confirmación**: Para trámites
5. **Historial de cambios**: Auditoría completa
6. **Integración con Inscripciones**: Vincular automáticamente

---

## 📝 Notas Técnicas

- **Laravel Version**: 12.48.1
- **PHP Version**: 8.4.16
- **Database**: MySQL
- **Packages Used**: Spatie Permission, Laravel Blade
- **CSS Framework**: Bootstrap 5
- **JS Libraries**: SweetAlert2 (ya integrado en el sistema)

---

## ✅ Estado: COMPLETADO Y FUNCIONAL

El módulo está **listo para producción** con:
- Código comentado
- Validaciones completas
- Seguridad implementada
- Interfaz amigable
- Documentación clara
- Datos de ejemplo

**Puede ser utilizado inmediatamente en el sistema.**
