<?php

declare(strict_types=1);

namespace TheBachtiarz\Base\App\Interfaces;

interface ResponseInterface
{
    /**
     * Response status
     */
    public const ATTRIBUTE_STATUS = 'status';

    /**
     * Response http code
     */
    public const ATTRIBUTE_HTTPCODE = 'http_code';

    /**
     * Response message
     */
    public const ATTRIBUTE_MESSAGE = 'message';

    /**
     * Response execute time
     */
    public const ATTRIBUTE_EXECUTETIME = 'execute_time';

    /**
     * Response data
     */
    public const ATTRIBUTE_DATA = 'data';

    /**
     * Response execute time attributes
     */
    public const ATTRIBUTE_EXECUTETIME_ATTRIBUTES = [
        self::ATTRIBUTE_EXECUTETIME_START,
        self::ATTRIBUTE_EXECUTETIME_FINISH,
        self::ATTRIBUTE_EXECUTETIME_DURATION,
    ];

    /**
     * Response execute time start
     */
    public const ATTRIBUTE_EXECUTETIME_START = 'start';

    /**
     * Response execute time finish
     */
    public const ATTRIBUTE_EXECUTETIME_FINISH = 'finish';

    /**
     * Response execute time duration
     */
    public const ATTRIBUTE_EXECUTETIME_DURATION = 'duration';
}
