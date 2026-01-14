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
            'edit_permissions',

            // Permisos de roles
            'view_roles',
            'create_roles',
            'update_roles',
            'delete_roles',
            'edit_roles',

            // Permisos de asignación de roles
            'assign_roles',

            // Permisos de centros
            'view_centros',
            'create_centros',
            'update_centros',
            'delete_centros',
            'edit_centros',

            // Permisos de usuarios
            'view_users',
            'create_users',
            'update_users',
            'delete_users',
            'edit_users',

            // Permisos de asignación de centros
            'assign_centros',

            // permisos acceso de dashboard
            'access_dashboard',
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
        $instructor->givePermissionTo(['view_centros', 'create_centros', 'update_centros', 'delete_centros', 'edit_centros', 'assign_centros']);
        $user->givePermissionTo(['view_centros']);
        $aprendiz->givePermissionTo(['view_centros']);
    }
}
