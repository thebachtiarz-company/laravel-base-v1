<?php

declare(strict_types=1);

namespace TheBachtiarz\Base\App\Libraries\Search\Params;

use Illuminate\Contracts\Database\Query\Builder as ContractsBuilder;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Model;

interface QuerySearchInputInterface
{
    // ? Public Methods

    // ? Getter Modules

    /**
     * Get model entity
     */
    public function getModel(): Model;

    /**
     * Get custom builder
     */
    public function getCustomBuilder(): ContractsBuilder|null;

    /**
     * Get custom paginate
     */
    public function getCustomPaginate(): LengthAwarePaginator|null;

    /**
     * Get map method
     */
    public function getMapMethod(): string|null;

    /**
     * Get where conditions
     */
    public function getWhereConditions(): array;

    /**
     * Get order conditions
     */
    public function getOrderConditions(): array;

    /**
     * Get per page
     */
    public function getPerPage(): int;

    /**
     * Get current page
     */
    public function getCurrentPage(): int;

    // ? Setter Modules

    /**
     * Set model entity for object paginated
     */
    public function setModel(Model $model): self;

    /**
     * Set custom builder
     */
    public function setCustomBuilder(ContractsBuilder $builder): self;

    /**
     * Set custom paginate.
     *
     * Will send directly into search result.
     */
    public function setCustomPaginate(LengthAwarePaginator|null $customPaginate): self;

    /**
     * Set map method
     */
    public function setMapMethod(string $mapMethod): self;

    /**
     * Add where conditions.
     */
    public function addWhereConditions(string $column, string $operator, mixed $condition, string|null $iterator = 'and'): self;

    /**
     * Add order conditions.
     */
    public function addOrderConditions(string $column, string|null $direction = 'ASC'): self;

    /**
     * Set per page
     */
    public function setPerPage(int $perPage): self;

    /**
     * Set current page
     */
    public function setCurrentPage(int $currentPage): self;
}
