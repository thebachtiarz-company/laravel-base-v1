<?php

declare(strict_types=1);

namespace TheBachtiarz\Base\App\Libraries\Paginator;

use TheBachtiarz\Base\App\Libraries\Paginator\Attributes\DataSort;
use TheBachtiarz\Base\App\Libraries\Paginator\Attributes\PageInfo;
use TheBachtiarz\Base\App\Libraries\Paginator\Params\SortAttributes;
use Throwable;

use function mb_strlen;
use function usort;

abstract class AbstractPaginator implements AbstractPaginatorInterface
{
    /**
     * Items result data original
     *
     * @var array
     */
    protected array $resultOriginal = [];

    /**
     * Items result data paginated
     *
     * @var array
     */
    protected array $resultPaginated = [];

    /**
     * Page info attributes
     */
    protected PageInfo $pageInfo;

    /**
     * Data sort attribute
     */
    protected DataSort $dataSort;

    /**
     * Total count of items actual
     */
    protected int|string $totalCount = 0;

    /**
     * Items result sorting by attribute
     *
     * @var array
     */
    protected array $sortAttribute = [];

    /**
     * Count item result per page
     */
    protected int|string $perPage = 15;

    /**
     * Index current page
     */
    protected int|string $currentPage = 1;

    /**
     * Total page result available
     */
    protected int|string $totalPage = 1;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->resetObjectValue();
    }

    /**
     * Destructor
     */
    public function __destruct()
    {
        $this->resetObjectValue();
    }

    /**
     * Get result as array
     */
    abstract public function toArray(): array;

    /**
     * Get page info
     */
    final public function getPageInfo(): PageInfo
    {
        return $this->pageInfo;
    }

    /**
     * Set page info.
     *
     * Override latest result mutator.
     *
     * @return static
     */
    final public function setPageInfo(
        int|string|null $perPage = null,
        int|string|null $totalPage = null,
        int|string|null $currentPage = null,
    ): static {
        if ($perPage) {
            $this->perPage = $perPage;
        }

        if ($totalPage) {
            $this->totalPage = $totalPage;
        }

        if ($currentPage) {
            $this->currentPage = $currentPage;
        }

        $this->pageInfo
            ->setPerPage($this->perPage)
            ->setTotalPage($this->totalPage)
            ->setCurrentPage($this->currentPage);

        return $this;
    }

    /**
     * Get data sort
     */
    final public function getDataSort(): DataSort
    {
        return $this->dataSort;
    }

    /**
     * Set data sort
     *
     * @param array $attributeSorts Format: [['sortAttribute' => null, 'sortType' => null]]
     *
     * @return static
     */
    final public function setDataSort(array $attributeSorts = []): static
    {
        foreach ($attributeSorts ?? [] as $key => $option) {
            try {
                $sortAttributes = new SortAttributes($option);

                if (! mb_strlen($sortAttributes->getSortAttribute())) {
                    continue;
                }

                $this->dataSort->addSortAttribute(
                    attribute: $sortAttributes->getSortAttribute(),
                    type: $sortAttributes->getSortType(),
                );
            } catch (Throwable) {
            }
        }

        return $this;
    }

    /**
     * Sort result
     *
     * @param array $data
     *
     * @return array
     */
    final protected function sortArrayResult(array $data, string $key = 'name', string $sortType = 'ASC'): array
    {
        usort($data, static function ($a, $b) use ($sortType, $key) {
            if ($sortType === 'ASC') {
                return $a[$key] <=> $b[$key];
            }

            if ($sortType === 'DESC') {
                return $b[$key] <=> $a[$key];
            }
        });

        return $data;
    }

    /**
     * Reset object value
     */
    protected function resetObjectValue(): void
    {
        $this->resultOriginal  = [];
        $this->resultPaginated = [];
        $this->totalCount      = 0;
        $this->sortAttribute   = [];
        $this->perPage         = 15;
        $this->currentPage     = 1;
        $this->totalPage       = 1;
    }
}
