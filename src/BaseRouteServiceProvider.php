<?php

declare(strict_types=1);

namespace TheBachtiarz\Base;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Route;

use function tbbaseconfig;
use function tbbaserestapipath;

class BaseRouteServiceProvider extends RouteServiceProvider
{
    /**
     * Define your route model bindings, pattern filters, and other route configuration.
     */
    public function boot(): void
    {
        $modules = [
            'base',
            'config',
        ];

        $prefix = tbbaseconfig(keyName: AppConfigInterface::CONFIG_APP_PREFIX, useOrigin: false);

        foreach ($modules as $key => $module) {
            Route::prefix($prefix)->group(tbbaserestapipath($module));
        }
    }
}
