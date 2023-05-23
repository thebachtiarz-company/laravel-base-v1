<?php

declare(strict_types=1);

namespace TheBachtiarz\Base\App\Helpers;

use Illuminate\Http\JsonResponse;
use TheBachtiarz\Base\App\Traits\Helper\PaginatorTrait;
use Throwable;

use function gettype;
use function mb_strlen;

class ResponseHelper
{
    use PaginatorTrait;

    /**
     * Status response
     */
    protected static string $status = 'success';

    /**
     * Http code response
     */
    protected static int $httpCode = 200;

    /**
     * Access start
     */
    protected static mixed $accessStart = null;

    /**
     * Access finish
     */
    protected static mixed $accessFinish = null;

    /**
     * Access duration
     */
    protected static mixed $accessDuration = null;

    /**
     * Message service
     */
    protected static string $message = '';

    /**
     * Data service
     */
    protected static mixed $data = null;

    /**
     * Get result as paginate
     */
    protected static bool $asPaginate = false;

    /**
     * Get result per page
     */
    protected static int $perPage = 15;

    /**
     * Get index page result
     */
    protected static int $currentPage = 1;

    // ? Public Modules

    /**
     * Get json result
     */
    public static function getJsonResult(): JsonResponse
    {
        $_result = static::createResult();

        return (new JsonResponse())->setData($_result);
    }

    /**
     * Get array result
     *
     * @return array
     */
    public static function getArrayResult(): array
    {
        return static::createResult();
    }

    /**
     * Get result as paginate
     *
     * @param int         $perPage       default: 15
     * @param int         $currentPage   default: 1
     * @param string|null $sortAttribute default: null
     * @param string|null $sortType      default: null ['ASC', 'DESC']
     *
     * @return static
     */
    public static function asPaginate(
        int $perPage = 15,
        int $currentPage = 1,
        string|null $sortAttribute = null,
        string|null $sortType = null,
    ): static {
        static::$asPaginate  = true;
        static::$perPage     = $perPage;
        static::$currentPage = $currentPage;

        if (mb_strlen($sortAttribute ?? '') > 0) {
            static::addPaginateSort($sortAttribute ?? '', $sortType ?? 'ASC');
        }

        return new static();
    }

    // ? Private Modules

    /**
     * Create basic result
     *
     * @return array
     */
    private static function createResult(): array
    {
        return [
            'status' => static::$status,
            'http_code' => static::$httpCode,
            'message' => static::$message,
            'access_time' => static::getAccessTime(),
            'data' => static::getDataResolver(),
        ];
    }

    /**
     * Get response access time
     *
     * @return array
     */
    private static function getAccessTime(): array
    {
        return [
            'start' => static::$accessStart,
            'finish' => static::$accessFinish ?? static::setAccessFinish(CarbonHelper::anyConvDateToTimestamp())::$accessFinish,
            'duration' => static::getAccessDuration(),
        ];
    }

    /**
     * Get access duration
     */
    private static function getAccessDuration(): string|null
    {
        $_duration = static::$accessStart && static::$accessFinish ? static::$accessFinish - static::$accessStart : null;

        if (@$_duration >= 0 && (gettype($_duration) === 'integer')) {
            return $_duration > 1 ? "$_duration second(s)" : "$_duration second";
        }

        return null;
    }

    /**
     * Get data resolver
     *
     * @return array
     */
    private static function getDataResolver(): array
    {
        try {
            if (static::$asPaginate) {
                return static::getPaginateResult(static::$data ?? [], static::$perPage, static::$currentPage);
            }

            return static::$data;
        } catch (Throwable) {
            return static::$data;
        }
    }

    // ? Getter Modules

    // ? Setter Modules

    /**
     * Set status response
     *
     * @return static
     */
    public static function setStatus(string $status): static
    {
        static::$status = $status;

        return new static();
    }

    /**
     * Set http code
     *
     * @return static
     */
    public static function setHttpCode(int $httpCode): static
    {
        static::$httpCode = $httpCode;

        return new static();
    }

    /**
     * Set access start
     *
     * @return static
     */
    public static function setAccessStart(): static
    {
        static::$accessStart = CarbonHelper::anyConvDateToTimestamp();

        return new static();
    }

    /**
     * Set access finish
     *
     * @return static
     */
    public static function setAccessFinish(): static
    {
        static::$accessFinish = CarbonHelper::anyConvDateToTimestamp();

        return new static();
    }

    /**
     * Set response data
     *
     * @param string $message Default: ''
     * @param mixed  $data    Default: null
     * @param bool   $force   Force to set values of response -- Default: true
     *
     * @return static
     */
    public static function setResponseData(string $message = '', mixed $data = null, bool $force = true): static
    {
        if ($force) {
            static::$message = $message;
            static::$data    = $data;
        }

        if (! mb_strlen(static::$message)) {
            static::$message = $message;
            static::$data    = $data;
        }

        return new static();
    }
}
