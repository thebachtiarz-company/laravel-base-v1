<?php

declare(strict_types=1);

namespace TheBachtiarz\Base\App\Libraries\Search;

use TheBachtiarz\Base\App\Libraries\Search\Output\SearchResultOutputInterface;
use TheBachtiarz\Base\App\Libraries\Search\Params\QuerySearchInputInterface;

interface QuerySearchInterface
{
    // ? Public Methods

    /**
     * Execute query search result
     */
    public function execute(QuerySearchInputInterface $querySearchInputInterface): SearchResultOutputInterface;

    // ? Getter Modules

    // ? Setter Modules
}
