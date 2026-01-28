<?php

namespace App\Policies;

use App\Models\Noticia;
use App\Models\User;

class NoticiasPolicy
{
    /**
     * Determinar si el usuario puede ver cualquier noticia.
     * 
     * @param User $user
     * @return bool
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('noticias.view');
    }

    /**
     * Determinar si el usuario puede ver una noticia en particular.
     * 
     * @param User $user
     * @param Noticia $noticia
     * @return bool
     */
    public function view(User $user, Noticia $noticia): bool
    {
        return $user->hasPermissionTo('noticias.view');
    }

    /**
     * Determinar si el usuario puede crear una noticia.
     * 
     * @param User $user
     * @return bool
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('noticias.create');
    }

    /**
     * Determinar si el usuario puede actualizar una noticia.
     * 
     * @param User $user
     * @param Noticia $noticia
     * @return bool
     */
    public function update(User $user, Noticia $noticia): bool
    {
        return $user->hasPermissionTo('noticias.update');
    }

    /**
     * Determinar si el usuario puede eliminar una noticia.
     * 
     * @param User $user
     * @param Noticia $noticia
     * @return bool
     */
    public function delete(User $user, Noticia $noticia): bool
    {
        return $user->hasPermissionTo('noticias.delete');
    }

    /**
     * Determinar si el usuario puede gestionar noticias.
     * 
     * @param User $user
     * @return bool
     */
    public function manage(User $user): bool
    {
        return $user->hasPermissionTo('noticias.manage');
    }
}
