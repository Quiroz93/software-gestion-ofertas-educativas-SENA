<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Determinar si el usuario puede ver cualquier usuario.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('users.index') || $user->can('users.view');
    }

    /**
     * Determinar si el usuario puede ver un usuario en particular.
     */
    public function view(User $user, User $model): bool
    {
        return $user->can('users.show') || $user->can('users.show');
    }

    /**
     * Determinar si el usuario puede crear un usuario.
     */
    public function create(User $user): bool
    {
        return $user->can('users.create');
    }

    /**
     * Determinar si el usuario puede actualizar un usuario.
     */
    public function update(User $user, User $model): bool
    {
        return $user->can('users.edit') || $user->can('users.update');
    }

    /**
     * Determinar si el usuario puede eliminar un usuario.
     */
    public function delete(User $user, User $model): bool
    {
        return $user->can('users.delete');
    }

    /**
     * Determinar si el usuario puede gestionar permisos de usuarios.
     */
    public function managePermissions(User $user): bool
    {
        return $user->can('users.manage');
    }

    /**
     * Determinar si el usuario puede restaurar un usuario eliminado.
     */
    public function restore(User $user, User $model): bool
    {
        return $user->can('users.restore');
    }
}
