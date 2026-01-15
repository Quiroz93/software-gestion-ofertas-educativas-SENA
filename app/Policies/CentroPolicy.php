<?php

namespace App\Policies;

use App\Models\Centro;
use App\Models\User;

class CentroPolicy
{
    /**
     * Ver listado de centros
     */
    public function viewAny(User $user): bool
    {
        return $user->can('centros.view');
    }

    /**
     * Ver un centro específico
     */
    public function view(User $user, Centro $centro): bool
    {
        return $user->can('centros.view');
    }

    /**
     * Crear centros
     */
    public function create(User $user): bool
    {
        return $user->can('centros.create');
    }

    /**
     * Actualizar centros
     */
    public function update(User $user, Centro $centro): bool
    {
        return $user->can('centros.update');
    }

    /**
     * Eliminar centros
     */
    public function delete(User $user, Centro $centro): bool
    {
        return $user->can('centros.delete');
    }
}
