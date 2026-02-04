<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Usuario administrador principal
        $admin = User::updateOrCreate(
            ['email' => 'admin@sena.edu.co'],
            [
                'name' => 'Administrador',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ]
        );
        $admin->assignRole('admin');

        // Usuario instructor
        $instructor = User::updateOrCreate(
            ['email' => 'instructor@sena.edu.co'],
            [
                'name' => 'Instructor Demo',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ]
        );
        $instructor->assignRole('instructor');

        // Usuario publicista
        $publicista = User::updateOrCreate(
            ['email' => 'publicista@sena.edu.co'],
            [
                'name' => 'Publicista Demo',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ]
        );
        $publicista->assignRole('publicista');

        // Usuario aprendiz
        $aprendiz = User::updateOrCreate(
            ['email' => 'aprendiz@sena.edu.co'],
            [
                'name' => 'Aprendiz Demo',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ]
        );
        $aprendiz->assignRole('aprendiz');

        $this->command->info('✓ 4 usuarios creados exitosamente.');
    }
}
