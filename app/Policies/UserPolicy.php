<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->can('usuarios.manage') || $user->can('usuarios.view');
    }

    public function view(User $user, User $model): bool
    {
        return $user->can('usuarios.view') || $user->can('usuarios.manage');
    }

    public function create(User $user): bool
    {
        return $user->can('usuarios.create');
    }

    public function update(User $user, User $model): bool
    {
        return $user->can('usuarios.edit') || $user->can('usuarios.update');
    }

    public function delete(User $user, User $model): bool
    {
        return $user->can('usuarios.delete');
    }

    public function managePermissions(User $user): bool
    {
        return $user->can('usuarios.manage');
    }

    public function restore(User $user, User $model): bool
    {
        return $user->can('usuarios.manage');
    }
}
