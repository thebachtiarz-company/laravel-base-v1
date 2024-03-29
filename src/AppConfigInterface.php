<?php

declare(strict_types=1);

namespace TheBachtiarz\Base;

interface AppConfigInterface
{
    public const CONFIG_APP_NAME     = 'app_name';
    public const CONFIG_APP_URL      = 'app_url';
    public const CONFIG_APP_TIMEZONE = 'app_timezone';
    public const CONFIG_APP_PREFIX   = 'app_prefix';
    public const CONFIG_APP_KEY      = 'app_key';
    public const CONFIG_CACHE_SYSTEM = 'cache_system';
}
