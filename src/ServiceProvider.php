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
        $_appService = $this->app->make(AppService::class);
        assert($_appService instanceof AppService);

        $_appService->registerConfig();

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

        $_configName  = BaseConfigInterface::CONFIG_NAME;
        $_publishName = 'thebachtiarz-base';

        $this->publishes([__DIR__ . "/../config/$_configName.php" => config_path("$_configName.php")], "$_publishName-config");
        $this->publishes([__DIR__ . '/../database/migrations' => database_path('migrations')], "$_publishName-migrations");
    }
}
