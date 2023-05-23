<?php

declare(strict_types=1);

namespace TheBachtiarz\Base;

use function array_merge;
use function config;
use function tbbaseconfig;
use function tbdirlocation;

class DataService
{
    /**
     * List of config who need to registered into current project
     *
     * @return array
     */
    public function registerConfig(): array
    {
        $registerConfig = [];

        // ! App
        $registerConfig[] = [
            'app.name' => tbbaseconfig(AppConfigInterface::CONFIG_APP_NAME, false),
            'app.url' => tbbaseconfig(AppConfigInterface::CONFIG_APP_URL, false),
            'app.timezone' => tbbaseconfig(AppConfigInterface::CONFIG_APP_TIMEZONE, false),
            'app.key' => tbbaseconfig(AppConfigInterface::CONFIG_APP_KEY),
        ];
        // $_providers = config('app.providers');
        // $registerConfig[] = [
        //     'app.providers' => array_merge(
        //         $_providers,
        //         [
        //             \TheBachtiarz\Toolkit\Backend\RouteServiceProvider::class
        //         ]
        //     )
        // ];

        // ! Cache
        $registerConfig[] = ['cache.default' => 'database'];

        // ! Cors paths
        $_paths           = config('cors.paths');
        $registerConfig[] = [
            'cors.paths' => array_merge(
                $_paths,
                [tbbaseconfig(AppConfigInterface::CONFIG_APP_PREFIX, false) . '/*'],
            ),
        ];

        // ! Logging
        $logging          = config('logging.channels');
        $registerConfig[] = [
            'logging.channels' => array_merge(
                $logging,
                [
                    'application' => [
                        'driver' => 'single',
                        'path' => tbdirlocation('log/application.log'),
                    ],
                    'curl' => [
                        'driver' => 'single',
                        'path' => tbdirlocation('log/curl.log'),
                    ],
                    'developer' => [
                        'driver' => 'single',
                        'path' => tbdirlocation('log/developer.log'),
                    ],
                    'production' => [
                        'driver' => 'single',
                        'path' => tbdirlocation('log/production.log'),
                    ],
                    'error' => [
                        'driver' => 'single',
                        'level' => 'debug',
                        'path' => tbdirlocation('log/error.log'),
                    ],
                    'maintenance' => [
                        'driver' => 'single',
                        'path' => tbdirlocation('log/maintenance.log'),
                    ],
                ],
            ),
        ];

        return $registerConfig;
    }
}
