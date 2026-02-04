# Solución de Problemas Comunes

## 🖼️ Las imágenes no se muestran (Error 404 en /storage)

### **Causa del problema**
El enlace simbólico entre `public/storage` y `storage/app/public` no existe o está roto.

### **Síntomas**
- Las fotos de perfil no se muestran
- Error 404 en rutas como `/storage/profile-photos/...`
- En los logs aparece: `[404]: GET /storage - No such file or directory`

### **Solución rápida**
```bash
php artisan storage:link
```

### **Verificación**
Ejecuta el script de verificación incluido:

**Windows (PowerShell):**
```powershell
.\check-storage.ps1
```

**Linux/Mac:**
```bash
chmod +x check-storage.sh
./check-storage.sh
```

### **Solución manual si persiste el error**

**Windows:**
```powershell
# Eliminar enlace roto
Remove-Item "public\storage" -Recurse -Force

# Crear nuevo enlace
php artisan storage:link
```

**Linux/Mac:**
```bash
# Eliminar enlace roto
rm -rf public/storage

# Crear nuevo enlace
php artisan storage:link
```

### **¿Por qué sucede esto?**
Los enlaces simbólicos no se almacenan en Git porque:
1. Son específicos del sistema operativo
2. Pueden apuntar a rutas absolutas diferentes según la máquina
3. Git solo rastrea archivos, no enlaces del sistema

**Situaciones donde el enlace se pierde:**
- Al clonar el repositorio en una nueva máquina
- Al cambiar de sistema operativo (Windows ↔ Linux ↔ Mac)
- Después de limpiar el directorio `public/`
- Al restaurar un backup sin preservar enlaces simbólicos

---

## 📋 Cómo prevenir este problema

### 1. **Automatización en composer.json** ✅
Ya incluido en el proyecto. El comando `composer setup` ejecuta automáticamente:
```bash
php artisan storage:link
```

### 2. **Documentación en README** ✅
El archivo README.md incluye instrucciones claras sobre:
- Requisitos del sistema
- Pasos de instalación
- Sección específica sobre el enlace simbólico

### 3. **Scripts de verificación** ✅
Archivos incluidos en el proyecto:
- `check-storage.ps1` (Windows PowerShell)
- `check-storage.sh` (Linux/Mac Bash)

**Úsalos cuando:**
- Configures el proyecto por primera vez
- Cambies de entorno
- Encuentres errores 404 en archivos de storage

### 4. **Checklist para nuevos desarrolladores**
Al unirse al proyecto, asegúrate de:
- [ ] Clonar el repositorio
- [ ] Ejecutar `composer setup` o `composer install`
- [ ] Copiar `.env.example` a `.env`
- [ ] Configurar base de datos en `.env`
- [ ] Ejecutar `php artisan storage:link`
- [ ] Ejecutar `php artisan migrate --seed`
- [ ] Verificar con `.\check-storage.ps1`

---

## 🔧 Otros problemas relacionados con storage

### Error: "No se puede escribir en storage"
**Solución (Linux/Mac):**
```bash
chmod -R 775 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache
```

**Solución (Windows):**
Generalmente no es necesario, pero verifica permisos del usuario en las carpetas.

### Error: "Class 'Intervention\Image' not found"
```bash
composer require intervention/image
```

### Storage disk 'public' no configurado
Verifica en `config/filesystems.php`:
```php
'disks' => [
    'public' => [
        'driver' => 'local',
        'root' => storage_path('app/public'),
        'url' => env('APP_URL').'/storage',
        'visibility' => 'public',
    ],
],
```

---

## 📞 Soporte adicional
Si los problemas persisten:
1. Verifica los logs: `storage/logs/laravel.log`
2. Ejecuta: `php artisan optimize:clear`
3. Revisa que el servidor web tenga permisos adecuados
4. Consulta con el equipo de desarrollo

---

**Última actualización:** 28 de enero de 2026  
**Mantenedor:** Equipo de Desarrollo SENA
