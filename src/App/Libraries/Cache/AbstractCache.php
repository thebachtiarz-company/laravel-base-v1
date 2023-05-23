<?php

declare(strict_types=1);

namespace TheBachtiarz\Base\App\Libraries\Cache;

abstract class AbstractCache implements CacheInterface
{
    abstract public function execute(): bool;
}
