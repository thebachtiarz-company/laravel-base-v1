<?php

namespace TheBachtiarz\Base\App\Helpers;

use Illuminate\Support\Facades\Cache;

class CacheHelper extends Cache
{
    //

    /**
     * Check is cache available by key
     *
     * @param string $cacheName
     * @return boolean
     */
    public static function has(string $cacheName): bool
    {
        return self::has($cacheName);
    }

    /**
     * Get cache by key
     *
     * @param string $cacheName
     * @return mixed
     */
    public static function get(string $cacheName): mixed
    {
        return self::get($cacheName);
    }

    /**
     * Set cache data forever
     *
     * @param string $cacheName
     * @param mixed $value
     * @return boolean
     */
    public static function set(string $cacheName, mixed $value): bool
    {
        return self::forever($cacheName, $value);
    }

    /**
     * Set cache data temporary with time to live
     *
     * @param string $cacheName
     * @param mixed $value
     * @param \DateTimeInterface|\DateInterval|int $ttl default: 60 seconds
     * @return boolean
     */
    public static function setTemporary(string $cacheName, mixed $value, \DateTimeInterface|\DateInterval|int $ttl = 60): bool
    {
        return self::put($cacheName, $value, $ttl);
    }

    /**
     * Delete a cache data by key
     *
     * @param string $cacheName
     * @return boolean
     */
    public static function delete(string $cacheName): bool
    {
        return self::forget($cacheName);
    }

    /**
     * Erase/Remove all cache data
     *
     * @return boolean
     */
    public static function erase(): bool
    {
        return self::flush();
    }
}
