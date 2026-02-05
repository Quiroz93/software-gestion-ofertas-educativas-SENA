# 🏗️ ARQUITECTURA DE SEGURIDAD - SOE SENA

## 📋 Descripción General

El sistema está dividido en dos grandes módulos separados con lógica de control de acceso unidireccional:

### **Módulo 1: VISTAS PÚBLICAS (Public Module)**
- **Acceso:** Todos los usuarios autenticados (rol `user`, `aprendiz`, etc.)
- **Contenido:** Programas, ofertas, noticias, historias de éxito, centros, etc.
- **Ruta Principal:** `/home`
- **Características:** Lectura de información pública + edición de contenido solo para publicistas/admins

### **Módulo 2: PANEL ADMINISTRATIVO (Admin Module)**
- **Acceso:** Solo usuarios con rol `admin` o `SuperAdmin`
- **Contenido:** CRUD de base de datos, gestión de usuarios, roles, permisos
- **Ruta Principal:** `/dashboard`
- **Características:** Administración completa del sistema

---

## 🔐 Sistema de Permisos y Roles

### **Roles Disponibles:**

| Rol | Permisos | Acceso |
|-----|----------|--------|
| **admin** | 78 permisos (CRUD completo) | Dashboard + Vistas Públicas |
| **SuperAdmin** | 78 permisos (CRUD completo) | Dashboard + Vistas Públicas |
| **user** | 6 permisos (lectura pública) | Solo Vistas Públicas |
| **aprendiz** | (por definir) | Solo Vistas Públicas |
| **instructor** | (por definir) | Según políticas específicas |
| **publicista** | `public_content.edit` | Edición de vistas públicas |

### **Permisos por Categoría:**

#### ✅ Permisos de Lectura Pública (Rol 'user')
```
- centros.view
- historias_de_exito.view
- ofertas.view
- ofertas.show
- programas.view
- redes_conocimiento.view
```

#### ❌ Permisos Administrativos (Rol 'admin' SOLO)
```
- dashboard.view ← CRÍTICO: NO debe tener rol 'user'
- admin.view
- users.* (create, edit, update, delete, manage)
- roles.* (create, edit, update, delete, manage)
- permissions.* (create, edit, update, delete, manage)
- centros.* (create, edit, update, delete, manage)
- [todos los CRUD completos]
```

#### 🎨 Permisos de Edición de Contenido Público
```
- public_content.edit ← Para publicistas/admins que editan vistas públicas
```

---

## 🚀 Flujo de Navegación Permitido

### **Usuarios con rol 'user':**
```
Inicio de Sesión
    ↓
HOME (vistas públicas)
    ├─ Ver Programas
    ├─ Ver Ofertas
    ├─ Ver Noticias
    ├─ Ver Historias de Éxito
    ├─ Mi Perfil
    └─ Cerrar Sesión
    
❌ NO PUEDE ACCEDER A:
    ├─ /dashboard
    ├─ /admin/users
    ├─ /admin/roles
    ├─ Ningún módulo CRUD
```

### **Usuarios con rol 'admin':**
```
Inicio de Sesión
    ↓
HOME (vistas públicas) ← Acceso total
    ├─ Ver Programas
    ├─ Ver Ofertas
    ├─ Ver Noticias
    └─ Editar contenido público
    
✅ PUEDE ACCEDER A:
    ├─ /dashboard
    ├─ /admin/users
    ├─ /admin/roles
    ├─ Todos los módulos CRUD
    └─ Gestión completa del sistema
```

---

## 🛡️ Mecanismos de Protección

### **1. Protección en Rutas (Backend)**

```php
// ✅ CORRECTO - Solo admins
Route::get('/dashboard', function () {
    return view('dashboard');
})
    ->middleware(['auth', 'verified', 'role:admin|SuperAdmin'])
    ->name('dashboard');

// ✅ CORRECTO - Con validación de permiso
Route::middleware(['auth', 'verified', 'can:centros.view'])
    ->get('centros/index', [CentroController::class, 'index'])
    ->name('centros.index');
```

### **2. Protección en Vistas (Frontend)**

```blade
<!-- ✅ CORRECTO - Usar hasRole para acceso al dashboard -->
@if (Auth::user()->hasRole('admin') || Auth::user()->hasRole('SuperAdmin'))
    <a href="{{ route('dashboard') }}">Dashboard</a>
@endif

<!-- ✅ CORRECTO - Usar can() para permisos específicos -->
@can('centros.view')
    <div>Botón de Centros</div>
@endcan
```

### **3. Protección en Policies**

```php
// En CentroPolicy.php
public function viewAny(User $user): bool {
    return $user->can('centros.view');
}

public function create(User $user): bool {
    return $user->can('centros.create'); // Admin solo
}
```

---

## 🔄 Flujo de Validación Unidireccional

### **Acceso a Dashboard:**
```
Usuario intenta ir a /dashboard
    ↓
¿Está autenticado? → NO → Redirige a login
    ↓ SÍ
¿Es verificado? → NO → Redirige a verificar email
    ↓ SÍ
¿Tiene rol admin|SuperAdmin? → NO → 403 Forbidden
    ↓ SÍ
✅ Acceso permitido → Dashboard cargado
```

### **Acceso a Módulos CRUD:**
```
Usuario intenta ir a /centros/index
    ↓
¿Está autenticado? → NO → Redirige a login
    ↓ SÍ
¿Es verificado? → NO → Redirige a verificar email
    ↓ SÍ
¿Tiene permiso centros.view? → NO → 403 Forbidden
    ↓ SÍ
✅ Acceso permitido → Index cargado
```

### **Acceso a Vistas Públicas:**
```
Usuario intenta ir a /home
    ↓
¿Está autenticado? → NO → Acceso permitido (guest)
    ↓ SÍ
✅ Acceso permitido → Home cargado con contenido
```

---

## 🔴 Errores Comunes y Cómo Prevenirlos

### **Error 1: Dashboard.view en rol 'user'**
```
❌ INCORRECTO:
$role->givePermissionTo('dashboard.view');

✅ CORRECTO:
// No asignar este permiso a 'user'
// Solo admin y SuperAdmin deben tenerlo
```

### **Error 2: Usar can() para validar acceso a dashboard**
```
❌ INCORRECTO:
@if (Auth::user()->can('dashboard.view'))
    <!-- Inseguro si el permiso se asigna incorrectamente -->
@endif

✅ CORRECTO:
@if (Auth::user()->hasRole('admin') || Auth::user()->hasRole('SuperAdmin'))
    <!-- Usar hasRole como validación principal -->
@endif
```

### **Error 3: Sin validación en rutas**
```
❌ INCORRECTO:
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

✅ CORRECTO:
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified', 'role:admin|SuperAdmin'])
    ->name('dashboard');
```

---

## 📊 Mapa de Módulos y Acceso

```
SOE SENA SYSTEM
│
├─ PUBLIC VIEWS (✅ user, publicista, admin)
│  ├─ /home (HomeController)
│  ├─ /public.centrosFormacion
│  ├─ /public.ultimaNoticias
│  ├─ /public.historiasDeExito
│  ├─ /public.programasDeFormacion
│  ├─ /public.ofertasEducativas
│  └─ /public.redesDeConocimiento
│
├─ ADMIN DASHBOARD (❌ user | ✅ admin, SuperAdmin)
│  └─ /dashboard
│
├─ CRUD MODULES (❌ user | ✅ admin, SuperAdmin)
│  ├─ /centros/* (centros.*)
│  ├─ /competencias/* (competencias.*)
│  ├─ /historias_de_exito/* (historias_de_exito.*)
│  ├─ /instructores/* (instructores.*)
│  ├─ /niveles_formacion/* (niveles_formacion.*)
│  ├─ /ofertas/* (ofertas.*)
│  ├─ /programas/* (programas.*)
│  ├─ /redes_conocimiento/* (redes_conocimiento.*)
│  └─ /noticias/* (noticias.*)
│
├─ ADMIN PANEL (❌ user | ✅ admin, SuperAdmin)
│  ├─ /admin/users/* (users.*)
│  ├─ /admin/roles/* (roles.*)
│  └─ /admin/permissions/* (permissions.*)
│
└─ USER PROFILE (✅ authenticated)
   └─ /profile/* (profile.*)
```

---

## ✅ Checklist de Seguridad Implementada

- [x] Dashboard protegido con validación de rol
- [x] Menú de usuario muestra opciones según rol
- [x] Permiso 'dashboard.view' removido de rol 'user'
- [x] Rutas CRUD protegidas con middleware
- [x] Vistas públicas accesibles para usuarios autenticados
- [x] Validación unidireccional (entrada a CRUD protegida)
- [x] Policies implementadas para CRUD
- [x] Separación clara de módulos público vs administrativo

---

## 🚀 Siguientes Mejoras Recomendadas

1. **Implementar Middleware personalizado** para auditoría de accesos
2. **Rate limiting** en endpoints administrativos
3. **IP whitelisting** para acceso a panel admin
4. **Two-factor authentication** para admins
5. **Logs de auditoría** de cambios en BD
6. **CSRF tokens** en todos los formularios
7. **Validación de entrada** en todos los CRUD

---

**Última actualización:** 29/01/2026  
**Responsable:** Sistema de Seguridad SOE  
**Estado:** ✅ IMPLEMENTADO Y OPERACIONAL
