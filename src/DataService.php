<?php

namespace TheBachtiarz\Base;

use TheBachtiarz\Base\Config\Services\ConfigService;

class DataService
{
    //

    /**
     * Constructor
     *
     * @param ConfigService $configService
     */
    public function __construct(
        protected ConfigService $configService
    ) {
        $this->configService = $configService;
    }

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
            'app.name' => $this->configService->getConfigValue(BaseConfigInterface::CONFIG_NAME . '.' . AppConfigInterface::CONFIG_APP_NAME),
            'app.url' => $this->configService->getConfigValue(BaseConfigInterface::CONFIG_NAME . '.' . AppConfigInterface::CONFIG_APP_URL),
            'app.timezone' => $this->configService->getConfigValue(BaseConfigInterface::CONFIG_NAME . '.' . AppConfigInterface::CONFIG_APP_TIMEZONE),
            'app.key' => $this->configService->getConfigValue(BaseConfigInterface::CONFIG_NAME . '.' . AppConfigInterface::CONFIG_APP_KEY)
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
        $registerConfig[] = [
            'cache.default' => 'database'
        ];

        // ! Cors paths
        $_paths = config('cors.paths');
        $registerConfig[] = [
            'cors.paths' => array_merge(
                $_paths,
                [$this->configService->getConfigValue(BaseConfigInterface::CONFIG_NAME . '.' . AppConfigInterface::CONFIG_APP_PREFIX) . '/*']
            )
        ];

        // ! Logging
        $logging = config('logging.channels');
        $registerConfig[] = [
            'logging.channels' => array_merge(
                $logging,
                [
                    'application' => [
                        'driver' => 'single',
                        'path' => tbdirlocation("log/application.log")
                    ],
                    'curl' => [
                        'driver' => 'single',
                        'path' => tbdirlocation("log/curl.log")
                    ],
                    'developer' => [
                        'driver' => 'single',
                        'path' => tbdirlocation("log/developer.log")
                    ],
                    'production' => [
                        'driver' => 'single',
                        'path' => tbdirlocation("log/production.log")
                    ],
                    'error' => [
                        'driver' => 'single',
                        'level' => 'debug',
                        'path' => tbdirlocation("log/error.log")
                    ],
                    'maintenance' => [
                        'driver' => 'single',
                        'path' => tbdirlocation("log/maintenance.log")
                    ]
                ]
            )
        ];

        return $registerConfig;
    }
}
