<?php

use TheBachtiarz\Base\BaseConfigInterface;

if (!function_exists('tbbaseconfig')) {
    /**
     * TheBachtiarz base config
     *
     * @param string|null $keyName Config key name | null will return all
     * @param boolean|null $useOrigin Use original value from config
     * @return mixed
     */
    function tbbaseconfig(?string $keyName = null, ?bool $useOrigin = true): mixed
    {
        $configName = BaseConfigInterface::CONFIG_NAME;

        return tbconfig($configName, $keyName, $useOrigin);
    }
}

if (!function_exists('tbconfig')) {
    /**
     * TheBachtiarz config
     *
     * @param string $configName
     * @param string|null $keyName
     * @param boolean|null $useOrigin
     * @return mixed
     */
    function tbconfig(string $configName, ?string $keyName = null, ?bool $useOrigin = true): mixed
    {
        try {
            $path = sprintf('%s%s', $configName, mb_strlen($keyName) ? ".$keyName" : null);

            return $useOrigin ? config($path) : tbconfigvalue($path);
        } catch (\Throwable $th) {
        }

        return null;
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
        /** @var \TheBachtiarz\Base\Config\Services\ConfigService $configService  */
        $configService = app()->make(\TheBachtiarz\Base\Config\Services\ConfigService::class);

        $configService->hideResponseResult();

        if ($setValue) {
            $configService->createOrUpdate($configPath, $setValue);
        }

        return $configService->getConfigValue($configPath);
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
