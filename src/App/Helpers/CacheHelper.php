<?php

declare(strict_types=1);

namespace TheBachtiarz\Base\App\Helpers;

use DateInterval;
use DateTimeInterface;
use Illuminate\Support\Facades\Cache;

class CacheHelper extends Cache
{
    /**
     * Check is cache available by key
     */
    public static function hasCache(string $cacheName): bool
    {
        return self::has($cacheName);
    }

    /**
     * Get cache by key
     */
    public static function getCache(string $cacheName): mixed
    {
        return self::get($cacheName);
    }

    /**
     * Set cache data forever
     */
    public static function setCache(string $cacheName, mixed $value): bool
    {
        return self::forever($cacheName, $value);
    }

    /**
     * Set cache data temporary with time to live
     *
     * @param DateTimeInterface|DateInterval|int $ttl default: 60 seconds
     */
    public static function setTemporaryCache(
        string $cacheName,
        mixed $value,
        DateTimeInterface|DateInterval|int $ttl = 60,
    ): bool {
        return self::put($cacheName, $value, $ttl);
    }

    /**
     * Delete a cache data by key
     */
    public static function deleteCache(string $cacheName): bool
    {
        return self::forget($cacheName);
    }

    /**
     * Erase/Remove all cache data
     */
    public static function eraseCaches(): bool
    {
        return self::flush();
    }
}
