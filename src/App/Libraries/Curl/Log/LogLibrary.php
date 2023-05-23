<?php

declare(strict_types=1);

namespace TheBachtiarz\Base\App\Libraries\Curl\Log;

use TheBachtiarz\Base\App\Libraries\Log\LogLibrary as BaseLogLibrary;

class LogLibrary extends BaseLogLibrary
{
    /**
     * Override
     */
    protected bool $override = false;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->logClassEntity['curl'] = LogCurl::class;
    }

    protected function defineEntityType(mixed $logEntity): string
    {
        return $this->override ? 'curl' : parent::defineEntityType($logEntity);
    }

    /**
     * Mark as override
     */
    public function override(bool $override = true): self
    {
        $this->override = $override;

        return $this;
    }
}
