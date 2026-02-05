Actúa como un desarrollador senior Laravel y arquitecto de software.

Contexto del sistema:
Estoy desarrollando un sistema de gestión de ofertas académicas (Laravel + Blade + Bootstrap5 + Bootstrap).
Se utiliza:
- Laravel 12+
- Blade
- AdminLTE
- Spatie Laravel Permission
- SweetAlert2
- MySQL
- Arquitectura MVC limpia
- Buenas prácticas (FormRequest, Policies, SoftDeletes)
- Alineación con estándares DESIGN_SYSTEM_SENA.md

Objetivo:
Crear un MÓDULO CRUD COMPLETO para la gestión de APRENDICES PREINSCRITOS, totalmente integrado al sistema existente y accesible desde el sidebar admin.

========================
ALGORITMO DEL MÓDULO
========================

1. El usuario accede al módulo desde el sidebar administrativo.
2. El sistema valida permisos usando Spatie:
   - Permiso requerido: `preinscritos.admin` (debes crear el permiso)
3. Si el permiso es válido:
   - Mostrar el index del CRUD con listado de aprendices preinscritos.
4. Si el permiso NO es válido:
   - Mostrar alerta con SweetAlert2 y bloquear acceso.

El usuario ADMIN puede:
- Crear registros
- Ver registros
- Editar registros
- Eliminar registros (Soft Delete)
- generar reportes con filtros según estado del preinscrito (preparar para futura exportación a Excel)

========================
DATOS DEL FORMULARIO
========================

Campos obligatorios:
- nombres
- apellidos
- tipo_documento (cc, ti, ce, ppt, etc)
- numero_documento (único)
- celular_principal
- correo_principal (email válido)
- programa_id (relación con programas.numero_ficha)
- estado (inscrito, por_inscribir, con_novedad)

Campos opcionales:
- celular_alternativo
- correo_alternativo
- comentarios

IMPORTANTE:
- En la base de datos se guarda el NUMERO DE FICHA
- En la UI se muestra el NOMBRE DEL PROGRAMA

========================
REGLAS FUNCIONALES
========================

1. Validar que el `numero_documento` no esté registrado previamente.
2. Si ya existe:
   - Mostrar alerta SweetAlert2 indicando registro duplicado.
3. Evitar eliminaciones accidentales:
   - Implementar SoftDeletes.
4. Usar transacciones DB para create/update.
5. Implementar filtros en el index:
   - Por programa
   - Por estado
   - Por tipo de documento
   - Por número de documento
6. Preparar el módulo para exportación futura a Excel.

========================
BASE DE DATOS
========================

Crear migración `preinscritos` con:
- id
- nombres
- apellidos
- tipo_documento
- numero_documento (unique, indexed)
- celular_principal
- celular_alternativo (nullable)
- correo_principal
- correo_alternativo (nullable)
- programa_ficha (FK hacia programas.numero_ficha)
- estado
- comentarios (nullable)
- created_by
- updated_by
- timestamps
- softDeletes

Definir relación:
- Preinscrito belongsTo Programa (por numero_ficha)

========================
ARQUITECTURA REQUERIDA
========================

Generar:
- Modelo `Preinscrito`
- Migración
- Seeder (tipos de documento y estados)
- Controlador Resource
- FormRequest (Store / Update)
- Rutas protegidas por middleware y permisos
- Vistas Blade:
  - index
  - create
  - edit
  - show
  - reportes (preparar para futura exportación Excel)
- Integración con SweetAlert2
- Uso de componentes Bootstrap5 y alineacion con DESIGN_SYSTEM_SENA.md
- Políticas de acceso (Policies)
- Código listo para producción

========================
CALIDAD DEL CÓDIGO
========================

- Código comentado
- Buenas prácticas Laravel
- Uso de relaciones Eloquent
- Validaciones claras
- Preparado para escalabilidad
- Compatible con futuras exportaciones Excel

Genera el módulo completo y funcional.
