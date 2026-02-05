# FASE 8: Compilar y Optimizar - Estado y Recomendaciones

**Fecha:** 2026-01-29  
**Duración Estimada:** 2 horas  
**Estado:** ⚠️ **PARCIALMENTE BLOQUEADA - Node.js no instalado**

---

## 🎯 Objetivo

Compilar todos los assets CSS/JS en modo producción con Vite, verificar minificación, optimización y preparar archivos para despliegue.

---

## ⚠️ Situación Actual

### Problema Detectado
**Node.js no está instalado en el sistema**

```powershell
PS> node --version
# Error: 'node' no se reconoce como nombre de un cmdlet

PS> npm --version  
# Error: 'npm' no se reconoce como nombre de un cmdlet
```

### Assets Existentes (Desactualizados)

**Ubicación:** `public/build/assets/`

| Archivo | Tamaño | Estado | Hash |
|---------|--------|--------|------|
| `app-CQ0aYGy6.css` | 0.46 KB | ❌ DESACTUALIZADO | CQ0aYGy6 |
| `app-CiZ6hk-B.js` | 79.92 KB | ❌ DESACTUALIZADO | CiZ6hk-B |

**Contenido actual de app-CQ0aYGy6.css:**
```css
body{background:linear-gradient(135deg,#0d6efd,#198754);min-height:100vh;color:#fff}
.brand-image svg{width:40px;height:40px;color:#39a900;margin-right:1rem}
.hover-sena{transition:color .3s ease}
.hover-sena:hover{color:#39a900!important}
.hero{padding:6rem 1rem}
.hero-card{background:#fff;color:#212529;border-radius:1rem;padding:3rem;box-shadow:0 20px 40px #00000026}
.feature-icon{font-size:2.5rem;color:#0d6efd;margin-bottom:.5rem}
footer{font-size:.9rem;opacity:.85}
```

**Problemas:**
- ❌ No incluye estructura modular (tokens, base, components, layouts)
- ❌ No incluye componentes creados en FASE 5 (hero-sena, cards-sena, etc.)
- ❌ No incluye layouts refactorizados en FASE 6 (admin.css, public.css, auth.css)
- ❌ No refleja cambios de FASE 1-7 (111 KB de CSS fuente vs 0.46 KB compilado)
- ❌ Hash desactualizado (debe cambiar tras cada build)

---

## 📊 Análisis de Assets Fuente

### CSS Modular Actual

**Ubicación:** `resources/css/`  
**Total Archivos:** 26 archivos CSS  
**Tamaño Total:** 111.07 KB (fuente sin minificar)

**Estructura Verificada:**
```css
/* resources/css/app.css */
@import './tokens/index.css';          /* ✅ Variables SENA */
@import './base/reset.css';            /* ✅ Normalización */
@import './base/typography.css';       /* ✅ Work Sans */
@import './base/forms.css';            /* ✅ Formularios base */

@import './components/buttons-sena.css';    /* ✅ 45+ variantes */
@import './components/cards-sena.css';      /* ✅ 4 contextos */
@import './components/badges-sena.css';     /* ✅ 4 estados */
@import './components/alerts-sena.css';     /* ✅ 5 variantes */
@import './components/forms-sena.css';      /* ✅ Validación */
@import './components/navigation-sena.css'; /* ✅ Navegación */
@import './components/hero-sena.css';       /* ✅ 4 variantes hero */

@import './layouts/admin.css';        /* ✅ +300 líneas */
@import './layouts/public.css';       /* ✅ +400 líneas */
@import './layouts/auth.css';         /* ✅ +300 líneas */

@import './pages/home.css';           /* ✅ Página home */
```

### Configuración Vite Actual

**Archivo:** `vite.config.js`

```javascript
import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',    // ✅ Entrada principal
                'resources/css/admin.css',   // ⚠️ No existe (ya integrado en app.css)
                'resources/css/public.css',  // ⚠️ No existe (ya integrado en app.css)
                'resources/js/app.js',
                'resources/js/admin.js',
                'resources/js/public.js'
            ],
            refresh: true,
        }),
    ],
    build: {
        rollupOptions: {
            output: {
                manualChunks: {
                    'vendor': ['bootstrap'],
                }
            }
        },
        minify: 'terser',  // ✅ Minificación habilitada
        terserOptions: {
            compress: {
                drop_console: true,  // ✅ Elimina console.log en producción
            }
        }
    }
});
```

**⚠️ Problema Detectado en vite.config.js:**
Los archivos `resources/css/admin.css` y `resources/css/public.css` ya no existen como archivos separados. Fueron refactorizados e integrados en `resources/css/layouts/` durante FASE 6 y se importan desde `app.css`.

**✅ Solución:** Actualizar vite.config.js para eliminar entradas inexistentes.

---

## 🔧 Acciones Requeridas

### 1. Instalar Node.js (REQUERIDO)

**Descarga:** https://nodejs.org/en/download/

**Versión Recomendada:** Node.js 20.x LTS o superior

**Verificación post-instalación:**
```powershell
node --version  # Debe mostrar v20.x.x o superior
npm --version   # Debe mostrar 10.x.x o superior
```

### 2. Instalar Dependencias NPM

```powershell
cd c:\Users\AdminSena\Documents\SoeSoftware2
npm install
```

**Dependencias esperadas (package.json):**
- `vite`: ^7.0.7 (bundler)
- `laravel-vite-plugin`: ^2.0.0 (integración Laravel)
- `axios`: ^1.11.0 (HTTP requests)
- `bootstrap`: ^5.3.8 (framework CSS)

### 3. Actualizar vite.config.js (CORREGIR)

**Problema:** Referencias a archivos CSS que ya no existen

**Archivo:** `vite.config.js`

**Cambio necesario:**
```javascript
// ANTES (❌ INCORRECTO)
input: [
    'resources/css/app.css',
    'resources/css/admin.css',   // ❌ Ya no existe
    'resources/css/public.css',  // ❌ Ya no existe
    'resources/js/app.js',
    'resources/js/admin.js',
    'resources/js/public.js'
]

// DESPUÉS (✅ CORRECTO)
input: [
    'resources/css/app.css',      // ✅ Incluye todos los layouts vía @import
    'resources/js/app.js',
    'resources/js/admin.js',
    'resources/js/public.js'
]
```

**Razón:** Durante FASE 6, `admin.css` y `public.css` se movieron a `resources/css/layouts/` y se importan automáticamente desde `app.css`.

### 4. Compilar Assets en Modo Producción

**Comando:**
```powershell
npm run build
```

**Salida esperada:**
```
vite v7.0.7 building for production...
✓ 26 modules transformed.
build/assets/app-[hash].css    XX.XX kB │ gzip: XX.XX kB
build/assets/app-[hash].js     XX.XX kB │ gzip: XX.XX kB
✓ built in XXXms
```

**Archivos generados esperados:**
- `public/build/assets/app-[nuevo-hash].css` (≈25-35 KB minificado)
- `public/build/assets/app-[nuevo-hash].js` (≈80-100 KB minificado)
- `public/build/assets/vendor-[hash].js` (Bootstrap separado)
- `public/build/manifest.json` (mapa de assets actualizado)

### 5. Verificar Minificación y Optimización

**Tamaño esperado después de build:**

| Asset | Fuente (sin minificar) | Minificado | Gzip | Reducción |
|-------|------------------------|------------|------|-----------|
| CSS | ~111 KB | ~25-35 KB | ~8-12 KB | ~70-75% |
| JS | ~80 KB | ~60-70 KB | ~20-25 KB | ~75% |

**Verificaciones:**
```powershell
# Tamaño archivo CSS minificado
Get-Item "public/build/assets/app-*.css" | Select-Object Name, @{Name="KB";Expression={[math]::Round($_.Length / 1KB, 2)}}

# Tamaño archivo JS minificado
Get-Item "public/build/assets/app-*.js" | Select-Object Name, @{Name="KB";Expression={[math]::Round($_.Length / 1KB, 2)}}

# Verificar que manifest.json se actualizó
Get-Content "public/build/manifest.json" | ConvertFrom-Json
```

### 6. Verificar Contenido Compilado

**Checklist de contenido en CSS compilado:**

```powershell
# Ver primeras líneas del CSS compilado
Get-Content "public/build/assets/app-*.css" | Select-Object -First 50
```

**Debe incluir (minificado):**
- ✅ CSS Variables SENA (colores, tipografía)
- ✅ Work Sans @font-face imports
- ✅ Reset/normalize CSS
- ✅ Componentes: .btn-sena, .card-*, .badge-*, .alert-*, .hero-*
- ✅ Layouts: .admin-*, .public-*, .auth-*
- ✅ Responsive media queries (@media)

---

## 📋 Checklist de Completitud FASE 8

### Preparación
- [x] Verificar estructura CSS modular (26 archivos, 111 KB)
- [x] Verificar app.css con todos los @import correctos
- [x] Identificar archivos compilados existentes (desactualizados)
- [x] Detectar problema: Node.js no instalado
- [ ] Instalar Node.js 20.x LTS
- [ ] Ejecutar `npm install` para dependencias

### Configuración
- [ ] Actualizar vite.config.js (eliminar admin.css/public.css del input)
- [ ] Verificar package.json scripts (build, dev)
- [ ] Limpiar build anterior: `rm -r public/build/assets/*`

### Compilación
- [ ] Ejecutar `npm run build` (modo producción)
- [ ] Verificar salida sin errores
- [ ] Confirmar nuevos hashes en archivos generados
- [ ] Verificar manifest.json actualizado

### Verificación
- [ ] Comprobar tamaño CSS minificado (≈25-35 KB)
- [ ] Comprobar tamaño JS minificado (≈60-70 KB)
- [ ] Verificar contenido CSS incluye todos los componentes
- [ ] Verificar vendor chunk separado (Bootstrap)
- [ ] Confirmar console.log eliminados (terser)

### Testing
- [ ] Iniciar servidor Laravel: `php artisan serve`
- [ ] Abrir aplicación en navegador
- [ ] Verificar que estilos se cargan correctamente
- [ ] Inspeccionar Network tab (archivos con nuevo hash)
- [ ] Verificar DevTools: 0 errores 404 en assets
- [ ] Verificar DevTools: CSS aplicado (Work Sans, colores SENA)

### Documentación
- [ ] Crear reporte FASE 8 con tamaños antes/después
- [ ] Documentar problemas encontrados
- [ ] Commit Git con archivos compilados
- [ ] Actualizar README con instrucciones de build

---

## 🚀 Workflow Completo (Ejecutar cuando Node.js esté instalado)

```powershell
# 1. Instalar Node.js desde https://nodejs.org (si no está instalado)

# 2. Verificar instalación
node --version
npm --version

# 3. Navegar al proyecto
cd c:\Users\AdminSena\Documents\SoeSoftware2

# 4. Instalar dependencias
npm install

# 5. Actualizar vite.config.js (ver sección 3 arriba)
# Editar manualmente o usar script

# 6. Limpiar build anterior (opcional)
Remove-Item -Path "public\build\assets\*" -Force -Recurse

# 7. Compilar assets en producción
npm run build

# 8. Verificar archivos generados
Get-ChildItem "public\build\assets" | Select-Object Name, @{Name="KB";Expression={[math]::Round($_.Length / 1KB, 2)}}

# 9. Iniciar servidor Laravel para testing
php artisan serve

# 10. Abrir en navegador
# http://localhost:8000

# 11. Inspeccionar Network tab en DevTools
# Verificar que archivos CSS/JS se cargan con nuevo hash
```

---

## 📊 Estimación de Resultados (Post-Build)

### Antes de FASE 8 (Estado Actual)
| Métrica | Valor | Estado |
|---------|-------|--------|
| CSS fuente | 111.07 KB | ✅ Modular |
| CSS compilado | 0.46 KB | ❌ Desactualizado |
| Archivos CSS | 26 | ✅ Organizados |
| Imports en app.css | 12 | ✅ Correctos |
| Node.js instalado | No | ❌ Bloqueante |

### Después de FASE 8 (Esperado)
| Métrica | Valor | Estado |
|---------|-------|--------|
| CSS fuente | 111.07 KB | ✅ Sin cambios |
| CSS compilado (minificado) | ~30 KB | ✅ -73% |
| CSS compilado (gzip) | ~10 KB | ✅ -91% |
| Archivos generados | 3-4 | ✅ Optimizado |
| Hash actualizado | Sí | ✅ Cache busting |
| Console.log removidos | Sí | ✅ Producción |
| Vendor chunk separado | Sí | ✅ Caching |

---

## 🎨 Validación de Colores SENA Post-Build

**Importante:** Después del build, verificar que los colores SENA se mantienen correctos en el CSS compilado.

**Colores autorizados a verificar en el CSS minificado:**
- `#39a900` - Verde SENA (principal)
- `#71277a` - Violeta SENA
- `#fdc300` - Amarillo SENA
- `#50e5f9` - Azul claro SENA
- `#00304d` - Azul oscuro SENA
- `#ffffff` - Blanco
- `#000000` - Negro
- `#6c757d`, `#dee2e6`, etc. - Grises

**Comando de verificación:**
```powershell
# Extraer todos los colores hexadecimales del CSS compilado
(Get-Content "public/build/assets/app-*.css") -join '' | Select-String -Pattern '#[0-9a-f]{6}' -AllMatches | ForEach-Object { $_.Matches } | Select-Object Value -Unique
```

---

## ⚡ Optimizaciones Adicionales (Opcional)

### 1. CSS Purging (PurgeCSS)
**Objetivo:** Eliminar CSS no utilizado (especialmente de Bootstrap)

**Implementación:**
```javascript
// vite.config.js (añadir después de instalar @fullhuman/postcss-purgecss)
import purgecss from '@fullhuman/postcss-purgecss';

export default defineConfig({
    css: {
        postcss: {
            plugins: [
                purgecss({
                    content: ['./resources/**/*.blade.php', './resources/**/*.js'],
                    safelist: ['active', 'show', 'collapse', 'dropdown-menu'],
                })
            ]
        }
    },
    // ... resto de configuración
});
```

**Beneficio:** Reducción adicional 30-50% en CSS final

### 2. Image Optimization
**Objetivo:** Optimizar imágenes en `public/images/`

**Herramientas:**
- ImageMagick (PowerShell: `magick convert input.png -quality 85 output.webp`)
- TinyPNG API
- Vite image optimizer plugin

### 3. Lazy Loading de Componentes
**Objetivo:** Cargar componentes CSS bajo demanda

**Estrategia:**
- Separar CSS por página/sección
- Usar `@vite()` condicional en Blade
- Implementar critical CSS inline

---

## 📝 Próximos Pasos Post-FASE 8

### FASE 9: Validación y Testing (3 horas)
**Tareas:**
1. Cross-browser testing (Chrome, Firefox, Safari, Edge)
2. Responsive testing (mobile, tablet, desktop)
3. WCAG AA compliance (contraste de color, semántica)
4. Performance audit (Lighthouse)
5. Screen reader testing

### FASE 10: Documentación y Limpieza (2 horas)
**Tareas:**
1. Eliminar archivos backup (`resources/css/backup/`)
2. Actualizar README.md con instrucciones
3. Documentar sistema de componentes
4. Crear guía de estilo (style guide)
5. Commit final + merge a main

---

## 🐛 Troubleshooting

### Error: "Cannot find module 'vite'"
**Solución:** `npm install`

### Error: "File not found: resources/css/admin.css"
**Solución:** Actualizar vite.config.js (eliminar referencias a admin.css/public.css)

### Error: Build exitoso pero estilos no se aplican
**Solución:**
1. Limpiar cache: `php artisan cache:clear`
2. Verificar layout Blade usa `@vite(['resources/css/app.css'])`
3. Hard refresh navegador (Ctrl+Shift+R)

### Error: CSS muy grande (>100 KB compilado)
**Solución:** 
1. Implementar PurgeCSS para Bootstrap
2. Verificar que no hay CSS duplicado
3. Revisar imports innecesarios

---

## 🎉 Estado del Proyecto

### Progreso General
**Completado:** 7 de 10 fases (70%)  
**FASE 8:** ⚠️ Bloqueada (Node.js requerido)  
**Tiempo Invertido:** ~18 horas de 28 horas estimadas  
**Tiempo Restante:** ~10 horas

### Fases Completadas ✅
1. ✅ FASE 1: Auditoría y Backup
2. ✅ FASE 2: Estructura Modular
3. ✅ FASE 3: Migración Tipografía
4. ✅ FASE 4: Eliminar Colores No Autorizados
5. ✅ FASE 5: Crear Componentes Unificados
6. ✅ FASE 6: Refactorizar Layouts
7. ✅ FASE 7: Actualizar Blade Views

### Fases Pendientes ⏳
8. ⏳ **FASE 8: Compilar y Optimizar** ← **BLOQUEADA - Node.js requerido**
9. ⏳ FASE 9: Validación y Testing (3h)
10. ⏳ FASE 10: Documentación y Limpieza (2h)

---

## 📞 Contacto y Soporte

**Si necesitas ayuda con la instalación de Node.js o el build process:**
1. Verificar versión de Windows: `systeminfo`
2. Descargar Node.js LTS: https://nodejs.org/en/download/
3. Ejecutar instalador con permisos de administrador
4. Reiniciar PowerShell después de instalar
5. Verificar `node --version` y `npm --version`

---

**Documento Generado:** 2026-01-29  
**Autor:** GitHub Copilot  
**Branch:** feature/css-sena-centralization  
**Estado:** ⚠️ FASE 8 PENDIENTE - Esperando instalación de Node.js
