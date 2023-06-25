<?php

declare(strict_types=1);

namespace TheBachtiarz\Base\App\Libraries\Search;

use TheBachtiarz\Base\App\Libraries\Paginator\PaginateResult;
use TheBachtiarz\Base\App\Libraries\Search\Output\SearchResultOutput;

abstract class AbstractSearch implements AbstractSearchInterface
{
    /**
     * Constructor
     */
    public function __construct(
        protected PaginateResult $paginateResult,
        protected SearchResultOutput $searchResultOutput,
    ) {
        $this->paginateResult     = $paginateResult;
        $this->searchResultOutput = $searchResultOutput;
    }

    // ? Public Methods

    // ? Protected Methods

    // ? Private Methods

    // ? Getter Modules

    // ? Setter Modules
}
