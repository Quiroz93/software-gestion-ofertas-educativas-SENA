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
