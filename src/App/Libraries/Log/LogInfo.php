<?php

namespace TheBachtiarz\Base\App\Libraries\Log;

class LogInfo extends AbstractLog implements LogInterface
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
