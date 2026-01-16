<?php

namespace App\Policies;

use App\Models\OfertaPrograma;
use App\Models\User;

class Oferta_programaPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

     /**
      * Determinar si el usuario puede ver cualquier oferta de programa.
      */
    public function viewAny(User $user): bool
    {
        return $user->hasRole('admin') || $user->hasRole('instructor');
    }

     /**
      * Determinar si el usuario puede ver una oferta de programa en particular.
      */
    public function view(User $user, OfertaPrograma $oferta_programa): bool
    {
        return $user->hasRole('admin') || $user->hasRole('instructor');
    }

     /**
      * Determinar si el usuario puede crear una oferta de programa.
      */
    public function create(User $user): bool
    {
        return $user->hasRole('admin');
    }

     /**
      * Determinar si el usuario puede actualizar una oferta de programa.
      */
    public function update(User $user, OfertaPrograma $oferta_programa): bool
    {
        return $user->hasRole('admin');
    }

     /**
      * Determinar si el usuario puede eliminar una oferta de programa.
      */
    public function delete(User $user, OfertaPrograma $oferta_programa): bool
    {
        return $user->hasRole('admin');
    }
}
