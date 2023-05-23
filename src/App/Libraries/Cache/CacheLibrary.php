<?php

declare(strict_types=1);

namespace TheBachtiarz\Base\App\Libraries\Cache;

use TheBachtiarz\Base\App\Libraries\Log\LogLibrary;
use Throwable;

use function app;
use function assert;
use function tbbaseconfig;

class CacheLibrary
{
    // ? Public Methods

    /**
     * Create application cache modules
     */
    public function createCaches(): bool
    {
        $result = false;

        try {
            $moduleCaches = tbbaseconfig('app_refresh_cache_classes');

            foreach ($moduleCaches ?? [] as $key => $module) {
                if (! (new $module() instanceof CacheInterface)) {
                    continue;
                }

                $cacheClass = app()->make($module);
                assert($cacheClass instanceof CacheInterface);
                $cacheClass->execute();
            }

            $result = true;
        } catch (Throwable $th) {
            $this->logInstance()->log($th);
        }

        return $result;
    }

    // ? Protected Methods

    /**
     * Get log instance
     */
    protected function logInstance(): LogLibrary
    {
        return app()->make(LogLibrary::class);
    }

    // ? Private Methods

    // ? Getter Modules

    // ? Setter Modules
}
