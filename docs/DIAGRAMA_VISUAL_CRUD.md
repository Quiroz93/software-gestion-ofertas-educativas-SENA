# 📊 Diagrama Visual - CRUD Carousel del Home

## 🏗️ Arquitectura General

```
┌─────────────────────────────────────────────────────────┐
│                 ADMIN - CAROUSEL DEL HOME                │
└─────────────────────────────────────────────────────────┘

┌──────────────────────────────────────────────────────────┐
│                    USUARIO ADMIN                         │
│                  (Autenticado en /admin)                 │
└──────────────────┬───────────────────────────────────────┘
                   │
                   ├─────── Dashboard
                   │        ├─ Ver tarjeta "Carousel"
                   │        └─ Click → /admin/carousel
                   │
                   ├─────── Index
                   │        ├─ GET /admin/carousel
                   │        ├─ Tabla de slides
                   │        ├─ Toggle activo/inactivo (AJAX)
                   │        └─ Botones Editar/Eliminar
                   │
                   ├─────── Create
                   │        ├─ GET /admin/carousel/create
                   │        ├─ Formulario vacío
                   │        └─ POST /admin/carousel (store)
                   │
                   ├─────── Edit
                   │        ├─ GET /admin/carousel/{id}/edit
                   │        ├─ Formulario con datos
                   │        └─ PUT /admin/carousel/{id} (update)
                   │
                   └─────── Delete
                            ├─ DELETE /admin/carousel/{id}
                            └─ Confirmar → Eliminar

```

---

## 📂 Flujo de Archivos

```
REQUEST (HTTP)
   │
   ├─ Router (routes/web.php)
   │  └─ Encuentra la ruta coincidente
   │
   ├─ Controlador (HomeCarouselController.php)
   │  ├─ Valida input
   │  ├─ Interactúa con BD (HomeCarousel Model)
   │  └─ Retorna Response
   │
   ├─ Vista (Blade)
   │  ├─ home-carousel/index.blade.php
   │  ├─ home-carousel/create.blade.php
   │  ├─ home-carousel/edit.blade.php
   │  └─ home-carousel/_form.blade.php
   │
   ├─ Estilos (CSS)
   │  └─ resources/css/public/home.css
   │
   ├─ Scripts (JavaScript)
   │  ├─ Preview de imágenes
   │  ├─ Toggle AJAX
   │  ├─ Validación
   │  └─ Confirmaciones
   │
   └─ Almacenamiento (Storage)
      └─ storage/app/public/carousel/
         ├─ imagen1.jpg
         ├─ imagen2.png
         └─ ...

RESPONSE (HTML/JSON)
   └─ Retorna al navegador
```

---

## 🔄 Ciclo de Vida de un Slide

```
CREAR SLIDE
┌─────────────────┐
│   Usuario hace  │
│ click en "Crear"│
└────────┬────────┘
         │
         ▼
┌─────────────────────┐
│ GET /admin/carousel │
│       /create       │
└────────┬────────────┘
         │
         ▼
┌─────────────────────────────┐
│ HomeCarouselController@      │
│ create()                    │
│ ├─ Retorna vista create     │
│ └─ Incluye _form.blade.php  │
└────────┬────────────────────┘
         │
         ▼
┌─────────────────────────────┐
│   Formulario (create.blade) │
│  ├─ Title (required)        │
│  ├─ Description (optional)  │
│  ├─ Image (optional)        │
│  ├─ Button Text/URL         │
│  ├─ Position (required)     │
│  └─ Is Active (checkbox)    │
└────────┬────────────────────┘
         │
         ▼
┌─────────────────────┐
│   Usuario completa  │
│   y envía form      │
└────────┬────────────┘
         │
         ▼
┌──────────────────────────────┐
│ POST /admin/carousel         │
│ {title, description, ...}    │
└────────┬─────────────────────┘
         │
         ▼
┌──────────────────────────────┐
│ HomeCarouselController@store │
│ ├─ Valida datos             │
│ ├─ Almacena imagen (storage)│
│ ├─ Crea registro (BD)       │
│ └─ Redirecciona con mensaje │
└────────┬─────────────────────┘
         │
         ▼
┌──────────────────────────────┐
│ GET /admin/carousel          │
│ (Redirección + Mensaje)      │
└────────┬─────────────────────┘
         │
         ▼
┌──────────────────────────────┐
│ ✅ Slide creado correctamente│
│ └─ Aparece en tabla          │
└──────────────────────────────┘
```

---

## 🎯 Matriz de Funciones

```
┌──────────────┬────────────────┬──────────────┬──────────────┐
│   Acción     │   Método HTTP  │     Ruta     │  Controlador │
├──────────────┼────────────────┼──────────────┼──────────────┤
│ Listar       │      GET       │ /carousel    │   index()    │
├──────────────┼────────────────┼──────────────┼──────────────┤
│ Crear Form   │      GET       │ /carousel    │   create()   │
│              │                │ /create      │              │
├──────────────┼────────────────┼──────────────┼──────────────┤
│ Guardar      │      POST      │ /carousel    │   store()    │
├──────────────┼────────────────┼──────────────┼──────────────┤
│ Editar Form  │      GET       │ /carousel    │   edit()     │
│              │                │ /{id}/edit   │              │
├──────────────┼────────────────┼──────────────┼──────────────┤
│ Actualizar   │      PUT       │ /carousel    │   update()   │
│              │                │ /{id}        │              │
├──────────────┼────────────────┼──────────────┼──────────────┤
│ Eliminar     │     DELETE     │ /carousel    │   destroy()  │
│              │                │ /{id}        │              │
├──────────────┼────────────────┼──────────────┼──────────────┤
│ Toggle       │     PATCH      │ /carousel    │ toggleActive│
│ Activo       │                │ /{id}/toggle │   ()        │
│              │                │ -active      │              │
└──────────────┴────────────────┴──────────────┴──────────────┘
```

---

## 💾 Almacenamiento de Datos

```
BASE DE DATOS
┌──────────────────────────────────────┐
│      home_carousels (Tabla)          │
├──────────────────────────────────────┤
│ id             (PK, auto-increment)  │
│ title          (string, required)    │
│ description    (text, nullable)      │
│ image_path     (string, nullable)    │
│ button_text    (string, nullable)    │
│ button_url     (string, nullable)    │
│ is_active      (boolean, default:1)  │
│ position       (integer, default:0)  │
│ created_at     (timestamp)           │
│ updated_at     (timestamp)           │
└──────────────────────────────────────┘

ALMACENAMIENTO DE ARCHIVOS
┌──────────────────────────────────────┐
│    storage/app/public/carousel/      │
├──────────────────────────────────────┤
│ eF9k3M2l9pQ.jpg    → Slide 1        │
│ sL8mN4oP2r.png     → Slide 2        │
│ zX1aB5cD3e.gif     → Slide 3        │
│ ...                                  │
└──────────────────────────────────────┘
```

---

## 🎨 Capas de la Aplicación

```
┌─────────────────────────────────────────────┐
│         PRESENTACIÓN (Blade)                 │
│  ├─ index.blade.php (Tabla)                 │
│  ├─ create.blade.php (Formulario)           │
│  ├─ edit.blade.php (Formulario)             │
│  ├─ _form.blade.php (Componente)            │
│  └─ CSS + JavaScript                        │
└─────────────────────────────────────────────┘
           ▲
           │
┌─────────────────────────────────────────────┐
│         CONTROL (Controller)                 │
│   HomeCarouselController                    │
│  ├─ Validación de input                     │
│  ├─ Lógica de negocio                       │
│  ├─ Gestión de archivos                     │
│  └─ Respuestas HTTP                         │
└─────────────────────────────────────────────┘
           ▲
           │
┌─────────────────────────────────────────────┐
│    MODELO & DATOS (Model/DB)                │
│   HomeCarousel Model                        │
│  ├─ Propiedades $fillable                   │
│  ├─ Relaciones (si aplica)                  │
│  └─ Métodos customizados                    │
└─────────────────────────────────────────────┘
           ▲
           │
┌─────────────────────────────────────────────┐
│      ALMACENAMIENTO (Storage)                │
│  ├─ Base de Datos (MySQL)                   │
│  └─ Sistema de Archivos (Images)            │
└─────────────────────────────────────────────┘
```

---

## 🔐 Seguridad en Capas

```
┌────────────────────────────────┐
│   CAPA 1: Autenticación        │
│   middleware(['auth'])         │
│   ✓ Usuario debe estar logueado│
└────────────┬───────────────────┘
             │
┌────────────▼───────────────────┐
│   CAPA 2: CSRF Protection      │
│   @csrf en formularios         │
│   ✓ Previene ataques CSRF      │
└────────────┬───────────────────┘
             │
┌────────────▼───────────────────┐
│   CAPA 3: Validación Input     │
│   $request->validate([...])    │
│   ✓ Valida tipos y rangos      │
└────────────┬───────────────────┘
             │
┌────────────▼───────────────────┐
│   CAPA 4: Sanitización Archivos│
│   mime:jpeg,png,jpg,gif        │
│   ✓ Solo formatos permitidos   │
└────────────┬───────────────────┘
             │
┌────────────▼───────────────────┐
│   CAPA 5: Gestión Segura       │
│   Storage::disk('public')      │
│   ✓ Rutas seguras y aisladas   │
└────────────────────────────────┘
```

---

## 🚀 Flujo de Petición Completo

```
1. Usuario escribe URL
   └─ http://localhost/admin/carousel

2. Petición HTTP llega a Laravel
   └─ GET /admin/carousel

3. Router evalúa las rutas
   └─ Coincide: admin.home-carousel.index

4. Middleware valida
   └─ ✓ Autenticado
   └─ ✓ CSRF token válido

5. Controlador procesa
   └─ HomeCarouselController@index()
   └─ SELECT * FROM home_carousels ORDER BY position

6. Datos van a la vista
   └─ resources/views/admin/home-carousel/index.blade.php

7. Blade renderiza HTML
   └─ Genera tabla con slides
   └─ Agrega CSS y JavaScript

8. Navegador recibe HTML
   └─ Renderiza en la pantalla
   └─ Descarga CSS/JS/Imágenes

9. Usuario ve la tabla
   └─ Puede interactuar
   └─ Editar, eliminar, toggle, etc.
```

---

## 📱 Responsividad

```
DESKTOP (1200px+)
├─ Tabla completa
├─ 6 columnas visibles
└─ Texto completo

TABLET (768px - 1199px)
├─ Tabla adaptada
├─ Algunas columnas ocultas
└─ Botones compactos

MÓVIL (< 768px)
├─ Tabla scrolleable
├─ Columnas principales
└─ Botones como iconos
```

---

## ✅ Checklist de Estados

```
SLIDE PUEDE ESTAR EN:
├─ ✓ ACTIVO
│  └─ Aparece en home público
│
└─ ✗ INACTIVO
   └─ No aparece en home público
      (pero no se elimina)

IMAGEN PUEDE ESTAR EN:
├─ storage/public/carousel/
│  └─ Accesible públicamente
│
└─ Sin imagen
   └─ Usa fallback/placeholder
```

---

## 🎯 Puntos de Integración

Para integrar los slides en el home público:

```php
// 1. En HomeController
public function __invoke()
{
    $slides = HomeCarousel::where('is_active', true)
        ->orderBy('position')
        ->get();
    
    return view('public.home', compact('slides'));
}

// 2. En la vista
@foreach($slides as $slide)
    <div class="carousel-item">
        <img src="{{ asset('storage/' . $slide->image_path) }}">
        <h2>{{ $slide->title }}</h2>
    </div>
@endforeach
```

---

## 📊 Resumen Visual

```
┌─────────────────────────────────────────────────────┐
│              CRUD CAROUSEL DEL HOME                  │
├─────────────────────────────────────────────────────┤
│                                                      │
│  7 MÉTODOS DEL CONTROLADOR                          │
│  ├─ index()      : Listar todos                     │
│  ├─ create()     : Formulario crear                 │
│  ├─ store()      : Guardar nuevo                    │
│  ├─ edit()       : Formulario editar                │
│  ├─ update()     : Guardar cambios                  │
│  ├─ destroy()    : Eliminar                         │
│  └─ toggleActive : Cambiar estado                   │
│                                                      │
│  4 VISTAS BLADE                                      │
│  ├─ index        : Tabla administrativa             │
│  ├─ create       : Formulario crear                 │
│  ├─ edit         : Formulario editar                │
│  └─ _form        : Componente reutilizable          │
│                                                      │
│  8 CAMPOS DE BD                                      │
│  ├─ id, title, description, image_path             │
│  ├─ button_text, button_url                        │
│  ├─ is_active, position                            │
│  └─ created_at, updated_at                         │
│                                                      │
│  7 RUTAS HTTP                                        │
│  ├─ GET    /carousel           → index             │
│  ├─ GET    /carousel/create    → create            │
│  ├─ POST   /carousel           → store             │
│  ├─ GET    /carousel/{id}/edit → edit              │
│  ├─ PUT    /carousel/{id}      → update            │
│  ├─ DELETE /carousel/{id}      → destroy           │
│  └─ PATCH  /carousel/{id}/...  → toggleActive      │
│                                                      │
└─────────────────────────────────────────────────────┘
```

---

*Diagrama visual del CRUD Carousel - SENA 2026*
