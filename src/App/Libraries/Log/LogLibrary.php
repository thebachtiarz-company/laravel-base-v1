<?php

namespace TheBachtiarz\Base\App\Libraries\Log;

class LogLibrary
{
    //

    /**
     * Log class entity
     *
     * @var array
     */
    protected array $logClassEntity = [
        'info' => \TheBachtiarz\Base\App\Libraries\Log\LogInfo::class,
        'error' => \TheBachtiarz\Base\App\Libraries\Log\LogError::class
    ];

    // ? Public Methods
    /**
     * Create log
     *
     * @param mixed $logEntity
     * @param string|null $channel
     * @return void
     */
    public function log(mixed $logEntity, ?string $channel = null): void
    {
        /** @var LogInterface|null $_logClass */
        $_logClass = @$this->logClassEntity[$this->defineEntityType($logEntity)];

        if ($_logClass) {
            /** @var AbstractLog $abstractLog */
            $abstractLog = app()->make($_logClass);

            if ($channel) {
                $abstractLog->setChannel($channel);
            }

            $abstractLog->setLogEntity($logEntity)->execute();
        }
    }

    // ? Protected Methods
    /**
     * Define log entity type
     *
     * @return string
     */
    protected function defineEntityType(mixed $logEntity): string
    {
        if ($logEntity instanceof \Throwable) {
            return 'error';
        }

        return 'info';
    }
}
