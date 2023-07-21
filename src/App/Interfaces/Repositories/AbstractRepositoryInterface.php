<?php

declare(strict_types=1);

namespace TheBachtiarz\Base\App\Interfaces\Repositories;

use Illuminate\Database\Eloquent\Model;
use TheBachtiarz\Base\App\Interfaces\Models\AbstractModelInterface;
use TheBachtiarz\Base\App\Libraries\Search\Output\SearchResultOutputInterface;
use TheBachtiarz\Base\App\Libraries\Search\Params\QuerySearchInputInterface;

interface AbstractRepositoryInterface
{
    // ? Public Methods

    /**
     * Get entity by id
     */
    public function getById(int $id): Model|AbstractModelInterface;

    /**
     * Search resources
     */
    public function search(QuerySearchInputInterface $querySearchInputInterface): SearchResultOutputInterface;

    /**
     * Create or update entity
     */
    public function createOrUpdate(Model|AbstractModelInterface $model): Model|AbstractModelInterface;

    /**
     * Delete by id
     */
    public function deleteById(int $id): bool;

    // ? Getter Modules

    // ? Setter Modules
}
