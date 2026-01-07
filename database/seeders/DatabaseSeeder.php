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
            'view_centros',
            'create_centros',
            'update_centros',
            'edit_centros',
            'delete_centros',
            'manage_users',
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

        $admin->givePermissionTo($permissions);

        $instructor->givePermissionTo(['view_centros']);
        $user->givePermissionTo(['view_centros']);
        $aprendiz->givePermissionTo(['view_centros']);
    }
}
