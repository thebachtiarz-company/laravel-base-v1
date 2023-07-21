<?php

declare(strict_types=1);

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;
use TheBachtiarz\Base\App\Helpers\CacheHelper;
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

if (! function_exists('tbgetmodelcolumns')) {
    /**
     * Get columns table from model
     */
    function tbgetmodelcolumns(Model $model, bool|null $refreshCache = false): array
    {
        $table     = $model->getTable();
        $cacheName = sprintf('table_%s_columns', $table);

        $iterable = 0;
        $result   = [];

        if ($refreshCache) {
            goto PROCESS_GET_COLUMNS;
        }

        PROCESS_CHECK_CACHE:
        $isCacheExist = CacheHelper::hasCache(cacheName: $cacheName);
        if (! $isCacheExist) {
            goto PROCESS_GET_COLUMNS;
        }

        PROCESS_GET_CACHE:
        $result = CacheHelper::getCache(cacheName: $cacheName);
        goto PROCESS_CHECK_COLUMNS;

        PROCESS_GET_COLUMNS:
        $result = collect(value: Schema::getColumnListing($table))->toArray();

        PROCESS_SET_CACHE:
        CacheHelper::setCache(cacheName: $cacheName, value: $result);
        goto PROCESS_RETURN_RESULT;

        PROCESS_CHECK_COLUMNS:
        if ($iterable < 1 && count(value: $result) < 1) {
            $iterable++;
            goto PROCESS_GET_COLUMNS;
        }

        PROCESS_RETURN_RESULT:

        return $result;
    }
}

if (! function_exists('tbbaserestapipath')) {
    /**
     * Base rest api path
     */
    function tbbaserestapipath(string $type): string
    {
        $package = match ($type) {
            'base' => 'App',
            'config' => 'Config',
        };

        return base_path("vendor/thebachtiarz-company/laravel-auth-v2/src/$package/routes/rest.php");
    }
}
