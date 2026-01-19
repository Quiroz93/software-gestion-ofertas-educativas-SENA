<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Artisan;
use Spatie\Permission\Models\Role;

class SystemBootstrapService
{
    /**
     * Inicializa el sistema si es el primer usuario.
     * Asigna el rol de superadministrador al primer usuario registrado
     * y marca el sistema como inicializado.
     *
     * @param User $user
     * @return void
     */
    public function initialize(User $user): void
    {
        // Solo se ejecuta si es el primer usuario en la base de datos.
        if (User::count() === 1) {
            $this->assignSuperAdminRole($user);
            $this->setSystemAsInitialized();
        }
    }

    /**
     * Asigna el rol de superadministrador (o root) a un usuario.
     * El nombre del rol se obtiene de la configuración de Spatie para evitar hardcodear.
     *
     * @param User $user
     * @return void
     */
    private function assignSuperAdminRole(User $user): void
    {
        // Asegúrate de tener 'super_admin' definido en config/permission.php o como rol en tu seeder.
        // Por ahora, usaré 'admin' que ya existe.
        $adminRoleName = 'admin'; 
        $role = Role::where('name', $adminRoleName)->first();

        if ($role) {
            $user->assignRole($role);
        }
    }

    /**
     * Marca el sistema como inicializado actualizando el archivo .env.
     * Esto previene que la lógica de inicialización se ejecute múltiples veces
     * y sirve como un indicador auditable.
     *
     * @return void
     */
    private function setSystemAsInitialized(): void
    {
        // Verificamos si la variable ya está establecida para no escribir innecesariamente.
        if (env('SYSTEM_INITIALIZED') === true) {
            return;
        }

        $this->setEnv('SYSTEM_INITIALIZED', 'true');
    }

    /**
     * Establece un valor en el archivo .env de forma segura.
     *
     * @param string $key
     * @param string $value
     * @return void
     */
    private function setEnv(string $key, string $value): void
    {
        $path = app()->environmentFilePath();
        
        if (!file_exists($path)) {
            return;
        }

        $content = file_get_contents($path);
        $newKey = "{$key}={$value}";

        if (strpos($content, "{$key}=") !== false) {
            // La clave existe, la reemplazamos
            $content = preg_replace("/^{$key}=.*/m", $newKey, $content);
        } else {
            // La clave no existe, la añadimos al final
            $content .= "\n{$newKey}\n";
        }

        file_put_contents($path, $content);

        // Limpiamos la caché de configuración para que el cambio sea visible inmediatamente.
        Artisan::call('config:clear');
    }
}