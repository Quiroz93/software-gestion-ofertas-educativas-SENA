<?php

/**
 * Script de Validación de Seguridad - SOE SENA
 * 
 * Verifica que los permisos y roles estén correctamente configurados
 * según la arquitectura de seguridad definida.
 * 
 * Uso: php artisan tinker < security-validation.php
 */

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

echo "🔐 INICIANDO VALIDACIÓN DE SEGURIDAD...\n\n";

// 1. Validar que dashboard.view NO está en rol 'user'
echo "1️⃣ Validando rol 'user':\n";
$roleUser = Role::where('name', 'user')->first();
if ($roleUser) {
    $hasDashboard = $roleUser->hasPermissionTo('dashboard.view');
    if ($hasDashboard) {
        echo "   ❌ CRÍTICO: rol 'user' TIENE permiso 'dashboard.view'\n";
    } else {
        echo "   ✅ CORRECTO: rol 'user' NO tiene permiso 'dashboard.view'\n";
    }
    
    echo "   Permisos del rol 'user':\n";
    foreach ($roleUser->permissions as $perm) {
        echo "      - {$perm->name}\n";
    }
} else {
    echo "   ❌ ERROR: rol 'user' no existe\n";
}

// 2. Validar que dashboard.view SÍ está en rol 'admin'
echo "\n2️⃣ Validando rol 'admin':\n";
$roleAdmin = Role::where('name', 'admin')->first();
if ($roleAdmin) {
    $hasDashboard = $roleAdmin->hasPermissionTo('dashboard.view');
    if ($hasDashboard) {
        echo "   ✅ CORRECTO: rol 'admin' TIENE permiso 'dashboard.view'\n";
    } else {
        echo "   ❌ CRÍTICO: rol 'admin' NO tiene permiso 'dashboard.view'\n";
    }
} else {
    echo "   ❌ ERROR: rol 'admin' no existe\n";
}

// 3. Validar que SuperAdmin existe y tiene dashboard.view
echo "\n3️⃣ Validando rol 'SuperAdmin':\n";
$roleSuperAdmin = Role::where('name', 'SuperAdmin')->first();
if ($roleSuperAdmin) {
    $hasDashboard = $roleSuperAdmin->hasPermissionTo('dashboard.view');
    echo "   ✅ EXISTE rol 'SuperAdmin'\n";
    if ($hasDashboard) {
        echo "   ✅ CORRECTO: 'SuperAdmin' TIENE permiso 'dashboard.view'\n";
    } else {
        echo "   ⚠️  AVISO: 'SuperAdmin' NO tiene permiso 'dashboard.view'\n";
    }
} else {
    echo "   ⚠️  AVISO: rol 'SuperAdmin' no existe (puede estar OK si no se usa)\n";
}

// 4. Validar que el usuario 'usuario publico' tiene rol 'user'
echo "\n4️⃣ Validando usuario 'usuario publico':\n";
$user = \App\Models\User::where('name', 'usuario publico')->first();
if ($user) {
    $roles = $user->roles->pluck('name')->toArray();
    echo "   ✅ Usuario existe\n";
    echo "   Roles asignados: " . implode(', ', $roles) . "\n";
    
    if (in_array('user', $roles)) {
        echo "   ✅ Tiene rol 'user'\n";
        if ($user->hasPermissionTo('dashboard.view')) {
            echo "   ❌ CRÍTICO: Puede acceder a 'dashboard.view'\n";
        } else {
            echo "   ✅ CORRECTO: No puede acceder a 'dashboard.view'\n";
        }
    } else {
        echo "   ⚠️  No tiene rol 'user'\n";
    }
} else {
    echo "   ⚠️  Usuario 'usuario publico' no existe\n";
}

// 5. Listar todos los roles y sus permisos count
echo "\n5️⃣ Resumen de roles:\n";
$roles = Role::all();
foreach ($roles as $role) {
    $permCount = $role->permissions()->count();
    echo "   - {$role->name}: {$permCount} permisos\n";
}

echo "\n✅ VALIDACIÓN COMPLETADA\n";
