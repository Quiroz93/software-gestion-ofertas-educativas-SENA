<?php

namespace App\Policies;

use App\Models\ProgramaCompetencia;
use App\Models\User;

class Programas_competenciasPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

     /**
      * Determinar si el usuario puede ver cualquier programa de competencia.
      */
    public function viewAny(User $user): bool
    {
        return $user->hasRole('admin') || $user->hasRole('instructor');
    }

     /**
      * Determinar si el usuario puede ver un programa de competencia en particular.
      */
    public function view(User $user, ProgramaCompetencia $programas_competencia): bool
    {
        return $user->hasRole('admin') || $user->hasRole('instructor');
    }

     /**
      * Determinar si el usuario puede crear un programa de competencia.
      */
    public function create(User $user): bool
    {
        return $user->hasRole('admin');
    }

     /**
      * Determinar si el usuario puede actualizar un programa de competencia.
      */
    public function update(User $user, ProgramaCompetencia $programas_competencia): bool
    {
        return $user->hasRole('admin');
    }

     /**
      * Determinar si el usuario puede eliminar un programa de competencia.
      */
    public function delete(User $user, ProgramaCompetencia $programas_competencia): bool
    {
        return $user->hasRole('admin');
    }
}
