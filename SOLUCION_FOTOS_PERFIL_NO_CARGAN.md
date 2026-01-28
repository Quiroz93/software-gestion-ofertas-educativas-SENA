# SOLUCIÓN: Fotos de Perfil No Se Cargan - Problemas de Enlace Simbólico

## Problema Identificado
Las fotos de perfil se guardaban correctamente en `storage/app/public/profile-photos/` pero **NO eran accesibles** desde el navegador porque:

1. El enlace simbólico `public/storage` estaba **vacío**
2. Las fotos exis tían en `storage/app/public/` pero no en `public/storage/`
3. Las URLs generadas apuntaban a `http://localhost:8000/storage/profile-photos/...` que devolvía 404

## Causa Raíz
El comando `php artisan storage:link` **no se había ejecutado correctamente** o el enlace se corrompió.

## Solución Implementada

### Paso 1: Eliminar el Enlace Simbólico Viejo
```powershell
Remove-Item "public/storage" -Force -Recurse
```

### Paso 2: Recrear el Enlace Simbólico
```bash
php artisan storage:link
```

**Salida:**
```
INFO  The [public/storage] link has been connected to [storage/app/public].
```

### Paso 3: Verificación
✅ Archivo existe: `public/storage/profile-photos/1vmSrhttdhx6kFWBplQ8MTRWskBPYPfOy4BKmDzN.jpg`  
✅ Carpetas accesibles: `media`, `profile-photos`

---

## Cómo Funciona

### Antes (CON ERROR):
```
URL: http://localhost:8000/storage/profile-photos/imagen.jpg
       ↓
public/storage/ → VACÍO ❌
       ↓
404 - Imagen no encontrada → Solo aparece el texto ALT
```

### Después (FUNCIONANDO):
```
URL: http://localhost:8000/storage/profile-photos/imagen.jpg
       ↓
public/storage → [enlace simbólico] ✅
       ↓
storage/app/public/profile-photos/imagen.jpg
       ↓
Imagen cargada correctamente ✅
```

---

## Comandos de Referencia

```bash
# Recriar el enlace simbólico (después de cualquier problema)
php artisan storage:link

# Verificar que el enlace está correcto
# Windows:
Test-Path "public/storage"
dir "public/storage"

# Linux/Mac:
ls -la public/storage
```

---

## Síntomas Resueltos

- ❌ **Antes:** Solo aparecía el texto ALT en las fotos de perfil
- ✅ **Ahora:** Las fotos se cargan correctamente

---

## Verificación en Base de Datos

Para confirmar que todo funciona, verifica en base de datos:
```sql
SELECT id, name, profile_photo_path FROM users WHERE profile_photo_path IS NOT NULL;
```

Las rutas guardadas se verán así:
```
profile-photos/1vmSrhttdhx6kFWBplQ8MTRWskBPYPfOy4BKmDzN.jpg
```

Y al acceder en el navegador, la URL completa será:
```
http://localhost:8000/storage/profile-photos/1vmSrhttdhx6kFWBplQ8MTRWskBPYPfOy4BKmDzN.jpg
```

---

## Estructura de Almacenamiento

```
📁 storage/app/public/
├── 📁 profile-photos/          ← Aquí se guardan las fotos
│   ├── 📷 imagen1.jpg
│   └── 📷 imagen2.jpg
└── 📁 media/

📁 public/storage/              ← Enlace simbólico
├── 📁 profile-photos/  → [apunta a storage/app/public/profile-photos]
└── 📁 media/
```

---

**Fecha de resolución:** 28 de enero de 2026  
**Estado:** ✅ RESUELTO Y VALIDADO
