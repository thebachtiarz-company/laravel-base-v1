<?php

declare(strict_types=1);

use TheBachtiarz\Base\BaseConfigInterface;

return [
    /*
    |--------------------------------------------------------------------------
    | Application Name
    |--------------------------------------------------------------------------
    |
    | Here your application name are stored.
    |
    */
    'app_name' => 'Local Project',

    /*
    |--------------------------------------------------------------------------
    | Application URL
    |--------------------------------------------------------------------------
    |
    | Here your application url are stored.
    |
    */
    'app_url' => '',

    /*
    |--------------------------------------------------------------------------
    | Application Timezone
    |--------------------------------------------------------------------------
    |
    | Here your application timezone are stored.
    | @see \DateTimeZone::listIdentifiers()
    |
    */
    'app_timezone' => 'UTC',

    /*
    |--------------------------------------------------------------------------
    | Application Key
    |--------------------------------------------------------------------------
    |
    | Here your application key are being stored.
    | Do generate based from laravel default.
    | Command 'artisan key:generate'.
    | And then paste here.
    |
    */
    'app_key' => '',

    /*
    |--------------------------------------------------------------------------
    | Application Prefix
    |--------------------------------------------------------------------------
    |
    | Here your application url subfolder prefix are stored.
    | Where you have library who requires this library.
    |
    | ex: {{domain}}/{{thebachtiarz}}/---
    |
    */
    'app_prefix' => 'thebachtiarz',

    /*
    |--------------------------------------------------------------------------
    | Cache System
    |--------------------------------------------------------------------------
    |
    | Here your can define cache system used in this application.
    |
    | ex: file | database
    |
    | Please use 'database' instead, for better experience.
    |
    */
    'cache_system' => 'file',

    /*
    |--------------------------------------------------------------------------
    | Logger Mode Available
    |--------------------------------------------------------------------------
    |
    | Here you can specify the mode to allow the system to write logs.
    |
    */
    'logger_mode' => ['local', 'developer', 'production'],

    /*
    |--------------------------------------------------------------------------
    | App Refresh Artisan Command Before
    |--------------------------------------------------------------------------
    |
    | This option will run artisan command when "artisan app:refresh" run.
    | Right after artisan down
    |
    */
    'app_refresh_artisan_commands_before' => [
        [
            'command' => 'cache:clear',
            'message' => '======> Application cache cleared!',
        ],
        [
            'command' => 'config:clear',
            'message' => '======> Configuration cache cleared!',
        ],
        [
            'command' => 'view:clear',
            'message' => '======> Compiled views cleared!',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | App Refresh Artisan Command After
    |--------------------------------------------------------------------------
    |
    | This option will run artisan command when "artisan app:refresh" run.
    | Right before artisan up
    |
    */
    'app_refresh_artisan_commands_after' => [
        [
            'command' => 'config:cache',
            'message' => '======> Configuration cached successfully!',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | App Refresh Cache Class
    |--------------------------------------------------------------------------
    |
    | This option will run cache service classes when "artisan thebachtiarz:base:app:refresh" run
    | make sure there is a method named "execute" inside the class
    | otherwise will return an error message.
    |
    | All class must "extends" following abstract class:
    | @see \TheBachtiarz\Base\App\Libraries\Cache\AbstractCache
    |
    */
    'app_refresh_cache_classes' => [],

    /*
    |--------------------------------------------------------------------------
    | Keep cache service
    |--------------------------------------------------------------------------
    |
    | This option keep cache(s) from reset.
    | Set cache name as key.
    |
    */
    'app_keep_cache_data' => [],

    /*
    |--------------------------------------------------------------------------
    | Config Registered
    |--------------------------------------------------------------------------
    |
    | Here all your config are registered.
    |
    */
    BaseConfigInterface::CONFIG_REGISTERED => [
        BaseConfigInterface::CONFIG_NAME,
    ],
];
