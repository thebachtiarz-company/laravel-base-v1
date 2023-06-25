<?php

declare(strict_types=1);

namespace TheBachtiarz\Base\App\Libraries\Search\Params;

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
     * Set where conditions.
     *
     * Format: ['column', 'operator', 'condition', ?'and']
     */
    public function setWhereConditions(array $whereConditions): self;

    /**
     * Set order conditions.
     *
     * Format: ['column', 'direction']|['column']
     */
    public function setOrderConditions(array $orderConditions): self;

    /**
     * Set per page
     */
    public function setPerPage(int $perPage): self;

    /**
     * Set current page
     */
    public function setCurrentPage(int $currentPage): self;
}
