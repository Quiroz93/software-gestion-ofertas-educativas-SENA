<?php

namespace App\Policies;

use App\Models\Programa;
use App\Models\User;

class ProgramaPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

     /**
      * Determinar si el usuario puede ver cualquier programa.
      */
    public function viewAny(User $user): bool
    {
        return $user->hasRole('admin') || $user->hasRole('instructor');
    }

     /**
      * Determinar si el usuario puede ver un programa en particular.
      */
    public function view(User $user, Programa $programa): bool
    {
        return $user->hasRole('admin') || $user->hasRole('instructor');
    }

     /**
      * Determinar si el usuario puede crear un programa.
      */
    public function create(User $user): bool
    {
        return $user->hasRole('admin');
    }

     /**
      * Determinar si el usuario puede actualizar un programa.
      */
    public function update(User $user, Programa $programa): bool
    {
        return $user->hasRole('admin');
    }

     /**
      * Determinar si el usuario puede eliminar un programa.
      */
    public function delete(User $user, Programa $programa): bool
    {
        return $user->hasRole('admin');
    }
}
