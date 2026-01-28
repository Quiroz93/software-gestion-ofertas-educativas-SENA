# CONTEXTO DEL PROYECTO - GUÍA PARA DESARROLLADORES Y ASISTENTES AI

## 1. INFORMACIÓN GENERAL

**Proyecto**: SoeSoftware - Sistema de Gestión de Formación y Ofertas Educativas
**Versión Laravel**: 12.48.1
**Versión PHP**: 8.4.16
**Framework CSS**: Bootstrap 5
**Estado**: Migración Bootstrap 5 completada (FASE 8)

## 2. HISTORIAL DE CAMBIOS RECIENTES

### FASE 8: Migración AdminLTE → Bootstrap 5 (Completado)

#### FASE 8.1: Migración de Vistas Admin
- **Objetivo**: Reemplazar AdminLTE con Bootstrap 5
- **Resultado**: 51 vistas admin migradas exitosamente
- **Archivos creados**:
  - `resources/views/layouts/admin.blade.php` (585 líneas) - Layout principal admin
  - 51 vistas admin en `resources/views/admin/` con Bootstrap 5

#### FASE 8.2: Limpieza de Dependencias
- Removido paquete `almasaeed2010/adminlte`
- Actualizado `composer.json`
- Limpiado config de AdminLTE (`config/adminlte.php`)
- Removidas referencias a AdminLTE en vistas

#### FASE 8.3: Optimizaciones de Rendimiento
- Asset bundling automatizado en Vite
- Lazy loading de componentes Bootstrap
- Implementado caching de Laravel
- CDN fallback para Bootstrap 5

### VALIDACIÓN Y CORRECCIÓN DE RUTAS (Completado)

#### Auditoría de Rutas
- Analizadas 130 rutas registradas en la aplicación
- Encontradas 15 inconsistencias críticas en referencias de rutas
- Identificadas en 8 archivos diferentes

#### Correcciones Realizadas
**Problema**: Inconsistencia entre nombres de rutas definidas y referencias en vistas
**Causa raíz**: Mezcla de nomenclaturas (camelCase/underscores, singular/plural)

**Archivos Corregidos**:
1. `resources/views/home.blade.php` (8 rutas)
2. `resources/views/layouts/admin.blade.php` (4 rutas)
3. `resources/views/public/ofertas/show.blade.php` (3 rutas)
4. `resources/views/public/noticias/show.blade.php` (5 rutas)
5. `resources/views/public/noticias/index.blade.php` (2 rutas)
6. `resources/views/public/programas/show.blade.php` (3 rutas)
7. `resources/views/public/programas/index.blade.php` (1 ruta)

**Total**: 26 correcciones de rutas

#### Corrección de Estructura Blade
- Eliminado `@endsection` duplicado en `resources/views/home.blade.php` línea 323
- Corregida estructura de secciones Blade para evitar error "Cannot end a section without first starting one"

## 3. CONVENCIONES DE NOMENCLATURA ESTABLECIDAS

### Rutas Públicas (Estándar)
```
public.{recursoEnCamelCase}.{accion}
```

**Ejemplos**:
- `public.programasDeFormacion.index` - Listado de programas
- `public.programasDeFormacion.show` - Detalle de programa
- `public.ofertasEducativas.index` - Listado de ofertas
- `public.ofertasEducativas.show` - Detalle de oferta
- `public.ultimaNoticias.index` - Listado de noticias
- `public.ultimaNoticias.show` - Detalle de noticia
- `public.centrosFormacion.index` - Listado de centros
- `public.centrosFormacion.show` - Detalle de centro
- `public.instructoresDeFormacion.index` - Listado de instructores
- `public.instructoresDeFormacion.show` - Detalle de instructor
- `public.historiasDeExito.index` - Listado de historias
- `public.historiasDeExito.show` - Detalle de historia

### Rutas de Administración (Estándar)
```
{recurso}.{accion}
```

**Convención de pluralización**:
- **Una palabra**: `recurso.accion` (ej: `programas.index`)
- **Varias palabras**: `recurso_underscore.accion` (ej: `niveles_formacion.index`)

**Ejemplos registrados**:
- `centros.index`, `centros.create`, `centros.store`, `centros.show`, `centros.edit`, `centros.update`, `centros.destroy`
- `programas.*`
- `ofertas.*`
- `noticias.*`
- `competencias.*`
- `niveles_formacion.*`
- `redes_conocimiento.*`
- `historias_de_exito.*`
- `instructores.*`
- `instructor_redes.*`
- `users.*` (no `usuarios`)
- `roles.*`
- `permissions.*`

## 4. ESTRUCTURA DEL PROYECTO

### Layouts
```
resources/views/layouts/
├── bootstrap.blade.php   - Layout base para vistas públicas
├── admin.blade.php       - Layout base para panel admin (585 líneas)
└── app.blade.php         - Layout principal de aplicación
```

### Vistas Públicas
```
resources/views/public/
├── programas/
│   ├── index.blade.php
│   └── show.blade.php
├── ofertas/
│   ├── index.blade.php
│   └── show.blade.php
├── noticias/
│   ├── index.blade.php
│   └── show.blade.php
├── centros/
│   ├── index.blade.php
│   └── show.blade.php
├── instructores/
│   ├── index.blade.php
│   └── show.blade.php
└── historias/
    ├── index.blade.php
    └── show.blade.php
```

### Vistas de Administración
```
resources/views/admin/
├── centros/
├── competencias/
├── historias_de_exito/
├── instructor_redes/
├── instructores/
├── niveles_formacion/
├── ofertas/
├── ofertas_programas/
├── programas/
├── redes_conocimiento/
└── users/
    ├── index.blade.php
    ├── create.blade.php
    ├── edit.blade.php
    ├── show.blade.php
    └── permisos.blade.php
```

### Modelos Principales
```
app/Models/
├── Centro.php
├── Competencia.php
├── HistoriaExito.php
├── Instructor.php
├── InstructorRed.php
├── NivelFormacion.php
├── Noticia.php
├── Oferta.php
├── OfertaPrograma.php
├── Programa.php
├── ProgramaCompetencia.php
├── Red.php
├── User.php
└── CustomContent.php
```

### Features Especiales

#### Contenido Editable
- Sistema de edición en vivo para usuarios admin
- Modelo `CustomContent.php` para almacenar contenido dinámico
- Helper `getCustomContent()` en `app/Helpers/CustomContentHelper.php`
- Atributos `data-*` en elementos editables para capturar cambios

#### Políticas de Autorización
Todos los modelos tienen políticas correspondientes en:
```
app/Policies/
├── CentroPolicy.php
├── CompetenciaPolicy.php
├── HistoriasExitoPolicy.php
├── InstructorPolicy.php
├── NivelFormacionPolicy.php
├── OfertaPolicy.php
├── ProgramaPolicy.php
├── RedPolicy.php
└── UserPolicy.php
```

## 5. DECISIONES ARQUITECTÓNICAS

### Bootstrap 5 como Framework CSS
- ✅ Responsive por defecto
- ✅ Componentes completos y modernos
- ✅ Excelente documentación
- ✅ Compatible con Vite/Laravel

### Estructura de Rutas
- **Públicas**: Rutas agrupadas por recurso público con prefijo `public.`
- **Admin**: Rutas RESTful estándar para CRUD
- **Auth**: Sistema de autenticación Laravel estándar

### Content Management
- Contenido editable sin necesidad de migraciones
- Sistema flexible para home page y otras secciones
- Caché para optimizar rendimiento

## 6. INFORMACIÓN IMPORTANTE PARA AI ASSISTANTS

### Al Trabajar con Rutas
```blade
<!-- CORRECTO: Uso de convención camelCase para públicas -->
<a href="{{ route('public.programasDeFormacion.index') }}">Ver Programas</a>

<!-- CORRECTO: Uso de underscore para admin multi-palabra -->
<a href="{{ route('niveles_formacion.index') }}">Niveles</a>

<!-- CORRECTO: Rutas con parámetros -->
<a href="{{ route('public.programasDeFormacion.show', $programa) }}">Detalles</a>
```

### Al Crear Nuevas Vistas
```blade
@extends('layouts.bootstrap')           <!-- Vistas públicas -->
@extends('layouts.admin')               <!-- Vistas admin -->

@section('title', 'Título de la Página')
@section('content')
    <!-- Contenido aquí -->
@endsection
```

### Helper para Contenido Editable
```php
// Obtener contenido personalizado
$texto = getCustomContent('home', 'hero_title', 'Título por defecto');

// En blade con edición
<h2 class="editable" 
    data-model="home" 
    data-key="hero_title" 
    data-type="text">
    {!! getCustomContent('home', 'hero_title', 'Default') !!}
</h2>
```

### Validaciones y Políticas
```php
// Todas las acciones están protegidas por políticas
@can('create', App\Models\Programa::class)
    <!-- Solo admin puede ver esto -->
@endcan

// En rutas
Route::middleware(['auth', 'verified'])->group(function () {
    // Rutas protegidas
});
```

## 7. ARCHIVOS CRÍTICOS QUE FUERON MODIFICADOS

### Layouts (Alto Impacto)
- `resources/views/layouts/bootstrap.blade.php` - Layout público
- `resources/views/layouts/admin.blade.php` - Layout admin (NUEVA, 585 líneas)

### Vistas Home (Alto Impacto)
- `resources/views/home.blade.php` - 8 correcciones de rutas + 1 fix @endsection

### Vistas Públicas (Medio Impacto)
- `resources/views/public/programas/index.blade.php` - 1 corrección de ruta
- `resources/views/public/programas/show.blade.php` - 3 correcciones de rutas
- `resources/views/public/ofertas/show.blade.php` - 3 correcciones de rutas
- `resources/views/public/noticias/index.blade.php` - 2 correcciones de rutas
- `resources/views/public/noticias/show.blade.php` - 5 correcciones de rutas

### Documentación
- `docs/ROUTE_VALIDATION_REPORT.md` - Análisis completo de inconsistencias (NUEVA)

## 8. TESTING Y VALIDACIÓN

### Rutas Validadas
- ✅ 130 rutas registradas analizadas
- ✅ 100+ referencias en vistas verificadas
- ✅ 15 inconsistencias identificadas y corregidas
- ✅ Navegación principal funcional
- ✅ Sidebar admin operativo
- ✅ Breadcrumbs públicos funcionales
- ✅ Enlaces entre vistas validados

## 9. PROCEDIMIENTOS PARA NUEVOS DESARROLLADORES

### Clonar y Configurar
```bash
# Clonar repositorio
git clone [repositorio-url]

# Instalar dependencias
composer install
npm install

# Configurar base de datos
cp .env.example .env
php artisan key:generate
php artisan migrate

# Compilar assets
npm run dev   # Desarrollo
npm run build # Producción
```

### Agregar Nueva Funcionalidad
1. **Crear modelo**: `php artisan make:model NuevoModelo -m -c -p`
2. **Crear policy**: `php artisan make:policy NuevoModeloPolicy --model=NuevoModelo`
3. **Crear vistas**: Seguir estructura en `resources/views/public/` o `resources/views/admin/`
4. **Definir rutas**: Seguir convención de nomenclatura establecida
5. **Validar rutas**: Verificar que route() en vistas coincida con Route:: en web.php

### Principios para Mantener Consistencia
- ✅ Siempre seguir convención de nomenclatura de rutas
- ✅ Usar helpers para contenido dinámico
- ✅ Implementar políticas para todas las acciones
- ✅ Usar Bootstrap 5 para estilos (no AdminLTE)
- ✅ Mantener estructura de carpetas existente
- ✅ Documentar cambios significativos

## 10. PRÓXIMOS PASOS SUGERIDOS

### Alto Impacto
- [ ] Completar correcciones en `resources/views/profile/users/` (2 files)
- [ ] Implementar tests automatizados para validación de rutas
- [ ] Agregar documentación de API si es necesario

### Medio Impacto
- [ ] Optimizar imágenes de hero background
- [ ] Implementar caching avanzado en CustomContent
- [ ] Agregar más componentes reutilizables Bootstrap 5

### Bajo Impacto
- [ ] Mejorar documentación de CustomContent
- [ ] Agregar temas CSS personalizados
- [ ] Crear componentes Blade reutilizables

## 11. CONTACTO Y REFERENCIAS

**Documentación Importante**:
- `docs/ROUTE_VALIDATION_REPORT.md` - Análisis detallado de rutas
- `docs/BOOTSTRAP5_MIGRATION_COMPLETE.md` - Resumen de migración
- `docs/INDEX.md` - Índice general de documentación

**Comandos Útiles**:
```bash
# Ver todas las rutas registradas
php artisan route:list

# Compilar assets
npm run dev

# Ejecutar migraciones
php artisan migrate

# Limpiar caché
php artisan cache:clear
php artisan config:clear
php artisan view:clear
```

---

**Última actualización**: 27 de enero de 2026
**Estado del proyecto**: Estable - Listo para desarrollo
