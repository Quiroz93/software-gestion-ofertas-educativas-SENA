<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->can('view_usuarios') || $user->can('view_usuarios');
    }

    public function view(User $user, User $model): bool
    {
        return $user->can('view_usuarios') || $user->can('manage_usuarios');
    }

    public function create(User $user): bool
    {
        return $user->can('create_usuarios');
    }

    public function update(User $user, User $model): bool
    {
        return $user->can('edit_usuarios') || $user->can('update_usuarios');
    }

    public function delete(User $user, User $model): bool
    {
        return $user->can('delete_usuarios');
    }

    public function managePermissions(User $user): bool
    {
        return $user->can('manage_usuarios');
    }

    public function restore(User $user, User $model): bool
    {
        return $user->can('manage_usuarios');
    }
}
