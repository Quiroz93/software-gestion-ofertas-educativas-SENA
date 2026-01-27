# Arquitectura de Módulos Escalables para SoeSoftware

## 📐 Visión General del Sistema

Este documento describe la arquitectura propuesta para crear un sistema de configuración modular y escalable que permitirá agregar fácilmente nuevas funcionalidades al aplicativo sin comprometer el código existente.

---

## 1. Principios de Diseño

### 1.1 SOLID Principles

- **S**ingle Responsibility: Cada módulo tiene una única responsabilidad
- **O**pen/Closed: Abierto para extensión, cerrado para modificación
- **L**iskov Substitution: Las clases derivadas deben ser sustituibles
- **I**nterface Segregation: Interfaces específicas, no generales
- **D**ependency Inversion: Depender de abstracciones, no de implementaciones

### 1.2 Arquitectura Hexagonal (Ports & Adapters)

```
┌─────────────────────────────────────────────────┐
│                   FRONTEND                      │
│         (Views, Controllers, API)               │
└─────────────────────────────────────────────────┘
                      ▼
┌─────────────────────────────────────────────────┐
│              APPLICATION LAYER                  │
│     (Services, Use Cases, DTOs, Events)         │
└─────────────────────────────────────────────────┘
                      ▼
┌─────────────────────────────────────────────────┐
│               DOMAIN LAYER                      │
│      (Models, Repositories, Interfaces)         │
└─────────────────────────────────────────────────┘
                      ▼
┌─────────────────────────────────────────────────┐
│           INFRASTRUCTURE LAYER                  │
│   (Database, File System, External APIs)        │
└─────────────────────────────────────────────────┘
```

---

## 2. Estructura de Directorios Propuesta

```
app/
├── Core/                          # Núcleo del sistema
│   ├── Contracts/                 # Interfaces (Ports)
│   │   ├── RepositoryInterface.php
│   │   ├── ServiceInterface.php
│   │   ├── ModuleInterface.php
│   │   └── SettingsInterface.php
│   │
│   ├── Abstracts/                 # Clases abstractas base
│   │   ├── BaseRepository.php
│   │   ├── BaseService.php
│   │   └── BaseModule.php
│   │
│   ├── Traits/                    # Traits reutilizables
│   │   ├── HasSettings.php
│   │   ├── HasMedia.php
│   │   ├── Auditable.php
│   │   └── Searchable.php
│   │
│   └── Support/                   # Helpers y utilidades
│       ├── ModuleLoader.php
│       ├── SettingsManager.php
│       └── ConfigurationRegistry.php
│
├── Modules/                       # Módulos de la aplicación
│   ├── Profile/                   # Módulo de perfil de usuario
│   │   ├── Controllers/
│   │   ├── Services/
│   │   ├── Repositories/
│   │   ├── Models/
│   │   ├── Requests/
│   │   ├── Resources/
│   │   ├── Events/
│   │   ├── Listeners/
│   │   ├── routes.php
│   │   ├── config.php
│   │   └── ProfileServiceProvider.php
│   │
│   ├── Settings/                  # Módulo de configuraciones
│   │   ├── Controllers/
│   │   ├── Services/
│   │   ├── Models/
│   │   │   ├── SystemSetting.php
│   │   │   ├── UserSetting.php
│   │   │   └── ModuleSetting.php
│   │   └── SettingsServiceProvider.php
│   │
│   ├── Media/                     # Módulo de gestión de medios
│   │   ├── Services/
│   │   │   ├── ImageService.php
│   │   │   ├── FileService.php
│   │   │   └── VideoService.php
│   │   └── MediaServiceProvider.php
│   │
│   └── [NuevoModulo]/             # Template para nuevos módulos
│       ├── Controllers/
│       ├── Services/
│       ├── Repositories/
│       ├── Models/
│       ├── routes.php
│       ├── config.php
│       └── [NuevoModulo]ServiceProvider.php
│
├── Services/                      # Servicios globales (legacy)
├── Helpers/                       # Helpers globales
├── Http/                          # HTTP layer (legacy)
└── Models/                        # Models (legacy)
```

---

## 3. Sistema de Módulos

### 3.1 Interface de Módulo

**Archivo**: `app/Core/Contracts/ModuleInterface.php`

```php
<?php

namespace App\Core\Contracts;

interface ModuleInterface
{
    /**
     * Obtener el nombre del módulo
     */
    public function getName(): string;

    /**
     * Obtener la versión del módulo
     */
    public function getVersion(): string;

    /**
     * Obtener las dependencias del módulo
     */
    public function getDependencies(): array;

    /**
     * Boot del módulo
     */
    public function boot(): void;

    /**
     * Register del módulo
     */
    public function register(): void;

    /**
     * Obtener las rutas del módulo
     */
    public function getRoutes(): ?string;

    /**
     * Obtener las migraciones del módulo
     */
    public function getMigrations(): array;

    /**
     * Obtener la configuración del módulo
     */
    public function getConfig(): array;

    /**
     * Verificar si el módulo está habilitado
     */
    public function isEnabled(): bool;
}
```

### 3.2 Clase Abstracta de Módulo

**Archivo**: `app/Core/Abstracts/BaseModule.php`

```php
<?php

namespace App\Core\Abstracts;

use App\Core\Contracts\ModuleInterface;

abstract class BaseModule implements ModuleInterface
{
    protected string $name;
    protected string $version = '1.0.0';
    protected array $dependencies = [];
    protected bool $enabled = true;

    public function getName(): string
    {
        return $this->name ?? class_basename(static::class);
    }

    public function getVersion(): string
    {
        return $this->version;
    }

    public function getDependencies(): array
    {
        return $this->dependencies;
    }

    public function isEnabled(): bool
    {
        return $this->enabled && config("modules.{$this->getName()}.enabled", true);
    }

    public function boot(): void
    {
        if (!$this->isEnabled()) {
            return;
        }

        // Cargar rutas
        if ($routes = $this->getRoutes()) {
            require $routes;
        }

        // Cargar vistas
        $this->loadViews();

        // Cargar traducciones
        $this->loadTranslations();

        // Publicar assets
        $this->publishAssets();
    }

    public function register(): void
    {
        // Registrar configuración
        $this->mergeConfigFrom(
            $this->getConfigPath(),
            'modules.' . $this->getName()
        );
    }

    public function getRoutes(): ?string
    {
        $routesPath = $this->getModulePath() . '/routes.php';
        return file_exists($routesPath) ? $routesPath : null;
    }

    public function getMigrations(): array
    {
        $migrationsPath = $this->getModulePath() . '/Database/Migrations';
        
        if (!is_dir($migrationsPath)) {
            return [];
        }

        return glob($migrationsPath . '/*.php');
    }

    public function getConfig(): array
    {
        return config("modules.{$this->getName()}", []);
    }

    protected function getModulePath(): string
    {
        $reflection = new \ReflectionClass($this);
        return dirname($reflection->getFileName());
    }

    protected function getConfigPath(): string
    {
        return $this->getModulePath() . '/config.php';
    }

    protected function loadViews(): void
    {
        $viewsPath = $this->getModulePath() . '/Views';
        
        if (is_dir($viewsPath)) {
            app('view')->addNamespace($this->getName(), $viewsPath);
        }
    }

    protected function loadTranslations(): void
    {
        $langPath = $this->getModulePath() . '/Lang';
        
        if (is_dir($langPath)) {
            app('translator')->addNamespace($this->getName(), $langPath);
        }
    }

    protected function publishAssets(): void
    {
        $assetsPath = $this->getModulePath() . '/Assets';
        
        if (is_dir($assetsPath)) {
            app('events')->listen('publishes', function() use ($assetsPath) {
                publishes([
                    $assetsPath => public_path('modules/' . strtolower($this->getName()))
                ], 'module-assets');
            });
        }
    }

    protected function mergeConfigFrom(string $path, string $key): void
    {
        if (file_exists($path)) {
            config()->set($key, array_merge(
                require $path,
                config($key, [])
            ));
        }
    }
}
```

### 3.3 Module Loader

**Archivo**: `app/Core/Support/ModuleLoader.php`

```php
<?php

namespace App\Core\Support;

use App\Core\Contracts\ModuleInterface;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\File;

class ModuleLoader
{
    protected Collection $modules;
    protected array $booted = [];

    public function __construct()
    {
        $this->modules = collect();
    }

    /**
     * Descubrir módulos automáticamente
     */
    public function discover(): self
    {
        $modulesPath = app_path('Modules');

        if (!File::exists($modulesPath)) {
            return $this;
        }

        $directories = File::directories($modulesPath);

        foreach ($directories as $directory) {
            $this->loadModule($directory);
        }

        return $this;
    }

    /**
     * Cargar un módulo específico
     */
    protected function loadModule(string $path): void
    {
        $moduleName = basename($path);
        $providerClass = "App\\Modules\\{$moduleName}\\{$moduleName}ServiceProvider";

        if (!class_exists($providerClass)) {
            return;
        }

        $provider = app($providerClass);

        if ($provider instanceof ModuleInterface) {
            $this->modules->put($moduleName, $provider);
        }
    }

    /**
     * Registrar todos los módulos
     */
    public function register(): void
    {
        $this->modules->each(function (ModuleInterface $module) {
            if ($module->isEnabled()) {
                $module->register();
            }
        });
    }

    /**
     * Boot de todos los módulos
     */
    public function boot(): void
    {
        // Resolver dependencias y ordenar módulos
        $sorted = $this->sortByDependencies();

        $sorted->each(function (ModuleInterface $module) {
            if ($module->isEnabled() && !in_array($module->getName(), $this->booted)) {
                $module->boot();
                $this->booted[] = $module->getName();
            }
        });
    }

    /**
     * Ordenar módulos por dependencias
     */
    protected function sortByDependencies(): Collection
    {
        $sorted = collect();
        $visited = [];

        $visit = function (ModuleInterface $module) use (&$visit, &$sorted, &$visited) {
            $name = $module->getName();

            if (in_array($name, $visited)) {
                return;
            }

            $visited[] = $name;

            foreach ($module->getDependencies() as $dependency) {
                if ($dependencyModule = $this->modules->get($dependency)) {
                    $visit($dependencyModule);
                }
            }

            $sorted->push($module);
        };

        $this->modules->each(function (ModuleInterface $module) use ($visit) {
            $visit($module);
        });

        return $sorted;
    }

    /**
     * Obtener módulo específico
     */
    public function get(string $name): ?ModuleInterface
    {
        return $this->modules->get($name);
    }

    /**
     * Obtener todos los módulos
     */
    public function all(): Collection
    {
        return $this->modules;
    }

    /**
     * Obtener módulos habilitados
     */
    public function enabled(): Collection
    {
        return $this->modules->filter(function (ModuleInterface $module) {
            return $module->isEnabled();
        });
    }

    /**
     * Verificar si un módulo existe
     */
    public function has(string $name): bool
    {
        return $this->modules->has($name);
    }
}
```

---

## 4. Sistema de Configuraciones

### 4.1 Settings Manager

**Archivo**: `app/Core/Support/SettingsManager.php`

```php
<?php

namespace App\Core\Support;

use Illuminate\Support\Facades\Cache;
use App\Models\SystemSetting;
use App\Models\UserSetting;

class SettingsManager
{
    protected string $cachePrefix = 'settings';
    protected int $cacheTtl = 3600; // 1 hora

    /**
     * Obtener configuración del sistema
     */
    public function system(string $key, mixed $default = null): mixed
    {
        $cacheKey = "{$this->cachePrefix}.system.{$key}";

        return Cache::remember($cacheKey, $this->cacheTtl, function () use ($key, $default) {
            $setting = SystemSetting::where('key', $key)->first();
            
            return $setting ? $this->castValue($setting->value, $setting->type) : $default;
        });
    }

    /**
     * Establecer configuración del sistema
     */
    public function setSystem(string $key, mixed $value, ?string $type = null): void
    {
        $type = $type ?? $this->detectType($value);

        SystemSetting::updateOrCreate(
            ['key' => $key],
            [
                'value' => $this->prepareValue($value, $type),
                'type' => $type
            ]
        );

        Cache::forget("{$this->cachePrefix}.system.{$key}");
    }

    /**
     * Obtener configuración de usuario
     */
    public function user(int $userId, string $key, mixed $default = null): mixed
    {
        $cacheKey = "{$this->cachePrefix}.user.{$userId}.{$key}";

        return Cache::remember($cacheKey, $this->cacheTtl, function () use ($userId, $key, $default) {
            $setting = UserSetting::where('user_id', $userId)
                ->where('setting_key', $key)
                ->first();
            
            return $setting ? $this->castValue($setting->setting_value, $setting->setting_type) : $default;
        });
    }

    /**
     * Establecer configuración de usuario
     */
    public function setUser(int $userId, string $key, mixed $value): void
    {
        $type = $this->detectType($value);

        UserSetting::updateOrCreate(
            [
                'user_id' => $userId,
                'setting_key' => $key
            ],
            [
                'setting_value' => $this->prepareValue($value, $type),
                'setting_type' => $type
            ]
        );

        Cache::forget("{$this->cachePrefix}.user.{$userId}.{$key}");
    }

    /**
     * Obtener todas las configuraciones de usuario
     */
    public function userAll(int $userId): array
    {
        $cacheKey = "{$this->cachePrefix}.user.{$userId}.all";

        return Cache::remember($cacheKey, $this->cacheTtl, function () use ($userId) {
            return UserSetting::where('user_id', $userId)
                ->get()
                ->mapWithKeys(function ($setting) {
                    return [
                        $setting->setting_key => $this->castValue(
                            $setting->setting_value,
                            $setting->setting_type
                        )
                    ];
                })
                ->toArray();
        });
    }

    /**
     * Limpiar cache de configuraciones
     */
    public function clearCache(?string $scope = null, ?int $userId = null): void
    {
        if ($scope === 'system') {
            Cache::forget("{$this->cachePrefix}.system.*");
        } elseif ($scope === 'user' && $userId) {
            Cache::forget("{$this->cachePrefix}.user.{$userId}.*");
        } else {
            Cache::forget("{$this->cachePrefix}.*");
        }
    }

    /**
     * Detectar tipo de dato
     */
    protected function detectType(mixed $value): string
    {
        return match (true) {
            is_bool($value) => 'boolean',
            is_int($value) => 'integer',
            is_float($value) => 'float',
            is_array($value) || is_object($value) => 'json',
            default => 'string'
        };
    }

    /**
     * Preparar valor para almacenar
     */
    protected function prepareValue(mixed $value, string $type): string
    {
        return match ($type) {
            'json' => json_encode($value),
            'boolean' => $value ? '1' : '0',
            default => (string) $value
        };
    }

    /**
     * Convertir valor desde la BD
     */
    protected function castValue(string $value, string $type): mixed
    {
        return match ($type) {
            'json' => json_decode($value, true),
            'boolean' => (bool) $value,
            'integer' => (int) $value,
            'float' => (float) $value,
            default => $value
        };
    }
}
```

### 4.2 Helpers Globales

**Archivo**: `app/Helpers/helpers.php` (agregar)

```php
if (!function_exists('settings')) {
    /**
     * Acceso rápido al settings manager
     */
    function settings(): \App\Core\Support\SettingsManager
    {
        return app(\App\Core\Support\SettingsManager::class);
    }
}

if (!function_exists('system_setting')) {
    /**
     * Obtener configuración del sistema
     */
    function system_setting(string $key, mixed $default = null): mixed
    {
        return settings()->system($key, $default);
    }
}

if (!function_exists('user_setting')) {
    /**
     * Obtener configuración del usuario actual
     */
    function user_setting(string $key, mixed $default = null): mixed
    {
        if (!auth()->check()) {
            return $default;
        }

        return settings()->user(auth()->id(), $key, $default);
    }
}

if (!function_exists('set_system_setting')) {
    /**
     * Establecer configuración del sistema
     */
    function set_system_setting(string $key, mixed $value, ?string $type = null): void
    {
        settings()->setSystem($key, $value, $type);
    }
}

if (!function_exists('set_user_setting')) {
    /**
     * Establecer configuración del usuario actual
     */
    function set_user_setting(string $key, mixed $value): void
    {
        if (!auth()->check()) {
            return;
        }

        settings()->setUser(auth()->id(), $key, $value);
    }
}

if (!function_exists('modules')) {
    /**
     * Acceso rápido al module loader
     */
    function modules(): \App\Core\Support\ModuleLoader
    {
        return app(\App\Core\Support\ModuleLoader::class);
    }
}
```

---

## 5. Ejemplo de Módulo: Profile

### 5.1 ProfileServiceProvider

**Archivo**: `app/Modules/Profile/ProfileServiceProvider.php`

```php
<?php

namespace App\Modules\Profile;

use App\Core\Abstracts\BaseModule;
use Illuminate\Support\Facades\Route;

class ProfileServiceProvider extends BaseModule
{
    protected string $name = 'Profile';
    protected string $version = '1.0.0';
    protected array $dependencies = ['Settings', 'Media'];

    public function register(): void
    {
        parent::register();

        // Registrar servicios del módulo
        $this->app->singleton(
            Services\ProfileService::class,
            function ($app) {
                return new Services\ProfileService(
                    $app->make(Repositories\ProfileRepository::class)
                );
            }
        );
    }

    public function boot(): void
    {
        parent::boot();

        // Registrar rutas
        $this->registerRoutes();

        // Registrar políticas
        $this->registerPolicies();

        // Registrar eventos
        $this->registerEvents();
    }

    protected function registerRoutes(): void
    {
        Route::middleware(['web', 'auth'])
            ->prefix('profile')
            ->name('profile.')
            ->group(function () {
                require __DIR__ . '/routes.php';
            });
    }

    protected function registerPolicies(): void
    {
        \Gate::policy(Models\UserProfile::class, Policies\ProfilePolicy::class);
    }

    protected function registerEvents(): void
    {
        \Event::listen(
            Events\ProfileUpdated::class,
            Listeners\UpdateProfileCache::class
        );
    }
}
```

### 5.2 Configuración del Módulo

**Archivo**: `app/Modules/Profile/config.php`

```php
<?php

return [
    'enabled' => true,

    'max_photo_size' => 2048, // KB

    'allowed_photo_types' => ['jpeg', 'jpg', 'png', 'webp'],

    'photo_dimensions' => [
        'max_width' => 1024,
        'max_height' => 1024,
    ],

    'default_avatar' => [
        'service' => 'ui-avatars',
        'background' => 'EBF4FF',
        'color' => '7F9CF5',
    ],

    'fields' => [
        'name' => ['required', 'max:255'],
        'bio' => ['nullable', 'max:500'],
        'phone' => ['nullable', 'max:20'],
        'location' => ['nullable', 'max:100'],
        'website' => ['nullable', 'url', 'max:255'],
    ],
];
```

---

## 6. Configuración del Sistema

### 6.1 Registrar Module Loader

**Archivo**: `app/Providers/AppServiceProvider.php`

```php
<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Core\Support\ModuleLoader;
use App\Core\Support\SettingsManager;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        // Registrar Module Loader
        $this->app->singleton(ModuleLoader::class, function () {
            return new ModuleLoader();
        });

        // Registrar Settings Manager
        $this->app->singleton(SettingsManager::class, function () {
            return new SettingsManager();
        });
    }

    public function boot(): void
    {
        // Descubrir y registrar módulos
        $moduleLoader = $this->app->make(ModuleLoader::class);
        $moduleLoader->discover()->register();

        // Boot de módulos
        $this->app->booted(function () use ($moduleLoader) {
            $moduleLoader->boot();
        });
    }
}
```

### 6.2 Configuración de Módulos

**Archivo**: `config/modules.php` (nuevo)

```php
<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Módulos del Sistema
    |--------------------------------------------------------------------------
    |
    | Configuración global de módulos
    |
    */

    'enabled' => env('MODULES_ENABLED', true),

    'cache' => [
        'enabled' => true,
        'ttl' => 3600, // 1 hora
    ],

    'autoload' => true,

    'modules_path' => app_path('Modules'),

    /*
    |--------------------------------------------------------------------------
    | Configuración Individual de Módulos
    |--------------------------------------------------------------------------
    */

    'Profile' => [
        'enabled' => true,
    ],

    'Settings' => [
        'enabled' => true,
    ],

    'Media' => [
        'enabled' => true,
    ],
];
```

---

## 7. Uso del Sistema

### 7.1 Configuraciones del Sistema

```php
// Obtener configuración
$siteName = system_setting('site_name', 'SoeSoftware');
$maintenanceMode = system_setting('maintenance_mode', false);

// Establecer configuración
set_system_setting('site_name', 'SENA SOE');
set_system_setting('maintenance_mode', true, 'boolean');
```

### 7.2 Configuraciones de Usuario

```php
// Obtener configuración del usuario actual
$theme = user_setting('theme', 'light');
$language = user_setting('language', 'es');
$notifications = user_setting('notifications_enabled', true);

// Establecer configuración
set_user_setting('theme', 'dark');
set_user_setting('notifications_enabled', false);

// Obtener todas las configuraciones
$allSettings = settings()->userAll(auth()->id());
```

### 7.3 Trabajar con Módulos

```php
// Obtener módulo específico
$profileModule = modules()->get('Profile');

// Verificar si un módulo existe
if (modules()->has('Profile')) {
    // ...
}

// Obtener todos los módulos habilitados
$enabled = modules()->enabled();

// Información del módulo
$module = modules()->get('Profile');
echo $module->getName();    // "Profile"
echo $module->getVersion(); // "1.0.0"
echo $module->isEnabled();  // true
```

---

## 8. Ventajas de esta Arquitectura

✅ **Modularidad**: Cada módulo es independiente y autónomo

✅ **Escalabilidad**: Fácil agregar nuevos módulos sin modificar código existente

✅ **Mantenibilidad**: Código organizado y fácil de mantener

✅ **Testabilidad**: Módulos pueden ser testeados independientemente

✅ **Reutilización**: Componentes y servicios reutilizables

✅ **Flexibilidad**: Configuración centralizada y personalizable

✅ **Performance**: Cache integrado en configuraciones

✅ **Extensibilidad**: Fácil extender funcionalidad mediante traits e interfaces

---

## 9. Próximos Pasos

1. Implementar estructura base (Core)
2. Migrar sistema de perfiles a módulo
3. Crear módulo de Settings
4. Crear módulo de Media
5. Documentar cada módulo
6. Crear tests unitarios
7. Migrar funcionalidad existente a módulos

---

**Fecha**: {{ date('d/m/Y') }}  
**Versión**: 1.0
