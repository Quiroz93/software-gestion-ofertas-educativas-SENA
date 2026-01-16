<?php

namespace App\Policies;

use App\Models\Instructor;
use App\Models\User;

class InstructoresPolicy
{
     /**
     * Determinar si el usuario puede ver una red de instructor en particular.
     */
    public function view(User $user, Instructor $instructor): bool
    {
        return $user->hasRole('admin') || $user->hasRole('instructor');
    }

     /**
     * Determinar si el usuario puede ver todas las redes de instructor.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasRole('admin') || $user->hasRole('instructor');
    }

     /**
     * Determinar si el usuario puede crear una red de instructor.
     */
    public function create(User $user): bool
    {
        return $user->hasRole('admin') || $user->hasRole('instructor');
    }

     /**
     * Determinar si el usuario puede actualizar una red de instructor.
     */
    public function update(User $user, Instructor $instructor): bool
    {
        return $user->hasRole('admin') || $user->hasRole('instructor');
    }

     /**
     * Determinar si el usuario puede eliminar una red de instructor.
     */
    public function delete(User $user, Instructor $instructor): bool
    {
        return $user->hasRole('admin');
    }
}
