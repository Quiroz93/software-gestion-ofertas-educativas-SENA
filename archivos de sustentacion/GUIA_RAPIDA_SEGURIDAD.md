# 🔒 GUÍA RÁPIDA DE SEGURIDAD - SOE SENA

## 📍 Ubicaciones Clave del Sistema

### **Módulo Público (Accesible a todos autenticados)**
```
/home                              - Vista principal pública
/public.centrosFormacion           - Listado de centros
/public.ultimaNoticias             - Listado de noticias
/public.historiasDeExito           - Historias de éxito
/public.programasDeFormacion       - Programas disponibles
/public.ofertasEducativas          - Ofertas educativas
```

### **Módulo Administrativo (Solo admins)**
```
/dashboard                         - Panel de control (SOLO ADMIN)
/admin/users/*                     - Gestión de usuarios
/admin/roles/*                     - Gestión de roles
/admin/permissions/*               - Gestión de permisos
/centros/*                         - CRUD de centros
/competencias/*                    - CRUD de competencias
/programas/*                       - CRUD de programas
/ofertas/*                         - CRUD de ofertas
/noticias/*                        - CRUD de noticias
```

---

## 🛡️ Validación de Acceso Rápida

### **Para Proteger una Nueva Ruta/Recurso:**

#### Opción 1: Usar Rol (RECOMENDADO para cambios mayores)
```php
// En routes/web.php
Route::get('/admin/nuevo', [Controller::class, 'index'])
    ->middleware(['auth', 'verified', 'role:admin|SuperAdmin'])
    ->name('nuevo.index');
```

#### Opción 2: Usar Permiso (Para permisos granulares)
```php
// En routes/web.php
Route::get('/recurso/index', [Controller::class, 'index'])
    ->middleware(['auth', 'verified', 'can:recurso.view'])
    ->name('recurso.index');
```

#### Opción 3: Usar Policy (Para modelos)
```php
// En app/Policies/RecursoPolicy.php
public function viewAny(User $user): bool {
    return $user->can('recurso.view');
}

// En Controller
$this->authorize('viewAny', Recurso::class);
```

---

## ✅ Checklist para Nuevas Funcionalidades

Cuando agregues un nuevo módulo CRUD:

- [ ] **1. Crear permisos en BD o seeder**
  ```php
  'recurso.view', 'recurso.create', 'recurso.edit', 
  'recurso.update', 'recurso.delete', 'recurso.manage'
  ```

- [ ] **2. Asignar permisos al rol 'admin'**
  ```php
  $adminRole->givePermissionTo([
      'recurso.create', 'recurso.edit', 'recurso.update', 
      'recurso.delete', 'recurso.manage'
  ]);
  ```

- [ ] **3. NO asignar permisos de CRUD a rol 'user'**
  ```php
  // ❌ NO HAGAS ESTO
  $userRole->givePermissionTo('recurso.create');
  ```

- [ ] **4. Proteger rutas en routes/web.php**
  ```php
  Route::middleware(['auth', 'verified', 'can:recurso.view'])
      ->get('recurso/index', ...)->name('recurso.index');
  ```

- [ ] **5. Crear Policy**
  ```php
  php artisan make:policy RecursoPolicy --model=Recurso
  ```

- [ ] **6. Crear botón en vista**
  ```blade
  @can('recurso.create')
      <a href="{{ route('recurso.create') }}" class="btn btn-primary">
          Crear Recurso
      </a>
  @endcan
  ```

---

## 🚨 Errores Comunes y Cómo Prevenirlos

### Error 1: Asignar permisos CRUD a 'user'
```php
❌ INCORRECTO:
$userRole->givePermissionTo('programas.create');

✅ CORRECTO:
// No asignar, solo 'admin' puede crear
$adminRole->givePermissionTo('programas.create');
```

### Error 2: Usar @can() para Dashboard
```blade
❌ INCORRECTO:
@can('dashboard.view')
    <a href="/dashboard">Dashboard</a>
@endcan

✅ CORRECTO:
@if (Auth::user()->hasRole('admin') || Auth::user()->hasRole('SuperAdmin'))
    <a href="/dashboard">Dashboard</a>
@endif
```

### Error 3: Olvidar validación en ruta
```php
❌ INCORRECTO:
Route::get('/admin/datos', [Controller::class, 'index'])->name('datos');

✅ CORRECTO:
Route::get('/admin/datos', [Controller::class, 'index'])
    ->middleware(['auth', 'verified', 'role:admin|SuperAdmin'])
    ->name('datos');
```

### Error 4: Validación incompleta en Controller
```php
❌ INCORRECTO:
public function index() {
    // Sin validación
    return view('admin.index');
}

✅ CORRECTO:
public function index() {
    $this->authorize('viewAny', Recurso::class);
    return view('admin.index');
}
```

---

## 📊 Matriz de Permisos Rápida

### Rol 'user' (Usuario Público)
| Acción | Permiso | Acceso |
|--------|---------|--------|
| Ver programas | programas.view | ✅ |
| Crear programa | programas.create | ❌ |
| Ver ofertas | ofertas.view | ✅ |
| Crear oferta | ofertas.create | ❌ |
| Ver dashboard | dashboard.view | ❌ |

### Rol 'admin' (Administrador)
| Acción | Permiso | Acceso |
|--------|---------|--------|
| Ver programas | programas.view | ✅ |
| Crear programa | programas.create | ✅ |
| Editar programa | programas.edit | ✅ |
| Ver dashboard | dashboard.view | ✅ |
| Gestionar usuarios | users.manage | ✅ |
| TODO | * | ✅ |

---

## 🔍 Verificar Permisos de un Usuario

### En Tinker:
```php
$ php artisan tinker

# Ver todos los permisos de un usuario
>>> $user = App\Models\User::find(1);
>>> $user->getAllPermissions()->pluck('name');

# Ver roles
>>> $user->roles->pluck('name');

# Verificar si tiene permiso
>>> $user->hasPermissionTo('dashboard.view');

# Verificar si tiene rol
>>> $user->hasRole('admin');

# Agregar permiso
>>> $user->givePermissionTo('nuevo.permiso');
```

### En Código PHP:
```php
// Ver si usuario puede crear
if ($user->can('programas.create')) {
    // Hacer algo
}

// Usar en Controller
public function create() {
    $this->authorize('create', Programa::class);
}
```

---

## 🧪 Testing de Seguridad Rápido

### Verificar que usuario 'usuario publico' NO puede acceder a /dashboard:
```bash
# 1. Logearse como 'usuario publico'
# 2. URL: http://localhost/dashboard
# 3. Resultado esperado: 403 Forbidden
```

### Verificar que admin SÍ puede acceder a /dashboard:
```bash
# 1. Logearse como admin
# 2. URL: http://localhost/dashboard
# 3. Resultado esperado: Dashboard cargado
```

### Ejecutar validación de seguridad:
```bash
php artisan tinker < docs/security-validation.php
```

---

## 📚 Documentación Relacionada

| Documento | Ubicación | Propósito |
|-----------|-----------|----------|
| Arquitectura de Seguridad | `docs/ARQUITECTURA_SEGURIDAD.md` | Referencia completa |
| Testing | `docs/TESTING_SEGURIDAD.md` | Procedimientos de testing |
| Auditoría | `docs/RESUMEN_AUDITORIA_SEGURIDAD.md` | Resumen de cambios |
| Esta guía | `docs/GUIA_RAPIDA_SEGURIDAD.md` | Referencia rápida |

---

## 🎯 Resumen en Una Línea

> **Dashboard y CRUD = Admins SOLO. Vistas públicas = Todos autenticados.**

---

**Última actualización:** 29/01/2026  
**Versión:** 1.0  
**Status:** ✅ Operacional
