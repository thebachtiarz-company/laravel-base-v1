<?php

declare(strict_types=1);

namespace TheBachtiarz\Base\App\Libraries\Curl\Example;

use TheBachtiarz\Base\App\Libraries\Curl\CurlLibrary as BaseCurlLibrary;

class CurlCustomerLibrary extends BaseCurlLibrary
{
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->classEntity['create-new-customer'] = CreateNewCustomer::class;
    }
}
