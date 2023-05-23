<?php

declare(strict_types=1);

namespace TheBachtiarz\Base\App\Libraries\Curl;

use TheBachtiarz\Base\App\Libraries\Curl\Data\CurlResponseInterface;

interface CurlInterface
{
    /**
     * Execute curl
     *
     * @param array $data
     */
    public function execute(array $data = []): CurlResponseInterface;
}
