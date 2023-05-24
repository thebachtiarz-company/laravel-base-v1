<?php

declare(strict_types=1);

use TheBachtiarz\Base\BaseConfigInterface;
use TheBachtiarz\Base\Config\Services\ConfigService;

if (! function_exists('tbbaseconfig')) {
    /**
     * TheBachtiarz base config
     *
     * @param string|null $keyName   Config key name | null will return all
     * @param bool|null   $useOrigin Use original value from config
     */
    function tbbaseconfig(string|null $keyName = null, bool|null $useOrigin = true): mixed
    {
        $configName = BaseConfigInterface::CONFIG_NAME;

        return tbconfig($configName, $keyName, $useOrigin);
    }
}

if (! function_exists('tbconfig')) {
    /**
     * TheBachtiarz config
     */
    function tbconfig(string $configName, string|null $keyName = null, bool|null $useOrigin = true): mixed
    {
        try {
            $path = sprintf('%s%s', $configName, mb_strlen($keyName) ? ".$keyName" : null);

            return $useOrigin ? config($path) : tbconfigvalue($path);
        } catch (Throwable) {
        }

        return null;
    }
}

if (! function_exists('tbconfigvalue')) {
    /**
     * Get config value
     *
     * @param mixed $setValue For create new/update config purpose -- default: null
     */
    function tbconfigvalue(string $configPath, mixed $setValue = null): mixed
    {
        $configService = app()->make(ConfigService::class);
        assert($configService instanceof ConfigService);

        $configService->hideResponseResult();

        if ($setValue) {
            $configService->createOrUpdate($configPath, $setValue);
        }

        return $configService->getConfigValue($configPath);
    }
}

if (! function_exists('tbdirlocation')) {
    /**
     * Check directory location
     */
    function tbdirlocation(string|null $subDir = null): string
    {
        $subDir = $subDir ? "/{$subDir}" : '';

        return base_path(BaseConfigInterface::DIRECTORY_PATH) . $subDir;
    }
}
