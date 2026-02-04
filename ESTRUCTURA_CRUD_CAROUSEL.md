# 📊 Estructura del CRUD Carousel - Árbol de Archivos

```
SoeSoftware2/
│
├── app/
│   └── Http/
│       └── Controllers/
│           └── Admin/
│               └── HomeCarouselController.php ✨ NEW
│                   ├── index()
│                   ├── create()
│                   ├── store()
│                   ├── edit()
│                   ├── update()
│                   ├── destroy()
│                   └── toggleActive()
│
├── resources/
│   ├── views/
│   │   ├── admin/
│   │   │   ├── dashboard.blade.php (MODIFICADO - tarjeta agregada)
│   │   │   └── home-carousel/ ✨ NEW FOLDER
│   │   │       ├── _form.blade.php (Formulario reutilizable)
│   │   │       ├── index.blade.php (Listado)
│   │   │       ├── create.blade.php (Crear)
│   │   │       └── edit.blade.php (Editar)
│   │   │
│   │   └── layouts/
│   │       └── bootstrap.blade.php
│   │
│   └── css/
│       └── public/
│           └── home.css (MODIFICADO - estilos agregados)
│
├── routes/
│   └── web.php (MODIFICADO - rutas agregadas)
│       └── Grupo: /admin/carousel
│           ├── GET    /carousel → index
│           ├── GET    /carousel/create → create
│           ├── POST   /carousel → store
│           ├── GET    /carousel/{id}/edit → edit
│           ├── PUT    /carousel/{id} → update
│           ├── DELETE /carousel/{id} → destroy
│           └── PATCH  /carousel/{id}/toggle-active → toggleActive
│
├── database/
│   └── migrations/
│       └── 2026_01_31_072326_create_home_carousels_table.php (Ya existe)
│
├── app/
│   └── Models/
│       └── HomeCarousel.php (Ya existe)
│
└── storage/
    └── app/
        └── public/
            └── carousel/ (Carpeta de imágenes - se crea automáticamente)
                ├── imagen1.jpg
                ├── imagen2.png
                └── ...

```

---

## 🔄 Flujo de Datos

### Crear Slide
```
Usuario → Click "Crear" 
   ↓
GET /admin/carousel/create
   ↓
HomeCarouselController@create() 
   ↓
create.blade.php (incluye _form.blade.php)
   ↓
Usuario completa formulario
   ↓
POST /admin/carousel
   ↓
HomeCarouselController@store()
   ├─ Validación
   ├─ Almacena imagen en storage/public/carousel
   ├─ Crea registro en BD
   └─ Redirecciona con mensaje
   ↓
Retorna a GET /admin/carousel (index)
```

### Editar Slide
```
Usuario → Click "Editar" 
   ↓
GET /admin/carousel/{id}/edit
   ↓
HomeCarouselController@edit()
   ↓
edit.blade.php (incluye _form.blade.php con datos)
   ↓
Usuario modifica formulario
   ↓
PUT /admin/carousel/{id}
   ↓
HomeCarouselController@update()
   ├─ Validación
   ├─ Elimina imagen antigua si es necesario
   ├─ Almacena nueva imagen
   ├─ Actualiza registro en BD
   └─ Redirecciona con mensaje
   ↓
Retorna a GET /admin/carousel (index)
```

### Toggle Estado (AJAX)
```
Usuario → Toggle checkbox "Activo/Inactivo"
   ↓
JavaScript detecta cambio
   ↓
PATCH /admin/carousel/{id}/toggle-active
   ↓
HomeCarouselController@toggleActive()
   ├─ Cambia estado (is_active)
   └─ Retorna JSON { success: true, is_active: boolean }
   ↓
JavaScript actualiza badge (sin recargar)
```

### Eliminar Slide
```
Usuario → Click "Eliminar"
   ↓
Confirmación del navegador
   ↓
DELETE /admin/carousel/{id}
   ↓
HomeCarouselController@destroy()
   ├─ Obtiene slide
   ├─ Elimina imagen del storage
   ├─ Elimina registro de BD
   └─ Redirecciona con mensaje
   ↓
Retorna a GET /admin/carousel (index)
```

---

## 🎯 Mapeo de Métodos HTTP

| Método | Ruta | Controlador | Acción |
|--------|------|-------------|--------|
| GET | `/admin/carousel` | HomeCarouselController | `index()` |
| GET | `/admin/carousel/create` | HomeCarouselController | `create()` |
| POST | `/admin/carousel` | HomeCarouselController | `store()` |
| GET | `/admin/carousel/{id}/edit` | HomeCarouselController | `edit()` |
| PUT | `/admin/carousel/{id}` | HomeCarouselController | `update()` |
| DELETE | `/admin/carousel/{id}` | HomeCarouselController | `destroy()` |
| PATCH | `/admin/carousel/{id}/toggle-active` | HomeCarouselController | `toggleActive()` |

---

## 📁 Estructura de Directorios en Storage

```
storage/
└── app/
    └── public/
        ├── carousel/ ← Carpeta de imágenes del carousel
        │   ├── eF9k3M2l9pQ.jpg
        │   ├── sL8mN4oP2r.png
        │   └── ...
        │
        └── otros contenidos...
```

**Permisos necesarios:**
```bash
chmod -R 755 storage/app/public
chmod -R 755 storage/app/public/carousel
```

---

## 🗄️ Estructura de Datos (BD)

### Tabla: `home_carousels`

```sql
CREATE TABLE home_carousels (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    title VARCHAR(255) NOT NULL,
    description TEXT NULL,
    image_path VARCHAR(255) NULL,
    button_text VARCHAR(100) NULL,
    button_url VARCHAR(255) NULL,
    is_active BOOLEAN DEFAULT 1,
    position INT DEFAULT 0,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL
);
```

**Índices:**
- `PRIMARY KEY (id)`
- `INDEX (is_active)` - Para queries públicas
- `INDEX (position, is_active)` - Para ordenamiento

---

## 🔗 Relaciones

```
HomeCarousel (Modelo)
├─ No tiene relaciones directas actualmente
├─ Podría relacionarse con User (creador)
└─ Podría tener adjuntos multimedia
```

---

## 📋 Validaciones

### En Store
```php
$validated = $request->validate([
    'title' => 'required|string|max:255',
    'description' => 'nullable|string|max:500',
    'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    'button_text' => 'nullable|string|max:100',
    'button_url' => 'nullable|url|max:255',
    'position' => 'required|integer|min:0',
    'is_active' => 'boolean',
]);
```

### En Update
```php
$validated = $request->validate([
    'title' => 'required|string|max:255',
    'description' => 'nullable|string|max:500',
    'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    'button_text' => 'nullable|string|max:100',
    'button_url' => 'nullable|url|max:255',
    'position' => 'required|integer|min:0',
    'is_active' => 'boolean',
]);
```

---

## 🎨 Vistas y sus Componentes

### index.blade.php
```
Header (Título + Botones)
├─ Título: "Gestión de Carousel"
├─ Botón: "Crear nuevo slide"
└─ Botón: "Volver"

Alertas (Sesión)
├─ Success
└─ Error

Tabla
├─ Columnas: ID, Imagen, Título, Estado, Orden, Acciones
├─ Rows: Slides del DB
├─ Acciones: Edit, Delete
└─ Toggle: Activo/Inactivo (AJAX)

Form (Oculto)
└─ Para DELETE
```

### create.blade.php
```
Header
├─ Título: "Crear nuevo slide"
└─ Descripción

Card
└─ _form.blade.php (nuevo = false)
```

### edit.blade.php
```
Header
├─ Título: "Editar slide"
└─ Muestra título del slide

Card
└─ _form.blade.php (nuevo = true)
```

### _form.blade.php
```
Formulario
├─ CSRF Token
├─ Method (POST o PUT)
├─ Enctype: multipart/form-data
└─ Campos:
    ├─ Title (required)
    ├─ Description (optional, contador)
    ├─ Image (optional, preview)
    ├─ Button Text (optional)
    ├─ Button URL (optional)
    ├─ Position (required)
    ├─ Is Active (checkbox)
    └─ Botones: Cancelar, Guardar
```

---

## ✅ Checklist de Deployment

- [ ] `php artisan migrate` ✓
- [ ] `php artisan storage:link` ✓
- [ ] Carpeta storage con permisos 755 ✓
- [ ] CSRF token en .env ✓
- [ ] APP_URL configurada ✓
- [ ] Autenticación funcional ✓
- [ ] Bootstrap CSS enlazado ✓
- [ ] Bootstrap Icons enlazado ✓
- [ ] Work Sans font enlazado ✓
- [ ] Probar crear slide ✓
- [ ] Probar editar slide ✓
- [ ] Probar eliminar slide ✓
- [ ] Probar toggle estado ✓
- [ ] Verificar slides en home público ✓

---

## 🚀 URLs de Acceso Rápido

| Acción | URL |
|--------|-----|
| Listado | `/admin/carousel` |
| Crear | `/admin/carousel/create` |
| Editar | `/admin/carousel/{id}/edit` |
| Dashboard | `/admin/dashboard` |
| Home Público | `/` |

---

## 📊 Estadísticas Finales

- **Controlador:** 135 líneas
- **Vistas:** ~500 líneas totales
- **Rutas:** 7 registradas
- **Campos:** 8 en BD
- **Validaciones:** 7 reglas
- **Archivos creados:** 7
- **Archivos modificados:** 2
- **Documentación:** 3 archivos

---

*Estructura completamente modular, escalable y mantenible.*
