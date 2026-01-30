<?php

namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class UserRoleController extends \App\Http\Controllers\Controller
{
    /**
     * Agrupa los permisos por categoría
     * @return array
     */
    private function getPermissionsGroupedByCategory()
    {
        $permissions = Permission::all();
        $grouped = [];

        foreach ($permissions as $permission) {
            // Dividir el nombre por el primer punto (ej: "usuarios.create" -> "usuarios")
            $parts = explode('.', $permission->name);
            $category = $parts[0] ?? 'otros';
            
            if (!isset($grouped[$category])) {
                $grouped[$category] = [];
            }
            
            $grouped[$category][] = $permission;
        }

        return $grouped;
    }

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
        $permissions = $this->getPermissionsGroupedByCategory();

        return view('admin.users.roles', compact('user', 'roles', 'userRoles', 'permissions'));
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
