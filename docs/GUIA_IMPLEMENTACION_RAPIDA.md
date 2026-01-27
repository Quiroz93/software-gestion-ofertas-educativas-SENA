# Guía Rápida de Implementación: Sistema de Perfiles

## 🚀 Inicio Rápido (Quick Start)

Esta guía te llevará paso a paso en la implementación del nuevo sistema de perfiles de usuario con foto personalizable.

---

## PASO 1: Base de Datos (15 minutos)

### 1.1 Crear Migraciones

```bash
php artisan make:migration add_profile_fields_to_users_table
php artisan make:migration create_user_settings_table
```

### 1.2 Editar Migración de Usuarios

**Archivo**: `database/migrations/YYYY_MM_DD_HHMMSS_add_profile_fields_to_users_table.php`

```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('profile_photo_path', 2048)->nullable()->after('email');
            $table->text('bio')->nullable()->after('profile_photo_path');
            $table->string('phone', 20)->nullable()->after('bio');
            $table->string('location', 100)->nullable()->after('phone');
            $table->string('website')->nullable()->after('location');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'profile_photo_path',
                'bio',
                'phone',
                'location',
                'website'
            ]);
        });
    }
};
```

### 1.3 Editar Migración de Configuraciones

**Archivo**: `database/migrations/YYYY_MM_DD_HHMMSS_create_user_settings_table.php`

```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('user_settings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('setting_key', 100);
            $table->text('setting_value')->nullable();
            $table->enum('setting_type', ['string', 'json', 'boolean', 'integer'])->default('string');
            $table->timestamps();

            $table->unique(['user_id', 'setting_key']);
            $table->index(['user_id', 'setting_key']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_settings');
    }
};
```

### 1.4 Ejecutar Migraciones

```bash
php artisan migrate
```

**Verificar**:
```bash
php artisan tinker
>>> Schema::hasColumn('users', 'profile_photo_path')
=> true
>>> Schema::hasTable('user_settings')
=> true
```

---

## PASO 2: Trait HasProfilePhoto (20 minutos)

### 2.1 Crear el Trait

**Archivo**: `app/Traits/HasProfilePhoto.php`

```bash
mkdir -p app/Traits
```

```php
<?php

namespace App\Traits;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

trait HasProfilePhoto
{
    /**
     * Actualizar la foto de perfil del usuario
     */
    public function updateProfilePhoto(UploadedFile $photo): void
    {
        tap($this->profile_photo_path, function ($previous) use ($photo) {
            $this->forceFill([
                'profile_photo_path' => $photo->storePublicly(
                    'profile-photos', 
                    ['disk' => $this->profilePhotoDisk()]
                ),
            ])->save();

            if ($previous) {
                Storage::disk($this->profilePhotoDisk())->delete($previous);
            }
        });
    }

    /**
     * Eliminar la foto de perfil del usuario
     */
    public function deleteProfilePhoto(): void
    {
        if (is_null($this->profile_photo_path)) {
            return;
        }

        Storage::disk($this->profilePhotoDisk())->delete($this->profile_photo_path);

        $this->forceFill([
            'profile_photo_path' => null,
        ])->save();
    }

    /**
     * Obtener la URL de la foto de perfil
     */
    public function getProfilePhotoUrlAttribute(): string
    {
        return $this->profile_photo_path
            ? Storage::disk($this->profilePhotoDisk())->url($this->profile_photo_path)
            : $this->defaultProfilePhotoUrl();
    }

    /**
     * Obtener la URL de la foto de perfil por defecto
     */
    protected function defaultProfilePhotoUrl(): string
    {
        $name = trim(collect(explode(' ', $this->name))->map(function ($segment) {
            return mb_substr($segment, 0, 1);
        })->join(' '));

        return 'https://ui-avatars.com/api/?name='.urlencode($name).'&color=7F9CF5&background=EBF4FF';
    }

    /**
     * Obtener el disco donde se almacenan las fotos de perfil
     */
    protected function profilePhotoDisk(): string
    {
        return config('app.profile_photo_disk', 'public');
    }

    /**
     * Compatibilidad con AdminLTE
     */
    public function adminlte_image(): string
    {
        return $this->profile_photo_url;
    }
}
```

### 2.2 Actualizar User Model

**Archivo**: `app/Models/User.php`

```php
<?php

namespace App\Models;

use App\Traits\HasProfilePhoto;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable, HasRoles, HasProfilePhoto;

    protected $fillable = [
        'name',
        'email',
        'password',
        'profile_photo_path',
        'bio',
        'phone',
        'location',
        'website',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $appends = [
        'profile_photo_url',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Relación con configuraciones de usuario
     */
    public function settings()
    {
        return $this->hasMany(UserSetting::class);
    }
}
```

### 2.3 Configurar Filesystem

**Archivo**: `config/app.php`

Agregar al final del array de configuración:

```php
    /*
    |--------------------------------------------------------------------------
    | Profile Photo Disk
    |--------------------------------------------------------------------------
    |
    | Disco de almacenamiento para las fotos de perfil de los usuarios
    |
    */

    'profile_photo_disk' => env('PROFILE_PHOTO_DISK', 'public'),
```

**Archivo**: `.env`

```env
PROFILE_PHOTO_DISK=public
```

### 2.4 Crear Enlace Simbólico (si no existe)

```bash
php artisan storage:link
```

---

## PASO 3: Controlador y Rutas (15 minutos)

### 3.1 Crear ProfilePhotoController

```bash
php artisan make:controller ProfilePhotoController
```

**Archivo**: `app/Http/Controllers/ProfilePhotoController.php`

```php
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Gate;

class ProfilePhotoController extends Controller
{
    /**
     * Actualizar la foto de perfil del usuario
     */
    public function update(Request $request): RedirectResponse
    {
        Gate::authorize('profile.update', $request->user());

        $request->validate([
            'photo' => ['required', 'image', 'mimes:jpeg,png,jpg,webp', 'max:2048'],
        ], [
            'photo.required' => 'Debes seleccionar una imagen.',
            'photo.image' => 'El archivo debe ser una imagen.',
            'photo.mimes' => 'La imagen debe ser formato: jpeg, png, jpg o webp.',
            'photo.max' => 'La imagen no debe superar los 2MB.',
        ]);

        $request->user()->updateProfilePhoto($request->file('photo'));

        return back()->with('success', 'Foto de perfil actualizada correctamente.');
    }

    /**
     * Eliminar la foto de perfil del usuario
     */
    public function destroy(Request $request): RedirectResponse
    {
        Gate::authorize('profile.update', $request->user());

        $request->user()->deleteProfilePhoto();

        return back()->with('success', 'Foto de perfil eliminada correctamente.');
    }
}
```

### 3.2 Agregar Rutas

**Archivo**: `routes/web.php`

Agregar dentro del grupo `middleware(['auth'])`:

```php
Route::middleware(['auth'])->group(function () {
    // ... rutas existentes ...

    // Rutas de foto de perfil
    Route::put('/profile/photo', [ProfilePhotoController::class, 'update'])
        ->name('profile.photo.update');
    Route::delete('/profile/photo', [ProfilePhotoController::class, 'destroy'])
        ->name('profile.photo.destroy');
});
```

---

## PASO 4: Vista de Actualización de Foto (25 minutos)

### 4.1 Crear Partial de Foto de Perfil

**Archivo**: `resources/views/profile/partials/update-profile-photo-form.blade.php`

```blade
<section>
    <header>
        <h2 class="h5 text-dark">
            Foto de Perfil
        </h2>
        <p class="text-muted small">
            Actualiza la foto de perfil de tu cuenta.
        </p>
    </header>

    <div class="mt-3">
        <!-- Vista previa de la foto actual -->
        <div class="d-flex align-items-center mb-3">
            <div class="me-3">
                <img src="{{ auth()->user()->profile_photo_url }}" 
                     alt="{{ auth()->user()->name }}" 
                     class="rounded-circle"
                     style="width: 80px; height: 80px; object-fit: cover;"
                     id="photo-preview">
            </div>
            <div>
                <p class="mb-1 fw-bold">{{ auth()->user()->name }}</p>
                <p class="mb-0 text-muted small">{{ auth()->user()->email }}</p>
            </div>
        </div>

        <!-- Formulario de subida -->
        <form method="POST" action="{{ route('profile.photo.update') }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="photo" class="form-label">Seleccionar nueva foto</label>
                <input type="file" 
                       class="form-control @error('photo') is-invalid @enderror" 
                       id="photo" 
                       name="photo" 
                       accept="image/*"
                       onchange="previewPhoto(event)">
                @error('photo')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                <small class="form-text text-muted">
                    Formatos permitidos: JPEG, PNG, JPG, WEBP. Tamaño máximo: 2MB
                </small>
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-upload me-1"></i> Subir Foto
                </button>

                @if(auth()->user()->profile_photo_path)
                    <button type="button" 
                            class="btn btn-outline-danger" 
                            onclick="deletePhoto()">
                        <i class="fas fa-trash me-1"></i> Eliminar Foto
                    </button>
                @endif
            </div>
        </form>

        <!-- Formulario oculto para eliminar -->
        <form method="POST" 
              action="{{ route('profile.photo.destroy') }}" 
              id="delete-photo-form" 
              class="d-none">
            @csrf
            @method('DELETE')
        </form>
    </div>

    @push('scripts')
    <script>
        // Preview de la foto antes de subir
        function previewPhoto(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('photo-preview').src = e.target.result;
                }
                reader.readAsDataURL(file);
            }
        }

        // Confirmar eliminación de foto
        function deletePhoto() {
            Swal.fire({
                title: '¿Eliminar foto de perfil?',
                text: "Se restaurará la foto por defecto",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-photo-form').submit();
                }
            });
        }
    </script>
    @endpush
</section>
```

### 4.2 Actualizar Vista de Edición de Perfil

**Archivo**: `resources/views/profile/edit.blade.php`

```blade
@extends('layouts.app')

@section('title', 'Perfil')

@section('content')

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <!-- NUEVA SECCIÓN: Foto de Perfil -->
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-photo-form')
                </div>
            </div>

            <!-- Información del perfil -->
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <!-- Actualizar contraseña -->
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <!-- Eliminar cuenta -->
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>

@endsection

@stack('scripts')
```

---

## PASO 5: Actualizar Configuración AdminLTE (5 minutos)

**Archivo**: `config/adminlte.php`

Actualizar las siguientes configuraciones:

```php
    'usermenu_enabled' => true,
    'usermenu_header' => true,
    'usermenu_header_class' => 'bg-primary',
    'usermenu_image' => true,
    'usermenu_desc' => false,
    'usermenu_profile_url' => 'profile',  // ← Cambiar de false a 'profile'
    'profile_url' => 'profile',            // ← Cambiar de false a 'profile'
```

---

## PASO 6: Probar el Sistema (10 minutos)

### 6.1 Prueba Manual

1. Inicia sesión en la aplicación
2. Ve al menú de usuario (esquina superior derecha)
3. Haz clic en tu nombre o foto
4. Debes ver la opción "Perfil"
5. Entra a "Perfil"
6. Verás la nueva sección de foto de perfil
7. Prueba subir una imagen
8. Verifica que se actualice en el menú superior

### 6.2 Prueba con Tinker

```bash
php artisan tinker
```

```php
$user = User::first();

// Ver foto actual
$user->profile_photo_url

// Verificar que el trait funciona
method_exists($user, 'updateProfilePhoto')  // debe retornar true

// Probar foto por defecto
$user->defaultProfilePhotoUrl()
```

### 6.3 Verificar Archivos Subidos

```bash
ls -la storage/app/public/profile-photos/
```

---

## PASO 7: Campos Adicionales del Perfil (Opcional) (15 minutos)

### 7.1 Actualizar Formulario de Información

**Archivo**: `resources/views/profile/partials/update-profile-information-form.blade.php`

Agregar después del campo de email:

```blade
<!-- Bio -->
<div class="mb-3">
    <label for="bio" class="form-label">Biografía</label>
    <textarea 
        class="form-control @error('bio') is-invalid @enderror" 
        id="bio" 
        name="bio" 
        rows="3"
        placeholder="Cuéntanos sobre ti">{{ old('bio', $user->bio) }}</textarea>
    @error('bio')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<!-- Teléfono -->
<div class="mb-3">
    <label for="phone" class="form-label">Teléfono</label>
    <input type="text" 
           class="form-control @error('phone') is-invalid @enderror" 
           id="phone" 
           name="phone" 
           value="{{ old('phone', $user->phone) }}"
           placeholder="+57 300 123 4567">
    @error('phone')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<!-- Ubicación -->
<div class="mb-3">
    <label for="location" class="form-label">Ubicación</label>
    <input type="text" 
           class="form-control @error('location') is-invalid @enderror" 
           id="location" 
           name="location" 
           value="{{ old('location', $user->location) }}"
           placeholder="Ciudad, País">
    @error('location')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<!-- Sitio Web -->
<div class="mb-3">
    <label for="website" class="form-label">Sitio Web</label>
    <input type="url" 
           class="form-control @error('website') is-invalid @enderror" 
           id="website" 
           name="website" 
           value="{{ old('website', $user->website) }}"
           placeholder="https://ejemplo.com">
    @error('website')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>
```

### 7.2 Actualizar ProfileController

**Archivo**: `app/Http/Controllers/ProfileController.php`

Actualizar método `update()`:

```php
public function update(ProfileUpdateRequest $request): RedirectResponse
{
    Gate::authorize('profile.update', $request->user());
    
    $request->user()->fill($request->validated());

    if ($request->user()->isDirty('email')) {
        $request->user()->email_verified_at = null;
    }

    $request->user()->save();

    return Redirect::route('profile.edit')
        ->with('success', 'Perfil actualizado correctamente.');
}
```

### 7.3 Actualizar ProfileUpdateRequest

**Archivo**: `app/Http/Requests/ProfileUpdateRequest.php`

```php
public function rules(): array
{
    return [
        'name' => ['required', 'string', 'max:255'],
        'email' => ['required', 'email', 'max:255', Rule::unique(User::class)->ignore($this->user()->id)],
        'bio' => ['nullable', 'string', 'max:500'],
        'phone' => ['nullable', 'string', 'max:20'],
        'location' => ['nullable', 'string', 'max:100'],
        'website' => ['nullable', 'url', 'max:255'],
    ];
}
```

---

## ✅ Verificación Final

### Checklist de Implementación

- [ ] Migraciones ejecutadas correctamente
- [ ] Trait `HasProfilePhoto` creado
- [ ] Modelo `User` actualizado con el trait
- [ ] Storage link creado
- [ ] Controlador `ProfilePhotoController` creado
- [ ] Rutas agregadas
- [ ] Vista de foto de perfil creada
- [ ] Configuración AdminLTE actualizada
- [ ] Probado: subir foto
- [ ] Probado: eliminar foto
- [ ] Probado: preview antes de subir
- [ ] Foto se muestra en menú de usuario
- [ ] Campos adicionales agregados (opcional)

---

## 🎉 ¡Listo!

Tu sistema de perfiles con foto personalizable está completamente funcional. Los usuarios ahora pueden:

- ✅ Subir su propia foto de perfil
- ✅ Ver preview antes de subir
- ✅ Eliminar su foto de perfil
- ✅ Ver foto por defecto con iniciales si no tienen foto
- ✅ La foto se muestra en el menú de AdminLTE automáticamente

---

## 🚀 Próximos Pasos

1. **Testing**: Crear tests automatizados
2. **Validaciones**: Agregar validaciones de dimensiones de imagen
3. **Optimización**: Comprimir imágenes automáticamente
4. **Crops**: Permitir recortar imágenes antes de subir
5. **Bootstrap 5**: Comenzar migración gradual

---

## 📞 Soporte

Si encuentras algún error, revisa:
1. Los logs de Laravel: `storage/logs/laravel.log`
2. Permisos de `storage/app/public`
3. Que el enlace simbólico existe: `public/storage`
4. Configuración de `.env`

