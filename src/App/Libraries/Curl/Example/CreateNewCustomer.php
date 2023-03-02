<?php

namespace TheBachtiarz\Base\App\Libraries\Curl\Example;

use TheBachtiarz\Base\App\Libraries\Curl\CurlInterface;
use TheBachtiarz\Base\App\Libraries\Curl\Data\CurlResponseInterface;

class CreateNewCustomer extends AbstractCurl implements CurlInterface
{
    //

    /**
     * Create new customer
     *
     * @param array $data
     * @return CurlResponseInterface
     */
    public function execute(array $data = []): CurlResponseInterface
    {
        return $this->setBody($data)->post();
    }
}
