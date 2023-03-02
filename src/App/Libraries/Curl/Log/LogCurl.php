<?php

namespace TheBachtiarz\Base\App\Libraries\Curl\Log;

use TheBachtiarz\Base\App\Libraries\Log\AbstractLog;
use TheBachtiarz\Base\App\Libraries\Log\LogInterface;

class LogCurl extends AbstractLog implements LogInterface
{
    //

    /**
     * {@inheritDoc}
     */
    public function execute(): void
    {
        $this->createLog()->info($this->logEntity);
    }
}
