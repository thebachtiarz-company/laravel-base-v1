<?php

declare(strict_types=1);

namespace TheBachtiarz\Base\App\Repositories;

use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use TheBachtiarz\Base\App\Interfaces\Models\AbstractModelInterface;
use TheBachtiarz\Base\App\Interfaces\Repositories\AbstractRepositoryInterface;
use TheBachtiarz\Base\App\Libraries\Search\Output\SearchResultOutputInterface;
use TheBachtiarz\Base\App\Libraries\Search\Params\QuerySearchInputInterface;
use TheBachtiarz\Base\App\Libraries\Search\QuerySearch;

use function app;
use function sprintf;

abstract class AbstractRepository implements AbstractRepositoryInterface
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

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->querySearch = app(QuerySearch::class);
    }

    // ? Public Methods

    /**
     * Get entity by id
     */
    public function getById(int $id): Model|AbstractModelInterface
    {
        $entity = $this->modelEntity::find($id);

        if (! $entity) {
            throw new ModelNotFoundException(sprintf(
                $this->getByIdErrorMessage() ?? "Entity with id '%s' not found!",
                $id,
            ));
        }

        return $entity;
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
     * Create or update entity
     */
    public function createOrUpdate(Model|AbstractModelInterface $model): Model|AbstractModelInterface
    {
        if ($model->getId()) {
            $save = $model->save();

            if (! $save) {
                throw new Exception(sprintf(
                    $this->createOrUpdateErrorMessage() ?? 'Failed to %s entity',
                    'save',
                ));
            }
        } else {
            $model = $this->createFromModel($model);

            if (! $model) {
                throw new Exception(sprintf(
                    $this->createOrUpdateErrorMessage() ?? 'Failed to %s entity',
                    'create new',
                ));
            }
        }

        return $model;
    }

    /**
     * Delete by id
     */
    public function deleteById(int $id): bool
    {
        $entity = $this->getById($id);

        return $entity->delete();
    }

    // ? Protected Methods

    /**
     * Create new record from model
     */
    protected function createFromModel(Model|AbstractModelInterface $model): Model|AbstractModelInterface
    {
        $data = $this->prepareCreate($model);

        return $model::create($data);
    }

    /**
     * Prepare data create
     *
     * @return array
     */
    protected function prepareCreate(Model|AbstractModelInterface $model): array
    {
        foreach ($model->getFillable() as $key => $attribute) {
            $this->modelData[$attribute] = $model->__get($attribute);
        }

        return $this->modelData;
    }

    /**
     * Add get by id error message
     */
    abstract protected function getByIdErrorMessage(): string|null;

    /**
     * Add create or update error message
     */
    abstract protected function createOrUpdateErrorMessage(): string|null;
}
