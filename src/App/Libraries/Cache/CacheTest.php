<?php

namespace TheBachtiarz\Base\App\Libraries\Cache;

class CacheTest extends AbstractCache implements CacheInterface
{
    //

    /**
     * {@inheritDoc}
     */
    public function execute(): bool
    {
        \Illuminate\Support\Facades\Log::channel('maintenance')->debug('CACHE OK');

        return true;
    }
}
