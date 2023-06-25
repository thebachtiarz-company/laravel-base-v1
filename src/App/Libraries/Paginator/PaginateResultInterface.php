<?php

declare(strict_types=1);

namespace TheBachtiarz\Base\App\Libraries\Paginator;

interface PaginateResultInterface extends AbstractPaginatorInterface
{
    // ? Public Methods

    /**
     * Execute paginate process
     *
     * @param array $resultData     Data result original
     * @param int   $perPage        Result data paginated per page
     * @param int   $currentPage    Result index current page
     * @param array $sortAttributes Format: [['sortAttribute' => null, 'sortType' => null]]
     */
    public function execute(array $resultData = [], int $perPage = 15, int $currentPage = 1, array $sortAttributes = []): self;

    // ? Getter Modules

    /**
     * Get result
     */
    public function getResult(): array;

    /**
     * Get total count
     */
    public function getTotalCount(): int;

    // ? Setter Modules

    /**
     * Set result
     */
    public function setResult(array $resultPaginated): self;

    /**
     * Set total count
     */
    public function setTotalCount(int|null $totalCount = null): self;
}
