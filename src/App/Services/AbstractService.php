<?php

declare(strict_types=1);

namespace TheBachtiarz\Base\App\Services;

use TheBachtiarz\Base\App\Helpers\ResponseHelper;
use TheBachtiarz\Base\App\Libraries\Log\LogLibrary;

use function app;
use function compact;

abstract class AbstractService
{
    /**
     * Response Helper
     *
     * @var ResponseHelper
     */
    protected static $responseHelper = ResponseHelper::class;

    /**
     * Set Response result
     */
    protected bool $responseResult = true;

    /**
     * Write any log
     */
    protected bool $writeLog = true;

    /**
     * Set service result response
     *
     * @param string $message  Default: ''
     * @param mixed  $data     Default: null
     * @param bool   $force    Default: true
     * @param string $status   Default: success
     * @param int    $httpCode Default: 200
     */
    final protected function setResponseData(
        string $message = '',
        mixed $data = null,
        bool $force = true,
        string $status = 'success',
        int $httpCode = 200,
    ): void {
        if (! $this->responseResult) {
            return;
        }

        static::$responseHelper::setResponseData(message: $message, data: $data, force: $force)
            ->setStatus($status)
            ->setHttpCode($httpCode);
    }

    /**
     * Generate service result response
     *
     * @return array
     */
    final protected function serviceResult(
        bool $status = false,
        string $message = '',
        mixed $data = null,
    ): array {
        return compact('status', 'message', 'data');
    }

    /**
     * Create logger
     *
     * @param string|null $channel Default: developer
     */
    final protected function log(mixed $log, string|null $channel = 'developer'): void
    {
        if (! $this->writeLog) {
            return;
        }

        /** @var LogLibrary @logLibrary */
        $logLibrary = app()->make(LogLibrary::class);

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

    /**
     * Ignore any log
     *
     * @return static
     */
    public function ignoreLog(): static
    {
        $this->writeLog = false;

        return $this;
    }
}
