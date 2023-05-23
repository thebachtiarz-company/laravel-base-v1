<?php

declare(strict_types=1);

namespace TheBachtiarz\Base\App\Libraries\Log;

use Illuminate\Support\Facades\Log;
use Psr\Log\LoggerInterface;

abstract class AbstractLog implements LogInterface
{
    /**
     * Log channel
     */
    protected string $channel = 'maintenance';

    /**
     * Log data entity
     */
    protected mixed $logEntity = null;

    abstract public function execute(): void;

    // ? Protected Methods

    /**
     * Create log interface
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
     */
    public function setChannel(string $channel): self
    {
        $this->channel = $channel;

        return $this;
    }

    /**
     * Set log entity
     */
    public function setLogEntity(mixed $logEntity): self
    {
        $this->logEntity = $logEntity;

        return $this;
    }
}
