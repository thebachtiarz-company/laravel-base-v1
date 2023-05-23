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
    public static function has(string $cacheName): bool
    {
        return self::has($cacheName);
    }

    /**
     * Get cache by key
     */
    public static function get(string $cacheName): mixed
    {
        return self::get($cacheName);
    }

    /**
     * Set cache data forever
     */
    public static function set(string $cacheName, mixed $value): bool
    {
        return self::forever($cacheName, $value);
    }

    /**
     * Set cache data temporary with time to live
     *
     * @param DateTimeInterface|DateInterval|int $ttl default: 60 seconds
     */
    public static function setTemporary(string $cacheName, mixed $value, DateTimeInterface|DateInterval|int $ttl = 60): bool
    {
        return self::put($cacheName, $value, $ttl);
    }

    /**
     * Delete a cache data by key
     */
    public static function delete(string $cacheName): bool
    {
        return self::forget($cacheName);
    }

    /**
     * Erase/Remove all cache data
     */
    public static function erase(): bool
    {
        return self::flush();
    }
}
