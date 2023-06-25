<?php

declare(strict_types=1);

namespace TheBachtiarz\Base\App\Helpers;

use Carbon\CarbonInterval;
use Illuminate\Http\JsonResponse;
use TheBachtiarz\Base\App\Libraries\Paginator\PaginateResult;
use TheBachtiarz\Base\App\Traits\Helper\PaginatorTrait;
use Throwable;

use function app;
use function assert;
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
     * Execute start timestamp
     */
    protected static mixed $executeStart = null;

    /**
     * Execute finish timestamp
     */
    protected static mixed $executeFinish = null;

    /**
     * Execute duration
     */
    protected static mixed $executeDuration = null;

    /**
     * Message response
     */
    protected static string $message = '';

    /**
     * Data response
     */
    protected static mixed $data = null;

    /**
     * Return result data direct without paginating
     */
    protected static bool $directResult = false;

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
        static::setExecuteStart();

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

            $customAttributeValues = app(PaginateResult::class);
            assert($customAttributeValues instanceof PaginateResult);

            $customAttributeValues->execute(
                resultData: $originalAttributeValues,
                perPage: @$options['perPage'] ?? 15,
                currentPage: @$options['currentPage'] ?? 1,
                sortAttributes: [@$options],
            );

            static::$data[$attribute] = $customAttributeValues->toArray();
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
            'execute_time' => static::getExecuteTime(),
            'data' => static::getDataResolver(),
        ];
    }

    /**
     * Get response execute time
     *
     * @return array
     */
    private static function getExecuteTime(): array
    {
        return [
            'start' => static::$executeStart,
            'finish' => static::$executeFinish ?? static::setExecuteFinish(CarbonHelper::anyConvDateToTimestamp())::$executeFinish,
            'duration' => static::getExecuteDuration(),
        ];
    }

    /**
     * Get data resolver
     */
    private static function getDataResolver(): mixed
    {
        try {
            if (static::$directResult) {
                goto RESULT;
            }

            if (static::$asPaginate) {
                $paginate = app(PaginateResult::class);
                assert($paginate instanceof PaginateResult);

                $sortAttributes = [];

                foreach (static::$itemsRequestSort ?? [] as $attribute => $type) {
                    $sortAttributes[] = ['sortAttribute' => $attribute, 'sortType' => $type];
                }

                return $paginate->execute(
                    resultData: static::$data,
                    perPage: static::$perPage,
                    currentPage: static::$currentPage,
                    sortAttributes: $sortAttributes,
                )->toArray();
            }

            if (static::$attributesPaginator) {
                static::resolveAttributePaginateResult();
            }

            RESULT:

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
     * Get execute start timestamp
     */
    public static function getExecuteStart(): mixed
    {
        return static::$executeStart;
    }

    /**
     * Get execute finish timestamp
     */
    public static function getExecuteFinish(): mixed
    {
        return static::$executeFinish;
    }

    /**
     * Get execute duration
     */
    public static function getExecuteDuration(): mixed
    {
        static::$executeDuration = null;

        if (static::$executeStart && static::$executeFinish) {
            static::$executeDuration = CarbonInterval::seconds(static::$executeFinish - static::$executeStart)
                ->cascade()
                ->forHumans();
        }

        return static::$executeDuration;
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
     * Set execute start
     *
     * @return static
     */
    public static function setExecuteStart(): static
    {
        static::$executeStart = CarbonHelper::anyConvDateToTimestamp();

        return new static();
    }

    /**
     * Set execute finish
     *
     * @return static
     */
    public static function setExecuteFinish(): static
    {
        static::$executeFinish = CarbonHelper::anyConvDateToTimestamp();

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
     * Set result data as paginated
     *
     * @return static
     */
    public static function setAsPaginate(bool $asPaginate = true): static
    {
        static::$asPaginate = $asPaginate;

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
