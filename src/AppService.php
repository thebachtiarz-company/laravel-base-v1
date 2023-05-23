<?php

declare(strict_types=1);

namespace TheBachtiarz\Base;

use TheBachtiarz\Base\App\Console\Commands\AppRefreshCommand;
use TheBachtiarz\Base\App\Console\Commands\BackupLogCommand;
use TheBachtiarz\Base\Config\Console\Commands\ConfigSynchronizeCommand;

use function app;
use function assert;
use function config;
use function is_dir;
use function mkdir;
use function tbdirlocation;

class AppService
{
    /**
     * Constructor
     */
    public function __construct()
    {
    }

    /**
     * Available command modules
     */
    public const COMMANDS = [
        AppRefreshCommand::class,
        BackupLogCommand::class,
        ConfigSynchronizeCommand::class,
    ];

    // ? Public Methods

    /**
     * Register config
     */
    public function registerConfig(): void
    {
        $this->createDirectories();
        $this->setConfigs();
    }

    // ? Private Methods

    /**
     * Set configs
     */
    private function setConfigs(): void
    {
        $dataService = app()->make(DataService::class);
        assert($dataService instanceof DataService);

        foreach ($dataService->registerConfig() as $key => $register) {
            config($register);
        }
    }

    /**
     * Create directories
     */
    private function createDirectories(): void
    {
        if (! is_dir(tbdirlocation())) {
            mkdir(tbdirlocation(), 0755);
        }

        if (! is_dir(tbdirlocation('backup/log'))) {
            mkdir(tbdirlocation('backup/log'), 0755, true);
        }

        if (is_dir(tbdirlocation('backup/database'))) {
            return;
        }

        mkdir(tbdirlocation('backup/database'), 0755, true);
    }

    // ? Setter Modules
}
