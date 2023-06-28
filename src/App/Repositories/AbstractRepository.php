<?php

declare(strict_types=1);

namespace TheBachtiarz\Base\App\Repositories;

use Illuminate\Database\Eloquent\Model;
use TheBachtiarz\Base\App\Libraries\Search\Output\SearchResultOutputInterface;
use TheBachtiarz\Base\App\Libraries\Search\Params\QuerySearchInputInterface;
use TheBachtiarz\Base\App\Libraries\Search\QuerySearch;

use function app;

abstract class AbstractRepository
{
    /**
     * Model entity
     */
    protected Model $modelEntity;

    /**
     * Query Search
     */
    protected QuerySearch $querySearch;

    /**
     * Model data
     *
     * @var array
     */
    protected array $modelData = [];

    public function __construct()
    {
        $this->querySearch = app(QuerySearch::class);
    }

    /**
     * Search resources
     */
    public function search(QuerySearchInputInterface $querySearchInputInterface): SearchResultOutputInterface
    {
        $querySearchInputInterface->setModel($this->modelEntity);

        return $this->querySearch->execute($querySearchInputInterface);
    }

    /**
     * Create new record from model
     */
    protected function createFromModel(Model $model): Model
    {
        $data = $this->prepareCreate($model);

        return $model::create($data);
    }

    /**
     * Prepare data create
     *
     * @return array
     */
    protected function prepareCreate(Model $model): array
    {
        foreach ($model->getFillable() as $key => $attribute) {
            $this->modelData[$attribute] = $model->__get($attribute);
        }

        return $this->modelData;
    }
}
