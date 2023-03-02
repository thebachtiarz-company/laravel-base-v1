<?php

namespace TheBachtiarz\Base\App\Libraries\Curl;

use TheBachtiarz\Base\App\Libraries\Curl\Data\CurlResponseInterface;

interface CurlInterface
{
    //

    /**
     * Execute curl
     *
     * @param array $data
     * @return CurlResponseInterface
     */
    public function execute(array $data = []): CurlResponseInterface;
}
