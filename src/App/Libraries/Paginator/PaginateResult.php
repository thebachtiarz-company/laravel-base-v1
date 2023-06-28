<?php

declare(strict_types=1);

namespace TheBachtiarz\Base\App\Libraries\Paginator;

use TheBachtiarz\Base\App\Libraries\Paginator\Attributes\DataSort;
use TheBachtiarz\Base\App\Libraries\Paginator\Attributes\PageInfo;

use function app;
use function ceil;
use function count;
use function intval;

final class PaginateResult extends AbstractPaginator implements PaginateResultInterface
{
    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();

        $this->pageInfo = app(PageInfo::class);
        $this->dataSort = app(DataSort::class);
    }

    // ? Public Methods

    /**
     * Execute paginate process
     *
     * @param array $resultData     Data result original
     * @param int   $perPage        Result data paginated per page
     * @param int   $currentPage    Result index current page
     * @param array $sortAttributes Format: [['sortAttribute' => null, 'sortType' => null]]
     */
    public function execute(
        array $resultData = [],
        int $perPage = 15,
        int $currentPage = 1,
        array $sortAttributes = [],
    ): self {
        PROCESS_BEGIN:
        $this->resetObjectValue();
        $this->resultOriginal = $resultData;
        $this->setDataSort($sortAttributes);
        $this->setTotalCount(count($this->resultOriginal));
        $this->setPageInfo(perPage: $perPage, currentPage: $currentPage);

        /**
         * Sorting process data before paginate process
         */
        PROCESS_SORTING_DATA:
        if (count($this->getDataSort()->getSortAttribute())) {
            foreach ($this->getDataSort()->getSortAttribute() as $attribute => $type) {
                $resultData = $this->sortArrayResult($resultData, $attribute, $type);
            }
        }

        $dataResult = [];

        /**
         * Set total page
         */
        PROCESS_SET_TOTAL_PAGE:
        $this->setPageInfo(totalPage: intval(ceil(count($this->resultOriginal) / $perPage)));

        /**
         * Define current page
         */
        PROCESS_SET_CURRENT_PAGE_DATA:
        for ($loopCurrentPage = 1; $loopCurrentPage <= $this->getPageInfo()->getTotalPage(); $loopCurrentPage++) {
            /**
             * Check page section
             */
            if ($loopCurrentPage !== $currentPage) {
                continue;
            }

            /**
             * Define start - finish item index
             */
            $indexStart  = ($currentPage - 1) * $perPage;
            $indexFinish = $this->getTotalCount() < $currentPage * $perPage
                ? $this->getTotalCount()
                : $currentPage * $perPage;

            for ($indexItem = $indexStart; $indexItem < $indexFinish; $indexItem++) {
                if ($indexItem + 1 > $this->getTotalCount()) {
                    break;
                }

                if (count($dataResult) >= $perPage) {
                    break;
                }

                $dataResult[] = $resultData[$indexItem];
            }
        }

        /**
         * Check if current page result value is not correct
         */
        PROCESS_CURRENT_PAGE_REDUCER:
        if (count($dataResult) < 1 && $currentPage > 1) {
            $currentPage = $this->getPageInfo()->getTotalPage();
            $this->setPageInfo(currentPage: $currentPage);
            goto PROCESS_SET_CURRENT_PAGE_DATA;
        }

        $this->setResult($dataResult);

        return $this;
    }

    public function toArray(): array
    {
        return [
            self::ATTRIBUTE_RESULT => $this->getResult(),
            self::ATTRIBUTE_PAGEINFO => $this->getPageInfo()->toArray(),
            self::ATTRIBUTE_TOTALCOUNT => $this->getTotalCount(),
            self::ATTRIBUTE_SORTATTRIBUTES => $this->getDataSort()->toArray(),
        ];
    }

    // ? Protected Methods

    // ? Private Methods

    // ? Getter Modules

    /**
     * Get result
     */
    public function getResult(): array
    {
        return $this->resultPaginated;
    }

    /**
     * Get total count
     */
    public function getTotalCount(): int
    {
        return $this->totalCount ? $this->totalCount : count($this->resultOriginal);
    }

    // ? Setter Modules

    /**
     * Set result
     */
    public function setResult(array $resultPaginated): self
    {
        $this->resultPaginated = $resultPaginated;

        return $this;
    }

    /**
     * Set total count
     */
    public function setTotalCount(int|null $totalCount = null): self
    {
        $this->totalCount = $totalCount ?? count($this->resultOriginal);

        return $this;
    }
}
