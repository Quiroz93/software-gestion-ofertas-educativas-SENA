<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class RolesController extends Controller
{
    public function index()
    {
        // Lógica para mostrar los roles
    }

    public function store(Request $request)
    {
        // Lógica para crear un nuevo rol
    }

    public function show($id)
    {
        // Lógica para mostrar un rol específico
    }

    public function edit($id)
    {
        // Lógica para editar un rol específico
    }

    
public function updateRoles(Request $request, User $user)
{
    $request->validate([
        'roles' => 'array',
        'roles.*' => 'exists:roles,name',
    ]);

    $user->syncRoles($request->roles ?? []);

    return back()->with('success', 'Rol actualizado correctamente');
}

    public function destroy($id)
    {
        // Lógica para eliminar un rol específico
    }

    public function assignRoleToUser(Request $request, $userId)
    {
        // Lógica para asignar un rol a un usuario
    }

    public function updateRoleToUser(Request $request, $userId)
    {
        // Lógica para actualizar el rol de un usuario
    }

    public function destroyRoleFromUser(Request $request, $userId)
    {
        // Lógica para eliminar el rol de un usuario
    }
}
