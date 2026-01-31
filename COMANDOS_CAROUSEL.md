# CRUD Carousel - Comandos de Utilidad

## Migración de Base de Datos

```bash
# Ejecutar las migraciones
php artisan migrate

# Si necesitas rollback (revertir)
php artisan migrate:rollback

# Rollback todas las migraciones
php artisan migrate:reset
```

## Rutas Disponibles

```bash
# Ver todas las rutas del carousel
php artisan route:list | grep admin.home-carousel
```

### Rutas Generadas:
```
GET|HEAD   admin/carousel                              admin.home-carousel.index
POST       admin/carousel                              admin.home-carousel.store
GET|HEAD   admin/carousel/create                       admin.home-carousel.create
GET|HEAD   admin/carousel/{homeCarousel}/edit          admin.home-carousel.edit
PUT        admin/carousel/{homeCarousel}               admin.home-carousel.update
DELETE     admin/carousel/{homeCarousel}               admin.home-carousel.destroy
PATCH      admin/carousel/{homeCarousel}/toggle-active admin.home-carousel.toggle-active
```

## Testing en Tinker

```bash
php artisan tinker
```

```php
// Crear un slide de prueba
use App\Models\HomeCarousel;

HomeCarousel::create([
    'title' => 'Primer Slide',
    'description' => 'Descripción de prueba',
    'button_text' => 'Ver más',
    'button_url' => 'https://ejemplo.com',
    'position' => 0,
    'is_active' => true
]);

// Ver todos los slides
HomeCarousel::all();

// Ver solo activos ordenados
HomeCarousel::where('is_active', true)->orderBy('position')->get();

// Actualizar un slide
$slide = HomeCarousel::find(1);
$slide->update(['title' => 'Nuevo título']);

// Eliminar un slide
$slide->delete();
```

## Limpiar Cache

```bash
# Limpiar cache de rutas
php artisan route:cache
php artisan route:clear

# Limpiar cache de config
php artisan config:cache
php artisan config:clear

# Limpiar todo
php artisan cache:clear
```

## Storage

```bash
# Enlazar storage público (si no está enlazado)
php artisan storage:link

# Ver archivos del carousel
ls storage/app/public/carousel/
```

## Validación Rápida

### 1. Comprobar que el controlador existe
```php
use App\Http\Controllers\Admin\HomeCarouselController;

// Debe retornar la clase
```

### 2. Comprobar que el modelo existe
```php
use App\Models\HomeCarousel;

// Debe retornar la clase
$slides = HomeCarousel::all();
```

### 3. Comprobar que las rutas existen
```bash
php artisan route:list --path=admin/carousel
```

### 4. Comprobar que las vistas existen
```bash
ls resources/views/admin/home-carousel/
# Debe retornar: _form.blade.php, create.blade.php, edit.blade.php, index.blade.php
```

## URLs de Acceso

- **Listado:** `http://localhost/admin/carousel`
- **Crear:** `http://localhost/admin/carousel/create`
- **Editar:** `http://localhost/admin/carousel/1/edit` (replace 1 with ID)
- **Dashboard:** `http://localhost/admin/dashboard` (debe mostrar tarjeta)

## Troubleshooting

### Error: "No se encuentra la ruta"
```bash
php artisan route:cache
php artisan route:clear
php artisan config:clear
```

### Error: "Clase no encontrada"
```bash
composer dump-autoload
```

### Error: "Tabla no existe"
```bash
php artisan migrate
```

### Error: "Archivo no se sube"
```bash
# Verificar permisos
chmod -R 755 storage/app/public

# Crear enlace si no existe
php artisan storage:link
```

### Error de CSRF
```
Token CSRF inválido o expirado
→ Asegúrate de que @csrf está en el formulario
```

## Estadísticas

- **Líneas de código:** ~600 (controlador + vistas)
- **Archivos creados:** 7
- **Rutas registradas:** 7
- **Métodos del controlador:** 7
- **Campos de BD:** 8

## Performance

```bash
# Generar consultas optimizadas
php artisan query:optimize

# Generar índices si es necesario
php artisan db:seed
```

## Seguridad

```bash
# Escanear vulnerabilidades
composer audit

# Actualizar dependencias
composer update
```

## Notas Importantes

⚠️ Asegúrate de:
- [ ] Ejecutar `php artisan migrate`
- [ ] Ejecutar `php artisan storage:link`
- [ ] Tener permisos de escritura en `storage/app/public`
- [ ] Estar autenticado para acceder al admin
- [ ] Actualizar el home público para mostrar slides

✨ El CRUD está listo para usar inmediatamente después de ejecutar estas comandos.
