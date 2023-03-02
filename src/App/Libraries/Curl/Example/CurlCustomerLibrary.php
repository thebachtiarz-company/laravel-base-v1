<?php

namespace TheBachtiarz\Base\App\Libraries\Curl\Example;

use TheBachtiarz\Base\App\Libraries\Curl\CurlLibrary as BaseCurlLibrary;

class CurlCustomerLibrary extends BaseCurlLibrary
{
    //

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->classEntity['create-new-customer'] = \TheBachtiarz\Base\App\Libraries\Curl\Example\CreateNewCustomer::class;
    }
}
