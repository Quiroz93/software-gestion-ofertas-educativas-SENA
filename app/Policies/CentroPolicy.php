<?php

namespace App\Policies;

use App\Models\Centro;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class CentroPolicy
{
    /**
     * Determina si el usuario puede ver cualquier modelo.
     */
    public function viewAny(User $user): bool
    {
        return false;
    }

    /**
     * Determina si el usuario puede ver el modelo.
     */
    public function view(User $user, Centro $centro): bool
    {
        return false;
    }

    /**
     * Determina si el usuario puede crear modelos.
     */
    public function create(User $user): bool
    {
        return false;
    }

    /**
     * Determina si el usuario puede actualizar el modelo.
     */
    public function update(User $user, Centro $centro): bool
    {
        return false;
    }

    /**
     * Determina si el usuario puede eliminar el modelo.
     */
    public function delete(User $user, Centro $centro): bool
    {
        return false;
    }

    /**
     * Determina si el usuario puede restaurar el modelo.
     */
    public function restore(User $user, Centro $centro): bool
    {
        return false;
    }

    /**
     * Determina si el usuario puede eliminar permanentemente el modelo.
     */
    public function forceDelete(User $user, Centro $centro): bool
    {
        return false;
    }
}
