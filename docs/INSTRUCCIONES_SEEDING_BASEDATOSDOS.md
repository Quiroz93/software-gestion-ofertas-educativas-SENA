# Instrucciones de Seeding - BaseDeDatosDos.md

## 📋 Fuente Única de Datos

El sistema está configurado para usar **ÚNICAMENTE** el archivo:
```
docs/BaseDeDatosDos.md
```

## 🗄️ Estructura de la Base de Datos

### Tablas Principales
1. **`preinscritos`** - Registros válidos e insertados correctamente
2. **`preinscritos_rechazados`** - Registros con problemas (duplicados, sin programa, datos incompletos)

### Seeders Activos
1. **`BaseDatosDosSeeder`** - Inserta preinscritos válidos en tabla `preinscritos`
2. **`PreinscritosRechazadosSeeder`** - Registra rechazados en tabla `preinscritos_rechazados`

## 🔄 Proceso de Reseteo y Seeding Completo

### Paso 1: Eliminar la Base de Datos
```powershell
# Opción A: Desde MySQL/phpMyAdmin
DROP DATABASE nombre_base_datos;
CREATE DATABASE nombre_base_datos CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

```powershell
# Opción B: Desde terminal (si tienes acceso MySQL CLI)
mysql -u root -p -e "DROP DATABASE IF EXISTS nombre_base_datos; CREATE DATABASE nombre_base_datos CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"
```

### Paso 2: Ejecutar Migraciones
```powershell
php artisan migrate:fresh
```

Este comando:
- ✅ Elimina todas las tablas existentes
- ✅ Ejecuta todas las migraciones desde cero
- ✅ Crea estructura limpia de la base de datos

### Paso 3: Ejecutar Seeding Completo
```powershell
php artisan db:seed --force
```

Este comando ejecuta `DatabaseSeeder` que incluye:
1. UserSeeder (usuarios del sistema)
2. CentroSeeder (centros de formación)
3. RedSeeder (redes de formación)
4. NivelFormacionSeeder (niveles educativos)
5. MunicipioSeeder (municipios)
6. CompetenciaSeeder (competencias)
7. **ProgramaSeeder** (programas con fichas)
8. InstructorSeeder (instructores)
9. HistoriaDeExitoSeeder (historias de éxito)
10. OfertaSeeder (ofertas educativas)
11. NoticiaSeeder (noticias)
12. TipoNovedadSeeder (tipos de novedades)
13. **BaseDatosDosSeeder** ← Inserta preinscritos desde BaseDeDatosDos.md
14. **PreinscritosRechazadosSeeder** ← Registra rechazados desde BaseDeDatosDos.md

### Paso 4: Verificar Resultados
```powershell
# Ver conteo de preinscritos insertados
php artisan tinker
>>> \App\Models\Preinscrito::count()

# Ver conteo de rechazados
>>> \App\Models\PreinscritoRechazado::count()

# Ver breakdown de rechazados por motivo
>>> \App\Models\PreinscritoRechazado::select('motivo', DB::raw('COUNT(*) as total'))->groupBy('motivo')->get()
```

## 🎯 Ejecución Individual de Seeders

Si solo necesitas re-sembrar preinscritos:

```powershell
# Solo preinscritos válidos (trunca tabla preinscritos)
php artisan db:seed --class=BaseDatosDosSeeder --force

# Solo registros rechazados
php artisan db:seed --class=PreinscritosRechazadosSeeder --force

# Ambos en orden
php artisan db:seed --class=BaseDatosDosSeeder --force
php artisan db:seed --class=PreinscritosRechazadosSeeder --force
```

⚠️ **IMPORTANTE**: `BaseDatosDosSeeder` hace `TRUNCATE` de la tabla `preinscritos` antes de insertar.

## 📊 Formato del Archivo BaseDeDatosDos.md

### Estructura (Tab-separated)
```
nombre	tipo documento	numero documento	telefono	programa	ficha	correo electronico	Novedad
```

### Índices de Columnas (0-based)
- `[0]` nombre completo
- `[1]` tipo_documento (CC, TI, PPT, CE, PA, PEP, NIT)
- `[2]` numero_documento
- `[3]` telefono
- `[4]` programa (nombre descriptivo)
- `[5]` ficha (número de ficha del programa)
- `[6]` correo electronico
- `[7]` Novedad (comentarios/observaciones)

### Ejemplo de Línea
```
Elkin Uribe Uribe	TI	1096951423	3177434169	Análisis y Desarrollo de Software	3410551	uribeelkin011@gmail.com	
```

## 🔍 Lógica de Procesamiento

### BaseDatosDosSeeder
- ✅ Lee `docs/BaseDeDatosDos.md`
- ✅ Normaliza tipo_documento a lowercase
- ✅ Mapea ficha → programa_id
- ✅ Detecta duplicados (salta inserción)
- ✅ Valida campos requeridos
- ✅ Estado: `inscrito` (sin novedad) o `con_novedad` (con novedad)
- ✅ Extrae novedades del campo [7] → campo `comentarios`
- ✅ Fallback: correo → "sin-correo-{doc}@example.invalid", teléfono → "0000000000"

### PreinscritosRechazadosSeeder
- ✅ Lee mismo archivo `docs/BaseDeDatosDos.md`
- ✅ Detecta 3 tipos de rechazo:
  - `documento_duplicado`: Ya existe en DB o en el mismo archivo
  - `sin_programa_asignado`: Ficha vacía o 'SIN_PROGRAMA'
  - `datos_incompletos`: Nombre o documento vacío
- ✅ Almacena datos completos en JSON para auditoría
- ✅ Registra fila_excel para trazabilidad

## 📈 Resultados Esperados

Con el archivo actual (297 registros):
- ✅ **~265 registros** en `preinscritos` (válidos)
- ✅ **~296 registros** en `preinscritos_rechazados`:
  - 292 documento_duplicado (92.4%)
  - 2 sin_programa_asignado (0.6%)
  - 2 datos_incompletos (0.6%)

## 🔐 Acceso a Interfaz Admin

**URL**: `http://localhost:8000/admin/preinscritos-rechazados`

**Requiere**:
- Autenticación (`auth` middleware)
- Permiso `preinscritos.admin`

**Funcionalidades**:
- Listar registros rechazados con filtros
- Ver detalle de cada registro
- Estadísticas por tipo de rechazo
- Eliminar registros

## 🛠️ Comandos de Utilidad

```powershell
# Ver rutas relacionadas con preinscritos
php artisan route:list --name=preinscrito

# Ver estructura de tabla preinscritos
php artisan tinker
>>> Schema::getColumnListing('preinscritos')

# Limpiar solo preinscritos (sin tocar otras tablas)
php artisan tinker
>>> \App\Models\Preinscrito::truncate()
>>> \App\Models\PreinscritoRechazado::truncate()
```

## 🚨 Troubleshooting

### Error: "Archivo BaseDeDatosDos.md no encontrado"
```powershell
# Verificar existencia del archivo
Test-Path "c:\Users\AdminSena\Documents\SoeSoftware2\docs\BaseDeDatosDos.md"
```

### Error: FK constraint fails (programa_id)
```powershell
# Ejecutar ProgramaSeeder primero
php artisan db:seed --class=ProgramaSeeder --force
```

### Error: Enum value mismatch (estado)
Los valores válidos son: `inscrito`, `por_inscribir`, `con_novedad`

### Error: Duplicate entry (numero_documento)
El seeder detecta y salta duplicados automáticamente. Aparecerán en `preinscritos_rechazados`.

## 📝 Notas Importantes

1. **Orden de Ejecución**: Siempre ejecutar `ProgramaSeeder` antes de `BaseDatosDosSeeder`
2. **Truncate Automático**: `BaseDatosDosSeeder` limpia la tabla antes de insertar
3. **Idempotencia**: `PreinscritosRechazadosSeeder` NO hace truncate, acumula registros
4. **Novedades**: Se extraen del campo [7] y se guardan en `comentarios`
5. **Estado Automático**: Si existe novedad → `con_novedad`, si no → `inscrito`

## 🔄 Workflow Completo Recomendado

```powershell
# 1. Backup de datos actuales (opcional)
php artisan tinker
>>> \App\Models\Preinscrito::all()->toJson() | Out-File "backup_preinscritos.json"

# 2. Reset completo
php artisan migrate:fresh

# 3. Seeding completo (incluye preinscritos)
php artisan db:seed --force

# 4. Verificación
php artisan tinker
>>> \App\Models\Preinscrito::count()
>>> \App\Models\PreinscritoRechazado::count()

# 5. Acceder a interfaz
# http://localhost:8000/admin/preinscritos-rechazados
```

---

**Última actualización**: 2026-02-04  
**Versión del sistema**: Laravel 12.48.1  
**Archivo de referencia**: `docs/BaseDeDatosDos.md` (única fuente de verdad)
