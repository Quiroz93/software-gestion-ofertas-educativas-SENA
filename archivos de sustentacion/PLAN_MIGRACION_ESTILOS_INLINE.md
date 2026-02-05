# 🛠️ PLAN DE MIGRACIÓN: Estilos Inline → CSS Classes

**Objetivo:** Remover 50+ estilos inline y usar clases CSS reutilizables  
**Fecha:** 31 de Enero 2026  
**Criticidad:** 🟡 MEDIA (Mejora de mantenibilidad)

---

## 📋 INVENTARIO DE ESTILOS INLINE

### Archivos a actualizar (5 archivos críticos)

```
1. resources/views/public/welcome.blade.php          (18+ estilos)
2. resources/views/public/programas/show.blade.php   (25+ estilos)
3. resources/views/public/redes/index.blade.php      (8+ estilos)
4. resources/views/partials/sidebar.blade.php        (2 estilos)
5. resources/views/public/historias_exito/show.blade.php (1 estilo)
```

---

## 🎯 ESTRATEGIA DE MIGRACIÓN

### Paso 1: Crear Clases CSS Reutilizables

**Archivo a crear:** `resources/css/public/components.css`

```css
/* Secciones Hero */
.hero-green {
    background-color: var(--sena-green);
}

.hero-blue {
    background-color: var(--sena-blue-dark);
}

/* Editores (Modal) */
.editor-container {
    display: none;
}

.editor-container.active {
    display: block;
}

/* Grid de archivos */
.files-grid {
    max-height: 300px;
    overflow-y: auto;
}

/* Thumbnails */
.media-thumbnail {
    width: 100%;
    height: 120px;
    object-fit: cover;
}

/* Previews */
.media-preview {
    max-height: 250px;
}

/* Drop zones */
.drop-zone {
    cursor: pointer;
    transition: var(--transition-base);
}

.drop-zone:hover {
    background-color: var(--gray-100);
}

/* Iconos grandes */
.icon-huge {
    font-size: 3rem;
    color: var(--text-muted);
}

.icon-large-danger {
    font-size: 2rem;
    color: #dc3545;
}

/* Circunferencias con color */
.circle-bg {
    width: 3rem;
    height: 3rem;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
}

.circle-bg-green {
    background-color: rgba(57, 169, 0, 0.08);
}

.circle-icon-green {
    font-size: 2rem;
    color: var(--sena-green);
}

/* Tarjetas editables */
.editable-card {
    background-color: var(--white);
    border-radius: var(--border-radius-lg);
    padding: var(--spacing-lg);
    box-shadow: var(--shadow-sm);
    transition: var(--transition-base);
}

.editable-card:hover {
    box-shadow: var(--shadow-md);
    cursor: pointer;
}

/* Progress bar */
.progress-animated {
    animation: progress-bar-stripes 1s linear infinite;
}

/* Offcanvas personalizado */
.offcanvas-header-sena {
    background-color: var(--sena-blue-dark);
    color: var(--white);
}

/* Info boxes */
.info-box {
    background-color: var(--neutral-bg);
    border: 1px solid var(--sena-blue-light);
    color: var(--sena-blue-dark);
    border-radius: var(--border-radius);
    padding: var(--spacing-md);
}

/* Icon buttons redondeados */
.icon-btn-round {
    width: 56px;
    height: 56px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 1040;
}

/* Títulos con color */
.title-green {
    color: var(--sena-green);
}

.title-blue {
    color: var(--sena-blue-dark);
}

.title-yellow {
    color: var(--sena-yellow);
}

/* Texto tachado */
.text-strikethrough {
    text-decoration: line-through;
}

/* Video/Imagen responsivos */
.media-responsive {
    width: 100%;
    max-height: 250px;
    background: #000;
}

.video-responsive {
    width: 100%;
    max-height: 200px;
    background: #000;
}

/* Navbar personalizado */
.navbar-sena {
    background-color: var(--sena-blue-dark);
}

.navbar-brand-sena {
    font-size: 1rem;
    color: var(--white) !important;
}

/* Información de programa */
.program-info-item {
    display: flex;
    align-items: center;
    gap: var(--spacing-md);
    padding: var(--spacing-md) 0;
    border-bottom: 1px solid var(--border-color);
}

.program-info-item:last-child {
    border-bottom: none;
}

.program-info-icon {
    font-size: 1.5rem;
    width: 1.5rem;
    flex-shrink: 0;
}

.program-info-icon-green {
    color: var(--sena-green);
}

.program-info-icon-yellow {
    color: var(--sena-yellow);
}

.program-info-icon-blue {
    color: var(--sena-blue-dark);
}

.program-info-text {
    color: var(--sena-blue-dark);
}

/* Competencias grid */
.competencies-grid {
    display: grid;
    gap: var(--spacing-md);
}

.competency-card {
    background-color: var(--neutral-bg);
    border-radius: var(--border-radius);
    padding: var(--spacing-md);
}

.competency-title {
    color: var(--sena-blue-dark);
    font-weight: var(--font-weight-semibold);
    margin-bottom: var(--spacing-sm);
}

.competency-description {
    color: var(--text-muted);
    font-size: var(--fs-sm);
}
```

---

## 🔄 MIGRACIONES ESPECÍFICAS

### ARCHIVO 1: welcome.blade.php (18+ estilos)

#### Estilo 1: Offcanvas header

**ANTES:**
```html
<div class="offcanvas-header" style="background-color: var(--sena-blue-dark); color: white;">
```

**DESPUÉS:**
```html
<div class="offcanvas-header offcanvas-header-sena">
```

---

#### Estilo 2: Icon font size (Cloud upload)

**ANTES:**
```html
<i class="bi bi-cloud-upload" style="font-size: 3rem; color: var(--text-muted);"></i>
```

**DESPUÉS:**
```html
<i class="bi bi-cloud-upload icon-huge"></i>
```

---

#### Estilo 3: Grid de archivos

**ANTES:**
```html
<div id="filesGrid" class="row g-2" style="max-height: 300px; overflow-y: auto;">
```

**DESPUÉS:**
```html
<div id="filesGrid" class="row g-2 files-grid">
```

---

#### Estilo 4: Drop zone

**ANTES:**
```html
<div id="dropZone" class="border border-dashed rounded p-5 text-center bg-light" 
     style="cursor: pointer; transition: all 0.3s;">
```

**DESPUÉS:**
```html
<div id="dropZone" class="border border-dashed rounded p-5 text-center bg-light drop-zone">
```

---

#### Estilo 5: Video inline

**ANTES:**
```html
$('#currentMediaPreview').html(`<video controls style="width: 100%; max-height: 200px; background: #000;">
    <source src="${currentSrc}" type="video/mp4">
</video>`);
```

**DESPUÉS (en JavaScript):**
```javascript
$('#currentMediaPreview').html(`<video controls class="video-responsive">
    <source src="${currentSrc}" type="video/mp4">
</video>`);
```

---

### ARCHIVO 2: programas/show.blade.php (25+ estilos)

#### Estilo 1: Hero section

**ANTES:**
```html
<div style="background-color: var(--sena-green);" class="text-white py-4 mb-5 rounded-lg overflow-hidden">
```

**DESPUÉS:**
```html
<div class="hero-section hero-bg-green py-4 mb-5">
```

---

#### Estilo 2: Icono grande

**ANTES:**
```html
<i class="bi bi-book-half text-white" style="font-size: 4rem; opacity: 0.3;"></i>
```

**DESPUÉS:**
```html
<i class="bi bi-book-half text-white icon-large"></i>
```

---

#### Estilo 3: Títulos con color

**ANTES:**
```html
<h4 class="card-title fw-bold mb-3" style="color: var(--sena-green);">
    <i class="bi bi-check-circle me-2" style="color: var(--sena-green);"></i>Requisitos
</h4>
```

**DESPUÉS:**
```html
<h4 class="card-title fw-bold mb-3 title-green">
    <i class="bi bi-check-circle me-2 text-sena-green"></i>Requisitos
</h4>
```

---

#### Estilo 4: Competencias grid

**ANTES:**
```html
<div class="p-3 rounded-lg" style="background-color: var(--neutral-bg);">
    <h6 class="fw-bold mb-2" style="color: var(--sena-blue-dark);">{{ $competencia->nombre }}</h6>
```

**DESPUÉS:**
```html
<div class="competency-card">
    <h6 class="competency-title">{{ $competencia->nombre }}</h6>
```

---

#### Estilo 5: Info items

**ANTES:**
```html
<i class="bi bi-hourglass-split" style="font-size: 1.5rem; color: var(--sena-green); margin-right: 1rem;"></i>
<strong style="color: var(--sena-blue-dark);">{{ $programa->duracion_meses }}</strong>
```

**DESPUÉS:**
```html
<div class="program-info-item">
    <i class="bi bi-hourglass-split program-info-icon program-info-icon-green"></i>
    <div class="program-info-text">
        <strong>{{ $programa->duracion_meses }} {{ $programa->duracion_meses == 1 ? 'mes' : 'meses' }}</strong>
    </div>
</div>
```

---

### ARCHIVO 3: redes/index.blade.php (8+ estilos)

#### Estilo 1: Hero section

**ANTES:**
```html
<div style="background-color: var(--sena-green);" class="text-white py-5 mb-5 rounded-bottom-lg">
```

**DESPUÉS:**
```html
<div class="hero-section hero-bg-green py-5 mb-5 rounded-bottom-lg">
```

---

#### Estilo 2: Círculo con icono

**ANTES:**
```html
<div style="background-color: rgba(57,169,0,0.08);" class="rounded-circle p-3">
    <i class="bi bi-diagram-3" style="font-size: 2rem; color: var(--sena-green);"></i>
</div>
```

**DESPUÉS:**
```html
<div class="circle-bg circle-bg-green p-3">
    <i class="bi bi-diagram-3 circle-icon-green"></i>
</div>
```

---

### ARCHIVO 4: sidebar.blade.php (2 estilos)

#### Estilo 1: Icon button redondo

**ANTES:**
```html
<button style="width: 56px; height: 56px; z-index: 1040;">
```

**DESPUÉS:**
```html
<button class="icon-btn-round btn btn-outline-success">
```

---

### ARCHIVO 5: historias_exito/show.blade.php (1 estilo)

#### Estilo 1: Hero section

**ANTES:**
```html
<div style="background-color: var(--sena-green);" class="text-white py-5 mb-5 rounded-lg overflow-hidden">
```

**DESPUÉS:**
```html
<div class="hero-section hero-bg-green py-5 mb-5">
```

---

## ✅ PASOS DE IMPLEMENTACIÓN

### 1. Crear archivo CSS de componentes

```bash
# Crear archivo
touch resources/css/public/components.css

# Copiar contenido de este documento a ese archivo
```

### 2. Actualizar vite.config.js

```javascript
// Ya se hizo en paso anterior
```

### 3. Migrar archivos Blade uno por uno

```
1. welcome.blade.php (18 cambios)
2. programas/show.blade.php (25 cambios)
3. redes/index.blade.php (8 cambios)
4. sidebar.blade.php (2 cambios)
5. historias_exito/show.blade.php (1 cambio)
```

### 4. Verificar en navegador

```bash
npm run build
# Visitar http://localhost:8000
# Verificar que los estilos se aplican igual
```

### 5. Commit

```bash
git add resources/css/public/components.css
git add resources/views/**/*.blade.php
git commit -m "refactor: migrar estilos inline a clases CSS reutilizables"
```

---

## 📊 BENEFICIOS

| Aspecto | Antes | Después |
|--------|-------|---------|
| **Estilos inline** | 54 | 0 |
| **Clases reutilizables** | 5 | 50+ |
| **Consistencia** | Baja | Alta |
| **Mantenibilidad** | Difícil | Fácil |
| **Cambiar colores** | 54 lugares | 1 variable CSS |

---

## 🚀 PRÓXIMOS PASOS

1. ✅ Crear `resources/css/public/components.css` (ya hecho)
2. ✅ Actualizar `vite.config.js` (ya hecho)
3. ⏳ Migrar estilos inline en blade files
4. ⏳ Verificar en navegador
5. ⏳ Git commit

---

## 📝 NOTAS

- Todas las clases usan variables CSS centralizadas
- Los colores se pueden cambiar desde `design-system.css`
- Las transiciones son consistentes
- Responsive design funciona igual
- No hay cambios visuales en navegador

