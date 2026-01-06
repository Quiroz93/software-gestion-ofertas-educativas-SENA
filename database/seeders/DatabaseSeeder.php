<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // Permisos
        $permissions = [
            'view.centros',
            'create.centros',
            'update.centros',
            'delete.centros',
            'manage.users',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Roles
        $admin = Role::firstOrCreate(['name' => 'admin']);
        $instructor = Role::firstOrCreate(['name' => 'instructor']);
        $user = Role::firstOrCreate(['name' => 'user']);
        $aprendiz = Role::firstOrCreate(['name' => 'aprendiz']);

        // Asignar permisos
        $admin->givePermissionTo(Permission::all());

        $instructor->givePermissionTo([
            'view.centros',
        ]);

        $user->givePermissionTo([
            'view.centros',
        ]);

        $aprendiz->givePermissionTo([
            'view.centros',
        ]);
    }
}
