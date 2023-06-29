<?php

declare(strict_types=1);

namespace TheBachtiarz\Base\App\Libraries\Paginator\Params;

class PaginateAttributes
{
    /**
     * Attribute per page
     */
    public const ATTRIBUTE_PERPAGE = 'perPage';

    /**
     * Attribute current page
     */
    public const ATTRIBUTE_CURRENTPAGE = 'currentPage';

    /**
     * Attribute sort options
     */
    public const ATTRIBUTE_SORTOPTIONS = 'sortOptions';

    /**
     * Result page per page
     */
    protected int|string $perPage = 15;

    /**
     * Index current page
     */
    protected int|string $currentPage = 1;

    /**
     * Result sort options
     *
     * @var array
     */
    protected array $sortOptions = [];

    /**
     * Constructor
     */
    public function __construct(array $attributes = [])
    {
        $this->setPerPage(@$attributes[self::ATTRIBUTE_PERPAGE] ?? $this->perPage);
        $this->setCurrentPage(@$attributes[self::ATTRIBUTE_CURRENTPAGE] ?? $this->currentPage);
        $this->setSortOptions(@$attributes[self::ATTRIBUTE_SORTOPTIONS] ?? $this->sortOptions);
    }

    // ? Public Methods

    /**
     * Get result as array
     *
     * @return array
     */
    public function toArray(): array
    {
        return [
            self::ATTRIBUTE_PERPAGE => $this->getPerPage(),
            self::ATTRIBUTE_CURRENTPAGE => $this->getCurrentPage(),
            self::ATTRIBUTE_SORTOPTIONS => $this->getSortOptions(),
        ];
    }

    // ? Protected Methods

    // ? Private Methods

    // ? Getter Modules

    /**
     * Get per page
     */
    public function getPerPage(): int|string
    {
        return $this->perPage;
    }

    /**
     * Get current page
     */
    public function getCurrentPage(): int|string
    {
        return $this->currentPage;
    }

    /**
     * Get sort options
     */
    public function getSortOptions(): array
    {
        return $this->sortOptions;
    }

    // ? Setter Modules

    /**
     * Set per page
     */
    public function setPerPage($perPage): self
    {
        $this->perPage = $perPage;

        return $this;
    }

    /**
     * Set current page
     */
    public function setCurrentPage($currentPage): self
    {
        $this->currentPage = $currentPage;

        return $this;
    }

    /**
     * Add sort option
     */
    public function addSortOption(array $sortOption): self
    {
        $this->sortOptions[] = (new SortAttributes($sortOption))->toArray();

        return $this;
    }

    /**
     * Set sort options
     */
    public function setSortOptions(array $sortOptions): self
    {
        foreach ($sortOptions as $key => $sortOption) {
            $this->addSortOption($sortOption);
        }

        return $this;
    }
}
