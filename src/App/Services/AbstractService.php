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
     * Set Response result
     *
     * @var boolean
     */
    protected bool $responseResult = true;

    /**
     * Set service result response
     *
     * @param string $message Default: ''
     * @param mixed $data Default: null
     * @param boolean $force Default: true
     * @param string $status Default: success
     * @param integer $httpCode Default: 200
     * @return void
     */
    final protected function setResponseData(
        string $message = '',
        mixed $data = null,
        bool $force = true,
        string $status = 'success',
        int $httpCode = 200
    ): void {
        if ($this->responseResult) {
            static::$responseHelper::setResponseData(message: $message, data: $data, force: $force)
                ->setStatus($status)
                ->setHttpCode($httpCode);
        }
    }

    /**
     * Generate service result response
     *
     * @param boolean $status
     * @param string $message
     * @param mixed $data
     * @return array
     */
    final protected function serviceResult(
        bool $status = false,
        string $message = '',
        mixed $data = null
    ): array {
        return compact('status', 'message', 'data');
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

    // ? Setter Modules
    /**
     * Hide response result
     *
     * @return static
     */
    public function hideResponseResult(): static
    {
        $this->responseResult = false;

        return $this;
    }
}
