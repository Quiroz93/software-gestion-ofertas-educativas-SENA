<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UserController extends \App\Http\Controllers\Controller
{
    use AuthorizesRequests;

    /**
     * Despliega la lista de usuarios
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        Gate::authorize("users.view");
        $users = User::all();
        return view('admin.users.index', compact('users'));
    }

    /**
     * Despliega el formulario para crear un nuevo usuario
     * @return \Illuminate\Contracts\View\View
     */
    public function create()
    {
        Gate::authorize("users.create");
        return view('admin.users.create');
    }

    /**
     * Almacena un nuevo usuario en la base de datos
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        Gate::authorize("users.create");
        // Lógica para almacenar un nuevo usuario
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        User::create($validated);

        return redirect()->route('users.index')->with('success', 'Usuario creado exitosamente');
    }

    /**
     * Despliega los detalles de un usuario
     * @param User $user
     * @return \Illuminate\Contracts\View\View
     */
    public function show(User $user)
    {
        Gate::authorize("users.view");
        $user->load([
            'roles.permissions',
            'permissions'
        ]);

        return view('admin.users.show', compact('user'));
    }

    /**
     * Despliega el formulario para editar un usuario
     * @param User $user
     * @return \Illuminate\Contracts\View\View
     */
    public function edit(User $user)
    {
        Gate::authorize("users.edit");
        return view('admin.users.edit', compact('user'));
    }

    /**
     * Actualiza los datos de un usuario en la base de datos
     * @param Request $request
     * @param User $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, User $user)
    {
        Gate::authorize("users.edit");
        // Lógica para actualizar el usuario
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
        ]);

        $user->update($validated);

        return redirect()->route('users.index')->with('success', 'Usuario actualizado exitosamente');
    }

    /**
     * Elimina un usuario de la base de datos
     * @param User $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(User $user)
    {
        Gate::authorize("users.delete");
        // Lógica para eliminar el usuario
        $user->delete();
        return redirect()->route('users.index')->with('success', 'Usuario eliminado exitosamente');
    }

    /**
     * Despliega el formulario para editar los permisos de un usuario
     * @param User $user
     * @return \Illuminate\Contracts\View\View
     */
    public function editPermissions(User $user)
    {
        Gate::authorize("users.manage");
        return view('admin.users.permisos', compact('user'));
    }

    /**
     * Actualiza los permisos de un usuario en la base de datos
     * @param Request $request
     * @param User $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updatePermissions(Request $request, User $user)
    {
        Gate::authorize("users.manage");
        $validated = $request->validate([
            'permissions' => ['nullable', 'array'],
            'permissions.*' => ['exists:permissions,id'],
        ]);

        // Sincronizar permisos
        if (isset($validated['permissions'])) {
            $permissions = Permission::whereIn('id', $validated['permissions'])->get();
            $user->syncPermissions($permissions);
        }

        return redirect()->route('user.permisos', $user)->with('success', 'Permisos actualizados exitosamente');
    }

    /**
     * Elimina los permisos de un usuario de la base de datos
     * @param User $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroyPermissions(User $user)
    {
        Gate::authorize("users.manage");
        // Lógica para eliminar los permisos del usuario
        $user->syncPermissions([]); // elimina todos los permisos directos
        return redirect()->route('user.permisos', $user)->with('success', 'Permisos eliminados exitosamente');
    }

    /**
     * Restaurar un usuario eliminado de la base de datos
     * @param User $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function restore(User $user)
    {
        Gate::authorize("users.manage");
        // Lógica para restaurar el usuario
        $user->restore();
        return redirect()->route('users.index')->with('success', 'Usuario restaurado exitosamente');
    }

    /**
     * Despliega el formulario para editar los roles y permisos de un usuario
     * @param User $user
     * @return \Illuminate\Contracts\View\View
     */
    public function editRolesPermissions(User $user)
    {
        Gate::authorize("users.manage");
        $roles = Role::all();
        $permissions = Permission::all()
            ->groupBy(fn($p) => explode('.', $p->name)[0]);

        $user->load(['roles', 'permissions']);

        return view('admin.users.roles', compact(
            'user',
            'roles',
            'permissions'
        ));
    }

    /**
     * Actualiza los roles y permisos de un usuario en la base de datos
     * @param Request $request
     * @param User $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateRolesPermissions(Request $request, User $user)
    {
        Gate::authorize("users.manage");
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
