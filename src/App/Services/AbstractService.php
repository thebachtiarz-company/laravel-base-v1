<?php

declare(strict_types=1);

namespace TheBachtiarz\Base\App\Services;

use TheBachtiarz\Base\App\Helpers\ResponseHelper;
use TheBachtiarz\Base\App\Interfaces\Services\AbstractServiceInterface;
use TheBachtiarz\Base\App\Libraries\Log\LogLibrary;

use function app;
use function compact;
use function tbconfig;

abstract class AbstractService implements AbstractServiceInterface
{
    /**
     * Set Response result
     */
    protected bool $showResponseResult = true;

    /**
     * Write any log
     */
    protected bool $writeLog = true;

    // ? Public Methods

    // ? Protected Methods

    /**
     * Call response helper
     */
    protected function response(): ResponseHelper
    {
        return new ResponseHelper();
    }

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
        if (! $this->showResponseResult) {
            return;
        }

        $this->response()::setResponseData(message: $message, data: $data, force: $force)
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
    final protected function log(mixed $log, string|null $channel = null): void
    {
        if (! $this->writeLog) {
            return;
        }

        /** @var LogLibrary @logLibrary */
        $logLibrary = app(LogLibrary::class);

        $logLibrary->log(
            logEntity: $log,
            channel: $channel ?: match (tbconfig(configName: 'app', keyName: 'env')) {
                'local' => 'developer',
                'production' => 'production',
                default => 'developer'
            },
        );
    }

    // ? Private Methods

    // ? Setter Modules

    /**
     * Hide response result
     *
     * @return static
     */
    public function hideResponseResult(): static
    {
        $this->showResponseResult = false;

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
