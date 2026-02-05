Actúa como un desarrollador senior Laravel y arquitecto de software, especializado en sistemas administrativos con trazabilidad de datos.

CONTEXTO DEL SISTEMA
Sistema académico desarrollado con:
- Laravel 10+
- Blade
- Bootstrap 5
- Spatie Laravel Permission
- SweetAlert2
- MySQL
- Alineación estricta con /docs/DESIGN_SYSTEM_SENA.md

OBJETIVO GENERAL
Diseñar e implementar un MÓDULO CRUD COMPLETO para la GESTIÓN DE NOVEDADES asociadas a PREINSCRITOS, manteniendo integridad de datos, historial de cambios y control administrativo.

IMPORTANTE:
- Un preinscrito puede tener MÚLTIPLES novedades.
- Las novedades NO cambian automáticamente el estado del preinscrito.
- Todo cambio debe quedar registrado.
- Los tipos de novedad deben ser administrables (CRUD).

================================
MODELO FUNCIONAL
================================

1️⃣ PREINSCRITOS
- Se extiende el módulo existente.
- En las vistas create, edit y show se debe mostrar:
  - Comentarios de preinscripción
  - Novedades asociadas (listado resumido)
- En la vista show se debe incluir una sección:
  “Gestión de Novedades”

================================
2️⃣ TIPOS DE NOVEDAD (CRUD ADMINISTRABLE)
================================

Crear un CRUD independiente para gestionar los tipos de novedad.

Ejemplos:
- Error en datos
- Documento inválido
- Duplicidad
- Información incompleta
- Otro

Tabla: tipos_novedad
Campos:
- id
- nombre
- descripcion
- activo
- timestamps
- softDeletes

Este CRUD debe:
- Ser accesible desde el sidebar admin
- Tener permisos con Spatie:
  - novedad.tipos.admin

================================
3️⃣ NOVEDADES DE PREINSCRITOS (CRUD PRINCIPAL)
================================

Tabla: novedades_preinscritos
Campos:
- id
- preinscrito_id (FK)
- tipo_novedad_id (FK)
- estado (abierta, en_gestion, resuelta, cancelada)
- descripcion
- created_by
- timestamps
- softDeletes

Reglas:
- Un preinscrito puede tener varias novedades.
- Las novedades son independientes entre sí.
- El estado del preinscrito NO se modifica automáticamente.

================================
4️⃣ HISTORIAL DE NOVEDADES
================================

Crear tabla para trazabilidad:

Tabla: novedades_historial
Campos:
- id
- novedad_id (FK)
- estado_anterior
- estado_nuevo
- comentario
- changed_by
- timestamps

Cada cambio de estado debe:
- Registrar historial
- Guardar usuario responsable
- Guardar observación

================================
5️⃣ MÓDULO DE GESTIÓN DE NOVEDADES
================================

Acceso:
- Desde el sidebar administrativo
- Permiso requerido:
  - preinscritos.novedades.admin

Funcionalidades:
- Listar novedades con filtros por:
  - Tipo de novedad
  - Estado
  - Nombre del preinscrito
  - Documento
  - Programa / ficha
- Acceder al detalle del preinscrito
- Cambiar estado de la novedad
- Agregar comentarios
- Ver historial completo

================================
6️⃣ CREACIÓN Y ASIGNACIÓN DE NOVEDADES
================================

El sistema debe permitir crear novedades desde:
- El detalle del preinscrito
- El módulo general de novedades

La asignación al preinscrito debe permitir:
- Búsqueda por nombre
- Búsqueda por número de documento
- Búsqueda por ficha / programa

================================
7️⃣ VISTA DETALLE DEL PREINSCRITO
================================

Agregar una sección “Gestión de Novedades” que muestre:
- Tipo de novedad
- Estado actual
- Descripción
- Comentarios iniciales
- Historial de cambios
- Botones de acción:
  - Cambiar estado
  - Agregar comentario
  - Crear nueva novedad

================================
8️⃣ ARQUITECTURA REQUERIDA
================================

Generar:
- Modelos:
  - TipoNovedad
  - NovedadPreinscrito
  - NovedadHistorial
- Migraciones con llaves foráneas e integridad referencial
- Controladores Resource
- FormRequest para validaciones
- Rutas protegidas por permisos
- Vistas Blade con Bootstrap 5
- Uso de SweetAlert2 para feedback
- Código modular, comentado y escalable

================================
9️⃣ REGLAS DE CALIDAD
================================

- No eliminar registros físicos críticos
- Usar SoftDeletes
- Mantener coherencia histórica
- Preparado para:
  - Auditoría
  - Reportes
  - Integración con otros módulos

Genera el módulo completo, integrado al sistema existente y listo para producción.
