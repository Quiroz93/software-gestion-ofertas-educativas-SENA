Actúa como un desarrollador senior Laravel especializado en generación de reportes Excel institucionales.

CONTEXTO DEL SISTEMA
Sistema académico desarrollado en:
- Laravel 12+
- Blade
- Bootstrap 5
- Spatie Laravel Permission
- SweetAlert2
- MySQL
- Maatwebsite/Laravel-Excel

El frontend debe respetar estrictamente:
- DESIGN_SYSTEM_SENA.md
(No usar AdminLTE ni estilos externos)

OBJETIVO DEL MÓDULO
Crear un módulo que permita generar archivos Excel tipo reporte institucional a partir de los datos almacenados en la tabla `preinscritos`.

================================
ACCESO Y PERMISOS
================================

- Acceso desde el sidebar admin
- Permiso requerido: `preinscritos.export`
- Sin permiso:
  - SweetAlert2
  - Cancelar proceso

================================
LÓGICA DE FILTROS
================================

El contenido del Excel debe depender exactamente de los filtros aplicados:

- Si hay 1 preinscrito → Excel con 1 registro
- Si hay N preinscritos → Excel con N registros
- Si se filtra por programa o ficha → reporte por ese filtro
- No agregar ni eliminar registros fuera del filtro

================================
LÓGICA DEL ENCABEZADO
================================

- Título centrado:
  “Reporte de Inscripciones”

Si el reporte contiene UNA sola ficha:
- Código Ficha → relacionado desde BD
- Programa de Formación → nombre real

Si el reporte contiene VARIAS fichas:
- Código Ficha → relacionado desde BD
- Programa de Formación → "N/A"

================================
COLUMNAS DEL REPORTE
================================

- Identificación
- Nombre
- Estado

================================
FORMATO EXCEL
================================

- Celdas combinadas
- Negrilla
- Alineación centrada
- Colores institucionales SENA
- Tablas limpias

================================
NOMBRE DEL ARCHIVO
================================

Formato:
reporte_preinscritos_YYYYMMDD_HHMMSS.xlsx

================================
TRAZABILIDAD
================================

Guardar cada exportación en BD:
- filtros_aplicados (json)
- total_registros
- usuario
- nombre_archivo
- fecha

================================
ARQUITECTURA
================================

Generar:
- Export class Laravel Excel
- Controlador de exportación
- Servicio de construcción del reporte
- Registro en BD del reporte generado
- Código modular y comentado

Genera el módulo completo, listo para producción y alineado al sistema.
