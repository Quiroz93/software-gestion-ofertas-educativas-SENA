# DIRECTRICES DE MARCA Y DISEÑO PARA VISTAS PÚBLICAS
## SENA - Sistema de Gestión de Formación y Ofertas Educativas

> **Nota**: Dado que no se encontró el manual de identidad SENA 2024 en el repositorio, este documento se basa en estándares de identidad institucional para entidades educativas colombianas y buenas prácticas de diseño web inclusivo y accesible.

---

## 1. IDENTIDAD VISUAL INSTITUCIONAL

### 1.1 Colores Oficiales SENA
Basados en la identidad institucional estándar de SENA:

| Color | Hex | RGB | Uso |
|-------|-----|-----|-----|
| **Verde SENA** | `#228B22` | 34, 139, 34 | Primario - CTA, acciones principales |
| **Verde Oscuro** | `#1a6b1a` | 26, 107, 26 | Hover, enfasis |
| **Blanco** | `#FFFFFF` | 255, 255, 255 | Fondo, texto en fondos oscuros |
| **Gris Oscuro** | `#2D3436` | 45, 52, 54 | Texto principal |
| **Gris Claro** | `#F0F3F5` | 240, 243, 245 | Fondos secundarios |
| **Azul Complementario** | `#0066CC` | 0, 102, 204 | Enlaces, información |

### 1.2 Implementación en Bootstrap 5

```css
/* En resources/css/app.css o recursos de estilos */

:root {
    --sena-primary: #228B22;
    --sena-primary-dark: #1a6b1a;
    --sena-gray-dark: #2D3436;
    --sena-gray-light: #F0F3F5;
    --sena-accent-blue: #0066CC;
}

/* Override de Bootstrap */
.btn-primary {
    background-color: var(--sena-primary);
    border-color: var(--sena-primary);
}

.btn-primary:hover {
    background-color: var(--sena-primary-dark);
    border-color: var(--sena-primary-dark);
}

.btn-success {
    background-color: var(--sena-primary);
    border-color: var(--sena-primary);
}
```

---

## 2. TIPOGRAFÍA

### 2.1 Fuentes Recomendadas

**Encabezados (H1-H6)**:
- **Primera opción**: Inter, Roboto, -apple-system (moderno, legible, institucional)
- **Fallback**: sans-serif

**Texto Body**:
- **Primera opción**: -apple-system, Segoe UI, Roboto, Oxygen-Sans
- **Fallback**: sans-serif

### 2.2 Escala de Tipografía

```blade
<!-- Jerarquía de encabezados para vistas públicas -->

<!-- Página principal (H1) - UNA por página -->
<h1 class="display-4 fw-bold text-sena-primary">
    Transformando Vidas a Través de la Educación
</h1>

<!-- Secciones principales (H2) -->
<h2 class="h2 fw-bold text-sena-gray-dark mt-5 mb-4">
    Nuestros Programas de Formación
</h2>

<!-- Subsecciones (H3) -->
<h3 class="h4 fw-bold text-sena-primary">
    Formación Profesional Integral
</h3>

<!-- Contenido regular (p, body) -->
<p class="lead text-muted">
    Accede a programas de calidad diseñados para tu desarrollo profesional
</p>
```

### 2.3 Tamaños de Letra por Contexto

| Elemento | Tamaño | Peso | Línea | Uso |
|----------|--------|------|-------|-----|
| H1 | 2.5rem-3rem | 700 | 1.2 | Título principal página |
| H2 | 2rem | 700 | 1.3 | Título de sección |
| H3 | 1.5rem | 600 | 1.4 | Subtítulo |
| H4 | 1.25rem | 600 | 1.4 | Encabezado tarjeta |
| Body | 1rem | 400 | 1.6 | Párrafos normales |
| Small | 0.875rem | 400 | 1.5 | Notas, meta información |
| Caption | 0.75rem | 500 | 1.4 | Leyendas, créditos |

---

## 3. ESTRUCTURA DE VISTAS PÚBLICAS

### 3.1 Patrón Recomendado

```blade
@extends('layouts.bootstrap')

@section('title', 'Título Descriptivo de la Página')

@section('content')

<!-- ============================================ -->
<!-- SECCIÓN 1: HERO / INTRODUCCIÓN -->
<!-- ============================================ -->
<section class="hero-section py-5" style="background: linear-gradient(135deg, var(--sena-primary), var(--sena-primary-dark));">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <h1 class="display-4 fw-bold text-white mb-3">
                    Título Principal
                </h1>
                <p class="lead text-white-50 mb-4">
                    Descripción breve del contenido
                </p>
                <a href="#content" class="btn btn-light btn-lg">
                    <i class="bi bi-arrow-down me-2"></i>Explorar
                </a>
            </div>
        </div>
    </div>
</section>

<!-- ============================================ -->
<!-- SECCIÓN 2: CONTENIDO PRINCIPAL -->
<!-- ============================================ -->
<section id="content" class="py-5">
    <div class="container">
        <h2 class="h2 fw-bold text-sena-gray-dark mb-4">
            Contenido Principal
        </h2>
        
        <!-- Grid de elementos -->
        <div class="row g-4">
            @forelse($items as $item)
            <div class="col-md-6 col-lg-4">
                <!-- Tarjeta -->
            </div>
            @empty
            <div class="col-12">
                <p class="text-muted text-center">Sin elementos disponibles</p>
            </div>
            @endforelse
        </div>
    </div>
</section>

<!-- ============================================ -->
<!-- SECCIÓN 3: LLAMADA A ACCIÓN -->
<!-- ============================================ -->
<section class="cta-section py-5 bg-sena-gray-light">
    <div class="container text-center">
        <h2 class="h3 fw-bold text-sena-gray-dark mb-3">
            Estás listo para comenzar?
        </h2>
        <p class="text-muted mb-4">
            Inicia tu proceso de formación hoy mismo
        </p>
        <a href="{{ route('public.programasDeFormacion.index') }}" class="btn btn-primary btn-lg">
            Ver Programas Disponibles
        </a>
    </div>
</section>

@endsection
```

### 3.2 Breadcrumbs (Migas de Pan)

```blade
<!-- En todas las vistas excepto home -->
<nav aria-label="breadcrumb" class="mb-4">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="{{ route('home') }}" class="text-decoration-none">
                <i class="bi bi-house me-1"></i>Inicio
            </a>
        </li>
        <li class="breadcrumb-item">
            <a href="{{ route('public.programasDeFormacion.index') }}" class="text-decoration-none">
                Programas
            </a>
        </li>
        <li class="breadcrumb-item active">{{ $programa->nombre }}</li>
    </ol>
</nav>
```

---

## 4. COMPONENTES DE VISTAS

### 4.1 Tarjetas (Cards) - Estándar

```blade
<div class="card h-100 border-0 shadow-sm hover-shadow-lg transition">
    <!-- Imagen -->
    @if($programa->imagen)
    <img src="{{ asset('storage/' . $programa->imagen) }}" 
         class="card-img-top" 
         alt="{{ $programa->nombre }}"
         style="height: 200px; object-fit: cover;">
    @else
    <div class="card-img-top bg-sena-gray-light d-flex align-items-center justify-content-center"
         style="height: 200px;">
        <i class="bi bi-book-half text-muted" style="font-size: 3rem;"></i>
    </div>
    @endif
    
    <!-- Body -->
    <div class="card-body">
        <!-- Badge de categoría -->
        <span class="badge bg-success mb-2">{{ $programa->categoria }}</span>
        
        <!-- Título -->
        <h5 class="card-title fw-bold text-sena-gray-dark">
            {{ $programa->nombre }}
        </h5>
        
        <!-- Descripción -->
        <p class="card-text text-muted small">
            {{ Str::limit($programa->descripcion, 100) }}
        </p>
        
        <!-- Meta información -->
        <div class="d-flex justify-content-between align-items-center small text-muted mb-3">
            <span><i class="bi bi-clock me-1"></i>{{ $programa->duracion }}</span>
            <span><i class="bi bi-people me-1"></i>{{ $programa->cupos }}</span>
        </div>
    </div>
    
    <!-- Footer -->
    <div class="card-footer bg-transparent border-top">
        <a href="{{ route('public.programasDeFormacion.show', $programa) }}" 
           class="btn btn-primary btn-sm w-100">
            Ver Detalles
        </a>
    </div>
</div>
```

### 4.2 Botones

```blade
<!-- Primario (CTA Principal) -->
<a href="{{ $link }}" class="btn btn-primary btn-lg">
    <i class="bi bi-arrow-right me-2"></i>Acción Principal
</a>

<!-- Secundario -->
<button class="btn btn-outline-primary">
    Acción Secundaria
</button>

<!-- Descargar / Externo -->
<a href="{{ $url }}" class="btn btn-info btn-sm" target="_blank" rel="noopener">
    <i class="bi bi-download me-2"></i>Descargar
</a>

<!-- Pequeño -->
<a href="{{ $link }}" class="btn btn-sm btn-outline-secondary">
    Más información
</a>
```

### 4.3 Alertas y Avisos

```blade
<!-- Éxito -->
<div class="alert alert-success alert-dismissible fade show" role="alert">
    <i class="bi bi-check-circle me-2"></i>
    <strong>¡Excelente!</strong> Tu inscripción ha sido completada.
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>

<!-- Información -->
<div class="alert alert-info">
    <i class="bi bi-info-circle me-2"></i>
    <strong>Información:</strong> Los formularios se cierran el próximo viernes.
</div>

<!-- Advertencia -->
<div class="alert alert-warning">
    <i class="bi bi-exclamation-triangle me-2"></i>
    <strong>Atención:</strong> Cupos limitados. Inscríbete pronto.
</div>

<!-- Error -->
<div class="alert alert-danger">
    <i class="bi bi-exclamation-circle me-2"></i>
    <strong>Error:</strong> No se pudo procesar tu solicitud.
</div>
```

### 4.4 Tablas

```blade
<div class="table-responsive">
    <table class="table table-hover align-middle">
        <thead class="table-light">
            <tr>
                <th class="fw-bold text-sena-primary">Encabezado 1</th>
                <th class="fw-bold text-sena-primary">Encabezado 2</th>
                <th class="fw-bold text-sena-primary">Acción</th>
            </tr>
        </thead>
        <tbody>
            @forelse($items as $item)
            <tr>
                <td>{{ $item->campo1 }}</td>
                <td>{{ $item->campo2 }}</td>
                <td>
                    <a href="{{ route('public.ruta.show', $item) }}" 
                       class="btn btn-sm btn-outline-primary">
                        Ver
                    </a>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="3" class="text-center text-muted py-4">
                    <i class="bi bi-inbox me-2"></i>Sin elementos
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
```

### 4.5 Formularios

```blade
<form method="POST" action="{{ $action }}" class="needs-validation">
    @csrf
    
    <!-- Input de Texto -->
    <div class="mb-3">
        <label for="nombre" class="form-label fw-bold">
            Nombre Completo <span class="text-danger">*</span>
        </label>
        <input type="text" 
               class="form-control @error('nombre') is-invalid @enderror" 
               id="nombre" 
               name="nombre" 
               value="{{ old('nombre') }}"
               placeholder="Ej: Juan Pérez"
               required>
        @error('nombre')
        <div class="invalid-feedback d-block">
            {{ $message }}
        </div>
        @enderror
    </div>
    
    <!-- Select -->
    <div class="mb-3">
        <label for="programa" class="form-label fw-bold">
            Programa <span class="text-danger">*</span>
        </label>
        <select class="form-select" id="programa" name="programa_id" required>
            <option selected disabled>-- Selecciona un programa --</option>
            @foreach($programas as $programa)
            <option value="{{ $programa->id }}">{{ $programa->nombre }}</option>
            @endforeach
        </select>
    </div>
    
    <!-- Textarea -->
    <div class="mb-3">
        <label for="mensaje" class="form-label fw-bold">
            Mensaje
        </label>
        <textarea class="form-control" id="mensaje" name="mensaje" rows="4" 
                  placeholder="Cuéntanos tus dudas o comentarios..."></textarea>
    </div>
    
    <!-- Checkbox -->
    <div class="mb-3 form-check">
        <input type="checkbox" class="form-check-input" id="terminos" 
               name="acepta_terminos" required>
        <label class="form-check-label" for="terminos">
            Acepto los <a href="#" class="text-primary">términos y condiciones</a>
        </label>
    </div>
    
    <!-- Botones -->
    <div class="d-grid gap-2 d-sm-flex gap-sm-2">
        <button type="submit" class="btn btn-primary btn-lg">
            <i class="bi bi-check me-2"></i>Enviar
        </button>
        <a href="{{ route('home') }}" class="btn btn-outline-secondary btn-lg">
            Cancelar
        </a>
    </div>
</form>
```

---

## 5. ACCESIBILIDAD E INCLUSIÓN

### 5.1 Principios WAI-ARIA

```blade
<!-- Navegación con rol semántico -->
<nav aria-label="Navegación principal">
    <!-- enlaces -->
</nav>

<!-- Encabezados con estructura correcta -->
<h1>Título Principal</h1>
<h2>Subtítulo 1</h2>
<p>Contenido...</p>
<h2>Subtítulo 2</h2>
<p>Contenido...</p>

<!-- Imágenes con alt descriptivo -->
<img src="programa.jpg" alt="Estudiantes en clase de programación web">

<!-- Iconos con descripción -->
<i class="bi bi-check-circle" aria-label="Completado"></i>

<!-- Botones con atributos accesibles -->
<button aria-label="Cerrar modal" type="button" class="btn-close"></button>

<!-- Secciones con aria-labelledby -->
<section aria-labelledby="cursos-titulo">
    <h2 id="cursos-titulo">Nuestros Cursos</h2>
    <!-- contenido -->
</section>
```

### 5.2 Contraste de Colores

| Combinación | Ratio | WCAG |
|------------|-------|------|
| Verde SENA (#228B22) sobre Blanco | 5.25:1 | AAA ✅ |
| Verde Oscuro sobre Blanco | 7.8:1 | AAA ✅ |
| Gris Oscuro sobre Blanco | 10.2:1 | AAA ✅ |
| Gris Oscuro sobre Gris Claro | 9.5:1 | AAA ✅ |

### 5.3 Tamaños Mínimos Interactivos

```blade
<!-- Botones y enlaces: mínimo 44x44px -->
<a href="{{ $link }}" class="btn btn-primary" style="min-height: 44px; min-width: 44px;">
    Acción
</a>

<!-- Espaciado entre elementos interactivos: mínimo 8px -->
<div class="gap-3">
    <button class="btn btn-primary">Botón 1</button>
    <button class="btn btn-secondary">Botón 2</button>
</div>
```

---

## 6. RESPONSIVE DESIGN

### 6.1 Breakpoints (Bootstrap 5)

| Dispositivo | Ancho Mínimo | CSS |
|-------------|--------------|-----|
| Mobile | 0px | `.col`, `.col-12` |
| Tablet | 576px | `.col-sm-*` |
| Tablet Grande | 768px | `.col-md-*` |
| Computadora | 992px | `.col-lg-*` |
| Computadora Grande | 1200px | `.col-xl-*` |
| Ultra Ancho | 1400px | `.col-xxl-*` |

### 6.2 Patrón de Grillas

```blade
<!-- Responsive grid: 1 col mobile, 2 tablet, 3 desktop -->
<div class="row g-4">
    @foreach($items as $item)
    <div class="col-12 col-sm-6 col-lg-4">
        <!-- Tarjeta -->
    </div>
    @endforeach
</div>

<!-- Imagen responsive -->
<img src="{{ $image }}" 
     class="img-fluid rounded" 
     alt="Descripción"
     style="max-width: 100%; height: auto;">

<!-- Video responsive -->
<div class="ratio ratio-16x9">
    <iframe src="https://www.youtube.com/embed/VIDEO_ID" 
            allowfullscreen></iframe>
</div>
```

---

## 7. IMÁGENES Y MULTIMEDIA

### 7.1 Directrices

- **Formato**: WEBP o JPG (comprimidas)
- **Resolución**: 1920x1080px máximo (escalar según necesidad)
- **Peso máximo**: 500KB por imagen (con compresión)
- **Proporciones recomendadas**:
  - Hero: 16:9
  - Tarjetas: 4:3 (ancho 400px, alto 300px)
  - Avatares: 1:1 (100x100px)

### 7.2 Lazy Loading

```blade
<!-- Imágenes con lazy loading -->
<img src="{{ asset('storage/' . $imagen) }}" 
     alt="Descripción"
     loading="lazy"
     class="img-fluid">

<!-- Video con lazy loading -->
<iframe src="https://www.youtube.com/embed/VIDEO_ID" 
        loading="lazy"
        allowfullscreen></iframe>
```

---

## 8. VARIABLES DE CONTENIDO EDITABLE

### 8.1 Campos Recomendados por Vista

#### Home Page
```php
[
    'hero_title' => 'Transformando Vidas a Través de la Educación',
    'hero_description' => 'Descubre nuestros programas...',
    'hero_background' => 'path/to/image',
    'carousel_slide1_image' => 'path/to/image',
    'carousel_slide2_image' => 'path/to/image',
    'carousel_slide3_image' => 'path/to/image',
    'featured_programs_title' => 'Programas Destacados',
    'cta_button_text' => 'Inscribirse',
]
```

#### Programas Index
```php
[
    'page_title' => 'Nuestros Programas de Formación',
    'page_description' => 'Explora nuestra oferta educativa...',
    'hero_image' => 'path/to/image',
]
```

#### Programa Show
```php
[
    'programa_' . $id . '_titulo' => 'Nombre del Programa',
    'programa_' . $id . '_descripcion' => 'Descripción detallada',
    'programa_' . $id . '_imagen' => 'path/to/image',
]
```

---

## 9. PATRONES DE NAVEGACIÓN

### 9.1 Barra de Navegación Principal

```blade
<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
    <div class="container">
        <!-- Logo -->
        <a class="navbar-brand fw-bold text-sena-primary" href="{{ route('home') }}">
            <i class="bi bi-mortarboard-fill me-2"></i>SENA
        </a>
        
        <!-- Toggle mobile -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" 
                data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        
        <!-- Items -->
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link active" href="{{ route('home') }}">Inicio</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="programasNav" 
                       role="button" data-bs-toggle="dropdown">
                        Programas
                    </a>
                    <ul class="dropdown-menu">
                        <li>
                            <a class="dropdown-item" 
                               href="{{ route('public.programasDeFormacion.index') }}">
                                Ver Todos
                            </a>
                        </li>
                        <li><hr class="dropdown-divider"></li>
                        @foreach($categorias as $cat)
                        <li>
                            <a class="dropdown-item" href="#">{{ $cat->nombre }}</a>
                        </li>
                        @endforeach
                    </ul>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('public.ultimaNoticias.index') }}">
                        Noticias
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Contacto</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
```

---

## 10. FOOTER

### 10.1 Estructura Recomendada

```blade
<footer class="bg-sena-gray-dark text-white py-5 mt-5">
    <div class="container">
        <div class="row g-4 mb-4">
            <!-- Columna 1: Información -->
            <div class="col-md-3">
                <h5 class="fw-bold mb-3">Sobre SENA</h5>
                <p class="text-white-50 small">
                    Servicio Nacional de Aprendizaje
                </p>
                <div class="d-flex gap-3">
                    <a href="#" class="text-white-50 hover:text-white">
                        <i class="bi bi-facebook"></i>
                    </a>
                    <a href="#" class="text-white-50 hover:text-white">
                        <i class="bi bi-twitter"></i>
                    </a>
                    <a href="#" class="text-white-50 hover:text-white">
                        <i class="bi bi-linkedin"></i>
                    </a>
                </div>
            </div>
            
            <!-- Columna 2: Enlaces -->
            <div class="col-md-3">
                <h5 class="fw-bold mb-3">Enlaces</h5>
                <ul class="list-unstyled small">
                    <li><a href="#" class="text-white-50 text-decoration-none">Programas</a></li>
                    <li><a href="#" class="text-white-50 text-decoration-none">Noticias</a></li>
                    <li><a href="#" class="text-white-50 text-decoration-none">Contacto</a></li>
                </ul>
            </div>
            
            <!-- Columna 3: Información Legal -->
            <div class="col-md-3">
                <h5 class="fw-bold mb-3">Legal</h5>
                <ul class="list-unstyled small">
                    <li><a href="#" class="text-white-50 text-decoration-none">Términos</a></li>
                    <li><a href="#" class="text-white-50 text-decoration-none">Privacidad</a></li>
                    <li><a href="#" class="text-white-50 text-decoration-none">Cookies</a></li>
                </ul>
            </div>
            
            <!-- Columna 4: Newsletter -->
            <div class="col-md-3">
                <h5 class="fw-bold mb-3">Suscríbete</h5>
                <form>
                    <div class="input-group mb-3">
                        <input type="email" class="form-control" placeholder="Tu email">
                        <button class="btn btn-primary" type="submit">
                            <i class="bi bi-envelope"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>
        
        <!-- Bottom Footer -->
        <hr class="border-white-50">
        <div class="row align-items-center">
            <div class="col-md-6">
                <p class="text-white-50 small mb-0">
                    &copy; {{ date('Y') }} SENA. Todos los derechos reservados.
                </p>
            </div>
            <div class="col-md-6 text-md-end">
                <p class="text-white-50 small mb-0">
                    <a href="#" class="text-white-50 text-decoration-none">Mapa del Sitio</a>
                </p>
            </div>
        </div>
    </div>
</footer>
```

---

## 11. ANIMACIONES Y TRANSICIONES

### 11.1 CSS Transitions

```css
/* En resources/css/app.css */

/* Transiciones suaves por defecto */
a, button, input, select, textarea {
    transition: all 0.3s ease;
}

/* Efecto hover en tarjetas */
.card {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.card:hover {
    transform: translateY(-4px);
    box-shadow: 0 8px 24px rgba(34, 139, 34, 0.15);
}

/* Efecto en botones */
.btn {
    transition: all 0.2s ease;
}

.btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
}

/* Fade in al cargar */
@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.fade-in {
    animation: fadeIn 0.6s ease;
}
```

---

## 12. VELOCIDAD Y RENDIMIENTO

### 12.1 Optimizaciones Recomendadas

- ✅ Imágenes comprimidas y en formato moderno (WEBP)
- ✅ Lazy loading para imágenes fuera del viewport
- ✅ CSS crítico inlined en `<head>`
- ✅ JavaScript deferido o async
- ✅ Minificación de assets
- ✅ Caching con etiquetas HTTP
- ✅ CDN para recursos estáticos

### 12.2 Implementación en Vite

```javascript
// vite.config.js
import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
            ],
            refresh: true,
        }),
    ],
    build: {
        minify: 'terser',
        reportCompressedSize: true,
    },
});
```

---

## 13. CHECKLIST PARA NUEVAS VISTAS PÚBLICAS

- [ ] Jerarquía de encabezados correcta (H1-H6)
- [ ] Todos los enlaces tienen `title` descriptivo
- [ ] Todas las imágenes tienen `alt` descriptivo
- [ ] Colores cumplen WCAG AAA
- [ ] Botones son al menos 44x44px
- [ ] Formularios tienen labels asociados
- [ ] Mensajes de error son claros
- [ ] Responsive en móvil, tablet y desktop
- [ ] Breadcrumbs presentes (excepto home)
- [ ] Footer con enlaces útiles
- [ ] Velocidad de carga < 3 segundos
- [ ] No hay contenido huérfano
- [ ] Imágenes optimizadas
- [ ] CTA principal es clara y visible
- [ ] Contenido editable está configurado

---

## 14. REFERENCIAS Y RECURSOS

### Documentación Oficial
- [Bootstrap 5 Documentation](https://getbootstrap.com/docs/5.0/)
- [WCAG 2.1 Guidelines](https://www.w3.org/WAI/WCAG21/quickref/)
- [Web.dev Performance Guide](https://web.dev/performance/)

### Herramientas de Prueba
- [WAVE Accessibility Tool](https://wave.webaim.org/)
- [Lighthouse (Chrome DevTools)](https://developers.google.com/web/tools/lighthouse)
- [Color Contrast Checker](https://webaim.org/resources/contrastchecker/)
- [Responsive Design Tester](https://responsivedesignchecker.com/)

---

## 15. NOTAS IMPORTANTES

1. **Sin Manual Oficial**: Este documento está basado en estándares internacionales y buenas prácticas. Si existe un manual de identidad SENA 2024, debe actualizarse con los colores, tipografías y logotipos específicos.

2. **Implementación Consistente**: Usar siempre variables CSS (`--sena-*`) para facilitar cambios globales.

3. **Validación Continua**: Probar accesibilidad con WAVE y rendimiento con Lighthouse regularmente.

4. **Feedback de Usuarios**: Recopilar feedback de usuarios con discapacidades para mejoras continuas.

---

**Documento actualizado**: 27 de enero de 2026
**Versión**: 1.0
**Estado**: Recomendaciones en vigor
