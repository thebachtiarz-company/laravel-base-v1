<?php

declare(strict_types=1);

namespace TheBachtiarz\Base\App\Helpers;

use Illuminate\Support\Collection;
use Throwable;

use function collect;
use function sprintf;

class TemporaryDataHelper
{
    /**
     * Temporary Data
     */
    protected static Collection $temporaryData;

    // ? Public Methods

    /**
     * Get data
     */
    public static function getData(string|null $attribute = null): mixed
    {
        static::init();

        return @static::$temporaryData->get($attribute) ?? static::$temporaryData->toArray();
    }

    /**
     * Set temporaries data
     *
     * @param array $temporariesData
     *
     * @return static
     */
    public static function setData(array $temporariesData = []): static
    {
        static::init();

        static::$temporaryData = collect($temporariesData);

        return new static();
    }

    /**
     * Add data into temporary
     *
     * @return static
     */
    public static function addData(string $attribute, mixed $value): static
    {
        static::init();

        static::$temporaryData->put(key: $attribute, value: $value);

        return new static();
    }

    /**
     * Save temporary data into cache
     *
     * @return static
     */
    public static function cache(): static
    {
        static::init();

        if (static::$temporaryData->count()) {
            CacheHelper::setCache(
                cacheName: sprintf(
                    '%s-%s',
                    CarbonHelper::anyConvDateToTimestamp(withMilli: true),
                    StringHelper::shuffleBoth(7),
                ),
                value: static::$temporaryData,
            );
        }

        return new static();
    }

    /**
     * Reset temporary data
     *
     * @return static
     */
    public static function flush(): static
    {
        static::init();

        static::$temporaryData = collect();

        return new static();
    }

    // ? Protected Methods

    /**
     * Init temporary collection
     */
    protected static function init(): void
    {
        try {
            static::$temporaryData->count();
        } catch (Throwable) {
            static::$temporaryData = collect();
        }
    }

    // ? Private Methods

    // ? Getter Modules

    // ? Setter Modules
}
