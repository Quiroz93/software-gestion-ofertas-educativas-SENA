<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        app(PermissionRegistrar::class)->forgetCachedPermissions();

        $permissions = [
            // Permisos de sistema
            'permissions.view',
            'permissions.create',
            'permissions.update',
            'permissions.delete',
            'permissions.edit',

            // Permisos de roles
            'roles.view',
            'roles.create',
            'roles.update',
            'roles.delete',
            'roles.edit',

            // Permisos de centros
            'centros.view',
            'centros.create',
            'centros.update',
            'centros.delete',
            'centros.edit',

            // Permisos de usuarios
            'users.view',
            'users.create',
            'users.update',
            'users.delete',
            'users.edit',
            'users.manage',

            // permisos acceso de dashboard
            'dashboard.view',

            // Permisos de asignación de roles a usuarios
            'users.assign.roles',

            // Permisos de noticias
            'noticias.view',
            'noticias.create',
            'noticias.update',
            'noticias.delete',
            'noticias.edit',

            // historias de exito
            'historias_exito.view',
            'historias_exito.create',
            'historias_exito.update',
            'historias_exito.delete',
            'historias_exito.edit',

            //instructores
            'instructores.view',
            'instructores.create',
            'instructores.update',
            'instructores.delete',
            'instructores.edit',

            //permisos nivel de formacion
            'nivel_formacion.view',
            'nivel_formacion.create',
            'nivel_formacion.update',
            'nivel_formacion.delete',
            'nivel_formacion.edit',

            //permisos ofertas
            'ofertas.view',
            'ofertas.create',
            'ofertas.update',
            'ofertas.delete',
            'ofertas.edit',

            //permisos de programas
            'programas.view',
            'programas.create',
            'programas.update',
            'programas.delete',
            'programas.edit',

            //permisos redes de conocimiento
            'redes_conocimiento.view',
            'redes_conocimiento.create',
            'redes_conocimiento.update',
            'redes_conocimiento.delete',
            'redes_conocimiento.edit',
        ];


        foreach ($permissions as $permission) {
            Permission::firstOrCreate([
                'name' => $permission,
                'guard_name' => 'web',
            ]);
        }

        $admin = Role::firstOrCreate([
            'name' => 'admin',
            'guard_name' => 'web',
        ]);

        $admin->givePermissionTo($permissions);

        $instructor = Role::firstOrCreate([
            'name' => 'instructor',
            'guard_name' => 'web',
        ]);

        $user = Role::firstOrCreate([
            'name' => 'user',
            'guard_name' => 'web',
        ]);

        $aprendiz = Role::firstOrCreate([
            'name' => 'aprendiz',
            'guard_name' => 'web',
        ]);

        // Asignar todos los permisos al admin
        $admin->givePermissionTo($permissions);

        // Permisos específicos por rol
        $instructor->givePermissionTo(['centros.view', 'centros.create', 'centros.update', 'centros.delete', 'centros.edit']);
        $user->givePermissionTo(['centros.view']);
        $aprendiz->givePermissionTo(['centros.view']);
    }
}
