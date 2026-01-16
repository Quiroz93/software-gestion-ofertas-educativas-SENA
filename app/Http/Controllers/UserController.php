<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    use AuthorizesRequests;

    public function index()
    {
        Gate::authorize("users.view");
        $users = User::all();
        return view('user.index', compact('users'));
    }

    public function create()
    {
        Gate::authorize("users.create");
        return view('user.create');
    }

    public function store(Request $request)
    {
        Gate::authorize("users.create");
        // Lógica para almacenar un nuevo usuario
    }

    public function show(User $user)
    {
        $user->load([
            'roles.permissions',
            'permissions'
        ]);

        return view('user.show', compact('user'));
    }


    public function edit(User $user)
    {
        Gate::authorize("users.edit");
        return view('user.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        Gate::authorize("users.edit");
        // Lógica para actualizar el usuario
    }

    public function destroy(User $user)
    {
        Gate::authorize("users.delete");
        // Lógica para eliminar el usuario
    }

    public function editPermissions(User $user)
    {
        Gate::authorize("users.manage");
        return view('user.permisos', compact('user'));
    }

    public function updatePermissions(Request $request, User $user)
    {
        Gate::authorize("users.manage");
        // Lógica para actualizar los permisos del usuario
    }

    public function destroyPermissions(User $user)
    {
        Gate::authorize("users.manage");
        // Lógica para eliminar los permisos del usuario
    }

    public function restore(User $user)
    {
        Gate::authorize("users.manage");
        // Lógica para restaurar el usuario
    }

    // Gestión de roles y permisos por usuario
    public function editRolesPermissions(User $user)
    {
        $roles = Role::all();
        $permissions = Permission::all()
            ->groupBy(fn($p) => explode('.', $p->name)[0]);

        $user->load(['roles', 'permissions']);

        return view('user.roles', compact(
            'user',
            'roles',
            'permissions'
        ));
    }

    public function updateRolesPermissions(Request $request, User $user)
    {
        $validated = $request->validate([
            'roles' => ['nullable', 'array'],
            'roles.*' => ['exists:roles,id'],

            'permissions' => ['nullable', 'array'],
            'permissions.*' => ['exists:permissions,id'],
        ]);

        // Sincronizar roles
        if (isset($validated['roles'])) {
            $roles = Role::whereIn('id', $validated['roles'])->get();
            $user->syncRoles($roles);
        } else {
            $user->syncRoles([]); // elimina todos los roles
        }

        // Sincronizar permisos directos
        if (isset($validated['permissions'])) {
            $permissions = Permission::whereIn('id', $validated['permissions'])->get();
            $user->syncPermissions($permissions);
        } else {
            $user->syncPermissions([]); // elimina permisos directos
        }

        return redirect()
            ->route('users.show', $user->id)
            ->with('success', 'Roles y permisos actualizados correctamente.');
    }
}
