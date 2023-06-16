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
     * Access start timestamp
     */
    protected static mixed $accessStart = null;

    /**
     * Access finish timestamp
     */
    protected static mixed $accessFinish = null;

    /**
     * Access duration
     */
    protected static mixed $accessDuration = null;

    /**
     * Message response
     */
    protected static string $message = '';

    /**
     * Data response
     */
    protected static mixed $data = null;

    /**
     * Tag result as paginate
     */
    protected static bool $asPaginate = false;

    /**
     * Tag paginate result per page
     */
    protected static int $perPage = 15;

    /**
     * Tag paginate index page result
     */
    protected static int $currentPage = 1;

    /**
     * Attributes paginator options
     */
    protected static array|null $attributesPaginator = null;

    // ? Public Modules

    /**
     * Init response result
     *
     * @return static
     */
    public static function init(): static
    {
        static::setAccessStart();

        return new static();
    }

    /**
     * Get json result
     */
    public static function getJsonResult(): JsonResponse
    {
        $result = static::createResult();

        return (new JsonResponse())->setData($result);
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

    /**
     * Make an/some attribute as paginate result
     *
     * @param array|null $paginateOptions Format: ['attribute_name' => ['perPage' => 15, 'currentPage' => 1, 'sortAttribute' => null, 'sortType' => null]]
     *
     * @return static
     */
    public static function attributesPaginate(array|null $paginateOptions = null): static
    {
        if ($paginateOptions) {
            static::$attributesPaginator = $paginateOptions;
        }

        return new static();
    }

    // ? Protected Modules

    /**
     * Custom attribute paginator resolver
     *
     * @return static
     */
    protected static function resolveAttributePaginateResult(): static
    {
        static::$itemsRequestSort = null;

        foreach (static::$attributesPaginator as $attribute => $options) {
            $originalAttributeValues = @static::$data[$attribute];

            if (! $originalAttributeValues) {
                continue;
            }

            $customAttributeValues = new static();

            if (@$options['sortAttribute']) {
                $customAttributeValues = $customAttributeValues::addPaginateSort(
                    $options['sortAttribute'] ?? '',
                    $options['sortType'] ?? 'ASC',
                );
            }

            $customAttributeValues = $customAttributeValues::getPaginateResult(
                $originalAttributeValues,
                @$options['perPage'] ?? 15,
                @$options['currentPage'] ?? 1,
            );

            static::$data[$attribute] = $customAttributeValues;
        }

        static::$itemsRequestSort = null;

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
     * Get data resolver
     */
    private static function getDataResolver(): mixed
    {
        try {
            if (static::$asPaginate) {
                return static::getPaginateResult(
                    static::$data ?? [],
                    static::$perPage,
                    static::$currentPage,
                );
            }

            if (static::$attributesPaginator) {
                static::resolveAttributePaginateResult();
            }

            return static::$data;
        } catch (Throwable) {
            return static::$data;
        }
    }

    // ? Getter Modules

    /**
     * Get status response
     */
    public static function getStatus(): string
    {
        return static::$status;
    }

    /**
     * Get http code response
     */
    public static function getHttpCode(): int
    {
        return static::$httpCode;
    }

    /**
     * Get access start timestamp
     */
    public static function getAccessStart(): mixed
    {
        return static::$accessStart;
    }

    /**
     * Get access finish timestamp
     */
    public static function getAccessFinish(): mixed
    {
        return static::$accessFinish;
    }

    /**
     * Get access duration
     */
    public static function getAccessDuration(): mixed
    {
        static::$accessDuration = null;

        $duration = static::$accessStart && static::$accessFinish ? static::$accessFinish - static::$accessStart : null;

        if (@$duration >= 0 && (gettype($duration) === 'integer')) {
            static::$accessDuration = $duration > 1 ? "$duration second(s)" : "$duration second";
        }

        return static::$accessDuration;
    }

    /**
     * Get message response
     */
    public static function getMessage(): string
    {
        return static::$message;
    }

    /**
     * Get data response
     */
    public static function getData(): mixed
    {
        return static::$data;
    }

    /**
     * Get is result as paginate
     */
    public static function isAsPaginate(): bool
    {
        return static::$asPaginate;
    }

    /**
     * Get result paginate per page
     */
    public static function getPerPage(): int
    {
        return static::$perPage;
    }

    /**
     * Get result paginate index page
     */
    public static function getCurrentPage(): int
    {
        return static::$currentPage;
    }

    /**
     * Get attribute paginator
     */
    public static function getAttributesPaginate(string|null $attributeName = null): array|null
    {
        return @static::$attributesPaginator[$attributeName] ?? static::$attributesPaginator;
    }

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

    /**
     * Set attribute paginator
     *
     * @param string $attributeName Attribute Name
     * @param array  $options       Format: ['perPage' => 15, 'currentPage' => 1, 'sortAttribute' => null, 'sortType' => null]
     *
     * @return static
     */
    public static function setAttributesPaginate(string $attributeName, array $options): static
    {
        static::$attributesPaginator[$attributeName] = $options;

        return new static();
    }
}
