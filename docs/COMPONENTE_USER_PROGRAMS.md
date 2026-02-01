# Componente de Programas del Usuario (user-programs)

## Descripción
Componente Blade que muestra los programas en los que está inscrito un usuario (aprendiz) con toda la información detallada de cada programa, incluyendo red, instructor, competencias, estado de inscripción, etc.

## Ubicación
- **Componente:** `resources/views/components/profile/user-programs.blade.php`
- **Modelo:** `app/Models/Inscripcion.php`
- **Migración:** `database/migrations/2026_01_30_185738_create_inscripciones_table.php`

## Estructura de Base de Datos

### Tabla: `inscripciones`
```sql
- id (bigint, PK)
- user_id (bigint, FK -> users)
- programa_id (bigint, FK -> programas)
- instructor_id (bigint, FK -> instructores, nullable)
- fecha_inscripcion (date)
- fecha_retiro (date, nullable)
- estado (enum: 'activo', 'inactivo', 'retirado', 'finalizado')
- observaciones (text, nullable)
- timestamps
```

## Uso del Componente

### Forma básica:
```blade
<x-profile.user-programs :user="$user" />
```

### Ejemplo completo en una vista:
```blade
@extends('layouts.bootstrap')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-lg-4">
            <x-profile.user-card :user="$user" />
        </div>
        <div class="col-lg-8">
            <x-profile.user-programs :user="$user" />
        </div>
    </div>
</div>
@endsection
```

## Funcionalidades

### 1. **Listado de Programas**
- Muestra todos los programas en los que el usuario está/estuvo inscrito
- Ordenados por fecha de inscripción (más recientes primero)
- Formato accordion (expandible/colapsable)

### 2. **Estados de Inscripción**
- **Activo** (verde): Usuario actualmente cursando el programa
- **Finalizado** (azul): Usuario completó el programa
- **Retirado** (rojo): Usuario se retiró del programa
- **Inactivo** (gris): Inscripción inactiva

### 3. **Información Mostrada**

#### Por cada programa:
- **Información básica:**
  - Nombre del programa
  - Nivel de formación
  - Modalidad y jornada
  - Duración en meses
  - Centro de formación

- **Estado de inscripción:**
  - Estado actual (con badge de color)
  - Fecha de inscripción
  - Fecha de retiro (si aplica)
  - Observaciones (si hay)

- **Red de conocimiento:**
  - Nombre de la red
  - Descripción

- **Instructor a cargo:**
  - Nombre completo
  - Correo electrónico (clickeable)
  - Perfil profesional
  - Botón para ver información completa en modal

- **Competencias del programa:**
  - Lista de todas las competencias
  - Nombre y descripción de cada una
  - Vista en tarjetas

- **Información adicional:**
  - Descripción del programa
  - Requisitos
  - Título otorgado
  - Código SNIES
  - Registro de calidad

### 4. **Modal de Instructor**
Cada programa con instructor asignado tiene un modal con información detallada:
- Nombre completo
- Correo electrónico
- Perfil profesional
- Experiencia

## Relaciones del Modelo

### Modelo `Inscripcion`:
```php
// Relaciones
$inscripcion->user       // Usuario inscrito
$inscripcion->programa   // Programa
$inscripcion->instructor // Instructor a cargo

// Scopes
Inscripcion::activas()       // Solo inscripciones activas
Inscripcion::finalizadas()   // Solo inscripciones finalizadas

// Métodos helper
$inscripcion->estaActiva()     // bool
$inscripcion->fueRetirada()    // bool
$inscripcion->estaFinalizada() // bool
```

### Modelo `User` (relaciones agregadas):
```php
$user->inscripciones()          // Todas las inscripciones
$user->programas()              // Programas vía belongsToMany
$user->inscripcionesOrdenadas() // Ordenadas por fecha desc
$user->inscripcionesActivas()   // Solo activas
```

### Modelo `Programa` (relaciones agregadas):
```php
$programa->inscripciones() // Todas las inscripciones
$programa->aprendices()    // Usuarios vía belongsToMany
$programa->competencias()  // Competencias del programa
```

## Datos de Prueba

Para crear datos de prueba, ejecutar:
```bash
php artisan db:seed --class=InscripcionSeeder
```

Esto creará 3 inscripciones de ejemplo para el primer usuario:
- Una activa
- Una finalizada
- Una retirada

## Personalización

### Colores de Estados:
Editar en el componente las variables `$estadoClass` y `$estadoIcon`:
```php
$estadoClass = match($inscripcion->estado) {
    'activo' => 'success',      // Verde
    'finalizado' => 'primary',  // Azul
    'retirado' => 'danger',     // Rojo
    'inactivo' => 'secondary',  // Gris
    default => 'secondary'
};
```

### Iconos Bootstrap:
```php
$estadoIcon = match($inscripcion->estado) {
    'activo' => 'check-circle-fill',
    'finalizado' => 'trophy-fill',
    'retirado' => 'x-circle-fill',
    'inactivo' => 'pause-circle-fill',
    default => 'circle'
};
```

## Requisitos

- Bootstrap 5 (para estilos y accordion)
- Bootstrap Icons (para iconografía)
- Laravel 12+
- Relaciones: User, Programa, Instructor, Competencia, Red, NivelFormacion, Centro

## Vista de Ejemplo

Un archivo de ejemplo completo está disponible en:
`resources/views/examples/user-profile-programs.blade.php`

## Notas Importantes

1. **Eager Loading:** El componente usa `with()` para cargar todas las relaciones necesarias y evitar el problema N+1
2. **Estados:** Los estados son enum en la base de datos para mantener consistencia
3. **Fechas:** Las fechas se formatean automáticamente gracias a los casts en el modelo
4. **Seguridad:** El componente verifica la existencia de relaciones antes de mostrarlas (`@if`)

## Mantenimiento

Para agregar nuevos estados:
1. Modificar el enum en la migración
2. Actualizar los match expressions en el componente
3. Agregar los métodos helper correspondientes en el modelo Inscripcion

## Troubleshooting

### Error: "Undefined property: user"
Asegúrate de pasar el usuario al componente:
```blade
<x-profile.user-programs :user="$user" />
```

### No aparecen programas
Verifica que:
1. El usuario tenga inscripciones en la BD
2. Las relaciones estén correctamente definidas
3. Los datos relacionados (programa, instructor, etc.) existan

### Error N+1
El componente ya incluye eager loading. Si agregas más relaciones, agrégalas al `with()`:
```php
$inscripciones = $user->inscripcionesOrdenadas()
    ->with(['programa.red', 'programa.competencias', ...])
    ->get();
```
