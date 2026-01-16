<?php

namespace App\Policies;

use App\Models\Red;
use App\Models\User;

class RedesPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

     /**
      * Determinar si el usuario puede ver cualquier red.
      */
    public function viewAny(User $user): bool
    {
        return $user->hasRole('admin') || $user->hasRole('instructor');
    }

     /**
      * Determinar si el usuario puede ver una red en particular.
      */
    public function view(User $user, Red $red): bool
    {
        return $user->hasRole('admin') || $user->hasRole('instructor');
    }

     /**
      * Determinar si el usuario puede crear una red.
      */
    public function create(User $user): bool
    {
        return $user->hasRole('admin');
    }

     /**
      * Determinar si el usuario puede actualizar una red.
      */
    public function update(User $user, Red $red): bool
    {
        return $user->hasRole('admin');
    }

     /**
      * Determinar si el usuario puede eliminar una red.
      */
    public function delete(User $user, Red $red): bool
    {
        return $user->hasRole('admin');
    }
}
