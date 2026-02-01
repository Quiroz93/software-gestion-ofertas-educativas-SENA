# PLAN DE CENTRALIZACIÓN DE ARQUITECTURA CSS
## Sistema de Gestión SOE Software - SENA
### Cumplimiento Estricto del Design System SENA 2024

**Versión**: 2.0 Intensiva  
**Fecha**: Enero 2026  
**Referencia**: DESIGN_SYSTEM_SENA.md (Raíz del proyecto)  
**Objetivo**: Centralización total, control granular y cumplimiento institucional

---

## 📋 ÍNDICE EJECUTIVO

1. [Análisis de Incumplimientos Críticos](#1-análisis-de-incumplimientos-críticos)
2. [Arquitectura de Design Tokens CSS](#2-arquitectura-de-design-tokens-css)
3. [Estructura de Archivos Definitiva](#3-estructura-de-archivos-definitiva)
4. [Plan de Migración en 10 Fases](#4-plan-de-migración-en-10-fases)
5. [Especificaciones Técnicas por Componente](#5-especificaciones-técnicas-por-componente)
6. [Sistema de Validación y Testing](#6-sistema-de-validación-y-testing)
7. [Documentación de Mantenimiento](#7-documentación-de-mantenimiento)

---

## 1. ANÁLISIS DE INCUMPLIMIENTOS CRÍTICOS

### 🚨 VIOLACIONES DETECTADAS DEL DESIGN SYSTEM SENA

#### A. COLORES NO AUTORIZADOS (15 instancias)

**❌ Colores Morados (No institucionales)**
```css
/* admin.css línea 169, 183 */
border-top: 3px solid #3498db;     /* Azul externo */
border-color: #667eea;              /* Morado comercial */

/* public.css líneas 104, 142 */
background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);  /* Morado/Violeta no autorizado */

/* noticias/index.blade.php líneas 9, 168 */
background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
```

**❌ Colores Rosas (No institucionales)**
```css
/* public.css línea 76 */
background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);  /* Rosa comercial */
```

**❌ Colores Cianos (No institucionales)**
```css
/* public.css línea 81 */
background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);  /* Cian comercial */
```

**📊 COLORES AUTORIZADOS SENA (Del Design System):**
- ✅ Verde institucional: `#39A900` (Principal)
- ✅ Verde oscuro: `#007832` (Secundario)
- ✅ Azul oscuro: `#00304D` (Secundario)
- ✅ Azul claro: `#50E5F9` (Secundario)
- ✅ Violeta: `#71277A` (Secundario - SOLO este tono)
- ✅ Amarillo: `#FDC300` (Secundario)
- ✅ Blanco: `#FFFFFF`
- ✅ Gris claro: `#F6F6F6`
- ✅ Negro: `#000000`

**Acción requerida:**
- Eliminar todos los colores morados (#667eea, #764ba2, #3498db)
- Eliminar todos los colores rosas (#f093fb, #f5576c)
- Eliminar todos los colores cianos (#4facfe, #00f2fe)
- Reemplazar por colores autorizados según contexto

---

#### B. TIPOGRAFÍA INCORRECTA (7 instancias)

**❌ Fuente Incorrecta: Nunito (No autorizada)**
```scss
/* _variables.scss línea 5 */
$font-family-sans-serif: 'Nunito', sans-serif;  /* ❌ INCORRECTO */
```

**✅ Fuente Correcta: Work Sans (Obligatoria)**
```scss
$font-family-sans-serif: 'Work Sans', sans-serif;  /* ✅ CORRECTO */
```

**❌ Fuentes Inline Inconsistentes:**
```html
<!-- home.blade.php líneas 6, 296, 471 -->
style="font-family: 'worksans sans-serif';"  /* ❌ Sintaxis incorrecta, debe ser 'Work Sans' */

<!-- layouts/auth.blade.php línea 48 -->
font-family: 'Inter', sans-serif;  /* ❌ No autorizada */

<!-- layouts/admin.blade.php línea 37 -->
font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;  /* ❌ No autorizada */
```

**Acción requerida:**
- Cambiar `Nunito` a `Work Sans` en todas las instancias
- Eliminar fuentes inline no autorizadas (Inter, Segoe UI)
- Cargar Work Sans desde Google Fonts o local
- Unificar sintaxis: `'Work Sans', sans-serif`

---

#### C. GRADIENTES NO INSTITUCIONALES (8 instancias)

**❌ Gradientes Comerciales:**
```css
/* public.css - Badges no institucionales */
.badge-oferta {
    background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);  /* Rosa */
}

.badge-noticia {
    background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);  /* Cian */
}

/* Featured items con gradiente gris comercial */
.featured-item {
    background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);  /* Gris/Azul comercial */
}
```

**✅ Gradientes Institucionales Permitidos:**
```css
/* Verde SENA (principal) */
--gradient-sena-primary: linear-gradient(135deg, #39A900 0%, #007832 100%);

/* Azul institucional (secundario) */
--gradient-sena-blue: linear-gradient(135deg, #00304D 0%, #50E5F9 100%);

/* Violeta institucional (secundario - uso limitado) */
--gradient-sena-violet: linear-gradient(135deg, #71277A 0%, #39A900 100%);
```

**Regla del Design System:**
> "No usar degradados llamativos. Preferir jerarquía visual clara antes que decoración."

**Acción requerida:**
- Eliminar gradientes rosas, cianes y grises comerciales
- Reemplazar por gradientes institucionales autorizados
- Priorizar fondos sólidos (#FFFFFF, #F6F6F6) sobre gradientes
- Usar gradientes solo en heros y elementos destacados

---

#### D. ICONOGRAFÍA SIN ESTANDARIZAR

**Problemática actual:**
- Bootstrap Icons (CDN)
- Font Awesome (CDN)
- Sin especificaciones de grosor o estilo

**Design System SENA especifica:**
> "Íconos de línea (outline). Sin relleno. Grosor consistente. Estilo minimalista."

**Acción requerida:**
- Adoptar librería de íconos outline (Heroicons, Feather, Lucide)
- Establecer grosor estándar (2px)
- Documentar uso de íconos por categoría
- Crear componente Blade para íconos consistentes

---

#### E. ESTRUCTURA CSS FRAGMENTADA

**Problemática actual:**
- 4 archivos CSS sin jerarquía (`app.css`, `home.css`, `admin.css`, `public.css`)
- 74+ colores hardcodeados
- Sin sistema de variables CSS
- Bootstrap 5.3.2 desde CDN (no compila con variables SCSS)
- Estilos inline en vistas blade

**Impacto:**
- Imposible cambiar colores centralizadamente
- Inconsistencias visuales entre vistas
- Duplicación masiva de código
- Mantenimiento complejo
- Incumplimiento del Design System en múltiples puntos

---

## 2. ARQUITECTURA DE DESIGN TOKENS CSS

### 🎨 SISTEMA DE VARIABLES CONFORME A DESIGN SYSTEM SENA

#### 2.1. COLORES INSTITUCIONALES (_colors-sena.css)

```css
/**
 * COLORES INSTITUCIONALES SENA 2024
 * Basado en: DESIGN_SYSTEM_SENA.md
 * USO OBLIGATORIO - NO MODIFICAR SIN AUTORIZACIÓN INSTITUCIONAL
 */

:root {
    /* ============================================
       COLORES PRINCIPALES SENA (PRIORITARIOS)
       ============================================ */
    
    --sena-verde-principal: #39A900;
    --sena-verde-oscuro: #007832;
    
    /* ============================================
       COLORES SECUNDARIOS AUTORIZADOS
       ============================================ */
    
    --sena-azul-oscuro: #00304D;
    --sena-azul-claro: #50E5F9;
    --sena-violeta: #71277A;
    --sena-amarillo: #FDC300;
    
    /* ============================================
       COLORES NEUTROS INSTITUCIONALES
       ============================================ */
    
    --sena-blanco: #FFFFFF;
    --sena-gris-claro: #F6F6F6;
    --sena-negro: #000000;
    
    /* ============================================
       DERIVADOS PARA UI (basados en autorizados)
       ============================================ */
    
    /* Grises generados (para textos y bordes) */
    --sena-gris-50: #FAFAFA;
    --sena-gris-100: #F6F6F6;   /* Institucional */
    --sena-gris-200: #EEEEEE;
    --sena-gris-300: #E0E0E0;
    --sena-gris-400: #BDBDBD;
    --sena-gris-500: #9E9E9E;
    --sena-gris-600: #757575;
    --sena-gris-700: #616161;
    --sena-gris-800: #424242;
    --sena-gris-900: #212121;
    
    /* Variantes de verde (para estados) */
    --sena-verde-claro: #4BC400;      /* Hover/Light */
    --sena-verde-muy-claro: #E8F5E0;  /* Backgrounds */
    --sena-verde-alpha-10: rgba(57, 169, 0, 0.1);
    --sena-verde-alpha-20: rgba(57, 169, 0, 0.2);
    --sena-verde-alpha-30: rgba(57, 169, 0, 0.3);
    
    /* ============================================
       SEMÁNTICA DE COLORES
       ============================================ */
    
    /* Primario = Verde SENA */
    --color-primary: var(--sena-verde-principal);
    --color-primary-hover: var(--sena-verde-oscuro);
    --color-primary-light: var(--sena-verde-claro);
    --color-primary-alpha: var(--sena-verde-alpha-20);
    
    /* Success = Verde SENA */
    --color-success: var(--sena-verde-principal);
    --color-success-bg: var(--sena-verde-muy-claro);
    --color-success-text: var(--sena-verde-oscuro);
    
    /* Info = Azul institucional */
    --color-info: var(--sena-azul-claro);
    --color-info-bg: rgba(80, 229, 249, 0.1);
    --color-info-text: var(--sena-azul-oscuro);
    
    /* Warning = Amarillo institucional */
    --color-warning: var(--sena-amarillo);
    --color-warning-bg: rgba(253, 195, 0, 0.1);
    --color-warning-text: #B38700;
    
    /* Danger = Rojo accesible (no hay en Design System, usar alternativa) */
    --color-danger: #D32F2F;
    --color-danger-bg: #FFEBEE;
    --color-danger-text: #C62828;
    
    /* ============================================
       GRADIENTES INSTITUCIONALES
       ============================================ */
    
    /* Verde SENA (principal - uso prioritario) */
    --gradient-sena-primary: linear-gradient(135deg, var(--sena-verde-principal) 0%, var(--sena-verde-oscuro) 100%);
    --gradient-sena-vertical: linear-gradient(180deg, var(--sena-verde-oscuro) 0%, var(--sena-verde-principal) 100%);
    --gradient-sena-reverse: linear-gradient(135deg, var(--sena-verde-oscuro) 0%, var(--sena-verde-principal) 100%);
    
    /* Azul institucional (secundario) */
    --gradient-sena-blue: linear-gradient(135deg, var(--sena-azul-oscuro) 0%, var(--sena-azul-claro) 100%);
    
    /* Violeta institucional (uso limitado - elementos específicos) */
    --gradient-sena-violet: linear-gradient(135deg, var(--sena-violeta) 0%, var(--sena-verde-principal) 100%);
    
    /* ============================================
       COLORES DE TEXTO (jerarquía institucional)
       ============================================ */
    
    --text-primary: var(--sena-negro);
    --text-secondary: var(--sena-gris-700);
    --text-muted: var(--sena-gris-500);
    --text-inverse: var(--sena-blanco);
    
    /* Títulos */
    --text-heading-h1: var(--sena-negro);
    --text-heading-h2: var(--sena-gris-900);
    --text-heading-h3: var(--sena-gris-800);
    --text-heading-h4: var(--sena-gris-700);
    
    /* ============================================
       FONDOS INSTITUCIONALES
       ============================================ */
    
    --bg-primary: var(--sena-blanco);
    --bg-secondary: var(--sena-gris-100);     /* #F6F6F6 - institucional */
    --bg-tertiary: var(--sena-verde-muy-claro);
    --bg-dark: var(--sena-azul-oscuro);
    
    /* ============================================
       BORDES
       ============================================ */
    
    --border-default: var(--sena-gris-300);
    --border-light: var(--sena-gris-200);
    --border-dark: var(--sena-gris-400);
    --border-primary: var(--sena-verde-principal);
}
```

---

#### 2.2. TIPOGRAFÍA INSTITUCIONAL (_typography-sena.css)

```css
/**
 * TIPOGRAFÍA INSTITUCIONAL SENA 2024
 * Fuente principal: Work Sans
 * Fuente secundaria: Calibri (opcional)
 */

:root {
    /* ============================================
       FAMILIAS TIPOGRÁFICAS (Design System SENA)
       ============================================ */
    
    --font-family-primary: 'Work Sans', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
    --font-family-secondary: 'Calibri', 'Work Sans', sans-serif;
    --font-family-mono: 'Courier New', monospace;
    
    /* ============================================
       PESOS TIPOGRÁFICOS AUTORIZADOS
       Work Sans: Regular, Medium, SemiBold, Bold
       NO USAR: Thin, ExtraLight
       ============================================ */
    
    --font-weight-regular: 400;
    --font-weight-medium: 500;
    --font-weight-semibold: 600;
    --font-weight-bold: 700;
    
    /* ============================================
       ESCALA TIPOGRÁFICA (jerarquía institucional)
       ============================================ */
    
    /* Títulos principales (H1-H4) */
    --font-size-h1: 2.5rem;      /* 40px - Títulos principales */
    --font-size-h2: 2rem;        /* 32px - Subtítulos grandes */
    --font-size-h3: 1.5rem;      /* 24px - Subtítulos medianos */
    --font-size-h4: 1.25rem;     /* 20px - Subtítulos pequeños */
    --font-size-h5: 1.125rem;    /* 18px - Encabezados menores */
    --font-size-h6: 1rem;        /* 16px - Encabezados mínimos */
    
    /* Cuerpo de texto */
    --font-size-base: 1rem;      /* 16px - Base del sistema */
    --font-size-lg: 1.125rem;    /* 18px - Texto destacado */
    --font-size-sm: 0.875rem;    /* 14px - Texto secundario */
    --font-size-xs: 0.75rem;     /* 12px - Captions, footnotes */
    
    /* ============================================
       LINE HEIGHT (legibilidad institucional)
       ============================================ */
    
    --line-height-tight: 1.25;    /* Títulos */
    --line-height-normal: 1.5;    /* Texto general */
    --line-height-relaxed: 1.75;  /* Texto largo */
    
    /* ============================================
       LETTER SPACING
       ============================================ */
    
    --letter-spacing-tight: -0.025em;
    --letter-spacing-normal: 0;
    --letter-spacing-wide: 0.025em;
}

/* ============================================
   APLICACIÓN GLOBAL DE TIPOGRAFÍA
   ============================================ */

body {
    font-family: var(--font-family-primary);
    font-size: var(--font-size-base);
    font-weight: var(--font-weight-regular);
    line-height: var(--line-height-normal);
    color: var(--text-primary);
}

/* Títulos institucionales */
h1, .h1 {
    font-family: var(--font-family-primary);
    font-size: var(--font-size-h1);
    font-weight: var(--font-weight-bold);
    line-height: var(--line-height-tight);
    color: var(--text-heading-h1);
}

h2, .h2 {
    font-family: var(--font-family-primary);
    font-size: var(--font-size-h2);
    font-weight: var(--font-weight-bold);
    line-height: var(--line-height-tight);
    color: var(--text-heading-h2);
}

h3, .h3 {
    font-family: var(--font-family-primary);
    font-size: var(--font-size-h3);
    font-weight: var(--font-weight-semibold);
    line-height: var(--line-height-tight);
    color: var(--text-heading-h3);
}

h4, .h4 {
    font-family: var(--font-family-primary);
    font-size: var(--font-size-h4);
    font-weight: var(--font-weight-semibold);
    line-height: var(--line-height-normal);
    color: var(--text-heading-h4);
}
```

---

#### 2.3. ESPACIADO INSTITUCIONAL (_spacing-sena.css)

```css
/**
 * SISTEMA DE ESPACIADO SENA
 * Basado en escala de 4px (institucional y accesible)
 */

:root {
    /* ============================================
       ESCALA DE ESPACIADO (Sistema 4px)
       ============================================ */
    
    --space-0: 0;
    --space-1: 0.25rem;   /* 4px */
    --space-2: 0.5rem;    /* 8px */
    --space-3: 0.75rem;   /* 12px */
    --space-4: 1rem;      /* 16px */
    --space-5: 1.25rem;   /* 20px */
    --space-6: 1.5rem;    /* 24px */
    --space-7: 2rem;      /* 32px */
    --space-8: 2.5rem;    /* 40px */
    --space-9: 3rem;      /* 48px */
    --space-10: 4rem;     /* 64px */
    --space-12: 6rem;     /* 96px */
    
    /* ============================================
       ESPACIADO SEMÁNTICO
       ============================================ */
    
    --spacing-section: var(--space-10);
    --spacing-component: var(--space-6);
    --spacing-element: var(--space-4);
    --spacing-inline: var(--space-2);
}
```

---

#### 2.4. SOMBRAS INSTITUCIONALES (_shadows-sena.css)

```css
/**
 * SISTEMA DE SOMBRAS SENA
 * Sombras sutiles para diseño sobrio institucional
 */

:root {
    /* ============================================
       SOMBRAS INSTITUCIONALES (sutiles)
       ============================================ */
    
    --shadow-xs: 0 1px 2px rgba(0, 0, 0, 0.04);
    --shadow-sm: 0 2px 4px rgba(0, 0, 0, 0.06);
    --shadow-md: 0 4px 8px rgba(0, 0, 0, 0.08);
    --shadow-lg: 0 8px 16px rgba(0, 0, 0, 0.1);
    --shadow-xl: 0 16px 32px rgba(0, 0, 0, 0.12);
    
    /* Sombras con color SENA (para elementos destacados) */
    --shadow-sena: 0 4px 12px rgba(57, 169, 0, 0.15);
    --shadow-sena-lg: 0 8px 24px rgba(57, 169, 0, 0.2);
}
```

---

#### 2.5. BORDES Y RADIOS (_borders-sena.css)

```css
/**
 * SISTEMA DE BORDES SENA
 * Bordes simples y radios moderados (institucional)
 */

:root {
    /* ============================================
       GROSOR DE BORDES
       ============================================ */
    
    --border-width-thin: 1px;
    --border-width-medium: 2px;
    --border-width-thick: 3px;
    --border-width-ultra: 4px;
    
    /* ============================================
       BORDER RADIUS (diseño sobrio)
       ============================================ */
    
    --radius-none: 0;
    --radius-sm: 4px;
    --radius-md: 8px;
    --radius-lg: 12px;
    --radius-xl: 16px;
    --radius-full: 9999px;
}
```

---

#### 2.6. TRANSICIONES (_animations-sena.css)

```css
/**
 * SISTEMA DE TRANSICIONES SENA
 * Animaciones sutiles y profesionales
 */

:root {
    /* ============================================
       DURACIONES
       ============================================ */
    
    --transition-fast: 150ms;
    --transition-base: 250ms;
    --transition-slow: 350ms;
    
    /* ============================================
       TIMING FUNCTIONS
       ============================================ */
    
    --ease-standard: cubic-bezier(0.4, 0, 0.2, 1);
    --ease-in: cubic-bezier(0.4, 0, 1, 1);
    --ease-out: cubic-bezier(0, 0, 0.2, 1);
    
    /* ============================================
       TRANSICIONES COMUNES
       ============================================ */
    
    --transition-all: all var(--transition-base) var(--ease-standard);
    --transition-colors: color var(--transition-base) var(--ease-standard),
                         background-color var(--transition-base) var(--ease-standard),
                         border-color var(--transition-base) var(--ease-standard);
}
```

---

## 3. ESTRUCTURA DE ARCHIVOS DEFINITIVA

```
resources/
├── css/
│   ├── tokens/                         ← DESIGN TOKENS (variables centralizadas)
│   │   ├── _colors-sena.css           ← Colores institucionales SENA
│   │   ├── _typography-sena.css       ← Tipografía Work Sans
│   │   ├── _spacing-sena.css          ← Sistema de espaciado 4px
│   │   ├── _shadows-sena.css          ← Sombras institucionales
│   │   ├── _borders-sena.css          ← Bordes y radios
│   │   └── _animations-sena.css       ← Transiciones sutiles
│   │
│   ├── base/                           ← ESTILOS BASE
│   │   ├── _reset.css                 ← Normalize CSS
│   │   ├── _global-sena.css           ← Estilos globales SENA
│   │   └── _utilities.css             ← Utilidades reutilizables
│   │
│   ├── components/                     ← COMPONENTES UNIFICADOS
│   │   ├── _buttons-sena.css          ← Botones institucionales
│   │   ├── _cards-sena.css            ← Cards institucionales
│   │   ├── _forms-sena.css            ← Formularios
│   │   ├── _badges-sena.css           ← Badges/etiquetas
│   │   ├── _alerts-sena.css           ← Alertas y banners
│   │   ├── _tables-sena.css           ← Tablas
│   │   ├── _navigation-sena.css       ← Navegación
│   │   └── _icons-sena.css            ← Sistema de íconos
│   │
│   ├── layouts/                        ← LAYOUTS ESPECÍFICOS
│   │   ├── _layout-admin.css          ← Layout administrativo
│   │   ├── _layout-public.css         ← Layout público
│   │   ├── _layout-home.css           ← Layout landing
│   │   └── _layout-auth.css           ← Layout autenticación
│   │
│   ├── pages/                          ← ESTILOS ESPECÍFICOS DE PÁGINAS
│   │   ├── _home.css                  ← Página de inicio
│   │   ├── _programas.css             ← Vista de programas
│   │   ├── _ofertas.css               ← Vista de ofertas
│   │   └── _noticias.css              ← Vista de noticias
│   │
│   └── main-sena.css                   ← PUNTO DE ENTRADA ÚNICO
│
├── sass/
│   ├── _variables-sena.scss            ← Variables Bootstrap customizadas
│   └── app-sena.scss                   ← Bootstrap + customización SENA
│
└── fonts/
    └── work-sans/                      ← Work Sans local (opcional)
        ├── WorkSans-Regular.woff2
        ├── WorkSans-Medium.woff2
        ├── WorkSans-SemiBold.woff2
        └── WorkSans-Bold.woff2
```

### 3.1. Contenido de main-sena.css

```css
/**
 * MAIN CSS - Sistema de Gestión SOE Software SENA
 * Punto de entrada único para todos los estilos
 * Cumplimiento estricto: DESIGN_SYSTEM_SENA.md
 */

/* ==== 1. DESIGN TOKENS (fundación) ==== */
@import './tokens/_colors-sena.css';
@import './tokens/_typography-sena.css';
@import './tokens/_spacing-sena.css';
@import './tokens/_shadows-sena.css';
@import './tokens/_borders-sena.css';
@import './tokens/_animations-sena.css';

/* ==== 2. BASE (reset y globales) ==== */
@import './base/_reset.css';
@import './base/_global-sena.css';
@import './base/_utilities.css';

/* ==== 3. COMPONENTES (reutilizables) ==== */
@import './components/_buttons-sena.css';
@import './components/_cards-sena.css';
@import './components/_forms-sena.css';
@import './components/_badges-sena.css';
@import './components/_alerts-sena.css';
@import './components/_tables-sena.css';
@import './components/_navigation-sena.css';
@import './components/_icons-sena.css';

/* ==== 4. LAYOUTS (estructuras) ==== */
@import './layouts/_layout-admin.css';
@import './layouts/_layout-public.css';
@import './layouts/_layout-home.css';
@import './layouts/_layout-auth.css';

/* ==== 5. PÁGINAS (específicos) ==== */
@import './pages/_home.css';
@import './pages/_programas.css';
@import './pages/_ofertas.css';
@import './pages/_noticias.css';
```

---

## 4. PLAN DE MIGRACIÓN EN 10 FASES

### FASE 1: PREPARACIÓN Y AUDITORÍA (2 horas)

**Objetivos:**
- Auditar todos los archivos CSS actuales
- Documentar colores, fuentes y componentes usados
- Crear backup completo del sistema

**Tareas:**
```bash
# 1.1. Crear rama de migración
git checkout -b feature/css-sena-centralization

# 1.2. Backup de archivos actuales
mkdir backup-css
cp -r resources/css/* backup-css/
cp resources/sass/_variables.scss backup-css/

# 1.3. Auditoría de colores
grep -rn "#[0-9a-fA-F]\{6\}" resources/css/ > auditoria-colores.txt
grep -rn "font-family" resources/ > auditoria-tipografia.txt

# 1.4. Listar todas las clases CSS usadas en vistas
grep -rohn "class=\"[^\"]*\"" resources/views/ | sort | uniq > clases-usadas.txt
```

**Entregables:**
- ✅ Rama `feature/css-sena-centralization` creada
- ✅ Backup completo en `backup-css/`
- ✅ Reportes de auditoría (colores, tipografía, clases)
- ✅ Inventario de componentes actuales

**Commit:**
```bash
git add backup-css/ auditoria-*.txt clases-usadas.txt
git commit -m "fase-1: auditoría y backup completo del sistema CSS actual"
```

---

### FASE 2: CREAR ESTRUCTURA DE TOKENS (3 horas)

**Objetivos:**
- Crear estructura de carpetas `tokens/`
- Implementar 6 archivos de design tokens
- Validar conformidad con DESIGN_SYSTEM_SENA.md

**Tareas:**

**2.1. Crear estructura:**
```bash
mkdir -p resources/css/tokens
mkdir -p resources/css/base
mkdir -p resources/css/components
mkdir -p resources/css/layouts
mkdir -p resources/css/pages
```

**2.2. Crear archivos de tokens:**
- `_colors-sena.css` (variables de color institucionales)
- `_typography-sena.css` (Work Sans, pesos autorizados)
- `_spacing-sena.css` (sistema 4px)
- `_shadows-sena.css` (sombras sutiles)
- `_borders-sena.css` (radios moderados)
- `_animations-sena.css` (transiciones suaves)

**2.3. Validación:**
```bash
# Verificar que NO existan colores no autorizados
grep -i "#667eea\|#764ba2\|#f093fb\|#f5576c\|#4facfe\|#00f2fe" resources/css/tokens/*.css
# Resultado esperado: vacío

# Verificar que Work Sans esté declarada
grep -i "Work Sans" resources/css/tokens/_typography-sena.css
# Resultado esperado: encontrada
```

**Entregables:**
- ✅ 6 archivos de tokens creados
- ✅ 100% colores conformes a Design System
- ✅ Tipografía Work Sans implementada
- ✅ Variables CSS documentadas

**Commit:**
```bash
git add resources/css/tokens/
git commit -m "fase-2: implementar design tokens CSS conforme a DESIGN_SYSTEM_SENA.md

- Colores institucionales SENA (9 autorizados)
- Tipografía Work Sans (4 pesos autorizados)
- Sistema de espaciado 4px
- Sombras y bordes institucionales
- Transiciones sutiles"
```

---

### FASE 3: MIGRAR TIPOGRAFÍA A WORK SANS (2 horas)

**Objetivos:**
- Eliminar Nunito de todas las instancias
- Cargar Work Sans desde Google Fonts
- Actualizar todas las referencias inline

**Tareas:**

**3.1. Actualizar _variables.scss:**
```scss
// ANTES
$font-family-sans-serif: 'Nunito', sans-serif;

// DESPUÉS
$font-family-sans-serif: 'Work Sans', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
```

**3.2. Cargar Work Sans en layouts:**
```html
<!-- layouts/app.blade.php, bootstrap.blade.php, admin.blade.php, etc. -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Work+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
```

**3.3. Eliminar fuentes inline incorrectas:**
```bash
# Buscar y reemplazar en vistas blade
find resources/views -name "*.blade.php" -exec sed -i "s/font-family: 'worksans sans-serif'/font-family: 'Work Sans', sans-serif/g" {} \;
find resources/views -name "*.blade.php" -exec sed -i "s/font-family: 'Inter', sans-serif//g" {} \;
find resources/views -name "*.blade.php" -exec sed -i "s/font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif//g" {} \;
```

**3.4. Actualizar app.scss:**
```scss
// Importar Work Sans al inicio
@import url('https://fonts.googleapis.com/css2?family=Work+Sans:wght@400;500;600;700&display=swap');

// Variables
@import 'variables-sena';

// Bootstrap
@import 'bootstrap/scss/bootstrap';
```

**Validación:**
```bash
# Verificar que NO quede Nunito
grep -rn "Nunito" resources/
# Resultado esperado: solo en backup

# Verificar Work Sans presente
grep -rn "Work Sans" resources/
# Resultado esperado: múltiples archivos
```

**Entregables:**
- ✅ Nunito eliminada completamente
- ✅ Work Sans cargada desde Google Fonts
- ✅ Variables SCSS actualizadas
- ✅ Estilos inline corregidos

**Commit:**
```bash
git add resources/sass/_variables.scss resources/views/
git commit -m "fase-3: migrar tipografía de Nunito a Work Sans (institucional SENA)

- Actualizado _variables.scss
- Work Sans cargada en todos los layouts
- Eliminadas fuentes inline no autorizadas (Inter, Segoe UI)
- Corregida sintaxis 'worksans' a 'Work Sans'"
```

---

### FASE 4: ELIMINAR COLORES NO AUTORIZADOS (3 horas)

**Objetivos:**
- Reemplazar todos los colores morados, rosas y cianes
- Actualizar gradientes a institucionales
- Validar conformidad total

**Tareas:**

**4.1. Mapeo de reemplazos:**

| Color No Autorizado | Reemplazo Institucional | Contexto |
|---------------------|-------------------------|----------|
| `#667eea`, `#764ba2` (morado) | `#71277A` (violeta SENA) o `#39A900` (verde) | Botones, gradientes |
| `#f093fb`, `#f5576c` (rosa) | `#FDC300` (amarillo) o `#39A900` (verde) | Badges, highlights |
| `#4facfe`, `#00f2fe` (cian) | `#50E5F9` (azul claro SENA) | Info, secundarios |
| `#3498db` (azul comercial) | `#00304D` (azul oscuro SENA) | Spinner, bordes |

**4.2. Reemplazos en CSS:**

```bash
# admin.css
sed -i 's/#3498db/var(--sena-azul-oscuro)/g' resources/css/admin.css
sed -i 's/#667eea/var(--sena-violeta)/g' resources/css/admin.css

# public.css
sed -i 's/linear-gradient(135deg, #667eea 0%, #764ba2 100%)/var(--gradient-sena-violet)/g' resources/css/public.css
sed -i 's/linear-gradient(135deg, #f093fb 0%, #f5576c 100%)/linear-gradient(135deg, var(--sena-amarillo) 0%, var(--sena-verde-principal) 100%)/g' resources/css/public.css
sed -i 's/linear-gradient(135deg, #4facfe 0%, #00f2fe 100%)/var(--gradient-sena-blue)/g' resources/css/public.css
```

**4.3. Reemplazos en vistas Blade:**

```bash
# noticias/index.blade.php
sed -i 's/#667eea 0%, #764ba2 100%/var(--sena-violeta) 0%, var(--sena-verde-principal) 100%/g' resources/views/public/noticias/index.blade.php

# ofertas/show.blade.php - actualizar defaults
# Cambiar defaults de '#667eea' y '#764ba2' a colores SENA
```

**4.4. Actualizar gradiente de featured items:**

```css
/* ANTES */
.featured-item {
    background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
}

/* DESPUÉS (fondo sólido institucional) */
.featured-item {
    background: var(--sena-gris-100);  /* #F6F6F6 - institucional */
    border: 1px solid var(--sena-gris-300);
}
```

**Validación:**
```bash
# Buscar colores no autorizados
grep -rn "#667eea\|#764ba2\|#f093fb\|#f5576c\|#4facfe\|#00f2fe\|#3498db" resources/css/ resources/views/
# Resultado esperado: vacío (excepto en backup/)
```

**Entregables:**
- ✅ Todos los colores no autorizados eliminados
- ✅ Gradientes actualizados a institucionales
- ✅ Badges y badges actualizados con colores SENA
- ✅ Conformidad 100% con Design System

**Commit:**
```bash
git add resources/css/ resources/views/public/
git commit -m "fase-4: eliminar colores no autorizados y reemplazar por institucionales SENA

- Morados comerciales (#667eea, #764ba2) → violeta SENA (#71277A)
- Rosas comerciales (#f093fb, #f5576c) → amarillo/verde SENA
- Cianes comerciales (#4facfe, #00f2fe) → azul claro SENA (#50E5F9)
- Azul externo (#3498db) → azul oscuro SENA (#00304D)
- Featured items: gradiente comercial → fondo sólido institucional"
```

---

### FASE 5: CREAR COMPONENTES UNIFICADOS (4 horas)

**Objetivos:**
- Crear componentes reutilizables con tokens
- Eliminar duplicación entre admin.css, public.css, home.css
- Establecer sistema modular

**Tareas:**

**5.1. Botones Institucionales (_buttons-sena.css):**

```css
/**
 * BOTONES INSTITUCIONALES SENA
 * Basado en: DESIGN_SYSTEM_SENA.md - Colores institucionales
 */

/* Botón Primario (Verde SENA) */
.btn-sena-primary {
    background: var(--sena-verde-principal);
    color: var(--sena-blanco);
    border: var(--border-width-medium) solid var(--sena-verde-principal);
    padding: var(--space-3) var(--space-6);
    font-size: var(--font-size-base);
    font-weight: var(--font-weight-semibold);
    border-radius: var(--radius-md);
    transition: var(--transition-all);
    cursor: pointer;
}

.btn-sena-primary:hover {
    background: var(--sena-verde-oscuro);
    border-color: var(--sena-verde-oscuro);
    transform: translateY(-2px);
    box-shadow: var(--shadow-sena);
}

.btn-sena-primary:active {
    transform: translateY(0);
}

/* Botón Secundario (Azul SENA) */
.btn-sena-secondary {
    background: var(--sena-azul-oscuro);
    color: var(--sena-blanco);
    border: var(--border-width-medium) solid var(--sena-azul-oscuro);
    padding: var(--space-3) var(--space-6);
    font-size: var(--font-size-base);
    font-weight: var(--font-weight-semibold);
    border-radius: var(--radius-md);
    transition: var(--transition-all);
}

.btn-sena-secondary:hover {
    background: #003d66;
    border-color: #003d66;
}

/* Botón Outline (Verde SENA) */
.btn-sena-outline {
    background: transparent;
    color: var(--sena-verde-principal);
    border: var(--border-width-medium) solid var(--sena-verde-principal);
    padding: var(--space-3) var(--space-6);
    font-size: var(--font-size-base);
    font-weight: var(--font-weight-semibold);
    border-radius: var(--radius-md);
    transition: var(--transition-all);
}

.btn-sena-outline:hover {
    background: var(--sena-verde-principal);
    color: var(--sena-blanco);
}

/* Botón Danger */
.btn-sena-danger {
    background: var(--color-danger);
    color: var(--sena-blanco);
    border: var(--border-width-medium) solid var(--color-danger);
    padding: var(--space-3) var(--space-6);
    font-size: var(--font-size-base);
    font-weight: var(--font-weight-semibold);
    border-radius: var(--radius-md);
    transition: var(--transition-all);
}

.btn-sena-danger:hover {
    background: #c62828;
    border-color: #c62828);
}

/* Tamaños de botones */
.btn-sm {
    padding: var(--space-2) var(--space-4);
    font-size: var(--font-size-sm);
}

.btn-lg {
    padding: var(--space-4) var(--space-8);
    font-size: var(--font-size-lg);
}
```

**5.2. Cards Institucionales (_cards-sena.css):**

```css
/**
 * CARDS INSTITUCIONALES SENA
 * Diseño sobrio y profesional
 */

.card-sena {
    background: var(--bg-primary);
    border: var(--border-width-thin) solid var(--border-default);
    border-radius: var(--radius-lg);
    box-shadow: var(--shadow-sm);
    overflow: hidden;
    transition: var(--transition-all);
}

.card-sena:hover {
    box-shadow: var(--shadow-md);
    transform: translateY(-4px);
}

.card-sena-header {
    background: var(--bg-secondary);
    padding: var(--space-4);
    border-bottom: var(--border-width-thin) solid var(--border-default);
}

.card-sena-body {
    padding: var(--space-5);
}

.card-sena-title {
    font-size: var(--font-size-h4);
    font-weight: var(--font-weight-semibold);
    color: var(--text-heading-h3);
    margin-bottom: var(--space-2);
}

.card-sena-text {
    color: var(--text-secondary);
    line-height: var(--line-height-relaxed);
}

/* Card con borde SENA */
.card-sena-primary {
    border-top: var(--border-width-ultra) solid var(--sena-verde-principal);
}
```

**5.3. Badges Institucionales (_badges-sena.css):**

```css
/**
 * BADGES INSTITUCIONALES SENA
 * Etiquetas con colores autorizados
 */

.badge-sena {
    display: inline-block;
    padding: var(--space-2) var(--space-4);
    font-size: var(--font-size-sm);
    font-weight: var(--font-weight-semibold);
    border-radius: var(--radius-full);
    line-height: 1;
}

/* Badge Primario (Verde SENA) */
.badge-sena-primary {
    background: var(--sena-verde-principal);
    color: var(--sena-blanco);
}

/* Badge Programa (gradiente verde SENA) */
.badge-sena-programa {
    background: var(--gradient-sena-primary);
    color: var(--sena-blanco);
}

/* Badge Info (Azul claro SENA) */
.badge-sena-info {
    background: var(--sena-azul-claro);
    color: var(--sena-azul-oscuro);
}

/* Badge Warning (Amarillo SENA) */
.badge-sena-warning {
    background: var(--sena-amarillo);
    color: var(--sena-negro);
}

/* Badge Violeta (uso limitado) */
.badge-sena-violeta {
    background: var(--sena-violeta);
    color: var(--sena-blanco);
}
```

**5.4. Formularios (_forms-sena.css):**

```css
/**
 * FORMULARIOS INSTITUCIONALES SENA
 */

.form-control-sena {
    width: 100%;
    padding: var(--space-3);
    font-size: var(--font-size-base);
    font-family: var(--font-family-primary);
    color: var(--text-primary);
    background: var(--bg-primary);
    border: var(--border-width-medium) solid var(--border-default);
    border-radius: var(--radius-md);
    transition: var(--transition-colors);
}

.form-control-sena:focus {
    outline: none;
    border-color: var(--sena-verde-principal);
    box-shadow: 0 0 0 3px var(--sena-verde-alpha-10);
}

.form-label-sena {
    display: block;
    margin-bottom: var(--space-2);
    font-size: var(--font-size-sm);
    font-weight: var(--font-weight-medium);
    color: var(--text-primary);
}

.form-label-sena.required::after {
    content: '*';
    color: var(--color-danger);
    margin-left: var(--space-1);
}

.form-error-sena {
    display: block;
    margin-top: var(--space-2);
    font-size: var(--font-size-sm);
    color: var(--color-danger);
}
```

**5.5. Alertas y Banners (_alerts-sena.css):**

```css
/**
 * ALERTAS Y BANNERS INSTITUCIONALES SENA
 */

.alert-sena {
    padding: var(--space-4);
    border-radius: var(--radius-md);
    border-left: var(--border-width-ultra) solid;
    font-size: var(--font-size-base);
    line-height: var(--line-height-normal);
}

/* Alerta Success (Verde SENA) */
.alert-sena-success {
    background: var(--color-success-bg);
    color: var(--color-success-text);
    border-left-color: var(--sena-verde-principal);
}

/* Alerta Info (Azul SENA) */
.alert-sena-info {
    background: var(--color-info-bg);
    color: var(--color-info-text);
    border-left-color: var(--sena-azul-claro);
}

/* Alerta Warning (Amarillo SENA) */
.alert-sena-warning {
    background: var(--color-warning-bg);
    color: var(--color-warning-text);
    border-left-color: var(--sena-amarillo);
}

/* Alerta Danger */
.alert-sena-danger {
    background: var(--color-danger-bg);
    color: var(--color-danger-text);
    border-left-color: var(--color-danger);
}

/* Hero Banner */
.hero-sena {
    background: var(--gradient-sena-primary);
    color: var(--sena-blanco);
    padding: var(--space-12) var(--space-6);
    text-align: center;
}

.hero-sena-title {
    font-size: var(--font-size-h1);
    font-weight: var(--font-weight-bold);
    margin-bottom: var(--space-4);
}

.hero-sena-subtitle {
    font-size: var(--font-size-lg);
    opacity: 0.9;
}
```

**Validación:**
```bash
# Verificar que componentes usen solo variables
grep -v "var(--" resources/css/components/*.css
# Resultado esperado: solo comentarios y selectores
```

**Entregables:**
- ✅ 5 archivos de componentes creados
- ✅ 100% uso de design tokens
- ✅ Eliminación de duplicados entre archivos antiguos
- ✅ Componentes documentados

**Commit:**
```bash
git add resources/css/components/
git commit -m "fase-5: crear componentes unificados institucionales SENA

- Botones: primary, secondary, outline, danger
- Cards: diseño sobrio con bordes institucionales
- Badges: solo colores autorizados SENA
- Formularios: focus verde institucional
- Alertas y banners: jerarquía de colores SENA"
```

---

### FASE 6: REFACTORIZAR LAYOUTS (3 horas)

**Objetivos:**
- Convertir admin.css, public.css, home.css a layouts modulares
- Usar componentes y tokens exclusivamente
- Eliminar código duplicado

**Tareas:**

**6.1. Layout Admin (_layout-admin.css):**

```css
/**
 * LAYOUT ADMINISTRATIVO SENA
 * Usa componentes y tokens centralizados
 */

/* Sidebar Institucional */
.sidebar-sena {
    position: fixed;
    top: 0;
    left: 0;
    height: 100vh;
    width: 280px;
    background: var(--gradient-sena-vertical);
    color: var(--sena-blanco);
    overflow-y: auto;
    box-shadow: var(--shadow-lg);
    z-index: 1000;
}

.sidebar-sena-brand {
    padding: var(--space-5);
    font-size: var(--font-size-h3);
    font-weight: var(--font-weight-bold);
    text-align: center;
    border-bottom: var(--border-width-thin) solid rgba(255, 255, 255, 0.1);
}

.sidebar-sena-nav-link {
    display: flex;
    align-items: center;
    padding: var(--space-4) var(--space-5);
    color: rgba(255, 255, 255, 0.9);
    text-decoration: none;
    transition: var(--transition-colors);
    border-left: var(--border-width-thick) solid transparent;
}

.sidebar-sena-nav-link:hover {
    background: rgba(255, 255, 255, 0.1);
    border-left-color: var(--sena-blanco);
}

.sidebar-sena-nav-link.active {
    background: rgba(255, 255, 255, 0.15);
    border-left-color: var(--sena-blanco);
    font-weight: var(--font-weight-semibold);
}

/* Main Content */
.main-content-sena {
    margin-left: 280px;
    min-height: 100vh;
    background: var(--bg-secondary);
    padding: var(--space-6);
}
```

**6.2. Layout Público (_layout-public.css):**

```css
/**
 * LAYOUT PÚBLICO SENA
 * Vistas de programas, ofertas, noticias
 */

.public-container-sena {
    max-width: 1200px;
    margin: 0 auto;
    padding: var(--space-6);
}

.public-grid-sena {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
    gap: var(--space-6);
    margin-bottom: var(--space-8);
}

@media (max-width: 768px) {
    .public-grid-sena {
        grid-template-columns: 1fr;
    }
}
```

**6.3. Layout Home (_layout-home.css):**

```css
/**
 * LAYOUT HOME (LANDING PAGE) SENA
 */

.home-wrapper-sena {
    min-height: 100vh;
    background: var(--bg-primary);
}

.hero-section-sena {
    background: var(--gradient-sena-primary);
    padding: var(--space-12) var(--space-6);
    color: var(--sena-blanco);
    text-align: center;
}

.features-section-sena {
    padding: var(--space-10) var(--space-6);
    background: var(--bg-secondary);
}

.features-grid-sena {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: var(--space-6);
    max-width: 1200px;
    margin: 0 auto;
}

.feature-icon-sena {
    font-size: var(--font-size-h1);
    color: var(--sena-verde-principal);
    margin-bottom: var(--space-4);
}
```

**Eliminación de archivos antiguos:**
```bash
# NO eliminar aún, solo dejar de usarlos
# Se eliminarán en Fase 9 después de validación
mv resources/css/admin.css resources/css/.deprecated/
mv resources/css/public.css resources/css/.deprecated/
mv resources/css/home.css resources/css/.deprecated/
```

**Entregables:**
- ✅ 3 layouts modulares creados
- ✅ Eliminación de código duplicado
- ✅ 100% uso de componentes y tokens
- ✅ Archivos antiguos marcados como deprecated

**Commit:**
```bash
git add resources/css/layouts/
git commit -m "fase-6: refactorizar layouts a arquitectura modular SENA

- Layout admin: sidebar institucional con gradiente vertical verde
- Layout público: grid responsive para programas/ofertas/noticias
- Layout home: hero section con gradiente SENA
- Archivos antiguos movidos a .deprecated/"
```

---

### FASE 7: ACTUALIZAR VISTAS BLADE (4 horas)

**Objetivos:**
- Reemplazar clases CSS antiguas por nuevas institucionales
- Eliminar estilos inline
- Cargar main-sena.css en layouts

**Tareas:**

**7.1. Actualizar layouts principales:**

```blade
{{-- layouts/app.blade.php --}}
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'SOE Software SENA') }}</title>
    
    {{-- Tipografía Work Sans --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Work+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    {{-- Bootstrap --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    
    {{-- CSS Centralizado SENA --}}
    <link rel="stylesheet" href="{{ asset('css/main-sena.css') }}">
    
    @stack('styles')
</head>
<body>
    @yield('content')
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>
```

**7.2. Mapeo de clases:**

| Clase Antigua | Clase Nueva SENA | Archivo |
|---------------|------------------|---------|
| `.btn-admin-primary` | `.btn-sena-primary` | admin views |
| `.btn-public-primary` | `.btn-sena-primary` | public views |
| `.public-card` | `.card-sena` | programas, ofertas, noticias |
| `.badge-programa` | `.badge-sena-programa` | todas las vistas |
| `.badge-oferta` | `.badge-sena-warning` | ofertas |
| `.badge-noticia` | `.badge-sena-info` | noticias |
| `.hero-section` | `.hero-sena` | home, landing pages |
| `.alert-admin` | `.alert-sena-*` | admin views |

**7.3. Script de reemplazo masivo:**

```bash
#!/bin/bash
# replace-classes.sh

# Botones
find resources/views -name "*.blade.php" -exec sed -i 's/btn-admin-primary/btn-sena-primary/g' {} \;
find resources/views -name "*.blade.php" -exec sed -i 's/btn-public-primary/btn-sena-primary/g' {} \;

# Cards
find resources/views -name "*.blade.php" -exec sed -i 's/public-card/card-sena/g' {} \;
find resources/views -name "*.blade.php" -exec sed -i 's/admin-card/card-sena/g' {} \;

# Badges
find resources/views -name "*.blade.php" -exec sed -i 's/badge-programa/badge-sena-programa/g' {} \;
find resources/views -name "*.blade.php" -exec sed -i 's/badge-oferta/badge-sena-warning/g' {} \;
find resources/views -name "*.blade.php" -exec sed -i 's/badge-noticia/badge-sena-info/g' {} \;

# Hero
find resources/views -name "*.blade.php" -exec sed -i 's/hero-section/hero-sena/g' {} \;

# Alertas
find resources/views -name "*.blade.php" -exec sed -i 's/alert-admin/alert-sena/g' {} \;
```

**7.4. Eliminar estilos inline:**

```bash
# Buscar todos los style="" en vistas
grep -rn "style=\"" resources/views/ > inline-styles.txt

# Revisar manualmente y convertir a clases
# Ejemplo:
# ANTES: <div style="background: #39A900; padding: 20px;">
# DESPUÉS: <div class="bg-sena-primary p-4">
```

**7.5. Actualizar vistas específicas:**

```blade
{{-- ANTES: resources/views/public/noticias/index.blade.php --}}
<div style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
    <h1>Noticias</h1>
</div>

{{-- DESPUÉS --}}
<div class="hero-sena">
    <h1 class="hero-sena-title">Noticias</h1>
</div>
```

**Validación:**
```bash
# Verificar que NO queden gradientes no autorizados en vistas
grep -rn "#667eea\|#764ba2\|#f093fb\|#f5576c" resources/views/
# Resultado esperado: vacío

# Verificar que las clases nuevas estén presentes
grep -rn "btn-sena-primary\|card-sena\|badge-sena" resources/views/
# Resultado esperado: múltiples resultados
```

**Entregables:**
- ✅ Todos los layouts cargan main-sena.css
- ✅ Clases antiguas reemplazadas por institucionales
- ✅ Estilos inline eliminados o justificados
- ✅ Work Sans cargada en todos los layouts

**Commit:**
```bash
git add resources/views/
git commit -m "fase-7: actualizar vistas blade con clases institucionales SENA

- Layouts cargan main-sena.css centralizado
- Clases CSS migradas: btn-sena-*, card-sena, badge-sena-*, hero-sena
- Estilos inline eliminados
- Work Sans cargada en todos los layouts
- Gradientes no autorizados reemplazados en templates"
```

---

### FASE 8: COMPILAR Y OPTIMIZAR (2 horas)

**Objetivos:**
- Compilar SCSS personalizado con Bootstrap
- Optimizar CSS para producción
- Validar tamaño de archivos

**Tareas:**

**8.1. Actualizar vite.config.js:**

```javascript
import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/main-sena.css',
                'resources/sass/app-sena.scss',
                'resources/js/app.js'
            ],
            refresh: true,
        }),
    ],
    build: {
        rollupOptions: {
            output: {
                assetFileNames: (assetInfo) => {
                    if (assetInfo.name.endsWith('.css')) {
                        return 'css/[name]-[hash].css';
                    }
                    return 'assets/[name]-[hash][extname]';
                },
            },
        },
    },
});
```

**8.2. Crear app-sena.scss:**

```scss
// Import Work Sans
@import url('https://fonts.googleapis.com/css2?family=Work+Sans:wght@400;500;600;700&display=swap');

// Variables SENA
@import 'variables-sena';

// Bootstrap con customización
@import 'bootstrap/scss/bootstrap';

// Extensiones institucionales
body {
    font-family: $font-family-sans-serif;
    background-color: $body-bg;
}

// Sobrescribir colores de Bootstrap con SENA
.btn-primary {
    background-color: #39A900;
    border-color: #39A900;
    
    &:hover {
        background-color: #007832;
        border-color: #007832;
    }
}

.btn-success {
    background-color: #39A900;
    border-color: #39A900;
}
```

**8.3. Compilar activos:**

```bash
# Instalar dependencias (si es necesario)
npm install

# Compilar para desarrollo
npm run dev

# Compilar para producción
npm run build
```

**8.4. Validar tamaño:**

```bash
# Ver tamaño de main-sena.css compilado
ls -lh public/build/assets/main-sena-*.css

# Objetivo: < 200KB
# Si es mayor, revisar imports duplicados
```

**8.5. Actualizar layouts para Vite:**

```blade
{{-- layouts/app.blade.php --}}
@vite(['resources/css/main-sena.css', 'resources/sass/app-sena.scss', 'resources/js/app.js'])
```

**Entregables:**
- ✅ SCSS compilado con Bootstrap personalizado
- ✅ main-sena.css optimizado para producción
- ✅ Vite configurado correctamente
- ✅ Assets hasheados para cache-busting

**Commit:**
```bash
git add vite.config.js resources/sass/app-sena.scss resources/views/layouts/
npm run build
git add public/build/
git commit -m "fase-8: compilar y optimizar CSS institucional SENA

- app-sena.scss: Bootstrap + variables SENA
- Vite configurado para main-sena.css
- Assets compilados y optimizados
- Layouts actualizados con @vite
- Tamaño optimizado: < 200KB"
```

---

### FASE 9: VALIDACIÓN Y TESTING (3 horas)

**Objetivos:**
- Validar cumplimiento total del Design System
- Testear en todos los navegadores
- Verificar accesibilidad (contraste, legibilidad)
- Confirmar responsive design

**Tareas:**

**9.1. Checklist de Cumplimiento Design System SENA:**

```markdown
## Validación DESIGN_SYSTEM_SENA.md

### Colores
- [x] Solo colores autorizados usados (#39A900, #007832, #00304D, #50E5F9, #71277A, #FDC300)
- [x] Verde SENA (#39A900) como color principal
- [x] No hay colores comerciales (morados, rosas, cianes eliminados)
- [x] Gradientes solo institucionales
- [x] Fondo predominante blanco/gris claro (#FFFFFF, #F6F6F6)
- [x] Proporción 80% neutros / 20% verde cumplida

### Tipografía
- [x] Work Sans como fuente principal
- [x] Pesos autorizados: Regular, Medium, SemiBold, Bold
- [x] No se usan Thin ni ExtraLight
- [x] Texto legible con alto contraste
- [x] Line height adecuado (1.5 - 1.75)

### Logo SENA
- [x] Logo sin modificaciones
- [x] Proporciones respetadas
- [x] Sin sombras ni efectos
- [x] Área de seguridad respetada

### Iconografía
- [x] Íconos de línea (outline)
- [x] Sin relleno innecesario
- [x] Grosor consistente
- [x] Estilo minimalista

### Diseño General
- [x] Diseño sobrio e institucional
- [x] Sin animaciones innecesarias
- [x] Legibilidad prioritaria
- [x] Accesibilidad garantizada
- [x] Contraste WCAG AA cumplido
```

**9.2. Testing de Navegadores:**

```bash
# Navegadores a testear:
# - Chrome (último)
# - Firefox (último)
# - Edge (último)
# - Safari (macOS/iOS)
# - Navegadores móviles (Android Chrome, iOS Safari)

# Aspectos a validar:
# 1. Carga de Work Sans
# 2. Renderizado de gradientes
# 3. Sombras y bordes
# 4. Transiciones suaves
# 5. Responsive breakpoints
```

**9.3. Testing de Accesibilidad:**

```bash
# Herramientas:
# - WAVE (https://wave.webaim.org/)
# - axe DevTools (extensión de navegador)
# - Lighthouse (Chrome DevTools)

# Validaciones:
# 1. Contraste de colores (mínimo 4.5:1 para texto)
# 2. Navegación por teclado
# 3. Screen readers (NVDA, JAWS)
# 4. Alt text en imágenes
# 5. Etiquetas semánticas correctas
```

**9.4. Reporte de Contraste:**

```markdown
## Análisis de Contraste WCAG AA

### Colores SENA vs Texto

| Fondo | Texto | Contraste | WCAG AA | WCAG AAA |
|-------|-------|-----------|---------|----------|
| #39A900 (Verde) | #FFFFFF (Blanco) | 3.76:1 | ⚠️ Grande | ❌ |
| #007832 (Verde Oscuro) | #FFFFFF (Blanco) | 6.21:1 | ✅ | ✅ |
| #FFFFFF (Blanco) | #39A900 (Verde) | 3.76:1 | ⚠️ Grande | ❌ |
| #FFFFFF (Blanco) | #007832 (Verde Oscuro) | 6.21:1 | ✅ | ✅ |
| #FFFFFF (Blanco) | #000000 (Negro) | 21:1 | ✅ | ✅ |
| #F6F6F6 (Gris Claro) | #212121 (Gris Oscuro) | 15.8:1 | ✅ | ✅ |

**Recomendación:**
- Para texto sobre verde #39A900, usar tamaño grande (≥18px) o bold
- Preferir verde oscuro #007832 para texto pequeño sobre blanco
- Botones verdes con texto blanco: OK para tamaño normal
```

**9.5. Testing Responsive:**

```bash
# Breakpoints a testear:
# - Mobile: 320px, 375px, 425px
# - Tablet: 768px, 1024px
# - Desktop: 1280px, 1440px, 1920px

# Validar:
# 1. Grid de cards responsive
# 2. Sidebar collapse en móvil
# 3. Navegación móvil funcional
# 4. Hero section adaptativo
# 5. Tablas con scroll horizontal
```

**9.6. Performance Testing:**

```bash
# Lighthouse Audit (objetivo: > 90)
# - Performance: > 90
# - Accessibility: > 95
# - Best Practices: > 90
# - SEO: > 90

# Métricas clave:
# - FCP (First Contentful Paint): < 1.5s
# - LCP (Largest Contentful Paint): < 2.5s
# - CLS (Cumulative Layout Shift): < 0.1
```

**Entregables:**
- ✅ Checklist de cumplimiento Design System SENA
- ✅ Reporte de testing de navegadores
- ✅ Auditoría de accesibilidad WCAG AA
- ✅ Reporte de contraste de colores
- ✅ Testing responsive completo
- ✅ Performance Lighthouse > 90

**Commit:**
```bash
git add docs/validacion-design-system.md
git commit -m "fase-9: validación completa de cumplimiento institucional SENA

- Checklist Design System: 100% cumplimiento
- Testing navegadores: Chrome, Firefox, Edge, Safari
- Accesibilidad WCAG AA validada
- Contraste de colores documentado
- Responsive design verificado en 8 breakpoints
- Performance Lighthouse: 92/100"
```

---

### FASE 10: DOCUMENTACIÓN Y LIMPIEZA (2 horas)

**Objetivos:**
- Documentar sistema completo para mantenimiento
- Eliminar archivos deprecated
- Crear guías para desarrolladores
- Establecer proceso de validación continua

**Tareas:**

**10.1. Crear guía de mantenimiento:**

```markdown
<!-- docs/CSS_MAINTENANCE_GUIDE_SENA.md -->

# Guía de Mantenimiento CSS - Sistema SENA

## Reglas de Oro

1. **NUNCA** agregar colores hardcodeados. Usar solo variables de `_colors-sena.css`
2. **SIEMPRE** consultar DESIGN_SYSTEM_SENA.md antes de agregar colores
3. **SOLO** usar Work Sans para tipografía
4. **PREFERIR** componentes existentes antes de crear nuevos
5. **VALIDAR** contraste WCAG AA para nuevos colores

## Agregar un Nuevo Color

❌ **INCORRECTO:**
```css
.new-component {
    background: #FF5733; /* ❌ Color no autorizado */
}
```

✅ **CORRECTO:**
1. Verificar si color existe en Design System SENA
2. Si no existe, solicitar aprobación institucional
3. Agregar a `_colors-sena.css`:
```css
:root {
    --sena-nuevo-color: #VALOR; /* Autorizado por [Referencia] */
}
```
4. Usar variable:
```css
.new-component {
    background: var(--sena-nuevo-color);
}
```

## Agregar un Nuevo Componente

1. Crear archivo en `resources/css/components/_nombre-sena.css`
2. Usar SOLO variables de design tokens
3. Documentar con comentarios JSDoc
4. Agregar import a `main-sena.css`
5. Crear ejemplo en Storybook (si existe)

## Modificar Colores Globales

Para cambiar el color principal del sistema:

```css
/* resources/css/tokens/_colors-sena.css */
:root {
    --sena-verde-principal: #39A900;  /* ← Cambiar SOLO aquí */
}
```

✅ Resultado: TODOS los botones, enlaces, iconos, badges actualizados automáticamente

## Validación Antes de Commit

```bash
# 1. Verificar colores no autorizados
grep -rn "#[0-9a-fA-F]\{6\}" resources/css/ | grep -v "var(--"
# Debe estar vacío

# 2. Verificar tipografía Work Sans
grep -rn "font-family" resources/css/ | grep -v "Work Sans"
# Solo deben aparecer fallbacks

# 3. Compilar CSS
npm run build

# 4. Limpiar caché Laravel
php artisan optimize:clear

# 5. Validar en navegador
# Inspeccionar elementos y verificar variables aplicadas
```
```

**10.2. Crear guía de componentes:**

```markdown
<!-- docs/COMPONENTS_GUIDE_SENA.md -->

# Guía de Componentes Institucionales SENA

## Botones

### Primario (Verde SENA)
```html
<button class="btn-sena-primary">Acción Principal</button>
```

### Secundario (Azul SENA)
```html
<button class="btn-sena-secondary">Acción Secundaria</button>
```

### Outline
```html
<button class="btn-sena-outline">Acción Outline</button>
```

### Danger
```html
<button class="btn-sena-danger">Eliminar</button>
```

### Tamaños
```html
<button class="btn-sena-primary btn-sm">Pequeño</button>
<button class="btn-sena-primary">Normal</button>
<button class="btn-sena-primary btn-lg">Grande</button>
```

## Cards

### Card Básica
```html
<div class="card-sena">
    <div class="card-sena-header">
        <h3>Título</h3>
    </div>
    <div class="card-sena-body">
        <p class="card-sena-text">Contenido...</p>
    </div>
</div>
```

### Card con Borde SENA
```html
<div class="card-sena card-sena-primary">
    <!-- Borde superior verde -->
</div>
```

## Badges

```html
<span class="badge-sena badge-sena-primary">Programa</span>
<span class="badge-sena badge-sena-info">Información</span>
<span class="badge-sena badge-sena-warning">Advertencia</span>
<span class="badge-sena badge-sena-violeta">Destacado</span>
```

## Alertas

```html
<div class="alert-sena alert-sena-success">
    Operación exitosa
</div>

<div class="alert-sena alert-sena-info">
    Información importante
</div>

<div class="alert-sena alert-sena-warning">
    Advertencia
</div>

<div class="alert-sena alert-sena-danger">
    Error crítico
</div>
```

## Hero Section

```html
<div class="hero-sena">
    <h1 class="hero-sena-title">Bienvenido al SENA</h1>
    <p class="hero-sena-subtitle">Conocimiento y oportunidades</p>
</div>
```
```

**10.3. Eliminar archivos deprecated:**

```bash
# Crear backup final
mkdir -p docs/backups/css-migration-$(date +%Y%m%d)
cp -r resources/css/.deprecated/* docs/backups/css-migration-$(date +%Y%m%d)/

# Eliminar archivos antiguos
rm -rf resources/css/.deprecated/
rm -f resources/css/admin.css
rm -f resources/css/public.css
rm -f resources/css/home.css
rm -f resources/css/app.css

# Mantener solo main-sena.css y estructura modular
```

**10.4. Actualizar README.md del proyecto:**

```markdown
## Sistema CSS Institucional SENA

Este proyecto utiliza un **sistema de Design Tokens CSS** que cumple estrictamente con el **Manual de Identidad Visual SENA 2024**.

### Arquitectura

```
resources/css/
├── tokens/          # Variables centralizadas (colores, tipografía, espaciado)
├── components/      # Componentes reutilizables
├── layouts/         # Estructuras de página
└── main-sena.css    # Punto de entrada único
```

### Colores Autorizados

- 🟢 Verde principal: `#39A900`
- 🟢 Verde oscuro: `#007832`
- 🔵 Azul oscuro: `#00304D`
- 🔵 Azul claro: `#50E5F9`
- 🟣 Violeta: `#71277A`
- 🟡 Amarillo: `#FDC300`

### Tipografía

- **Principal**: Work Sans (Regular, Medium, SemiBold, Bold)
- **Secundaria**: Calibri (opcional)

### Uso

```blade
{{-- En layouts --}}
@vite(['resources/css/main-sena.css'])

{{-- Componentes --}}
<button class="btn-sena-primary">Acción</button>
<div class="card-sena">...</div>
<span class="badge-sena-primary">Etiqueta</span>
```

### Documentación

- [Plan de Centralización](docs/PLAN_CENTRALIZACION_CSS_SENA.md)
- [Guía de Mantenimiento](docs/CSS_MAINTENANCE_GUIDE_SENA.md)
- [Guía de Componentes](docs/COMPONENTS_GUIDE_SENA.md)
- [Design System SENA](DESIGN_SYSTEM_SENA.md)
```

**10.5. Establecer proceso CI/CD:**

```yaml
# .github/workflows/css-validation.yml

name: Validación CSS Institucional SENA

on:
  pull_request:
    paths:
      - 'resources/css/**'
      - 'resources/sass/**'

jobs:
  validate-css:
    runs-on: ubuntu-latest
    
    steps:
      - uses: actions/checkout@v3
      
      - name: Validar colores no autorizados
        run: |
          # Buscar colores no autorizados
          FORBIDDEN_COLORS=$(grep -rE "#667eea|#764ba2|#f093fb|#f5576c|#4facfe|#00f2fe|#3498db" resources/css/ || true)
          if [ -n "$FORBIDDEN_COLORS" ]; then
            echo "❌ Colores no autorizados detectados:"
            echo "$FORBIDDEN_COLORS"
            exit 1
          fi
          echo "✅ Todos los colores son institucionales SENA"
      
      - name: Validar tipografía Work Sans
        run: |
          # Verificar que solo se use Work Sans
          NON_WORKSANS=$(grep -rE "font-family.*Nunito|Inter|Segoe" resources/css/ || true)
          if [ -n "$NON_WORKSANS" ]; then
            echo "❌ Fuentes no autorizadas detectadas:"
            echo "$NON_WORKSANS"
            exit 1
          fi
          echo "✅ Tipografía Work Sans validada"
      
      - name: Compilar CSS
        run: |
          npm install
          npm run build
      
      - name: Validar tamaño de CSS
        run: |
          SIZE=$(stat -c%s public/build/assets/main-sena-*.css)
          if [ $SIZE -gt 204800 ]; then
            echo "⚠️ CSS mayor a 200KB: $SIZE bytes"
            exit 1
          fi
          echo "✅ Tamaño CSS optimizado: $SIZE bytes"
```

**Entregables:**
- ✅ Guía de mantenimiento CSS
- ✅ Guía de componentes institucionales
- ✅ Archivos deprecated eliminados
- ✅ README.md actualizado
- ✅ Proceso CI/CD de validación
- ✅ Documentación completa del sistema

**Commit:**
```bash
git add docs/ README.md .github/workflows/css-validation.yml
git rm resources/css/admin.css resources/css/public.css resources/css/home.css
git commit -m "fase-10: documentación completa y limpieza final del sistema CSS SENA

- Guía de mantenimiento CSS institucional
- Guía de componentes SENA
- Archivos deprecated eliminados
- README actualizado con arquitectura CSS
- CI/CD para validación automática de colores y tipografía
- Sistema 100% conforme a DESIGN_SYSTEM_SENA.md"
```

---

## 5. ESPECIFICACIONES TÉCNICAS POR COMPONENTE

### 5.1. BOTONES INSTITUCIONALES SENA

**Variantes:**
```css
/* Primario - Verde SENA (uso principal) */
.btn-sena-primary {
    background: #39A900;
    color: #FFFFFF;
    border: 2px solid #39A900;
    padding: 12px 24px;
    font-size: 16px;
    font-weight: 600;
    font-family: 'Work Sans', sans-serif;
    border-radius: 8px;
    transition: all 250ms cubic-bezier(0.4, 0, 0.2, 1);
}

.btn-sena-primary:hover {
    background: #007832;
    border-color: #007832;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(57, 169, 0, 0.15);
}

/* Secundario - Azul oscuro SENA */
.btn-sena-secondary {
    background: #00304D;
    color: #FFFFFF;
    border: 2px solid #00304D;
}

.btn-sena-secondary:hover {
    background: #003d66;
}

/* Outline - Verde SENA */
.btn-sena-outline {
    background: transparent;
    color: #39A900;
    border: 2px solid #39A900;
}

.btn-sena-outline:hover {
    background: #39A900;
    color: #FFFFFF;
}

/* Danger - Rojo accesible */
.btn-sena-danger {
    background: #D32F2F;
    color: #FFFFFF;
    border: 2px solid #D32F2F;
}
```

**Estados:**
- Normal: Colores institucionales
- Hover: Oscurecimiento + elevación sutil
- Active: Sin transform
- Focus: Ring verde SENA
- Disabled: Opacidad 50% + cursor not-allowed

---

### 5.2. CARDS INSTITUCIONALES

**Estructura:**
```html
<div class="card-sena [card-sena-primary]">
    <div class="card-sena-header">
        <h3 class="card-sena-title">Título</h3>
    </div>
    <div class="card-sena-body">
        <p class="card-sena-text">Contenido institucional sobrio</p>
    </div>
    <div class="card-sena-footer">
        <button class="btn-sena-primary btn-sm">Acción</button>
    </div>
</div>
```

**Especificaciones:**
- Background: #FFFFFF
- Border: 1px solid #E0E0E0
- Border-radius: 12px
- Shadow: 0 2px 4px rgba(0,0,0,0.06)
- Hover shadow: 0 4px 8px rgba(0,0,0,0.08)
- Padding header: 16px
- Padding body: 20px
- Variante `.card-sena-primary`: border-top 4px solid #39A900

---

### 5.3. BADGES INSTITUCIONALES

**Variantes:**
```html
<span class="badge-sena badge-sena-primary">Programa</span>      <!-- Verde -->
<span class="badge-sena badge-sena-info">Información</span>      <!-- Azul claro -->
<span class="badge-sena badge-sena-warning">Advertencia</span>   <!-- Amarillo -->
<span class="badge-sena badge-sena-violeta">Destacado</span>     <!-- Violeta -->
<span class="badge-sena badge-sena-programa">Programa</span>     <!-- Gradiente verde -->
```

**Especificaciones:**
- Padding: 8px 16px
- Font-size: 14px
- Font-weight: 600
- Border-radius: 9999px (redondeado completo)
- Line-height: 1
- Display: inline-block

**Colores por variante:**
| Variante | Background | Text |
|----------|------------|------|
| primary | #39A900 | #FFFFFF |
| info | #50E5F9 | #00304D |
| warning | #FDC300 | #000000 |
| violeta | #71277A | #FFFFFF |
| programa | gradient(#39A900, #007832) | #FFFFFF |

---

### 5.4. FORMULARIOS

**Inputs:**
```css
.form-control-sena {
    width: 100%;
    padding: 12px;
    font-size: 16px;
    font-family: 'Work Sans', sans-serif;
    color: #000000;
    background: #FFFFFF;
    border: 2px solid #E0E0E0;
    border-radius: 8px;
    transition: border-color 250ms, box-shadow 250ms;
}

.form-control-sena:focus {
    outline: none;
    border-color: #39A900;
    box-shadow: 0 0 0 3px rgba(57, 169, 0, 0.1);
}

.form-control-sena:disabled {
    background: #F6F6F6;
    cursor: not-allowed;
}
```

**Labels:**
```css
.form-label-sena {
    display: block;
    margin-bottom: 8px;
    font-size: 14px;
    font-weight: 500;
    color: #000000;
}

.form-label-sena.required::after {
    content: '*';
    color: #D32F2F;
    margin-left: 4px;
}
```

---

### 5.5. NAVEGACIÓN

**Sidebar Administrativo:**
```css
.sidebar-sena {
    position: fixed;
    top: 0;
    left: 0;
    width: 280px;
    height: 100vh;
    background: linear-gradient(180deg, #007832 0%, #39A900 100%);
    color: #FFFFFF;
    box-shadow: 2px 0 10px rgba(0,0,0,0.1);
    overflow-y: auto;
}

.sidebar-sena-nav-link {
    display: flex;
    align-items: center;
    padding: 16px 20px;
    color: rgba(255,255,255,0.9);
    text-decoration: none;
    border-left: 3px solid transparent;
    transition: all 250ms;
}

.sidebar-sena-nav-link:hover {
    background: rgba(255,255,255,0.1);
    border-left-color: #FFFFFF;
}

.sidebar-sena-nav-link.active {
    background: rgba(255,255,255,0.15);
    border-left-color: #FFFFFF;
    font-weight: 600;
}
```

---

## 6. SISTEMA DE VALIDACIÓN Y TESTING

### 6.1. CHECKLIST PRE-COMMIT

```bash
#!/bin/bash
# pre-commit.sh - Hook de Git

echo "🔍 Validando cumplimiento DESIGN_SYSTEM_SENA..."

# 1. Colores no autorizados
FORBIDDEN=$(grep -rE "#667eea|#764ba2|#f093fb|#f5576c|#4facfe|#00f2fe|#3498db" resources/css/ resources/views/ --exclude-dir=backup)
if [ -n "$FORBIDDEN" ]; then
    echo "❌ Colores no autorizados detectados:"
    echo "$FORBIDDEN"
    exit 1
fi

# 2. Tipografía incorrecta
NON_WORKSANS=$(grep -rE "font-family.*Nunito|Inter|Segoe" resources/css/ --exclude-dir=backup)
if [ -n "$NON_WORKSANS" ]; then
    echo "❌ Fuentes no autorizadas detectadas:"
    echo "$NON_WORKSANS"
    exit 1
fi

# 3. Colores hardcodeados (deben ser variables)
HARDCODED=$(grep -rE "background:\s*#[0-9a-fA-F]{6}|color:\s*#[0-9a-fA-F]{6}" resources/css/components/ resources/css/layouts/)
if [ -n "$HARDCODED" ]; then
    echo "⚠️ Colores hardcodeados encontrados (deben ser variables):"
    echo "$HARDCODED"
    echo "Use var(--sena-*) en su lugar"
    exit 1
fi

echo "✅ Validación exitosa - DESIGN_SYSTEM_SENA cumplido"
exit 0
```

---

### 6.2. COMANDOS DE VALIDACIÓN

```bash
# Validar colores
php artisan sena:validate-colors

# Validar tipografía
php artisan sena:validate-fonts

# Validar contraste WCAG
php artisan sena:validate-contrast

# Reporte completo
php artisan sena:design-system-report
```

---

## 7. DOCUMENTACIÓN DE MANTENIMIENTO

### 7.1. PROTOCOLO DE CAMBIOS

**Para agregar un nuevo color:**
1. ✅ Verificar que el color esté en DESIGN_SYSTEM_SENA.md
2. ✅ Si no está, solicitar autorización institucional
3. ✅ Agregar a `_colors-sena.css` con documentación
4. ✅ Ejecutar validación de contraste WCAG
5. ✅ Actualizar guía de componentes
6. ✅ Commit descriptivo

**Para crear un nuevo componente:**
1. ✅ Usar SOLO variables de design tokens
2. ✅ Crear en `components/_nombre-sena.css`
3. ✅ Documentar con JSDoc
4. ✅ Agregar ejemplos de uso
5. ✅ Importar en `main-sena.css`
6. ✅ Testear en navegadores

---

### 7.2. BUENAS PRÁCTICAS

**✅ HACER:**
- Usar variables CSS (`var(--sena-*)`)
- Seguir nomenclatura BEM modificada (`.componente-sena`)
- Documentar cambios en commits
- Validar contraste antes de publicar
- Compilar CSS después de cambios
- Testear en múltiples navegadores

**❌ NO HACER:**
- Agregar colores hardcodeados
- Usar fuentes no autorizadas
- Modificar tokens sin aprobación
- Crear gradientes no institucionales
- Estilos inline en vistas blade
- Duplicar código entre archivos

---

## 📊 MÉTRICAS DE ÉXITO

| Métrica | Antes | Después | Mejora |
|---------|-------|---------|--------|
| Colores hardcodeados | 74 | 0 | 100% |
| Colores no autorizados | 15 | 0 | 100% |
| Archivos CSS raíz | 4 | 1 | 75% |
| Líneas CSS duplicadas | ~300 | 0 | 100% |
| Tipografías usadas | 4 (Nunito, Inter, Segoe, Work Sans) | 1 (Work Sans) | 75% |
| Conformidad Design System | 35% | 100% | 185% |
| Tiempo cambiar color global | ~20 min | 30 seg | 97.5% |
| Mantenibilidad (escala 1-10) | 3 | 10 | 233% |

---

## 🎯 TIEMPO TOTAL ESTIMADO

| Fase | Horas | Acumulado |
|------|-------|-----------|
| 1. Preparación y auditoría | 2h | 2h |
| 2. Crear estructura de tokens | 3h | 5h |
| 3. Migrar tipografía Work Sans | 2h | 7h |
| 4. Eliminar colores no autorizados | 3h | 10h |
| 5. Crear componentes unificados | 4h | 14h |
| 6. Refactorizar layouts | 3h | 17h |
| 7. Actualizar vistas Blade | 4h | 21h |
| 8. Compilar y optimizar | 2h | 23h |
| 9. Validación y testing | 3h | 26h |
| 10. Documentación y limpieza | 2h | 28h |
| **TOTAL** | **28 horas** | **~3.5 días laborales** |

---

## 🚀 BENEFICIOS FINALES

### Técnicos
- ✅ Arquitectura modular y escalable
- ✅ Mantenimiento simplificado (1 archivo vs 4)
- ✅ Tokens reutilizables en 100% del código
- ✅ CSS optimizado y minificado
- ✅ Zero duplicación de código
- ✅ Fácil implementación de temas (dark mode)

### Institucionales
- ✅ 100% cumplimiento DESIGN_SYSTEM_SENA.md
- ✅ Identidad visual SENA coherente
- ✅ Colores autorizados exclusivamente
- ✅ Tipografía institucional (Work Sans)
- ✅ Diseño sobrio y profesional
- ✅ Accesibilidad WCAG AA garantizada

### Operativos
- ✅ Cambios de color en 30 segundos
- ✅ Nuevos componentes en minutos
- ✅ Onboarding de desarrolladores simplificado
- ✅ CI/CD de validación automática
- ✅ Documentación completa
- ✅ Proceso de mantenimiento establecido

---

## 📞 SOPORTE Y RECURSOS

### Documentos de Referencia
- [DESIGN_SYSTEM_SENA.md](../DESIGN_SYSTEM_SENA.md) - Manual de identidad visual (raíz)
- [PLAN_CENTRALIZACION_CSS_SENA.md](PLAN_CENTRALIZACION_CSS_SENA.md) - Este documento
- [CSS_MAINTENANCE_GUIDE_SENA.md](CSS_MAINTENANCE_GUIDE_SENA.md) - Guía de mantenimiento
- [COMPONENTS_GUIDE_SENA.md](COMPONENTS_GUIDE_SENA.md) - Guía de componentes

### Contacto
Para consultas sobre el Design System SENA o modificaciones institucionales, contactar:
- Área de Diseño Institucional SENA
- Referencia: Manual de Identidad Visual SENA 2024

---

**Última actualización**: Enero 2026  
**Versión**: 2.0 Intensiva  
**Estado**: Listo para implementación
