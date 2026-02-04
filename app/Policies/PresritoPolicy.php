<?php

namespace App\Policies;

use App\Models\Preinscrito;
use App\Models\User;

class PresritoPolicy
{
    /**
     * Determinar si el usuario puede ver la lista de preinscritos
     */
    public function viewAny(User $user): bool
    {
        return $user->can('preinscritos.view');
    }

    /**
     * Determinar si el usuario puede ver un preinscrito específico
     */
    public function view(User $user, Preinscrito $presrito): bool
    {
        return $user->can('preinscritos.view');
    }

    /**
     * Determinar si el usuario puede crear un preinscrito
     */
    public function create(User $user): bool
    {
        return $user->can('preinscritos.create');
    }

    /**
     * Determinar si el usuario puede editar un preinscrito
     */
    public function update(User $user, Preinscrito $presrito): bool
    {
        return $user->can('preinscritos.edit');
    }

    /**
     * Determinar si el usuario puede eliminar un preinscrito
     */
    public function delete(User $user, Preinscrito $presrito): bool
    {
        return $user->can('preinscritos.delete');
    }

    /**
     * Determinar si el usuario puede restaurar un preinscrito eliminado
     */
    public function restore(User $user, Preinscrito $presrito): bool
    {
        return $user->can('preinscritos.restore');
    }

    /**
     * Determinar si el usuario puede eliminar permanentemente un preinscrito
     */
    public function forceDelete(User $user, Preinscrito $presrito): bool
    {
        return $user->can('preinscritos.force_delete');
    }
}
