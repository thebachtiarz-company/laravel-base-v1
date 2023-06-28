<?php

declare(strict_types=1);

namespace TheBachtiarz\Base\App\Helpers;

use Carbon\CarbonInterval;
use Illuminate\Http\JsonResponse;
use TheBachtiarz\Base\App\Libraries\Paginator\PaginateResult;
use TheBachtiarz\Base\App\Libraries\Paginator\Params\PaginatorParam;
use Throwable;

use function app;
use function assert;
use function count;
use function mb_strlen;

class ResponseHelper
{
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
     * Assert result as paginated
     *
     * @param int|null   $perPage                   Default: 15
     * @param int|null   $currentPage               Default: 1
     * @param array|null $sortOptions               Format: [['sortAttribute' => null, 'sortType' => null]]
     * @param array|null $attributesPaginateOptions Format: ['attribute_name' => ['perPage' => 15, 'currentPage' => 1, 'sortOptions' => [['sortAttribute' => null, 'sortType' => null]]]]
     *
     * @return static
     */
    public static function asPaginate(
        int|null $perPage = null,
        int|null $currentPage = null,
        array|null $sortOptions = [],
        array|null $attributesPaginateOptions = [],
    ): static {
        PaginatorParam::setAsPaginate(true);

        if ($perPage) {
            PaginatorParam::setPerPage($perPage);
        }

        if ($currentPage) {
            PaginatorParam::setCurrentPage($currentPage);
        }

        if (count($sortOptions)) {
            PaginatorParam::setResultSortOptions($sortOptions);
        }

        if (count($attributesPaginateOptions)) {
            PaginatorParam::setAttributePaginateOptions($attributesPaginateOptions);
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
        foreach (PaginatorParam::getAttributesPaginateOptions() as $attribute => $options) {
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
                sortAttributes: @$options ?? [],
            );

            static::$data[$attribute] = $customAttributeValues->toArray();
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
            if (PaginatorParam::isDirectResult()) {
                goto RESULT;
            }

            if (PaginatorParam::isAsPaginate()) {
                $paginate = app(PaginateResult::class);
                assert($paginate instanceof PaginateResult);

                $sortAttributes = [];

                foreach (PaginatorParam::getResultSortOptions() ?? [] as $attribute => $type) {
                    $sortAttributes[] = ['sortAttribute' => $attribute, 'sortType' => $type];
                }

                return $paginate->execute(
                    resultData: static::$data,
                    perPage: PaginatorParam::getPerPage(),
                    currentPage: PaginatorParam::getCurrentPage(),
                    sortAttributes: $sortAttributes,
                )->toArray();
            }

            if (count(PaginatorParam::getAttributesPaginateOptions())) {
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
}
