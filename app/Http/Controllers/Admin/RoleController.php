<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    use AuthorizesRequests;
    /**
     * Despliega la lista de roles.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        $this->authorize('roles.view'); // o middleware

        $roles = Role::with('permissions')->get();
        return view('admin.roles.index', compact('roles'));
    }

    /**
     * Despliega el formulario para crear un nuevo rol.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function create()
    {
        $this->authorize('roles.create'); // o middleware

        $permissions = Permission::all();
        return view('admin.roles.create', compact('permissions'));
    }

    /**
     * Almacena un nuevo rol en la base de datos.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $this->authorize('roles.create'); // o middleware

        $request->validate([
            'name' => 'required|string|max:255|unique:roles,name',
            'guard_name' => 'required|string',
            'permissions' => 'array'
        ]);

        $role = Role::create([
            'name' => $request->name,
            'guard_name' => $request->guard_name,
        ]);

        $role->syncPermissions($request->permissions ?? []);

        return redirect()
            ->route('roles.index')
            ->with('success', 'Rol creado correctamente');
    }


    /**
     * Despliega la información detallada de un rol.
     *
     * @param Role $role
     * @return \Illuminate\Contracts\View\View
     */
    public function show(Role $role)
    {
        $this->authorize('roles.view'); // o middleware

        return view('admin.roles.show', compact('role'));
    }

    /**
     * Despliega el formulario para editar un rol existente.
     *
     * @param Role $role
     * @return \Illuminate\Contracts\View\View
     */
    public function edit(Role $role)
    {
        $this->authorize('roles.edit'); // o middleware

        $permissions = Permission::orderBy('name')->get()
            ->groupBy(fn($p) => explode('.', $p->name)[0]);

        $rolePermissions = $role->permissions->pluck('id')->toArray();

        return view('admin.roles.edit', compact('role', 'permissions', 'rolePermissions'));
    }

    /**
     * Actualiza un rol existente en la base de datos.
     *
     * @param Request $request
     * @param Role $role
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Role $role)
    {
        $this->authorize('roles.edit'); // o middleware

        $request->validate([
            'name' => 'required|string|max:255|unique:roles,name,' . $role->id,
            'guard_name' => 'required|string',
            'permissions' => 'array'
        ]);

        $role->update([
            'name' => $request->name,
            /*'guard_name' => $request->guard_name,
            'permissions' => $request->permissions ?? []
            */
        ]);

        $permissionIds = $request->permissions ?? [];

        // Convertir IDs → modelos Permission
        $permissions = Permission::whereIn('id', $permissionIds)->get();

        // Spatie acepta modelos
        $role->syncPermissions($permissions);

        return redirect()
            ->route('roles.index', $role->id)
            ->with('success', 'Rol actualizado correctamente');
    }



    /**
     * Elimina un rol existente de la base de datos.
     *
     * @param Role $role
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Role $role)
    {
        $this->authorize('roles.delete'); // o middleware


        if (in_array($role->name, ['admin', 'super-admin'])) {
            return back()->with('error', 'No se puede eliminar este rol porque es el rol más alto de la jerarquía');
        }

        if ($role->users()->count() > 0) {
            return back()->with('error', 'No se puede eliminar este rol porque está asignado a usuarios');
        }

        $role->delete();

        return redirect()
            ->route('roles.index')
            ->with('success', 'Rol eliminado exitosamente');
    }
}
