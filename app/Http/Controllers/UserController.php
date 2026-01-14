<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class UserController extends Controller
{
    use AuthorizesRequests;

    public function index()
    {
        Gate::authorize("view_users");
        $users = User::all();
        return view('user.index', compact('users'));
    }

    public function create()
    {
        Gate::authorize("create_users");
        return view('user.create');
    }

    public function store(Request $request)
    {
        Gate::authorize("create_users");
        // Lógica para almacenar un nuevo usuario
    }

    public function show(User $user)
    {
        Gate::authorize("view_users");
        return view('user.show', compact('user'));
    }

    public function edit(User $user)
    {
        Gate::authorize("edit_users");
        return view('user.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        Gate::authorize("update_users");
        // Lógica para actualizar el usuario
    }

    public function destroy(User $user)
    {
        Gate::authorize("delete_users");
        // Lógica para eliminar el usuario
    }

    public function editPermissions(User $user)
    {
        Gate::authorize("manage_users");
        return view('user.permisos', compact('user'));
    }

    public function updatePermissions(Request $request, User $user)
    {
        Gate::authorize("manage_users");
        // Lógica para actualizar los permisos del usuario
    }

    public function destroyPermissions(User $user)
    {
        Gate::authorize("manage_users");
        // Lógica para eliminar los permisos del usuario
    }

    public function restore(User $user)
    {
        Gate::authorize("manage_users");
        // Lógica para restaurar el usuario
    }

}