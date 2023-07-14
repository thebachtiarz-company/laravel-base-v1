<?php

declare(strict_types=1);

namespace TheBachtiarz\Base\Config\Helpers;

use Illuminate\Support\Collection;
use Throwable;

use function collect;
use function config;
use function is_array;
use function tbconfigvalue;

class ConfigPoolHelper
{
    /**
     * Config pool
     */
    private static Collection $configPool;

    // ? Public Methods

    /**
     * Add config pool
     *
     * @return static
     */
    public static function addConfigPool(string $configPath, mixed $configValue, bool $collapse = false): static
    {
        $collection = collect();

        try {
            foreach (tbconfigvalue(configPath: $configPath) ?? [] as $key => $value) {
                $collection->push(is_array($value) ? [$key => $value] : $value);
            }
        } catch (Throwable) {
        }

        $collection->push($configValue);

        static::$configPool = $collapse ? $collection->unique()->collapse() : $collection->unique();

        config([$configPath => static::$configPool->toArray()]);

        try {
            tbconfigvalue(configPath: $configPath, setValue: static::$configPool->toArray());
        } catch (Throwable) {
        }

        return new static();
    }

    /**
     * Get pool collection
     */
    public static function getPool(): Collection
    {
        return static::$configPool;
    }

    // ? Protected Methods

    // ? Private Methods

    // ? Getter Modules

    // ? Setter Modules
}
