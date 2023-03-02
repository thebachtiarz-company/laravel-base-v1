<?php

namespace TheBachtiarz\Base\App\Helpers;

use Illuminate\Http\JsonResponse;
use TheBachtiarz\Base\App\Traits\Helper\PaginatorTrait;

class ResponseHelper
{
    use PaginatorTrait;

    /**
     * Status response
     *
     * @var string
     */
    protected static string $status = 'success';

    /**
     * Http code response
     *
     * @var integer
     */
    protected static int $httpCode = 200;

    /**
     * Access start
     *
     * @var integer|null
     */
    protected static ?int $accessStart = null;

    /**
     * Access finish
     *
     * @var integer|null
     */
    protected static ?int $accessFinish = null;

    /**
     * Access duration
     *
     * @var integer|null
     */
    protected static ?int $accessDuration = null;

    /**
     * Message service
     *
     * @var string
     */
    protected static string $message = '';

    /**
     * Data service
     *
     * @var mixed
     */
    protected static mixed $data = null;

    /**
     * Get result as paginate
     *
     * @var boolean
     */
    protected static bool $asPaginate = false;

    /**
     * Get result per page
     *
     * @var integer
     */
    protected static int $perPage = 15;

    /**
     * Get index page result
     *
     * @var integer
     */
    protected static int $currentPage = 1;

    // ? Public Modules
    /**
     * Get json result
     *
     * @return JsonResponse
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
        $_result = static::createResult();

        return $_result;
    }

    /**
     * Get result as paginate
     *
     * @param integer $perPage default: 15
     * @param integer $currentPage default: 1
     * @param string|null $sortAttribute default: null
     * @param string|null $sortType default: null ['ASC', 'DESC']
     * @return static
     */
    public static function asPaginate(
        int $perPage = 15,
        int $currentPage = 1,
        ?string $sortAttribute = null,
        ?string $sortType = null
    ): static {
        static::$asPaginate = true;
        static::$perPage = $perPage;
        static::$currentPage = $currentPage;

        if (mb_strlen($sortAttribute)) {
            static::addPaginateSort($sortAttribute ?? '', $sortType ?? 'ASC');
        }

        return new static;
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
            'data' => static::$asPaginate
                ? static::getPaginateResult(static::$data, static::$perPage, static::$currentPage)
                : static::$data
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
            'duration' => static::getAccessDuration()
        ];
    }

    /**
     * Get access duration
     *
     * @return string|null
     */
    private static function getAccessDuration(): ?string
    {
        $_duration = static::$accessStart && static::$accessFinish ? (static::$accessFinish - static::$accessStart) : null;

        if (@$_duration >= 0 && (gettype($_duration) == 'integer')) {
            return $_duration > 1 ? "$_duration second(s)" : "$_duration second";
        }

        return null;
    }

    // ? Getter Modules

    // ? Setter Modules
    /**
     * Set status response
     *
     * @param string $status
     * @return static
     */
    public static function setStatus(string $status): static
    {
        static::$status = $status;

        return new static;
    }

    /**
     * Set http code
     *
     * @param integer $httpCode
     * @return static
     */
    public static function setHttpCode(int $httpCode): static
    {
        static::$httpCode = $httpCode;

        return new static;
    }

    /**
     * Set access start
     *
     * @return static
     */
    public static function setAccessStart(): static
    {
        static::$accessStart = CarbonHelper::anyConvDateToTimestamp();

        return new static;
    }

    /**
     * Set access finish
     *
     * @return static
     */
    public static function setAccessFinish(): static
    {
        static::$accessFinish = CarbonHelper::anyConvDateToTimestamp();

        return new static;
    }

    /**
     * Set response data
     *
     * @param string $message default: ''
     * @param mixed $data default: null
     * @return static
     */
    public static function setResponseData(string $message = '', mixed $data = null): static
    {
        static::$message = $message;
        static::$data = $data;

        return new static;
    }
}
