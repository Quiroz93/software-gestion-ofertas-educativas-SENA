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
        return $user->can('view_centros');
    }

    /**
     * Ver un centro específico
     */
    public function view(User $user, Centro $centro): bool
    {
        return $user->can('view_centros');
    }

    /**
     * Crear centros
     */
    public function create(User $user): bool
    {
        return $user->can('create_centros');
    }

    /**
     * Actualizar centros
     */
    public function update(User $user, Centro $centro): bool
    {
        return $user->can('update_centros');
    }

    /**
     * Eliminar centros
     */
    public function delete(User $user, Centro $centro): bool
    {
        return $user->can('delete_centros');
    }
}
