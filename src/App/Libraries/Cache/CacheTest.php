<?php

declare(strict_types=1);

namespace TheBachtiarz\Base\App\Libraries\Cache;

use Illuminate\Support\Facades\Log;

class CacheTest extends AbstractCache implements CacheInterface
{
    public function execute(): bool
    {
        Log::channel('maintenance')->debug('CACHE OK');

        return true;
    }
}
