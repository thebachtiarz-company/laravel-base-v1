<?php

declare(strict_types=1);

namespace TheBachtiarz\Base\App\Repositories;

use Illuminate\Database\Eloquent\Model;

abstract class AbstractRepository
{
    /**
     * Model data
     *
     * @var array
     */
    protected array $modelData = [];

    /**
     * Create new record from model
     */
    protected function createFromModel(Model $model): Model
    {
        $_data = $this->prepareCreate($model);

        return $model::create($_data);
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
