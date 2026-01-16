<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;

class UserRoleController extends Controller
{
    /**
     * Despliega el formulario para editar los permisos de un usuario
     * @param User $user
     * @return \Illuminate\Contracts\View\View
     */
    public function edit(User $user)
    {
        Gate::authorize("users.edit");
        $roles = Role::all();
        $userRoles = $user->roles->pluck('name')->toArray();

        return view('user.roles', compact('user', 'roles', 'userRoles'));
    }

    /**
     * Actualiza los permisos de un usuario
     * Evita que un admin se quite su propio rol de administrador
     * @param Request $request
     * @param User $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, User $user)
    {
        Gate::authorize("users.edit");

        $request->validate([
            'roles' => 'nullable|array',
            'roles.*' => 'exists:roles,name',
        ]);

        $authUser = Auth::user();
        $roles = $request->roles ?? [];

        // Evitar que un admin se quite su propio rol de administrador
        if (
            $authUser->id === $user->id &&
            $authUser->hasAnyRole(['admin']) &&
            !in_array('admin', $roles)
        ) {
            return back()->withErrors([
                'roles' => 'No puedes quitarte tu propio rol de administrador.'
            ]);
        }

        $user->syncRoles($roles);

        return redirect()
            ->route('users.index')
            ->with('success', 'Roles actualizados correctamente');
    }
}
