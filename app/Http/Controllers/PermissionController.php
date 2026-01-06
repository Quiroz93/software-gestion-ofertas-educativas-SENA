<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    public function index()
    {
        // Lógica para mostrar los permisos
    }

    public function store(Request $request)
    {
        // Lógica para crear un nuevo permiso
    }

    public function show($id)
    {
        // Lógica para mostrar un permiso específico
    }

    public function edit($id)
    {
        // Lógica para editar un permiso específico
    }

    public function updatePermisos(Request $request, User $user)
{
    $request->validate([
        'roles' => 'nullable|array',
        'roles.*' => 'exists:roles,name',

        'permissions' => 'nullable|array',
        'permissions.*' => 'exists:permissions,name',
    ]);
    $user->syncRoles($request->roles ?? []);
    $user->syncPermissions($request->permissions ?? []);

    return back()->with('success', 'Permisos actualizados correctamente');
}

    public function destroy($id)
    {
        // Lógica para eliminar un permiso específico
    }
}
