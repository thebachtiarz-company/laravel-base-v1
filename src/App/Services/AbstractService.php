<?php

namespace TheBachtiarz\Base\App\Services;

use TheBachtiarz\Base\App\Helpers\ResponseHelper;

abstract class AbstractService
{
    //

    /**
     * Response Helper
     *
     * @var ResponseHelper
     */
    protected static $responseHelper = ResponseHelper::class;
}
