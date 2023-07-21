<?php

declare(strict_types=1);

namespace TheBachtiarz\Base\App\Models;

use Illuminate\Contracts\Database\Query\Builder as BuilderContract;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder as QueryBuilder;
use Illuminate\Support\Facades\DB;
use TheBachtiarz\Base\App\Interfaces\Models\AbstractModelInterface;

use function count;

abstract class AbstractModel extends Model implements AbstractModelInterface
{
    /**
     * Constructor
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
    }

    // ? Public Methods

    /**
     * Get data
     */
    public function getData(string $attribute): mixed
    {
        return $this->__get($attribute);
    }

    /**
     * Set data
     *
     * @return static
     */
    public function setData(string $attribute, mixed $value): static
    {
        $this->__set($attribute, $value);

        return $this;
    }

    // ? Getter Modules

    /**
     * Get id
     */
    public function getId(): int|null
    {
        return $this->__get(self::ATTRIBUTE_ID);
    }

    /**
     * Get created at
     */
    public function getCreatedAt(): mixed
    {
        return $this->__get(self::ATTRIBUTE_CREATEDAT);
    }

    /**
     * Get updated at
     */
    public function getUpdatedAt(): mixed
    {
        return $this->__get(self::ATTRIBUTE_UPDATEDAT);
    }

    // ? Setter Modules

    /**
     * Set id
     *
     * @return static
     */
    public function setId(int $id): static
    {
        $this->__set(self::ATTRIBUTE_ID, $id);

        return $this;
    }

    // ? Map Modules

    /**
     * Get entity simple map
     *
     * @param array $attributes
     *
     * @return array
     */
    public function simpleListMap(array $attributes = []): array
    {
        $this->makeHidden([
            self::ATTRIBUTE_ID,
            self::ATTRIBUTE_CREATEDAT,
            self::ATTRIBUTE_UPDATEDAT,
        ]);

        return count($attributes) ? $this->only($attributes) : $this->toArray();
    }

    // ? Scope Modules

    /**
     * Get entity by attribute
     */
    public function scopeGetByAttribute(
        EloquentBuilder|QueryBuilder $builder,
        string $column,
        mixed $value,
        string $operator = '=',
    ): BuilderContract {
        return $builder->where(
            column: DB::raw("BINARY `$column`"),
            operator: $operator,
            value: $value,
        );
    }
}
