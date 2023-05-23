<?php

declare(strict_types=1);

namespace TheBachtiarz\Base\App\Libraries\Log;

class LogInfo extends AbstractLog implements LogInterface
{
    public function execute(): void
    {
        $this->createLog()->info($this->logEntity);
    }
}
