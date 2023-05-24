<?php

declare(strict_types=1);

namespace TheBachtiarz\Base\App\Libraries\Log;

use Throwable;

use function assert;
use function json_encode;

class LogError extends AbstractLog implements LogInterface
{
    public function execute(): void
    {
        $throwable = $this->logEntity;
        assert($throwable instanceof Throwable);

        $trace = $throwable->getTrace();

        $logData = json_encode([
            'file' => $trace[0]['file'],
            'line' => $trace[0]['line'],
            'message' => $throwable->getMessage(),
            'code' => $throwable->getCode(),
        ]);

        $this->createLog()->error($logData);
    }
}
