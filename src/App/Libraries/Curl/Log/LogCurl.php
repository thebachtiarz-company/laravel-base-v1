<?php

declare(strict_types=1);

namespace TheBachtiarz\Base\App\Libraries\Curl\Log;

use TheBachtiarz\Base\App\Libraries\Log\AbstractLog;
use TheBachtiarz\Base\App\Libraries\Log\LogInterface;

class LogCurl extends AbstractLog implements LogInterface
{
    public function execute(): void
    {
        $this->createLog()->info($this->logEntity);
    }
}
