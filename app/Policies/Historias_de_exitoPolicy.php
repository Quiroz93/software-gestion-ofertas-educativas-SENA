<?php

namespace App\Policies;

use App\Models\HistoriaExito;
use App\Models\User;

class Historias_de_exitoPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Determinar si el usuario puede ver las historias de éxito.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('historias_exito.view');
    }

    /**
     * Determinar si el usuario puede ver una historia de éxito en particular.
     */
    public function view(User $user, HistoriaExito $historia_exito): bool
    {
        return $user->hasPermissionTo('historias_exito.view');
    }

    /**
     * Determinar si el usuario puede crear historias de éxito.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('historias_exito.create');
    }

    /**
     * Determinar si el usuario puede actualizar una historia de éxito.
     */
    public function update(User $user, HistoriaExito $historia_exito): bool
    {
        return $user->hasPermissionTo('historias_exito.update');
    }

    /**
     * Determinar si el usuario puede eliminar una historia de éxito.
     */
    public function delete(User $user, HistoriaExito $historia_exito): bool
    {
        return $user->hasPermissionTo('historias_exito.delete');
    }

    /**
     * Determinar si el usuario puede gestionar historias de éxito.
     */
    public function manage(User $user): bool
    {
        return $user->hasPermissionTo('historias_exito.manage');
    }
}

