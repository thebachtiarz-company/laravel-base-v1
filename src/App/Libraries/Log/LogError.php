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

        $_trace = $throwable->getTrace();

        $_logData = json_encode([
            'file' => $_trace[0]['file'],
            'line' => $_trace[0]['line'],
            'message' => $throwable->getMessage(),
            'code' => $throwable->getCode(),
        ]);

        $this->createLog()->error($_logData);
    }
}
