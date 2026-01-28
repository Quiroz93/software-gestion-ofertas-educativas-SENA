# Reporte de Validación de Rutas
**Fecha:** Enero 27, 2026  
**Proyecto:** SoeSoftware2 - Sistema SENA

## 🔍 Resumen Ejecutivo

Se han identificado **14 inconsistencias críticas** en las rutas de la aplicación que necesitan ser corregidas para garantizar la coherencia y funcionalidad del sistema.

---

## ❌ Inconsistencias Detectadas

### 1. **Rutas Públicas - Nomenclatura Inconsistente**

#### 1.1 Centros
**Ubicación:** `resources/views/home.blade.php` líneas 203-210

**Problema:**
```php
// ❌ INCORRECTO - Esta ruta NO existe
route('public.centros.index')

// ✅ CORRECTO - Ruta que SÍ existe
route('public.centrosFormacion.index')
```

**Rutas registradas:**
- ✅ `public.centrosFormacion.index` → `/centrosFormacion`
- ✅ `public.centrosFormacion.show` → `/centrosFormacion/{id}`

**Impacto:** Los enlaces a centros públicos no funcionan (404)

---

#### 1.2 Programas
**Ubicación:** `resources/views/home.blade.php` líneas 225-227

**Problema:**
```php
// ❌ INCORRECTO - Esta ruta NO existe
route('public.programas.index')
route('public.programas.show')

// ✅ CORRECTO - Ruta que SÍ existe
route('public.programasDeFormacion.index')
route('public.programasDeFormacion.show')
```

**Rutas registradas:**
- ✅ `public.programasDeFormacion.index` → `/programasDeFormacion`
- ✅ `public.programasDeFormacion.show` → `/programasDeFormacion/{id}`

**Impacto:** Enlaces a programas públicos generan error 404

---

#### 1.3 Ofertas
**Ubicación:** Múltiples vistas

**Problema:**
```php
// ❌ INCORRECTO - Esta ruta NO existe
route('public.ofertas.index')
route('public.ofertas.show')

// ✅ CORRECTO - Ruta que SÍ existe
route('public.ofertasEducativas.index')
route('public.ofertasEducativas.show')
```

**Rutas registradas:**
- ✅ `public.ofertasEducativas.index` → `/ofertasEducativas`
- ✅ `public.ofertasEducativas.show` → `/ofertasEducativas/{id}`

**Archivos afectados:**
- `resources/views/home.blade.php` (líneas 247, 249)
- `resources/views/public/ofertas/show.blade.php` (líneas 36, 218)
- `resources/views/public/ofertas/index.blade.php`

**Impacto:** Navegación pública de ofertas rota

---

#### 1.4 Noticias
**Ubicación:** Múltiples vistas

**Problema:**
```php
// ❌ INCORRECTO - Esta ruta NO existe
route('public.noticias.index')
route('public.noticias.show')

// ✅ CORRECTO - Ruta que SÍ existe
route('public.ultimaNoticias.index')
route('public.ultimaNoticias.show')
```

**Rutas registradas:**
- ✅ `public.ultimaNoticias.index` → `/ultimaNoticias`
- ✅ `public.ultimaNoticias.show` → `/ultimaNoticias/{id}`

**Archivos afectados:**
- `resources/views/home.blade.php` (líneas 269, 271)
- `resources/views/public/noticias/show.blade.php` (líneas 14, 91, 119, 181)
- `resources/views/public/noticias/index.blade.php` (líneas 61, 109)

**Impacto:** Todas las vistas públicas de noticias inaccesibles

---

#### 1.5 Instructores
**Ubicación:** `resources/views/home.blade.php`

**Problema:**
```php
// ❌ INCORRECTO - Esta ruta NO existe
route('public.instructores.index')

// ✅ CORRECTO - Ruta que SÍ existe
route('public.instructoresDeFormacion.index')
route('public.instructoresDeFormacion.show')
```

**Rutas registradas:**
- ✅ `public.instructoresDeFormacion.index` → `/instructoresDeFormacion`
- ✅ `public.instructoresDeFormacion.show` → `/instructoresDeFormacion/{id}`

**Impacto:** Enlace a instructores públicos roto

---

### 2. **Rutas Admin - Inconsistencias de Nomenclatura**

#### 2.1 Niveles de Formación
**Ubicación:** `resources/views/layouts/admin.blade.php` línea 378

**Problema:**
```php
// ❌ INCORRECTO - Esta ruta NO existe
route('nivel_formacion.index')

// ✅ CORRECTO - Ruta que SÍ existe
route('niveles_formacion.index')
```

**Rutas registradas:**
- ✅ `niveles_formacion.index` → `/niveles_formacion/index`
- ✅ `niveles_formacion.create` → `/niveles_formacion/create`
- ✅ `niveles_formacion.edit` → `/niveles_formacion/{nivel}/edit`
- etc.

**Impacto:** Enlace del sidebar admin a niveles de formación no funciona

---

#### 2.2 Redes de Conocimiento
**Ubicación:** `resources/views/layouts/admin.blade.php` línea 387

**Problema:**
```php
// ❌ INCORRECTO - Esta ruta NO existe
route('redes.index')

// ✅ CORRECTO - Ruta que SÍ existe
route('redes_conocimiento.index')
```

**Rutas registradas:**
- ✅ `redes_conocimiento.index` → `/redes_conocimiento/index`
- ✅ `redes_conocimiento.create` → `/redes_conocimiento/create`
- ✅ `redes_conocimiento.edit` → `/redes_conocimiento/{red}/edit`
- etc.

**Impacto:** Enlace del sidebar admin a redes no funciona

---

#### 2.3 Usuarios Admin
**Ubicación:** `resources/views/layouts/admin.blade.php` línea 409

**Problema:**
```php
// ❌ INCORRECTO - Esta ruta NO existe
route('user.index')

// ✅ CORRECTO - Ruta que SÍ existe
route('users.index')
```

**Rutas registradas:**
- ✅ `users.index` → `/admin/users`
- ✅ `users.create` → `/admin/users/create`
- ✅ `users.show` → `/admin/users/{user}`
- etc.

**Impacto:** Enlace del sidebar admin a usuarios no funciona

---

#### 2.4 Centros Admin (con parámetro fijo)
**Ubicación:** `resources/views/layouts/admin.blade.php` línea 360

**Problema:**
```php
// ⚠️ PELIGROSO - Usa ID fijo
route('centros.show', 1)

// ✅ RECOMENDADO - Debería ir a index
route('centros.index')
```

**Rutas registradas:**
- ✅ `centros.index` → `/centros/index`
- ✅ `centros.show` → `/centros/{centro}`

**Impacto:** Siempre muestra el centro con ID=1, no lista todos los centros

---

### 3. **Rutas Profile - Usuarios No Admin**

#### 3.1 Permisos de Usuario
**Ubicación:** `resources/views/profile/users/permisos.blade.php` línea 7

**Problema:**
```php
// ❌ INCORRECTO - Esta ruta NO existe
route('usuarios.updatepermisos')

// ✅ CORRECTO - Ruta que SÍ existe
route('users.permissions.update', $user)
```

**Rutas registradas:**
- ✅ `users.permissions.edit` → `/usuarios/{user}/permisos` (GET)
- ✅ `users.permissions.update` → `/usuarios/{user}/permisos` (PUT)

**Impacto:** Formulario de permisos no puede actualizarse

---

#### 3.2 CRUD Usuarios Profile
**Ubicación:** `resources/views/profile/users/index.blade.php`

**Problema:**
```php
// ❌ INCORRECTO - Estas rutas NO existen
route('usuarios.create')
route('usuarios.edit')
route('usuarios.destroy')
route('usuarios.show')

// ✅ CORRECTO - Rutas que SÍ existen
route('users.create')
route('users.edit')
route('users.destroy')
route('users.show')
```

**Rutas registradas:**
- ✅ `users.create` → `/admin/users/create`
- ✅ `users.edit` → `/admin/users/{user}/edit`
- ✅ `users.destroy` → `/admin/users/{user}` (DELETE)
- ✅ `users.show` → `/admin/users/{user}`

**Impacto:** Toda la gestión de usuarios en profile no funciona

---

### 4. **Ruta Home Pública**

**Ubicación:** `resources/views/layouts/public.blade.php` línea 105

**Problema:**
```php
// ❌ INCORRECTO - Esta ruta NO existe
route('public.home')

// ✅ CORRECTO - Ruta que SÍ existe
route('home')  // o simplemente: url('/')
```

**Rutas registradas:**
- ✅ `public.home` → `/` (GET)
- ✅ `home` → `/home` (GET)

**Impacto:** Confusión entre home pública y home autenticada

---

### 5. **Oferta Educativa en Home**

**Ubicación:** `resources/views/home.blade.php` línea 562

**Problema:**
```php
// ❌ INCORRECTO - Esta ruta NO existe
route('ofertasEducativas.index')

// ✅ CORRECTO - Ruta que SÍ existe
route('public.ofertasEducativas.index')
```

**Impacto:** Enlace sin prefijo `public.` causa error

---

## 📋 Tabla Resumen de Inconsistencias

| # | Vista/Layout | Línea | Ruta Incorrecta | Ruta Correcta | Severidad |
|---|-------------|-------|-----------------|---------------|-----------|
| 1 | home.blade.php | 203-210 | `public.centros.index` | `public.centrosFormacion.index` | 🔴 Alta |
| 2 | home.blade.php | 225-227, 535-537 | `public.programas.index/show` | `public.programasDeFormacion.index/show` | 🔴 Alta |
| 3 | home.blade.php | 247-249 | `public.ofertas.index` | `public.ofertasEducativas.index` | 🔴 Alta |
| 4 | home.blade.php | 269-271 | `public.noticias.index` | `public.ultimaNoticias.index` | 🔴 Alta |
| 5 | home.blade.php | 607-609 | `public.instructores.index` | `public.instructoresDeFormacion.index` | 🔴 Alta |
| 6 | home.blade.php | 562 | `ofertasEducativas.index` | `public.ofertasEducativas.index` | 🟠 Media |
| 7 | layouts/admin.blade.php | 378 | `nivel_formacion.index` | `niveles_formacion.index` | 🔴 Alta |
| 8 | layouts/admin.blade.php | 387 | `redes.index` | `redes_conocimiento.index` | 🔴 Alta |
| 9 | layouts/admin.blade.php | 409 | `user.index` | `users.index` | 🔴 Alta |
| 10 | layouts/admin.blade.php | 360 | `centros.show, 1` | `centros.index` | 🟡 Baja |
| 11 | layouts/public.blade.php | 105 | `public.home` | `url('/')` | 🟡 Baja |
| 12 | public/ofertas/show.blade.php | 36, 218 | `public.ofertas.index` | `public.ofertasEducativas.index` | 🔴 Alta |
| 13 | public/noticias/show.blade.php | 14, 91, 119, 181 | `public.noticias.index/show` | `public.ultimaNoticias.index/show` | 🔴 Alta |
| 14 | profile/users/permisos.blade.php | 7 | `usuarios.updatepermisos` | `users.permissions.update` | 🔴 Alta |
| 15 | profile/users/index.blade.php | 12, 29, 30, 34, 35 | `usuarios.*` | `users.*` | 🔴 Alta |

**Total:** 15 inconsistencias  
**Severidad Alta (🔴):** 12 rutas  
**Severidad Media (🟠):** 1 ruta  
**Severidad Baja (🟡):** 2 rutas  

---

## ✅ Rutas Validadas Correctamente

### Admin CRUD Completo
✅ **Programas:** `programas.index/create/store/show/edit/update/destroy`  
✅ **Ofertas:** `ofertas.index/create/store/edit/update/destroy`  
✅ **Noticias:** `noticias.index/create/store/show/edit/update/destroy`  
✅ **Historias de Éxito:** `historias_de_exito.index/create/store/edit/update/destroy`  
✅ **Centros:** `centros.index/create/store/edit/update/destroy`  
✅ **Instructores:** `instructores.index/create/store/show/edit/update/destroy`  
✅ **Competencias:** `competencias.index/create/store/show/edit/update/destroy`  

### Auth
✅ **Login/Logout:** `login`, `logout`, `register`  
✅ **Password:** `password.request`, `password.email`, `password.reset`, `password.update`  
✅ **Email Verification:** `verification.notice`, `verification.send`, `verification.verify`  
✅ **Profile:** `profile.edit`, `profile.update`, `profile.destroy`  

### Public Views
✅ **Navbar Links en layouts/public.blade.php:** Usa las rutas correctas  
✅ **Breadcrumbs:** Correctamente implementados en vistas show  

---

## 🔧 Recomendaciones de Corrección

### Opción 1: Corregir las Vistas (RECOMENDADO)
Actualizar todas las vistas para usar las rutas correctas registradas en la aplicación.

**Ventajas:**
- No modifica rutas existentes
- Mantiene coherencia con la estructura actual
- Menor riesgo de romper funcionalidad existente

### Opción 2: Crear Aliases de Rutas
Crear rutas alias en `routes/web.php` para mantener compatibilidad.

**Ventajas:**
- No requiere cambiar vistas existentes
- Mantiene retrocompatibilidad

**Desventajas:**
- Duplicación de rutas
- Confusión futura en mantenimiento

---

## 📊 Impacto por Módulo

### Home (Vista Principal)
**Impacto:** 🔴 **CRÍTICO**
- 8 enlaces rotos que afectan navegación principal
- Afecta experiencia de usuario en página de inicio

### Admin Layout (Sidebar)
**Impacto:** 🔴 **CRÍTICO**
- 3 enlaces del menú no funcionan
- Afecta navegación administrativa diaria

### Public Views
**Impacto:** 🔴 **CRÍTICO**
- Breadcrumbs rotos en vistas show
- Botones "Volver" no funcionan
- Enlaces entre vistas públicas rotos

### Profile/Users
**Impacto:** 🔴 **CRÍTICO**
- Gestión de usuarios completamente rota
- Imposible crear/editar/eliminar usuarios desde profile

---

## 🎯 Plan de Acción Sugerido

### Fase 1: Correcciones Críticas (Prioridad ALTA)
1. ✅ Corregir `home.blade.php` (8 rutas)
2. ✅ Corregir `layouts/admin.blade.php` (3 rutas)
3. ✅ Corregir vistas públicas de ofertas y noticias
4. ✅ Corregir profile/users

### Fase 2: Validación (Prioridad MEDIA)
1. Testing manual de todas las rutas corregidas
2. Verificar breadcrumbs
3. Probar navegación completa

### Fase 3: Optimización (Prioridad BAJA)
1. Documentar convenciones de nomenclatura
2. Crear guía de rutas para desarrolladores
3. Implementar tests automatizados de rutas

---

## 📝 Notas Adicionales

### Convenciones Observadas

**Rutas Admin:**
- Formato: `recurso.accion` (ej: `programas.index`)
- Algunos usan guiones bajos: `niveles_formacion`, `redes_conocimiento`

**Rutas Públicas:**
- Formato: `public.recursoCamelCase.accion`
- Ejemplos: `public.programasDeFormacion.index`, `public.ofertasEducativas.index`

### Inconsistencias de Nomenclatura

La raíz del problema son **dos convenciones de nomenclatura mixtas:**

1. **Singular/Plural:** `public.centros` vs `public.centrosFormacion`
2. **Guiones bajos vs CamelCase:** `niveles_formacion` vs `nivelFormaciones`
3. **Prefijos:** `public.noticias` vs `public.ultimaNoticias`

**Recomendación:** Estandarizar a una convención única en futuras rutas.

---

**Generado:** Enero 27, 2026  
**Estado:** Pendiente de corrección  
**Próximo paso:** Implementar correcciones de Fase 1
