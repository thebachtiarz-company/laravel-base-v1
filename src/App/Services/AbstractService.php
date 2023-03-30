<?php

namespace TheBachtiarz\Base\App\Services;

use Illuminate\Container\Container;
use TheBachtiarz\Base\App\Helpers\ResponseHelper;
use TheBachtiarz\Base\App\Libraries\Log\LogLibrary;

abstract class AbstractService
{
    //

    /**
     * Response Helper
     *
     * @var ResponseHelper
     */
    protected static $responseHelper = ResponseHelper::class;

    /**
     * Set service result response
     *
     * @param string $message
     * @param mixed $data
     * @param boolean $force
     * @return void
     */
    final protected function setResponseData(string $message = '', mixed $data = null, bool $force = false): void
    {
        static::$responseHelper::setResponseData(message: $message, data: $data, force: $force);
    }

    /**
     * Create logger
     *
     * @param mixed $log
     * @param string|null $channel Default: developer
     * @return void
     */
    final protected function log(mixed $log, ?string $channel = 'developer'): void
    {
        /** @var LogLibrary @logLibrary */
        $logLibrary = Container::getInstance()->make(LogLibrary::class);

        $logLibrary->log(logEntity: $log, channel: $channel);
    }
}
