<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;

class UserRoleController extends Controller
{
    public function edit(User $user)
    {
        $roles = Role::all();
        $userRoles = $user->roles->pluck('name')->toArray();

        return view('user.roles', compact('user', 'roles', 'userRoles'));
    }

    public function update(Request $request, User $user)
    {

        $request->validate([
            'roles' => 'nullable|array',
            'roles.*' => 'exists:roles,name',
        ]);

        $authUser = Auth::user();
        $roles = $request->roles ?? [];

        // 🚫 Evitar que un admin se quite su propio rol
        if (
            $authUser->id === $user->id &&
            $authUser->hasRole('admin') &&
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
