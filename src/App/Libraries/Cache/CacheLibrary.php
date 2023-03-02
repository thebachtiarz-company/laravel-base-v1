<?php

namespace TheBachtiarz\Base\App\Libraries\Cache;

use Illuminate\Container\Container;
use TheBachtiarz\Base\App\Libraries\Log\LogLibrary;

class CacheLibrary
{
    //

    // ? Public Methods
    /**
     * Create application cache modules
     *
     * @return boolean
     */
    public function createCaches(): bool
    {
        $result = false;

        try {
            $moduleCaches = tbbaseconfig('app_refresh_cache_classes');

            foreach ($moduleCaches ?? [] as $key => $module) {
                if (new $module instanceof CacheInterface) {
                    /** @var CacheInterface $cacheClass */
                    $cacheClass = Container::getInstance()->make($module);
                    $cacheClass->execute();
                }
            }

            $result = true;
        } catch (\Throwable $th) {
            $this->logInstance()->log($th);
        }

        return $result;
    }

    // ? Protected Methods
    /**
     * Get log instance
     *
     * @return LogLibrary
     */
    protected function logInstance(): LogLibrary
    {
        $container = Container::getInstance();

        return $container->make(LogLibrary::class);
    }

    // ? Private Methods

    // ? Getter Modules

    // ? Setter Modules
}
