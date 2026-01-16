<?php

namespace App\Policies;

use App\Models\Centro;
use App\Models\User;

class CentroPolicy
{
    /**
     * Determinar si el usuario puede ver listado de centros
     */
    public function viewAny(User $user): bool
    {
        return $user->can('centros.view');
    }

    /**
     * Determinar si el usuario puede ver un centro específico
     */
    public function view(User $user, Centro $centro): bool
    {
        return $user->can('centros.view');
    }

    /**
     * Determinar si el usuario puede crear centros
     */
    public function create(User $user): bool
    {
        return $user->can('centros.create');
    }

    /**
     * Determinar si el usuario puede actualizar centros
     */
    public function update(User $user, Centro $centro): bool
    {
        return $user->can('centros.update');
    }

    /**
     * Determinar si el usuario puede eliminar centros
     */
    public function delete(User $user, Centro $centro): bool
    {
        return $user->can('centros.delete');
    }
}
