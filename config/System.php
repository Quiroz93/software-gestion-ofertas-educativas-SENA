<?php

/*
|--------------------------------------------------------------------------
| System Configuration
|--------------------------------------------------------------------------
*/

namespace App\Config;
return [
    'system.owner_key' => env('SYSTEM_OWNER_KEY'),
    'system.initialized' => env('SYSTEM_INITIALIZED', false),
];