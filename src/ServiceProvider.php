<?php

declare(strict_types=1);

namespace TheBachtiarz\Base;

use Illuminate\Support\ServiceProvider as LaravelServiceProvider;

use function assert;
use function config_path;
use function database_path;

class ServiceProvider extends LaravelServiceProvider
{
    /**
     * {@inheritDoc}
     */
    public function register()
    {
        $appService = $this->app->make(AppService::class);
        assert($appService instanceof AppService);

        $appService->registerConfig();

        if (! $this->app->runningInConsole()) {
            return;
        }

        $this->commands(AppService::COMMANDS);
    }

    /**
     * Boot
     */
    public function boot(): void
    {
        if (! $this->app->runningInConsole()) {
            return;
        }

        $configName  = BaseConfigInterface::CONFIG_NAME;
        $publishName = 'thebachtiarz-base';

        $this->publishes([__DIR__ . "/../config/$configName.php" => config_path("$configName.php")], "$publishName-config");
        $this->publishes([__DIR__ . '/../database/migrations' => database_path('migrations')], "$publishName-migrations");
    }
}
