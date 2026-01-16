<?php

namespace App\Policies;

use App\Models\NivelFormacion;
use App\Models\User;

class Nivel_formacionPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

     /**
     * Determinar si el usuario puede ver cualquier nivel de formación.
     */
    public function viewAny(User $user, NivelFormacion $nivel_formacion): bool
    {
        return $user->hasRole('admin') || $user->hasRole('instructor');
    }

    /**
     * Determinar si el usuario puede ver un nivel de formación en particular.
     */
    public function view(User $user, NivelFormacion $nivel_formacion): bool
    {
        return $user->hasRole('admin') || $user->hasRole('instructor');
    }

     /**
     * Determinar si el usuario puede crear un nivel de formación.
     */
    public function create(User $user, NivelFormacion $nivel_formacion): bool
    {
        return $user->hasRole('admin');
    }

    /**
     * Determinar si el usuario puede actualizar un nivel de formación.
     */
    public function update(User $user, NivelFormacion $nivel_formacion): bool
    {
        return $user->hasRole('admin');
    }

     /**
     * Determinar si el usuario puede eliminar un nivel de formación.
     */
    public function delete(User $user, NivelFormacion $nivel_formacion): bool
    {
        return $user->hasRole('admin');
    }
}
