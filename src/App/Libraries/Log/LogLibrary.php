<?php

declare(strict_types=1);

namespace TheBachtiarz\Base\App\Libraries\Log;

use Throwable;

use function app;
use function assert;

class LogLibrary
{
    /**
     * Log class entity
     *
     * @var array
     */
    protected array $logClassEntity = [
        'info' => LogInfo::class,
        'error' => LogError::class,
    ];

    // ? Public Methods

    /**
     * Create log
     */
    public function log(mixed $logEntity, string|null $channel = null): void
    {
        $_logClass = @$this->logClassEntity[$this->defineEntityType($logEntity)];
        assert($_logClass instanceof LogInterface || $_logClass === null);

        if (! $_logClass) {
            return;
        }

        $abstractLog = app()->make($_logClass);
        assert($abstractLog instanceof AbstractLog);

        if ($channel) {
            $abstractLog->setChannel($channel);
        }

        $abstractLog->setLogEntity($logEntity)->execute();
    }

    // ? Protected Methods

    /**
     * Define log entity type
     */
    protected function defineEntityType(mixed $logEntity): string
    {
        if ($logEntity instanceof Throwable) {
            return 'error';
        }

        return 'info';
    }
}
