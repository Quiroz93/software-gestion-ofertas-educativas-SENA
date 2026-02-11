<?php

namespace App\Traits;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

trait HasProfilePhoto
{
    /**
     * Actualizar la foto de perfil del usuario
     */
    public function updateProfilePhoto(UploadedFile $photo): void
    {
        tap($this->profile_photo_path, function ($previous) use ($photo) {
            // Generar un nombre único para la foto
            $filename = 'profile-' . $this->id . '-' . Str::random(10) . '.' . $photo->getClientOriginalExtension();
            $path = 'uploads/profile-photos';
            
            // Guardar en public/uploads/profile-photos
            $photo->move(public_path($path), $filename);
            
            // Guardar la ruta relativa en la BD
            $this->forceFill([
                'profile_photo_path' => $filename,
            ])->save();

            // Eliminar foto anterior si existe
            if ($previous) {
                $oldPath = public_path('uploads/profile-photos/' . $previous);
                if (file_exists($oldPath)) {
                    unlink($oldPath);
                }
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

        $photoPath = public_path('uploads/profile-photos/' . $this->profile_photo_path);
        if (file_exists($photoPath)) {
            unlink($photoPath);
        }

        $this->forceFill([
            'profile_photo_path' => null,
        ])->save();
    }

    /**
     * Obtener la URL de la foto de perfil
     */
    public function getProfilePhotoUrlAttribute(): string
    {
        if (!$this->profile_photo_path) {
            return $this->defaultProfilePhotoUrl();
        }

        // Retornar la URL directa a la carpeta pública
        return config('app.url') . '/uploads/profile-photos/' . $this->profile_photo_path;
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

    /**
     * Compatibilidad con AdminLTE para descripción de usuario
     */
    public function adminlte_desc(): string
    {
        return $this->email ?? '';
    }

    /**
     * Compatibilidad con AdminLTE para URL del perfil
     */
    public function adminlte_profile_url(): string
    {
        return route('profile.edit');
    }
}
