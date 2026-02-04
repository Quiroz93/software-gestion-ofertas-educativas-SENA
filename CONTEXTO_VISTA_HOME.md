# Contexto de la Vista HOME

## 📍 Ubicación
- **Archivo**: `resources/views/home.blade.php` (1169 líneas)
- **Backup**: `resources/views/home.blade.php.backup`
- **Layout**: Extiende `layouts.bootstrap`
- **Sección**: `@section('content')`

## 🎨 Estructura de la Página

### 1. **Sección de Bienvenida** (Líneas ~5-25)
- Título dinámico: `¡Bienvenido, {{ auth()->user()->name }}!`
- Subtítulo: "Accede a todos nuestros programas, ofertas y recursos de formación"
- Enlace a perfil: `route('profile.edit')`
- Clases Bootstrap: `container-fluid`, `display-5`, `fw-bold`

### 2. **Hero Section** (Líneas ~26-64)
**Contenido editable dinámico via `getCustomContent('home', ...)`:**

| Campo | Clave | Default | Tipo |
|-------|-------|---------|------|
| Fondo de Hero | `hero_background` | `images/background_1.png` | image |
| Título Hero | `hero_title` | "Bienvenido a nuestra plataforma de formación" | text |
| Descripción Hero | `hero_description` | "Descubre nuestros programas y oportunidades..." | text |

- **Características**:
  - Fondo con overlay (rgba(0,0,0,0.4))
  - Min-height: 400px
  - Contenido posicionado como `position-relative` con z-index
  - Botón "Explorar Programas" ancla a `#programas`
  - Elementos marcados con clase `editable` para edición en tiempo real

### 3. **Galería Carousel** (Líneas ~65-130)
**Bootstrap Carousel con 3 slides editables:**

| Slide | Imagen Key | Altura | Intervalo |
|-------|------------|--------|-----------|
| Slide 1 | `carousel_slide1_image` | 500px | 5000ms (auto) |
| Slide 2 | `carousel_slide2_image` | 500px | 5000ms (auto) |
| Slide 3 | `carousel_slide3_image` | 500px | 5000ms (auto) |

- **Controles**: Indicadores, navegación prev/next
- **Atributos Carousel**:
  - `data-bs-ride="carousel"` (autoplay)
  - `data-bs-interval="5000"` (cada 5 segundos)
  - `object-fit: cover`
  - Fallback para imágenes faltantes

### 4. **Posts Destacados** (Líneas ~131-197)
**2 tarjetas de artículos destacados (lado a lado)**

#### Post 1:
| Campo | Clave | Default |
|-------|-------|---------|
| Imagen | `post1_image` | (vacía) |
| Categoría (badge) | `post1_category` | "Noticia" |
| Título | `post1_title` | "Título del post" |
| Fecha | `post1_date` | "Enero 28, 2026" |
| Descripción | `post1_desc` | "Descripción del primer post..." |
| Botón | - | "Leer más" |

#### Post 2:
| Campo | Clave | Default |
|-------|-------|---------|
| Imagen | `post2_image` | (vacía) |
| Categoría (badge) | `post2_category` | "Ofertas" |
| Título | `post2_title` | "Título del post 2" |
| Fecha | `post2_date` | "Enero 28, 2026" |
| Descripción | `post2_desc` | "Descripción del segundo post..." |
| Botón | - | "Leer más" |

- **Estilos**: `col-md-6` (responsive), `card h-100 shadow-sm border-0`
- **Imagen**: 250px de altura, `object-fit: cover`

### 5. **Sección de Acceso Rápido (Tarjetas)** (Líneas ~198-278)
**ID**: `#programas` (punto de anclaje del hero)

Cuatro tarjetas principales con enlaces condicionales por permisos:

#### Tarjeta 1: Centros
```
Icono: bi-building (primario)
Título: getCustomContent('home', 'centros_title', 'Centros')
Descripción: getCustomContent('home', 'centros_description', 'Conoce nuestras sedes')
Enlaces:
  - Con permiso: route('centros.index')
  - Sin permiso: route('public.centrosFormacion.index')
```

#### Tarjeta 2: Programas
```
Icono: bi-journal-code (success)
Título: getCustomContent('home', 'programas_title', 'Programas')
Descripción: getCustomContent('home', 'programas_description', 'Formación profesional')
Enlaces:
  - Con permiso: route('programas.index')
  - Sin permiso: route('public.programasDeFormacion.index')
```

#### Tarjeta 3: Ofertas
```
Icono: bi-megaphone (warning)
Título: getCustomContent('home', 'ofertas_title', 'Ofertas')
Descripción: getCustomContent('home', 'ofertas_description', 'Oportunidades laborales')
Enlaces:
  - Con permiso: route('ofertas.index')
  - Sin permiso: route('public.ofertasEducativas.index')
```

#### Tarjeta 4: Noticias
```
Icono: bi-newspaper (danger)
Título: getCustomContent('home', 'noticias_title', 'Noticias')
Descripción: getCustomContent('home', 'noticias_description', 'Últimas novedades')
Enlaces:
  - Con permiso: route('noticias.index')
  - Sin permiso: route('public.ultimaNoticias.index')
```

- **Clases**: `col-md-3`, `transition`, `hover-shadow`
- **Interactividad**: Transform -5px al hover + shadow mejorada

### 6. **Sección CTA (Call To Action)** (Líneas ~279-289)
```
Fondo: bg-primary text-white
Título: "¿Necesitas ayuda?"
Subtítulo: "Nuestro equipo está listo para asistirte..."
Botón: Email a info@example.com
Clases: rounded-lg, p-5, text-center
```

### 7. **Estilos CSS Personalizados** (Líneas ~290-318)
```css
.transition { transition: all 0.3s ease; }

.hover-shadow:hover {
    box-shadow: 0 0.5rem 1.5rem rgba(0, 0, 0, 0.15) !important;
    transform: translateY(-5px);
}

.carousel-indicators [data-bs-target] {
    width: 12px;
    height: 12px;
    border-radius: 50%;
    background-color: rgba(255, 255, 255, 0.5);
    opacity: 0.7;
    transition: all 0.3s ease;
}

.carousel-indicators [data-bs-target].active {
    background-color: #fff;
    opacity: 1;
    transform: scale(1.2);
}
```

### 8. **Sección Duplicada: Carousel Alternativo** (Líneas ~319-382)
⚠️ **Nota**: Existe código duplicado del carousel con estructura diferente:
- ID: `#carouselExampleCaptions` (Inconsistencia con `#carouselHome` arriba)
- Incluye captions en cada slide:
  - `carousel_slide[1-3]_title`
  - `carousel_slide[1-3]_desc`
- Similar al primer carousel pero con captions adicionales

### 9. **Sección de Módulos/Información** (Líneas ~383-482)
**Título**: "Información y Módulos" (icono `fas fa-layer-group`)

Grid de 3 columnas (md) con tarjetas que incluyen:

1. **Centros** - Icono `bi-building`
2. **Programas** - Icono `bi-journal-bookmark`
3. **Ofertas** - Icono `bi-mortarboard`
4. **Noticias Dinámicas** - Loop sobre `$noticias` (variable pasada del controlador)
5. **Instructores** - Icono `fas fa-chalkboard-teacher`
6. **Historias de Éxito** - Icono `fas fa-book-open`
7. **Reconocimientos** - Icono `bi-award`

- **Contenido**: Cada tarjeta es editable via `getCustomContent()`
- **Clases**: `card h-100 shadow-sm border-0 text-center`

### 10. **Blog Section** (Líneas ~483-850)
**Título**: getCustomContent('home', 'blog_title', 'Blog Home Page')
**Descripción**: getCustomContent('home', 'blog_description', 'An example blog...')

#### Layout: 2 columnas
**Columna izquierda (col-md-8)**: Artículos
**Columna derecha (col-md-4)**: Sidebar sticky

#### Artículos (3 artículos principales):

**Article 1**:
```
Subtitle: getCustomContent('home', 'article1_subtitle', 'From the Firehose')
Título: article1_title
Meta: article1_meta
Párrafos: article1_parrafo1, article1_parrafo2
Blockquotes, listas, código de ejemplo
```

**Article 2**:
```
Título: article2_title
Meta: article2_meta
Contenido: article2_content
Blockquote: article2_quote
Contenido adicional: article2_additional_content[1-2]
Tabla de ejemplo con datos (Alice, Bob, Charlie)
```

**Article 3**:
```
Título: article3_title
Meta: article3_meta
Lista de items básicos
```

**Paginación**: Botones "Older" y "Newer"

#### Sidebar (position-sticky, top: 2rem):

1. **About Box** (bg-body-tertiary, text-success)
   - Título: `sidebar_about_title`
   - Texto: `sidebar_about_text`

2. **Recent Posts**
   - Título: `sidebar_recent_title`
   - 3 items con placeholder SVG (96x100%)

3. **Archives**
   - Título: `sidebar_archives_title`
   - Links a archivos (Marzo 2021 a Abril 2020)

4. **Elsewhere**
   - Título: `sidebar_elsewhere_title`
   - Links: GitHub, Social, Facebook

### 11. **Footer** (Líneas ~851-920)
**Clase**: `bg-light py-5`

Estructura en 4 columnas (col-md-3):

#### Columna 1: Centro
- Título: `footer_centro_title` (default: "Centro")
- Link 1: `footer_centro_link1` ("Sobre nosotros")
- Link 2: `footer_centro_link2` ("Programas")

#### Columna 2: Servicios
- Título: `footer_servicios_title` (default: "Servicios")
- Link 1: `footer_servicios_link1` ("Características")
- Link 2: `footer_servicios_link2` ("Información")

#### Columna 3: Recursos
- Título: `footer_recursos_title` (default: "Recursos")
- Link 1: `footer_recursos_link1` ("Blog")
- Link 2: `footer_recursos_link2` ("Centro de ayuda")

#### Columna 4: Contacto
- Título: `footer_contacto_title` (default: "Contactanos")
- Dirección: `footer_contacto_direccion` ("Cra. 11 No. 13-13")
- Teléfono: `footer_contacto_telefono` ("Linea de atención: 018000 910270")
- Email: `footer_contacto_email` ("Email: servicioalciudadano@sena.udu.co")

#### Fila inferior:
- Copyright: `footer_copyright` ("© 2026 SENA, Centro Agroempresarial...")
- Clases: `text-center text-muted border-top pt-3`

---

## 🔧 Sistema de Edición Editable

### Función Helper: `getCustomContent()`

**Ubicación**: `app/Helpers/helpers.php` (líneas 5-43)

**Firma**:
```php
function getCustomContent($modelName, $key, $default = null)
```

**Funcionamiento**:
1. Construye el nombre de la clase: `App\Models\[ModelName]`
2. Verifica que la clase existe
3. Busca en tabla `custom_contents`:
   ```sql
   SELECT * FROM custom_contents WHERE
     contentable_type = 'App\Models\Home',
     contentable_id = 0,
     key = '[key]'
   ```
4. Si encuentra contenido:
   - Valida archivos multimedia (image, video, gif)
   - Verifica que existan en `storage/public/media/`
   - Devuelve el valor o default si el archivo no existe
5. Si no encuentra: devuelve `$default`

### Atributos de Edición en HTML

Cada elemento editable tiene estos data-attributes:
```html
<element class="editable"
         data-model="home"
         data-model-id="0"
         data-key="[campo_key]"
         data-type="[text|image|video|gif]">
</element>
```

**Tipos soportados**:
- `text`: Texto simple
- `image`: Rutas a archivos de imagen
- `video`: Rutas a archivos de video
- `gif`: Rutas a archivos GIF

**Modelo**: Siempre `data-model="home"` en esta vista
**ID del Modelo**: Siempre `data-model-id="0"` (contenido global)

---

## 📊 Variables Pasadas del Controlador

### Variable requerida:
```php
$noticias  // Collection de noticias para loop en línea ~440
```

**Looped en**:
```blade
@foreach($noticias as $noticia)
    <div class="col-md-3">
        <h6>{{ $noticia->titulo }}</h6>
        <p>{{ Str::limit($noticia->descripcion, 90) }}</p>
    </div>
@endforeach
```

---

## 🔐 Validaciones de Permisos

La vista utiliza directivas `@can` para mostrar/ocultar enlaces según permisos:

| Elemento | Con Permiso | Sin Permiso |
|----------|------------|-----------|
| Centros | `route('centros.index')` | `route('public.centrosFormacion.index')` |
| Programas | `route('programas.index')` | `route('public.programasDeFormacion.index')` |
| Ofertas | `route('ofertas.index')` | `route('public.ofertasEducativas.index')` |
| Noticias | `route('noticias.index')` | `route('public.ultimaNoticias.index')` |
| Instructores | `route('instructores.index')` | `route('public.instructoresDeFormacion.index')` |
| Historias | `route('historias_de_exito.index')` | `route('public.historiasDeExito.index')` |

**Permisos verificados**:
- `centros.view`
- `programas.view`
- `ofertas.view`
- `noticias.view`
- `instructores.view`
- `historias_de_exito.view`

---

## ⚠️ Problemas Identificados

### 1. **Código Duplicado del Carousel** (Líneas 319-382)
- Existe un segundo carousel con ID diferente (`#carouselExampleCaptions`)
- Duplica funcionalidad del primer carousel (líneas 65-130)
- Genera confusión y puede causar conflictos de JS
- **Recomendación**: Eliminar duplicados o mantener solo uno

### 2. **Falta de Ruta en Reconocimientos**
```html
<a href=""><!-- VACÍA --></a>
```
- La sección "Reconocimientos" no tiene enlace activo
- **Recomendación**: Definir ruta o remover el enlace

### 3. **Inconsistencias en Nombres de Routes Públicas**
- `route('public.ultimaNoticias.index')` vs patrón general
- Usar camelCase consistente

### 4. **Placehold SVGs sin Edición**
- Algunas imágenes usan SVG placeholder genéricos
- No son editables ni dinámicos
- **Recomendación**: Integrar con sistema editable

---

## 🎯 Resumen Ejecutivo

La vista **home.blade.php** es un dashboard completo de landing page con:

✅ **Estructura modular** en 11 secciones principales
✅ **Sistema editable en tiempo real** para textos e imágenes
✅ **Bootstrap 5** para responsive design
✅ **Carousel automático** con 3 slides
✅ **Tarjetas informativas** con transiciones hover
✅ **Blog integrado** con 3 artículos y sidebar
✅ **Footer dinámico** con 4 columnas
✅ **Control de permisos** por rol de usuario
✅ **Noticias dinámicas** desde base de datos

**Archivo Total**: 1169 líneas de código Blade/HTML/CSS

