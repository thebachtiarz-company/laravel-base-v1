<?php

declare(strict_types=1);

namespace TheBachtiarz\Base;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider;
use Illuminate\Routing\RouteRegistrar;
use Illuminate\Support\Facades\Route;

use function assert;
use function is_string;
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
            assert(is_string($module));
            $this->routes(static fn (): RouteRegistrar => Route::prefix($prefix)->group(tbbaserestapipath($module)));
        }
    }
}
