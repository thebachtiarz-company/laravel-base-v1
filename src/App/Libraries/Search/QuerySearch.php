<?php

declare(strict_types=1);

namespace TheBachtiarz\Base\App\Libraries\Search;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Database\Query\Builder as QueryBuilder;
use TheBachtiarz\Base\App\Libraries\Search\Output\SearchResultOutputInterface;
use TheBachtiarz\Base\App\Libraries\Search\Params\QuerySearchInputInterface;

use function assert;
use function collect;
use function count;
use function in_array;
use function tbgetmodelcolumns;

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
            $prepare = $querySearchInputInterface->getCustomBuilder() ?: $querySearchInputInterface->getModel()->query();
            assert($prepare instanceof EloquentBuilder || $prepare instanceof QueryBuilder);

            $modelColumns = tbgetmodelcolumns($prepare->getModel());

            if (count($querySearchInputInterface->getWhereConditions())) {
                $whereConditions = collect();

                foreach ($querySearchInputInterface->getWhereConditions() as $key => $whereCondition) {
                    if (! in_array($whereCondition[0], $modelColumns)) {
                        continue;
                    }

                    $whereCondition = $whereConditions->push($whereCondition);
                }

                if ($whereConditions->count()) {
                    $prepare = $prepare->where($whereConditions->toArray());
                }
            }

            if (count($querySearchInputInterface->getOrderConditions())) {
                foreach ($querySearchInputInterface->getOrderConditions() as $key => $orderCondition) {
                    $column    = $orderCondition[0];
                    $direction = @$orderCondition[1] ?? 'ASC';

                    if (! in_array($column, $modelColumns)) {
                        continue;
                    }

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
