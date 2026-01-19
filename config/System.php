<?php

/*
|--------------------------------------------------------------------------
| System Configuration
|--------------------------------------------------------------------------
*/

namespace App\Config;
return [
    'owner_email' => env('SYSTEM_OWNER_EMAIL'),
    'initialized' => env('SYSTEM_INITIALIZED', false),
];