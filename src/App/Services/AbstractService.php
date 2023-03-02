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
     * @return void
     */
    final protected function setResponseData(string $message = '', mixed $data = null): void
    {
        static::$responseHelper::setResponseData($message, $data);
    }

    /**
     * Create logger
     *
     * @param mixed $log
     * @param string|null $channel
     * @return void
     */
    final protected function log(mixed $log, ?string $channel = null): void
    {
        $container = Container::getInstance();

        /** @var LogLibrary @logLibrary */
        $logLibrary = $container->make(LogLibrary::class);

        $logLibrary->log($log, $channel);
    }
}
