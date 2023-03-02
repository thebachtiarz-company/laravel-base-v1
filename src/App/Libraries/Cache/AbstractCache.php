<?php

namespace TheBachtiarz\Base\App\Libraries\Cache;

abstract class AbstractCache implements CacheInterface
{
    //

    /**
     * {@inheritDoc}
     */
    abstract public function execute(): bool;
}
