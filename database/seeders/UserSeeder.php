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
        $admin = User::create([
            'name' => 'Administrador',
            'email' => 'admin@sena.edu.co',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);
        $admin->assignRole('admin');

        // Usuario instructor
        $instructor = User::create([
            'name' => 'Instructor Demo',
            'email' => 'instructor@sena.edu.co',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);
        $instructor->assignRole('instructor');

        // Usuario publicista
        $publicista = User::create([
            'name' => 'Publicista Demo',
            'email' => 'publicista@sena.edu.co',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);
        $publicista->assignRole('publicista');

        // Usuario aprendiz
        $aprendiz = User::create([
            'name' => 'Aprendiz Demo',
            'email' => 'aprendiz@sena.edu.co',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);
        $aprendiz->assignRole('aprendiz');

        $this->command->info('✓ 4 usuarios creados exitosamente.');
    }
}
