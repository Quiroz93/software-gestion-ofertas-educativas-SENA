<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Artisan;
use App\Models\SystemSetting;

class SystemBootstrapService
{
    /**
     * Verifica si el sistema ya fue inicializado.
     * Fuente primaria: .env
     * Fuente secundaria (rescate): existencia de super_admin
     */
    public function systemIsInitialized(): bool
    {
        return SystemSetting::get('system_initialized', 'false') === 'true';
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

        $systemKey = config('System.owner_key');

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
        SystemSetting::set('system_initialized', 'true');
    }
}
