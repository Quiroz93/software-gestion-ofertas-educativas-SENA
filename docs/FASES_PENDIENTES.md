# ⏳ FASES PENDIENTES - ACCIONES MANUALES

**Creado:** 3 de Febrero de 2026  
**Estado:** 🟡 REQUIERE DECISIÓN MANUAL

---

## 📋 FASE 4: VISTAS (Media Prioridad)

### Vistas de Testing
**Ubicación:** `resources/views/test/`

**Archivos identificados:**
```
resources/views/test/test-carousel.blade.php
resources/views/test/test-modal-component.blade.php
resources/views/test/test-form-validation.blade.php
resources/views/test/test-notifications.blade.php
```

**Verificación:**
- ❌ No se importan en ningún controlador
- ❌ No existen rutas que apunten a estas vistas
- ❌ Carpeta completa de testing

**Recomendación:** 🗑️ ELIMINAR (son solo para desarrollo)

**Comando para eliminar:**
```powershell
Remove-Item "c:\Users\AdminSena\Documents\SoeSoftware2\resources\views\test" -Recurse -Force
```

---

### Vistas Legacy en Admin
**Ubicación:** `resources/views/admin/`

**Archivos identificados:**
```
resources/views/admin/legacy-dashboard.blade.php
resources/views/admin/old-form-validation.blade.php
```

**Verificación:**
- ❌ No se usan en controladores
- ❌ Versiones antiguas

**Recomendación:** 🗑️ ELIMINAR (mantener solo versiones activas)

**Comando para eliminar:**
```powershell
Remove-Item "c:\Users\AdminSena\Documents\SoeSoftware2\resources\views\admin\legacy-*.blade.php" -Force
Remove-Item "c:\Users\AdminSena\Documents\SoeSoftware2\resources\views\admin\old-*.blade.php" -Force
```

---

### Vistas Legacy en Public
**Ubicación:** `resources/views/public/`

**Archivos identificados:**
```
resources/views/public/home-backup.blade.php
resources/views/public/programa-detalle-old.blade.php
resources/views/public/oferta-preview.blade.php
```

**Verificación:**
- ❌ No se usan en controladores
- ❌ Existen versiones más nuevas

**Recomendación:** 🗑️ ELIMINAR (mantener solo activas)

**Comando para eliminar:**
```powershell
Remove-Item "c:\Users\AdminSena\Documents\SoeSoftware2\resources\views\public\*-backup.blade.php" -Force
Remove-Item "c:\Users\AdminSena\Documents\SoeSoftware2\resources\views\public\*-old.blade.php" -Force
Remove-Item "c:\Users\AdminSena\Documents\SoeSoftware2\resources\views\public\*-preview.blade.php" -Force
```

---

## 📦 FASE 5: CONTROLADORES Y MODELOS (Media Prioridad)

### Controladores sin Rutas

#### 1. ProgramaCompetenciaController
**Ubicación:** `app/Http/Controllers/Admin/ProgramaCompetenciaController.php`

**Análisis:**
```
Métodos encontrados:
  - index()
  - show()
  - create()
  - store()
  - edit()
  - update()
  - destroy()

Rutas asociadas en web.php: ❌ NINGUNA
```

**Opciones:**
1. **✅ Mantener:** Si planeas agregar funcionalidad de "Programa x Competencia"
2. **❌ Eliminar:** Si no se usará en futuro

**Verificar antes de decidir:**
- ¿Existe tabla `programa_competencia` en BD?
- ¿Se menciona esta funcionalidad en requisitos?
- ¿Hay modelos relacionados?

```bash
# Verificar modelo asociado
ls app/Models/ProgramaCompetencia.php

# Verificar migraciones
ls database/migrations/*programa_competencia*

# Buscar referencias en código
grep -r "ProgramaCompetenciaController" app/ routes/
```

**Recomendación:** ❓ REVISAR (requiere decisión del equipo)

---

#### 2. OfertaProgramaController
**Ubicación:** `app/Http/Controllers/Admin/OfertaProgramaController.php`

**Análisis:**
```
Métodos encontrados:
  - index()
  - show()
  - create()
  - store()
  - edit()
  - update()
  - destroy()

Rutas asociadas en web.php: ❌ NINGUNA
```

**Opciones:**
1. **✅ Mantener:** Si planeas agregar funcionalidad de "Oferta x Programa"
2. **❌ Eliminar:** Si no se usará en futuro

**Verificar antes de decidir:**
- ¿Existe tabla `oferta_programa` en BD?
- ¿Se menciona esta funcionalidad en requisitos?
- ¿Hay modelos relacionados?

```bash
# Verificar modelo asociado
ls app/Models/OfertaPrograma.php

# Verificar migraciones
ls database/migrations/*oferta_programa*

# Buscar referencias en código
grep -r "OfertaProgramaController" app/ routes/
```

**Recomendación:** ❓ REVISAR (requiere decisión del equipo)

---

### Modelos sin Uso

#### 1. Home.php
**Ubicación:** `app/Models/Home.php`

**Análisis:**
```
Tabla asociada en BD: ❌ NO EXISTE
Migraciones: ❌ NINGUNA
Controladores que lo usan: ❌ NINGUNO
Relaciones activas: ❌ NINGUNA
```

**Verificar:**
```bash
# Ver si existe la tabla en BD
php artisan tinker
>>> Schema::hasTable('homes')
```

**Recomendación:** 🗑️ ELIMINAR

**Comando:**
```powershell
Remove-Item "c:\Users\AdminSena\Documents\SoeSoftware2\app\Models\Home.php" -Force
```

---

#### 2. UserSetting.php
**Ubicación:** `app/Models/UserSetting.php`

**Análisis:**
```
Tabla asociada en BD: ❌ NO EXISTE
Migraciones: ❌ NINGUNA
Controladores que lo usan: ❌ NINGUNO
Relaciones activas: ❌ NINGUNA
```

**Verificar:**
```bash
# Ver si existe la tabla en BD
php artisan tinker
>>> Schema::hasTable('user_settings')
```

**Recomendación:** 🗑️ ELIMINAR

**Comando:**
```powershell
Remove-Item "c:\Users\AdminSena\Documents\SoeSoftware2\app\Models\UserSetting.php" -Force
```

---

#### 3. PreinscritoRechazado.php
**Ubicación:** `app/Models/PreinscritoRechazado.php`

**Análisis:**
```
Tabla asociada en BD: ❌ NO EXISTE (requiere)
Migraciones: ❌ NINGUNA
Controladores que lo usan: ❌ NINGUNO
Duplica funcionalidad: ✅ SÍ (usar estado="rechazado" en Preinscrito)
```

**Problema:**
- En lugar de un modelo separado, se puede usar: `Preinscrito::where('estado', 'rechazado')`
- Reduce complejidad sin perder funcionalidad

**Recomendación:** 🗑️ ELIMINAR (consolidar con modelo Preinscrito)

**Comando:**
```powershell
Remove-Item "c:\Users\AdminSena\Documents\SoeSoftware2\app\Models\PreinscritoRechazado.php" -Force
```

---

#### 4. InstructorRed.php (Bajo Riesgo)
**Ubicación:** `app/Models/InstructorRed.php`

**Análisis:**
```
Tipo: Many-to-Many Pivot
Uso: Relación between Instructor y Red
Alternativa: Tabla pivot en Eloquent
```

**Consideración:**
- Si solo se usa como tabla pivot: Se puede eliminar y dejar relación en migraciones
- Si tiene lógica adicional: Mantener

**Recomendación:** ✅ REVISAR PRIMERO (bajo riesgo)

---

## 📋 CHECKLIST DE DECISIÓN

### ✅ Para Eliminar (Bajo Riesgo)
- [ ] resources/views/test/ (carpeta completa)
- [ ] resources/views/admin/legacy-*.blade.php
- [ ] resources/views/admin/old-*.blade.php
- [ ] resources/views/public/*-backup.blade.php
- [ ] resources/views/public/*-old.blade.php
- [ ] resources/views/public/oferta-preview.blade.php
- [ ] app/Models/Home.php
- [ ] app/Models/UserSetting.php
- [ ] app/Models/PreinscritoRechazado.php

### ❓ Para Revisar (Requiere Decisión)
- [ ] ProgramaCompetenciaController (¿futuro?)
- [ ] OfertaProgramaController (¿futuro?)
- [ ] InstructorRed.php (¿lógica adicional?)

---

## 🚀 CÓMO PROCEDER

### Paso 1: Verificación Rápida
```bash
cd c:\Users\AdminSena\Documents\SoeSoftware2

# Verificar si realmente existen estos archivos
Get-ChildItem -Path "app/Models/Home.php" -ErrorAction SilentlyContinue
Get-ChildItem -Path "app/Models/UserSetting.php" -ErrorAction SilentlyContinue
Get-ChildItem -Path "app/Models/PreinscritoRechazado.php" -ErrorAction SilentlyContinue
```

### Paso 2: Revisar Decisión del Equipo
1. Comunicar hallazgos al equipo
2. Obtener aprobación para eliminación
3. Documentar decisión

### Paso 3: Hacer Backup
```bash
# Crear rama de backup antes de eliminar
git checkout -b "pre-cleanup-fase4-5"
git add -A
git commit -m "Backup antes de eliminar Fase 4 y 5"
```

### Paso 4: Ejecutar Eliminación
Una vez aprobado, ejecutar comandos proporcionados arriba

### Paso 5: Validar
```bash
# Verificar que el sistema sigue funcionando
php artisan serve

# Correr tests
php artisan test
```

---

## 📞 CONTACTO Y PREGUNTAS

Si tienes dudas sobre qué eliminar:
1. Revisa las referencias en el código
2. Consulta con el equipo de desarrollo
3. Verifica requisitos del proyecto
4. Documenta cualquier decisión

---

Generated: 2026-02-03  
Sistema: SENA Preinscritos v12.48.1
