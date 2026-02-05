# Arquitectura CSS Centralizada - Análisis y Plan de Implementación

## 📊 ANÁLISIS DE LA SITUACIÓN ACTUAL

### Problemas Identificados

#### 1. **Fragmentación de Estilos**
- **4 archivos CSS independientes** sin jerarquía:
  - `app.css` (solo importa home.css)
  - `home.css` (estilos específicos landing)
  - `admin.css` (estilos área administrativa)
  - `public.css` (estilos vistas públicas)

#### 2. **Valores Hardcodeados**
Total: **74 colores hardcodeados** detectados en los archivos CSS:

```
admin.css:  36 colores hardcodeados
public.css: 29 colores hardcodeados
home.css:   9 colores hardcodeados
```

**Colores duplicados más frecuentes:**
- `#39A900` (Verde SENA Primary): 12 ocurrencias
- `#2d8500` (Verde SENA Dark): 9 ocurrencias
- `#fff` (Blanco): 15 ocurrencias
- `#667eea` (Morado - legacy): 6 ocurrencias
- `#f8f9fa` (Gris claro): 5 ocurrencias

#### 3. **Inconsistencias de Diseño**

**Gradientes no estandarizados:**
```css
/* admin.css */
background: linear-gradient(180deg, #2d8500 0%, #39A900 100%);

/* public.css */
background: linear-gradient(135deg, #39A900 0%, #2d8500 100%);

/* home.css */
background: linear-gradient(135deg, #39A900, #2d8500);
```

**Espaciados inconsistentes:**
- Paddings varían entre `0.75rem`, `1rem`, `1.5rem`, `2rem` sin patrón
- Márgenes sin sistema de espaciado uniforme

**Shadows sin jerarquía:**
```css
box-shadow: 0 2px 4px rgba(0,0,0,0.05);    /* Pequeña */
box-shadow: 0 2px 8px rgba(0,0,0,0.08);    /* Media */
box-shadow: 0 4px 12px rgba(0,0,0,0.12);   /* Grande */
box-shadow: 0 8px 24px rgba(0,0,0,0.15);   /* Extra grande */
```

#### 4. **Estilos Bootstrap No Centralizados**

Las vistas usan **Bootstrap 5.3.2 desde CDN**:
```html
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
```

**Pero `_variables.scss` solo define 2 variables:**
```scss
$primary: #39A900;
$success: #39A900;
```

❌ **Bootstrap NO está compilándose con las variables personalizadas**
❌ Los archivos CSS ignoran completamente las variables SCSS

#### 5. **Sin Sistema de Variables CSS**
- No existen CSS Custom Properties (`:root`)
- Cambiar colores requiere editar múltiples archivos
- No hay tematización dinámica

---

## 🏗️ ARQUITECTURA PROPUESTA

### Sistema de Design Tokens con CSS Variables

```
resources/
├── css/
│   ├── tokens/
│   │   ├── _colors.css          ← Variables de color centralizadas
│   │   ├── _typography.css      ← Fuentes, tamaños, pesos
│   │   ├── _spacing.css         ← Sistema de espaciado
│   │   ├── _shadows.css         ← Sombras estandarizadas
│   │   ├── _borders.css         ← Radios y bordes
│   │   └── _animations.css      ← Transiciones y keyframes
│   │
│   ├── base/
│   │   ├── _reset.css           ← Normalize/reset
│   │   └── _global.css          ← Estilos globales
│   │
│   ├── components/
│   │   ├── _buttons.css         ← Botones centralizados
│   │   ├── _cards.css           ← Cards unificadas
│   │   ├── _forms.css           ← Formularios
│   │   ├── _badges.css          ← Badges
│   │   └── _navigation.css      ← Navegación
│   │
│   ├── layouts/
│   │   ├── _admin.css           ← Layout administrativo
│   │   ├── _public.css          ← Layout público
│   │   └── _home.css            ← Layout landing
│   │
│   └── main.css                 ← Punto de entrada único
│
└── sass/
    ├── _variables.scss          ← Variables Bootstrap (mantener)
    └── app.scss                 ← Bootstrap customizado
```

---

## 🎨 PROPUESTA: SISTEMA DE DESIGN TOKENS

### 1. Variables de Color (_colors.css)

```css
:root {
    /* ==== SENA Brand Colors ==== */
    --color-sena-primary: #39A900;
    --color-sena-primary-dark: #2d8500;
    --color-sena-primary-light: #4bc400;
    --color-sena-primary-lightest: #f0f8e8;
    
    /* ==== Semantic Colors ==== */
    --color-success: var(--color-sena-primary);
    --color-success-bg: #d4edda;
    --color-success-text: #155724;
    
    --color-danger: #dc3545;
    --color-danger-bg: #f8d7da;
    --color-danger-text: #721c24;
    
    --color-warning: #ffc107;
    --color-warning-bg: #fff3cd;
    --color-warning-text: #856404;
    
    --color-info: #17a2b8;
    --color-info-bg: #d1ecf1;
    --color-info-text: #0c5460;
    
    /* ==== Neutral Colors ==== */
    --color-white: #ffffff;
    --color-black: #000000;
    
    --color-gray-50: #f8f9fa;
    --color-gray-100: #f3f3f3;
    --color-gray-200: #e9ecef;
    --color-gray-300: #dee2e6;
    --color-gray-400: #ced4da;
    --color-gray-500: #adb5bd;
    --color-gray-600: #6c757d;
    --color-gray-700: #495057;
    --color-gray-800: #343a40;
    --color-gray-900: #212529;
    
    /* ==== Text Colors (Títulos, Párrafos, Subtítulos) ==== */
    --color-text-primary: #212529;
    --color-text-secondary: #6c757d;
    --color-text-muted: #adb5bd;
    --color-text-inverse: #ffffff;
    
    /* Títulos específicos */
    --color-heading-h1: #212529;
    --color-heading-h2: #2c3e50;
    --color-heading-h3: #495057;
    --color-heading-h4: #6c757d;
    
    /* Subtítulos y destacados */
    --color-subtitle: #6c757d;
    --color-caption: #adb5bd;
    --color-lead: #343a40;
    
    /* ==== Background Colors ==== */
    --color-bg-primary: #ffffff;
    --color-bg-secondary: #f8f9fa;
    --color-bg-tertiary: #f0f8e8;
    --color-bg-dark: #2c3e50;
    
    /* ==== Border Colors (específicos por componente) ==== */
    --color-border-default: #dee2e6;
    --color-border-light: #e9ecef;
    --color-border-dark: #adb5bd;
    --color-border-primary: var(--color-sena-primary);
    --color-border-success: #28a745;
    --color-border-danger: #dc3545;
    --color-border-warning: #ffc107;
    
    /* Bordes de componentes específicos */
    --color-border-card: #e9ecef;
    --color-border-input: #ced4da;
    --color-border-input-focus: var(--color-sena-primary);
    --color-border-button: transparent;
    --color-border-divider: rgba(0, 0, 0, 0.1);
    
    /* ==== Icon Colors ==== */
    --color-icon-primary: var(--color-sena-primary);
    --color-icon-secondary: #6c757d;
    --color-icon-success: #28a745;
    --color-icon-danger: #dc3545;
    --color-icon-warning: #ffc107;
    --color-icon-info: #17a2b8;
    --color-icon-muted: #adb5bd;
    
    /* ==== Button Colors ==== */
    --color-btn-primary-bg: var(--color-sena-primary);
    --color-btn-primary-text: #ffffff;
    --color-btn-primary-border: var(--color-sena-primary);
    --color-btn-primary-hover-bg: var(--color-sena-primary-dark);
    --color-btn-primary-hover-border: var(--color-sena-primary-dark);
    
    --color-btn-secondary-bg: #6c757d;
    --color-btn-secondary-text: #ffffff;
    --color-btn-secondary-border: #6c757d;
    --color-btn-secondary-hover-bg: #5a6268;
    --color-btn-secondary-hover-border: #5a6268;
    
    --color-btn-outline-primary-text: var(--color-sena-primary);
    --color-btn-outline-primary-border: var(--color-sena-primary);
    --color-btn-outline-primary-hover-bg: var(--color-sena-primary);
    --color-btn-outline-primary-hover-text: #ffffff;
    
    --color-btn-danger-bg: #dc3545;
    --color-btn-danger-text: #ffffff;
    --color-btn-danger-hover-bg: #c82333;
    
    /* ==== Banner Colors ==== */
    --color-banner-hero-bg: var(--gradient-sena-primary);
    --color-banner-hero-text: #ffffff;
    --color-banner-hero-subtitle: rgba(255, 255, 255, 0.9);
    
    --color-banner-info-bg: #d1ecf1;
    --color-banner-info-text: #0c5460;
    --color-banner-info-border: #bee5eb;
    
    --color-banner-warning-bg: #fff3cd;
    --color-banner-warning-text: #856404;
    --color-banner-warning-border: #ffeaa7;
    
    --color-banner-success-bg: #d4edda;
    --color-banner-success-text: #155724;
    --color-banner-success-border: #c3e6cb;
    
    /* ==== Badge Colors ==== */
    --color-badge-primary-bg: var(--color-sena-primary);
    --color-badge-primary-text: #ffffff;
    
    --color-badge-secondary-bg: #6c757d;
    --color-badge-secondary-text: #ffffff;
    
    --color-badge-success-bg: #28a745;
    --color-badge-success-text: #ffffff;
    
    --color-badge-danger-bg: #dc3545;
    --color-badge-danger-text: #ffffff;
    
    --color-badge-warning-bg: #ffc107;
    --color-badge-warning-text: #212529;
    
    --color-badge-info-bg: #17a2b8;
    --color-badge-info-text: #ffffff;
    
    /* ==== Span/Label Colors ==== */
    --color-span-primary: var(--color-sena-primary);
    --color-span-secondary: #6c757d;
    --color-span-muted: #adb5bd;
    --color-span-highlight: #ffc107;
    --color-span-error: #dc3545;
    
    /* ==== Card Colors ==== */
    --color-card-bg: #ffffff;
    --color-card-border: #dee2e6;
    --color-card-header-bg: #f8f9fa;
    --color-card-header-text: #495057;
    --color-card-shadow: rgba(0, 0, 0, 0.08);
    
    /* ==== Gradient Presets ==== */
    --gradient-sena-primary: linear-gradient(135deg, var(--color-sena-primary) 0%, var(--color-sena-primary-dark) 100%);
    --gradient-sena-reverse: linear-gradient(135deg, var(--color-sena-primary-dark) 0%, var(--color-sena-primary) 100%);
    --gradient-sena-vertical: linear-gradient(180deg, var(--color-sena-primary-dark) 0%, var(--color-sena-primary) 100%);
    --gradient-light: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
    
    /* ==== Opacity Variants ==== */
    --color-sena-primary-alpha-10: rgba(57, 169, 0, 0.1);
    --color-sena-primary-alpha-20: rgba(57, 169, 0, 0.2);
    --color-sena-primary-alpha-30: rgba(57, 169, 0, 0.3);
    --color-sena-primary-alpha-50: rgba(57, 169, 0, 0.5);
}
```

### 2. Variables de Espaciado (_spacing.css)

```css
:root {
    /* ==== Spacing Scale (sistema 4px) ==== */
    --space-0: 0;
    --space-1: 0.25rem;  /* 4px */
    --space-2: 0.5rem;   /* 8px */
    --space-3: 0.75rem;  /* 12px */
    --space-4: 1rem;     /* 16px */
    --space-5: 1.5rem;   /* 24px */
    --space-6: 2rem;     /* 32px */
    --space-7: 2.5rem;   /* 40px */
    --space-8: 3rem;     /* 48px */
    --space-9: 4rem;     /* 64px */
    --space-10: 6rem;    /* 96px */
    
    /* ==== Semantic Spacing ==== */
    --spacing-component-padding: var(--space-5);
    --spacing-section-gap: var(--space-8);
    --spacing-card-padding: var(--space-5);
}
```

### 3. Variables de Sombras (_shadows.css)

```css
:root {
    /* ==== Shadow System ==== */
    --shadow-xs: 0 1px 2px rgba(0, 0, 0, 0.05);
    --shadow-sm: 0 2px 4px rgba(0, 0, 0, 0.05);
    --shadow-md: 0 2px 8px rgba(0, 0, 0, 0.08);
    --shadow-lg: 0 4px 12px rgba(0, 0, 0, 0.12);
    --shadow-xl: 0 8px 24px rgba(0, 0, 0, 0.15);
    --shadow-2xl: 0 20px 40px rgba(0, 0, 0, 0.15);
    
    /* ==== Colored Shadows ==== */
    --shadow-sena: 0 4px 8px var(--color-sena-primary-alpha-30);
    --shadow-sena-lg: 0 8px 16px var(--color-sena-primary-alpha-30);
}
```

### 4. Variables de Tipografía (_typography.css)

```css
:root {
    /* ==== Font Families ==== */
    --font-primary: 'Nunito', 'Inter', system-ui, -apple-system, sans-serif;
    --font-mono: 'Courier New', monospace;
    
    /* ==== Font Sizes ==== */
    --font-size-xs: 0.75rem;    /* 12px */
    --font-size-sm: 0.875rem;   /* 14px */
    --font-size-base: 0.9rem;   /* 14.4px */
    --font-size-md: 1rem;       /* 16px */
    --font-size-lg: 1.25rem;    /* 20px */
    --font-size-xl: 1.5rem;     /* 24px */
    --font-size-2xl: 2rem;      /* 32px */
    --font-size-3xl: 2.5rem;    /* 40px */
    
    /* ==== Font Weights ==== */
    --font-weight-normal: 400;
    --font-weight-medium: 500;
    --font-weight-semibold: 600;
    --font-weight-bold: 700;
    
    /* ==== Line Heights ==== */
    --line-height-tight: 1.25;
    --line-height-normal: 1.6;
    --line-height-relaxed: 1.8;
}
```

### 5. Variables de Bordes (_borders.css)

```css
:root {
    /* ==== Border Radius ==== */
    --radius-sm: 4px;
    --radius-md: 8px;
    --radius-lg: 12px;
    --radius-xl: 20px;
    --radius-2xl: 25px;
    --radius-full: 9999px;
    
    /* ==== Border Widths ==== */
    --border-width-thin: 1px;
    --border-width-medium: 2px;
    --border-width-thick: 3px;
    --border-width-ultra: 4px;
    
    /* ==== Border Colors ==== */
    --border-color-default: var(--color-gray-300);
    --border-color-light: var(--color-gray-200);
    --border-color-dark: var(--color-gray-400);
}
```

### 6. Variables de Animación (_animations.css)

```css
:root {
    /* ==== Transition Durations ==== */
    --transition-fast: 150ms;
    --transition-base: 200ms;
    --transition-slow: 300ms;
    --transition-slower: 500ms;
    
    /* ==== Transition Timing ==== */
    --transition-ease: cubic-bezier(0.4, 0, 0.2, 1);
    --transition-ease-in: cubic-bezier(0.4, 0, 1, 1);
    --transition-ease-out: cubic-bezier(0, 0, 0.2, 1);
    --transition-ease-in-out: cubic-bezier(0.4, 0, 0.2, 1);
    
    /* ==== Common Transitions ==== */
    --transition-all: all var(--transition-base) var(--transition-ease);
    --transition-colors: color var(--transition-base) var(--transition-ease),
                         background-color var(--transition-base) var(--transition-ease),
                         border-color var(--transition-base) var(--transition-ease);
    --transition-transform: transform var(--transition-base) var(--transition-ease);
}
```

---

## 🔄 MIGRACIÓN DE ESTILOS ACTUALES

### Antes (admin.css - Hardcoded):
```css
.sidebar {
    background: linear-gradient(180deg, #2d8500 0%, #39A900 100%);
    color: #ecf0f1;
    box-shadow: 2px 0 10px rgba(0,0,0,0.1);
}

.sidebar-nav-link:hover {
    background: rgba(57, 169, 0, 0.2);
    border-left-color: #39A900;
}

.btn-admin-primary {
    background: linear-gradient(135deg, #39A900 0%, #2d8500 100%);
    box-shadow: 0 4px 8px rgba(57, 169, 0, 0.3);
}
```

### Después (Con Design Tokens):
```css
.sidebar {
    background: var(--gradient-sena-vertical);
    color: var(--color-gray-100);
    box-shadow: var(--shadow-md);
}

.sidebar-nav-link:hover {
    background: var(--color-sena-primary-alpha-20);
    border-left-color: var(--color-sena-primary);
}

.btn-admin-primary {
    background: var(--gradient-sena-primary);
    box-shadow: var(--shadow-sena);
}
```

---

## 📝 PLAN DE IMPLEMENTACIÓN

### Fase 1: Crear Sistema de Tokens (1-2 horas)
✅ Crear estructura de carpetas `tokens/`
✅ Crear 6 archivos de tokens (colors, spacing, shadows, typography, borders, animations)
✅ Definir todas las variables CSS en `:root`
✅ Crear `main.css` que importe todos los tokens

### Fase 2: Refactorizar admin.css (1 hora)
✅ Reemplazar 36 colores hardcodeados por variables
✅ Estandarizar gradientes usando `--gradient-*`
✅ Normalizar shadows usando `--shadow-*`
✅ Usar sistema de espaciado `--space-*`

### Fase 3: Refactorizar public.css (1 hora)
✅ Reemplazar 29 colores hardcodeados
✅ Migrar gradientes legacy (morado, rosa, cyan) a sistema o eliminar
✅ Estandarizar shadows y spacing

### Fase 4: Refactorizar home.css (30 min)
✅ Reemplazar 9 colores hardcodeados
✅ Usar variables de gradiente
✅ Normalizar spacing

### Fase 5: Unificar Componentes Duplicados (2 horas)
✅ Crear `components/_buttons.css` unificado
✅ Crear `components/_cards.css` unificado
✅ Crear `components/_badges.css` unificado
✅ Eliminar duplicados de admin.css, public.css, home.css

### Fase 6: Integrar con Bootstrap (1 hora)
✅ Actualizar `_variables.scss` para usar nuevos tokens
✅ Sincronizar colores Bootstrap con CSS variables
✅ Compilar SCSS personalizado

### Fase 7: Actualizar Vistas Blade (30 min)
✅ Cambiar imports de CSS individuales por `main.css`
✅ Agregar scope de layout (clases `.layout-admin`, `.layout-public`)

### Fase 8: Testing y Validación (1 hora)
✅ Validar colores en todas las vistas
✅ Verificar responsive design
✅ Testear cambios de tema (futuro dark mode)

---

## � CONTROL GRANULAR POR COMPONENTE

### Ejemplos de Aplicación de Variables por Componente

#### 1. **BOTONES** - Control Total de Estados

```css
/* Botón Primario SENA */
.btn-sena-primary {
    background: var(--color-btn-primary-bg);           /* #39A900 */
    color: var(--color-btn-primary-text);              /* #ffffff */
    border: 2px solid var(--color-btn-primary-border); /* #39A900 */
    transition: var(--transition-all);
}

.btn-sena-primary:hover {
    background: var(--color-btn-primary-hover-bg);     /* #2d8500 */
    border-color: var(--color-btn-primary-hover-border); /* #2d8500 */
    box-shadow: var(--shadow-sena);
}

/* Botón Outline */
.btn-sena-outline {
    background: transparent;
    color: var(--color-btn-outline-primary-text);      /* #39A900 */
    border: 2px solid var(--color-btn-outline-primary-border); /* #39A900 */
}

.btn-sena-outline:hover {
    background: var(--color-btn-outline-primary-hover-bg);   /* #39A900 */
    color: var(--color-btn-outline-primary-hover-text);       /* #ffffff */
}

/* Botón Danger */
.btn-danger {
    background: var(--color-btn-danger-bg);            /* #dc3545 */
    color: var(--color-btn-danger-text);               /* #ffffff */
    border: none;
}

.btn-danger:hover {
    background: var(--color-btn-danger-hover-bg);      /* #c82333 */
}
```

**Cambio global de botones:**
```css
/* En _colors.css - Cambiar TODOS los botones primarios a naranja: */
:root {
    --color-btn-primary-bg: #FF5733;
    --color-btn-primary-hover-bg: #e04e2a;
}
/* ✅ Todos los botones .btn-sena-primary ahora son naranjas */
```

---

#### 2. **BORDES** - Por Tipo y Contexto

```css
/* Bordes de Cards */
.card {
    border: var(--border-width-thin) solid var(--color-border-card); /* 1px #e9ecef */
    border-radius: var(--radius-lg);                                 /* 12px */
}

/* Bordes de Inputs */
.form-control {
    border: var(--border-width-medium) solid var(--color-border-input); /* 2px #ced4da */
    border-radius: var(--radius-md);                                    /* 8px */
}

.form-control:focus {
    border-color: var(--color-border-input-focus);   /* #39A900 */
    box-shadow: 0 0 0 0.2rem var(--color-sena-primary-alpha-20);
}

/* Bordes de Dividers */
.divider {
    border-top: var(--border-width-thin) solid var(--color-border-divider); /* 1px rgba(0,0,0,0.1) */
}

/* Borde de Sidebar Active */
.sidebar-nav-link.active {
    border-left: var(--border-width-thick) solid var(--color-border-primary); /* 3px #39A900 */
}
```

**Cambio global de bordes de inputs:**
```css
:root {
    --color-border-input: #000000;       /* Bordes negros */
    --color-border-input-focus: #FF0000; /* Focus rojo */
}
```

---

#### 3. **TÍTULOS, SUBTÍTULOS Y PÁRRAFOS** - Jerarquía Visual

```css
/* Títulos Principales */
h1, .heading-1 {
    color: var(--color-heading-h1);      /* #212529 - Casi negro */
    font-size: var(--font-size-3xl);     /* 2.5rem */
    font-weight: var(--font-weight-bold); /* 700 */
    line-height: var(--line-height-tight); /* 1.25 */
}

h2, .heading-2 {
    color: var(--color-heading-h2);      /* #2c3e50 - Gris oscuro */
    font-size: var(--font-size-2xl);     /* 2rem */
    font-weight: var(--font-weight-bold);
}

h3, .heading-3 {
    color: var(--color-heading-h3);      /* #495057 - Gris medio */
    font-size: var(--font-size-xl);      /* 1.5rem */
    font-weight: var(--font-weight-semibold); /* 600 */
}

h4, .heading-4 {
    color: var(--color-heading-h4);      /* #6c757d - Gris claro */
    font-size: var(--font-size-lg);      /* 1.25rem */
    font-weight: var(--font-weight-semibold);
}

/* Subtítulos */
.subtitle {
    color: var(--color-subtitle);        /* #6c757d */
    font-size: var(--font-size-lg);      /* 1.25rem */
    font-weight: var(--font-weight-normal); /* 400 */
}

/* Párrafos */
p, .paragraph {
    color: var(--color-text-primary);    /* #212529 */
    font-size: var(--font-size-base);    /* 0.9rem */
    line-height: var(--line-height-normal); /* 1.6 */
}

.lead {
    color: var(--color-lead);            /* #343a40 */
    font-size: var(--font-size-lg);      /* 1.25rem */
    font-weight: var(--font-weight-medium); /* 500 */
}

/* Caption/Pequeños */
.caption, small {
    color: var(--color-caption);         /* #adb5bd */
    font-size: var(--font-size-sm);      /* 0.875rem */
}
```

**Cambio de color de todos los títulos h1:**
```css
:root {
    --color-heading-h1: #39A900; /* Ahora todos los h1 son verdes SENA */
}
```

---

#### 4. **BANNERS** - Hero, Alertas, Notificaciones

```css
/* Hero Banner */
.hero-banner {
    background: var(--color-banner-hero-bg);         /* gradient verde SENA */
    color: var(--color-banner-hero-text);            /* #ffffff */
    padding: var(--space-10);                         /* 6rem */
}

.hero-banner .subtitle {
    color: var(--color-banner-hero-subtitle);        /* rgba(255,255,255,0.9) */
}

/* Banner de Información */
.banner-info {
    background: var(--color-banner-info-bg);         /* #d1ecf1 */
    color: var(--color-banner-info-text);            /* #0c5460 */
    border: var(--border-width-thin) solid var(--color-banner-info-border); /* #bee5eb */
    border-radius: var(--radius-md);
    padding: var(--space-5);
}

/* Banner de Advertencia */
.banner-warning {
    background: var(--color-banner-warning-bg);      /* #fff3cd */
    color: var(--color-banner-warning-text);         /* #856404 */
    border-left: var(--border-width-ultra) solid var(--color-banner-warning-border); /* 4px #ffeaa7 */
}

/* Banner de Éxito */
.banner-success {
    background: var(--color-banner-success-bg);      /* #d4edda */
    color: var(--color-banner-success-text);         /* #155724 */
    border-left: var(--border-width-ultra) solid var(--color-banner-success-border); /* 4px #c3e6cb */
}
```

**Cambiar color de fondo de hero globalmente:**
```css
:root {
    --color-banner-hero-bg: linear-gradient(135deg, #FF5733 0%, #C70039 100%); /* Rojo naranja */
}
```

---

#### 5. **ICONOS** - Estados Semánticos

```css
/* Iconos Primarios */
.icon-primary {
    color: var(--color-icon-primary);    /* #39A900 */
    font-size: var(--font-size-2xl);     /* 2rem */
}

/* Iconos por Estado */
.icon-success { color: var(--color-icon-success); }  /* #28a745 */
.icon-danger { color: var(--color-icon-danger); }    /* #dc3545 */
.icon-warning { color: var(--color-icon-warning); }  /* #ffc107 */
.icon-info { color: var(--color-icon-info); }        /* #17a2b8 */
.icon-muted { color: var(--color-icon-muted); }      /* #adb5bd */

/* Iconos en navegación */
.nav-icon {
    color: var(--color-icon-secondary);  /* #6c757d */
    margin-right: var(--space-2);        /* 0.5rem */
}

.nav-icon.active {
    color: var(--color-icon-primary);    /* #39A900 */
}

/* Feature Icons (landing page) */
.feature-icon {
    color: var(--color-icon-primary);    /* #39A900 */
    font-size: var(--font-size-3xl);     /* 2.5rem */
    margin-bottom: var(--space-3);       /* 0.75rem */
}
```

**Cambiar color de TODOS los iconos primarios:**
```css
:root {
    --color-icon-primary: #FF6B35; /* Todos los iconos primarios ahora naranjas */
}
```

---

#### 6. **SPANS Y LABELS** - Destacados y Estados

```css
/* Span Primario (destacado) */
.span-primary, .text-primary {
    color: var(--color-span-primary);    /* #39A900 */
    font-weight: var(--font-weight-medium);
}

/* Span Secundario */
.span-secondary {
    color: var(--color-span-secondary);  /* #6c757d */
}

/* Span Muted */
.span-muted, .text-muted {
    color: var(--color-span-muted);      /* #adb5bd */
}

/* Span Resaltado */
.span-highlight, mark {
    background: var(--color-span-highlight); /* #ffc107 */
    padding: var(--space-1) var(--space-2);
    border-radius: var(--radius-sm);
}

/* Span de Error */
.span-error, .text-danger {
    color: var(--color-span-error);      /* #dc3545 */
    font-weight: var(--font-weight-semibold);
}

/* Labels de formulario */
label {
    color: var(--color-text-primary);    /* #212529 */
    font-weight: var(--font-weight-medium);
    margin-bottom: var(--space-2);
}

label.required::after {
    content: '*';
    color: var(--color-span-error);      /* #dc3545 */
    margin-left: var(--space-1);
}
```

---

#### 7. **BADGES** - Etiquetas y Estados

```css
/* Badge Base */
.badge {
    padding: var(--space-2) var(--space-3);
    border-radius: var(--radius-xl);              /* 20px - redondeado */
    font-size: var(--font-size-sm);               /* 0.875rem */
    font-weight: var(--font-weight-semibold);
    display: inline-block;
}

/* Badge Primario */
.badge-primary {
    background: var(--color-badge-primary-bg);    /* #39A900 */
    color: var(--color-badge-primary-text);       /* #ffffff */
}

/* Badge Secundario */
.badge-secondary {
    background: var(--color-badge-secondary-bg);  /* #6c757d */
    color: var(--color-badge-secondary-text);     /* #ffffff */
}

/* Badge Success */
.badge-success {
    background: var(--color-badge-success-bg);    /* #28a745 */
    color: var(--color-badge-success-text);       /* #ffffff */
}

/* Badge Danger */
.badge-danger {
    background: var(--color-badge-danger-bg);     /* #dc3545 */
    color: var(--color-badge-danger-text);        /* #ffffff */
}

/* Badge Warning */
.badge-warning {
    background: var(--color-badge-warning-bg);    /* #ffc107 */
    color: var(--color-badge-warning-text);       /* #212529 - texto oscuro */
}

/* Badge Info */
.badge-info {
    background: var(--color-badge-info-bg);       /* #17a2b8 */
    color: var(--color-badge-info-text);          /* #ffffff */
}

/* Badge con gradiente (Programas) */
.badge-programa {
    background: var(--gradient-sena-primary);
    color: #ffffff;
}
```

---

#### 8. **CARDS** - Tarjetas y Contenedores

```css
/* Card Base */
.card {
    background: var(--color-card-bg);             /* #ffffff */
    border: var(--border-width-thin) solid var(--color-card-border); /* 1px #dee2e6 */
    border-radius: var(--radius-lg);              /* 12px */
    box-shadow: var(--shadow-md);                 /* 0 2px 8px rgba(0,0,0,0.08) */
    overflow: hidden;
}

.card:hover {
    box-shadow: var(--shadow-lg);                 /* 0 4px 12px rgba(0,0,0,0.12) */
    transform: translateY(-4px);
    transition: var(--transition-all);
}

/* Card Header */
.card-header {
    background: var(--color-card-header-bg);      /* #f8f9fa */
    color: var(--color-card-header-text);         /* #495057 */
    padding: var(--space-4);
    border-bottom: var(--border-width-thin) solid var(--color-card-border);
}

/* Card Body */
.card-body {
    padding: var(--space-5);
    color: var(--color-text-primary);
}

/* Card Title */
.card-title {
    color: var(--color-heading-h3);               /* #495057 */
    font-size: var(--font-size-lg);
    font-weight: var(--font-weight-semibold);
    margin-bottom: var(--space-3);
}

/* Card Text */
.card-text {
    color: var(--color-text-secondary);           /* #6c757d */
    line-height: var(--line-height-normal);
}
```

---

## 📋 TABLA DE CONTROL POR COMPONENTE

| Componente | Variables CSS | Cambio Global | Archivo |
|------------|---------------|---------------|---------|
| **Botones** | `--color-btn-primary-bg`<br>`--color-btn-primary-hover-bg`<br>`--color-btn-danger-bg` | 1 línea | `_colors.css` |
| **Bordes** | `--color-border-card`<br>`--color-border-input`<br>`--color-border-primary` | 1 línea | `_colors.css` |
| **Títulos** | `--color-heading-h1`<br>`--color-heading-h2`<br>`--color-heading-h3` | 1 línea | `_colors.css` |
| **Párrafos** | `--color-text-primary`<br>`--color-text-secondary`<br>`--color-lead` | 1 línea | `_colors.css` |
| **Subtítulos** | `--color-subtitle`<br>`--color-caption` | 1 línea | `_colors.css` |
| **Banners** | `--color-banner-hero-bg`<br>`--color-banner-info-bg`<br>`--color-banner-warning-bg` | 1 línea | `_colors.css` |
| **Iconos** | `--color-icon-primary`<br>`--color-icon-success`<br>`--color-icon-muted` | 1 línea | `_colors.css` |
| **Spans** | `--color-span-primary`<br>`--color-span-highlight`<br>`--color-span-error` | 1 línea | `_colors.css` |
| **Badges** | `--color-badge-primary-bg`<br>`--color-badge-danger-bg`<br>`--color-badge-warning-bg` | 1 línea | `_colors.css` |
| **Cards** | `--color-card-bg`<br>`--color-card-border`<br>`--color-card-header-bg` | 1 línea | `_colors.css` |

---

## 🎯 EJEMPLO PRÁCTICO: CAMBIO GLOBAL INSTANTÁNEO

```css
/* ANTES: Cambiar color de botones requería editar 3 archivos */
/* admin.css línea 120 */
.btn-admin-primary { background: #39A900; }

/* public.css línea 103 */
.btn-public-primary { background: #39A900; }

/* home.css línea 45 */
.btn-sena { background: #39A900; }

/* ❌ 3 archivos editados, inconsistencias, mantenimiento complejo */
```

```css
/* DESPUÉS: 1 línea en _colors.css controla TODO */
:root {
    --color-btn-primary-bg: #FF5733; /* ← ÚNICO cambio necesario */
}

/* ✅ Resultado automático:
   - Todos los botones primarios → naranja
   - Hovers ajustados automáticamente
   - Sin tocar admin.css, public.css, home.css
   - Consistencia garantizada
*/
```

---

## 🚀 IMPLEMENTACIÓN RECOMENDADA

### Prioridad 1: Componentes Más Usados
1. ✅ **Botones** (4 variantes: primary, secondary, outline, danger)
2. ✅ **Títulos y Textos** (h1-h4, párrafos, subtítulos)
3. ✅ **Bordes** (cards, inputs, dividers)
4. ✅ **Iconos** (primary, secondary, estados semánticos)

### Prioridad 2: Componentes Visuales
5. ✅ **Banners** (hero, info, warning, success)
6. ✅ **Badges** (6 variantes de estado)
7. ✅ **Cards** (background, border, header, shadow)
8. ✅ **Spans/Labels** (destacados, errores, muted)

### Prioridad 3: Estados y Variantes
9. ✅ **Hovers** (todos los componentes interactivos)
10. ✅ **Focus** (inputs, botones, links)
11. ✅ **Active** (navegación, tabs)
12. ✅ **Disabled** (formularios, botones)

---

### 1. **Control Total desde un Punto Central**
```css
/* Cambiar color principal en TODO el sitio editando UNA línea: */
:root {
    --color-sena-primary: #39A900; /* ← Solo aquí */
}
```

### 2. **Reducción de Código**
- **Antes**: 74 colores hardcodeados en 3 archivos
- **Después**: 1 archivo con ~40 variables reutilizables
- **Reducción**: ~60% menos repetición

### 3. **Tematización Dinámica Preparada**
```css
/* Dark Mode Future Ready */
:root[data-theme="dark"] {
    --color-bg-primary: #1a1a1a;
    --color-text-primary: #ffffff;
    /* Sobrescribir solo lo necesario */
}
```

### 4. **Consistencia de Diseño**
- Gradientes estandarizados
- Sistema de espaciado uniforme
- Jerarquía de sombras clara
- Tipografía consistente

### 5. **Mantenibilidad**
- Cambiar un color: 1 archivo editado
- Agregar nuevo tema: extender `:root`
- Nuevos componentes: usar tokens existentes

### 6. **Performance**
- CSS Variables son nativas del navegador
- Cambios en tiempo real sin recargar CSS
- Mejor caché (tokens raramente cambian)

---

## 🚀 COMANDO DE EJECUCIÓN

Una vez aprobado, ejecutar:

```bash
# Fase 1: Crear estructura
git checkout -b feature/css-design-tokens

# Fase 2-5: Implementar tokens y refactorizar
# (commits incrementales por fase)

# Fase 6: Integrar Bootstrap
npm run build  # Compilar SCSS

# Fase 7: Actualizar vistas
# (editar layouts blade)

# Fase 8: Testing
php artisan serve
# Validar en navegador

# Final: Merge
git commit -m "feat: implementar sistema de design tokens CSS centralizado"
```

---

## 📊 MÉTRICAS DE ÉXITO

| Métrica | Antes | Después | Mejora |
|---------|-------|---------|--------|
| Colores hardcodeados | 74 | 0 | 100% |
| Archivos CSS raíz | 4 | 1 (main.css) | -75% |
| Tiempo cambiar color global | ~15 min | 30 seg | 97% |
| Líneas CSS duplicadas | ~200 | ~50 | 75% |
| Componentes reutilizables | 3 | 10+ | 233% |

---

## ⚠️ COLORES LEGACY A ELIMINAR

Estos colores NO pertenecen a SENA y deben eliminarse/reemplazar:

```css
/* Morados - Legacy de template */
#667eea, #764ba2  → Reemplazar por gradiente SENA

/* Rosas - Legacy */
#f093fb, #f5576c  → Reemplazar por gradiente SENA

/* Cianos - Legacy */
#4facfe, #00f2fe  → Reemplazar por gradiente SENA o color info

/* Azul spinner */
#3498db  → Reemplazar por --color-sena-primary
```

---

## 🎨 EJEMPLO FINAL: UN CAMBIO, TODO ACTUALIZADO

```css
/* EN: resources/css/tokens/_colors.css */
:root {
    --color-sena-primary: #FF5733;  /* ← Cambio de naranja */
}

/* RESULTADO AUTOMÁTICO EN TODO EL SITIO:
   ✅ Sidebar admin → naranja
   ✅ Botones → naranja
   ✅ Enlaces → naranja
   ✅ Badges → naranja
   ✅ Hero sections → naranja
   ✅ Iconos → naranja
   ✅ Breadcrumbs → naranja
   
   SIN tocar ningún otro archivo CSS
*/
```

---

## 📌 CONCLUSIÓN

La arquitectura actual tiene **fragmentación crítica** que impide el control centralizado. La implementación de un **sistema de Design Tokens con CSS Variables** resuelve todos los problemas identificados y prepara el proyecto para:

- ✅ Tematización dinámica (dark mode)
- ✅ Cambios de branding instantáneos
- ✅ Escalabilidad sin duplicación
- ✅ Mantenimiento simplificado

**Tiempo total estimado**: 6-8 horas
**Impacto**: Alto - Refactor estructural que facilita todo desarrollo futuro
**Riesgo**: Bajo - CSS es retrocompatible, se puede migrar incrementalmente

---

**¿Proceder con la implementación?**
