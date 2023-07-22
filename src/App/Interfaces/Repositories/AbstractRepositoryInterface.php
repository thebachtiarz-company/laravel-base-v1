<?php

declare(strict_types=1);

namespace TheBachtiarz\Base\App\Interfaces\Repositories;

use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder as QueryBuilder;
use TheBachtiarz\Base\App\Interfaces\Models\AbstractModelInterface;
use TheBachtiarz\Base\App\Libraries\Search\Output\SearchResultOutputInterface;
use TheBachtiarz\Base\App\Libraries\Search\Params\QuerySearchInputInterface;

interface AbstractRepositoryInterface
{
    // ? Public Methods

    /**
     * Get entity by id
     */
    public function getById(int $id): Model|AbstractModelInterface|null;

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
    public function deleteById(int $id): bool|null;

    /**
     * Model builder
     */
    public function modelBuilder(
        EloquentBuilder|QueryBuilder|null $modelBuilder = null,
    ): static|EloquentBuilder|QueryBuilder|null;

    // ? Getter Modules

    // ? Setter Modules
}
