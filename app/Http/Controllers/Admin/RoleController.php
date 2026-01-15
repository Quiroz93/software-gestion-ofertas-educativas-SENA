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
     * Display a listing of the resource.
     */
    public function index()
    {
        $roles = Role::with('permissions')->get();
        return view('admin.roles.index', compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $permissions = Permission::all();
        return view('admin.roles.create', compact('permissions'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
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
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Role $role)
{
    $permissions = Permission::orderBy('name')->get()
        ->groupBy(fn($p) => explode('.', $p->name)[0]);

    $rolePermissions = $role->permissions->pluck('id')->toArray();

    return view('roles.edit', compact('role', 'permissions', 'rolePermissions'));
}

    /**
     * Update the specified resource in storage.
     */
 public function update(Request $request, Role $role)
    {
        $role->update(['name' => $request->name]);
        $role->syncPermissions($request->permissions ?? []);
        return redirect()->route('roles.index');
    }


public function destroy(Role $role)
{
    $this->authorize('roles.delete'); // o middleware

    if (in_array($role->name, ['admin', 'super-admin'])) {
        return back()->with('error', 'No se puede eliminar este rol');
    }

    $role->delete();

    return redirect()
        ->route('roles.index')
        ->with('success', 'Rol eliminado exitosamente');
}

}
