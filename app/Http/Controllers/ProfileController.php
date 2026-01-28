<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Illuminate\Support\Facades\Gate;

class ProfileController extends Controller
{
    /**
     * Despliega el formulario para editar el perfil del usuario
     * @param Request $request
     * @return \Illuminate\Contracts\View\View
     */
    public function edit(Request $request): View
    {
        Gate::authorize('profile.update', $request->user());
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Actualiza la información del perfil del usuario
     * @param ProfileUpdateRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        Gate::authorize('profile.update', $request->user());
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Elimina la cuenta del usuario
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request): RedirectResponse
    {
        Gate::authorize('profile.delete', $request->user());
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

    /**
     * Actualiza la foto de perfil del usuario
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function photoUpdate(Request $request): RedirectResponse
    {
        Gate::authorize('profile.update', $request->user());
        
        $request->validate([
            'photo' => ['required', 'image', 'mimes:jpg,jpeg,png,gif', 'max:2048'],
        ]);

        $request->user()->updateProfilePhoto($request->file('photo'));

        return Redirect::route('profile.edit')->with('status', 'photo-updated');
    }

    /**
     * Elimina la foto de perfil del usuario
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function photoDestroy(Request $request): RedirectResponse
    {
        Gate::authorize('profile.update', $request->user());
        
        $request->user()->deleteProfilePhoto();

        return Redirect::route('profile.edit')->with('status', 'photo-deleted');
    }
}
