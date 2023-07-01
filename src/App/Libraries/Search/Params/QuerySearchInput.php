<?php

declare(strict_types=1);

namespace TheBachtiarz\Base\App\Libraries\Search\Params;

use Illuminate\Contracts\Database\Query\Builder as ContractsBuilder;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder as QueryBuilder;

use function assert;

class QuerySearchInput implements QuerySearchInputInterface
{
    /**
     * Model entity
     */
    protected Model $model;

    /**
     * Custom builder
     */
    protected ContractsBuilder|null $customBuilder = null;

    /**
     * Custom paginate
     */
    protected LengthAwarePaginator|null $customPaginate = null;

    /**
     * Model where conditions
     *
     * @var array
     */
    protected array $whereConditions = [];

    /**
     * Model order conditions
     *
     * @var array
     */
    protected array $orderConditions = [];

    /**
     * Map method
     */
    protected string|null $mapMethod = null;

    /**
     * Result per page
     */
    protected int $perPage = 15;

    /**
     * Current page
     */
    protected int $currentPage = 1;

    // ? Public Methods

    // ? Protected Methods

    // ? Private Methods

    // ? Getter Modules

    /**
     * Get model entity
     */
    public function getModel(): Model
    {
        return $this->model;
    }

    /**
     * Get custom builder
     */
    public function getCustomBuilder(): ContractsBuilder|null
    {
        return $this->customBuilder;
    }

    /**
     * Get custom paginate
     */
    public function getCustomPaginate(): LengthAwarePaginator|null
    {
        return $this->customPaginate;
    }

    /**
     * Get instance method
     */
    public function getMapMethod(): string|null
    {
        return $this->mapMethod;
    }

    /**
     * Get where conditions
     */
    public function getWhereConditions(): array
    {
        return $this->whereConditions;
    }

    /**
     * Get order conditions
     */
    public function getOrderConditions(): array
    {
        return $this->orderConditions;
    }

    /**
     * Get per page
     */
    public function getPerPage(): int
    {
        return $this->perPage;
    }

    /**
     * Get current page
     */
    public function getCurrentPage(): int
    {
        return $this->currentPage;
    }

    // ? Setter Modules

    /**
     * Set model entity for object paginated
     */
    public function setModel(Model $model): self
    {
        $this->model = $model;

        return $this;
    }

    /**
     * Set custom builder
     */
    public function setCustomBuilder(ContractsBuilder $builder): self
    {
        assert($builder instanceof EloquentBuilder || $builder instanceof QueryBuilder);

        $this->customBuilder = $builder;
        $this->model         = $builder->getModel();

        return $this;
    }

    /**
     * Set custom paginate.
     *
     * Will send directly into search result.
     */
    public function setCustomPaginate(LengthAwarePaginator|null $customPaginate): self
    {
        $this->customPaginate = $customPaginate;

        return $this;
    }

    /**
     * Set map method
     */
    public function setMapMethod(string $mapMethod): self
    {
        $this->mapMethod = $mapMethod;

        return $this;
    }

    /**
     * Add where conditions.
     */
    public function addWhereConditions(
        string $column,
        string $operator,
        mixed $condition,
        string|null $iterator = 'and',
    ): self {
        $this->whereConditions[] = [$column, $operator, $condition, $iterator];

        return $this;
    }

    /**
     * Add order conditions.
     */
    public function addOrderConditions(
        string $column,
        string|null $direction = 'ASC',
    ): self {
        $this->orderConditions[] = [$column, $direction];

        return $this;
    }

    /**
     * Set per page
     */
    public function setPerPage(int $perPage): self
    {
        $this->perPage = $perPage;

        return $this;
    }

    /**
     * Set current page
     */
    public function setCurrentPage(int $currentPage): self
    {
        $this->currentPage = $currentPage;

        return $this;
    }
}
