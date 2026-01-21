<?php

namespace App\Policies;

use App\Models\Competencia;
use App\Models\User;

class CompetenciaPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Determinar si el usuario puede ver las competencias.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasRole('admin') || $user->hasRole('instructor');
    }

    /**
     * Determinar si el usuario puede ver una competencia en particular.
     */
    public function view(User $user, Competencia $competencia): bool
    {
        return $user->hasRole('admin') || $user->hasRole('instructor');
    }

     /**
     * Determinar si el usuario puede crear competencias.
     */
    public function create(User $user): bool
    {
        return $user->hasRole('admin') || $user->hasRole('instructor');
    }

     /**
     * Determinar si el usuario puede actualizar una competencia.
     */
    public function update(User $user, Competencia $competencia): bool
    {
        return $user->hasRole('admin') || $user->hasRole('instructor');
    }

     /**
     * Determinar si el usuario puede eliminar una competencia.
     */
    public function delete(User $user, Competencia $competencia): bool
    {
        return $user->hasRole('admin');
    }
}
