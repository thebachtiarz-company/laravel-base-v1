<?php

namespace TheBachtiarz\Base\App\Libraries\Log;

class LogError extends AbstractLog implements LogInterface
{
    //

    /**
     * {@inheritDoc}
     */
    public function execute(): void
    {
        /** @var \Throwable $throwable */
        $throwable = $this->logEntity;

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
