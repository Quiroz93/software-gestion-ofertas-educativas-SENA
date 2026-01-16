<?php

namespace App\Policies;

use App\Models\Oferta;
use App\Models\User;

class OfertaPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Determinar si el usuario puede ver cualquier oferta.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasRole('admin') || $user->hasRole('instructor');
    }

     /**
      * Determinar si el usuario puede ver una oferta en particular.
      */
    public function view(User $user, Oferta $oferta): bool
    {
        return $user->hasRole('admin') || $user->hasRole('instructor');
    }

     /**
      * Determinar si el usuario puede crear una oferta.
      */
    public function create(User $user): bool
    {
        return $user->hasRole('admin');
    }

     /**
      * Determinar si el usuario puede actualizar una oferta.
      */
    public function update(User $user, Oferta $oferta): bool
    {
        return $user->hasRole('admin');
    }

     /**
      * Determinar si el usuario puede eliminar una oferta.
      */
    public function delete(User $user, Oferta $oferta): bool
    {
        return $user->hasRole('admin');
    }
}
