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
        $role = Role::create([
            'name' => $request->name,
            'guard_name' => 'web'
        ]);

        $role->syncPermissions($request->permissions ?? []);

        return redirect()->route('roles.index');
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
    public function edit(string $id)
    {
        $role = Role::findOrFail($id);
        $permissions = Permission::all();
        return view('admin.roles.edit', compact( 'role', 'permissions'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Role $role)
{
    $request->validate([
        'name' => 'required|string|unique:roles,name,' . $role->id,
    ]);

    $role->update(['name' => $request->name]);
    $role->syncPermissions($request->permissions ?? []);

    return redirect()->route('roles.index')
        ->with('success', 'Rol actualizado correctamente');
}

public function destroy(Role $role)
{
    $this->authorize('delete_roles'); // o middleware

    if (in_array($role->name, ['admin', 'super-admin'])) {
        return back()->with('error', 'No se puede eliminar este rol');
    }

    $role->delete();

    return redirect()
        ->route('roles.index')
        ->with('success', 'Rol eliminado exitosamente');
}

}
