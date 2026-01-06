<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;

class UserController extends Controller
{
    use AuthorizesRequests;

    public function index()
    {
        $this->authorize("viewAny", User::class);
        $users = User::all();
        return view('users.index', compact('users'));
    }

    public function create()
    {
        $this->authorize("create", User::class);
        return view('users.create');
    }

    public function store(Request $request)
    {
        $this->authorize("create", User::class);
        // Lógica para almacenar un nuevo usuario
    }

    public function show(User $user)
    {
        $this->authorize("view", $user);
        return view('users.show', compact('user'));
    }

    public function edit(User $user)
    {
        $this->authorize("update", $user);
        return view('users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $this->authorize("update", $user);
        // Lógica para actualizar el usuario
    }

    public function destroy(User $user)
    {
        $this->authorize("delete", $user);
        // Lógica para eliminar el usuario
    }

    public function editPermissions(User $user)
    {
        $this->authorize("managePermissions", User::class);
        return view('users.permisos', compact('user'));
    }

    public function updatePermissions(Request $request, User $user)
    {
        $this->authorize("managePermissions", User::class);
        // Lógica para actualizar los permisos del usuario
    }

    public function destroyPermissions(User $user)
    {
        $this->authorize("managePermissions", User::class);
        // Lógica para eliminar los permisos del usuario
    }

    public function restore(User $user)
    {
        $this->authorize("restore", $user);
        // Lógica para restaurar el usuario
    }

}