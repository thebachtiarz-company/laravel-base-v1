<?php

declare(strict_types=1);

namespace TheBachtiarz\Base\App\Libraries\Search;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Database\Query\Builder as QueryBuilder;
use TheBachtiarz\Base\App\Libraries\Search\Output\SearchResultOutputInterface;
use TheBachtiarz\Base\App\Libraries\Search\Params\QuerySearchInputInterface;

use function assert;
use function count;

class QuerySearch extends AbstractSearch implements QuerySearchInterface
{
    // ? Public Methods

    /**
     * Execute query search result
     */
    public function execute(QuerySearchInputInterface $querySearchInputInterface): SearchResultOutputInterface
    {
        $paginateResult = $querySearchInputInterface->getCustomPaginate();
        assert($paginateResult instanceof LengthAwarePaginator || $paginateResult === null);

        if (! $paginateResult) {
            $prepare = $querySearchInputInterface->getModel()->query();
            assert($prepare instanceof EloquentBuilder || $prepare instanceof QueryBuilder);

            if (count($querySearchInputInterface->getWhereConditions())) {
                $prepare = $prepare->where($querySearchInputInterface->getWhereConditions());
            }

            if (count($querySearchInputInterface->getOrderConditions())) {
                foreach ($querySearchInputInterface->getOrderConditions() as $key => $orderCondition) {
                    $column    = $orderCondition[0];
                    $direction = @$orderCondition[1] ?? 'asc';

                    $prepare = $prepare->orderBy(column: $column, direction: $direction);
                }
            }

            PROCESS_PAGINATE:
            $paginateResult = $prepare->paginate(
                perPage: $querySearchInputInterface->getPerPage(),
                page: $querySearchInputInterface->getCurrentPage(),
            );

            if (count($paginateResult->items()) < 1 && $querySearchInputInterface->getCurrentPage() > 1) {
                $querySearchInputInterface->setCurrentPage($paginateResult->lastPage());
                goto PROCESS_PAGINATE;
            }
        }

        $this->searchResultOutput->setPaginate(
            result: $paginateResult,
            mapName: $querySearchInputInterface->getMapMethod(),
        );

        return $this->searchResultOutput;
    }

    // ? Protected Methods

    // ? Private Methods

    // ? Getter Modules

    // ? Setter Modules
}
