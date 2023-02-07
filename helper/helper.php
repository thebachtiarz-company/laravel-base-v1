<?php

use TheBachtiarz\Base\BaseConfigInterface;

/**
 * TheBachtiarz base config
 *
 * @param string|null $keyName config key name | null will return all
 * @return mixed
 */
function tbbaseconfig(?string $keyName = null): mixed
{
    $configName = BaseConfigInterface::CONFIG_NAME;

    return iconv_strlen($keyName)
        ? config("{$configName}.{$keyName}")
        : config("{$configName}");
}

/**
 * Check directory location
 *
 * @param string|null $subDir
 * @return string
 */
function tbdirlocation(?string $subDir = null): string
{
    $_subDir = $subDir ? "/{$subDir}" : "";

    return base_path(BaseConfigInterface::DIRECTORY_PATH) . $_subDir;
}
