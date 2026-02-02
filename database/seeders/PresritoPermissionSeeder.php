<?php

namespace Database\Seeders;

use Spatie\Permission\Models\Permission;
use Illuminate\Database\Seeder;

/**
 * Seeder para permisos de Preinscritos
 * Crea los permisos necesarios para el módulo de gestión de preinscritos
 */
class PresritoPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Permisos específicos para preinscritos
        $permissions = [
            'preinscritos.view',
            'preinscritos.create',
            'preinscritos.edit',
            'preinscritos.update',
            'preinscritos.delete',
            'preinscritos.restore',
            'preinscritos.force_delete',
            'preinscritos.manage',
            'preinscritos.admin',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate([
                'name' => $permission,
                'guard_name' => 'web',
            ]);
        }

        $this->command->info('Permisos de Preinscritos creados exitosamente.');
    }
}
