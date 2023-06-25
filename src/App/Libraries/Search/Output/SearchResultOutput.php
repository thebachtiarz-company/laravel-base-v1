<?php

declare(strict_types=1);

namespace TheBachtiarz\Base\App\Libraries\Search\Output;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use TheBachtiarz\Base\App\Libraries\Paginator\PaginateResult;

use function app;
use function array_map;
use function collect;

class SearchResultOutput implements SearchResultOutputInterface
{
    /**
     * Result collection
     */
    protected Collection $resultCollection;

    /**
     * Result paginate
     */
    protected PaginateResult $resultPaginate;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->resultCollection = collect();
        $this->resultPaginate   = app(PaginateResult::class);
    }

    // ? Public Methods

    /**
     * Set result to process to paginated
     */
    public function setPaginate(LengthAwarePaginator $result, string|null $mapName = null): self
    {
        $this->resultCollection = collect($result->items());

        $resultItem = $result->items();

        if ($mapName) {
            $resultItem = [
                ...array_map(
                    static fn (Model $model) => $model->{$mapName}(),
                    $this->resultCollection->all(),
                ),
            ];
        }

        $this->resultPaginate
            ->setResult($resultItem)
            ->setPageInfo(
                perPage: $result->perPage(),
                totalPage: $result->lastPage(),
                currentPage: $result->currentPage(),
            )
            ->setTotalCount($result->total());

        return $this;
    }

    /**
     * Get result paginate
     */
    public function getPaginate(): PaginateResult
    {
        return $this->resultPaginate;
    }

    /**
     * Get result collection
     */
    public function getCollection(): Collection
    {
        return $this->resultCollection;
    }

    // ? Protected Methods

    // ? Private Methods

    // ? Getter Modules

    // ? Setter Modules
}
