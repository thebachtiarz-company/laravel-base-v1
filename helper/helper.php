<?php

use TheBachtiarz\Base\BaseConfigInterface;

if (!function_exists('tbbaseconfig')) {
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
}

if (!function_exists('tbdirlocation')) {
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
}

if (!function_exists('tbconfigvalue')) {
    /**
     * Get config value
     *
     * @param string $configPath
     * @param mixed $setValue For create new/update config purpose -- default: null
     * @return mixed
     */
    function tbconfigvalue(string $configPath, mixed $setValue = null): mixed
    {
        /** @var \Illuminate\Container\Container $container */
        $container = \Illuminate\Container\Container::getInstance();

        /** @var \TheBachtiarz\Base\Config\Services\ConfigService $configService  */
        $configService = $container->make(\TheBachtiarz\Base\Config\Services\ConfigService::class);

        $configService->hideResponseResult();

        if ($setValue) {
            $configService->createOrUpdate($configPath, $setValue);
        }

        return $configService->getConfigValue($configPath);
    }
}
