<?php

namespace App\Policies;

use App\Models\nivel_formacion;
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
    public function viewAny(User $user, nivel_formacion $nivel_formacion): bool
    {
        return $user->hasRole('admin') || $user->hasRole('instructor');
    }

    /**
     * Determinar si el usuario puede ver un nivel de formación en particular.
     */
    public function view(User $user, nivel_formacion $nivel_formacion): bool
    {
        return $user->hasRole('admin') || $user->hasRole('instructor');
    }

     /**
     * Determinar si el usuario puede crear un nivel de formación.
     */
    public function create(User $user, nivel_formacion $nivel_formacion): bool
    {
        return $user->hasRole('admin');
    }

    /**
     * Determinar si el usuario puede actualizar un nivel de formación.
     */
    public function update(User $user, nivel_formacion $nivel_formacion): bool
    {
        return $user->hasRole('admin');
    }

     /**
     * Determinar si el usuario puede eliminar un nivel de formación.
     */
    public function delete(User $user, nivel_formacion $nivel_formacion): bool
    {
        return $user->hasRole('admin');
    }
}
