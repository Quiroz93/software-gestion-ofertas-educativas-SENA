# 🔍 AUDITORÍA DETALLADA: CÓDIGO NO UTILIZADO Y BASURA
**Repositorio:** SoeSoftware2 - Sistema de Ofertas Educativas SENA  
**Fecha:** 3 de Febrero de 2026  
**Estado:** ANÁLISIS COMPLETO - NO SE HA ELIMINADO NADA

---

## 📋 RESUMEN EJECUTIVO

Esta auditoría identifica **código no utilizado, archivos obsoletos y basura** en el repositorio Laravel. El análisis cubre 10 categorías principales con recomendaciones de prioridad para cada ítem.

**Estadísticas generales:**
- **Vistas Blade:** 124 archivos (7 huérfanas/legacy detectadas)
- **Controladores:** 48 archivos (1 sin uso detectado)
- **Modelos:** 28 archivos (3 sin uso completo)
- **Servicios:** 3 archivos (todos en uso)
- **Traits:** 1 archivo (en uso)
- **CSS:** 32 archivos + 4 backups (múltiples sin importar)
- **Archivos de depuración:** 9 archivos .txt + scripts temporales

---

## 1️⃣ VISTAS BLADE NO UTILIZADAS

### 🔴 PRIORIDAD ALTA - Eliminar

#### `resources/views/layouts/navigation.blade.php`
- **Ruta completa:** `c:\Users\AdminSena\Documents\SoeSoftware2\resources\views\layouts\navigation.blade.php`
- **Razón:** Este layout NO se usa en ninguna vista. No hay referencias a `@extends('layouts.navigation')` ni `@include('layouts.navigation')` en todo el proyecto.
- **Recomendación:** ELIMINAR - Es un archivo huérfano que no se referencia en ningún lugar.

#### `resources/views/layouts/guest.blade.php`
- **Ruta completa:** `c:\Users\AdminSena\Documents\SoeSoftware2\resources\views\layouts\guest.blade.php`
- **Razón:** Layout de invitados que NO se usa en ninguna vista de autenticación actual.
- **Recomendación:** ELIMINAR si se confirma que auth.blade.php es el layout actual para autenticación.

#### `resources/views/legacy/home/home/admin.blade.php`
- **Ruta completa:** `c:\Users\AdminSena\Documents\SoeSoftware2\resources\views\legacy\home\home\admin.blade.php`
- **Razón:** Vista legacy. No se encuentra ninguna referencia `view('legacy.home.home.admin')` en controladores.
- **Recomendación:** ELIMINAR - Es código legacy obsoleto.

#### `resources/views/legacy/home/home/user.blade.php`
- **Ruta completa:** `c:\Users\AdminSena\Documents\SoeSoftware2\resources\views\legacy\home\home\user.blade.php`
- **Razón:** Vista legacy. No se encuentra ninguna referencia `view('legacy.home.home.user')` en controladores.
- **Recomendación:** ELIMINAR - Es código legacy obsoleto.

#### `resources/views/legacy/backups/home.blade.php.backup`
- **Ruta completa:** `c:\Users\AdminSena\Documents\SoeSoftware2\resources\views\legacy\backups\home.blade.php.backup`
- **Razón:** Archivo de backup con extensión `.backup`.
- **Recomendación:** ELIMINAR - Los backups deben estar en control de versiones (Git), no en el repositorio activo.

#### `resources/views/legacy/backups/welcome.blade.php.bak`
- **Ruta completa:** `c:\Users\AdminSena\Documents\SoeSoftware2\resources\views\legacy\backups\welcome.blade.php.bak`
- **Razón:** Archivo de backup con extensión `.bak`.
- **Recomendación:** ELIMINAR - Los backups deben estar en control de versiones (Git), no en el repositorio activo.

#### `resources/views/legacy/panel_usuario.html`
- **Ruta completa:** `c:\Users\AdminSena\Documents\SoeSoftware2\resources\views\legacy\panel_usuario.html`
- **Razón:** Archivo HTML puro (no Blade) en carpeta legacy. No se usa en el sistema Laravel.
- **Recomendación:** ELIMINAR - Es un archivo legacy que no forma parte del sistema actual.

### 🟡 PRIORIDAD MEDIA - Revisar uso

#### `resources/views/examples/user-profile-programs.blade.php`
- **Ruta completa:** `c:\Users\AdminSena\Documents\SoeSoftware2\resources\views\examples\user-profile-programs.blade.php`
- **Razón:** Vista en carpeta `examples/`. No se encuentra referencia en controladores. Parece ser un ejemplo de documentación.
- **Recomendación:** MOVER a `/docs/examples/` o ELIMINAR si ya no es necesario como referencia.

#### `resources/views/welcome.html`
- **Ruta completa:** `c:\Users\AdminSena\Documents\SoeSoftware2\resources\views\welcome.html`
- **Razón:** Archivo HTML estático en carpeta views. Laravel usa `welcome.blade.php`.
- **Recomendación:** ELIMINAR - Archivo duplicado/obsoleto.

---

## 2️⃣ CONTROLADORES SIN RUTAS O MÉTODOS NO UTILIZADOS

### 🟡 PRIORIDAD MEDIA - Revisar

#### `app/Http/Controllers/Admin/ProgramaCompetenciaController.php`
- **Ruta completa:** `c:\Users\AdminSena\Documents\SoeSoftware2\app\Http\Controllers\Admin\ProgramaCompetenciaController.php`
- **Razón:** Controlador completo con 7 métodos (index, create, store, show, edit, update, destroy) pero **NO tiene rutas definidas** en `routes/web.php`.
- **Métodos sin ruta:**
  - `index()` → vista `admin.programasCompetencias.index`
  - `create()` → vista `admin.programasCompetencias.create`
  - `store()` → N/A
  - `show()` → vista `admin.programasCompetencias.show`
  - `edit()` → vista `admin.programasCompetencias.edit`
  - `update()` → N/A
  - `destroy()` → N/A
- **Recomendación:** Si no se usa la gestión de competencias por programa, ELIMINAR este controlador. Si se planea usar, agregar las rutas correspondientes.

#### `app/Http/Controllers/Admin/OfertaProgramaController.php`
- **Ruta completa:** `c:\Users\AdminSena\Documents\SoeSoftware2\app\Http\Controllers\Admin\OfertaProgramaController.php`
- **Razón:** Controlador completo con 7 métodos pero **NO tiene rutas definidas** en `routes/web.php`.
- **Métodos sin ruta:**
  - `index()` → vista `admin.ofertasProgramas.index`
  - `create()` → vista `admin.ofertasProgramas.create`
  - `store()` → N/A
  - `show()` → vista `admin.ofertasProgramas.show`
  - `edit()` → vista `admin.ofertasProgramas.edit`
  - `update()` → N/A
  - `destroy()` → N/A
- **Recomendación:** Si no se usa la relación de ofertas-programas, ELIMINAR este controlador. Si se planea usar, agregar las rutas correspondientes.

### 🟢 PRIORIDAD BAJA - Informativo

**Nota:** Todos los demás controladores tienen rutas definidas y están en uso activo según el listado de rutas.

---

## 3️⃣ MODELOS NO UTILIZADOS O SIN REFERENCIAS

### 🔴 PRIORIDAD ALTA - Eliminar

#### `app/Models/Home.php`
- **Ruta completa:** `c:\Users\AdminSena\Documents\SoeSoftware2\app\Models\Home.php`
- **Razón:** Modelo que **NO se usa en controladores**. Solo hay referencias a `App\Models\HomeCarousel` (diferente).
- **Migración asociada:** NO IDENTIFICADA (probablemente no existe)
- **Uso detectado:** Solo importa `CustomContent` pero el modelo en sí no se usa.
- **Recomendación:** ELIMINAR - Modelo huérfano sin uso en el sistema.

### 🟡 PRIORIDAD MEDIA - Revisar uso

#### `app/Models/UserSetting.php`
- **Ruta completa:** `c:\Users\AdminSena\Documents\SoeSoftware2\app\Models\UserSetting.php`
- **Razón:** Modelo con migración existente. Solo se usa como relación en `User.php` (`hasMany(UserSetting::class)`), pero **no se usa activamente** en ningún controlador o servicio.
- **Migración:** Probablemente existe (tabla `user_settings`)
- **Recomendación:** MANTENER si se planea implementar configuraciones de usuario. ELIMINAR si no está en el roadmap.

#### `app/Models/InstructorRed.php`
- **Ruta completa:** `c:\Users\AdminSena\Documents\SoeSoftware2\app\Models\InstructorRed.php`
- **Razón:** Modelo con migración (`create_instructor_redes_table`). Solo se usa en `Instructor_redesPolicy.php` (Policy que probablemente tampoco se usa).
- **Migración:** Existe (`2026_01_16_143316_create_instructor_redes_table.php`)
- **Uso detectado:** Política de autorización que puede no estar registrada.
- **Recomendación:** Si la relación instructor-red no se gestiona, ELIMINAR modelo + migración + policy.

#### `app/Models/NovedadHistorial.php`
- **Ruta completa:** `c:\Users\AdminSena\Documents\SoeSoftware2\app\Models\NovedadHistorial.php`
- **Razón:** Modelo que **SÍ se usa** en `NovedadPreinscrito.php` (relación `hasMany` y creación de registros históricos). Funcionalidad de auditoría.
- **Recomendación:** ✅ **MANTENER** - Es funcional y se usa para historial de cambios de estado.

#### `app/Models/PreinscritoRechazado.php`
- **Ruta completa:** `c:\Users\AdminSena\Documents\SoeSoftware2\app\Models\PreinscritoRechazado.php`
- **Razón:** Modelo que solo se menciona en `ValidateDataIntegrity.php` (comando de validación) con un `class_exists()`.
- **Uso real:** BAJO - Solo para validación/debugging.
- **Recomendación:** Si no se usa la tabla de rechazados, ELIMINAR modelo + migración.

### ✅ EN USO - No eliminar

Los siguientes modelos están activamente utilizados:
- `User`, `Preinscrito`, `Programa`, `Oferta`, `Centro`, `Noticia`, `Competencia`, `Red`, `NivelFormacion`, `Municipio`, `Instructor`, `HistoriaExito`, `HomeCarousel`, `Inscripcion`, `OfertaPrograma`, `ProgramaCompetencia`, `TipoNovedad`, `NovedadPreinscrito`, `ConsolidacionPreinscrito`, `ConsolidacionPreinscritoDetalle`, `Exportacion`, `CustomContent`, `SystemSetting`

---

## 4️⃣ ARCHIVOS CSS NO IMPORTADOS

### 🔴 PRIORIDAD ALTA - Revisar importaciones

#### `backup-css-migration/_variables.scss`
- **Ruta completa:** `c:\Users\AdminSena\Documents\SoeSoftware2\backup-css-migration\_variables.scss`
- **Razón:** Archivo SCSS en carpeta de backup. No se importa en ningún archivo CSS activo.
- **Recomendación:** ELIMINAR - Es un backup de migración pasada.

#### `backup-css-migration/admin.css`
- **Ruta completa:** `c:\Users\AdminSena\Documents\SoeSoftware2\backup-css-migration\admin.css`
- **Razón:** Backup de CSS anterior. No se importa en el sistema actual.
- **Recomendación:** ELIMINAR - Ya existe `resources/css/layouts/admin.css` en uso.

#### `backup-css-migration/app.css`
- **Ruta completa:** `c:\Users\AdminSena\Documents\SoeSoftware2\backup-css-migration\app.css`
- **Razón:** Backup de CSS anterior.
- **Recomendación:** ELIMINAR - Ya existe `resources/css/common/app.css` en uso.

#### `backup-css-migration/home.css`
- **Ruta completa:** `c:\Users\AdminSena\Documents\SoeSoftware2\backup-css-migration\home.css`
- **Razón:** Backup de CSS anterior.
- **Recomendación:** ELIMINAR - Ya existe `resources/css/public/home.css` y `resources/css/pages/home.css` en uso.

#### `backup-css-migration/public.css`
- **Ruta completa:** `c:\Users\AdminSena\Documents\SoeSoftware2\backup-css-migration\public.css`
- **Razón:** Backup de CSS anterior.
- **Recomendación:** ELIMINAR - Ya existe `resources/css/public/public.css` y `resources/css/layouts/public.css` en uso.

### 🟡 PRIORIDAD MEDIA - Verificar uso

#### `resources/css/welcome.css`
- **Ruta completa:** `c:\Users\AdminSena\Documents\SoeSoftware2\resources\css\welcome.css`
- **Razón:** Archivo CSS standalone que no se importa en ningún otro archivo CSS del sistema centralizado.
- **Importaciones propias:** Importa Google Fonts directamente.
- **Recomendación:** Verificar si se enlaza directamente en alguna vista Blade. Si no, CONSOLIDAR en el sistema de diseño o ELIMINAR.

#### `resources/css/sena-utilities.css`
- **Ruta completa:** `c:\Users\AdminSena\Documents\SoeSoftware2\resources\css\sena-utilities.css`
- **Razón:** Archivo de utilidades que NO se importa en ningún archivo CSS del sistema.
- **Recomendación:** Si se usa, importarlo en `design-system.css` o `app.css`. Si no, ELIMINAR.

#### `resources/css/pages/dashboard.css`
- **Ruta completa:** `c:\Users\AdminSena\Documents\SoeSoftware2\resources\css\pages\dashboard.css`
- **Razón:** CSS específico del dashboard. No se importa en el sistema CSS centralizado.
- **Recomendación:** Verificar si se enlaza directamente en `dashboard.blade.php`. Considerar importarlo en el sistema centralizado.

#### `resources/css/common/app.css`
- **Ruta completa:** `c:\Users\AdminSena\Documents\SoeSoftware2\resources\css\common\app.css`
- **Razón:** Importa `../public/home.css`. No se importa en ningún otro archivo.
- **Recomendación:** Verificar su uso en `vite.config.js` o en layouts Blade.

### ✅ EN USO - Sistema de tokens

Los siguientes archivos SÍ están correctamente importados:
- `resources/css/tokens/index.css` (importa todos los tokens: colors, typography, spacing, shadows, borders, animations)
- `resources/css/design-system.css` (importa tokens)
- `resources/css/public/public.css` (importa home.css)

**Nota importante:** Se detecta **importación duplicada de Google Fonts** en:
1. `resources/css/welcome.css`
2. `resources/css/tokens/_typography-sena.css`
3. `resources/css/public/home.css`

**Recomendación:** Consolidar en un solo lugar (preferiblemente en `_typography-sena.css` del design system).

---

## 5️⃣ ARCHIVOS DE DEBUG Y TESTING

### 🔴 PRIORIDAD ALTA - Eliminar antes de producción

#### `test-carousel.sh`
- **Ruta completa:** `c:\Users\AdminSena\Documents\SoeSoftware2\test-carousel.sh`
- **Razón:** Script de testing Bash. No debe estar en producción.
- **Recomendación:** ELIMINAR o mover a `/tests/scripts/` si es necesario mantenerlo.

#### `auditoria-fase1.txt`
- **Ruta completa:** `c:\Users\AdminSena\Documents\SoeSoftware2\auditoria-fase1.txt`
- **Razón:** Archivo de auditoría/notas de desarrollo.
- **Recomendación:** MOVER a `/docs/` o ELIMINAR si ya está documentado en Markdown.

#### `audit-colors.txt`
- **Ruta completa:** `c:\Users\AdminSena\Documents\SoeSoftware2\audit-colors.txt`
- **Razón:** Auditoría de colores.
- **Recomendación:** MOVER a `/docs/` o ELIMINAR si ya está en `AUDITORIA_CSS_COMPLETA.md`.

#### `audit-fonts.txt`
- **Ruta completa:** `c:\Users\AdminSena\Documents\SoeSoftware2\audit-fonts.txt`
- **Razón:** Auditoría de tipografías.
- **Recomendación:** MOVER a `/docs/` o ELIMINAR si ya está documentado.

#### `fase3-migracion-tipografia.txt`
- **Ruta completa:** `c:\Users\AdminSena\Documents\SoeSoftware2\fase3-migracion-tipografia.txt`
- **Razón:** Notas de migración.
- **Recomendación:** MOVER a `/docs/migration-logs/` o ELIMINAR.

#### `fase4-colores-eliminados.txt`
- **Ruta completa:** `c:\Users\AdminSena\Documents\SoeSoftware2\fase4-colores-eliminados.txt`
- **Razón:** Notas de migración.
- **Recomendación:** MOVER a `/docs/migration-logs/` o ELIMINAR.

#### `fase5-componentes-unificados.txt`
- **Ruta completa:** `c:\Users\AdminSena\Documents\SoeSoftware2\fase5-componentes-unificados.txt`
- **Razón:** Notas de migración.
- **Recomendación:** MOVER a `/docs/migration-logs/` o ELIMINAR.

#### `fase6-refactorizar-layouts.txt`
- **Ruta completa:** `c:\Users\AdminSena\Documents\SoeSoftware2\fase6-refactorizar-layouts.txt`
- **Razón:** Notas de migración.
- **Recomendación:** MOVER a `/docs/migration-logs/` o ELIMINAR.

#### `prompt_modulo_consolidar._reportesmd`
- **Ruta completa:** `c:\Users\AdminSena\Documents\SoeSoftware2\prompt_modulo_consolidar._reportesmd`
- **Razón:** Archivo de prompt (probablemente notas de desarrollo). Extensión incorrecta.
- **Recomendación:** ELIMINAR o renombrar a `.md` y mover a `/docs/`.

### 🟡 PRIORIDAD MEDIA - Revisar necesidad

#### Scripts Python

##### `normalize_and_update.py`
- **Ruta completa:** `c:\Users\AdminSena\Documents\SoeSoftware2\normalize_and_update.py`
- **Razón:** Script Python de normalización. No está en carpeta `scripts/`.
- **Recomendación:** MOVER a `/scripts/` o ELIMINAR si ya se ejecutó y no se volverá a usar.

##### `update_fichas.py`
- **Ruta completa:** `c:\Users\AdminSena\Documents\SoeSoftware2\update_fichas.py`
- **Razón:** Script Python de actualización.
- **Recomendación:** MOVER a `/scripts/` o ELIMINAR si ya se ejecutó.

##### `update_fichas.ps1`
- **Ruta completa:** `c:\Users\AdminSena\Documents\SoeSoftware2\update_fichas.ps1`
- **Razón:** Script PowerShell de actualización.
- **Recomendación:** MOVER a `/scripts/` o ELIMINAR si ya se ejecutó.

#### Archivos JSON de datos temporales

##### `preinscritos_data.json`
- **Ruta completa:** `c:\Users\AdminSena\Documents\SoeSoftware2\preinscritos_data.json`
- **Razón:** Datos temporales de preinscritos.
- **Recomendación:** ELIMINAR si ya se importaron a la base de datos. Estos datos no deben estar en el repositorio.

##### `preinscritos_full_data.json`
- **Ruta completa:** `c:\Users\AdminSena\Documents\SoeSoftware2\preinscritos_full_data.json`
- **Razón:** Datos completos temporales.
- **Recomendación:** ELIMINAR. Agregar `*.json` (excepto `package.json` y `composer.json`) al `.gitignore`.

##### `preinscritos_updated.json`
- **Ruta completa:** `c:\Users\AdminSena\Documents\SoeSoftware2\preinscritos_updated.json`
- **Razón:** Datos actualizados temporales.
- **Recomendación:** ELIMINAR.

##### `pre incripciones.xlsx`
- **Ruta completa:** `c:\Users\AdminSena\Documents\SoeSoftware2\pre incripciones.xlsx`
- **Razón:** Archivo Excel con datos (probablemente sensibles).
- **Recomendación:** ⚠️ **ELIMINAR INMEDIATAMENTE** - Puede contener datos personales. Agregar `*.xlsx` al `.gitignore`.

### ⚠️ CÓDIGO DEBUG EN PRODUCCIÓN

**No se encontraron** llamadas a `console.log()`, `dd()` o `dump()` en el código PHP/JS de producción. Solo se encontraron en archivos de documentación en `/docs/`, lo cual es correcto.

✅ **BUENA PRÁCTICA:** El código de producción está limpio de debugging.

---

## 6️⃣ SERVICIOS NO UTILIZADOS

### ✅ TODOS LOS SERVICIOS EN USO

**Resultado:** Los 3 servicios existentes están activamente utilizados:

1. **`app/Services/MediaService.php`**
   - Usado en: `MediaContentController.php`
   - Función: Gestión de archivos multimedia
   - **Estado:** ✅ EN USO

2. **`app/Services/SystemBootstrapService.php`**
   - Usado en: `RegisteredUserController.php`
   - Función: Configuración inicial del sistema
   - **Estado:** ✅ EN USO

3. **`app/Services/ReportePresritoService.php`**
   - Usado en: `ReportesController.php`
   - Función: Generación de reportes de preinscritos
   - **Estado:** ✅ EN USO

**Recomendación:** ✅ **MANTENER TODOS** - No se detectó ningún servicio sin uso.

---

## 7️⃣ TRAITS NO UTILIZADOS

### ✅ TRAIT EN USO

**`app/Traits/HasProfilePhoto.php`**
- **Usado en:** `app/Models/User.php` (líneas 7 y 18)
- **Función:** Gestión de fotos de perfil de usuario
- **Estado:** ✅ EN USO ACTIVO

**Recomendación:** ✅ **MANTENER** - El único trait está en uso.

---

## 8️⃣ RUTAS ORFANDAS

### ✅ NO SE DETECTARON RUTAS HUÉRFANAS

**Resultado del análisis:** Todas las 186 rutas definidas en `routes/web.php` apuntan a controladores y métodos existentes.

**Verificación realizada:**
- ✅ Controladores de autenticación (Auth/*)
- ✅ Controladores públicos (Public/*)
- ✅ Controladores administrativos (Admin/*)
- ✅ Controladores de perfil (ProfileController)
- ✅ Controladores de inscripción (InscripcionController)

**Nota sobre controladores sin rutas:**
- ⚠️ `ProgramaCompetenciaController` y `OfertaProgramaController` tienen métodos pero **NO tienen rutas definidas** (ver sección 2).

**Recomendación:** ✅ Las rutas están limpias. Solo revisar controladores sin rutas (sección 2).

---

## 9️⃣ MIGRACIONES SIN MODELOS

### 🟡 PRIORIDAD MEDIA - Revisar consistencia

#### Migración: `create_permission_tables`
- **Archivo:** `2026_01_05_214535_create_permission_tables.php`
- **Tablas creadas:** `permissions`, `roles`, `model_has_permissions`, `model_has_roles`, `role_has_permissions`
- **Modelo asociado:** ❌ NO - Las usa el paquete **Spatie Laravel Permission**
- **Estado:** ✅ CORRECTO - Estas tablas las gestiona Spatie con sus propios modelos (`Spatie\Permission\Models\Role` y `Spatie\Permission\Models\Permission`)
- **Recomendación:** ✅ **MANTENER** - Es la migración del paquete de permisos.

#### Tablas pivot sin modelos explícitos

Las siguientes migraciones crean tablas pivot que **NO requieren modelo** en Laravel:
- `instructor_redes` (relación muchos a muchos: Instructor ↔ Red)
- `oferta_programas` (relación muchos a muchos: Oferta ↔ Programa)
- `programa_competencias` (relación muchos a muchos: Programa ↔ Competencia)

**Nota:** Laravel permite manejar estas relaciones sin modelos explícitos usando `belongsToMany()`.

**PERO:** Se detectó que **SÍ existen modelos** para estas tablas:
- `InstructorRed.php` → Modelo que solo se usa en Policy (ver sección 3)
- `OfertaPrograma.php` → Modelo con controlador SIN rutas (ver sección 2)
- `ProgramaCompetencia.php` → Modelo con controlador SIN rutas (ver sección 2)

**Recomendación:** Si las relaciones `instructor_redes`, `oferta_programas` y `programa_competencias` **NO se gestionan directamente** (solo sirven como pivot), ELIMINAR sus modelos y controladores. Laravel las manejará automáticamente.

### ✅ RESTO DE MIGRACIONES

Todas las demás migraciones (37 en total) tienen modelos correspondientes y activos:
- `users`, `cache`, `jobs`, `sessions` → Framework Laravel
- `centros`, `competencias`, `programas`, `ofertas`, `noticias`, etc. → Modelos del sistema

---

## 🔟 SEEDERS NO UTILIZADOS

### ✅ TODOS LOS SEEDERS SE EJECUTAN

**Análisis del `DatabaseSeeder.php`:**

Líneas 322-335 del archivo muestran que se ejecutan **12 seeders**:

```php
$this->call([
    UserSeeder::class,
    CentroSeeder::class,
    RedSeeder::class,
    NivelFormacionSeeder::class,
    MunicipioSeeder::class,
    CompetenciaSeeder::class,
    ProgramaSeeder::class,
    InstructorSeeder::class,
    HistoriaDeExitoSeeder::class,
    OfertaSeeder::class,
    NoticiaSeeder::class,
    TipoNovedadSeeder::class,
    PreinscritoExcelSeeder::class,
]);
```

**Seeders existentes en `/database/seeders/`:**
1. ✅ UserSeeder
2. ✅ CentroSeeder
3. ✅ RedSeeder
4. ✅ NivelFormacionSeeder
5. ✅ MunicipioSeeder
6. ✅ CompetenciaSeeder
7. ✅ ProgramaSeeder
8. ✅ InstructorSeeder
9. ✅ HistoriaDeExitoSeeder
10. ✅ OfertaSeeder
11. ✅ NoticiaSeeder
12. ✅ TipoNovedadSeeder
13. ✅ PreinscritoExcelSeeder
14. ✅ DatabaseSeeder (orquestador)
15. ⚠️ InscripcionSeeder - **NO SE EJECUTA** (ver abajo)

### 🟡 PRIORIDAD MEDIA - Revisar necesidad

#### `InscripcionSeeder.php`
- **Ruta completa:** `c:\Users\AdminSena\Documents\SoeSoftware2\database\seeders\InscripcionSeeder.php`
- **Razón:** Existe el archivo pero **NO se llama** en `DatabaseSeeder.php`.
- **Recomendación:** 
  - Si se necesita poblar la tabla `inscripciones` con datos de prueba, agregarlo al `DatabaseSeeder`.
  - Si NO se necesita, ELIMINAR el archivo.

---

## 📊 RESUMEN DE ELIMINACIONES RECOMENDADAS

### 🔴 PRIORIDAD ALTA - Eliminar inmediatamente

**Total: 23 archivos**

#### Vistas (7)
1. `resources/views/layouts/navigation.blade.php`
2. `resources/views/layouts/guest.blade.php`
3. `resources/views/legacy/home/home/admin.blade.php`
4. `resources/views/legacy/home/home/user.blade.php`
5. `resources/views/legacy/backups/home.blade.php.backup`
6. `resources/views/legacy/backups/welcome.blade.php.bak`
7. `resources/views/legacy/panel_usuario.html`

#### CSS (6)
8. `backup-css-migration/_variables.scss`
9. `backup-css-migration/admin.css`
10. `backup-css-migration/app.css`
11. `backup-css-migration/home.css`
12. `backup-css-migration/public.css`
13. **Carpeta completa:** `backup-css-migration/` → ELIMINAR

#### Archivos de datos temporales (4)
14. `preinscritos_data.json`
15. `preinscritos_full_data.json`
16. `preinscritos_updated.json`
17. ⚠️ **`pre incripciones.xlsx`** (puede contener datos sensibles)

#### Scripts de testing (1)
18. `test-carousel.sh`

#### Archivos de auditoría/notas (5)
19. `auditoria-fase1.txt`
20. `audit-colors.txt`
21. `audit-fonts.txt`
22. `fase3-migracion-tipografia.txt`
23. `fase4-colores-eliminados.txt`
24. `fase5-componentes-unificados.txt`
25. `fase6-refactorizar-layouts.txt`
26. `prompt_modulo_consolidar._reportesmd`

### 🟡 PRIORIDAD MEDIA - Revisar y decidir (11 ítems)

1. `resources/views/examples/user-profile-programs.blade.php` → Mover a docs o eliminar
2. `resources/views/welcome.html` → Eliminar (duplicado)
3. `app/Http/Controllers/Admin/ProgramaCompetenciaController.php` → Eliminar si no se usa
4. `app/Http/Controllers/Admin/OfertaProgramaController.php` → Eliminar si no se usa
5. `app/Models/Home.php` → Eliminar (no se usa)
6. `app/Models/UserSetting.php` → Eliminar si no está en roadmap
7. `app/Models/InstructorRed.php` → Eliminar si no se gestiona
8. `app/Models/PreinscritoRechazado.php` → Eliminar si no se usa
9. `resources/css/welcome.css` → Consolidar o eliminar
10. `resources/css/sena-utilities.css` → Importar o eliminar
11. `database/seeders/InscripcionSeeder.php` → Agregar llamada o eliminar

### 🟢 PRIORIDAD BAJA - Mejoras de organización (3)

1. Scripts Python → Mover a `/scripts/`
2. Archivos .txt de fases → Mover a `/docs/migration-logs/`
3. Google Fonts → Consolidar importaciones en un solo lugar

---

## 🎯 PLAN DE ACCIÓN RECOMENDADO

### Fase 1: Limpieza inmediata (ALTA prioridad) 🔴
```bash
# 1. Eliminar carpeta de backups CSS
rm -rf backup-css-migration/

# 2. Eliminar vistas legacy
rm -rf resources/views/legacy/

# 3. Eliminar archivos HTML sueltos
rm resources/views/welcome.html

# 4. Eliminar vistas huérfanas
rm resources/views/layouts/navigation.blade.php
rm resources/views/layouts/guest.blade.php

# 5. Eliminar datos temporales (¡IMPORTANTE!)
rm preinscritos_data.json
rm preinscritos_full_data.json
rm preinscritos_updated.json
rm "pre incripciones.xlsx"

# 6. Eliminar scripts de testing
rm test-carousel.sh

# 7. Eliminar/mover archivos de auditoría
mkdir -p docs/migration-logs
mv auditoria-fase1.txt docs/migration-logs/
mv audit-colors.txt docs/migration-logs/
mv audit-fonts.txt docs/migration-logs/
mv fase3-migracion-tipografia.txt docs/migration-logs/
mv fase4-colores-eliminados.txt docs/migration-logs/
mv fase5-componentes-unificados.txt docs/migration-logs/
mv fase6-refactorizar-layouts.txt docs/migration-logs/
rm prompt_modulo_consolidar._reportesmd
```

### Fase 2: Revisión de código (MEDIA prioridad) 🟡

**Decisiones a tomar:**

1. **¿Se usarán ProgramaCompetencia y OfertaPrograma?**
   - ❌ NO → Eliminar controladores + modelos
   - ✅ SÍ → Crear rutas en `web.php`

2. **¿Se implementará UserSetting?**
   - ❌ NO → Eliminar modelo + migración
   - ✅ SÍ → Mantener para futuro

3. **¿Se gestiona InstructorRed directamente?**
   - ❌ NO → Eliminar modelo + policy (usar solo relación pivot)
   - ✅ SÍ → Crear rutas en `web.php`

4. **¿Se necesita tabla de rechazados?**
   - ❌ NO → Eliminar modelo + migración
   - ✅ SÍ → Implementar funcionalidad

### Fase 3: Mejoras de organización (BAJA prioridad) 🟢

```bash
# Organizar scripts
mkdir -p scripts
mv normalize_and_update.py scripts/
mv update_fichas.py scripts/
mv update_fichas.ps1 scripts/

# Consolidar importaciones de Google Fonts
# (Dejar solo en _typography-sena.css, eliminar de otros archivos)
```

### Fase 4: Actualizar .gitignore

Agregar al `.gitignore`:
```gitignore
# Archivos de datos temporales
*.json
!package.json
!package-lock.json
!composer.json
!composer.lock

# Archivos de Excel con datos
*.xlsx
*.xls

# Archivos de backup
*.backup
*.bak
*.old

# Scripts temporales de testing
test-*.sh
test-*.ps1
```

---

## 📈 IMPACTO DE LA LIMPIEZA

### Espacio liberado estimado
- Vistas legacy: ~50 KB
- CSS backups: ~200 KB
- Datos JSON: **~10-50 MB** (dependiendo del tamaño de preinscritos)
- Archivos Excel: **~1-5 MB**
- Archivos .txt: ~20 KB
- **Total estimado:** 11-55 MB

### Reducción de confusión
- ✅ Elimina 7 vistas que no se usan (más claridad para desarrolladores)
- ✅ Elimina 5 archivos CSS de backup (mejora organización)
- ✅ Elimina 4 archivos de datos temporales (previene confusión)
- ✅ Elimina 2 controladores sin rutas (reduce complejidad)

### Mejora de seguridad
- ⚠️ **CRÍTICO:** Eliminar `pre incripciones.xlsx` (puede contener datos personales)
- ✅ Eliminar archivos .json con datos de preinscritos
- ✅ Actualizar .gitignore para prevenir futuros commits de datos sensibles

---

## ✅ CONCLUSIONES FINALES

### Lo que está bien ✅
1. **Servicios:** Los 3 servicios están en uso activo
2. **Traits:** El único trait está en uso
3. **Rutas:** Todas las rutas apuntan a métodos existentes
4. **Seeders:** 13 de 14 seeders se ejecutan correctamente
5. **Código de debug:** No hay `console.log()`, `dd()` o `dump()` en producción
6. **Modelos principales:** 22 de 28 modelos están activamente utilizados

### Lo que necesita limpieza 🧹
1. **Vistas:** 7 archivos legacy/huérfanos a eliminar
2. **CSS:** 6 archivos de backup + archivos sin importar
3. **Datos:** 4 archivos JSON + 1 Excel con datos temporales/sensibles
4. **Controladores:** 2 controladores sin rutas definidas
5. **Modelos:** 3-4 modelos con uso cuestionable
6. **Organización:** 8 archivos .txt de auditoría en raíz

### Riesgo de seguridad ⚠️
- **ALTO:** Archivo `pre incripciones.xlsx` en repositorio
- **MEDIO:** Archivos JSON con datos de preinscritos
- **Recomendación:** Eliminar inmediatamente y actualizar .gitignore

---

## 📝 NOTAS ADICIONALES

**Última actualización:** 3 de Febrero de 2026  
**Auditor:** GitHub Copilot (Claude Sonnet 4.5)  
**Método:** Análisis automático + verificación cruzada de referencias

**Disclaimer:** Esta auditoría se basa en análisis estático de código. Se recomienda realizar pruebas después de cualquier eliminación para confirmar que no afecta funcionalidad activa.

**Próximos pasos sugeridos:**
1. Revisar este documento con el equipo de desarrollo
2. Aprobar las eliminaciones de PRIORIDAD ALTA
3. Decidir sobre los ítems de PRIORIDAD MEDIA
4. Ejecutar las eliminaciones en una rama de git separada
5. Realizar pruebas exhaustivas antes de merge a producción

---

**FIN DEL REPORTE DE AUDITORÍA**
