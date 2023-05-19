<?php

namespace TheBachtiarz\Base;

use Illuminate\Support\ServiceProvider as LaravelServiceProvider;

class ServiceProvider extends LaravelServiceProvider
{
    //

    /**
     * {@inheritDoc}
     */
    public function register()
    {
        /** @var AppService $_appService */
        $_appService = $this->app->make(AppService::class);

        $_appService->registerConfig();

        if ($this->app->runningInConsole()) {
            $this->commands(AppService::COMMANDS);
        }
    }

    /**
     * Boot
     *
     * @return void
     */
    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $_configName = BaseConfigInterface::CONFIG_NAME;
            $_publishName = 'thebachtiarz-base';

            $this->publishes([__DIR__ . "/../config/$_configName.php" => config_path("$_configName.php")], "$_publishName-config");
            $this->publishes([__DIR__ . '/../database/migrations' => database_path('migrations')], "$_publishName-migrations");
        }
    }
}
