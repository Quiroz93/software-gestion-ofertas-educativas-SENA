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

        if (!isset($data['owner_key']) || !is_string($data['owner_key']) || $data['owner_key'] === '') {
            return false;
        }

        $submittedKey = $data['owner_key'];

        // Prefer stored hashed key in DB if available
        $storedHash = SystemSetting::get('owner_key_hash');
        if (is_string($storedHash) && $storedHash !== '') {
            return password_verify($submittedKey, $storedHash);
        }

        // Fallback to .env value — preserve backwards compatibility.
        $systemKey = config('System.owner_key');
        if (!is_string($systemKey) || $systemKey === '') {
            return false;
        }

        // Constant-time compare against plaintext env value.
        if (hash_equals($systemKey, $submittedKey)) {
            // Migrate to hashed storage for future checks.
            $hash = password_hash($submittedKey, PASSWORD_DEFAULT);
            if ($hash !== false) {
                SystemSetting::set('owner_key_hash', $hash);
            }
            return true;
        }

        return false;
    }


    /**
     * Marca el sistema como inicializado
     */
    public function markSystemAsInitialized(): void
    {
        SystemSetting::set('system_initialized', 'true');
    }
}
