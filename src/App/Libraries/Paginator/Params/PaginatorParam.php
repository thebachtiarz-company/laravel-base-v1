<?php

declare(strict_types=1);

namespace TheBachtiarz\Base\App\Libraries\Paginator\Params;

use function mb_strlen;

class PaginatorParam
{
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
     * Result sorting options
     */
    protected static array $resultSortOptions = [];

    /**
     * Attributes paginate options
     */
    protected static array $attributesPaginateOptions = [];

    // ? Public Methods

    // ? Protected Methods

    // ? Private Methods

    // ? Getter Modules

    /**
     * Get is result data directed without processed
     */
    public static function isDirectResult(): bool
    {
        return static::$directResult;
    }

    /**
     * Is result data returned as paginated
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
     * Get result sorting options
     *
     * @return array
     */
    public static function getResultSortOptions(string|null $attributeName = null, bool|null $asMultiple = false): array
    {
        $result = @static::$resultSortOptions[$attributeName] ?? static::$resultSortOptions;

        if (! $attributeName && $asMultiple) {
            $reFormat = [];

            foreach ($result as $attribute => $type) {
                $reFormat[] = (new SortAttributes())->setSortAttribute($attribute)->setSortType($type)->toArray();
            }

            $result = $reFormat;
        }

        return $result;
    }

    /**
     * Get attributes paginate options
     *
     * @return array
     */
    public static function getAttributesPaginateOptions(string|null $attributeName = null): array
    {
        return @static::$attributesPaginateOptions[$attributeName] ?? static::$attributesPaginateOptions;
    }

    // ? Setter Modules

    /**
     * Set direct result status
     *
     * @param bool $status Default: false
     *
     * @return static
     */
    public static function setDirectResult(bool $status = false): static
    {
        static::$directResult = $status;

        return new static();
    }

    /**
     * Set result data returned as paginated
     *
     * @param bool $status Default: true
     *
     * @return static
     */
    public static function setAsPaginate(bool $status = true): static
    {
        static::$asPaginate = $status;

        return new static();
    }

    /**
     * Set paginate result items per page
     *
     * @return static
     */
    public static function setPerPage(int $perPage = 15): static
    {
        static::$perPage = $perPage;

        return new static();
    }

    /**
     * Set current index page
     *
     * @return static
     */
    public static function setCurrentPage(int $currentPage = 1): static
    {
        static::$currentPage = $currentPage;

        return new static();
    }

    /**
     * Add result sorting option
     *
     * @param string      $attributeName default: ''
     * @param string|null $sortType      default: 'ASC'
     *
     * @return static
     */
    public static function addResultSortOption(string $attributeName = '', string|null $sortType = 'ASC'): static
    {
        if (mb_strlen($attributeName)) {
            static::$resultSortOptions[$attributeName] = $sortType;
        }

        return new static();
    }

    /**
     * Set result sorting options
     *
     * @param array $sortOptions Format: [['sortAttribute' => null, 'sortType' => null]]
     *
     * @return static
     */
    public static function setResultSortOptions(array $sortOptions = []): static
    {
        foreach ($sortOptions ?? [] as $key => $option) {
            $sort = new SortAttributes($option);

            static::addResultSortOption(attributeName: $sort->getSortAttribute(), sortType: $sort->getSortType());
        }

        return new static();
    }

    /**
     * Set attribute paginator option
     *
     * @param string $attributeName   Attribute Name
     * @param array  $attributeOption Format: ['perPage' => 5, 'currentPage' => 1, 'sortOptions' => [['sortAttribute' => null, 'sortType' => null]]]
     *
     * @return static
     */
    public static function addAttributePaginateOption(string $attributeName, array $attributeOption): static
    {
        static::setAsPaginate(false);
        static::$attributesPaginateOptions[$attributeName] = (new PaginateAttributes($attributeOption))->toArray();

        return new static();
    }

    /**
     * Set attribute paginator options
     *
     * @param array $attributePaginateOptions Format: ['attribute_name' => ['perPage' => 5, 'currentPage' => 1, 'sortOptions' => [['sortAttribute' => null, 'sortType' => null]]]]
     *
     * @return static
     */
    public static function setAttributePaginateOptions(array $attributePaginateOptions = []): static
    {
        foreach ($attributePaginateOptions ?? [] as $attributeName => $attributeOption) {
            static::addAttributePaginateOption(attributeName: $attributeName, attributeOption: $attributeOption);
        }

        return new static();
    }
}
