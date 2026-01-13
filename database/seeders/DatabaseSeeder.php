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
            'view_permissions',
            'create_permissions',
            'update_permissions',
            'delete_permissions',

            // Permisos de roles
            'view_roles',
            'create_roles',
            'update_roles',
            'delete_roles',

            // Permisos de asignación de roles
            'assign_roles',

            // Permisos de centros
            'centros.view',
            'centros.create',
            'centros.update',
            'centros.delete',
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
        $instructor->givePermissionTo(['centros.view', 'centros.create', 'centros.update', 'centros.delete']);
        $user->givePermissionTo(['centros.view']);
        $aprendiz->givePermissionTo(['centros.view']);
    }
}
