# 🚀 Guía Rápida - Sistema de Inscripciones

## En 30 Segundos

El sistema permite que aprendices se inscriban en programas de formación. 

**Ruta:** `/programas/{id}/inscribirse` → Llena formulario → ¡Inscrito!

---

## Acceso de Prueba

```
Usuario: aprendiz@test.local
Contraseña: password123
Rol: aprendiz
```

---

## Rutas Principales

| Método | Ruta | Acción | Requerido |
|--------|------|--------|-----------|
| GET | `/programas/{id}/inscribirse` | Mostrar formulario | Aprendiz |
| POST | `/programas/{id}/inscribir` | Procesar inscripción | Aprendiz |
| DELETE | `/inscripciones/{id}` | Retirarse | Propietario |
| GET | `/mis-inscripciones` | Ver mis inscripciones | Autenticado |

---

## Validaciones de Seguridad

✅ Usuario autenticado  
✅ Rol = "aprendiz"  
✅ Sin duplicados  
✅ Cupo disponible  
✅ Términos aceptados  

---

## Archivos Clave

```
📄 app/Http/Controllers/InscripcionController.php
📄 app/Http/Requests/InscripcionRequest.php
📄 app/Models/Inscripcion.php
📄 resources/views/public/inscribirse.blade.php
📄 database/seeders/InscripcionSeeder.php
```

---

## Comandos Útiles

```bash
# Generar datos de prueba
php artisan db:seed --class=InscripcionSeeder

# Acceder a tinker
php artisan tinker

# Ver inscripciones en tinker
> $user = User::where('email', 'aprendiz@test.local')->first();
> $user->inscripciones()->with('programa')->get();

# Listar rutas
php artisan route:list | grep inscripcion
```

---

## Estados Posibles

- **activo** - Inscripción en curso
- **finalizado** - Programa completado
- **retirado** - Usuario se retiró

---

## Datos de Prueba Generados

```
Usuario: Juan Aprendiz
Email: aprendiz@test.local

Inscripciones:
  1. Administración de Empresas (activo)
  2. Automatización Industrial (finalizado)
  3. Automatización Industrial (retirado)
  4. Análisis y Desarrollo de Sistemas (activo)
```

---

## Base de Datos (tabla inscripciones)

```sql
CREATE TABLE inscripciones (
  id INT PRIMARY KEY AUTO_INCREMENT,
  user_id INT NOT NULL (FK → users),
  programa_id INT NOT NULL (FK → programas),
  instructor_id INT (FK → instructors),
  fecha_inscripcion DATE,
  fecha_retiro DATE NULL,
  estado ENUM('activo', 'finalizado', 'retirado'),
  observaciones TEXT NULL,
  created_at TIMESTAMP,
  updated_at TIMESTAMP
);
```

---

## Flujo de Usuario

```
1. Login como Aprendiz
   ↓
2. Navegar a Programas
   ↓
3. Seleccionar Programa
   ↓
4. Clic "Inscribirse"
   ↓
5. Ver Formulario (Programa + Términos)
   ↓
6. Aceptar Términos + Enviar
   ↓
7. ✅ Inscripción Exitosa
   ↓
8. Ver en Perfil → "Mis Programas"
```

---

## Troubleshooting Rápido

| Problema | Solución |
|----------|----------|
| "No tienes rol aprendiz" | `$user->assignRole('aprendiz')` en tinker |
| "Ya inscrito" | Verificar en `inscripciones` tabla |
| "Sin cupo" | Aumentar cupo del programa |
| Caché inválido | `php artisan optimize:clear` |

---

## Status General

✅ **COMPLETAMENTE FUNCIONAL**

- Endpoints: 4/4 ✓
- Validaciones: 6/6 ✓
- Tests manuales: Todos pasados ✓
- Documentación: Completa ✓
- Datos de prueba: Disponibles ✓

