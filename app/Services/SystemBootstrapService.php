<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Artisan;

class SystemBootstrapService
{
    /**
     * Verifica si el sistema ya fue inicializado.
     * Fuente primaria: .env
     * Fuente secundaria (rescate): existencia de super_admin
     */
    public function systemIsInitialized(): bool
    {
        if (config('system.initialized')) {
            return true;
        }

        // Fallback defensivo (recuperación ante ataques)
        return User::role('admin')->exists();
    }

    /**
     * Determina si el usuario que se registra
     * cumple las condiciones para ser el owner real
     */
    public function isOwnerCandidate(array $data): bool
{
    if ($this->systemIsInitialized()) {
        return false;
    }

    $systemKey = config('system.owner_key');

    if (!is_string($systemKey) || $systemKey === '') {
        return false;
    }

    return isset($data['owner_key'])
        && is_string($data['owner_key'])
        && hash_equals($systemKey, $data['owner_key']);
}


    /**
     * Marca el sistema como inicializado
     */
    public function markSystemAsInitialized(): void
    {
        Artisan::call('env:set', [
            'key'   => 'SYSTEM_INITIALIZED',
            'value' => 'true',
        ]);
    }
}
