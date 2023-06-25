<?php

declare(strict_types=1);

namespace TheBachtiarz\Base\App\Libraries\Paginator\Attributes;

use TheBachtiarz\Base\App\Libraries\Paginator\AbstractPaginator;

use function intval;

final class PageInfo extends AbstractPaginator
{
    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();

        $this->pageInfo = $this;
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
            self::ATTRIBUTE_PERPAGE => $this->perPage,
            self::ATTRIBUTE_CURRENTPAGE => $this->currentPage,
            self::ATTRIBUTE_TOTALPAGES => $this->totalPage,
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
     * Get total page
     */
    public function getTotalPage(): int|string
    {
        return $this->totalPage;
    }

    // ? Setter Modules

    /**
     * Set per page
     */
    public function setPerPage(int|string $perPage = 15): self
    {
        $this->perPage = intval($perPage);

        return $this;
    }

    /**
     * Set current page
     */
    public function setCurrentPage(int|string $currentPage = 1): self
    {
        $this->currentPage = intval($currentPage);

        return $this;
    }

    /**
     * Set total page
     */
    public function setTotalPage(int|string $totalPage = 1): self
    {
        $this->totalPage = intval($totalPage);

        return $this;
    }
}
