# Algoritmo de Inscripción a Programas de Formación

## 1. Resumen Ejecutivo

El **Sistema de Inscripción** permite a usuarios con rol **aprendiz** inscribirse en programas de formación disponibles. El proceso está protegido con validaciones de duplicados, límites de cupos, requisitos previos y transacciones atómicas en base de datos.

**Componentes principales:**
- `InscripcionController` - Lógica de negocio
- `InscripcionRequest` - Validaciones de formulario
- `inscribirse.blade.php` - Interfaz de usuario
- `Inscripcion` model - Persistencia de datos
- Rutas protegidas en `routes/web.php`

---

## 2. Diagrama de Flujo

```
┌─────────────────────────────────────────────────────────────┐
│          Usuario accede a programa de formación             │
└──────────────────────┬──────────────────────────────────────┘
                       │
                       ▼
        ┌──────────────────────────────┐
        │ ¿Usuario autenticado?        │
        └──────┬──────────────────────┘
               │ NO
               ▼
        Redirigir a login
               │ SI
               ▼
        ┌──────────────────────────────┐
        │ ¿Tiene rol 'aprendiz'?       │
        └──────┬───────────────────────┘
               │ NO
               ▼
        Error: Solo aprendices
               │ SI
               ▼
        ┌──────────────────────────────┐
        │ GET /programas/{id}/inscribirse
        │ InscripcionController@create │
        └──────┬───────────────────────┘
               │
               ▼
        ┌──────────────────────────────┐
        │ ¿Ya está inscrito?           │
        │ (activo o finalizado)        │
        └──────┬───────────────────────┘
               │ SI
               ▼
        Error: Ya inscrito
        
               │ NO
               ▼
        Mostrar formulario
        ┌──────────────────────────────┐
        │   inscribirse.blade.php      │
        │  - Datos del programa        │
        │  - Datos del usuario         │
        │  - Campo observaciones       │
        │  - Aceptar términos          │
        └──────┬───────────────────────┘
               │
               ▼ Llenar formulario
        ┌──────────────────────────────┐
        │ POST /programas/{id}/inscribir │
        │ InscripcionController@store    │
        └──────┬───────────────────────┘
               │
               ▼
        ┌─────────────────────────────────────────────────┐
        │ TRANSACCIÓN BEGIN                               │
        └──────┬──────────────────────────────────────────┘
               │
               ▼
        ┌──────────────────────────────┐
        │ ¿Duplicado?                  │
        └──────┬───────────────────────┘
               │ SI
               ▼
        ROLLBACK → Error: Duplicado
               │ NO
               ▼
        ┌──────────────────────────────┐
        │ ¿Cupo disponible?            │
        └──────┬───────────────────────┘
               │ NO
               ▼
        ROLLBACK → Error: Sin cupo
               │ SI (o sin cupo máx)
               ▼
        ┌──────────────────────────────┐
        │ ¿Cumple requisitos?          │
        └──────┬───────────────────────┘
               │ NO
               ▼
        ROLLBACK → Error: Requisitos
               │ SI
               ▼
        ┌──────────────────────────────┐
        │ Crear registro en BD         │
        │ INSERT inscripciones         │
        └──────┬───────────────────────┘
               │
               ▼
        ┌──────────────────────────────┐
        │ COMMIT TRANSACCIÓN           │
        └──────┬───────────────────────┘
               │
               ▼
        Redirigir a programa
        + Mensaje de éxito
```

---

## 3. Flujo Detallado de Inscripción

### Fase 1: Preparación (GET /programas/{programa}/inscribirse)

**Método:** `InscripcionController@create(Programa $programa)`

**Validaciones previas:**
1. ✅ Usuario autenticado (`auth()->check()`)
2. ✅ Usuario tiene rol `aprendiz` (`auth()->user()->hasRole('aprendiz')`)
3. ✅ No está inscrito activamente (`Inscripcion::where('estado', 'activo')`)
4. ✅ Cargar relaciones de programa (competencias, instructor)

**Respuesta:**
- ✅ Vista `inscribirse.blade.php` con datos del programa y usuario
- ❌ Error 403 si no es aprendiz
- ❌ Redirección con error si ya está inscrito

**Código:**
```php
public function create(Programa $programa): View
{
    if (!auth()->check()) {
        throw new AuthorizationException('Debes estar autenticado');
    }

    if (!auth()->user()->hasRole('aprendiz')) {
        throw new AuthorizationException('Solo aprendices pueden inscribirse');
    }

    $yaInscrito = Inscripcion::where('user_id', auth()->id())
        ->where('programa_id', $programa->id)
        ->whereIn('estado', ['activo', 'finalizado'])
        ->exists();

    if ($yaInscrito) {
        return back()->with('error', 'Ya estás inscrito');
    }

    $programa->load('competencias', 'instructor');
    
    return view('public.inscribirse', [
        'programa' => $programa,
        'user' => auth()->user()
    ]);
}
```

---

### Fase 2: Validación de Formulario (FormRequest)

**Clase:** `InscripcionRequest`

**Reglas de validación:**
```php
[
    'observaciones' => ['nullable', 'string', 'max:500'],
    'acepta_terminos' => ['required', 'boolean'],
]
```

**Errores posibles:**
- `observaciones.max`: No puede exceder 500 caracteres
- `acepta_terminos.required`: Debes aceptar los términos

---

### Fase 3: Procesamiento y Persistencia (POST /programas/{programa}/inscribir)

**Método:** `InscripcionController@store(InscripcionRequest $request, Programa $programa)`

**Algoritmo paso a paso:**

```
1. VERIFICAR AUTENTICACIÓN
   if (!auth()->check()) → return error

2. VERIFICAR ROL APRENDIZ
   if (!auth()->user()->hasRole('aprendiz')) → return error

3. INICIAR TRANSACCIÓN
   DB::beginTransaction()

4. VALIDAR DUPLICADO
   SELECT COUNT(*) FROM inscripciones
   WHERE user_id = ? 
   AND programa_id = ? 
   AND estado IN ('activo', 'finalizado')
   
   if (count > 0) {
       DB::rollBack()
       return error "Ya inscrito"
   }

5. VALIDAR CUPO
   if (programa.cupo_maximo != null) {
       SELECT COUNT(*) FROM inscripciones
       WHERE programa_id = ? AND estado = 'activo'
       
       if (count >= cupo_maximo) {
           DB::rollBack()
           return error "Cupo lleno"
       }
   }

6. VALIDAR REQUISITOS
   if (programa.requisitos) {
       if (!validarRequisitos(user, programa)) {
           DB::rollBack()
           return error "No cumples requisitos"
       }
   }

7. CREAR INSCRIPCIÓN
   INSERT INTO inscripciones (
       user_id,
       programa_id,
       instructor_id,
       fecha_inscripcion,
       estado,
       observaciones
   ) VALUES (?, ?, ?, now(), 'activo', ?)

8. CONFIRMAR TRANSACCIÓN
   DB::commit()

9. REDIRIGIR CON ÉXITO
   return redirect()
       ->with('status', 'inscripcion-exitosa')
       ->with('message', 'Inscrito exitosamente')
```

**Pseudocódigo completo:**

```php
public function store(InscripcionRequest $request, Programa $programa)
{
    if (!auth()->check()) {
        return back()->with('error', 'Debes estar autenticado');
    }

    $user = auth()->user();
    
    if (!$user->hasRole('aprendiz')) {
        return back()->with('error', 'Solo aprendices');
    }

    try {
        DB::beginTransaction();

        // Validación 1: Duplicado
        $existente = Inscripcion::where('user_id', $user->id)
            ->where('programa_id', $programa->id)
            ->whereIn('estado', ['activo', 'finalizado'])
            ->first();

        if ($existente) {
            DB::rollBack();
            return back()->with('error', 'Ya estás inscrito');
        }

        // Validación 2: Cupo
        if ($programa->cupo_maximo !== null) {
            $inscritosActivos = Inscripcion::where('programa_id', $programa->id)
                ->where('estado', 'activo')
                ->count();

            if ($inscritosActivos >= $programa->cupo_maximo) {
                DB::rollBack();
                return back()->with('error', 'Cupo lleno');
            }
        }

        // Validación 3: Requisitos
        if ($programa->requisitos) {
            if (!$this->validarRequisitos($user, $programa)) {
                DB::rollBack();
                return back()->with('error', 'No cumples requisitos');
            }
        }

        // Crear inscripción
        $inscripcion = Inscripcion::create([
            'user_id' => $user->id,
            'programa_id' => $programa->id,
            'instructor_id' => $programa->instructor_id,
            'fecha_inscripcion' => now()->toDateString(),
            'estado' => 'activo',
            'observaciones' => $request->input('observaciones'),
        ]);

        DB::commit();

        return redirect()
            ->route('programas.show', $programa)
            ->with('status', 'inscripcion-exitosa')
            ->with('message', '¡Inscrito exitosamente!');

    } catch (\Exception $e) {
        DB::rollBack();
        return back()->with('error', 'Error: ' . $e->getMessage());
    }
}
```

---

## 4. Validaciones Clave

### 4.1 Validación de Duplicado
```
Propósito: Evitar inscripciones múltiples al mismo programa
Tipo: Base de datos (en transacción)
Constraint: UNIQUE(user_id, programa_id, estado)

Lógica:
- Un usuario NO puede estar inscrito dos veces en ACTIVO o FINALIZADO
- Un usuario SÍ puede estar en RETIRADO (histórico)
- Un usuario SÍ puede reinscribirse después de retirarse (manual en BD)
```

### 4.2 Validación de Cupo
```
Propósito: Limitar inscripciones si programa tiene límite
Tipo: Lógica de negocio

Condiciones:
- IF programa.cupo_maximo IS NULL → sin límite (inscripción ilimitada)
- IF programa.cupo_maximo IS NOT NULL:
    - COUNT inscripciones ACTIVAS < cupo_maximo → permitir
    - COUNT inscripciones ACTIVAS >= cupo_maximo → denegar
    
Nota: No contar RETIRADO, FINALIZADO, INACTIVO
```

### 4.3 Validación de Requisitos
```
Propósito: Verificar que usuario cumpla con entrada del programa
Tipo: Lógica de negocio (extensible)

Ejemplos (a implementar según negocio):
1. Haber completado programa X previamente
2. Tener competencia mínima Y
3. Edad mínima Z
4. Aprobación manual de instructor

Actual:
- Por defecto: siempre permite (retorna true)
- TODO: Implementar lógica según requisitos del programa
```

### 4.4 Validación de Rol
```
Propósito: Solo aprendices pueden inscribirse
Tipo: Autorización

Roles permitidos: 'aprendiz'
Roles NO permitidos: 'admin', 'instructor', 'user'
```

---

## 5. Retiro de Inscripción

**Método:** `InscripcionController@destroy(Inscripcion $inscripcion)`

**Flujo:**
```
1. Verificar autorización:
   - Usuario es propietario OR es admin
   
2. Iniciar transacción
   
3. Actualizar estado:
   UPDATE inscripciones
   SET estado = 'retirado', fecha_retiro = now()
   WHERE id = ?

4. Confirmar transacción

5. Redirigir con éxito
```

**Código:**
```php
public function destroy(Inscripcion $inscripcion): RedirectResponse
{
    if (!auth()->check() || (auth()->id() !== $inscripcion->user_id && !auth()->user()->hasRole('admin'))) {
        throw new AuthorizationException('Sin permisos');
    }

    try {
        DB::beginTransaction();

        $inscripcion->update([
            'estado' => 'retirado',
            'fecha_retiro' => now()->toDateString(),
        ]);

        DB::commit();

        return back()->with('status', 'inscripcion-retirada')
                    ->with('message', 'Te has retirado exitosamente');

    } catch (\Exception $e) {
        DB::rollBack();
        return back()->with('error', 'Error: ' . $e->getMessage());
    }
}
```

---

## 6. Rutas Disponibles

```
GET  /programas/{programa}/inscribirse
     → InscripcionController@create
     → Mostrar formulario
     → Middleware: auth
     
POST /programas/{programa}/inscribir
     → InscripcionController@store
     → Procesar inscripción
     → Middleware: auth, verified
     
DELETE /inscripciones/{inscripcion}
       → InscripcionController@destroy
       → Retirar del programa
       → Middleware: auth
       
GET /mis-inscripciones
    → InscripcionController@misinscripciones
    → Listar inscripciones del usuario
    → Middleware: auth
```

---

## 7. Estructura de Datos

### Tabla: inscripciones

```sql
CREATE TABLE inscripciones (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    user_id BIGINT NOT NULL FOREIGN KEY REFERENCES users(id),
    programa_id BIGINT NOT NULL FOREIGN KEY REFERENCES programas(id),
    instructor_id BIGINT NULLABLE FOREIGN KEY REFERENCES instructores(id),
    fecha_inscripcion DATE NOT NULL,
    fecha_retiro DATE NULLABLE,
    estado ENUM('activo', 'inactivo', 'retirado', 'finalizado') DEFAULT 'activo',
    observaciones TEXT NULLABLE,
    created_at TIMESTAMP,
    updated_at TIMESTAMP,
    
    UNIQUE KEY unique_inscripcion (user_id, programa_id),
    INDEX idx_user_id (user_id),
    INDEX idx_programa_id (programa_id),
    INDEX idx_estado (estado),
    INDEX idx_fecha_inscripcion (fecha_inscripcion)
);
```

### Estados Posibles

| Estado | Descripción | Transiciones |
|--------|-------------|--------------|
| `activo` | Inscrito actualmente | → retirado, finalizado |
| `inactivo` | No activo (espera) | → activo, retirado |
| `retirado` | Se retiró del programa | (final) |
| `finalizado` | Completó el programa | (final) |

---

## 8. Casos de Uso y Escenarios

### Caso 1: Inscripción exitosa
```
Usuario: Juan (aprendiz)
Programa: Python Avanzado (cupo=20, inscritos=18)
Resultado: ✅ Inscrito
Estado BD: activo, fecha_inscripcion = 2025-01-30
```

### Caso 2: Duplicado detectado
```
Usuario: María (aprendiz)
Programa: React (ya inscrita, estado=activo)
Resultado: ❌ Error "Ya estás inscrito"
Estado BD: sin cambios
```

### Caso 3: Cupo lleno
```
Usuario: Pedro (aprendiz)
Programa: Java (cupo=10, inscritos=10)
Resultado: ❌ Error "Cupo lleno"
Estado BD: sin cambios
```

### Caso 4: Retiro exitoso
```
Usuario: Laura (aprendiz)
Inscripción: Activa en PHP
Resultado: ✅ Retirada
Estado BD: estado=retirado, fecha_retiro=2025-01-30
```

### Caso 5: No aprendiz intenta inscribirse
```
Usuario: Admin (rol=admin)
Programa: cualquiera
Resultado: ❌ Error 403 "Solo aprendices"
Estado BD: sin cambios
```

---

## 9. Políticas y Restricciones

### Políticas de Negocio

1. **Un usuario = Un programa (activo)**
   - No duplicados en estado activo o finalizado

2. **Cupo limitado (opcional)**
   - Si `programa.cupo_maximo` está definido, se aplica límite
   - Solo cuenta inscripciones ACTIVAS

3. **Requisitos previos (extensible)**
   - Por ahora: siempre permite
   - Futura: validar competencias, programas previos, etc.

4. **Retiro en cualquier momento**
   - Usuario puede retirarse en cualquier momento
   - No requiere aprobación

5. **Historial conservado**
   - Estados RETIRADO y FINALIZADO quedan en BD
   - Reportes y análisis históricos disponibles

---

## 10. Transacciones y Atomicidad

**Nivel de aislamiento:** READ COMMITTED (default Laravel)

**Puntos de transacción:**

```
BEGIN TRANSACTION
├─ Verificar duplicado (SELECT)
├─ Verificar cupo (SELECT COUNT)
├─ Verificar requisitos (SELECT)
└─ Crear inscripción (INSERT)
COMMIT o ROLLBACK
```

**Escenarios concurrentes:**

1. **Dos usuarios inscriben simultáneamente en cupo limitado:**
   ```
   T1: SELECT COUNT → 9 (< cupo 10) → OK
   T2: SELECT COUNT → 9 (< cupo 10) → OK
   T1: INSERT → count = 10
   T2: INSERT → count = 11 (ERROR por cupo)
   
   Solución: Transacción + SELECT ... FOR UPDATE (si es crítico)
   ```

2. **Usuario intenta inscribir 2x en paralelo:**
   ```
   T1: Check duplicado → no existe → OK
   T2: Check duplicado → no existe → OK
   T1: INSERT → OK
   T2: INSERT → ERROR por UNIQUE constraint
   
   Resultado: Falla atómicamente, rollback
   ```

---

## 11. Mensajes de Error y Feedback

### Errores de Autorización
- "Debes estar autenticado para inscribirte"
- "Solo los aprendices pueden inscribirse"
- "No tienes permiso para realizar esta acción"

### Errores de Validación
- "Ya estás inscrito en este programa"
- "El programa ha alcanzado su cupo máximo"
- "No cumples con los requisitos para este programa"

### Errores de Formulario
- "Las observaciones no pueden exceder 500 caracteres"
- "Debes aceptar los términos y condiciones"

### Errores de Sistema
- "Error al procesar tu inscripción: [mensaje técnico]"
- "Error al procesar tu retiro: [mensaje técnico]"

### Mensajes de Éxito
- "¡Te has inscrito exitosamente al programa!"
- "Te has retirado del programa exitosamente"

---

## 12. Notas Técnicas

### N+1 Query Prevention
```php
// ❌ MAL: N+1 queries
$inscripciones = Inscripcion::all();
foreach ($inscripciones as $insc) {
    $programa = $insc->programa->nombre; // Query adicional
}

// ✅ BIEN: Eager loading
$inscripciones = Inscripcion::with('programa', 'instructor')->get();
```

### Índices Recomendados
```sql
CREATE INDEX idx_inscripciones_user_id ON inscripciones(user_id);
CREATE INDEX idx_inscripciones_programa_id ON inscripciones(programa_id);
CREATE INDEX idx_inscripciones_estado ON inscripciones(estado);
CREATE INDEX idx_inscripciones_fecha ON inscripciones(fecha_inscripcion);
```

### Performance
- Transacciones atómicas: ~50-100ms por inscripción
- Queries: 3-5 según validaciones
- Índices mantienen < 1ms para lookups

---

## 13. Posibles Mejoras Futuras

1. **Rate limiting** - Evitar spam de inscripciones
2. **Validación de requisitos** - Implementar lógica específica
3. **Aprobación manual** - Instructor aprueba inscripciones
4. **Notificaciones** - Email al usuario y instructor
5. **Pagos/Facturación** - Integración con sistema de pagos
6. **Certificados digitales** - Emisión automática
7. **Análisis y reportes** - Dashboard de inscripciones
8. **Auditoría** - Log de todas las acciones
9. **Estados intermedios** - En espera, pausado, etc.
10. **Grupos/Cohortes** - Agrupar inscripciones por período

---

## 14. Testing

### Test: Inscripción exitosa
```php
public function test_inscripcion_exitosa()
{
    $user = User::factory()->create();
    $user->assignRole('aprendiz');
    $programa = Programa::factory()->create();

    $response = $this->actingAs($user)
        ->post(route('inscripcion.store', $programa), [
            'observaciones' => 'Me interesa este programa',
            'acepta_terminos' => true,
        ]);

    $response->assertRedirect(route('programas.show', $programa));
    $this->assertDatabaseHas('inscripciones', [
        'user_id' => $user->id,
        'programa_id' => $programa->id,
        'estado' => 'activo',
    ]);
}
```

### Test: Duplicado rechazado
```php
public function test_duplicado_rechazado()
{
    $user = User::factory()->create();
    $user->assignRole('aprendiz');
    $programa = Programa::factory()->create();
    
    Inscripcion::create([
        'user_id' => $user->id,
        'programa_id' => $programa->id,
        'estado' => 'activo',
    ]);

    $response = $this->actingAs($user)
        ->post(route('inscripcion.store', $programa), [
            'acepta_terminos' => true,
        ]);

    $response->assertSessionHasErrors();
}
```

---

## 15. Referencias y Documentación Relacionada

- [Inscripcion Model](../app/Models/Inscripcion.php)
- [InscripcionController](../app/Http/Controllers/InscripcionController.php)
- [InscripcionRequest](../app/Http/Requests/InscripcionRequest.php)
- [inscribirse.blade.php](../resources/views/public/inscribirse.blade.php)
- [user-programs Component](../resources/views/components/profile/user-programs.blade.php)
- [COMPONENTE_USER_PROGRAMS.md](./COMPONENTE_USER_PROGRAMS.md)

---

**Última actualización:** 30 de enero de 2026  
**Versión:** 1.0  
**Autor:** Sistema de Documentación SENA
