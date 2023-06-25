<?php

declare(strict_types=1);

namespace TheBachtiarz\Base\App\Libraries\Search\Output;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use TheBachtiarz\Base\App\Libraries\Paginator\PaginateResult;

interface SearchResultOutputInterface
{
    // ? Public Methods

    /**
     * Set result to process to paginated
     */
    public function setPaginate(LengthAwarePaginator $result, string|null $mapName = null): self;

    /**
     * Get result paginate
     */
    public function getPaginate(): PaginateResult;

    /**
     * Get result collection
     */
    public function getCollection(): Collection;

    // ? Getter Modules

    // ? Setter Modules
}
