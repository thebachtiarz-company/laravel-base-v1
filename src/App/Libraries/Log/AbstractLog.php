<?php

namespace TheBachtiarz\Base\App\Libraries\Log;

use Illuminate\Support\Facades\Log;
use Psr\Log\LoggerInterface;

abstract class AbstractLog implements LogInterface
{
    //

    /**
     * Log channel
     *
     * @var string
     */
    protected string $channel = 'maintenance';

    /**
     * Log data entity
     *
     * @var mixed
     */
    protected mixed $logEntity = null;

    // ? Public Methods
    /**
     * {@inheritDoc}
     */
    abstract public function execute(): void;

    // ? Protected Methods
    /**
     * Create log interface
     *
     * @return LoggerInterface
     */
    protected function createLog(): LoggerInterface
    {
        return Log::channel($this->channel);
    }

    // ? Private Methods

    // ? Getter Modules

    // ? Setter Modules
    /**
     * Set log channel
     *
     * @param string $channel
     * @return self
     */
    public function setChannel(string $channel): self
    {
        $this->channel = $channel;

        return $this;
    }

    /**
     * Set log entity
     *
     * @param mixed $logEntity
     * @return self
     */
    public function setLogEntity(mixed $logEntity): self
    {
        $this->logEntity = $logEntity;

        return $this;
    }
}
