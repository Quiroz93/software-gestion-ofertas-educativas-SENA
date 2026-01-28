<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        /*
        |--------------------------------------------------------------------------
        | Limpiar caché de permisos
        |--------------------------------------------------------------------------
        */
        app(PermissionRegistrar::class)->forgetCachedPermissions();

        /*
        |--------------------------------------------------------------------------
        | Definición centralizada de permisos del sistema
        |--------------------------------------------------------------------------
        | Convención:
        | modulo.accion
        |--------------------------------------------------------------------------
        */
        $permissions = [
            /*
            |--------------------------------------------------------------------------
            | Contenidos públicos
            |--------------------------------------------------------------------------
            */
            'public_content.edit',

            /*
            |--------------------------------------------------------------------------
            | Dashboard
            |--------------------------------------------------------------------------
            */
            'dashboard.view',
            'admin.view',

            /*
            |--------------------------------------------------------------------------
            | Usuarios
            |--------------------------------------------------------------------------
            */
            'users.view',
            'users.show',
            'users.create',
            'users.edit',
            'users.update',
            'users.delete',
            'users.manage',
            'users.assign.roles',

            /*
            |--------------------------------------------------------------------------
            | Roles
            |--------------------------------------------------------------------------
            */
            'roles.view',
            'roles.create',
            'roles.edit',
            'roles.update',
            'roles.delete',
            'roles.manage',

            /*
            |--------------------------------------------------------------------------
            | Permisos
            |--------------------------------------------------------------------------
            */
            'permissions.view',
            'permissions.create',
            'permissions.edit',
            'permissions.update',
            'permissions.delete',
            'permissions.manage',

            /*
            |--------------------------------------------------------------------------
            | Centros educativos
            |--------------------------------------------------------------------------
            */
            'centros.view',
            'centros.create',
            'centros.edit',
            'centros.update',
            'centros.delete',
            'centros.manage',

            /*
            |--------------------------------------------------------------------------
            | Competencias
            |--------------------------------------------------------------------------
            */
            'competencias.view',
            'competencias.create',
            'competencias.edit',
            'competencias.update',
            'competencias.delete',
            'competencias.manage',

            /*
            |--------------------------------------------------------------------------
            | Historias de éxito
            |--------------------------------------------------------------------------
            */
            'historias_exito.view',
            'historias_exito.create',
            'historias_exito.edit',
            'historias_exito.update',
            'historias_exito.delete',
            'historias_exito.manage',

            /*
            |--------------------------------------------------------------------------
            | Instructores
            |--------------------------------------------------------------------------
            */
            'instructores.view',
            'instructores.create',
            'instructores.edit',
            'instructores.update',
            'instructores.delete',
            'instructores.manage',

            /*
            |--------------------------------------------------------------------------
            | Niveles de formación
            |--------------------------------------------------------------------------
            */
            'niveles_formacion.view',
            'niveles_formacion.create',
            'niveles_formacion.edit',
            'niveles_formacion.update',
            'niveles_formacion.delete',
            'niveles_formacion.manage',

            /*
            |--------------------------------------------------------------------------
            | Ofertas educativas
            |--------------------------------------------------------------------------
            */
            'ofertas.view',
            'ofertas.create',
            'ofertas.edit',
            'ofertas.update',
            'ofertas.delete',
            'ofertas.manage',
            'ofertas.show',

            /*
            |--------------------------------------------------------------------------
            | Programas de formación
            |--------------------------------------------------------------------------
            */
            'programas.view',
            'programas.create',
            'programas.edit',
            'programas.update',
            'programas.delete',
            'programas.manage',

            /*
            |--------------------------------------------------------------------------
            | Noticias y artículos
            |--------------------------------------------------------------------------
            */
            'noticias.view',
            'noticias.create',
            'noticias.edit',
            'noticias.update',
            'noticias.delete',
            'noticias.manage',

            /*
            |--------------------------------------------------------------------------
            | Redes de conocimiento
            |--------------------------------------------------------------------------
            */
            'redes_conocimiento.view',
            'redes_conocimiento.create',
            'redes_conocimiento.edit',
            'redes_conocimiento.update',
            'redes_conocimiento.delete',
            'redes_conocimiento.manage',
        ];

        /*
        |--------------------------------------------------------------------------
        | Creación de permisos
        |--------------------------------------------------------------------------
        */
        foreach ($permissions as $permission) {
            Permission::firstOrCreate([
                'name'       => $permission,
                'guard_name' => 'web',
            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | Creación de roles del sistema
        |--------------------------------------------------------------------------
        */
        $publicista = Role::firstOrCreate(
            [
                'name' => 'publicista',
                'guard_name' => 'web'
            ]
        );

        $admin = Role::firstOrCreate([
            'name'       => 'admin',
            'guard_name' => 'web',
        ]);

        $instructor = Role::firstOrCreate([
            'name'       => 'instructor',
            'guard_name' => 'web',
        ]);

        $user = Role::firstOrCreate([
            'name'       => 'user',
            'guard_name' => 'web',
        ]);

        $aprendiz = Role::firstOrCreate([
            'name'       => 'aprendiz',
            'guard_name' => 'web',
        ]);

        /*
        |--------------------------------------------------------------------------
        | Asignación de permisos a roles
        |--------------------------------------------------------------------------
        */
        // 📢 Publicista: acceso público
        $publicista->syncPermissions([
            'public_content.edit',
        ]);

        // 🔐 Administrador: acceso total
        $admin->syncPermissions($permissions);

        // 👨‍🏫 Instructor: gestión académica parcial
        $instructor->syncPermissions([
            'dashboard.view',

            'centros.view',
            'competencias.view',
            'competencias.create',
            'competencias.edit',
            'competencias.update',

            'programas.view',
            'programas.create',
            'programas.edit',
            'programas.update',

            'ofertas.view',
            'ofertas.create',
            'ofertas.edit',
            'ofertas.update',

            'instructores.view',
        ]);

        // 👤 Usuario: acceso informativo
        $user->syncPermissions([
            'dashboard.view',
            'centros.view',
            'programas.view',
            'ofertas.view',
            'historias_exito.view',
            'redes_conocimiento.view',
            'ofertas.show',
        ]);

        // 🎓 Aprendiz: acceso público / académico
        $aprendiz->syncPermissions([
            'dashboard.view',

            'programas.view',
            'ofertas.view',
            'historias_exito.view',
        ]);
    }
}
