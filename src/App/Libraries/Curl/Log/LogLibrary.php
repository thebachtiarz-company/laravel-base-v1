<?php

namespace TheBachtiarz\Base\App\Libraries\Curl\Log;

use TheBachtiarz\Base\App\Libraries\Log\LogLibrary as BaseLogLibrary;

class LogLibrary extends BaseLogLibrary
{
    //

    /**
     * Override
     *
     * @var boolean
     */
    protected bool $override = false;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->logClassEntity['curl'] = \TheBachtiarz\Base\App\Libraries\Curl\Log\LogCurl::class;
    }

    /**
     * {@inheritDoc}
     */
    protected function defineEntityType(mixed $logEntity): string
    {
        return $this->override ? 'curl' : parent::defineEntityType($logEntity);
    }

    /**
     * Mark as override
     *
     * @param boolean $override
     * @return self
     */
    public function override(bool $override = true): self
    {
        $this->override = $override;

        return $this;
    }
}
